@extends('admin.layouts.app')
@section('content')
<style>
    td{
        text-align: center;
    }
</style>

<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="slim-pagetitle"> School Management </h6>
        </div>
        <p class="d-flex justify-content-end"><a href="{{ route('admin-school-add')}}" class="btn btn-primary"> Add School </a></p>
        <div class="section-wrapper">
            <div class="table-wrapper">
                <table id="manageschools" class="table display responsive">
                    <thead>
                        <tr>
                            <th class="text-center">S.no</th>
                            <th class="text-center">School Name</th>
                            <th class="text-center">Type </th>
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

@endsection
@push('adminscripts')
<script>
    $(document).ready(function() {
        $("#manageschools").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin-school-management') }}",
            columns: [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex"
                },
                {
                    data: "schoolname",
                    name: "schoolname"
                },
                {
                    data: "type",
                    name: "type"
                },
                {
                    data: "status",
                    name: "status"
                },
                {
                    data: "actions",
                    name: "actions",
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('click', function(event) {
            if (event.target.closest('.deleterecords')) {
                const button = event.target.closest('.deleterecords');
                const id = button.getAttribute('data-id');
                const url = button.getAttribute('data-url');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this record!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute(
                                        'content'),
                                },
                            })
                            .then((response) => {
                                if (!response.ok) {
                                    throw new Error(
                                        'An error occurred while deleting the record.');
                                }
                                return response.json();
                            })
                            .then((data) => {
                                toastr.success(data.message);
                            })
                            .catch((error) => {
                                toastr.error(error.message ||
                                    'An error occurred while deleting the record.');
                            });
                    }
                });
            }
        });
    });
</script>
@endpush