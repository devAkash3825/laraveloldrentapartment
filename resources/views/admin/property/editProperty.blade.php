@extends('admin/layouts/app')

@section('title', 'RentApartments Admin | Edit Property')

@push('style')
<link rel="stylesheet" href="{{ asset('admin_asset/css/tabview.css') }}">
@endpush
@section('content')

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
                    <form id="editdetails" action="{{ route('admin-edit-property-details') }}" method="POST" class="needs-validation">
                        @csrf
                        <input type="hidden" name="propertyId" value="{{ $propertyId }}">

                        <input type="hidden" name="yearbuildvalue" id="yearbuildvalue"
                            value="{{ $propertyinfo->Year }}">
                        <input type="hidden" name="yearremodeledvalue" id="yearremodeledvalue"
                            value="{{ $propertyinfo->YearRemodel }}">

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="managername"> User Name </label>
                                <select class="form-control" id="managername" name="managername">
                                    <option value="{{ optional($propertyinfo->login)->Id }}">
                                        {{ optional($propertyinfo->login)->UserName ?? 'Select Manager' }}
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
                                <select class="form-control state-dropdown" id="editpropertystate" name="editpropertystate"
                                    data-city-target="#editpropertycity" required>
                                    @foreach ($state as $row)
                                    <option value="{{ $row->Id }}"
                                        {{ optional(optional($propertyinfo->city)->state)->Id == $row->Id ? 'selected' : '' }}>
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
                                    @if($propertyinfo->city)
                                        <option value="{{ $propertyinfo->city->Id }}" selected>{{ $propertyinfo->city->CityName }}</option>
                                    @endif
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
                                <textarea rows="3" class="form-control" name="officeHours" id="officeHours">{{ $propertyinfo->officehour ?? '' }}</textarea>
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
                    <form id="generaldetailsform" action="{{ route('admin-edit-general-details') }}" method="POST" class="needs-validation">
                        @csrf
                        <div class="form-row">
                            <input type="hidden" name="property_id" id=""
                                value="{{ $propertyinfo->Id }}">

                            <div class="form-group col-md-12">
                                <h4 class="p-2">:: Community Descriptions ::</h4>
                                <textarea id="editcommunitydescription" name="editcommunitydescription" class="form-control" rows="5">
                                {{ @$propertyinfo->communitydescription->Description ? @$propertyinfo->communitydescription->Description : '' }}
                                </textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <h4 class="p-2">:: Agent Comments ::</h4>
                                <textarea id="editagentcomments" name="editagentcomments" class="form-control" rows="5">
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
                                <textarea id="editkeyword" name="editkeyword" class="form-control" rows="3">
                                {{ $propertyinfo->Keyword ?? '' }}
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
                    <form id="additionaldetailsform" action="{{ route('admin-edit-additional-details') }}" method="POST" class="needs-validation">
                        @csrf
                        <div class="form-row">
                            <input type="hidden" name="property_id" id=""
                                value="{{ $propertyinfo->Id }}">

                            <div class="form-group col-md-12">
                                <h4 class="p-2">:: Leasing Terms ::</h4>
                                <textarea id="editleasingterm" name="editleasingterm" class="form-control" rows="5">
                                {{ @$propertyinfo->propertyAdditionalInfo->LeasingTerms ? @$propertyinfo->propertyAdditionalInfo->LeasingTerms : '' }}
                                </textarea>

                            </div>

                            <div class="form-group col-md-12">
                                <h4 class="p-2">:: Qualifiying Criteria ::</h4>
                                <textarea id="editqualifyingcriteria" name="editqualifyingcriteria" class="form-control" rows="5">
                                {{ @$propertyinfo->propertyAdditionalInfo->QualifiyingCriteria ? @$propertyinfo->propertyAdditionalInfo->QualifiyingCriteria : '' }}
                                </textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <h4 class="p-2">:: Parking ::</h4>
                                <textarea id="editparking" name="editparking" class="form-control" rows="5">
                                {{ @$propertyinfo->propertyAdditionalInfo->Parking ? @$propertyinfo->propertyAdditionalInfo->Parking : '' }}
                                </textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <h4 class="p-2"> :: Pet Policy :: </h4>
                                <p> Please check boxes for breeds you DO ACCEPT </p>
                                @php
                                    $selectedPets = explode(',', @$propertyinfo->propertyAdditionalInfo->Pets ?? '');
                                @endphp
                                <div class="row mt-1">
                                    @foreach ($petList as $pet)
                                        <div class="col-xl-4 col-md-6 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                    name="pets[]" value="{{ $pet->id }}" 
                                                    id="petCheck{{ $pet->id }}"
                                                    {{ in_array($pet->id, $selectedPets) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="petCheck{{ $pet->id }}">
                                                    {{ $pet->Pets }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <h4 class="p-2">:: Neighborhood ::</h4>
                                <textarea id="editneighbourhood" name="editneighbourhood" class="form-control" rows="5">
                                {{ @$propertyinfo->propertyAdditionalInfo->Neighborhood ? @$propertyinfo->propertyAdditionalInfo->Neighborhood : '' }}
                                </textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <h4 class="p-2">:: Driving Directions ::</h4>
                                <textarea id="editdrivingdirection" name="editdrivingdirection" class="form-control" rows="5">
                                {{ @$propertyinfo->propertyAdditionalInfo->drivedirection ? @$propertyinfo->propertyAdditionalInfo->drivedirection : '' }}
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
                <div class="p-3 bg-white border border-top-0">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="slim-card-title">Rent & Specials</h6>
                        <a href="{{ route('admin-add-floor-plan', ['id' => $propertyId]) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus ms-1"></i> Create New Unit
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Plan Name</th>
                                    <th>Plan Type</th>
                                    <th>Price</th>
                                    <th>Footage</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selectFloorPlan as $floorDetail)
                                    <tr>
                                        <td>{{ $floorDetail->propertyfloorplancategory->Name ?? 'N/A' }}</td>
                                        <td>{{ $floorDetail->PlanName }}</td>
                                        <td>{{ $floorDetail->PlanType }}</td>
                                        <td>${{ number_format($floorDetail->Price, 0) }}</td>
                                        <td>{{ $floorDetail->Footage }} sq ft</td>
                                        <td>
                                            <a href="{{ route('admin-edit-floor-plan', ['id' => $floorDetail->Id]) }}" class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm delete-floor-plan" data-id="{{ $floorDetail->Id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($selectFloorPlan->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center p-4">
                                            <div class="text-muted">No floor plans found for this property.</div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
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
                                    @if ($galleryDetails != '' && $galleryDetails->gallerydetail->isNotEmpty())
                                        @foreach ($galleryDetails->gallerydetail as $imagerec)
                                        <tr data-id="{{ $imagerec->Id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @php
                                                    $imageName = $imagerec->ImageName ?? null;
                                                @endphp
                                                @if ($imageName)
                                                    <img src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $propertyId }}/Original/{{ $imageName }}"
                                                        alt="Property Image"
                                                        style="width:70px; height:70px; object-fit: cover;">
                                                @else
                                                    <img class="img-fluid" src="{{ asset('img/no-img.jpg') }}" alt="Default Image" style="width:70px;">
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <input type="radio" name="is_default_radio" class="set-default-img" 
                                                    {{ $imagerec->DefaultImage ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm gallery-title" value="{{ $imagerec->ImageTitle }}" placeholder="Title">
                                                <textarea class="form-control form-control-sm mt-1 gallery-desc" placeholder="Description">{{ $imagerec->Description }}</textarea>
                                            </td>
                                            <td>
                                                <select class="form-control form-control-sm gallery-floorplan">
                                                    <option value="">None</option>
                                                    @foreach ($selectFloorPlan as $fp)
                                                        <option value="{{ $fp->Id }}" {{ $imagerec->floorplan_id == $fp->Id ? 'selected' : '' }}>
                                                            {{ $fp->PlanName }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-primary btn-sm update-gallery-item" title="Update">
                                                        <i class="fa fa-save"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm delete-gallery-item" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center p-4 text-muted">No gallery images found.</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="section-wrapper mt-4">
                    <form action="{{ route('upload-gallery-image') }}" method="POST" id="upload-image-gallery" enctype="multipart/form-data">
                        @csrf
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

{{-- Hidden support forms for traditional submits --}}
<form id="deleteFloorPlanForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="deleteGalleryImageForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="updateGalleryDetailsForm" action="{{ route('admin-update-gallery-details') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="id" id="upd_gallery_id">
    <input type="hidden" name="image_title" id="upd_gallery_title">
    <input type="hidden" name="description" id="upd_gallery_desc">
    <input type="hidden" name="floorplan_id" id="upd_gallery_floorplan">
    <input type="hidden" name="is_default" id="upd_gallery_default">
</form>
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






        $('#editdetails').validate({
            errorClass: "error",
            validClass: "is-valid",
            rules: {
                managername: {
                    required: true
                },
                propertyName: {
                    required: true
                },
                propertyContact: {
                    required: true
                },
                managementCompany: {
                    required: true
                },
                numberOfUnits: {
                    required: true
                },
                leasingEmail: {
                    required: true,
                    email: true
                },
                yearBuilt: {
                    required: true
                },
                editpropertystate: {
                    required: true
                },
                editpropertycity: {
                    required: true
                },
                zipCode: {
                    required: true
                }
            },
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                error.insertAfter(element);
            },
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        $(document).on('click', '.delete-floor-plan', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this floor plan?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#deleteFloorPlanForm');
                    form.attr('action', "{{ url('/admin/property/delete-floor-plan') }}/" + id);
                    form.submit();
                }
            });
        });

        $(document).on('click', '.delete-gallery-item', function(e) {
            e.preventDefault();
            var row = $(this).closest('tr');
            var id = row.data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this image?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#deleteGalleryImageForm');
                    form.attr('action', "{{ url('/admin/property/delete-gallery-image') }}/" + id);
                    form.submit();
                }
            });
        });

        $(document).on('click', '.update-gallery-item', function(e) {
            e.preventDefault();
            var btn = $(this);
            var row = btn.closest('tr');
            var id = row.data('id');
            
            $('#upd_gallery_id').val(id);
            $('#upd_gallery_title').val(row.find('.gallery-title').val());
            $('#upd_gallery_desc').val(row.find('.gallery-desc').val());
            $('#upd_gallery_floorplan').val(row.find('.gallery-floorplan').val());
            $('#upd_gallery_default').val(row.find('.set-default-img').is(':checked') ? 1 : 0);
            
            $('#updateGalleryDetailsForm').submit();
        });
    });
</script>
@endpush
