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
                <form action="">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-layout-footer p-2" style="float: right;">
                                <a href="{{ route('admin-add-source') }}" class="btn btn-primary btn-block">
                                    <i class="fa-solid fa-plus"></i> Add New Source </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="section-wrapper mg-t-20">
                <div class="table-responsive">
                    <table class="table table-hover mg-b-0" id="manage-source">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Source Name</th>
                                <th>Actions</th>
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
        
    </script>
@endpush
