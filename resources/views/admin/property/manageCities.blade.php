@extends('admin.layouts.app')
@section('content')
@section('title', 'RentApartments Admin | Manage Cities')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="slim-pagetitle"> Cities Management </h6>
        </div>
        <p class="d-flex justify-content-end">
            <a href="{{ route('admin-add-city')}}" class="btn btn-premium btn-premium-primary">
                <i class="fa fa-plus mr-2"></i> Add Cities
            </a>
        </p>
        <div class="section-wrapper">
            <div class="table-wrapper">
                <table id="managecities" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>City Name</th>
                            <th>State Name</th>
                            <th class="text-center">Status</th>
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
            { data: "cityname", name: "cityname" },
            { data: "statename", name: "statename" },
            { data: "status", name: "status", className: "text-center" },
            { data: "actions", name: "actions", orderable: false, searchable: false, className: "text-center" }
        ];

        const config = DataTableHelpers.getConfig(
            "{{ route('admin-manage-city') }}",
            columns
        );

        $("#managecities").DataTable($.extend(config, {
            order: [[1, 'asc']]
        }));

    });
</script>
@endpush
