@extends('admin/layouts/app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle"> Manage My Agents </h6>
            </div>

            <div class="report-summary-header">
                <div>
                    <a href="{{ route('admin-add-admin-users') }}" class="btn btn-premium btn-premium-primary">
                        <i class="fa-solid fa-plus mr-2"></i> Add New Agent
                    </a>
                </div>
            </div>

            <div class="section-wrapper mg-t-20">
                <div class="table-responsive">
                    <table class="table table-hover mg-b-0" id="add-admin-agents">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>User Login ID</th>
                                <th class="text-center">Edit</th>
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
                { data: "username", name: "username" },
                { data: "userloginid", name: "userloginid" },
                { data: "edit", name: "edit", orderable: false, searchable: false, className: "text-center" }
            ];

            const config = DataTableHelpers.getConfig(
                "{{ route('admin-manage-my-agents') }}",
                columns
            );

            $("#add-admin-agents").DataTable($.extend(config, {
                order: [[1, 'asc']]
            }));
        });
    </script>
@endpush
