@extends('admin/layouts/app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle"> Manage My Agents </h6>
            </div>

            <div class="report-summary-header">
                <div>
                    <a href="{{ route('admin-add-admin-users') }}" class="btn btn-primary"><i
                            class="fa-solid fa-plus mr-2"></i> Add New Agent
                    </a>
                </div>
            </div>

            <div class="section-wrapper mg-t-20">
                <div class="table-responsive">
                    <table class="table table-hover mg-b-0" id="add-admin-agents">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>User Login ID</th>
                                <th>Edit </th>
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
        // function deleteAgent(e) {
        //     var id = e;
        //     // let url = route('admin-delete-agent', id);
        //     console.log("id",url);
        //     //    console.log("dddd",id);
        //     swal({
        //         title: "Are you sure?",
        //         text: "You will not be able to recover this record!",
        //         icon: "warning",
        //         buttons: true,
        //         dangerMode: true,
        //     }).then((willDelete) => {
        //         if (willDelete) {
        //             $.ajax({
        //                 url: "",
        //                 method: "DELETE",
        //                 headers: {
        //                     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
        //                         "content"
        //                     ),
        //                 },
        //                 success: function(response) {
        //                     toastr.success(response.message);
        //                     location.reload();
        //                 },
        //                 error: function() {
        //                     toastr.error(
        //                         "An error occurred while deleting the record."
        //                     );
        //                 },
        //             });
        //         }
        //     });
        // }
    </script>
@endpush
