<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AsChatConversation extends Model
{
    protected $table = 'as_chat_conversations';

    /**
     * Match Asia/Manila timezone used by DS AXIS BaseModel.
     */
    public function freshTimestamp()
    {
        return Carbon::now('Asia/Manila');
    }

    protected $fillable = [
        'visitorName',
        'visitorEmail',
        'farmLocation',
        'visitorType',
        'leadId',
        'sessionId',
        'assignedTo',
        'status',
        'deleteStatus',
    ];

    public function scopeActive($query)
    {
        return $query->where('deleteStatus', 'active');
    }

    public function messages()
    {
        return $this->hasMany(AsChatMessage::class, 'conversationId')->where('deleteStatus', 'active');
    }
}
