@extends('admin/layouts/app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin-edit-property', ['id' => $propertyId]) }}">Edit Property</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Floor Plan</li>
                </ol>
                <h6 class="slim-pagetitle">Create Floor Plan </h6>
            </div>

            <div class="section-wrapper">
                <form id="createfloorplan" action="{{ route('admin-store-floor-plan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="propertyId" value="{{ $propertyId }}">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="f-600">Category <span class="text-danger">*</span></label>
                            <select class="form-control" name="category" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->Id }}" {{ old('category') == $category->Id ? 'selected' : '' }}>{{ $category->Name }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="f-600">Plan Type</label>
                            <input type="text" class="form-control" name="plan_type" value="{{ old('plan_type') }}"
                                placeholder="(e.g. Apartment, Loft, Townhome)">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="f-600">Floor Plan</label>
                            <input type="text" class="form-control" name="floor_plan" value="{{ old('floor_plan') }}"
                                placeholder="(e.g. Studio, 2 bed 1 bath)">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="f-600">Plan Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="plan_name" value="{{ old('plan_name') }}" placeholder="Enter Plan Name"
                                required>
                            @error('plan_name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="f-600">Square Footage</label>
                            <input type="number" class="form-control" name="square_footage" value="{{ old('square_footage') }}" placeholder="e.g. 850">
                            @error('square_footage')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label class="f-600">Starting at ($)</label>
                            <input type="number" class="form-control" name="starting_at" value="{{ old('starting_at') }}" placeholder="Monthly rent">
                            @error('starting_at')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label class="f-600">Deposit ($)</label>
                            <input type="number" class="form-control" name="deposit" value="{{ old('deposit') }}" placeholder="Deposit amount">
                            @error('deposit')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="f-600">Link</label>
                            <input type="text" class="form-control" name="link" value="{{ old('link') }}" placeholder="External link">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="f-600">Available URL</label>
                            <input type="text" class="form-control" name="available_url" value="{{ old('available_url') }}" placeholder="Availability link">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="f-600">Expiry Date</label>
                            <input type="date" class="form-control" name="expiry_date" value="{{ old('expiry_date') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="f-600">Unit Description / Specials</label>
                        <textarea class="form-control summernote" name="unit_description" id="unit_description">{{ old('unit_description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="f-600">Special Note</label>
                        <textarea class="form-control summernote" name="special" id="special_note">{{ old('special') }}</textarea>
                    </div>

                    <div class="form-group" id="medicine_row">
                        <label class="f-600">Available Dates</label>
                        <div class="d-flex mb-2">
                            <input type="date" class="form-control" name="dates[]">
                            <button type="button" id="add_row" class="btn btn-primary ml-2">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <div id="dynamic_date_rows"></div>
                    </div>

                    <div class="form-group mt-4 text-right">
                        <a href="{{ route('admin-edit-property', ['id' => $propertyId]) }}#rentandspecial" class="btn btn-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 submit-spinner"> Save Floor Plan </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('adminscripts')
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 150,
                placeholder: 'Type here...'
            });

            $('#add_row').click(function() {
                const row = `
                    <div class="d-flex mb-2">
                        <input type="date" class="form-control" name="dates[]">
                        <button type="button" class="btn btn-danger ml-2 remove_row">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                `;
                $('#dynamic_date_rows').append(row);
            });

            $(document).on('click', '.remove_row', function() {
                $(this).parent().remove();
            });

            $('#createfloorplan').validate({
                errorClass: "text-danger small",
                rules: {
                    category: { required: true },
                    plan_name: { required: true },
                    square_footage: { number: true },
                    starting_at: { number: true },
                    deposit: { number: true }
                },
                messages: {
                    category: "Please select a category",
                    plan_name: "Please enter a plan name"
                },
                submitHandler: function(form) {
                    $('.summernote').each(function() {
                        $(this).val($(this).summernote('code'));
                    });
                    $('.submit-spinner').prop('disabled', true).text('Saving...');
                    form.submit();
                }
            });
        });
    </script>
@endpush
