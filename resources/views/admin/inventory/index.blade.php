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
        <a class="btn btn-dark float-right" href="{{ url('admin/inventory/create') }}">Create</a>
    </div>
    <div class="card-body">
        <table id="example1" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th width="180px;">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>


<!-- Modal to confirm to delete the inventory -->
<div class="modal fade" id="deleteInventoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this inventory?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" id="btn-delete-inventory" class="btn btn-danger">Yes</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).on('click', '.delete-inv-btn', function(e){
        e.preventDefault();
        jQuery('#deleteInventoryModal').modal('show');
        var id = $(this).attr('id');
        $("#btn-delete-inventory").click(function(){
            $("#btn-delete-inventory").attr('disabled', 'disabled');
            $('.loader').show();
            $("#delete-inventory"+id).submit();
        });
    });
    var $j = jQuery.noConflict();
    $(document).ready(function () {
        $('#example1').DataTable({
            fixedHeader: true,
            autoWidth: false,
            header: "jqueryui",
            pageButton: "bootstrap",
            responsive: true,
            colReorder: true,
            deferRender: true,
            processing: true,
            'language': {
                'loadingRecords': '&nbsp;',
                'processing': '<div class="loading">Loading&#8230;</div>',
                "emptyTable": "No record found!"
            },
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('inventory.data') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataSrc: 'data',
                /* beforeSend: function () {
                    $(".loading").show();
                },
                complete: function () {
                    $(".loading").hide();
                }, */
            },
            columns: [
                {
                    data: 'id',
                    name: 'inventories.id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1; // Add 1 to start the numbering from 1
                    },
                    searchable: false
                },
                {
                    data: 'inventory_name',
                    name: 'inventories.name',
                    render: function(data, type, row, meta) {
                        return row.inventoryName; // Add 1 to start the numbering from 1
                        // console.log(row);
                    },
                    searchable: true, // Enable searching for name
                },
                { data: 'category_name', name: 'category_id', searchable: false }, // Enable searching for category name
                { data: 'status', name: 'inventories.status', searchable: false }, // Enable searching for status
                {
                    data: 'inventory_type_name',
                    name: 'inventoryType.name',
                    render: function(data, type, row, meta) {
                        return data; // Add 1 to start the numbering from 1
                    },
                    searchable: true, // Enable searching for inventory type name
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>
@endsection