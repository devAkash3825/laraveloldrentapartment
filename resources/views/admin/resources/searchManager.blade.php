@extends('admin.layouts.app')

@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle">Search Manager </h6>
            </div>

            <div class="section-wrapper">
                <!-- Search Form -->
                <form id="search-form">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="1" checked>
                                <label class="form-check-label">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="0">
                                <label class="form-check-label">Inactive</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="2">
                                <label class="form-check-label">Dead</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="">
                                <label class="form-check-label">All</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">User Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Property Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="propertyname">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Manage By</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="keywords_srch">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="button" class="btn btn-primary" id="search-btn">Search</button>
                        </div>
                    </div>
                </form>

                <!-- DataTable (initially hidden) -->
                <div id="resultsContainer" style="display: none;">
                    <table id="managers-table" class="table table-bordered" style="width:100%;">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Property Names</th>
                                <th>Managed By</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('adminscripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable but don't show it initially
            var table = $('#managers-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin-search-managers') }}", // Your route here
                    type: 'GET',
                    data: function(d) {
                        // Pass form data to the server
                        d.status = $('input[name="status"]:checked').val();
                        d.username = $('input[name="username"]').val();
                        d.email = $('input[name="email"]').val();
                        d.keywords_srch = $('input[name="keywords_srch"]').val();
                        d.propertyname = $('input[name="propertyname"]').val();
                    },
                    error: function(xhr) {
                        console.error("DataTables Error:", xhr
                        .responseText); // Log errors for debugging
                    },
                },
                columns: [{
                        data: 'username',
                        title: 'User Name'
                    },
                    {
                        data: 'email',
                        title: 'Email'
                    },
                    {
                        data: 'property_names',
                        title: 'Properties',
                        orderable: false,
                        render: function(data) {
                            return data || '<span class="text-muted">No properties</span>';
                        }
                    },
                    {
                        data: 'managed_by',
                        title: 'Managed By'
                    },
                ],
                language: {
                    emptyTable: "No managers found",
                    search: "",
                    lengthMenu: "",
                },
                paging: true,
                ordering: true,
            });
            
            $('#search-btn').on('click', function() {
                table.ajax.reload(function() {
                    $('#resultsContainer').show();
                });
            });
        });
    </script>
@endpush
