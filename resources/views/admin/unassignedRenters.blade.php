@extends('admin.layouts.app')
@section('content')
@section('title', 'RentApartments Admin | Leased Renters')
<style>
    td {
        text-align: center;
    }
</style>
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Unassigned Renters </li>
            </ol>
            <h6 class="slim-pagetitle">Unassigned Renter</h6>
        </div>
        <div class="section-wrapper">
            <div class="table-wrapper">
                <table id="unassigned-renter" class="table display responsive">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th class="text-center">Full Name</th>
                            <th class="text-center">Probability</th>
                            <th class="text-center">Area</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
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
                $("#unassigned-renter").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin-unassigned-renters') }}",
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex",
                        },
                        {
                            data: "fullname",
                            name: "fullname",
                        },
                        {
                            data: "probability",
                            name: "probability",
                        },
                        {
                            data: "area",
                            name: "area",
                        },
                        {
                            data: "actions",
                            name: "actions",
                        },
                    ],
                });
            } catch (err) {
                console.log("Err in datatables", err);
            }
        });
    });

    function claimrenter(renterId) {
        $.ajax({
            url: "{{ route('admin-claim-renter') }}",
            method: "POST",
            data: {
                renterId: renterId
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
                if (response.message) {
                    $('#renter-row-' + renterId).remove();
                    toastr.success("Status Changes Successfully!");
                } else {
                    toastr.danger("Failed to change status. Please try again.");
                }
            },
            error: function() {
                toastr.danger("An error occurred. Please try again.");
            }
        });
    }
</script>
@endpush
