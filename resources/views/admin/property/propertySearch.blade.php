@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Search Property</li>
                </ol>
                <h6 class="slim-pagetitle">Property Search</h6>
            </div>

            <div>
                <div class="section-wrapper">
                    <div class="table-responsive">
                        <table id="propertyTable" class="display">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Property Name</th>
                                    <th>City</th>
                                    <th class="text-center">Features</th>
                                    <th class="text-center">Status</th>
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
    </div>
@endsection
@push('adminscripts')
    <script>
        $(document).ready(function() {
            const columns = [
                { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false },
                { data: "propertyname", name: "propertyname" },
                { data: "city", name: "city" },
                { data: "features", name: "features", className: "text-center" },
                { data: "status", name: "status", className: "text-center" },
                { data: "action", name: "action", orderable: false, searchable: false, className: "text-center" }
            ];

            const ajaxUrl = {
                url: "{{ route('admin-property-search') }}",
                data: function(d) {
                    d.propertysearch = "{{ $searchText ?? '' }}";
                }
            };

            const config = DataTableHelpers.getConfig(
                ajaxUrl,
                columns,
                {
                    order: [[1, 'asc']]
                }
            );

            $('#propertyTable').DataTable(config);
        });
    </script>
@endpush
