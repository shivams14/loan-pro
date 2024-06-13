<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryType;


class InventoryTypeController extends Controller
{
    protected $data = [];

    public function __construct() {
        $this->data['title'] = 'Inventory type';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = InventoryType::withoutTrashed()->latest()->get();

        $this->data['records'] = $records;
        return view('admin.inventory_type.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.inventory_type.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'name' => 'required|unique:inventory_types,name,NULL,id,deleted_at,NULL|max:25'
        ],
        [
            'name.required' => 'Please enter the inventory type!',
            'name.unique'   => 'The inventory type already exists!',
            'name.max'      => 'Please don\'t enter the inventory type more than :max characters!'
        ]);

        InventoryType::create(['name' => $request->input('name')]);

        return redirect()->route('inventory-type.index')->with('success', 'Inventory type created successfully!');  
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $records = InventoryType::find($id);
        $this->data['record'] = $records;
        return view('admin.inventory_type.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,
        [
            'name' => 'required|unique:inventory_types,name,'.$id.',id,deleted_at,NULL|max:25'
        ],
        [
            'name.required' => 'Please enter the inventory type!',
            'name.unique'   => 'The inventory type already exists!',
            'name.max'      => 'Please don\'t enter the inventory type more than :max characters!'
        ]);

        $season = InventoryType::find($id);
        $season->name = $request->input('name');
        $season->save();

        return redirect()->route('inventory-type.index')->with('success', 'Inventory type updated successfully!');  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventoryType = InventoryType::find($id);
        $inventoryType->delete();
        /* Deleting inventory related to inventory type */
        $inventoryType->inventories()->each(function ($item) {
            $item->inventoryNotes()->delete();
            $item->inventoryFiles()->delete();
            $item->loan()->each(function ($item2) {
                $item2->loanEntry()->delete();
                $item2->escrow()->delete();
                $item2->supports()->delete();
            });
            $item->loan()->delete();
        });
        $inventoryType->inventories()->delete();

        return redirect()->route('inventory-type.index')->with('success', 'Inventory type deleted successfully!');
    }
}
