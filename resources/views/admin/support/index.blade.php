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
        <a class="btn btn-dark float-right" href="{{ route($route.'support.create') }}">Create</a>
    </div>
    <div class="card-body">
        <table id="#example1" class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Ticket No</th>
                @if($userType == 'admin')
                    <th>Client Name</th>
                @endif
                <th>Created By</th>
                <th>Loan Name</th>
                <th>Issue Details</th>
                <th>Status</th>
                <th width="150px;">Action</th>
            </tr>
            @forelse($supports as $key => $support)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$support->ticket_no}}</td>
                    @if($userType == 'admin')
                        <td>{{$support->client->name}}</td>
                    @endif
                    <td>{{$support->user->name}}</td>
                    <td><a href="{{ route($route.'loan.view', $support->loan->id) }}" target="_blank">{{$support->loan->loan_label}}</a></td>
                    <td>{{\Illuminate\Support\Str::limit($support->issue_details, 25)}}<a href="#" id="see-more" supportId="{{$support->id}}"><br>See More</a></td>
                    <td>@if($support->status == \App\Enums\Status::OPEN) Open @else Closed @endif</td>
                    <td>
                        <a class="btn btn-primary" href="{{route($route.'support.chat', $support->id)}}">Chat</a>

                        @if($userType == 'admin' && $support->status == \App\Enums\Status::OPEN)
                            {!! Form::open(['method' => 'PUT', 'route' => ['support.closeTicket', $support->id], 'style' => 'display:inline', 'id' => 'close-ticket'.$support->id]) !!}
                                {!! Form::button('Close', ['class' => 'btn btn-danger confirm', 'id' => $support->id]) !!}
                            {!! Form::close() !!}
                        @endif
                    </td>
                    <!-- Modal to confirm to close the ticket -->
                    <div class="modal fade" id="seeMoreModal{{$support->id}}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Issue Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{$support->issue_details}}
                                </div>
                            </div>
                        </div>
                    </div>
                </tr>
            @empty
                <tr>
                    <td colspan="100" class="no-record-found">No record found!</td>
                </tr>
            @endforelse
        </table>
    </div>
</div>

<!-- Modal to confirm to close the ticket -->
<div class="modal fade" id="closeTicketModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Close Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to close this ticket?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" id="btn-close-ticket" class="btn btn-danger">Yes</button>
            </div>
        </div>
    </div>
</div>

<script>

$(document).on('click', '.confirm', function(e){
    e.preventDefault();
    $('#closeTicketModal').modal('show');

    var id = $(this).attr('id');
    $("#btn-close-ticket").click(function(){
        $("#btn-close-ticket").attr('disabled', 'disabled');
        $('.loader').show();
        $("#close-ticket"+id).submit();
    });
});

$(document).on('click', '#see-more', function(e){
    e.preventDefault();
    var supportId = $(this).attr('supportId');
    $('#seeMoreModal'+supportId).modal('show');
});

</script>

@endsection
