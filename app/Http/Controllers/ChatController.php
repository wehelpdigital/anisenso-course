<?php

namespace App\Http\Controllers;

use App\Models\AsChatConversation;
use App\Models\AsChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Get the chat support form fields for dynamic rendering.
     */
    public function getFormFields()
    {
        $form = DB::table('crm_forms')
            ->where('formSlug', 'support-chat-form')
            ->where('delete_status', 'active')
            ->where('formStatus', 'active')
            ->first();

        if (!$form) {
            return response()->json(['success' => false, 'message' => 'Form not found.'], 404);
        }

        $elements = json_decode($form->formElements, true) ?? [];

        // Filter out non-input elements
        $skipTypes = ['heading', 'paragraph', 'divider', 'submit_button', 'image', 'video'];
        $fields = [];
        foreach ($elements as $el) {
            if (!isset($el['id']) || in_array($el['type'], $skipTypes)) continue;
            $fields[] = $el;
        }

        return response()->json(['success' => true, 'fields' => $fields]);
    }

    /**
     * Start a new conversation or resume existing one.
     */
    public function startConversation(Request $request)
    {
        $sessionId = $request->input('session_id');

        // If there's an existing active conversation with this session, resume it
        if ($sessionId) {
            $existing = AsChatConversation::active()
                ->where('sessionId', $sessionId)
                ->where('status', 'active')
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => true,
                    'conversation' => [
                        'id' => $existing->id,
                        'sessionId' => $existing->sessionId,
                    ],
                ]);
            }
        }

        // Get the CRM form
        $form = DB::table('crm_forms')
            ->where('formSlug', 'support-chat-form')
            ->where('delete_status', 'active')
            ->first();

        if (!$form) {
            return response()->json(['success' => false, 'message' => 'Form not configured.'], 500);
        }

        $formElements = json_decode($form->formElements, true) ?? [];
        $skipTypes = ['heading', 'paragraph', 'divider', 'submit_button', 'image', 'video'];

        // Validate using form element rules
        $rules = [];
        $messages = [];
        foreach ($formElements as $el) {
            if (!isset($el['id']) || in_array($el['type'], $skipTypes)) continue;
            $fieldRules = [];
            if (!empty($el['required'])) {
                $fieldRules[] = 'required';
                $messages[$el['id'] . '.required'] = ($el['label'] ?? 'This field') . ' is required.';
            } else {
                $fieldRules[] = 'nullable';
            }
            if ($el['type'] === 'email') {
                $fieldRules[] = 'email';
                $messages[$el['id'] . '.email'] = 'Please enter a valid email address.';
            }
            $rules[$el['id']] = $fieldRules;
        }

        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Submit to CRM form (create submission + execute triggers)
        $submissionData = [];
        $visitorName = null;
        $visitorEmail = null;
        $farmLocation = null;
        $visitorType = null;
        $initialMessage = null;

        foreach ($formElements as $el) {
            if (!isset($el['id']) || in_array($el['type'], $skipTypes)) continue;
            $value = $request->input($el['id']);
            $submissionData[$el['id']] = $value;

            // Extract known fields by label for conversation
            $label = strtolower($el['label'] ?? '');
            if (stripos($label, 'pangalan') !== false || stripos($label, 'name') !== false) $visitorName = $value;
            if ($el['type'] === 'email') $visitorEmail = $value;
            if (stripos($label, 'lokasyon') !== false || stripos($label, 'farm') !== false) $farmLocation = $value;
            if (stripos($label, 'ikaw') !== false) $visitorType = $value;
            if ($el['type'] === 'textarea') $initialMessage = $value;
        }

        // Create CRM form submission
        $submissionId = DB::table('crm_form_submissions')->insertGetId([
            'formId' => $form->id,
            'submissionData' => json_encode($submissionData),
            'submitterIp' => $request->ip(),
            'submitterUserAgent' => $request->userAgent(),
            'submitterEmail' => $visitorEmail,
            'submitterName' => $visitorName,
            'submissionStatus' => 'new',
            'delete_status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Increment form submission count
        DB::table('crm_forms')->where('id', $form->id)->increment('submitCount');

        // Execute trigger flow (create lead etc.)
        $this->executeTriggerFlow($form, $submissionId, $submissionData);

        // Create new conversation
        $conversation = AsChatConversation::create([
            'visitorName' => $visitorName ?? 'Visitor',
            'visitorEmail' => $visitorEmail,
            'farmLocation' => $farmLocation,
            'sessionId' => Str::uuid()->toString(),
            'status' => 'active',
            'deleteStatus' => 'active',
        ]);

        // Send the initial message
        $message = AsChatMessage::create([
            'conversationId' => $conversation->id,
            'senderType' => 'visitor',
            'senderId' => null,
            'message' => $initialMessage ?? $visitorName . ' started a conversation.',
            'isRead' => false,
            'deleteStatus' => 'active',
        ]);

        // Check for auto-reply
        $settings = DB::table('as_chat_settings')
            ->whereIn('settingKey', ['auto_reply_enabled', 'auto_reply_message', 'last_admin_heartbeat'])
            ->pluck('settingValue', 'settingKey');

        if (($settings['auto_reply_enabled'] ?? '0') === '1') {
            $lastHeartbeat = $settings['last_admin_heartbeat'] ?? null;
            $adminIsOnline = $lastHeartbeat && \Carbon\Carbon::parse($lastHeartbeat, 'Asia/Manila')->diffInSeconds(now('Asia/Manila')) < 30;

            if (!$adminIsOnline && !empty($settings['auto_reply_message'])) {
                AsChatMessage::create([
                    'conversationId' => $conversation->id,
                    'senderType' => 'system',
                    'senderId' => null,
                    'message' => $settings['auto_reply_message'],
                    'isRead' => false,
                    'deleteStatus' => 'active',
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'conversation' => [
                'id' => $conversation->id,
                'sessionId' => $conversation->sessionId,
            ],
            'message' => [
                'id' => $message->id,
                'senderType' => $message->senderType,
                'message' => $message->message,
                'createdAt' => $message->created_at->format('M d, h:i A'),
            ],
        ]);
    }

    /**
     * Execute the CRM form's trigger flow.
     */
    private function executeTriggerFlow($form, $submissionId, $submissionData)
    {
        $triggerFlow = json_decode($form->triggerFlow, true) ?? [];
        if (empty($triggerFlow)) return;

        foreach ($triggerFlow as $step) {
            try {
                $type = $step['type'] ?? null;
                $config = $step['config'] ?? [];

                if ($type === 'create_lead') {
                    $this->createLeadFromTrigger($config, $form, $submissionData);
                }
            } catch (\Exception $e) {
                report($e);
            }
        }
    }

    /**
     * Create a CRM lead from trigger flow config.
     */
    private function createLeadFromTrigger($config, $form, $submissionData)
    {
        $fieldMappings = $config['fieldMappings'] ?? [];
        $formUsersId = $form->usersId;

        $sourceName = $config['source'] ?? 'form';

        $leadData = [
            'usersId' => $formUsersId,
            'leadStatus' => $config['status'] ?? 'new',
            'leadSourceOther' => $sourceName,
            'delete_status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Match source name to lead sources table
        $sourceId = DB::table('crm_lead_sources')
            ->where('sourceName', $sourceName)
            ->where('delete_status', 'active')
            ->value('id');
        if ($sourceId) {
            $leadData['leadSourceId'] = $sourceId;
        }

        $customFields = [];

        foreach ($fieldMappings as $mapping) {
            $formField = $mapping['formField'] ?? '';
            $leadField = $mapping['leadField'] ?? '';
            if (empty($formField) || empty($leadField)) continue;

            $value = $submissionData[$formField] ?? null;
            if ($value === null) continue;
            if (is_array($value)) $value = implode(', ', $value);

            if (str_starts_with($leadField, 'custom:')) {
                $customFields[substr($leadField, 7)] = $value;
            } elseif ($leadField === 'storeTargets') {
                $leadData['_storeTargets'] = $value;
            } else {
                $leadData[$leadField] = $value;
            }
        }

        // Handle fullName split
        if (isset($leadData['fullName'])) {
            $parts = explode(' ', $leadData['fullName'], 2);
            $leadData['firstName'] = $parts[0];
            $leadData['lastName'] = $parts[1] ?? '';
            unset($leadData['fullName']);
        }

        // Check for duplicate by email
        $existingLead = null;
        if (!empty($leadData['email'])) {
            $existingLead = DB::table('crm_leads')
                ->where('delete_status', 'active')
                ->where('usersId', $formUsersId)
                ->where('email', $leadData['email'])
                ->first();
        }

        // Extract store targets before inserting lead
        $storeTargets = $leadData['_storeTargets'] ?? null;
        unset($leadData['_storeTargets']);

        if ($existingLead) {
            $leadId = $existingLead->id;
            $updateData = array_filter($leadData, fn($v, $k) => !empty($v) && !in_array($k, ['usersId', 'delete_status', 'created_at']), ARRAY_FILTER_USE_BOTH);
            DB::table('crm_leads')->where('id', $leadId)->update($updateData);
        } else {
            $leadId = DB::table('crm_leads')->insertGetId($leadData);
        }

        // Handle store targets
        if (!empty($storeTargets)) {
            $storeIds = is_array($storeTargets) ? $storeTargets : array_map('trim', explode(',', $storeTargets));
            foreach ($storeIds as $storeId) {
                if (!$storeId) continue;
                $exists = DB::table('crm_lead_store_targets')
                    ->where('leadId', $leadId)
                    ->where('storeId', $storeId)
                    ->exists();
                if (!$exists) {
                    DB::table('crm_lead_store_targets')->insert([
                        'leadId' => $leadId,
                        'storeId' => $storeId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Handle custom fields
        $now = now();
        foreach ($customFields as $fieldName => $fieldValue) {
            $existing = DB::table('crm_lead_custom_data')
                ->where('leadId', $leadId)
                ->where('fieldName', $fieldName)
                ->where('delete_status', 'active')
                ->first();

            if ($existing) {
                DB::table('crm_lead_custom_data')->where('id', $existing->id)->update(['fieldValue' => $fieldValue, 'updated_at' => $now]);
            } else {
                DB::table('crm_lead_custom_data')->insert([
                    'leadId' => $leadId, 'fieldName' => $fieldName, 'fieldValue' => $fieldValue,
                    'usersId' => $formUsersId, 'delete_status' => 'active', 'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }
    }

    /**
     * Send a message from visitor.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|integer',
            'message' => 'required|string|max:5000',
        ]);

        $conversation = AsChatConversation::active()
            ->where('id', $request->conversation_id)
            ->where('status', 'active')
            ->first();

        if (!$conversation) {
            return response()->json([
                'success' => false,
                'message' => 'Conversation not found or has been closed.',
            ], 404);
        }

        $message = AsChatMessage::create([
            'conversationId' => $conversation->id,
            'senderType' => 'visitor',
            'senderId' => null,
            'message' => $request->message,
            'isRead' => false,
            'deleteStatus' => 'active',
        ]);

        $conversation->touch();

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'senderType' => $message->senderType,
                'message' => $message->message,
                'createdAt' => $message->created_at->format('M d, h:i A'),
            ],
        ]);
    }

    /**
     * Get messages for a conversation (visitor polling).
     */
    public function getMessages(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|integer',
        ]);

        $conversation = AsChatConversation::active()
            ->where('id', $request->conversation_id)
            ->first();

        if (!$conversation) {
            return response()->json([
                'success' => false,
                'message' => 'Conversation not found.',
            ], 404);
        }

        // Mark admin messages as read
        AsChatMessage::where('conversationId', $conversation->id)
            ->where('senderType', 'admin')
            ->where('isRead', false)
            ->update(['isRead' => true]);

        $messages = $conversation->messages()
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'senderType' => $msg->senderType,
                    'message' => $msg->message,
                    'createdAt' => $msg->created_at->format('M d, h:i A'),
                ];
            });

        return response()->json([
            'success' => true,
            'status' => $conversation->status,
            'messages' => $messages,
        ]);
    }
}
