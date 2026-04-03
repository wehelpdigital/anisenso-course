<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AsChatMessage extends Model
{
    protected $table = 'as_chat_messages';

    /**
     * Match Asia/Manila timezone used by DS AXIS BaseModel.
     */
    public function freshTimestamp()
    {
        return Carbon::now('Asia/Manila');
    }

    protected $fillable = [
        'conversationId',
        'senderType',
        'senderId',
        'message',
        'isRead',
        'deleteStatus',
    ];

    protected $casts = [
        'isRead' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('deleteStatus', 'active');
    }

    public function conversation()
    {
        return $this->belongsTo(AsChatConversation::class, 'conversationId');
    }
}
