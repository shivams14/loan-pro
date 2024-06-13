<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $data = [];

    public function __construct() {
        $this->data['title'] = 'Category';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Category::withoutTrashed()->latest()->get();

        $this->data['records'] = $records;
        return view('admin.category.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,NULL,id,deleted_at,NULL|max:25'
        ], [
            'name.required' => 'Please enter the category!',
            'name.unique'   => 'The category already exists!',
            'name.max'      => 'Please don\'t enter the category more than :max characters!'
        ]);

        Category::create(['name' => $request->input('name')]);

        return redirect()->route('category.index')->with('success', 'Category created successfully!');
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
        $records = Category::find($id);

        $this->data['record'] = $records;
        return view('admin.category.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,
        [
            'name' => 'required|unique:categories,name,'.$id.',id,deleted_at,NULL|max:25'
        ],
        [
            'name.required' => 'Please enter the category!',
            'name.unique'   => 'The category already exists!',
            'name.max'      => 'Please don\'t enter the category more than :max characters!'
        ]);

        $season = Category::find($id);
        $season->name = $request->input('name');
        $season->save();

        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();
        /* Deleting the inventories related to the category */
        $category->inventories()->each(function ($item) {
            $item->inventoryNotes()->delete();
            $item->inventoryFiles()->delete();
            $item->loan()->each(function ($item2) {
                $item2->loanEntry()->delete();
                $item2->escrow()->delete();
                $item2->supports()->delete();
            });
            $item->loan()->delete();
        });
        $category->inventories()->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }
}
