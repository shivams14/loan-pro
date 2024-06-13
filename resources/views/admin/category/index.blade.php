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
        <a class="btn btn-dark float-right" href="{{ url('admin/category/create') }}">Create</a>
    </div>
    <div class="card-body">
        <table id="#example1" class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th width="150px;">Action</th>
            </tr>
            @php
                $delete = "category.destroy";
            @endphp
            @forelse($records as $key => $value)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{ $value->name }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ url('admin/category/' .$value->id. '/edit') }}">Edit</a>

                        {!! Form::open(['method' => 'DELETE','route' => [$delete, $value->id], 'style' => 'display:inline', 'id' => 'delete-category'.$value->id]) !!}
                            {!! Form::button('Delete', ['class' => 'btn btn-danger confirm', 'onclick' => 'return deleteConfirm()', 'id' => $value->id]) !!}
                        {!! Form::close() !!}

                    </td>
                </tr>
            @empty
                <tr>
                    No record found!
                </tr>
            @endforelse
        </table>
    </div>
</div>


<!-- Modal to confirm to delete the category -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this category?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" id="btn-delete-category" class="btn btn-danger">Yes</button>
            </div>
        </div>
    </div>
</div>

<script>

function deleteConfirm() {
    $('#deleteCategoryModal').modal('show');

    var id = $(this).attr('id');
    $("#btn-delete-category").click(function(){
        $("#btn-delete-category").attr('disabled', 'disabled');
        $('.loader').show();
        $("#delete-category"+id).submit();
    });
}

</script>

@endsection