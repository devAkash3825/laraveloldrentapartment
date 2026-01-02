@extends('admin.layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="slim-pagetitle">Add Company </h6>
        </div>

        <div class="section-wrapper">
            <form id="agentForm" novalidate>
                
                <div class="form-group row">
                    <label for="userName" class="col-md-2 col-form-label"> Meta Content Description </label>
                    <div class="col-md-10">
                        <textarea class="form-control" id="metacontent" name="metacontent"></textarea>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="userName" class="col-md-2 col-form-label"> Meta Keyword Description </label>
                    <div class="col-md-10">
                        <textarea class="form-control" id="metacontent" name="metacontent"></textarea>
                    </div>
                </div>
                
                
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Upload Logo </label>
                    <div class="col-sm-10">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile2">
                            <label class="custom-file-label custom-file-label-primary" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_confirmation" class="col-sm-2 col-form-label">URL</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="url" name="url">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password_confirmation" class="col-sm-2 col-form-label">Alt Text</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="alttext" name="alttext">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password_confirmation" class="col-sm-2 col-form-label"> Position </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="position" name="position" value="0">
                    </div>
                </div>
                
                <div class="form-group row mt-1">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary float-right">Add Company</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#agentForm').on('submit', function(event) {
            event.preventDefault();

            // Check for password match
            let password = $('#password').val();
            let password_confirmation = $('#password_confirmation').val();

            if (password !== password_confirmation) {
                $('#password_confirmation').addClass('is-invalid');
                return;
            } else {
                $('#password_confirmation').removeClass('is-invalid');
            }

            // Perform front-end validation
            if (this.checkValidity() === false) {
                event.stopPropagation();
                $(this).addClass('was-validated');
            } else {

                $.ajax({
                    url: '{{ route("admin-create-manager") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success('Manager Created !');
                        $('#agentForm')[0].reset();
                        $('#agentForm').removeClass('was-validated');
                    },
                    error: function(response) {
                        toastr.error('An error occurred while submitting the form.');
                    }
                });
            }
        });
    });
</script>
@endsection
