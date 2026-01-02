@extends('admin.layouts.app')
@section('content')
@section('title', 'RentApartments Admin | List Properties ')

<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="slim-pagetitle"> List Properties </h6>
        </div>

        <div class="section-wrapper">
            <div class="table-wrapper">
                <table id="listProperty" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-15p">S.no</th>
                            <th class="wd-15p">Property Name</th>
                            <th class="wd-20p">City</th>
                            <th class="wd-15p">Features</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-25p text-align-center">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('adminscripts')
<script>
    $(document).ready(function() {
        $(function() {
            try {
                $("#listProperty").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin-property-listproperty') }}",
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex",
                        },
                        {
                            data: "propertyname",
                            name: "propertyname"
                        },
                        {
                            data: "city",
                            name: "city"
                        },
                        {
                            data: "features",
                            name: "features"
                        },
                        {
                            data: "status",
                            name: "status"
                        },
                        {
                            data: "action",
                            name: "action"
                        },
                    ],
                });
            } catch (err) {
                console.log("Err in datatables", err);
            }
        });
    });

    function changeStatus(id) {
        var status = $('#changetopropertystatus').data('status');
        $.ajax({
            url: "{{ route('admin-change-property-status') }}",
            method: "POST",
            data: {
                id: id,
                statusid:status
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
                if (response.success) {
                    toastr.message("Status Changes Successfully!");
                } else {
                    toastr.error("Failed to change status. Please try again.");
                }
            },
            error: function() {
                toastr.danger("An error occurred. Please try again.");
            }
        });
    }
</script>
@endpush
