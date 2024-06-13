@extends('layouts.admin.dashboard')
@section('title', $title)
@section('content')
@include('shared.admin.page_title')

<div class="card">
    <div class="card-header">
        <a class="btn btn-dark float-right" href="{{URL('admin/client-type')}}">Back</a>
    </div>
    <div class="card-body">

        @php
            $update = "client-type.update";
        @endphp
        {!! Form::model($record, ['method' => 'PATCH', 'route' => [$update, $record->id]]) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', null, array('placeholder' => 'Client Type', 'class' => 'form-control')) !!}
                    @if($errors->first('name'))
                        <div class="col-sm-8">
                            <small class="text-danger">
                                {{$errors->first('name')}}
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
</div>

@endsection