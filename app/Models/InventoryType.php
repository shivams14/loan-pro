<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryType extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    /**
     * Get the inventories associated with the Inventory type.
     */
    public function inventories() {
        return $this->hasMany(Inventory::class, 'inventory_type_id', 'id');
    }
}
