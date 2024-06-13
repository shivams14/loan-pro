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
    <div class="card-header">
        <a class="btn btn-dark float-right" href="{{route($route.'support')}}">Back</a>
    </div>
    <div class="card-body">

        @php
            $store = $route."support.store";
        @endphp
        {!! Form::open(array('route'=>$store,'method'=>'POST','id'=>'supportForm')) !!}

            @include('admin.support.form')

        {!! Form::close() !!}

    </div>
</div> 

@endsection