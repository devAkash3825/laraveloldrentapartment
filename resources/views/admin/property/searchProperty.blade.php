@extends('admin.layouts.app')
@section('title', 'Renter Apartment Admin Section | Search Property ')
@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item active"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item" aria-current="page">Search Properties </li>
            </ol>
            <h6 class="slim-pagetitle">Search Property </h6>
        </div>

        <div class="section-wrapper">
            <form method="get" action="{{ route('admin-property-searching') }}" id="propertySearchForm">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Search Property</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="propertysearch">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Property Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="propertytitle">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Added By</label>
                    <div class="col-sm-10">
                        <select class="form-control py-2" id="propertymanager" name="propertymanager">
                            <option value=""> Select Property Manager </option>
                            @foreach ($getManagers as $managers)
                            <option value="{{ $managers->Id }}">{{ $managers->UserName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Added Between</label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" name="added_from" id="added_from" placeholder="From">
                    </div>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" name="added_to" id="added_to" placeholder="To">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">School</label>
                    <div class="col-sm-5">
                        <label class="col-sm-4 col-form-label  text-dark font-weight-bold px-0"> District School
                        </label>
                        <input type="text" class="form-control" name="districtschool" id="districtschool"
                            placeholder="District School">

                        <label class="col-sm-4 col-form-label  text-dark font-weight-bold px-0">Elementary
                            School</label>
                        <input type="text" class="form-control" name="elementaryschool" id="elementaryschool"
                            placeholder="Elementary School">

                        <label class="col-sm-4 col-form-label  text-dark font-weight-bold px-0">High School</label>
                        <input type="text" class="form-control" name="highschool" id="highschool"
                            placeholder="High School">

                        <label class="col-sm-4 col-form-label  text-dark font-weight-bold px-0">Middle School</label>
                        <input type="text" class="form-control" name="middleschool" id="middleschool"
                            placeholder="Middle School">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">State</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="searchpropertystate" name="state">
                            <option value="">- SELECT STATE -</option>
                            @foreach ($state as $row)
                            <option value="{{ $row->Id }}">{{ $row->StateName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">City</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="search-property-city" name="search-property-city">
                            <option value="">- SELECT CITY -</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Area</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Area" placeholder="Area">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Zip Code</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="zipcode" placeholder="Zip Code">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Managed By</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="manageby" placeholder="Managed By">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Price Range</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="rangefrom" placeholder="From">
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="rangeto" placeholder="To">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Bedrooms</label>

                    <div class="col-md-5 d-flex gap-5 py-3">
                        <label class="ckbox">
                            <input type="checkbox" name="bedroom[]" value="1" class="bedroom-checkbox">
                            <span class="text-dark font-weight-bold"> Studio- 1 Bedroom </span>
                        </label>
                    </div>

                    <div class="col-md-5 d-flex gap-5 py-3">
                        <label class="ckbox ml-3">
                            <input type="checkbox" name="bedroom[]" value="2" class="bedroom-checkbox">
                            <span class="text-dark font-weight-bold"> 1 Bedroom Den - 2 Bedroom </span>
                        </label>
                    </div>

                    <label class="col-sm-2 col-form-label font-weight-bold"></label>

                    <div class="col-md-5 d-flex gap-5 py-3">
                        <label class="ckbox">
                            <input type="checkbox" name="bedroom[]" value="3" class="bedroom-checkbox">
                            <span class="text-dark font-weight-bold"> 2 Bedroom Den - 3 Bedroom</span>
                        </label>
                    </div>

                    <div class="col-md-5 d-flex gap-5 py-3">
                        <label class="ckbox ml-3">
                            <input type="checkbox" name="bedroom[]" value="4" class="bedroom-checkbox">
                            <span class="text-dark font-weight-bold"> 3 Bedroom Den - 4 Bedroom</span>
                        </label>
                    </div>

                    <label class="col-sm-2 col-form-label font-weight-bold"></label>

                    <div class="col-md-5 d-flex gap-5 py-3">
                        <label class="ckbox">
                            <input type="checkbox" name="bedroom[]" value="5" class="bedroom-checkbox">
                            <span class="text-dark font-weight-bold"> 5 Bedroom </span>
                        </label>
                    </div>

                    <div class="col-md-5 d-flex gap-5 py-3">
                        <label class="ckbox ml-3">
                            <input type="checkbox" name="bedroom[]" value="all" id="select-all">
                            <span class="text-dark font-weight-bold"> All</span>
                        </label>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Status</label>

                    <div class="col-md-5 d-flex gap-5 py-3">
                        <label class="ckbox">
                            <input type="checkbox" name="status[]" value="1">
                            <span class="text-dark font-weight-bold"> Active </span>
                        </label>
                    </div>

                    <div class="col-md-5 d-flex gap-5 py-3">
                        <label class="ckbox ml-3">
                            <input type="checkbox" name="status[]" value="0">
                            <span class="text-dark font-weight-bold"> Inactive </span>
                        </label>
                    </div>

                    <label class="col-sm-2 col-form-label font-weight-bold"></label>

                    <div class="col-md-5 d-flex gap-5 py-3">
                        <label class="ckbox">
                            <input type="checkbox" name="status[]" value="">
                            <span class="text-dark font-weight-bold"> Display featured property only </span>
                        </label>
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <div class="d-flex gap-3 justify-content-end">
                            <button type="submit" class="btn btn-primary float-right" id="search-btn">Search
                                Property</button>
                            <button class="btn btn-secondary bd-0 ml-2" id="reset-form"> Reset </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('adminscripts')
<script>
$("#searchpropertystate").on("change", function() {
    var stateId = $(this).val();
    if (stateId) {
        $.ajax({
            url: `{{ route('admin-get-cities', ':stateId') }}`.replace(':stateId',
                stateId),
            type: "GET",
            dataType: "json",
            success: function(data) {
                $("#search-property-city").empty();
                $("#search-property-city").append(
                    '<option value="">Select City</option>'
                );
                $.each(data, function(key, value) {
                    $("#search-property-city").append(
                        '<option value="' +
                        value.Id +
                        '">' +
                        value.CityName +
                        "</option>"
                    );
                });
            },
            error: function(xhr) {
                console.error("Error fetching cities:", xhr);
            },
        });
    } else {
        $("#search-property-city").empty();
        $("#search-property-city").append('<option value="">Select City</option>');
    }
});


$("#propertymanager").select2({
    placeholder: "- Select Property Manager -",
    allowClear: true,
});


$(document).ready(function() {
    $('#reset-form').on('click', function(e) {
        e.preventDefault();
        $('#propertySearchForm')[0].reset();
        $('#search-property-city').html(
            '<option value="">- SELECT CITY -</option>');
    });
});



function updateDataTable(data) {
    var table = $('#propertyTable').DataTable();
    table.clear();
    data.forEach(function(property) {
        table.row.add([
            property.PropertyName,
            property.Area,
            property.Zone,
            property.Keyword,
        ]).draw();
    });
}

document.getElementById('select-all').addEventListener('change', function() {
    const isChecked = this.checked;
    const checkboxes = document.querySelectorAll('.bedroom-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.checked = isChecked;
    });
});

document.querySelectorAll('.bedroom-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const allCheckboxes = document.querySelectorAll('.bedroom-checkbox');
        const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);

        document.getElementById('select-all').checked = allChecked;
    });
});
</script>
@endpush