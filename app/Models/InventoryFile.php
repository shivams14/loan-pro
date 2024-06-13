<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryFile extends Model
{
    use HasFactory;
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    /**
     * Get the user associated with the Inventory file.
     */
    public function user()
    {
        return $this->belongsTo(user::class, 'user_id', 'id');
    }

    /**
     * Get the inventory associated with the Inventory file.
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }
}
