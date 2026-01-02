@extends('admin.layouts.app')
@section('content')
    <style>
        .form-group .table-icons {
            width: 100%;
        }

        .form-group .table-icons input {
            width: 90% !important;
        }
    </style>
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle">Edit Features </h6>
            </div>

            <div class="section-wrapper">
                <div class="container">
                    <form action="" id="updateFeatureForm">
                        <input type="hidden" name="feature_id" value="{{ $feature->id }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Icon <span class="text-danger">*</span></label>
                                    <div role="iconpicker" data-align="left" data-selected-class="btn-primary"
                                        data-unselected-class="" name="icon" data-icon="{{ $feature->icon }}"></div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Our Feature Title <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="title" value="{{ $feature->title }}">
                                </div>
                                
                                <input type="hidden" name="icons" id="" value="{{ $feature->icon }}">


                                <div class="form-group">
                                    <label for="">Our Feature Sub Title <span class="text-danger"></span></label>
                                    <textarea name="short_description" class="form-control">{{ $feature->short_description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option @selected($feature->status === 1) value="1">Active</option>
                                        <option @selected($feature->status === 0) value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-lg-12 mt-4">
                                <div class="form-layout-footer" style="float: right;">
                                    <button class="btn btn-primary bd-0 submit-spinner" id="submitFeatureBtn"
                                        data-url="{{ route('update-feature', ['id' => $feature->id]) }}">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script>
        $(document).ready(function() {
            $('#submitFeatureBtn').on('click', function(e) {
                e.preventDefault();
                const url = $(this).data('url');
                const form = $('#updateFeatureForm');
                const id = form.find('input[name="feature_id"]').val();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('.submit-spinner').html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Updating...`)
                        $('.submit-spinner').prop('disabled', true);
                    },
                    success: function(response) {
                        console.log('response',response);
                        if (response.success) {
                            toastr.success(" Updated Successfully ");
                        } else {
                            alert('error');
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'An error occurred:\n';
                        for (let field in errors) {
                            errorMessage += `${errors[field][0]}\n`;
                        }
                        $('.submit-spinner').html(`Update`);
                        $('.submit-spinner').prop('disabled',false);
                        toastr.error("There is some error with Updating Record .");
                    },
                    complete: function(){
                    $('.submit-spinner').html(`Update`);
                    $('.submit-spinner').prop('disabled',false);
                }
                });
            });
        });
    </script>
@endpush
