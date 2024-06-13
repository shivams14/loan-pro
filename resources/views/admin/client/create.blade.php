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

<div class="card">
    <div class="card-header">
        <a class="btn btn-dark float-right" href="{{URL('admin/client')}}">Back</a>
    </div>
    <div class="card-body">

        @php
            $store = "client.store";
        @endphp
        {!! Form::open(array('route'=>$store,'method'=>'POST','id'=>'clientForm')) !!}

            @include('admin.client.form')

        {!! Form::close() !!}

    </div>
</div>

@endsection