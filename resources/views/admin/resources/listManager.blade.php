@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List Managers</li>
                </ol>
                <h6 class="slim-pagetitle">Manager List</h6>
            </div>

            <div class="section-wrapper">
                <div class="table-wrapper">
                    <table id="listofmanagers-table" class="table display responsive nowrap">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Manager Name</th>
                                <th>Status</th>
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
        $('#listofmanagers-table').DataTable(DataTableHelpers.getConfig("{{ route('admin-list-manager') }}", [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "managername", name: "UserName" },
            { data: "status", name: "Status", orderable: false, searchable: false },
            { data: "action", name: "action", orderable: false, searchable: false }
        ]));
    });
</script>
@endpush
