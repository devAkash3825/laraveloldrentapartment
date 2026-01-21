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

    .section-t2 {
        background: #f1f5f9;
        padding: 6px;
        border-radius: 12px;
        margin-bottom: 25px;
    }
    .section-t2 .tabs {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 6px;
        justify-content: space-between;
    }
    .tab-li {
        flex: 1;
    }
    .tab-li__link {
        display: block;
        padding: 12px 10px;
        text-align: center;
        text-decoration: none !important;
        color: #64748b !important;
        font-weight: 700;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border-radius: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: transparent;
    }
    .tab-li__link.active {
        background: white;
        color: var(--colorPrimary) !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .my_listing_single {
        margin-bottom: 25px;
    }
    .my_listing_single label {
        display: block;
        font-weight: 700;
        margin-bottom: 6px;
        color: #475569;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .input_area input, .input_area select, .input_area textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        background: #fdfdfd;
        font-size: 0.95rem;
        transition: all 0.2s;
        color: #1e293b;
    }
    .input_area input:focus, .input_area select:focus, .input_area textarea:focus {
        border-color: var(--colorPrimary);
        background: white;
        box-shadow: 0 0 0 4px rgba(var(--colorPrimaryRgb, 106,100,241), 0.1);
        outline: none;
    }
    .my_listing {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid #f1f5f9;
        margin-bottom: 30px;
    }

    /* Standardized Premium Table Styles */
    .recent-table-container {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .table-header-box {
        padding: 24px 30px;
        border-bottom: 1px solid #f1f5f9;
        background: #fff;
    }

    .table-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.025em;
    }

    .custom-premium-table thead th {
        font-weight: 600;
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.05em;
        color: #64748b;
        padding: 14px 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .custom-premium-table tbody td {
        padding: 14px 20px;
        color: #334155;
        font-size: 0.85rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .custom-premium-table tbody tr:last-child td {
        border-bottom: none;
    }

    .custom-premium-table tbody tr:hover {
        background-color: #f8fafc;
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
                    <div class="my_listing list_padding">
                        <form class="py-2" action="{{ route('edit-property-detail', ['id' => $propertyinfo->Id]) }}" method="POST" id="propertyEditForm">
                            @csrf
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
                                            <select class="form-control form-select form-control-a state-dropdown"
                                                name="editpropertystate" id="editpropertystate" data-city-target="#editpropertycity" required>
                                                @foreach ($state as $row)
                                                <option value="{{ $row->Id }}"
                                                    {{ (isset($propertyinfo->city->state) && $propertyinfo->city->state->Id == $row->Id) ? 'selected' : '' }}>
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
                                        <textarea class="form-control mt-1" id="qualifying_criteria" name="qualifying_criteria" rows="5">{{ @$propertyinfo->propertyAdditionalInfo->QualifiyingCriteria }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label for="parking">:: Parking ::</label>
                                        <textarea class="form-control mt-1" id="parking" name="parking" rows="5">{{ @$propertyinfo->propertyAdditionalInfo->Parking }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label for="pet_policy">:: Pet Policy ::</label>
                                        <textarea class="form-control mt-1" id="pet_policy" name="pet_policy" rows="5">{{ @$propertyinfo->propertyAdditionalInfo->PetPolicy }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label for="neighborhood">:: Neighborhood ::</label>
                                        <textarea class="form-control mt-1" id="neighborhood" name="neighborhood" rows="5">{{ @$propertyinfo->propertyAdditionalInfo->Neighborhood }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label for="schools">:: Schools ::</label>
                                        <textarea class="form-control mt-1" id="schools" name="schools" rows="5">{{ @$propertyinfo->propertyAdditionalInfo->Schools }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label for="driving_directions">:: Driving Directions ::</label>
                                        <textarea class="form-control mt-1" id="driving_directions" name="driving_directions" rows="5">{{ @$propertyinfo->propertyAdditionalInfo->drivedirection }}</textarea>
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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Rent & Specials</h4>
                        <a href="{{ route('create-floor-plan', ['id' => $propertyinfo->Id]) }}" class="read_btn d-inline-flex gap-2 text-decoration-none">
                            <i class="bi bi-clipboard-plus"></i>
                            <span>Create New Floorplan</span>
                        </a>
                    </div>

                    @foreach ($categories as $category)
                    <div class="category-section mb-5">
                        <h5 class="category-title py-2 px-3 bg-light rounded-2 border-start border-4 border-primary mb-4">{{ $category->Name }}</h5>
                        
                        @php
                        $propertyId = $propertyinfo->Id;
                        $categoryId = $category->Id;
                        $floorDetails = $category->getFloorPlanDetails($propertyId, $categoryId);
                        @endphp

                        @if (count($floorDetails) > 0)
                            <div class="row g-4">
                                @foreach ($floorDetails as $floorDetail)
                                <div class="col-md-12">
                                    <div class="card shadow-sm border-0 h-100 floorplan-card">
                                        <div class="card-body p-4">
                                            <form action="{{ route('update-floor-plan', ['id' => $floorDetail->Id]) }}" method="POST">
                                                @csrf
                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                                        <label class="form-label small fw-bold">Plan Name</label>
                                                        <input type="text" class="form-control form-control-sm" name="plan_name" value="{{ $floorDetail->PlanName }}" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label small fw-bold">Plan Type</label>
                                                        <input type="text" class="form-control form-control-sm" name="plan_type" value="{{ $floorDetail->PlanType }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label small fw-bold">SQFT</label>
                                                        <input type="text" class="form-control form-control-sm" name="square_footage" value="{{ $floorDetail->Footage }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label small fw-bold">Rent ($)</label>
                                                        <input type="number" class="form-control form-control-sm" name="starting_at" value="{{ $floorDetail->Price }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label small fw-bold">Category</label>
                                                        <select class="form-select form-select-sm" name="category" required>
                                                            @foreach ($categories as $cat)
                                                                <option value="{{ $cat->Id }}" {{ $category->Id == $cat->Id ? 'selected' : '' }}>{{ $cat->Name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label small fw-bold">Deposit ($)</label>
                                                        <input type="text" class="form-control form-control-sm" name="deposit" value="{{ $floorDetail->deposit }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label small fw-bold">Available Date</label>
                                                        <input type="text" class="form-control form-control-sm" name="avail_date" value="{{ $floorDetail->avail_date }}" placeholder="YYYY-MM-DD or text">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label small fw-bold">Available URL</label>
                                                        <input type="text" class="form-control form-control-sm" name="available_url" value="{{ $floorDetail->Available_Url }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label small fw-bold">Link</label>
                                                        <input type="text" class="form-control form-control-sm" name="link" value="{{ $floorDetail->floorplan_link }}">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Comments / Specials</label>
                                                        <textarea class="form-control form-control-sm" name="unit_description" rows="2">{{ $floorDetail->Comments }}</textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold">Specials Note</label>
                                                        <textarea class="form-control form-control-sm" name="special" rows="2">{{ $floorDetail->special }}</textarea>
                                                    </div>

                                                    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                                                        <button type="submit" class="read_btn py-1 px-3 fs-6">
                                                            <i class="bi bi-save me-1"></i> Save Changes
                                                        </button>
                                                        <button type="button" class="btn btn-outline-danger btn-sm px-3 rounded-pill" onclick="if(confirm('Are you sure you want to delete this floor plan?')) { document.getElementById('delete-fp-{{ $floorDetail->Id }}').submit(); }">
                                                            <i class="bi bi-trash me-1"></i> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <form id="delete-fp-{{ $floorDetail->Id }}" action="{{ route('delete-floor-plan', ['id' => $floorDetail->Id]) }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-light border text-center py-4 rounded-3">
                                <i class="bi bi-info-circle fs-4 d-block mb-2 text-muted"></i>
                                <p class="mb-0 text-muted">No floor plans found in this category.</p>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </section>

                <section id="imagegallary" data-tab-content>
                    <div class="recent-table-container mt-4">
                        <div class="table-header-box">
                            <h4 class="table-title">Image Gallery</h4>
                            <p class="text-muted small mb-0 mt-1">Manage property images, logos, and floorplans</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table custom-premium-table mb-0">
                                <thead>
                                    <tr>
                                        <th width="80" class="text-center">#</th>
                                        <th>Preview</th>
                                        <th width="100" class="text-center">Logo</th>
                                        <th width="200">Floor Plan Link</th>
                                        <th width="120" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($galleryDetails && $galleryDetails->gallerydetail)
                                        @foreach ($galleryDetails->gallerydetail as $imagerec)
                                            <tr>
                                                <td class="text-center text-muted fw-bold">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        @php
                                                            $imageName = $imagerec->ImageName ?? null;
                                                        @endphp
                                                        @if ($imageName)
                                                            <img src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $propertyId }}/Original/{{ $imageName }}"
                                                                alt="Property Image"
                                                                class="rounded shadow-sm"
                                                                style="width:80px; height:60px; object-fit: cover;">
                                                        @else
                                                            <img src="{{ asset('img/no-img.jpg') }}" alt="Default" class="rounded shadow-sm" style="width:80px; height:60px; object-fit: cover;">
                                                        @endif
                                                        <div>
                                                            <div class="fw-semibold text-dark">{{ $imagerec->ImageTitle ?? 'No Title' }}</div>
                                                            <div class="text-muted smaller" style="font-size: 0.75rem;">{{ Str::limit($imagerec->Description, 40) }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input" type="checkbox" name="propertylogo" {{ $imagerec->DefaultImage ? 'checked' : '' }} disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select class="form-select form-select-sm" disabled>
                                                        <option value="">None</option>
                                                        @foreach ($selectFloorPlan as $row)
                                                            <option value="{{ $row->Id }}">{{ $row->PlanName }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <a href="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $propertyId }}/Original/{{ $imageName }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-circle delete-gllry-img" data-id="{{ $imagerec->Id }}" data-value="{{ $propertyId }}" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                No images found in gallery.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
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
    $(document).ready(function() {
        // Additional Details Form Sync


        // Gallery Image Deletion
        $('.delete-gllry-img').on('click', function() {
            const id = $(this).data('id');
            const propertyId = $(this).data('value');
            const row = $(this).closest('tr');

            if (confirm('Are you sure you want to delete this image?')) {
                $.ajax({
                    url: "{{ url('/delete-gallery-image') }}/" + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        propertyId: propertyId
                    },
                    success: function(response) {
                        if (response.success) {
                            row.fadeOut(300, function() {
                                $(this).remove();
                            });
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting image. Please try again.');
                    }
                });
            }
        });

        // Year select population
        const currentYear = new Date().getFullYear();
        const startYear = 1900;
        const yearSelect = $('#year-select, #year-remodeled');
        
        for (let year = currentYear; year >= startYear; year--) {
            yearSelect.append(`<option value="${year}">${year}</option>`);
        }

        // Set selected years if available
        $('#year-select').val("{{ $propertyinfo->Year }}");
        $('#year-remodeled').val("{{ $propertyinfo->YearRemodel }}");

        // Trigger initial city load for edit mode
        const editPropertyState = document.getElementById('editpropertystate');
        if (editPropertyState && editPropertyState.value) {
            const editPropertyCity = document.getElementById('editpropertycity');
            const selectedCityId = document.getElementById('editselectedCity').value;
            if (editPropertyCity) {
                window.CityStateHandler.loadCities(editPropertyState.value, editPropertyCity, false).then(() => {
                    if (selectedCityId) {
                        editPropertyCity.value = selectedCityId;
                        if (typeof jQuery !== 'undefined' && jQuery.fn.select_2) {
                            jQuery(editPropertyCity).trigger('change');
                        }
                    }
                });
            }
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('vendor/js/tabviewform.js') }}"></script>
@endpush

<style>
       .read_btn {
        background: var(--colorPrimary);
        color: white !important;
        border: none;
        border-radius: 8px;
        padding: 8px 24px;
        font-weight: 600;
        font-size: 0.88rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .read_btn:hover {
        background: #1a1a1a;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        color: white !important;
    }

    .btn-outline-danger {
        border: 1px solid #fee2e2;
        background: #fff;
        color: #dc2626 !important;
        transition: all 0.2s;
    }
    .btn-outline-danger:hover {
        background: #dc2626;
        color: #fff !important;
        border-color: #dc2626;
    }

    .floorplan-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        border: 1px solid #f1f5f9 !important;
    }
    .floorplan-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.06) !important;
        border-color: #e2e8f0 !important;
    }
    .category-title {
        color: #1e293b;
        font-weight: 700;
        letter-spacing: -0.01em;
    }
    .form-control-sm, .form-select-sm {
        border-radius: 8px;
        border-color: #e2e8f0;
        padding: 0.5rem 0.75rem;
    }
    .form-label.small {
        margin-bottom: 0.35rem;
        color: #64748b;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
</style>
