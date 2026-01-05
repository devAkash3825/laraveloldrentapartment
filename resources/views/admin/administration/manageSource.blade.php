@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage Source</li>
                </ol>
                <h6 class="slim-pagetitle"> Manage Sources </h6>
            </div>

            <div class="section-wrapper px-1 py-1">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-2 text-right">
                            <a href="{{ route('admin-add-source') }}" class="btn btn-premium btn-premium-primary">
                                <i class="fa-solid fa-plus mr-2"></i> Add New Source
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-wrapper mg-t-20">
                <div class="table-responsive">
                    <table class="table table-hover mg-b-0" id="manage-source">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Source Name</th>
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
                { data: "sourcename", name: "sourcename" },
                { data: "actions", name: "actions", orderable: false, searchable: false, className: "text-center" }
            ];

            const config = DataTableHelpers.getConfig(
                "{{ route('admin-manage-source') }}",
                columns
            );

            $("#manage-source").DataTable($.extend(config, {
                order: [[1, 'asc']]
            }));
        });
    </script>
@endpush
