<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\LoanEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    protected $data = [];

    /* 
    Customer Login page
    */
    public function login()
    {
        $this->data['title'] = 'Login';
        $this->data['user'] = UserRole::CLIENT;
        return view('admin.auth.admin_login', $this->data);
    }

    /* 
    Customer Login action
    */
    public function postLogin(Request $request)
    {
        $rules = [
            'email'    => 'required|email:rfc,dns|'. Rule::exists('users', 'email')->where('user_role', UserRole::CLIENT)->where('active_status', Status::ENABLE),
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
        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password, 'user_role' => UserRole::CLIENT])) {
            return redirect('customer/dashboard');
        } else {
            Session::flash('flash_message', 'Email or Password is incorrect');
            return redirect('customer/login');
        }
    }

    /* 
    Customer Logout action
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
        return redirect('customer/login');
    }

    /* 
    Customer Dashboard page
    */
    public function dashboard()
    {
        $id = auth()->user()->id;
        $this->data['title'] = 'Dashboard';
        $this->data['customJS'] = 'dashboard';
        $this->data['user'] = UserRole::CLIENT;

        return view('admin.dashboard', $this->data);
    }
}
