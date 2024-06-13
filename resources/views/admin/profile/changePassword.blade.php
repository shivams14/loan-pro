@extends('layouts.admin.dashboard')
@section('title', $title)
@section('content')
@include('shared.admin.page_title')

@if(Session::has('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
</div>
@endif

@if(Session::has('danger'))
<div class="alert alert-danger">
    {{ Session::get('danger') }}
</div>
@endif

@php
    $userType = 'admin';
    $route = '';
@endphp
@if(auth()->user()->user_role == \App\Enums\UserRole::CLIENT)
    @php
        $userType = 'customer';
        $route = 'customer.';
    @endphp
@endif

<div class="card">
    <div class="card-header">Update Password</div>
    <div class="card-body">
        {!! Form::open(array('route'=>[$route.'profile.updatePassword', $id],'method'=>'PUT','id'=>'changePasswordForm')) !!}

            <div class="row">
                <div class="form-group">
                    <strong>Old Password:</strong>
                    <input placeholder="Old Password" class="form-control" id="old_password" name="old_password" type="password">
                    @if($errors->first('old_password'))
                        <div class="col-sm-6">
                            <small class="text-danger">
                                {{$errors->first('old_password')}}
                            </small>
                        </div>
                    @endif
                    @if(Session::has('invalid'))
                        <div class="col-sm-6">
                            <small class="text-danger">
                                {{ Session::get('invalid') }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <strong>New Password:</strong>
                    <input placeholder="New Password" class="form-control" id="new_password" name="new_password" type="password">
                    @if($errors->first('new_password'))
                        <div class="col-sm-6">
                            <small class="text-danger">
                                {{$errors->first('new_password')}}
                            </small>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <strong>Confirm New Password:</strong>
                    <input placeholder="Confirm New Password" class="form-control" id="confirm_new_password" name="confirm_new_password" type="password">
                    @if($errors->first('confirm_new_password'))
                        <div class="col-sm-8">
                            <small class="text-danger">
                                {{$errors->first('confirm_new_password')}}
                            </small>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 submit-action">
                <button type="submit" class="btn btn-primary">Change</button>
            </div>

        {!! Form::close() !!}
    </div>
</div> 

@endsection