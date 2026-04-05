<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommunityController extends Controller
{
    /**
     * Get the CRM form (id=4) for join-community.
     */
    private function getCrmForm()
    {
        return DB::table('crm_forms')
            ->where('id', 4)
            ->where('delete_status', 'active')
            ->where('formStatus', 'active')
            ->first();
    }

    /**
     * Show the join-community page with dynamic form fields.
     */
    public function show()
    {
        $form = $this->getCrmForm();

        $formFields = [];
        $pageContent = [];
        $formSettings = [];

        if ($form) {
            $formFields = json_decode($form->formElements, true) ?? [];
            $pageContent = json_decode($form->pageContent, true) ?? [];
            $formSettings = json_decode($form->formSettings, true) ?? [];

            // Increment view count
            DB::table('crm_forms')->where('id', $form->id)->increment('viewCount');
        }

        return view('community.join', compact('formFields', 'pageContent', 'formSettings'));
    }

    /**
     * Get form fields via AJAX (for Alpine.js initialization).
     */
    public function getFormFields()
    {
        $form = $this->getCrmForm();

        if (!$form) {
            return response()->json(['success' => false, 'message' => 'Form not found.'], 404);
        }

        $elements = json_decode($form->formElements, true) ?? [];

        return response()->json(['success' => true, 'fields' => $elements]);
    }

    /**
     * Handle form submission.
     */
    public function submit(Request $request)
    {
        $form = $this->getCrmForm();

        if (!$form) {
            return response()->json(['success' => false, 'message' => 'Form not configured.'], 500);
        }

        $formElements = json_decode($form->formElements, true) ?? [];
        $skipTypes = ['heading', 'paragraph', 'divider', 'submit_button', 'image', 'video'];

        // Build validation rules
        $rules = [];
        $messages = [];
        foreach ($formElements as $el) {
            if (!isset($el['id']) || in_array($el['type'], $skipTypes)) continue;

            $fieldRules = [];
            if (!empty($el['required'])) {
                if ($el['type'] === 'checkbox') {
                    $fieldRules[] = 'required';
                    $fieldRules[] = 'array';
                    $fieldRules[] = 'min:1';
                    $messages[$el['id'] . '.required'] = ($el['label'] ?? 'This field') . ' is required.';
                    $messages[$el['id'] . '.min'] = ($el['label'] ?? 'This field') . ' is required.';
                } else {
                    $fieldRules[] = 'required';
                    $messages[$el['id'] . '.required'] = ($el['label'] ?? 'This field') . ' is required.';
                }
            } else {
                $fieldRules[] = 'nullable';
            }

            if ($el['type'] === 'email') {
                $fieldRules[] = 'email';
                $messages[$el['id'] . '.email'] = 'Please enter a valid email address.';
            }
            if ($el['type'] === 'phone') {
                $fieldRules[] = 'regex:/^(09\d{9}|63\d{10})$/';
                $messages[$el['id'] . '.regex'] = 'Format: 09XXXXXXXXX o 63XXXXXXXXXX';
            }
            if ($el['type'] === 'number') {
                $fieldRules[] = 'numeric';
            }

            $rules[$el['id']] = $fieldRules;
        }

        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Collect submission data
        $submissionData = [];
        $visitorName = null;
        $visitorEmail = null;

        foreach ($formElements as $el) {
            if (!isset($el['id']) || in_array($el['type'], $skipTypes)) continue;
            $value = $request->input($el['id']);
            $submissionData[$el['id']] = $value;

            $label = strtolower($el['label'] ?? '');
            if (stripos($label, 'pangalan') !== false || stripos($label, 'name') !== false) $visitorName = $value;
            if ($el['type'] === 'email') $visitorEmail = $value;
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

        // Execute trigger flow
        $this->executeTriggerFlow($form, $submissionId, $submissionData);

        // Get success message from form settings
        $settings = json_decode($form->formSettings, true) ?? [];
        $successMessage = $settings['successMessage'] ?? 'Salamat sa pag-join! Makakatanggap ka ng email confirmation.';

        return response()->json([
            'success' => true,
            'message' => $successMessage,
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

        if (isset($leadData['fullName'])) {
            $parts = explode(' ', $leadData['fullName'], 2);
            $leadData['firstName'] = $parts[0];
            $leadData['lastName'] = $parts[1] ?? '';
            unset($leadData['fullName']);
        }

        $existingLead = null;
        if (!empty($leadData['email'])) {
            $existingLead = DB::table('crm_leads')
                ->where('delete_status', 'active')
                ->where('usersId', $formUsersId)
                ->where('email', $leadData['email'])
                ->first();
        }

        $storeTargets = $leadData['_storeTargets'] ?? null;
        unset($leadData['_storeTargets']);

        if ($existingLead) {
            $leadId = $existingLead->id;
            $updateData = array_filter($leadData, fn($v, $k) => !empty($v) && !in_array($k, ['usersId', 'delete_status', 'created_at']), ARRAY_FILTER_USE_BOTH);
            DB::table('crm_leads')->where('id', $leadId)->update($updateData);
        } else {
            $leadId = DB::table('crm_leads')->insertGetId($leadData);
        }

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
}
