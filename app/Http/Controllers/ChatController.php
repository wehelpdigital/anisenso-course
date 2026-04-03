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
     * Start a new conversation or resume existing one.
     */
    public function startConversation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'farm_location' => 'required|string|max:255',
            'visitor_type' => 'required|in:farm_owner,farm_worker,other',
            'message' => 'required|string|max:5000',
        ]);

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

        // Create CRM lead in Axis
        $leadId = $this->createCrmLead($request);

        // Create new conversation
        $conversation = AsChatConversation::create([
            'visitorName' => $request->name,
            'visitorEmail' => $request->email,
            'farmLocation' => $request->farm_location,
            'visitorType' => $request->visitor_type,
            'leadId' => $leadId,
            'sessionId' => Str::uuid()->toString(),
            'status' => 'active',
            'deleteStatus' => 'active',
        ]);

        // Send the initial message atomically with conversation creation
        $message = AsChatMessage::create([
            'conversationId' => $conversation->id,
            'senderType' => 'visitor',
            'senderId' => null,
            'message' => $request->message,
            'isRead' => false,
            'deleteStatus' => 'active',
        ]);

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
     * Create a CRM lead from chat visitor info.
     */
    private function createCrmLead(Request $request): ?int
    {
        try {
            // Find the "Support Chat" lead source
            $sourceId = DB::table('crm_lead_sources')
                ->where('sourceName', 'Support Chat')
                ->where('delete_status', 'active')
                ->value('id');

            $visitorTypeLabels = [
                'farm_owner' => 'Farm Owner',
                'farm_worker' => 'Farm Worker',
                'other' => 'Other',
            ];

            // Split name into first/last if possible
            $nameParts = explode(' ', trim($request->name), 2);
            $firstName = $nameParts[0];
            $lastName = $nameParts[1] ?? '';

            $leadId = DB::table('crm_leads')->insertGetId([
                'usersId' => 1, // System/admin owner
                'leadStatus' => 'new',
                'leadPriority' => 'medium',
                'leadSourceId' => $sourceId,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $request->email,
                'delete_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Store chat-specific data as custom fields
            $now = now();
            $customFields = [
                ['leadId' => $leadId, 'fieldName' => 'Farm Location', 'fieldValue' => $request->farm_location, 'usersId' => 1, 'delete_status' => 'active', 'created_at' => $now, 'updated_at' => $now],
                ['leadId' => $leadId, 'fieldName' => 'Visitor Type', 'fieldValue' => $visitorTypeLabels[$request->visitor_type] ?? $request->visitor_type, 'usersId' => 1, 'delete_status' => 'active', 'created_at' => $now, 'updated_at' => $now],
            ];
            DB::table('crm_lead_custom_data')->insert($customFields);

            return $leadId;
        } catch (\Exception $e) {
            // Don't fail the chat if lead creation fails
            report($e);
            return null;
        }
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
