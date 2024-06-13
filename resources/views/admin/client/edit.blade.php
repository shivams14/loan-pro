@extends('layouts.admin.dashboard')
@section('title', $title)
@section('content')
@include('shared.admin.page_title')

<div class="card">
    <div class="card-header">
        <a class="btn btn-dark float-right" href="{{URL('admin/client')}}">Back</a>
    </div>
    <div class="card-body">

        @php
            $update = "client.update";
        @endphp
        {!! Form::model($record, ['method' => 'PATCH','route' => [$update, $record->id],'id'=>'clientForm']) !!}

            @include('admin.client.form')

        {!! Form::close() !!}

    </div>
</div>

@endsection