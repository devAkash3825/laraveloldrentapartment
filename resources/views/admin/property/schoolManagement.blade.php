@extends('admin.layouts.app')
@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">School Management</li>
            </ol>
            <h6 class="slim-pagetitle"> School Management </h6>
        </div>
        <p class="d-flex justify-content-end">
            <a href="{{ route('admin-school-add')}}" class="btn btn-premium btn-premium-primary">
                <i class="fa fa-plus mr-2"></i> Add School
            </a>
        </p>
        <div class="section-wrapper">
            <div class="table-wrapper">
                <table id="manageschools" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>School Name</th>
                            <th>Type </th>
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
            { data: "schoolname", name: "schoolname" },
            { data: "type", name: "type" },
            { data: "status", name: "status", className: "text-center" },
            { data: "actions", name: "actions", orderable: false, searchable: false, className: "text-center" }
        ];

        const config = DataTableHelpers.getConfig(
            "{{ route('admin-school-management') }}",
            columns
        );

        $("#manageschools").DataTable($.extend(config, {
            order: [[1, 'asc']]
        }));

    });
</script>
@endpush