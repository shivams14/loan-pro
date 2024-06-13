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
    <div class="card-header">Update Profile
        <a class="btn btn-primary button-right" href="{{ route($route.'profile.change-password', $id) }}">Change Password</a>
    </div>
    <div class="card-body">
        {!! Form::open(array('route'=>[$route.'profile.update', $id],'method'=>'PUT','id'=>'profileForm')) !!}

            <div class="row">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', $client->name, array('placeholder' => 'Name', 'class' => 'form-control', 'id' => 'name')) !!}
                    @if($errors->first('name'))
                        <div class="col-sm-3">
                            <small class="text-danger">
                                {{$errors->first('name')}}
                            </small>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <strong>Email:</strong>
                    {!! Form::text('email', $client->email, array('placeholder' => 'Email', 'class' => 'form-control', 'id' => 'email')) !!}
                    @if($errors->first('email'))
                        <div class="col-sm-3">
                            <small class="text-danger">
                                {{$errors->first('email')}}
                            </small>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 submit-action">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        {!! Form::close() !!}
    </div>
</div> 

@endsection