<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\UserRole;
use App\Mail\Customer;
use Illuminate\Http\Request;
use App\Models\ClientType;
use App\Models\Country;
use App\Models\PaymentMethod;
use App\Models\State;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Languages;

class ClientController extends Controller
{
    protected $data = [];

    public function __construct() {
        $this->data['title'] = 'Client';
        $this->data['customJS'] = 'admin_client';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = User::withoutTrashed()->with('family')->where('user_role', UserRole::CLIENT)->latest()->get();
        $this->data['records'] = $records;
        return view('admin.client.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['clientTypes'] = ClientType::withoutTrashed()->latest()->get();
        $this->data['paymentMethods'] = PaymentMethod::withoutTrashed()->latest()->get();
        $this->data['countries'] = Country::withoutTrashed()->oldest()->get();
        $this->data['states'] = State::withoutTrashed()->oldest()->get();
        $this->data['languages'] = Languages::lookup();
        $this->data['memberRecords'] = [];
        return view('admin.client.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'name' 					 => 'required|unique:users,name,NULL,id,deleted_at,NULL|max:25',
                'email' 				 => 'required|email:rfc,dns|unique:users,email,NULL,id,deleted_at,NULL',
                'client_type_id' 		 => 'required|integer|exists:client_types,id',
                'language' 				 => 'required',
                'allowed_payment_method' => 'required|exists:payment_methods,id'
            ];
            $messages = [
                'name.required' 		          => 'Please enter the display name!',
                'name.unique' 			          => 'The display name already exists!',
                'name.max'                        => 'Please don\'t enter the display name more than :max characters!',
                'email.required' 		          => 'Please enter the email!',
                'email.email' 			          => 'Please enter the valid email!',
                'email.unique' 			          => 'This email has already been taken!',
                'client_type_id.required'         => 'Please select the client type!',
                'client_type_id.exists'           => 'Please select the valid client type!',
                'language.required' 	          => 'Please select language!',
                'allowed_payment_method.required' => 'Please select the payment method!',
                'allowed_payment_method.exists'   => 'Please select the valid payment method!'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect("admin/client/create")->withErrors($validator)->withInput();
            }
            $insertArr = [];
            $alphanumeric = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; // To generate unique account number whenever the client is created
            $insertArr['name'] = $request->name;
            $insertArr['email'] = $request->email;
            $password = str_replace(' ', '_', $insertArr['name']) . 'PW' . time();
            $insertArr['password'] = bcrypt($password);
            $insertArr['client_type_id'] = $request->client_type_id;
            $insertArr['active_status'] = $request->active_status;
            $insertArr['language'] = $request->language;
            $insertArr['allowed_payment_method'] = json_encode($request->allowed_payment_method);
            $insertArr['account_number'] = substr(str_shuffle($alphanumeric), 0, 9);
            $client = User::create($insertArr);

            $mailData = [
                'status'         => Status::CUSTOMER_CREATED,
                'name'           => $client->name,
                'email'          => $client->email,
                'password'       => $password,
                'account_number' => $client->account_number,
                'loginURL'       => route('customer.login')
            ];
            $this->sendCustomerEmail($mailData);

            return redirect()->route('client.index')->with('success', 'Client created successfully!');
        } catch (Exception $e) {
            return redirect("admin/client/create")->with('danger', 'Something went wrong. Please try again!');
        }
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
        // print_r(Status::CUSTOMER['Customer Created']);die;
        $records = User::where('user_role', UserRole::CLIENT)->withoutTrashed()->find($id);

        $this->data['record'] = $records;
        $this->data['clientTypes'] = ClientType::withoutTrashed()->latest()->get();
        $this->data['paymentMethods'] = PaymentMethod::withoutTrashed()->latest()->get();
        $this->data['memberRecords'] = User::withoutTrashed()->where(['parent_id' => $id])->latest()->get();
        $this->data['countries'] = Country::withoutTrashed()->oldest()->get();
        $this->data['languages'] = Languages::lookup();
        $this->data['states'] = State::withoutTrashed()->where('country_id', $records->country_id)->get();
        return view('admin.client.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->validate($request,
            [
                'name' 					 => 'required|unique:users,name,'.$id.',id,deleted_at,NULL|max:25',
                'email' 				 => 'required|email:rfc,dns|unique:users,email,'.$id.',id,deleted_at,NULL',
                'client_type_id' 		 => 'required|integer|exists:client_types,id',
                'language' 				 => 'required',
                'allowed_payment_method' => 'required|exists:payment_methods,id'
            ],
            [
                'name.required' 		          => 'Please enter the display name!',
                'name.unique' 			          => 'The display name already exists!',
                'name.max'                        => 'Please don\'t enter the display name more than :max characters!',
                'email.required' 		          => 'Please enter the email!',
                'email.email' 			          => 'Please enter the valid email!',
                'email.unique' 			          => 'This email has already been taken!',
                'client_type_id.required'         => 'Please select the client type!',
                'client_type_id.exists'           => 'Please select the valid client type!',
                'language.required' 	          => 'Please select language!',
                'allowed_payment_method.required' => 'Please select the payment method!',
                'allowed_payment_method.exists'   => 'Please select the valid payment method!'
            ]);

            $name = $request->input('name');
            $newEmail = $request->input('email');

            $client = User::find($id);

            $email = $client->email;
            $client->name = $name;
            $client->email = $newEmail;
            $client->client_type_id = $request->input('client_type_id');
            $client->active_status = $request->input('active_status');
            $client->language = $request->input('language');
            $client->allowed_payment_method = json_encode($request->input('allowed_payment_method'));

            $client->save();

            if($email != $newEmail){
                $mailData = [
                    'status'   => Status::CUSTOMER_UPDATED,
                    'name'     => $name,
                    'email'    => $newEmail,
                    'loginURL' => route('customer.login')
                ];
                $this->sendCustomerEmail($mailData);
            }

            return redirect()->route('client.index')->with('success', 'Client updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('danger', 'Something went wrong. Please try again!');
        }
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
        /* Deleting loans and client family members related to the client */
        $user->loans()->each(function ($item) {
            $item->loanEntry()->delete();
            $item->escrow()->delete();
            $item->supports()->delete();
        });
        $user->loans()->delete();
        $user->family()->update(['active_status' => Status::DISABLE]);
        $user->family()->delete();

        return redirect()->route('client.index')->with('success', 'Client deleted successfully!');
    }

