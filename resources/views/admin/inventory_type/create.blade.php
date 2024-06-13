@extends('layouts.admin.dashboard')
@section('title', $title)
@section('content')
@include('shared.admin.page_title')

<div class="card">
    <div class="card-header">
        <a class="btn btn-dark float-right" href="{{URL('admin/inventory-type')}}">Back</a>
    </div>
    <div class="card-body">

        @php
            $store = "inventory-type.store";
        @endphp
        {!! Form::open(array('route' => $store, 'method' => 'POST')) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', null, array('placeholder' => 'Inventory Type', 'class' => 'form-control')) !!}
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
        </div>
        {!! Form::close() !!}

    </div>
</div>

@endsection