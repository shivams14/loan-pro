<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\UserRole;
use App\Models\BankLoan;
use App\Models\Insurance;
use App\Models\User;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    protected $data = [];

    public function __construct() {
        $this->data['title'] = 'Investor';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = User::withoutTrashed()->where('active_status', Status::ENABLE)->where('user_role', UserRole::INVESTOR)->latest()->get();

        $this->data['records'] = $records;
        return view('admin.investor.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.investor.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'name'  => 'required|unique:users,name,NULL,id,deleted_at,NULL|max:25',
            'email' => 'required|email:rfc,dns|unique:users,email,NULL,id,deleted_at,NULL',
        ],
        [
            'name.required'  => 'Please enter the name!',
            'name.unique'    => 'The name already exists!',
            'name.max'       => 'Please don\'t enter the name more than :max characters!',
            'email.required' => 'Please enter the email!',
            'email.email'    => 'Please enter the valid email!',
            'email.unique'   => 'The email already exists!'
        ]);

        $name = $request->input('name');

        $password = str_replace(' ', '_', $name) . 'PW' . time();
        User::create([
            'name'          => $name,
            'email'         => $request->input('email'),
            'password'      => bcrypt($password),
            'user_role'     => UserRole::INVESTOR,
            'active_status' => Status::ENABLE
        ]);

        return redirect()->route('investor.index')->with('success', 'Investor created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $investor = User::where('user_role', UserRole::INVESTOR)->withoutTrashed()->find($id);
        $this->data['record'] = $investor;
        $this->data['insurance'] = Insurance::withoutTrashed()->latest()->first();
        $this->data['bankLoan'] = BankLoan::withoutTrashed()->get();
        return view('admin.investor.detail', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $records = User::where('user_role', UserRole::INVESTOR)->withoutTrashed()->find($id);
        $this->data['record'] = $records;
        return view('admin.investor.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,
        [
			'name'  => 'required|unique:users,name,'.$id.',id,deleted_at,NULL|max:25',
			'email' => 'required|email:rfc,dns|unique:users,email,'.$id.',id,deleted_at,NULL'
        ],
        [
			'name.required'  => 'Please enter the name!',
			'name.unique'    => 'The name already exists!',
            'name.max'       => 'Please don\'t enter the name more than :max characters!',
			'email.required' => 'Please enter the email!',
			'email.email'    => 'Please enter the valid email!',
			'email.unique'   => 'The email already exists!'
		]);

        $client = User::find($id);
        $client->name = $request->input('name');
        $client->email = $request->input('email');

        $client->save();

        return redirect()->route('investor.index')->with('success', 'Investor updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->active_status = Status::DISABLE;
        $user->save();
        $user->delete();
        /* Deleting loans and inventories related to the investor */
        $user->inventories()->each(function ($item) {
            $item->loan()->each(function ($item2) {
                $item2->loanEntry()->delete();
                $item2->escrow()->delete();
                $item2->supports()->delete();
            });
            $item->loan()->delete();
        });
        $user->inventories()->delete();

        return redirect()->route('investor.index')->with('success', 'Investor deleted successfully!');
    }
}
