Hi {{$data['name']}},

<br><br>

@if($data['status'] == \App\Enums\Status::CUSTOMER_CREATED || $data['status'] == \App\Enums\Status::CUSTOMER_UPDATED)

    @if($data['status'] == \App\Enums\Status::CUSTOMER_CREATED)
        Your account has been created. Please click on <a href="{{$data['loginURL']}}" target="_blank">Login</a> and use below credentials to login:
        <br>
        <strong>Email:</strong> {{$data['email']}}<br>
        <strong>Password:</strong> {{$data['password']}}<br>
        <strong>Account Number:</strong> {{$data['account_number']}}
    @elseif($data['status'] == \App\Enums\Status::CUSTOMER_UPDATED)
        Your email has been updated by Admin. Please use this email to login:
        <br>
        <strong>Email:</strong> {{$data['email']}}
    @endif

@endif

@if($data['status'] == \App\Enums\Status::PROFILE_UPDATED)
    You have successfully updated your profile!
@endif

@if($data['status'] == \App\Enums\Status::PASSWORD_UPDATED)
    You have successfully updated your password!
@endif

<br><br>

Thanks!