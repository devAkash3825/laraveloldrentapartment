@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List Managers </li>
                </ol>
                <h6 class="slim-pagetitle">Manager List </h6>
            </div>

            <div class="section-wrapper">
                <div class="table-wrapper">
                    <table id="listofmanagers" class="table display responsive">
                        <thead>
                            <tr>
                                <th> Id</th>
                                <th> Manager Name </th>
                                <th> Status </th>
                                <th class="justify-content-center"> Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
