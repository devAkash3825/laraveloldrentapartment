@extends('admin/layouts/app')
@section('content')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <div class="slim-mainpanel">

        <div class="container">

            <div class="slim-pageheader">
                <h6 class="slim-pagetitle float-left">Manage Company </h6>
            </div>
               
            <div class="section-wrapper">
               
                <div class="table-wrapper">
                    <div class="card-header mb-3 bg-white border d-flex">
                        <button class="btn btn-primary">Add Company</button>
                    </div>
                    <table id="listofmanagers" class="table display responsive">
                        <thead>
                            <tr>
                                <th> Company Logo</th>
                                <th> Status </th>
                                <th> Position </th>
                                <th> Actions </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
@endsection
