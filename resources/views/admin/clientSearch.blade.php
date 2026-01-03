@extends('admin.layouts.app')
@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Client Search</li>
            </ol>
            <h6 class="slim-pagetitle">Search Results @if(request('search')) for "{{ request('search') }}" @endif</h6>
        </div>

        <div class="section-wrapper">
            <div class="table-wrapper">
                <table id="client-search-results" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Status</th>
                            <th>Admin</th>
                            <th class="text-center">Action</th>
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
        const searchVal = "{{ request('search') }}";
        
        $('#client-search-results').DataTable(DataTableHelpers.getConfig("{{ route('admin-client-search') }}", [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "firstname", name: "renterinfo.Firstname" },
            { data: "lastname", name: "renterinfo.Lastname" },
            { data: "status", name: "Status", orderable: false, searchable: false },
            { data: "adminname", name: "adminname", orderable: false },
            { data: "actions", name: "actions", orderable: false, searchable: false }
        ], {
            ajax: {
                url: "{{ route('admin-client-search') }}",
                data: function(d) {
                    d.search = searchVal;
                }
            }
        }));
    });
</script>
@endpush
