<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    /**
     * Get the category associated with the Inventory.
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * Get the inventory type associated with the Inventory .
     */
    public function inventoryType()
    {
        return $this->hasOne(InventoryType::class, 'id', 'inventory_type_id')->select(['id', 'name as typeName']);
    }

    /**
     * Get the country associated with the Inventory .
     */
    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    /**
     * Get the state associated with the Inventory .
     */
    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    /**
     * Get the inventory notes associated with the Inventory.
     */
    public function inventoryNotes()
    {
        return $this->hasMany(InventoryNote::class, 'inventory_id', 'id');
    }

    /**
     * Get the inventory files associated with the Inventory.
     */
    public function inventoryFiles()
    {
        return $this->hasMany(InventoryFile::class, 'inventory_id', 'id');
    }

    /**
     * Get the loan associated with the Inventory.
     */
    public function loan() {
        return $this->hasOne(Loan::class, 'inventory_id', 'id');
    }

    /**
     * Get the investor associated with the Inventory.
     */
    public function investor() {
        return $this->belongsTo(User::class, 'investor_id', 'id');
    }

    /**
     * Get the insurance associated with the Inventory.
     */
    public function insurance() {
        return $this->hasOne(Insurance::class, 'inventory_id', 'id');
    }
}
