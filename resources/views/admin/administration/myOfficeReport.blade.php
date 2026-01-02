@extends('admin.layouts.app')
@section('content')
@section('title', 'RentApartments Admin | Active Renters')
<style>
    td {
        text-align: center;
    }
</style>
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Active Renters</li>
            </ol>
            <h6 class="slim-pagetitle">My Office Report </h6>
        </div>
        <div class="section-wrapper">
            <div class="table-wrapper">
                <table id="my-office-report" class="table display responsive">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th class="text-center">First Name</th>
                            <th class="text-center">Last Name</th>
                            <th class="text-center">Probability</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Admin</th>
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
        $(function() {
            try {
                $("#my-office-report").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin-my-office-report') }}",
                    columns: [{
                            data: "DT_RowIndex",
                            name: "DT_RowIndex",
                        },
                        {
                            data: "firstname",
                            name: "firstname",
                        },
                        {
                            data: "lastname",
                            name: "lastname",
                        },
                        {
                            data: "probability",
                            name: "probability",
                        },
                        {
                            data: "status",
                            name: "status",
                        },
                        {
                            data: "adminname",
                            name: "adminname",
                        },
                        {
                            data: "actions",
                            name: "actions",
                        },
                    ],
                });
            } catch (err) {
                console.log("Err in datatables", err);
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('click', function(event) {
            if (event.target.closest('.deleteRenter')) {
                const button = event.target.closest('.deleteRenter');
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