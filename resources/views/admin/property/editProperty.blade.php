@extends('admin.layouts.app')
@push('style')
<link rel="stylesheet" href="{{ asset('admin_asset/css/tabview.css') }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush
@section('content')
<style>
    .property-sm-img {
        height: 3.5rem;
        width: 3.5rem;
    }

    .text-editor-container .toolbar {
        width: 100%;
        margin: 0 auto 10px;
    }

    .text-editor-container button {
        width: 30px;
        height: 30px;
        border-radius: 3px;
        background: none;
        border: none;
        box-sizing: border-box;
        padding: 0;
        font-size: 20px;
        color: #a6a6a6;
        cursor: pointer;
        outline: none;
    }

    .text-editor-container button:hover {
        border: 1px solid #a6a6a6;
        color: #777;
    }

    .text-editor-container #bold,
    .text-editor-container #italic,
    .text-editor-container #underline {
        font-size: 18px;
    }

    .text-editor-container #underline,
    .text-editor-container #align-right {
        margin-right: 17px;
    }

    .text-editor-container #align-left {
        margin-left: 17px;
    }

    .text-editor-container select {
        height: 24px;
        font-size: 15px;
        font-weight: bold;
        color: #444;
        background: #fcfcfc;
        border: 1px solid #a6a6a6;
        border-radius: 3px;
        margin: 0;
        outline: none;
        cursor: pointer;
    }

    .text-editor-container select>option {
        font-size: 15px;
        background: #fafafa;
    }

    .text-editor-container #fonts {
        width: 140px;
    }

    .text-editor-container .sp-replacer {
        background: #fcfcfc;
        padding: 1px 2px 1px 3px;
        border-radius: 3px;
        border-color: #a6a6a6;
        margin-top: -1px;
    }

    .text-editor-container .sp-replacer:hover {
        border-color: #a6a6a6;
        color: inherit;
    }

    .text-editor-container .sp-preview {
        width: 15px;
        height: 15px;
        border: none;
        margin-top: 2px;
        margin-right: 3px;
    }

    .text-editor-container .sp-preview-inner,
    .text-editor-container .sp-alpha-inner,
    .text-editor-container .sp-thumb-inner {
        border-radius: 3px;
    }

    .text-editor-container .editor {
        position: relative;
        width: 100%;
        /* height: ; */
        margin: 0 auto;
        padding: 20px;
        background: #fcfcfc;
        border-radius: 3px;
        box-shadow: inset 0 0 8px 1px rgba(0, 0, 0, 0.2);
        box-sizing: border-box;
        overflow: hidden;
        word-break: break-all;
        outline: none;
    }
