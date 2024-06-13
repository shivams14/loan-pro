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
        <a class="btn btn-dark float-right" href="{{ url('admin/client/create') }}">Create</a>
    </div>
    <div class="card-body">
        <table id="#example1" class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Status</th>
                <th>Type</th>
                <th>Account Number</th>
                <th>Entities</th>
                <th>Action</th>
            </tr>
            @php
                $delete = "client.destroy";
            @endphp
            @forelse($records as $key => $value)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{ $value->name }}</td>
                    <td>@if($value->active_status == \App\Enums\Status::ENABLE) {{'Enable'}} @else {{'Disable'}} @endif</td>
                    <td>{{ $value->clientType->name }}</td>
                    <td>@if($value->account_number) {{ $value->account_number }} @else - @endif</td>
                    <td>
                    @forelse($value->family as $k => $members)
                        @if($k > 0 && $k < count($value->family))
                            ,
                        @endif
                        {{$members->first_name}}
                        {{$members->middle_name}}
                        {{$members->last_name}}
                    @empty
                        -
                    @endforelse
                    </td>
                    <td>
                        <a class="btn btn-primary" href="{{ url('admin/client/' .$value->id. '/edit') }}">Edit</a>

                        <!-- {!! Form::open(['method' => 'DELETE', 'route' => [$delete, $value->id], 'style' => 'display:inline', 'id' => 'delete-client'.$value->id]) !!}
                            {!! Form::button('Delete', ['class' => 'btn btn-danger confirm', 'id' => $value->id]) !!}
                        {!! Form::close() !!} -->
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="100" class="no-record-found">No record found!</td>
                </tr>
            @endforelse
        </table>
    </div>
</div>

<!-- Modal to confirm to delete the client -->
<div class="modal fade" id="deleteClientModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this client?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" id="btn-delete-client" class="btn btn-danger">Yes</button>
            </div>
        </div>
    </div>
</div>

<script>

$(document).on('click', '.confirm', function(e){
    e.preventDefault();
    $('#deleteClientModal').modal('show');

    var id = $(this).attr('id');
    $("#btn-delete-client").click(function(){
        $("#btn-delete-client").attr('disabled', 'disabled');
        $('.loader').show();
        $("#delete-client"+id).submit();
    });
});

</script>

@endsection
