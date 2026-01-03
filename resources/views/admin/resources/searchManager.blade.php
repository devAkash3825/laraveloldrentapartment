@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Search Manager</li>
                </ol>
                <h6 class="slim-pagetitle">Search Manager</h6>
            </div>

            <div class="section-wrapper">
                <form id="search-manager-form">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Status</label>
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
                        <label class="col-sm-2 col-form-label font-weight-bold">User Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="username" placeholder="Username">
                        </div>
                        <label class="col-sm-2 col-form-label font-weight-bold">Email</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Property Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="propertyname" placeholder="Property Name">
                        </div>
                        <label class="col-sm-2 col-form-label font-weight-bold">Manage By (Company)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="company" placeholder="Company">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary" id="search-btn">
                                <i class="fa fa-search mr-1"></i> Search Manager
                            </button>
                        </div>
                    </div>
                </form>

                <hr>

                <div id="results-section" style="display:none;">
                    <div class="mb-3">
                        <button class="btn btn-outline-secondary btn-sm" id="btn-back-to-search">
                            <i class="fa fa-arrow-left mr-1"></i> Back to Search
                        </button>
                    </div>
                    <div class="table-wrapper">
                        <table id="manager-search-results" class="table display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Properties</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('adminscripts')
<script>
$(document).ready(function() {
    let resultsTable = null;

    $('#search-manager-form').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const resultsSection = $('#results-section');

        form.hide();
        resultsSection.show();

        if ($.fn.DataTable.isDataTable('#manager-search-results')) {
            resultsTable.destroy();
        }

        resultsTable = $('#manager-search-results').DataTable(DataTableHelpers.getConfig("{{ route('admin-search-managers') }}", [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "username", name: "UserName" },
            { data: "Email", name: "Email", defaultContent: "-" },
            { data: "status", name: "Status", orderable: false, searchable: false },
            { data: "property_names", name: "propertyinfo.PropertyName", orderable: false },
            { data: "actions", name: "actions", orderable: false, searchable: false }
        ], {
            ajax: {
                url: "{{ route('admin-search-managers') }}",
                data: function(d) {
                    d.status = $('input[name="status"]:checked').val();
                    d.username = $('input[name="username"]').val();
                    d.email = $('input[name="email"]').val();
                    d.company = $('input[name="company"]').val();
                    d.propertyname = $('input[name="propertyname"]').val();
                }
            }
        }));
    });

    $('#btn-back-to-search').on('click', function() {
        $('#results-section').hide();
        $('#search-manager-form').show();
    });
});
</script>
@endpush
