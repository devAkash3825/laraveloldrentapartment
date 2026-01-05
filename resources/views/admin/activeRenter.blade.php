@extends('admin.layouts.app')
@section('content')
@section('title', 'RentApartments Admin | Active Renters')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Active Renters</li>
            </ol>
            <h6 class="slim-pagetitle">Active Renter</h6>
        </div>
        <div class="section-wrapper">
            <div class="table-wrapper">
                <table id="active-renter" class="table display responsive">
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
        $('#active-renter').DataTable($.extend(DataTableHelpers.getConfig("{{ route('admin-activeRenter') }}", [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "firstname", name: "firstname" },
            { data: "lastname", name: "lastname" },
            { data: "probability", name: "probability" },
            { data: "status", name: "status", orderable: false, searchable: false },
            { data: "adminname", name: "adminname" },
            { data: "actions", name: "actions", orderable: false, searchable: false }
        ]), {
            order: [[1, 'asc']]
        }));
    });
</script>
@endpush
