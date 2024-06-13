<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventory;
use App\Models\Loan;
use App\Models\LoanEntry;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    protected $data = [];

    /* 
    Admin Login page
    */
    public function login()
    {
        $this->data['title'] = 'Login';
        $this->data['user'] = UserRole::SUPERADMIN;
        return view('admin.auth.admin_login', $this->data);
    }

    /* 
    Admin Login action
    */
    public function postLogin(Request $request)
    {
        $rules = [
            'email'    => 'required|email:rfc,dns|'. Rule::exists('users', 'email')->where('user_role', UserRole::SUPERADMIN)->where('active_status', Status::ENABLE),
            'password' => 'required'
        ];
        $messages = [
            'email.required'    => 'Please enter your username!',
            'email.email'       => 'Please enter your valid username!',
            'email.exists'      => 'Please enter your valid username!',
            'password.required' => 'Please enter your password!'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect("admin/login")->withErrors($validator)->withInput();
        }
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password, 'user_role' => UserRole::SUPERADMIN])) {
            return redirect('admin/dashboard');
        } else {
            Session::flash('flash_message', 'Email or Password is incorrect');
            return redirect('admin/login');
        }
    }

    /* 
    Admin Logout action
    */
    public function logout(Request $request)
    {
        // $request->session()->flush();
        $successMessage = '';
        if(Session::has('success')){
            $successMessage = Session::get('success');
        }
        Auth::logout();
        Session::flash('password_reset', $successMessage);
        return redirect('admin/login');
    }

    /* 
    Admin Dashboard page
    */
    public function dashboard()
    {
        $this->data['title'] = 'Dashboard';
        $this->data['customJS'] = 'dashboard';
        $this->data['user'] = UserRole::SUPERADMIN;
        $this->data['total_inventory'] = Inventory::withoutTrashed()->count();
        $this->data['total_client'] = User::withoutTrashed()->where(['user_role' => UserRole::CLIENT])->count();

        return view('admin.dashboard', $this->data);
    }
}
