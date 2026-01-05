@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage States</li>
                </ol>
                <h6 class="slim-pagetitle">State Management</h6>
            </div>
            <div class="d-flex justify-content-end">
                <p>
                    <a href="{{ route('admin-add-states') }}" class="btn btn-premium btn-premium-primary">
                        <i class="fa fa-plus mr-2"></i> Add States
                    </a>
                </p>
            </div>
            <div class="section-wrapper">
                <div class="table-wrapper">
                    <table id="statemanagement" class="table display responsive nowrap">
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>State Name</th>
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
                { data: "statename", name: "statename" },
                { data: "actions", name: "actions", orderable: false, searchable: false, className: "text-center" }
            ];

            const config = DataTableHelpers.getConfig(
                "{{ route('admin-manage-states') }}",
                columns
            );

            $("#statemanagement").DataTable($.extend(config, {
            order: [[1, 'asc']]
        }));

        });
    </script>
@endpush
