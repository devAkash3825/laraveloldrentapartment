@extends('admin.layouts.app')
@section('content')
    <style>
        .wd-25p {
            text-align: center;
        }

        .dataTables_filter label {
            display: flex;
        }
    </style>
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage States </li>
                </ol>
                <h6 class="slim-pagetitle">Manage States</h6>
            </div>
            <div class="d-flex justify-content-end">
                <p><a href="{{ route('admin-add-states') }}" class="btn btn-primary"> Add States</a></p>
            </div>
            <div class="section-wrapper">
                <div class="table-wrapper">
                    <table id="statemanagement" class="table display responsive nowrap">
                        <thead>
                            <tr>
                                <th class="wd-15p">S.no</th>
                                <th class="wd-15p">State Name</th>
                                <th class="wd-25p text-align-center">Actions</th>
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
        $(function() {
            try {
                $("#statemanagement").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin-manage-states')}}",
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex",
                        },
                        {
                            data: "statename",
                            name: "statename",
                        },
                        {
                            data: "actions",
                            name: "actions",
                        },
                    ],
                });
            } catch (err) {
                console.log("err", err);
            }
        });
    </script>
@endpush
