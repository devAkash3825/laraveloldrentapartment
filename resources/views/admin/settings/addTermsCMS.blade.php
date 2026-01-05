@extends('admin.layouts.app')
@push('style')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .form-card {
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .form-label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
    }
</style>
@endpush
@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pages-management') }}">Pages Management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Terms & Conditions</li>
            </ol>
            <h6 class="slim-pagetitle">Add Terms and Conditions</h6>
        </div>
        
        <div class="form-card">
            <form id="addtermsform">
                @csrf
                <div class="form-group mb-4">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter Term Title" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" class="form-control" required></textarea>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <a href="{{ route('pages-management') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary submit-spinner" id="submit-btn" style="min-width: 120px;">Save Changes</button>
                </div>
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
            height: 300,
            toolbar: [
                ['style', ['style', 'clear']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'table', 'hr']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });

        $("#addtermsform").submit(function(e) {
            e.preventDefault();
            var url = "{{ route('admin-create-terms') }}";
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
                    $('.submit-spinner').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Saving...').prop('disabled', true);
                },
                success: function(response) {
                    if (response.success) {
                        AdminToast.success(response.message);
                        $("#addtermsform")[0].reset();
                        $('#description').summernote('reset');
                        setTimeout(function() {
                            window.location.href = "{{ route('pages-management') }}";
                        }, 1500);
                    } else {
                        AdminToast.error(response.message || "Something went wrong");
                    }
                },
                error: function(xhr) {
                    AdminToast.error("An error occurred. Please try again.");
                },
                complete: function() {
                    $('.submit-spinner').html('Save Changes').prop('disabled', false);
                }
            });
            $(this).addClass('was-validated');
        });
    });
</script>
@endpush