</style>
<style>
        .show-password {
            cursor: pointer;
        }

        label.error {
            color: red;
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        input.error,
        select.error,
        textarea.error {
            border-color: red;
        }

        .invalid-feedback {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
        }

        .input-group {
            margin-bottom: 1rem;
        }

        input {
            transition: all 0.3s ease-in-out;
        }
    </style>

<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Property </li>
            </ol>
            <h6 class="slim-pagetitle">Edit Property </h6>
        </div>
        <div class="container-fluid px-0">
            <nav>
                <ul class="tabs">
                    <li class="tab-li">
                        <a href="#maindetails" class="tab-li__link">Main Details</a>
                    </li>
                    <li class="tab-li">
                        <a href="#generaldetails" class="tab-li__link">General Details</a>
                    </li>
                    <li class="tab-li">
                        <a class="nav-link" href="#additionaldetails" data-toggle="tab">Additional Details</a>
                    </li>
                    <li class="tab-li">
                        <a class="nav-link" href="#rentandspecial" data-toggle="tab">Rent & Specials</a>
                    </li>
                    <li class="tab-li">
                        <a class="nav-link" href="#photo" data-toggle="tab">Photo</a>
                    </li>
                </ul>
            </nav>
        </div>


        <div class="tab-content mt-3" id="ex2-content">
            <section id="maindetails" data-tab-content class="p-0">
                <div class="section-wrapper mt-3">
                    <form id="editdetails" novalidate class="needs-validation">

                        <input type="hidden" name="yearbuildvalue" id="yearbuildvalue"
                            value="{{ $propertyinfo->Year }}">
                        <input type="hidden" name="yearremodeledvalue" id="yearremodeledvalue"
                            value="{{ $propertyinfo->YearRemodel }}">

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="managername"> User Name </label>
                                <select class="form-control" id="managername" name="managername">
                                    <option value="{{ $propertyinfo->login->Id }}">
                                        {{ $propertyinfo->login->UserName }}
                                    </option>
                                    @foreach ($managerIds as $row)
                                    <option value="{{ $row->Id }}">{{ $row->UserName }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please select the year built.
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="propertyName">Property Name </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="propertyName" name="propertyName"
                                        value="{{ $propertyinfo->PropertyName }}">
                                    <div class="invalid-feedback">
                                        Please enter a Property name.
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="propertyContact">Property Contact </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="propertyContact"
                                        name="propertyContact" value="{{ $propertyinfo->PropertyContact }}" required>
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="managementCompany">Management Company </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="managementCompany"
                                        name="managementCompany" value="{{ $propertyinfo->Company }}" required>
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="numberOfUnits">Number of Units </label>
                                <input type="number" class="form-control" id="numberOfUnits"
                                    name="numberOfUnits" value="{{ $propertyinfo->Units }}" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="leasingEmail">Leasing Email</label>
                                <input type="email" class="form-control" id="leasingEmail" name="leasingEmail"
                                    value="{{ $propertyinfo->Email }}" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="yearBuilt">Year Built </label>
                                <select class="form-control" id="year-select" name="yearBuilt" required>
                                </select>
                                <div class="invalid-feedback">
                                    Please select the year built.
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="yearRemodeled">Year Remodeled</label>
                                <select class="form-control" id="year-remodeled" name="yearRemodeled">
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="fax">Fax</label>
                                <input type="text" class="form-control" id="fax" name="fax"
                                    value="{{ $propertyinfo->Fax }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="website">Web Site</label>
                                <input type="url" class="form-control" id="website" name="website"
                                    value="{{ $propertyinfo->WebSite }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="address">Address </label>
                                <textarea rows="3" class="form-control" placeholder="Textarea" id="editaddress" name="editaddress" required>{{ $propertyinfo->Address }}</textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="state">State </label>
                                <select class="form-control" id="editpropertystate" name="editpropertystate"
                                    required>
                                    @foreach ($state as $row)
                                    <option value="{{ $row->Id }}"
                                        {{ $propertyinfo->city->state->Id == $row->Id ? 'selected' : '' }}>
                                        {{ $row->StateName }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="city">City </label>
                                <input type="hidden" id="editselectedCity" value="{{ $propertyinfo->CityId }}">
                                <select id="editpropertycity" class="form-control" name="editpropertycity" required>
                                    <option value="">Select City</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="area">Area </label>
                                <input type="text" class="form-control" id="area" name="area"
                                    value="{{ $propertyinfo->Area }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="zipCode">Zip Code </label>
                                <input type="text" class="form-control" id="zipCode" name="zipCode"
                                    value="{{ $propertyinfo->Zip }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="zone">Zone</label>
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
                                <label for="contactNo">Contact No </label>
                                <input type="text" class="form-control" id="contactNo" name="contactNo"
                                    value="{{ $propertyinfo->ContactNo ?? '' }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="latitude">Latitude </label>
                                <input type="text" class="form-control" id="latitude" name="latitude"
                                    value="{{ $propertyinfo->latitude ?? '' }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="longitude">Longitude </label>
                                <input type="text" class="form-control" id="longitude" name="longitude"
                                    value="{{ $propertyinfo->longitude ?? '' }}">
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="officeHours">Office Hours </label>
                                <textarea rows="3" class="form-control" placeholder="Textarea" name="" value="">{{ $propertyinfo->officehour ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>


            <section id="generaldetails" data-tab-content class="">
                <div class="section-wrapper mt-3">
                    <form id="generaldetailsform" novalidate class="needs-validation">
                        <div class="form-row">
                            <input type="hidden" name="property_id" id=""
                                value="{{ $propertyinfo->Id }}">

                            <div class="form-group col-md-12">
                                editcommunitydescription
                                <h4 class="p-2">:: Community Descriptions ::</h4>
                                <textarea id="editcommunitydescription" name="editcommunitydescription" class="form-control">
                                {{ @$propertyinfo->communitydescription->Description ? @$propertyinfo->communitydescription->Description : '' }}
                                </textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <h4 class="p-2">:: Agent Comments ::</h4>
                                <textarea id="editagentcomments" name="editagentcomments" class="form-control">
                                {{ @$propertyinfo->communitydescription->Agent_comments ? @$propertyinfo->communitydescription->Agent_comments : '' }}
                                </textarea>
                            </div>

                            <div class="form-group col-md-12">
                                @php
                                $amenityfn = $propertyinfo->CommunityFeatures;
                                $selectedamenities = explode(',', $amenityfn);
                                @endphp
                                <h4 class="p-2">Amenities <span>(Maximum Aminities-20)</span></h4>
                                <div class="row mt-1">
                                    @foreach ($amenities as $row)
                                    <div class="col-xl-6 col-xxl-6 col-md-6 mt-2">
                                        <div class="amenities_check_area">
                                            <div class="wsus__pro_check">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="{{ $row->Id }}" name="amenities[]"
                                                        id="flexCheckIndeterminate"
                                                        @if (in_array($row->Id, $selectedamenities)) checked @endif>

                                                    <label class="form-check-label"
                                                        for="flexCheckIndeterminate">
                                                        {{ $row->Amenity }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                @php
                                $featuresfn = $propertyinfo->PropertyFeatures;
                                $selectedFeatures = explode(',', $featuresfn);
                                @endphp
                                <h4 class="p-2">Apartment Features <span> (listed in alphabetical order) </span>
                                </h4>
                                <div class="row mt-1">
                                    @foreach ($apartmentFeature as $feature)
                                    <div class="col-xl-6 col-xxl-4 col-md-6 mt-2">
                                        <div class="amenities_check_area">
                                            <div class="wsus__pro_check">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="apartmentfeatures[]"
                                                        value="{{ $feature->Id }}"
                                                        id="flexCheckIndeterminate{{ $feature->Id }}"
                                                        @if (in_array($feature->Id, $selectedFeatures)) checked @endif>
                                                    <label class="form-check-label"
                                                        for="flexCheckIndeterminate{{ $feature->Id }}">
                                                        {{ $feature->PropertyFeatureType }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <h4 class="p-2">:: Keywords ::</h4>
                                <textarea id="editkeyword" name="editkeyword" class="form-control">
                                {{ @$propertyinfo->communitydescription->Agent_comments ? @$propertyinfo->communitydescription->Agent_comments : '' }}
                                </textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button type="submit"
                                    class="btn btn-primary float-right submit-spinner">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </section>


            <section id="additionaldetails" data-tab-content class="">
                <div class="section-wrapper mt-3">
                    <form id="additionaldetailsform" novalidate class="needs-validation">
                        <div class="form-row">
                            <input type="hidden" name="property_id" id=""
                                value="{{ $propertyinfo->Id }}">

                            <div class="form-group col-md-12">
                                <h4 class="p-2">:: Leasing Terms ::</h4>
                                <textarea id="editleasingterm" name="editleasingterm" class="form-control">
                                {{ @$propertyinfo->newAdditionalInfo->LeasingTerms ? @$propertyinfo->newAdditionalInfo->LeasingTerms : '' }}
                                </textarea>

                            </div>

                            <div class="form-group col-md-12">
                                <h4 class="p-2">:: Qualifiying Criteria ::</h4>
                                <textarea id="editqualifyingcriteria" name="editqualifyingcriteria" class="form-control">
                                {{ @$propertyinfo->newAdditionalInfo->QualifiyingCriteria ? @$propertyinfo->newAdditionalInfo->QualifiyingCriteria : '' }}
                                </textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <h4 class="p-2">:: Parking ::</h4>
                                <textarea id="editparking" name="editparking" class="form-control">
                                {{ @$propertyinfo->newAdditionalInfo->Parking ? @$propertyinfo->newAdditionalInfo->Parking : '' }}
                                </textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <h4 class="p-2"> :: Pet Policy :: </h4>
                                <p> Please check boxes for breeds you DO ACCEPT </p>
                            </div>

                            <div class="form-group col-md-12">
                                <h4 class="p-2">:: Neighborhood ::</h4>
                                <textarea id="editneighbourhood" name="editneighbourhood" class="form-control">
                                {{ @$propertyinfo->newAdditionalInfo->Neighborhood ? @$propertyinfo->newAdditionalInfo->Neighborhood : '' }}
                                </textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <h4 class="p-2">:: Driving Directions ::</h4>
                                <textarea id="editdrivingdirection" name="editdrivingdirection" class="form-control">
                                {{ @$propertyinfo->newAdditionalInfo->drivedirection ? @$propertyinfo->newAdditionalInfo->drivedirection : '' }}
                                </textarea>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button type="submit"
                                    class="btn btn-primary float-right submit-spinner">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </section>


            <section id="rentandspecial" data-tab-content class="">
                <div class="section-wrapper mt-3">
                    <div class="card card-quick-post">
                        <div class="list-group">
                            <a href="#" class="btn btn-primary">
                                <span class="font-weight-bold"> Create New Unit </span>
                            </a>
                        </div>

                        <div class="form-group mt-3">
                            @foreach ($categories as $category)
                            <h4 class="m-3 border p-2">{{ $category->Name }}</h4>
                            <div class="primary-table table-flex">
                                <?php
                                $propertyId = $propertyinfo->Id;
                                $categoryId = $category['Id'];
                                $floorDetails = $category->getFloorPlanDetails($propertyId, $categoryId);
                                $count = count($floorDetails);
                                ?>
                                @if ($count > 0)
                                <div class="row">
                                    @foreach ($floorDetails as $floorDetail)
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label for="" class="fw-700"> Delete </label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input_area">
                                                    <input type="checkbox" id="deletefloorPlan" name="deletefloorPlan" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-5">
                                                <label for="" class="fw-700"> Category </label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input_area">
                                                    <select class="form-control form-select form-control-a state-select-box" name="editpropertystate"
                                                        id="editpropertystate" required>
                                                        @foreach ($categories as $cat)
                                                        <option value="{{ $cat->Id }}"
                                                            {{ $category->Id == $cat->Id ? 'selected' : '' }}>
                                                            {{ $cat->Name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-5">
                                                <label for="" class="fw-700">Plan Type</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input_area">
                                                    <input type="text" id="deletefloorPlan"
                                                        name="deletefloorPlan"
                                                        value="{{ $floorDetail->PlanType }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-5">
                                                <label for="" class="fw-700">Floor
                                                    Plan</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input_area">
                                                    <input type="text" id="floorPlan"
                                                        name="floorPlan"
                                                        value="{{ $floorDetail->PlanName }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-5">
                                                <label for="" class="fw-700">Square
                                                    Footage</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input_area">
                                                    <input type="text" id="floorPlan"
                                                        name="floorPlan"
                                                        value="{{ $floorDetail->Footage }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-5">
                                                <label for="" class="fw-700">Starting
                                                    at</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input_area">
                                                    <input type="text" id="Price"
                                                        name="Price"
                                                        value="{{ $floorDetail->Price }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-5">
                                                <label for="" class="fw-700">Deposit</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input_area">
                                                    <input type="text" id="Price"
                                                        name="Price"
                                                        value="{{ $floorDetail->deposit }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-5">
                                                <label for="" class="fw-700">Link</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input_area">
                                                    <input type="text" id="Price"
                                                        name="Price"
                                                        value="{{ $floorDetail->floorplan_link }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-5">
                                                <label for="" class="fw-700">Available
                                                    Url</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input_area">
                                                    <input type="text" id="Price"
                                                        name="Price"
                                                        value="{{ $floorDetail->Available_Url }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-5">
                                                <label for="" class="fw-700">Deposit</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input_area">
                                                    <input type="text" id="Price"
                                                        name="Price"
                                                        value="{{ $floorDetail->deposit }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-5">
                                                <label for="" class="fw-700">Unit Description
                                                    Specials
                                                    Available Dates</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input_area">
                                                    <textarea type="text" id="Price" name="Price" value="">{{ $floorDetail->Comments }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-5">
                                                <label for="" class="fw-700">Special</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input_area">
                                                    <textarea type="text" id="Price" name="Price" value=""> {{ @$floorDetail->special }} </textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-5">
                                                <label for="" class="fw-700">Available
                                                    Date</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input_area">
                                                    <input type="date" name=""
                                                        id=""
                                                        value="{{ $floorDetail->avail_date }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="table-flex">
                                    <div class="table-tbody mt-2 border">
                                        <h6> No Record Found </h6>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <hr>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary">Add Special </button>
                        </div>
                        <hr>
                    </div>
                </div>
            </section>


            <section id="photo" data-tab-content class="">
                <div class="section-wrapper mt-3">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0">:: Gallary Details ::</h5>
                        </div>

                        <div class="table-responsive mt-3">
                            <table class="table table-traffic mb-0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Image</th>
                                        <th>Set Logo</th>
                                        <th>Floor Plan Image </th>
                                        <th>Floor Plan Name</th>
                                        <th colspan="2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($galleryDetails != '')
                                    @foreach ($galleryDetails->gallerydetail as $imagerec)
                                    <tr>
                                        <td
                                            class="px-3 py-3 border-b border-slate-200 last:border-none first:pl-3 last:pr-3 last:bg-gradient-to-r last:from-transparent last:to-white last:to-[12px] last:pl-5 last:sticky last:right-0">
                                            <div class="text-slate-500">{{ $loop->iteration }}</div>
                                        </td>
                                        <td
                                            class="px-3 py-3 border-b border-slate-200 last:border-none first:pl-3 last:pr-3 last:bg-gradient-to-r last:from-transparent last:to-white last:to-[12px] last:pl-5 last:sticky last:right-0">
                                            <div class="flex items-center">
                                                @php
                                                $imageName = $imagerec->ImageName ?? null;
                                                @endphp

                                                @if ($imageName)
                                                <img src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $propertyId }}/Original/{{ $imageName }}"
                                                    alt="Property Image"
                                                    style="width:70px !important;height:70px !important;">
                                                @else
                                                <img class="img-fluid"
                                                    src="{{ asset('img/no-img.jpg') }}"
                                                    alt="Default Image">
                                                @endif
                                            </div>
                                        </td>
                                        <td
                                            class="px-3 py-3 border-b border-slate-200 last:border-none first:pl-3 last:pr-3 last:bg-gradient-to-r last:from-transparent last:to-white last:to-[12px] last:pl-5 last:sticky last:right-0">
                                            <div class="text-slate-500">
                                                <input type="checkbox" id="vehicle1"
                                                    name="propertylogo"
                                                    {{ $imagerec->DefaultImage ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td
                                            class="px-3 py-3 border-b border-slate-200 last:border-none first:pl-3 last:pr-3 last:bg-gradient-to-r last:from-transparent last:to-white last:to-[12px] last:pl-5 last:sticky last:right-0">
                                            <div class="text-slate-900">
                                                <input type="checkbox" id="vehicle1"
                                                    name="propertyfloorplanimage"
                                                    {{ $imagerec->floorplan_id ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td
                                            class="px-3 py-3 border-b border-slate-200 last:border-none first:pl-3 last:pr-3 last:bg-gradient-to-r last:from-transparent last:to-white last:to-[12px] last:pl-5 last:sticky last:right-0">
                                            <div class="text-slate-900">
                                                <select
                                                    class="form-control form-select form-control-a state-select-box"
                                                    name="editpropertystate" id="editpropertystate"
                                                    required style="width:70%;">
                                                    <option value="">Select Floor Plan</option>
                                                    @foreach ($selectFloorPlan as $row)
                                                    <option value="{{ $row->Id }}">
                                                        {{ $row->PlanName }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td
                                            class="px-3 py-3 border-b border-slate-200 last:border-none first:pl-3 last:pr-3 last:bg-gradient-to-r last:from-transparent last:to-white last:to-[12px] last:pl-5 last:sticky last:right-0">
                                            <div class="table-actions-icons justify-content-start">
                                                <a href="" class="edit-btn"><i
                                                        class="fa-regular fa-pen-to-square border px-2 py-2 edit-icon"></i></a>
                                                <a href="javascript:void(0)" id="delete-property"
                                                    class="propertyDlt" data-id="" data-url="">
                                                    <i
                                                        class="fa-solid fa-trash px-2 py-2 delete-icon border"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6" class="text-center">No gallery images found.</td>
                                    </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="section-wrapper mt-4">
                    <form action="" id="upload-image-gallery">
                        <input type="hidden" name="property_id" id=""
                            value="{{ $propertyinfo->Id }}">
                        <label class="section-title">Add Gallery Images </label>
                        <div class="form-layout form-layout-4 mt-5">
                            <div class="row">
                                <label class="col-sm-4 form-control-label">Image Title </label>
                                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                    <input type="text" class="form-control" placeholder="Enter Image Title"
                                        name="imagetitle">
                                </div>
                            </div>
                            <div class="row mg-t-20">
                                <label class="col-sm-4 form-control-label"> Description </label>
                                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                    <textarea rows="2" class="form-control" name="description" placeholder="Enter Image Description "></textarea>
                                </div>
                            </div>
                            <div class="row mg-t-20">
                                <label class="col-sm-4 form-control-label">Image </label>
                                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                    <input type="file" class="custom-file-input" id="propertyimage"
                                        name="propertyimage" required>
                                    <label class="custom-file-label custom-file-label-primary"
                                        for="customFile">Choose file</label>
                                </div>
                            </div>
                            <div class="form-layout-footer mg-t-30">
                                <button class="btn btn-primary bd-0 submit-spinner">Submit Form</button>
                                <button class="btn btn-secondary bd-0">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>

    </div>
</div>
@endsection

@push('adminscripts')
<script src="{{ asset('admin_asset/js/tabviewform.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('.image-preview').css({
            'background-image': `url({{ @$counter->background ? asset($counter->background) : asset('img/no-img.jpg') }})`,
            'background-size': 'cover',
            'background-position': 'center center'
        });

        $('nav a').click(function() {
            $('nav a').removeClass("active");
            $(this).addClass("active");
        });

        $('#editkeyword').summernote({
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

        $('#editagentcomments').summernote({
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

        $('#editcommunitydescription').summernote({
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

        $('#editdrivingdirection').summernote({
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

        $('#editleasingterm').summernote({
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

        $('#editqualifyingcriteria').summernote({
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

        $('#editparking').summernote({
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

        $('#editneighbourhood').summernote({
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


        const startYear = 1900;
        const currentYear = new Date().getFullYear();
        var selectedYear = $("#yearbuildvalue").val();
        var selectedRemodeledYear = $("#yearremodeledvalue").val();

        for (let year = currentYear; year >= startYear; year--) {
            if (year == selectedYear) {
                $("#year-select").append(new Option(year, year, true, true));
            } else {
                $("#year-select").append(new Option(year, year));
            }
        }

        for (let year = currentYear; year >= startYear; year--) {
            if (year == selectedRemodeledYear) {
                $("#year-remodeled").append(new Option(year, year, true, true));
            } else {
                $("#year-remodeled").append(new Option(year, year));
            }
        }


        $("#editstate").on("change", function() {
            let stateId = $(this).val();
            let citySelect = $("#editcity");

            citySelect.empty();
            citySelect.append('<option value="">Select City</option>');

            if (stateId) {
                $.ajax({
                    url: "/cities/" + stateId,
                    type: "GET",
                    success: function(data) {
                        $.each(data, function(key, city) {
                            citySelect.append(
                                '<option value="' +
                                city.Id +
                                '">' +
                                city.CityName +
                                "</option>"
                            );
                        });

                        // Get the selected city from the hidden input
                        let selectedCity = $("#selectedCity").val();
                        if (selectedCity) {
                            citySelect.val(selectedCity); // Preselect the city
                        }
                    },
                    error: function() {
                        // Handle error
                    },
                });
            }
        });

        $("#editstate").trigger("change");

        $("#editpropertystate").on("change", function() {
            let stateId = $(this).val();
            let citySelect = $("#editpropertycity");

            citySelect.empty();
            citySelect.append('<option value="">Select City</option>');

            if (stateId) {
                $.ajax({
                    url: "/cities/" + stateId,
                    type: "GET",
                    success: function(data) {
                        $.each(data, function(key, city) {
                            citySelect.append(
                                '<option value="' +
                                city.Id +
                                '">' +
                                city.CityName +
                                "</option>"
                            );
                        });

                        let editselectedCity = $("#editselectedCity").val();
                        if (editselectedCity) {
                            citySelect.val(editselectedCity);
                        }
                    },
                    error: function() {},
                });
            }
        });
        $("#editpropertystate").trigger("change");

        // $("#editdetails").submit(function(event) {
        //     event.preventDefault();
        //     if (this.checkValidity() === false) {
        //         event.stopPropagation();
        //         return;
        //     }
        //     var formData = $(this).serialize();

        //     $.ajax({
        //         url: "{{ route('admin-edit-property-details') }}",
        //         method: "POST",
        //         data: formData,
        //         headers: {
        //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        //         },
        //         success: function(response) {
        //             toastr.success(response.message);
        //             location.reload();
        //         },
        //         error: function(response) {
        //             toastr.error(response.responseJSON.error);
        //         },
        //     });
        // });

        $('#upload-image-gallery').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('upload-gallery-image') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
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
                    $('#upload-image-gallery')[0].reset();
                    toastr.success(response.message);
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

        $('#generaldetailsform').on('submit', function(e) {
            e.preventDefault();
            var c_description = $('#community-description').html()
            var a_comments = $('#agent-comments').html()
            var keywords = $('#keywords').html()

            let formData = new FormData(this);
            formData.append('community_description', c_description);
            formData.append('agent_comments', a_comments);
            formData.append('keywords', keywords);

            $.ajax({
                url: "{{ route('admin-edit-general-details') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
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
                    $('#upload-image-gallery')[0].reset();
                    toastr.success(response.message);
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
                        toastr.error(response.message)
                    }
                },
                complete: function() {
                    $('.submit-spinner').html(`Create`);
                    $('.submit-spinner').prop('disabled', false);
                },
            });
        });




        $('#editdetails').validate({
            errorClass: "error",
            validClass: "is-valid",
            rules: {
                editassignAgent: {
                    required: true
                },
                edituserName: {
                    required: true
                },
                editemailId: {
                    required: true,
                    email: true
                },
                editfirstName: {
                    required: true,
                    maxlength: 255
                },
                editlastName: {
                    required: true,
                    maxlength: 255
                },
                editcell: {
                    required: true,
                    maxlength: 15,
                    digits: true
                },
                editcurrentAddress: {
                    required: true,
                    maxlength: 255
                },
                editstate: {
                    required: true
                },
                editcity: {
                    required: true
                },
                editzipCode: {
                    required: true
                }
            },
            messages: {
                editassignAgent: {
                    required: "Assign Agent is required."
                },
                edituserName: {
                    required: "User Name is required."
                },
                editemailId: {
                    required: "Valid email is required.",
                    email: "Please enter a valid email address."
                },
                editfirstName: {
                    required: "First Name is required."
                },
                editlastName: {
                    required: "Last Name is required."
                },
                editcell: {
                    required: "Cell Number is required.",
                    digits: "Cell number must contain only numeric digits."
                },
                editcurrentAddress: {
                    required: "Current Address is required."
                },
                editstate: {
                    required: "State is required."
                },
                editcity: {
                    required: "City is required."
                },
                editzipCode: {
                    required: "Zip Code is required."
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
            submitHandler: function(form) {
                event.preventDefault();
                const formData = $(form).serialize();
                console.log("formData", formData);
                const url = `{{ route('admin-edit-renter-update') }}`;
                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $(".submit-spinner").prop("disabled", true).text("Editing...");
                    },
                    success: function(response) {
                        $(".submit-spinner").prop("disabled", false).text(
                            "Edit Renter");
                        if (response.success) {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        $(".submit-spinner").prop("disabled", false).text(
                            "Edit Renter");
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