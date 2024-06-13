<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    /**
     * Get the support associated with the Chat.
     */
    public function support() {
        return $this->belongsTo(Support::class, 'support_id', 'id');
    }

    /**
     * Get the userFrom details associated with the Chat.
     */
    public function userFrom() {
        return $this->belongsTo(User::class, 'message_from', 'id');
    }

    /**
     * Get the userTo details associated with the Chat.
     */
    public function userTo() {
        return $this->belongsTo(User::class, 'message_to', 'id');
    }
}
