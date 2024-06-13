<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use Illuminate\Http\Request;
use App\Models\ClientType;


class ClientTypeController extends Controller
{
    protected $data = [];

    public function __construct() {
        $this->data['title'] = 'Client type';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = ClientType::withoutTrashed()->latest()->get();
        $this->data['records'] = $records;
        return view('admin.client_type.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.client_type.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'name' => 'required|unique:client_types,name,NULL,id,deleted_at,NULL|max:25'
        ],
        [
            'name.required' => 'Please enter the client type!',
            'name.unique'   => 'The client type already exists!',
            'name.max'      => 'Please don\'t enter the client type more than :max characters!'
        ]);

        ClientType::create(['name' => $request->input('name')]);

        return redirect()->route('client-type.index')->with('success', 'Client type created successfully!');
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
        $records = ClientType::find($id);
        $this->data['record'] = $records;
        return view('admin.client_type.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,
        [
            'name' => 'required|unique:client_types,name,'.$id.',id,deleted_at,NULL|max:25'
        ],
        [
            'name.required' => 'Please enter the client type!',
            'name.unique'   => 'The client type already exists!',
            'name.max'      => 'Please don\'t enter the client type more than :max characters!'
        ]);

        $season = ClientType::find($id);
        $season->name = $request->input('name');
        $season->save();

        return redirect()->route('client-type.index')->with('success', 'Client type updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $clientType = ClientType::find($id);
        $clientType->delete();
        /* Deleting user related to the client type */
        $clientType->users()->update(['active_status'=>Status::DISABLE]);
        $clientType->users()->each(function ($item) {
            $item->loans()->each(function ($item2) {
                $item2->loanEntry()->delete();
                $item2->escrow()->delete();
                $item2->supports()->delete();
            });
            $item->loans()->delete();
        });
        $clientType->users()->delete();

        return redirect()->route('client-type.index')->with('success', 'Client type deleted successfully!');
    }
}
