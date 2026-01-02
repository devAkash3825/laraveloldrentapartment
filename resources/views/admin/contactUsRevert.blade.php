@extends('admin/layouts/app')
@section('content')
    <style>
        #search-box {
            position: relative;
            width: 100%;
            margin: 0;
        }

        #search-form {
            height: 40px;
            border: 1px solid #999;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            background-color: #fff;
            overflow: hidden;
        }

        #search-text {
            font-size: 14px;
            color: #ddd;
            border-width: 0;
            background: transparent;
        }

        #search-box input[type="text"] {
            width: 90%;
            padding: 11px 0 12px 1em;
            color: #333;
            outline: none;
        }

        #search-button {
            position: absolute;
            top: 0;
            right: 0;
            height: 42px;
            width: 80px;
            font-size: 14px;
            color: #fff;
            text-align: center;
            line-height: 42px;
            border-width: 0;
            background-color: #4d90fe;
            -webkit-border-radius: 0px 5px 5px 0px;
            -moz-border-radius: 0px 5px 5px 0px;
            border-radius: 0px 5px 5px 0px;
            cursor: pointer;
        }

        .message-box {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .message-input {
            width: 100%;
            height: 60px;
        }

        .btn-send-message {
            display: inline-block;
            float: right;
        }
    </style>
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle">Contact Us Inquiries  </h6>
            </div>
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="section-wrapper mg-t-20">
                        <div class="table">
                            <div class="table-responsive mg-t-20">
                                <table class="table" id="contactusreverts">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>EMail</th>
                                            <th>Subject</th>
                                            <th>Message </th>
                                            <th>Revert</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script>
        $(function() {
            const url = "{{ route('admin-revert-contactus') }}";
            var table = $("#contactusreverts").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:url,
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'subject',
                        name: 'subject',
                    },
                    {
                        data: 'message',
                        name: 'message',
                    },
                    {
                        data: 'revert',
                        name: 'revert',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, "asc"]
                ],
                pageLength: 40,
                dom: "Bfrtip",
                buttons: ["csv"],
            });
            
            $("button:contains('Reset')").on("click", function() {
                $("form")[0].reset();
                table.draw();
            });
            
            $('#exportCsv').on('click', function() {
                let query = {
                    rentername: $("input[name='rentername']").val(),
                    adminname: $("input[name='adminname']").val(),
                    fromsearch: $("input[name='fromsearch']").val(),
                    tosearch: $("input[name='tosearch']").val(),
                };

                let url = `renter-info-update-history/export?${$.param(query)}`;
                window.location.href = url;
            });
        });
        $(document).on('click', '.btn-pending', function() {
            var id = $(this).data('id');
            $('#message-box-' + id).toggle();
        });


        $(document).on('click', '.btn-send-message', function() {
            var id = $(this).data('id');
            var message = $('#message-input-' + id).val();
            const url = "{{ route('admin-revert-contactus') }}";

            if (message.trim() === '') {
                alert('Please enter a message before submitting.');
                return;
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), // CSRF Token
                    id: id,
                    message: message
                },
                success: function(response) {
                    if (response.success) {
                        $('#message-box-' + id).hide();
                        $('#message-input-' + id).val('');
                        $('.btn-pending[data-id="' + id + '"]').replaceWith(
                            '<span class="badge badge-success">Reverted</span>');
                    } else {
                        alert('Something went wrong, please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });
    </script>
@endpush
