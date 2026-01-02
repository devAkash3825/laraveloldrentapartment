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
                    <li class="breadcrumb-item active" aria-current="page">Manage Pets </li>
                </ol>
                <h6 class="slim-pagetitle">Manage Pets</h6>
            </div>

            <div class="section-wrapper">
                <div class="table-wrapper">
                    <table id="listProperty" class="table display responsive nowrap">
                        <thead>
                            <tr>
                                <th class="wd-15p">S.no</th>
                                <th class="wd-15p">Pets</th>
                                <th class="wd-20p">Status</th>
                                <th class="wd-15p">Edit</th>
                                <th class="wd-10p">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
        {{-- <div class="table-responsive">
            <table class="table mg-b-0 tx-13 table-hover">
                <thead>
                    <tr class="tx-10">
                        <th class="wd-10p pd-y-5 tx-center"><input type="checkbox" id="selectAll"></th>
                        <th class="wd-10p pd-y-5 tx-center">S No</th>
                        <th class="pd-y-5">Pets</th>
                        <th class="pd-y-5 tx-right">Status</th>
                        <th class="pd-y-5 tx-right">Edit</th>
                        <th class="pd-y-5 tx-center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                    <tr>
                        <td class="tx-center"><input type="checkbox" class="selectItem" data-id="{{ $row->id }}"></td>
                        <td class="tx-center">{{$loop->iteration}}</td>
                        <td><a href="" class="tx-inverse tx-medium d-block">{{$row->Pets }}</a></td>
                        <td><a href="" class="tx-inverse tx-medium d-block">{{$row->Status == '1' ? 'Active' : 'InActive' }}</a></td>
                        <td class="valign-middle tx-center">
                            <button class="btn btn-outline-secondary btn-sm edit-single" data-id="{{ $row->id }}"><i class="fa fa-edit"></i></button>
                        </td>
                        <td class="valign-middle tx-center">
                            <button class="btn btn-outline-danger btn-sm delete-single" data-id="{{ $row->id }}"><i class="fa fa-trash"></i></button>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}
    </div>
@endsection
@push('adminscripts')
    <script>
        $(document).ready(function() {
            $(function() {
                try {
                    $("#listProperty").DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('admin-pets-management') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex",
                            },
                            {
                                data: "pets",
                                name: "pets"
                            },
                            {
                                data: "status",
                                name: "status"
                            },
                            {
                                data: "actions",
                                name: "actions"
                            },
                        ],
                    });
                } catch (err) {
                    console.log("Err in datatables", err);
                }
            });
        });
    </script>
@endpush
