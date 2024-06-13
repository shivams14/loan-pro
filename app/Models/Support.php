<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Support extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    /**
     * Get the client associated with the Support.
     */
    public function client() {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    /**
     * Get the loan associated with the Support.
     */
    public function loan() {
        return $this->belongsTo(Loan::class, 'loan_id', 'id');
    }

    /**
     * Get the chats associated with the Support.
     */
    public function chat() {
        return $this->hasMany(Chat::class, 'support_id', 'id');
    }

    /**
     * Get the user associated with the Support.
     */
    public function user() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
