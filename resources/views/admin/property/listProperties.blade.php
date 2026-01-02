@extends('admin.layouts.app')
@section('content')
@section('title', 'RentApartments Admin | List Properties ')

<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="slim-pagetitle"> List Properties </h6>
        </div>

        <div class="section-wrapper">
            <div class="table-wrapper">
                <table id="listProperty" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-15p">S.no</th>
                            <th class="wd-15p">Property Name</th>
                            <th class="wd-20p">City</th>
                            <th class="wd-15p text-center">Features</th>
                            <th class="wd-10p text-center">Status</th>
                            <th class="wd-25p text-center">Actions</th>
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
            { data: "propertyname", name: "propertyname" },
            { data: "city", name: "city" },
            { data: "features", name: "features" },
            { data: "status", name: "status", className: "text-center" },
            { data: "action", name: "action", orderable: false, searchable: false, className: "text-center" }
        ];

        const config = DataTableHelpers.getConfig(
            "{{ route('admin-property-listproperty') }}",
            columns,
            {
                order: [[1, 'asc']]
            }
        );

        $("#listProperty").DataTable(config);
    });

    function changeStatus(id) {
        // ... existing changeStatus code if needed, but DataTableService uses standard pills now
    }
</script>
@endpush