    /* Ajax Add Family Member */
    public function ajaxClientAddMember(Request $request)
    {
        $id = '';
        if($request->family_member_id > 0) {
            $id = $request->family_member_id;
        }
        $rules = [
            'member_title_name'   => 'required|max:25',
            'member_first_name'   => 'required|max:25',
            'member_middle_name'  => 'nullable|max:25',
            'member_last_name' 	  => 'required|max:25',
            'member_email'        => 'required|email:rfc,dns|unique:users,email,'.$id.',id,deleted_at,NULL',
            'member_dob'          => 'required|date',
            'member_phone_number' => 'required|integer|min:0|digits:10',
            'member_country_name' => 'required|integer|exists:countries,id',
            'member_state_name'   => 'required|integer|exists:states,id'
        ];
        $messages = [
            'member_title_name.required'   => 'Please enter the title!',
            'member_title_name.max'        => 'Please don\'t enter the title more than :max characters!',
            'member_first_name.required'   => 'Please enter the first name!',
            'member_first_name.max'        => 'Please don\'t enter the first name more than :max characters!',
            'member_middle_name.max'       => 'Please don\'t enter the middle name more than :max characters!',
            'member_last_name.required'    => 'Please enter the last name!',
            'member_last_name.max'         => 'Please don\'t enter the last name more than :max characters!',
            'member_email.required' 	   => 'Please enter the email!',
            'member_email.email' 		   => 'Please enter the valid email!',
            'member_email.unique'          => 'The email already exists!',
            'member_dob.required'          => 'Please select date of birth!',
            'member_dob.date' 	           => 'Please select valid date of birth!',
            'member_phone_number.required' => 'Please enter the phone number!',
            'member_phone_number.integer'  => 'Please enter the phone number in numeric!',
            'member_phone_number.min'      => 'Please enter the valid phone number!',
            'member_phone_number.digits'   => 'Please enter the phone number of :digits digits!',
            'member_country_name.required' => 'Please select the country!',
            'member_country_name.exists'   => 'Please select the valid country!',
            'member_state_name.required'   => 'Please select the state!',
            'member_state_name.exists'     => 'Please select the valid state!'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status'   => Status::INTERNAL_ERROR,
                'messages' => $validator->messages()
            ]);
        }
        $insertArr = $json = [];
        /* Basic details */
        $insertArr['name'] = $request->member_title_name;
        $insertArr['first_name'] = $request->member_first_name;
        $insertArr['middle_name'] = $request->member_middle_name;
        $insertArr['last_name'] = $request->member_last_name;
        $insertArr['user_role'] = UserRole::FAMILY;
        $insertArr['email'] = $request->member_email;
        $insertArr['dob'] = $request->member_dob;
        $insertArr['tax_id_number'] = $request->member_tax_id_number;
        $password = $insertArr['name'] . 'PW' . time();
        $insertArr['password'] = bcrypt($password);
        $insertArr['active_status'] = Status::ENABLE;
        $insertArr['parent_id'] = $request->user_id;

        /* Phone number */
        $insertArr['phone_number'] = $request->member_phone_number;
        $insertArr['is_cellular'] = ($request->member_celular !== 'on') ? 0 : 1;

        /* Address */
        $insertArr['street'] = $request->member_street_name;
        $insertArr['city'] = $request->member_city_name;
        $insertArr['country_id'] = $request->member_country_name;
        $insertArr['state_id'] = $request->member_state_name;
        $insertArr['zipcode'] = $request->member_zip_code;

        if(!empty($id)) {
            User::where(['id'=>$id])->update($insertArr);
            $json['message'] = 'Member has been updated!';
        } else {       
            User::create($insertArr);
            $json['message'] = 'Member has been added!';
        }
        $json['status'] = Status::SUCCESS;

        return response()->json($json);
    }

    /* Ajax Find Family Member */
    public function ajaxFindFamilyMember(Request $request)
    {
        $userDetail = User::find($request->id);
        $this->data['status'] = Status::SUCCESS;
        $this->data['record'] = $userDetail;
        $this->data['countries'] = Country::withoutTrashed()->oldest()->get();
        $this->data['states'] = State::withoutTrashed()->where('country_id', $userDetail->country_id)->get();
        return view('admin.client.family_form', $this->data);
    }

    /* Sending email to customer */
    public function sendCustomerEmail($mailData = []) {
        try {
            Mail::to($mailData['email'])->send(new Customer($mailData));
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }
}
