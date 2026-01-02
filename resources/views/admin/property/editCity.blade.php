@extends('admin.layouts.app')
@section('content')
@section('title', 'RentApartments Admin | Edit Cities')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit States </li>
            </ol>
            <h6 class="slim-pagetitle">Edit City </h6>
        </div>

        <div class="section-wrapper">
            <form id="editcityform" novalidate="">
                <div class="form-row">
                    <input type="hidden" name="cityid" id="cityid" value="{{$city->Id}}">
                    <div class="form-group col-lg-12 col-md-12 col-12">
                        <label for="stateid" class="font-weight-bold"> Select State <span class="text-danger"> *
                            </span></label>
                        <select class="form-control" id="stateid" name="stateid" required>
                            @foreach($state as $row)
                            <option value="{{ $row->Id }}" {{ $row->Id == $city->StateId ? 'selected' : '' }}>
                                {{ $row->StateName }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    

                    <div class="form-group col-lg-6 col-md-6 col-12">
                        <label for="userName" class="font-weight-bold"> City Name <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cityname" name="cityname" value="{{$city->CityName}}" required>
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-12">
                        <label for="emailId" class="font-weight-bold"> Short Name 
                        </label>
                        <input type="email" class="form-control" id="shortName" name="shortName" value="{{$city->shortName}}">
                    </div>

                    <div class="form-group col-lg-12 col-md-12 col-12">
                        <label for="status" class="font-weight-bold">City Status </label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="1" {{ $city->Status == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ $city->Status == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-12 col-md-12 col-12">
                        <label for="emailId" class="font-weight-bold"> City Rent 
                        </label>
                        <textarea class="form-control" id="cityrent" name="cityrent" value="{{ $city->cityrent }}">{!! $city->cityrent !!}</textarea>
                    </div>


                </div>
                <div class="form-row justify-content-end">
                    <button type="submit" class="btn btn-primary submit-spinner">Edit City</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('adminscripts')
<script>
    $(document).ready(function() {
        $('#editcityform').validate({
            errorClass: "error",
            validClass: "is-valid",
            rules: {
                stateid: {
                    required: true
                },
                cityname: {
                    required: true
                }
            },
            messages: {
                stateid: {
                    required: "State is required."
                },
                cityname: {
                    required: "City Name is required."
                }
            },
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                error.insertAfter(element);
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
                const url = `{{ route('admin-update-city') }}`;
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
                        $(".submit-spinner").prop("disabled", false).text("Edit City");
                        if (response.success) {
                            toastr.success(response.messages);
                        }
                    },
                    error: function(xhr) {
                        $(".submit-spinner").prop("disabled", false).text("Edit City");
                        if (xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error("An error occurred while saving.");
                        }
                    }
                });
            }
        });
    });
</script>

@endpush