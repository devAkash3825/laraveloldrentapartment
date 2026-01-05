@extends('admin/layouts/app')
@section('title', 'RentApartments Admin | Add New Property')
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
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="propertyForm" action="{{ route('admin-submit-property') }}" method="POST" class="needs-validation" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="userName" class="f-600">User Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select class="form-control @error('username') is-invalid @enderror" id="username" name="username" required>
                                    <option value="">- SELECT USERNAME -</option>
                                    @foreach ($listofManagers as $row)
                                        <option value="{{ $row->Id }}" {{ old('username') == $row->Id ? 'selected' : '' }}>{{ $row->UserName }}</option>
                                    @endforeach
                                </select>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please select a user name.</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="propertyName" class="f-600">Property Name <span class="text-danger"> * </span></label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('propertyName') is-invalid @enderror" id="propertyName" name="propertyName"
                                    placeholder="Enter Property Name" value="{{ old('propertyName') }}" required>
                                @error('propertyName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please enter a property name.</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="title" class="f-600">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                                placeholder="Enter Title">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="managementCompany" class="f-600">Management Company <span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('managementCompany') is-invalid @enderror" id="managementCompany" name="managementCompany"
                                    value="{{ old('managementCompany') }}" required>
                                @error('managementCompany')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please enter the management company name.</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="propertyContact" class="f-600">Property Contact <span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('propertyContact') is-invalid @enderror" id="propertyContact" name="propertyContact"
                                    value="{{ old('propertyContact') }}" required>
                                @error('propertyContact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please enter the property contact.</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="numberOfUnits" class="f-600">Number of Units <span class="text-danger"> *</span></label>
                            <input type="number" class="form-control @error('numberOfUnits') is-invalid @enderror" id="numberOfUnits" name="numberOfUnits" 
                                value="{{ old('numberOfUnits') }}" required>
                                @error('numberOfUnits')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please enter the number of units.</div>
                                @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="yearBuilt" class="f-600">Year Built <span class="text-danger"> * </span></label>
                            <select id="yearBuilt" class="form-control @error('year') is-invalid @enderror" name="year" required>
                                <option value="" selected> Select Year </option>
                            </select>
                             @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Please select the year built.</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="yearRemodeled" class="f-600">Year Remodeled</label>
                            <select id="yearRemodeled" class="form-control" name="yearremodeled" disabled>
                                <option value="" selected> Select Year </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="address" class="f-600">Address <span class="text-danger"> * </span></label>
                            <textarea rows="3" class="form-control @error('address') is-invalid @enderror" placeholder="Address" id="address" name="address" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Please enter the address.</div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="leasingEmail" class="f-600">Leasing Email <span class="text-danger"> *</span></label>
                            <input type="email" class="form-control @error('leasingEmail') is-invalid @enderror" id="leasingEmail" name="leasingEmail" value="{{ old('leasingEmail') }}" required>
                            @error('leasingEmail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="state" class="f-600">State <span class="text-danger"> * </span></label>
                            <select class="form-control @error('state') is-invalid @enderror" id="select-state" name="state" required>
                                <option value="">- SELECT STATE -</option>
                                @foreach ($state as $row)
                                    <option value="{{ $row->Id }}" {{ old('state') == $row->Id ? 'selected' : '' }}>{{ $row->StateName }}</option>
                                @endforeach
                            </select>
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Please select a state.</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="city" class="f-600">City <span class="text-danger"> * </span></label>
                            <select class="form-control @error('city') is-invalid @enderror" id="select-city" name="city" required>
                                <option value="">- SELECT CITY -</option>
                            </select>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Please select a city.</div>
                            @enderror
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="area" class="f-600">Area <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ old('area') }}" required>
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Please enter the area.</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label for="zone" class="f-600">Zone <span class="text-danger"> * </span></label>
                            <select class="form-control @error('zone') is-invalid @enderror" id="zone" name="zone" required>
                                <option value="">Select zone</option>
                                @foreach ($zones as $zone)
                                    <option value="{{ $zone->id }}" {{ old('zone') == $zone->id ? 'selected' : '' }}>{{ $zone->Zone }}</option>
                                @endforeach
                            </select>
                            @error('zone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Please select a zone.</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="zipCode" class="f-600">Zip Code <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control @error('zipCode') is-invalid @enderror" id="zipCode" name="zipCode" value="{{ old('zipCode') }}" required>
                            @error('zipCode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Please enter the zip code.</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label class="f-600">Status</label>
                            <select class="form-control" id="status" name="statuss">
                                <option value="1" {{ old('statuss') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('statuss') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="f-600">Featured</label>
                            <select class="form-control" id="featured" name="featured">
                                <option value="1" {{ old('featured') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('featured') == '0' ? 'selected' : '' }} @if(!old('featured')) selected @endif>No</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="contactNo" class="f-600">Contact No <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control @error('contactNo') is-invalid @enderror" id="contactNo" name="contactNo" value="{{ old('contactNo') }}" required>
                             @error('contactNo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Please enter a contact number.</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label for="fax" class="f-600">Fax</label>
                            <input type="text" class="form-control" id="fax" name="fax" value="{{ old('fax') }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="website" class="f-600">Web Site</label>
                            <input type="url" class="form-control" id="website" name="website" value="{{ old('website') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="officeHours" class="f-600">Office Hours</label>
                            <input type="text" class="form-control" id="officeHours" name="officeHours" value="{{ old('officeHours') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="embddedmap" class="f-600">Embedded Map </label>
                            <input type="text" class="form-control" id="embddedmap" name="embddedmap" value="{{ old('embddedmap') }}">
                        </div>
                    </div>
                    <div class="form-row col-md-3">
                        <label class="f-600">Upload Default Image </label>
                        <div class="border p-2">
                            <input type="file" id="file-input" name="default-image" accept="image/*" class="form-control-file">
                            <div class="drop-zone mt-2" id="drop-zone">
                                <span>Drag and drop files here</span>
                            </div>
                            <div id="preview"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 text-right">
                            <hr>
                            <button type="submit" class="btn btn-primary float-right submit-spinner"> Add Property </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script>
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
            // Year Dropdown Initialization
            const yearSelect = $('#yearBuilt');
            const remodelSelect = $('#yearRemodeled');
            const currentYear = new Date().getFullYear();
            for (let i = currentYear; i >= 1900; i--) {
                yearSelect.append(`<option value="${i}">${i}</option>`);
                remodelSelect.append(`<option value="${i}">${i}</option>`);
            }

            // Restore old values for year and city if they exist
            @if(old('year'))
                yearSelect.val("{{ old('year') }}");
                remodelSelect.prop('disabled', false);
            @endif

            @if(old('yearremodeled'))
                remodelSelect.val("{{ old('yearremodeled') }}");
            @endif

            yearSelect.on('change', function() {
                if ($(this).val()) {
                    remodelSelect.prop('disabled', false);
                } else {
                    remodelSelect.prop('disabled', true).val('');
                }
            });

            $('#select-state').on('change', function() {
                var stateId = $(this).val();
                loadCities(stateId);
            });

            function loadCities(stateId, selectedCity = null) {
                if (stateId) {
                    $.ajax({
                        url: "{{ url('/admin/property/get-cities-by-state-id') }}/" + stateId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#select-city').empty();
                            $('#select-city').append('<option value="">- SELECT CITY -</option>');
                            $.each(data, function(key, value) {
                                $('#select-city').append('<option value="' + value.Id + '"' + (selectedCity == value.Id ? ' selected' : '') + '>' + value.CityName + '</option>');
                            });
                        }
                    });
                } else {
                    $('#select-city').empty();
                    $('#select-city').append('<option value="">- SELECT CITY -</option>');
                }
            }

            // Reload cities on validation error
            @if(old('state'))
                loadCities("{{ old('state') }}", "{{ old('city') }}");
            @endif

            // Basic Preview Logic for Default Image
            $('#file-input').on('change', function(e) {
                const files = e.target.files;
                $('#preview').empty();
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (file.type.match('image.*')) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            $('#preview').append(`<div class="preview-item"><img src="${event.target.result}"></div>`);
                        }
                        reader.readAsDataURL(file);
                    }
                }
            });
            
            // Drag and drop logic
            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('file-input');

            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('highlight');
            });

            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('highlight');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('highlight');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    $(fileInput).trigger('change');
                }
            });
        });
    </script>
@endpush
