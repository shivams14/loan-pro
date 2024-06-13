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
    @if(count($chats) > 0)
        <div class="message-box">
            @foreach($chats as $chat)
                <div class="chats @if(auth()->user()->id == $chat->message_from){{'float-right'}}@else{{'float-left'}}@endif">
                    <strong>@if(auth()->user()->id == $chat->message_from) {{'You'}} @else {{$chat->userFrom->name}} @endif:</strong>
                    {{$chat->message}}
                    <br>
                </div>
            @endforeach
        </div>
    @elseif($support->status == \App\Enums\Status::CLOSED)
        No chat has been initiated!
    @endif

    @if($support->status == \App\Enums\Status::OPEN)
        {!! Form::open(array('route'=>[$route.'support.chat.store', $id],'method'=>'POST','id'=>'chatForm')) !!}
            <div class="row">
                <div class="form-group">
                    <strong>Message:</strong>
                    <input type="hidden" name="message_from" value="{{auth()->user()->id}}">
                    <input type="hidden" name="message_to" value="@if($userType == 'admin'){{$support->client_id}}@else{{$support->created_by}}@endif">
                    {!! Form::textarea('message', null, array('placeholder' => 'Type a Message', 'class' => 'form-control', 'id' => 'message')) !!}
                    @if($errors->first('message'))
                        <div class="col-sm-3">
                            <small class="text-danger">
                                {{$errors->first('message')}}
                            </small>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3 submit-action">
                <button type="submit" class="btn btn-primary" id="send-message">Send</button>
            </div>
        {!! Form::close() !!}
    @endif
</div>

@endsection