@extends('admin.layouts.app')
@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Search Renter</li>
            </ol>
            <h6 class="slim-pagetitle">Search Renter</h6>
        </div>

        <div class="section-wrapper">
            <form id="search-renter-form">
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
                            <label class="form-check-label">Leased</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" value="">
                            <label class="form-check-label">All</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">First Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="firstname" placeholder="First Name">
                    </div>
                    <label class="col-sm-2 col-form-label font-weight-bold">Last Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Email</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                    </div>
                    <label class="col-sm-2 col-form-label font-weight-bold">Phone</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="phone" placeholder="Phone">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Admin</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="admin" id="admin-filter">
                            <option value="0">All</option>
                            <!-- Admins will be loaded or hardcoded as before, ideally from a variable -->
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary" id="search-btn">
                            <i class="fa fa-search mr-1"></i> Search Renter
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
                    <table id="search-results-table" class="table display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Status</th>
                                <th>Admin</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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

    $('#search-renter-form').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const resultsSection = $('#results-section');
        const searchBtn = $('#search-btn');

        // Show results section, hide form
        form.hide();
        resultsSection.show();

        // If table already exists, destroy it or just reload
        if ($.fn.DataTable.isDataTable('#search-results-table')) {
            resultsTable.destroy();
        }

        // Initialize DataTable with server-side processing and form data
        resultsTable = $('#search-results-table').DataTable(DataTableHelpers.getConfig("{{ route('admin-searched-renter-result') }}", [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "firstname", name: "firstname" },
            { data: "lastname", name: "lastname" },
            { data: "status", name: "status", orderable: false, searchable: false },
            { data: "adminname", name: "adminname" },
            { data: "actions", name: "actions", orderable: false, searchable: false }
        ], {
            // Pass form data to the server-side request
            ajax: {
                url: "{{ route('admin-searched-renter-result') }}",
                data: function(d) {
                    d.status = $('input[name="status"]:checked').val();
                    d.firstname = $('input[name="firstname"]').val();
                    d.lastname = $('input[name="lastname"]').val();
                    d.email = $('input[name="email"]').val();
                    d.phone = $('input[name="phone"]').val();
                    d.admin = $('select[name="admin"]').val();
                }
            }
        }));
    });

    $('#btn-back-to-search').on('click', function() {
        $('#results-section').hide();
        $('#search-renter-form').show();
    });
});
</script>
@endpush
