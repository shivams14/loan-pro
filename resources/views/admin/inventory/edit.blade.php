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
            $update = "inventory.update";
        @endphp
        {!! Form::model($record, ['method' => 'PATCH', 'route' => [$update, $record->id], 'id' => 'updateInventoryForm']) !!}

            <input type="hidden" name="update_form" value="{{$record->id}}" id="update_form">
            @include('admin.inventory.first_form')
            @include('admin.inventory.second_form')
            @include('admin.inventory.third_form')

        {!! Form::close() !!}

    </div>
</div>

@endsection