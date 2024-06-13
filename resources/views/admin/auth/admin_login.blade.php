@extends('layouts.admin.login')
@section('title', $title)
@section('content')

<div class="card-body">

  <div class="error-message">
    @if(session()->has('flash_message'))
      <p class="alert {{ session()->get('alert-class', 'alert-danger') }}">{{ session()->get('flash_message') }}</p>
    @endif

    @if(session()->get('password_reset'))
      <p class="alert {{ session()->get('alert-class', 'alert-success') }}">{{ session()->get('password_reset') }}</p>
    @endif
  </div>

  <div class="pt-4 pb-2">
    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
    <p class="text-center small">Enter your username & password to login</p>
  </div>

  <form class="row g-3 needs-validation" action="@if($user == \App\Enums\UserRole::SUPERADMIN) {{ URL::to('admin/post-login') }} @else {{ URL::to('customer/post-login') }} @endif" method="post">
    {{ csrf_field() }}

    <div class="col-12">
      <label for="yourUsername" class="form-label">Username</label>
      <div class="input-group has-validation">
        <span class="input-group-text" id="inputGroupPrepend">@</span>
        <input type="email" name="email" class="form-control" id="yourUsername">
      </div>
    </div>
    @if($errors->first('email'))
      <div class="col-sm-12">
        <small class="text-danger">
          {{$errors->first('email')}}
        </small>
      </div>
    @endif

    <div class="col-12">
      <label for="yourPassword" class="form-label">Password</label>
      <input type="password" name="password" class="form-control" id="yourPassword">
    </div>
    @if($errors->first('password'))
      <div class="col-sm-12">
        <small class="text-danger">
          {{$errors->first('password')}}
        </small>
      </div>
    @endif

    <!--  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
      <label class="form-check-label" for="rememberMe">Remember me</label>
    </div>
  </div> -->
    <div class="col-12">
      <button class="btn btn-dark w-100" type="submit">Login</button>
    </div>
    <!-- <div class="col-12">
    <p class="small mb-0">Don't have account? <a href="pages-register.html">Create an account</a></p>
  </div> -->
  </form>

</div>


@endsection