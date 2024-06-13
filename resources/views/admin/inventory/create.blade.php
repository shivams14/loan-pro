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

<!-- Horizontal Steppers -->
@include('admin.inventory.steper')
<!-- /.Horizontal Steppers -->

<div class="card">
    <div class="card-header"></div>
    <div class="card-body">

        @php
            $store = "inventory.store";
        @endphp
        {!! Form::open(array('route'=>$store, 'method'=>'POST', 'id'=>'inventoryForm')) !!}

            @include('admin.inventory.first_form')
            @include('admin.inventory.second_form')
            @include('admin.inventory.third_form')

        {!! Form::close() !!}

    </div>
</div>

@endsection