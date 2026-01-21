@extends('admin.layouts.app')
@section('content')
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
                <li class="breadcrumb-item active" aria-current="page">Edit School</li>
            </ol>
            <h6 class="slim-pagetitle">Edit School</h6>
        </div>

        <div class="section-wrapper">
            <form id="editSchoolForm">
                @csrf
                <input type="hidden" name="school_id" value="{{ $school->school_id }}">
                <div class="form-group">
                    <label for="schoolName" class="font-weight-bold">School Name</label>
                    <input type="text" class="form-control" id="schoolName" name="school_name" placeholder="Enter school name" value="{{ $school->school_name }}" required>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">School Type</label><br>
                    <div class="d-flex flex-wrap gap-3">
                        @php
                            $types = ['Elementary', 'Middle', 'High', 'District'];
                        @endphp
                        @foreach ($types as $type)
                        <div class="form-check mr-3">
                            <input class="form-check-input" type="radio" name="school_type" id="school_type_{{ $type }}" value="{{ $type }}" {{ $school->school_type == $type ? 'checked' : '' }} required>
                            <label class="form-check-label" for="school_type_{{ $type }}">{{ $type }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-row justify-content-end">
                    <button type="submit" class="btn btn-primary submit-spinner">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('adminscripts')
<script>
    $(document).ready(function() {
        $('#editSchoolForm').validate({
            errorClass: "error",
            validClass: "is-valid",
            rules: {
                school_type: {
                    required: true
                },
                school_name: {
                    required: true
                }
            },
            messages: {
                school_type: {
                    required: "School type is required."
                },
                school_name: {
                    required: "School Name is required."
                }
            },
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                if (element.prop("type") === "radio") {
                    error.insertAfter(element.closest('.form-group').children('div'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            },
            submitHandler: function(form, event) {
                event.preventDefault();
                const formData = $(form).serialize();
                const url = `{{ route('admin-update-school') }}`;
                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $(".submit-spinner").prop("disabled", true).text("Loading...");
                    },
                    success: function(response) {
                        $(".submit-spinner").prop("disabled", false).text("Update");
                        if (response.success) {
                            toastr.success(response.success);
                            // Redirect to list after success
                            setTimeout(function(){
                                window.location.href = "{{ route('admin-school-management') }}";
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        $(".submit-spinner").prop("disabled", false).text("Update");
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error("An error occurred while updating.");
                        }
                    }
                });
            }
        });
    });
</script>
@endpush
