<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    protected $data = [];
    protected $clientController = [];

    public function __construct(ClientController $clientController) {
        $this->clientController = $clientController;
    }

    /* Showing edit profile */
    public function index(string $id) {
        $this->data['title'] = 'Profile';
        $this->data['id'] = $id;
        $this->data['client'] = User::find($id);
        return view('admin.profile.index', $this->data);
    }

    /* Update profile */
    public function updateProfile(Request $request, string $id) {
        try {
            $rules = [
                'name'  => 'required',
                'email' => 'required|email:rfc,dns'
            ];
            $messages = [
                'name.required'  => 'Please enter the name!',
                'email.required' => 'Please enter the email!',
                'email.email'    => 'Please enter the valid email!'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $client = User::find($id);
            $client->name = $request->name;
            $client->email = $request->email;
            $client->save();

            $mailData = [
                'status'   => Status::PROFILE_UPDATED,
                'name'     => $client->name,
                'email'    => $client->email
            ];
            $this->clientController->sendCustomerEmail($mailData);

            return redirect()->back()->with('success', 'Profile updated successfully!');
        } catch (Exception $e) {
            return back()->with('danger', 'Something went wrong. Please try again!');
        }
    }

    /* Showing Change Password page */
    public function changePassword(string $id) {
        $this->data['title'] = 'Change Password';
        $this->data['id'] = $id;
        return view('admin.profile.changePassword', $this->data);
    }

    /* Update Password */
    public function updatePassword(Request $request, string $id) {
        try {
            $rules = [
                'old_password'         => 'required',
                'new_password'         => 'required',
                'confirm_new_password' => 'required|same:new_password'
            ];
            $messages = [
                'old_password.required'         => 'Please enter the old password!',
                'new_password.required'         => 'Please enter the new password!',
                'confirm_new_password.required' => 'Please confirm the new password!',
                'confirm_new_password.same'     => 'Password\'s don\'t match!'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            } else {
                $client = User::find($id);
                $bcrypt = new BcryptHasher();
                if (!$bcrypt->check($request->old_password, $client->password)) {
                    return redirect()->back()->withInput()->with('invalid', 'Please enter the valid old passsword!');
                }
                $client->password = bcrypt($request->new_password);
                $client->save();

                $mailData = [
                    'status'   => Status::PASSWORD_UPDATED,
                    'name'     => $client->name,
                    'email'    => $client->email
                ];
                $this->clientController->sendCustomerEmail($mailData);
            }

            if(auth()->user()->user_role == UserRole::CLIENT) {
                $route = 'customer/';
            } else {
                $route = 'admin/';
            }
            return redirect($route.'logout')->with('success', 'Password updated successfully!');
        } catch (Exception $e) {
            return back()->with('danger', 'Something went wrong. Please try again!');
        }
    }
}
