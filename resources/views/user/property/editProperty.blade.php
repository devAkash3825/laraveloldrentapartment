@extends('user/layout/app')
@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/css/tabview.css') }}">
@endpush
@section('content')
<style>
    [data-tab-content] {
        display: none;
    }

    .active[data-tab-content] {
        display: block;
    }

    .section-t2 {
        padding-bottom: 12px;
    }

    .section-t2 .tabs {
        display: flex;
        justify-content: space-around;
        list-style-type: none;
        flex-wrap: wrap;
        margin: 0;
        padding: 0;
    }

    .section-t2 .tab {
        flex: 1;
        font-weight: 600;
        text-align: center;
        text-transform: uppercase;
        cursor: pointer;
        padding: 10px;
        border-bottom: 1px solid #cdcdcd;
    }

    .section-t2 .tab.active {
        color: #1babf9;
        border-bottom: 2px solid #1babf9;
    }
</style>
<!-- Premium Header -->
<div class="header-premium-gradient py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">Edit Property</h1>
                <p class="text-white opacity-75 lead mb-0">Update your listing details and media</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('my-properties') }}" class="text-white opacity-75 text-decoration-none small">My Properties</a></li>
                        <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">Edit Listing</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>


<section id="listing_grid" class="grid_view">
    <div class="container">
        <div class="row p-3">
            <div class="col-lg-3">
                <x-dashboard-sidebar />
            </div>
            <div class="col-lg-9 mt-3 mt-lg-0">
                <nav class="section-t2">
                    <ul class="tabs">
                        <li class="tab-li">
                            <a href="#maindetails" class="tab-li__link"> Main Details </a>
                        </li>
                        <li class="tab-li">
                            <a href="#additionaldetails" class="tab-li__link"> Additional Details </a>
                        </li>
                        <li class="tab-li">
                            <a href="#rentspecial" class="tab-li__link"> Rent & Specials </a>
                        </li>
                        <li class="tab-li">
                            <a href="#imagegallary" class="tab-li__link"> Image Gallary </a>
                        </li>
                    </ul>
                </nav>
                <input type="hidden" name="propertyId" value="{{ $propertyId }}" id="editpropertyId">
                <section id="maindetails" data-tab-content>
                    <div class="my_listing list_mar list_padding">
                        <form class="py-2" id="propertyEditForm">
                            <div class="row mt-2">
                                <!-- Property Name -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label>Property Name</label>
                                        <div class="input_area">
                                            <input type="text" name="propertyname" value="{{ $propertyinfo->PropertyName }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label>Management Company</label>
                                        <div class="input_area">
                                            <input type="text" name="company" value="{{ $propertyinfo->Company }}"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label>Property Contact</label>
                                        <div class="input_area">
                                            <input type="text" name="propertycontact"
                                                value="{{ $propertyinfo->PropertyContact }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label>Number of Units</label>
                                        <div class="input_area">
                                            <input type="text" name="units" value="{{ $propertyinfo->Units }}">
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="yearbuildvalue" id="yearbuildvalue"
                                    value="{{ $propertyinfo->Year }}">
                                <input type="hidden" name="yearremodeledvalue" id="yearremodeledvalue"
                                    value="{{ $propertyinfo->YearRemodel }}">

                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label>Year Built</label>
                                        <div class="input_area">
                                            <select id="year-select" name="yearbuilt" style="width: 100%;">
                                                <!-- Populate options dynamically if needed -->
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label>Year Remodeled</label>
                                        <div class="input_area">
                                            <select id="year-remodeled" name="yearremodeled" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label>Leasing Email</label>
                                        <div class="input_area">
                                            <input type="email" name="email" value="{{ $propertyinfo->Email }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label>Zip Code</label>
                                        <div class="input_area">
                                            <input type="text" name="zipcode" value="{{ $propertyinfo->Zip }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label>Contact No</label>
                                        <div class="input_area">
                                            <input type="text" name="contactno"
                                                value="{{ $propertyinfo->ContactNo ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="my_listing_single">
                                        <label>Area of Town</label>
                                        <div class="input_area">
                                            <input type="text" name="area" value="{{ $propertyinfo->Area }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="my_listing_single">
                                        <label>Zone</label>
                                        <div class="input_area">
                                            <input type="text" name="zone" value="{{ $propertyinfo->Zone }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="my_listing_single">
                                        <label for="state">State</label>
                                        <div class="input_area">
                                            <select class="form-control form-select form-control-a state-select-box"
                                                name="editpropertystate" id="editpropertystate" required>
                                                @foreach ($state as $row)
                                                <option value="{{ $row->Id }}"
                                                    {{ $propertyinfo->city->state->Id == $row->Id ? 'selected' : '' }}>
                                                    {{ $row->StateName }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="my_listing_single">
                                        <label for="city">Destination City</label>
                                        <input type="hidden" id="editselectedCity"
                                            value="{{ $propertyinfo->CityId }}">
                                        <div class="input_area">
                                            <select id="editpropertycity" name="editpropertycity" class="select_2">
                                                <option value="">Select City</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="my_listing_single">
                                        <label>Fax No</label>
                                        <div class="input_area">
                                            <input type="text" name="faxno" value="{{ $propertyinfo->Fax }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="my_listing_single">
                                        <label>Website</label>
                                        <div class="input_area">
                                            <input type="text" name="website"
                                                value="{{ $propertyinfo->WebSite }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="my_listing_single mar_bottom">
                                        <label>Address</label>
                                        <div class="input_area">
                                            <textarea name="address" cols="3" rows="5">{{ $propertyinfo->Address ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="my_listing_single mar_bottom">
                                        <label>Office Hours</label>
                                        <div class="input_area">
                                            <textarea name="officehours" cols="3" rows="5">{{ $propertyinfo->officehour ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12">
                                    <button type="submit" class="read_btn float-right mt-2">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="my_listing list_mar list_padding">
                        <form action="{{ route('edit-general-detail', ['id' => $propertyinfo->Id]) }}" method="POST" id="generaldetailForm">
                            @csrf
                            <div class="row mt-1">
                                <div class="col-xl-12">
                                    <div class="my_listing_single mar_bottom">
                                        <label>Community Description</label>
                                        <div class="input_area">
                                            <textarea cols="3" rows="5" placeholder="Add Community Description" name="communitydescription" value="">{{ @$propertyinfo->communitydescription->Description ? @$propertyinfo->communitydescription->Description : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @php
                                $amenityfn = $propertyinfo->CommunityFeatures;
                                $selectedamenities = explode(',', $amenityfn);
                                @endphp
                                <h4 class="p-2">Amenities <span>(Maximum Aminities-20)</span></h4>
                                @foreach ($amenities as $row)
                                <div class="col-xl-6 col-xxl-6 col-md-6 mt-2">
                                    <div class="amenities_check_area">
                                        <div class="wsus__pro_check">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $row->Id }}" name="amenities[]"
                                                    id="flexCheckIndeterminate"
                                                    @if (in_array($row->Id, $selectedamenities)) checked @endif>

                                                <label class="form-check-label" for="flexCheckIndeterminate">
                                                    {{ $row->Amenity }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @php
                            $featuresfn = $propertyinfo->PropertyFeatures;
                            $selectedFeatures = explode(',', $featuresfn);
                            @endphp
                            <div class="row mt-1">
                                <h4 class="p-2">Apartment Features <span> (listed in alphabetical order) </span>
                                </h4>
                                @foreach ($apartmentFeature as $feature)
                                <div class="col-xl-6 col-xxl-4 col-md-6 mt-2">
                                    <div class="amenities_check_area">
                                        <div class="wsus__pro_check">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="apartmentfeatures[]" value="{{ $feature->Id }}"
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

                            <div class="row mt-1">
                                <div class="col-xl-12 pb-4">
                                    <div class="my_listing_single">
                                        <button type="submit" class="read_btn float-right mt-1">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

                <section id="additionaldetails" data-tab-content>
                    <div class="my_listing list_mar list_padding">
                        <h2>Additional Details</h2>
                        <form id="additionalDetailsForm" action="{{ route('edit-additional-detail', ['id' => $propertyinfo->Id]) }}" method="POST">
                            @csrf
                            <div class="row mt-1">
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label for="leasing_terms">:: Leasing Terms ::</label>
                                        <textarea class="form-control summer_note mt-1" id="leasing_terms" name="leasing_terms">{{ @$propertyinfo->propertyAdditionalInfo->LeasingTerms }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label for="qualifying_criteria">:: Qualifying Criteria ::</label>
                                        <textarea class="form-control summer_note mt-1" id="qualifying_criteria" name="qualifying_criteria">{{ @$propertyinfo->propertyAdditionalInfo->QualifiyingCriteria }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label for="parking">:: Parking ::</label>
                                        <textarea class="form-control summer_note mt-1" id="parking" name="parking">{{ @$propertyinfo->propertyAdditionalInfo->Parking }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label for="pet_policy">:: Pet Policy ::</label>
                                        <textarea class="form-control summer_note mt-1" id="pet_policy" name="pet_policy">{{ @$propertyinfo->propertyAdditionalInfo->PetPolicy }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label for="neighborhood">:: Neighborhood ::</label>
                                        <textarea class="form-control summer_note mt-1" id="neighborhood" name="neighborhood">{{ @$propertyinfo->propertyAdditionalInfo->Neighborhood }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label for="schools">:: Schools ::</label>
                                        <textarea class="form-control summer_note mt-1" id="schools" name="schools">{{ @$propertyinfo->propertyAdditionalInfo->Schools }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label for="driving_directions">:: Driving Directions ::</label>
                                        <textarea class="form-control summer_note mt-1" id="driving_directions" name="driving_directions">{{ @$propertyinfo->propertyAdditionalInfo->drivedirection }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="propertyId" value="{{ $propertyId }}"
                                id="additonalDetailPropertyId">
                            <div class="row mt-1">
                                <div class="col-xl-12 pb-4">
                                    <div class="my_listing_single">
                                        <button type="submit" class="read_btn float-right mt-1">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

                <section id="rentspecial" data-tab-content>
                    <p class="d-flex justify-content-end">
                        <a href="{{ route('create-floor-plan', ['id' => $propertyinfo->Id]) }}" class="primary-btn d-flex gap-2"><i class="bi bi-clipboard-plus"></i><span class="text-white"> Create New Floorplan </span></a>
                    </p>
                    <div class="my_listing list_mar list_padding">
                        @foreach ($categories as $category)
                        <h5 class="m-2 p-2">{{ $category->Name }}</h5>
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
                                                <input type="checkbox" id="deletefloorPlan"
                                                    name="deletefloorPlan" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-5">
                                            <label for="" class="fw-700"> Category </label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input_area">
                                                <select
                                                    class="form-control form-select form-control-a state-select-box"
                                                    name="editpropertystate" id="editpropertystate"
                                                    required>
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
                                            <label for="" class="fw-700">Floor Plan</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input_area">
                                                <input type="text" id="floorPlan" name="floorPlan"
                                                    value="{{ $floorDetail->PlanName }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-5">
                                            <label for="" class="fw-700">Square Footage</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input_area">
                                                <input type="text" id="floorPlan" name="floorPlan"
                                                    value="{{ $floorDetail->Footage }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-5">
                                            <label for="" class="fw-700">Starting at</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input_area">
                                                <input type="text" id="Price" name="Price"
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
                                                <input type="text" id="Price" name="Price"
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
                                                <input type="text" id="Price" name="Price"
                                                    value="{{ $floorDetail->floorplan_link }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-5">
                                            <label for="" class="fw-700">Available Url</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input_area">
                                                <input type="text" id="Price" name="Price"
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
                                                <input type="text" id="Price" name="Price"
                                                    value="{{ $floorDetail->deposit }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-5">
                                            <label for="" class="fw-700">Unit Description Specials
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
                                            <label for="" class="fw-700">Available Date</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input_area">
                                                <input type="date" name="" id=""
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
                </section>

                <section id="imagegallary" data-tab-content>
                    <div class="relative font-inter antialiased my_listing_table">
                        <main class="relative min-h-screen flex flex-col justify-center bg-slate-50 overflow-hidden">
                            <div class="w-full max-w-6xl mx-auto px-4 md:px-5 py-24">
                                <div class="flex justify-center">
                                    <div class="w-full max-w-2xl bg-white shadow-xl rounded-2xl">
                                        <div class="p-3">
                                            <div class="overflow-x-auto">
                                                <table class="table-auto w-full">
                                                    <thead class="text-[13px] text-slate-500/70">
                                                        <tr>
                                                            <th
                                                                class="px-3 py-2 first:pl-3 last:pr-3 bg-slate-100 first:rounded-l last:rounded-r last:pl-5 last:sticky last:right-0">
                                                                <div class="font-medium text-left">#</div>
                                                            </th>
                                                            <th
                                                                class="px-3 py-2 first:pl-3 last:pr-3 bg-slate-100 first:rounded-l last:rounded-r last:pl-5 last:sticky last:right-0">
                                                                <div class="font-medium text-left">Image</div>
                                                            </th>
                                                            <th
                                                                class="px-5 py-2 first:pl-3 last:pr-3 bg-slate-100 first:rounded-l last:rounded-r last:pl-5 last:sticky last:right-0">
                                                                <div class="font-medium text-left">Logo</div>
                                                            </th>
                                                            <th
                                                                class="px-5 py-2 first:pl-3 last:pr-3 bg-slate-100 first:rounded-l last:rounded-r last:pl-5 last:sticky last:right-0">
                                                                <div class="font-medium text-left">FloorPlan</div>
                                                            </th>
                                                            <th
                                                                class="px-3 py-2 first:pl-3 last:pr-3 bg-slate-100 first:rounded-l last:rounded-r last:pl-5 last:sticky last:right-0">
                                                                <div class="font-medium text-left">Set Image
                                                                </div>
                                                            </th>
                                                            <th
                                                                class="px-3 py-2 first:pl-3 last:pr-3 bg-slate-100 first:rounded-l last:rounded-r last:pl-5 last:sticky last:right-0">
                                                                <div class="font-medium text-left">Action </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-sm font-medium">
                                                        @if ($galleryDetails && $galleryDetails->gallerydetail)
                                                        @foreach ($galleryDetails->gallerydetail as $imagerec)
                                                        <tr>
                                                            <td class="px-3 py-3 border-b border-slate-200">
                                                                <div class="text-slate-500">
                                                                    {{ $loop->iteration }}
                                                                </div>
                                                            </td>
                                                            <td class="px-3 py-3 border-b border-slate-200">
                                                                <div class="flex items-center">
                                                                    @php
                                                                    $imageName =
                                                                    $imagerec->ImageName ?? null;
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
                                                            <td class="px-3 py-3 border-b border-slate-200">
                                                                <div class="text-slate-500">
                                                                    <input type="checkbox" id="vehicle1"
                                                                        name="propertylogo"
                                                                        {{ $imagerec->DefaultImage ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td class="px-3 py-3 border-b border-slate-200">
                                                                <div class="text-slate-900">
                                                                    <input type="checkbox" id="vehicle1"
                                                                        name="" value="Bike">
                                                                </div>
                                                            </td>
                                                            <td class="px-3 py-3 border-b border-slate-200">
                                                                <div class="text-slate-900">
                                                                    <select
                                                                        class="form-control form-select form-control-a state-select-box"
                                                                        name="editpropertystate"
                                                                        id="editpropertystate" required
                                                                        style="width:70%;">
                                                                        <option value="">Select Floor
                                                                            Plan</option>
                                                                        @foreach ($selectFloorPlan as $row)
                                                                        <option
                                                                            value="{{ $row->Id }}">
                                                                            {{ $row->PlanName }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td class="px-3 py-3 border-b border-slate-200">
                                                                <div class="demo-btn-list d-flex"
                                                                    style="gap: 5px;">
                                                                    <a href=""
                                                                        class="btn-primary-icon px-2 py-1 border rounded m-1"
                                                                        data-bs-toggle="tooltip"
                                                                        title="View">
                                                                        <i class="bi bi-eye"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)"
                                                                        class="btn-danger-icon px-2 py-1 border rounded m-1 delete-gllry-img"
                                                                        data-id="{{ $imagerec->Id }}"
                                                                        data-bs-toggle="tooltip"
                                                                        data-value="{{ $propertyId }}"
                                                                        title="Delete">
                                                                        <i class="bi bi-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td colspan="6" class="text-center text-slate-500">
                                                                No images found.
                                                            </td>
                                                        </tr>
                                                        @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>

                    <div class="content mt-3">
                        <div class="my_listing list_mar list_padding">
                            <label for="" class="px-3 py-2">
                                <h5> :: Add Image in Gallery :: </h5>
                            </label>
                            <div class="row mt-2 p-3 ">
                                <form id="uploadImageForm" enctype="multipart/form-data" action="{{ route('upload-image') }}" method="POST">
                                    @csrf
                                    <div class="col-xl-12 col-md-6">
                                        <div class="my_listing_single">
                                            <label>Image Title</label>
                                            <div class="input_area">
                                                <input type="text" name="imagetitle" id="imagetitle">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-md-6">
                                        <div class="my_listing_single">
                                            <label>Description</label>
                                            <div class="input_area">
                                                <input type="text" name="description" id="description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-md-6">
                                        <div class="my_listing_single">
                                            <label>Image <span class="text-danger">*</span></label>
                                            <div class="input_area input_area_2">
                                                <input type="file" id="propertyimage" name="propertyimage">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="property_id" id="property_id"
                                        value="{{ $propertyinfo->Id }}">
                                    <div class="col-12">
                                        <button type="submit" class="read_btn float-right mt-2">Submit</button>
                                    </div>
                                </form>
                                <div id="successMessage" class="mt-2"></div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>



<script>
    @if(session('success'))
    toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
    toastr.error("{{ session('error') }}");
    @endif
</script>
@endsection
@push('scripts')
<script>
    $('#additionalDetailsForm').on('submit', function() {
        $('.summer_note').each(function() {
            $(this).val($(this).summernote('code')); // sync content to textarea
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('vendor/js/tabviewform.js') }}"></script>
@endpush
