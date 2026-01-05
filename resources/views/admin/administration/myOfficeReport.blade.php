@extends('admin.layouts.app')
@section('content')
@section('title', 'RentApartments Admin | Active Renters')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Office Report</li>
            </ol>
            <h6 class="slim-pagetitle">My Office Report</h6>
        </div>
        <div class="section-wrapper">
            <div class="table-wrapper">
                <table id="my-office-report" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th class="text-center">Probability</th>
                            <th class="text-center">Status</th>
                            <th>Admin</th>
                            <th class="text-center">Actions</th>
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
        const columns = [
            { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false },
            { data: "firstname", name: "firstname" },
            { data: "lastname", name: "lastname" },
            { data: "probability", name: "probability", className: "text-center" },
            { data: "status", name: "status", className: "text-center" },
            { data: "adminname", name: "adminname" },
            { data: "actions", name: "actions", orderable: false, searchable: false, className: "text-center" }
        ];

        const config = DataTableHelpers.getConfig(
            "{{ route('admin-my-office-report') }}",
            columns
        );

        $("#my-office-report").DataTable($.extend(config, {
            order: [[1, 'asc']]
        }));

    });
</script>
@endpush