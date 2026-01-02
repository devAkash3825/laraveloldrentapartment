@extends('admin.layouts.app')
@push('style')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush
@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="slim-pagetitle"> Add Manager Terms </h6>
        </div>
        <div class="section-wrapper">
            <form id="addmanagerterms" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" id="title" class="form-control" value="" required>
                </div>

                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description" id="description" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-3 submit-spinner" id="submit-btn">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
@push('adminscripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {

        $('#description').summernote({
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style', 'clear']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        $("#addmanagerterms").submit(function(e) {
            e.preventDefault();

            var url = "{{ route('admin-create-manager-terms') }}";
            var formData = new FormData(this);

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.submit-spinner').html(
                        `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Updating...`
                    );
                    $('.submit-spinner').prop('disabled', true);
                },
                success: function(response) {
                    if (response.message) {
                        toastr.success(response.message);
                        $("#updateaboutus")[0].reset();
                        $('.submit-spinner').html(`Update`);
                        $('.submit-spinner').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    toastr.error("An error occurred. Please try again.");
                    $('.submit-spinner').html(`Update`);
                    $('.submit-spinner').prop('disabled', false);
                },
            });

            $(this).addClass('was-validated');
        });

    });
</script>
@endpush