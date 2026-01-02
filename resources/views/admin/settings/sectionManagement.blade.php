@extends('admin.layouts.app')
@section('content')
@push('style')
<link rel="stylesheet" href="{{ asset('admin_asset/css/tabview.css') }}">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.3.0/css/bootstrap-colorpicker.min.css">
<style>
    .image-preview,
    #callback-preview {
        width: 250px;
        height: 250px;
        border: 2px dashed #ddd;
        border-radius: 3px;
        position: relative;
        overflow: hidden;
        background-color: #ffffff;
        color: #ecf0f1;
    }

    .image-preview,
    #callback-preview:hover {
        /* background-color: black; */
        cursor: pointer;
    }

    .image-preview input,
    #callback-preview input {
        line-height: 200px;
        font-size: 200px;
        position: absolute;
        opacity: 0;
        z-index: 10;
        cursor: pointer;
    }

    .image-hover-label {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        justify-content: center;
        align-items: center;
        font-size: 16px;
        cursor: pointer;
    }

    .image-preview:hover .image-hover-label {
        display: flex;
    }
</style>
@endpush
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="slim-pagetitle"> Sections Management </h6>
        </div>
        <div class="section-wrapper">
            <nav>
                <ul class="tabs">
                    <li class="tab-li">
                        <a href="#ourfeatures" class="tab-li__link">Our Features </a>
                    </li>
                    <li class="tab-li">
                        <a href="#countermanagement" class="tab-li__link">Counter </a>
                    </li>
                    <li class="tab-li">
                        <a href="#sectiontitles" class="tab-li__link">Section Titles </a>
                    </li>
                </ul>
            </nav>

            <section id="ourfeatures" data-tab-content class="p-0">
                <div class="container">

                    <form id="addourfeatures" novalidate="">
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Icon <span class="text-danger">*</span></label>
                                    <div role="iconpicker" data-align="left" data-selected-class="btn-primary"
                                        data-unselected-class="" name="icon" required></div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Our Feature Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="our_feature_title" value=""
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="">Our Feature Sub Title <span
                                            class="text-danger">*</span></label>
                                    <textarea name="our_feature_sub_title" class="form-control" required></textarea>
                                    <div id="charCountMessage" class="text-muted">Character Count: 0 / 100</div>
                                    <div id="charLimitErrorMessage" class="text-danger" style="display: none;">
                                        Limit exceeded! Please limit to 100 characters.</div>
                                </div>

                                <div class="form-group">
                                    <label for="">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="2">InActive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mt-4">
                                <div class="form-layout-footer" style="float: right;">
                                    <button type="submit" class="btn btn-primary bd-0 submit-spinner" id="add-features">Create</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <hr>
                <div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-colored bg-primary">
                                <tr>
                                    <th class="wd-10p">ID</th>
                                    <th class="wd-35p">Icon</th>
                                    <th class="wd-35p">Title</th>
                                    <th class="wd-20p">Status</th>
                                    <th class="wd-20p">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ourFeatures as $feature)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td><i class="{{ $feature->icon }}"></i></td>
                                    <td>{{ $feature->title }}</td>
                                    <td><a href="javascript:void(0)"
                                            class="c-pill {{ $feature->status == 1 ? 'c-pill--success' : 'c-pill--warning' }}">
                                            {{ $feature->Status == 1 ? 'Active' : 'Inactive' }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="table-actionss-icon table-actions-icons float-left">
                                            <a href="{{ route('edit-feature', ['id' => $feature->id]) }}"
                                                class="edit-btn">
                                                <i
                                                    class="fa-solid fa-pen px-2 py-2 edit-icon border px-2 py-2 edit-icon"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="delete-btn"
                                                data-id="{{ $feature->id }}"
                                                data-url="{{ route('delete-feature', ['id' => $feature->id]) }}">
                                                <i class="fa-solid fa-trash px-2 py-2 delete-icon border"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="countermanagement" data-tab-content class="p-0">
                <div class="row row-sm mt-5">
                    <div class="col-lg-12">
                        <div class="manager-left">
                            <nav class="nav">
                                <a href="javascript:void(0)" class="nav-link ">
                                    <span class="font-weight-bold"> Total Properties in System </span>
                                    <span>{{ $totalproperty }}</span>
                                </a>
                                <a href="javascript:void(0)" class="nav-link ">
                                    <span class="font-weight-bold">Properties Added in Last one week</span>
                                    <span></span>
                                </a>
                                <a href="javascript:void(0)" class="nav-link">
                                    <span class="font-weight-bold">Total Active Properties in system</span>
                                    <span>{{ $activeProperty }}</span>
                                </a>
                                <a href="javascript:void(0)" class="nav-link">
                                    <span class="font-weight-bold">Total Inactive Properties in system</span>
                                    <span>{{ $inactiveProperty }}</span>
                                </a>
                                <a href="javascript:void(0)" class="nav-link">
                                    <span class="font-weight-bold">Total Users</span>
                                    <span>{{ $totalUser }}</span>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <form action="" id="addcounter" method="POST" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Background Image </label>
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-favicon-preview" id="image-label" class="image-hover-label">Choose File</label>
                                        <input type="file" name="background" id="image-upload" />
                                        <input type="hidden" name="old_background" value="{{ @$counter->background }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Counter One </label>
                                        <input type="text" class="form-control" name="counter_one"
                                            value="{{ @$counter->counter_one }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Counter Title One </label>
                                        <input type="text" class="form-control" name="counter_title_one"
                                            value="{{ @$counter->counter_title_one }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Counter Two </label>
                                        <input type="text" class="form-control" name="counter_two"
                                            value="{{ @$counter->counter_two }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Counter Title Two </label>
                                        <input type="text" class="form-control" name="counter_title_two"
                                            value="{{ @$counter->counter_title_two }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Counter Three </label>
                                        <input type="text" class="form-control" name="counter_three"
                                            value="{{ @$counter->counter_three }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Counter Title Three </label>
                                        <input type="text" class="form-control" name="counter_title_three"
                                            value="{{ @$counter->counter_title_three }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Counter Four </label>
                                        <input type="text" class="form-control" name="counter_four"
                                            value="{{ @$counter->counter_four }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Counter Title Four </label>
                                        <input type="text" class="form-control" name="counter_title_four"
                                            value="{{ @$counter->counter_title_four }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <div class="form-layout-footer" style="float: right;">
                                        <button type="submit" class="btn btn-primary bd-0 submit-spinner"
                                            id="add-counter">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <section id="sectiontitles" data-tab-content class="p-0">
                <div class="row mt-4">
                    <div class="col-12">
                        <form action="" method="POST" enctype="multipart/form-data" id="updatesectiontitles">

                            <h6>Our Feature:</h6>
                            <div class="form-group">
                                <input type="text" class="form-control" name="our_feature_title"
                                    value="{{ $title?->our_feature_title }}">
                            </div>
                            <h6>Our Feature Sub Title:</h6>
                            <div class="form-group">
                                <textarea name="our_feature_sub_title" class="form-control">{{ $title?->our_feature_sub_title }}</textarea>
                            </div>

                            <hr>


                            <h6>Our Featured Listing Title :</h6>
                            <div class="form-group">
                                <input type="text" class="form-control" name="our_featured_listing_title"
                                    value="{{ $title?->our_featured_listing_title }}">
                            </div>

                            <h6>Our Featured Listing Sub Title:</h6>
                            <div class="form-group">
                                <textarea name="our_featured_listing_sub_title" class="form-control">{{ $title?->our_featured_listing_sub_title }}</textarea>
                            </div>

                            

                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <div class="form-layout-footer" style="float: right;">
                                        <button type="submit" class="btn btn-primary bd-0 submit-spinner"
                                            id="update-titles"> Update </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection
@push('adminscripts')
<script src="{{ asset('admin_asset/js/tabviewform.js') }}"></script>
<script src="{{ asset('admin_asset/js/jquery.uploadPreview.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.3.0/js/bootstrap-colorpicker.min.js">
</script>

<script>
    // var ImageData = e.target.result
    $(document).ready(function() {
        // This is Working Fine
        $("#addourfeatures").submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            if (this.checkValidity() === false) {
                e.stopPropagation(); // Stop form submission if the form is invalid
            } else {
                var url = "{{ route('add-feature') }}";
                var formData = $(this).serialize();

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('.submit-spinner').html(
                            `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Creating...`
                        );
                        $('.submit-spinner').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success("Created Successfully");
                            $("#addourfeatures")[0].reset();
                            $('.submit-spinner').html(`Create`);
                            $('.submit-spinner').prop('disabled', false);
                        } else {
                            if (response.errors) {
                                toastr.error("Not Created");
                            }
                        }
                    },
                    error: function(xhr) {
                        toastr.error("An error occurred. Please try again.");
                        $('.submit-spinner').html(`Create`);
                        $('.submit-spinner').prop('disabled', false);
                    },
                });
            }
            $(this).addClass('was-validated');
        });

        $('#image-preview').css({
            'background-image': `url({{ asset(@$counter->background) }})`,
            'background-size': 'contain',
            'background-position': 'center center',
            'background-repeat': 'no-repeat',
        });

        $('#image-upload').on('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').css('background-image', `url(${e.target.result})`);
                };
                reader.readAsDataURL(file);
            }
        });


        $(".table-icons input").attr("required", "required");

        $('textarea[name="our_feature_sub_title"]').on("input", function() {
            var text = $(this).val();
            var charCount = text.length;

            $("#charCountMessage").text("Character Count: " + charCount + " / 100");

            if (charCount > 100) {
                $(this).val(text.substring(0, 100));
                $("#charCountMessage").css("color", "red");
                $("#charLimitErrorMessage").show();
            } else {
                $("#charCountMessage").css("color", "black");
                $("#charLimitErrorMessage").hide();
            }
        });



        $('.delete-btn').on('click', function() {
            var id = $(this).data('id');
            var url = $(this).data('url');
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this record!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: url,
                            method: 'Post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                toastr.success(response.message);
                                location.reload();
                            },
                            error: function() {
                                toastr.error(
                                    'An error occurred while deleting the record.'
                                );
                            }
                        });
                    }
                });
        });

        $("#addcounter").submit(function(e) {
            e.preventDefault();
            if (this.checkValidity() === false) {
                event.stopPropagation();
            } else {
                var url = "{{ route('update-counter') }}";

                var formData = $(this).serialize();
                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('.submit-spinner').html(
                            `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Creating...`
                        )
                        $('.submit-spinner').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.message) {
                            toastr.success(response.message);
                            $("#updatesectiontitles")[0].reset();
                            $('.submit-spinner').html(`Create`)
                            $('.submit-spinner').prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        toastr.error("An error occurred. Please try again.");
                        $('.submit-spinner').html(
                            `Create`
                        )
                        $('.submit-spinner').prop('disabled', false);
                    },
                });
            }
            $(this).addClass('was-validated');
        });

        $("#updatesectiontitles").submit(function(e) {
            e.preventDefault();
            if (this.checkValidity() === false) {
                event.stopPropagation();
            } else {
                var url = "{{ route('admin-update-section-titles') }}";
                var formData = $(this).serialize();
                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('.submit-spinner').html(
                            `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Creating...`
                        )
                        $('.submit-spinner').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.message) {
                            toastr.success(response.message);
                            $("#updatesectiontitles")[0].reset();
                            $('.submit-spinner').html(`Create`)
                            $('.submit-spinner').prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        toastr.error(response.message);
                        $('.submit-spinner').html(`Update`)
                        $('.submit-spinner').prop('disabled', false);
                    },
                });
            }
            $(this).addClass('was-validated');
        });


        // $("#addourfeatures").submit(function(e) {
        //     e.preventDefault();
        //     alert('ddd');
        //     if (this.checkValidity() === false) {
        //         event.stopPropagation();
        //     } else {
        //         var url = "{{ route('add-feature') }}";
        //         var formData = $(this).serialize();
        //         $.ajax({
        //             url: url,
        //             type: "POST",
        //             data: formData,
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             beforeSend: function() {
        //                 $('.submit-spinner').html(
        //                     `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Creating...`
        //                 )
        //                 $('.submit-spinner').prop('disabled', true);
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     toastr.success(" Created Successfully ");
        //                     $("#addourfeatures")[0].reset();
        //                     $('.submit-spinner').html(
        //                         `Create`
        //                     )
        //                     $('.submit-spinner').prop('disabled', false);
        //                 } else {
        //                     if (response.errors) {
        //                         toastr.error(" Not Created ");
        //                     }
        //                 }
        //             },
        //             error: function(xhr) {
        //                 toastr.error("An error occurred. Please try again.");
        //                 $('.submit-spinner').html(
        //                     `Create`
        //                 )
        //                 $('.submit-spinner').prop('disabled', false);
        //             },
        //         });
        //     }
        //     $(this).addClass('was-validated');
        // });




    });
</script>
@endpush