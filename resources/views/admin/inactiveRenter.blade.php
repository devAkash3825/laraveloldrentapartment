@extends('admin.layouts.app')
@section('content')
@section('title', 'RentApartments Admin | Inactive Renters')
<style>
    td{
        text-align: center;
    }
</style>
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Inactive Renter</li>
            </ol>
            <h6 class="slim-pagetitle">Inactive Renter</h6>
        </div>
        <div class="section-wrapper">
            <div class="table-wrapper">
                <table id="inactive-renter" class="table display responsive">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th class="text-center">First Name</th>
                            <th class="text-center">Last Name</th>
                            <th class="text-center">Probability</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Admin</th>
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
                $("#inactive-renter").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin-inactiveRenter') }}",
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex",
                        },
                        {
                            data: "firstname",
                            name: "firstname",
                        },
                        {
                            data: "lastname",
                            name: "lastname",
                        },
                        {
                            data: "probability",
                            name: "probability",
                        },
                        {
                            data: "status",
                            name: "status",
                        },
                        {
                            data: "adminname",
                            name: "adminname",
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
</script>
@endpush
