@extends('admin/layouts/app')
@section('content')
    <style>
        .drop-zone {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
        }

        .drop-zone.highlight {
            background-color: #eaf6ff;
        }

        #preview {
            width: 100%;
            height: auto;
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .preview-item {
            width: 300px;
            height: 200px;
            border: 1px solid #ccc;
            margin: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .preview-item img,
        .preview-item video {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
    </style>
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle">Add Property </h6>
            </div>

            <div class="section-wrapper">
                <form id="propertyForm" novalidate class="needs-validation" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="userName" class="f-600">User Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select class="form-control" id="username" name="username" required>
                                    <option value="">- SELECT USERNAME -</option>
                                    @foreach ($listofManagers as $row)
                                        <option value="{{ $row->Id }}">{{ $row->UserName }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please enter a user name.
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="propertyName" class="f-600">Property Name <span class="text-danger"> *
                                </span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="propertyName" name="propertyName"
                                    placeholder="Enter Property Name" required>
                                <div class="invalid-feedback">
                                    Please enter a property name.
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="title" class="f-600">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Enter Title">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="managementCompany" class="f-600">Management Company <span class="text-danger"> *
                                </span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="managementCompany" name="managementCompany"
                                    required>
                                <div class="invalid-feedback">
                                    Please enter the management company name.
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="propertyContact" class="f-600">Property Contact <span class="text-danger"> *
                                </span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="propertyContact" name="propertyContact"
                                    required>
                                <div class="invalid-feedback">
                                    Please enter the property contact.
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="numberOfUnits" class="f-600">Number of Units <span class="text-danger"> *
                                </span></label>
                            <input type="number" class="form-control" id="numberOfUnits" name="numberOfUnits" required>
                            <div class="invalid-feedback">
                                Please enter the number of units.
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="yearBuilt" class="f-600">Year Built <span class="text-danger"> * </span></label>
                            <select id="yearBuilt" class="form-control" name="year" required>
                                <option value="" selected> Select Year </option>
                            </select>
                            <div class="invalid-feedback">
                                Please select the year built.
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="yearRemodeled" class="f-600">Year Remodeled</label>
                            <select id="yearRemodeled" class="form-control" name="yearremodeled" disabled>
                                <option value="" selected> Select Year </option>
                            </select>
                            <div class="invalid-feedback">
                                Please select the year remodeled.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="address" class="f-600">Address <span class="text-danger"> * </span></label>
                            <textarea rows="3" class="form-control" placeholder="Textarea" id="address" name="address" required></textarea>
                            <div class="invalid-feedback">
                                Please enter the address.
                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="leasingEmail" class="f-600">Leasing Email <span class="text-danger"> *
                                </span></label>
                            <input type="email" class="form-control" id="leasingEmail" name="leasingEmail" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="state" class="f-600">State <span class="text-danger"> * </span></label>
                            <select class="form-control" id="select-state" name="state" required>
                                <option value="">- SELECT STATE -</option>
                                @foreach ($state as $row)
                                    <option value="{{ $row->Id }}">{{ $row->StateName }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Please select a state.
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="city" class="f-600">City <span class="text-danger"> * </span></label>
                            <select class="form-control" id="select-city" name="city" required>
                                <option value="">- SELECT CITY -</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a city.
                            </div>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="area" class="f-600">Area <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control" id="area" name="area" required>
                            <div class="invalid-feedback">
                                Please enter the area.
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="zone" class="f-600">Zone <span class="text-danger"> * </span></label>
                            <select class="form-control" id="zone" name="zone" required>
                                <option value="">Select zone</option>
                                @foreach ($zones as $zone)
                                    <option value="{{ $zone->id }}">{{ $zone->Zone }}</option>
                                @endforeach

                            </select>
                            <div class="invalid-feedback">
                                Please select a zone.
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="zipCode" class="f-600">Zip Code <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control" id="zipCode" name="zipCode" required>
                            <div class="invalid-feedback">
                                Please enter the zip code.
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="latitude" class="f-600">Status</label>
                            <select class="form-control" id="status" name="statuss" required>
                                <option value="">Select Status </option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            <div class="invalid-feedback">
                                Please Select Status
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="longitude" class="f-600">Featured</label>
                            <select class="form-control" id="featured" name="featured" required>
                                <option value="">Select Featured </option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            <div class="invalid-feedback">
                                Please Select Featured Status
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="contactNo" class="f-600">Contact No <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control" id="contactNo" name="contactNo" required>
                            <div class="invalid-feedback">
                                Please enter a contact number.
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="fax" class="f-600">Fax</label>
                            <input type="text" class="form-control" id="fax" name="fax">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="website" class="f-600">Web Site</label>
                            <input type="url" class="form-control" id="website" name="website">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="officeHours" class="f-600">Office Hours</label>
                            <input type="text" class="form-control" id="officeHours" name="officeHours">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="officeHours" class="f-600">Embedded Map </label>
                            <input type="text" class="form-control" id="embddedmap" name="embddedmap">
                        </div>
                    </div>
                    <div class="form-row col-md-3">
                        <label for="website" class="f-600">Upload Default Image </label>
                        <div class="border p-2">
                            <input type="file" id="file-input" name="default-image" accept="image/*, video/*"
                                multiple>
                            <div class="drop-zone mt-2" id="drop-zone">
                                <span>Drag and drop files here</span>
                            </div>
                            <div id="preview"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary float-right submit-spinner"> Create </button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const yearBuiltSelect = document.getElementById('yearBuilt');
            const yearRemodeledSelect = document.getElementById('yearRemodeled');
            const currentYear = new Date().getFullYear();
            const startYear = currentYear - 100;
            const endYear = currentYear + 10;

            for (let year = startYear; year <= currentYear; year++) {
                let option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearBuiltSelect.appendChild(option);
            }

            yearBuiltSelect.addEventListener('change', function() {
                const selectedYearBuilt = parseInt(this.value);

                yearRemodeledSelect.innerHTML = '';

                for (let year = selectedYearBuilt; year <= currentYear; year++) {
                    let option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    yearRemodeledSelect.appendChild(option);
                }

                yearRemodeledSelect.disabled = false;
            });
        });

        var fileInput = document.getElementById('file-input');
        var dropZone = document.getElementById('drop-zone');
        var preview = document.getElementById('preview');

        fileInput.addEventListener('change', function() {
            displayFiles(this.files);
        });

        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropZone.classList.add('highlight');
        });

        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            dropZone.classList.remove('highlight');
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            dropZone.classList.remove('highlight');
            var droppedFiles = e.dataTransfer.files;
            fileInput.files = droppedFiles;
            displayFiles(droppedFiles);
        });

        function displayFiles(files) {
            preview.innerHTML = '';

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();

                reader.onload = (function(file) {
                    return function(e) {
                        var fileType = file.type.split('/')[0];
                        var previewItem = document.createElement('div');
                        previewItem.className = 'preview-item';
                        var previewElement;

                        if (fileType === 'image') {
                            previewElement = document.createElement('img');
                        } else if (fileType === 'video') {
                            previewElement = document.createElement('video');
                            previewElement.controls = true;
                        } else {
                            return; // Unsupported file type
                        }

                        previewElement.src = e.target.result;
                        previewItem.appendChild(previewElement);
                        preview.appendChild(previewItem);
                    };
                })(file);

                reader.readAsDataURL(file);
            }
        }

        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        $(document).ready(function() {
            $('#propertyForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin-submit-property') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    beforeSend: function() {
                        $('.submit-spinner').html(
                            `<span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                            <span role="status">Creating...</span>`
                        );
                        $('.submit-spinner').prop('disabled', true);
                    },
                    success: function(response) {
                        $('#propertyForm')[0].reset();
                        toastr.success(response.message);
                        $("#addourfeatures")[0].reset();
                        $('.submit-spinner').html(`Create`);
                        $('.submit-spinner').prop('disabled', false);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = "";
                            for (let field in errors) {
                                toastr.error(errors[field][0])
                            }
                        } else {
                            toastr.error("Something went wrong. Please try again later.")
                        }
                    },
                    complete: function() {
                        $('.submit-spinner').html(`Create`);
                        $('.submit-spinner').prop('disabled', false);
                    },
                });
            });
        });
    </script>
@endpush
