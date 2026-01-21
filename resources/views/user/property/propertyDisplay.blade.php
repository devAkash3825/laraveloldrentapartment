@extends('user.layout.app')
@section('content')
@section('title', 'Property | ' . $propertyDetails['propertyname'])
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
<style>
    #map {
        height: 500px;
        width: 100% !important;
    }

    .page-content {
        padding: 32px;
        background: #fff;
        min-height: 100vh;
    }

    [data-tab-content] {
        display: none;
    }

    .active[data-tab-content] {
        display: block;
    }

    .tabs {
        display: flex;
        justify-content: space-around;
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .tab {
        flex: 1;
        font-weight: 600;
        text-align: center;
        text-transform: uppercase;
        cursor: pointer;
        padding: 10px;
        border-bottom: 1px solid #cdcdcd;
    }

    .tab.active {
        color: #1babf9;
        border-bottom: 2px solid #1babf9;
    }

    .tab-li {
        flex: 1;
        margin-bottom: 0;
    }

    .tab-li a {
        display: block;
        text-align: center;
        background-color: #fff;
        border: 1px solid #ced4da;
        color: #495057;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 50px;
        text-transform: uppercase;
        font-weight: 700;
        font-size: 13px;
        letter-spacing: 1px;
        align-content: center;
    }


    .tab-li a {
        text-decoration: none;
        white-space: nowrap;
        padding: 10px;
        -webkit-user-drag: none;
        user-select: none;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        display: block;
    }

    #maindetails {
        padding: 10px 17px !important;
    }

    .item {
        align-items: center;
        background-color: #fff;
        color: white;
        display: flex;
        height: 100%;
        justify-content: center;
    }

    .property-slider .owl-nav span {
        background: var(--colorPrimary);
        height: 10px;
        width: 10px;
        padding: 17px 18px 18px 18px;
        display: flex;
        align-items: center;
        color: #fff;
        font-size: 27px;
        justify-content: center;
        border-radius: 5px;
    }

    .owl-theme .owl-nav [class*='owl-']:hover {
        background: #ffffff;
        color: #FFF;
        text-decoration: none;
    }

    .property-slider .owl-theme .owl-nav {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 0px;
    }
</style>
@endpush

<!-- Premium Header -->
<div class="header-premium-gradient py-5 position-relative overflow-hidden" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $propertyDetails['id'] }}/Original/{{ $propertyDetails['listingImages']['ImageName'] ?? 'default.jpg' }}'); background-size: cover; background-position: center;">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1 class="text-white fw-bold display-5 mb-2">{{ $propertyDetails['propertyname'] }}</h1>
                <p class="text-white opacity-75 lead mb-0"><i class="bi bi-geo-alt-fill me-2"></i>{{ $propertyDetails['address'] }}, {{ $propertyDetails['city'] }}</p>
            </div>
            <div class="col-md-5 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('list-properties') }}" class="text-white opacity-75 text-decoration-none small">Properties</a></li>
                        <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>


<section class="property-single nav-arrow-b">
    <div class="container p-4 mt-3">
        <div class="row justify-content-between pt-5">
            <div class="col-xl-8 col-lg-7">
                <div class="listing_details_text listing_det_header property-desktop-block">
                    <div class="listing_det_header">
                        <div class="listing_det_header_img">
                            <img src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $propertyDetails['id'] }}/Original/{{ $propertyDetails['listingImages']['ImageName'] ?? 'default.jpg' }}"
                                alt="logo" class="img-fluid w-100">
                        </div>
                        <div class="listing_det_header_text">
                            <h6>{{ $propertyDetails['propertyname'] }}</h6>
                            <p class="host_name"> Hosted by
                                <a href="javascript:void(0)"
                                    class="text-primary">
                                    {{ $propertyDetails['manageBy'] }}
                                </a>
                            </p>
                            <ul class="mt-3">
                                <li id="addtofavorite" value="{{ $propertyDetails['id'] }}" class="addtofavorite">
                                    <a href="javascript:void(0)">
                                        <i class="bi bi-heart-fill" style="display: none;"></i>
                                        <i class="bi bi-heart"></i>
                                        Add to Favorite
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="listing_det_text">
                        <p class="description color-text-a" style="font-size:1.1rem;">
                            Use this Request Quote form to have managers review your needs and send you their best
                            possible
                            rate.<br>
                            We work on commission so tip your waiter and put Vita on guest cards and
                            applications.<br>
                            Need help picking properties? Click Live Chat at the top of the page to talk to one of
                            our
                            rental search techs.
                        </p>
                        <input type="hidden" value="{{ $propertyDetails['lon'] }}" id="prop_lon">
                        <input type="hidden" value="{{ $propertyDetails['lat'] }}" id="prop_lat">
                        <input type="hidden" value="{{ $propertyDetails['propertyname'] }}" id="prop_name">
                    </div>
                    <div class="listing_det_Photo  gallary-desktop">
                        <div class="row">
                            @php
                            $allImages =
                            is_array($propertyDetails['allimages']) || is_object($propertyDetails['allimages'])
                            ? $propertyDetails['allimages']
                            : [];
                            @endphp
                            @foreach ($allImages as $key => $image)
                            <div class="col-xl-2 col-sm-6 col-6">
                                <a class="venobox vbox-item" data-gall="gallery01"
                                    href="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $propertyDetails['id'] }}/Original/{{ $image->ImageName ?? 'default.jpg' }}">
                                    <img src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $propertyDetails['id'] }}/Original/{{ $image->ImageName ?? 'default.jpg' }}"
                                        alt="gallery1" class="display-property-img">
                                    <div class="photo_overlay">
                                        <i class="fal fa-plus" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row property-slider">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="contain">
                                <div id="owl-carousel" class="owl-carousel owl-theme">
                                    @foreach ($allImages as $key => $image)
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 ">
                                        <div class="item listing_det_Photo">
                                            <a class="venobox vbox-item" data-gall="gallery01"
                                                href="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $propertyDetails['id'] }}/Original/{{ $image->ImageName ?? 'default.jpg' }}">
                                                <img src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $propertyDetails['id'] }}/Original/{{ $image->ImageName ?? 'default.jpg' }}"
                                                    alt="gallery1" class="display-property-img">
                                                <div class="photo_overlay">
                                                    <i class="fal fa-plus" aria-hidden="true"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="listing_details_sidebar">
                    <div class="row">
                        <div class="col-12">
                            <div class="listing_det_side_contact">
                                <h5> Request Quote </h5>
                                <form id="request-quote">
                                    <input type="hidden" placeholder="First Name" name="propertyId"
                                        value="{{ $propertyDetails['id'] }}">
                                    <input type="text" placeholder="First Name" name="firstname"
                                        value="{{ $renterinfo->UserName ?? '' }}">
                                    <input type="text" placeholder="Last Name" name="lastname"
                                        value="{{ $renterinfo->renterinfo->Lastname ?? '' }}">
                                    <input type="text" placeholder="Phone" name="phone"
                                        value="{{ $renterinfo->renterinfo->phone ?? '' }}">
                                    <input type="email" placeholder="Email" name="email"
                                        value="{{ $renterinfo->Email ?? '' }}">
                                    <input type="date" placeholder="Move Date" name="movedate"
                                        value="{{ $renterinfo->renterinfo->Lmove_date ?? '' }}">
                                    <textarea cols="" rows="" placeholder="Comments" name="comments" required></textarea>
                                    <button type="submit" class="read_btn">Send</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="property-display-sections">
            <div class="col-md-12 ">
                <nav class="section-t3">
                    <ul class="tabs">
                        <li class="tab-li">
                            <a href="#maindetails" class="tab-li__link">Map & Local Info</a>
                        </li>
                        <li class="tab-li">
                            <a href="#propertydetails" class="tab-li__link">Property Details</a>
                        </li>
                        <li class="tab-li">
                            <a href="#generaldeatails" class="tab-li__link"> General Details </a>
                        </li>
                        <li class="tab-li">
                            <a href="#additionaldetails" class="tab-li__link"> Additional Details </a>
                        </li>
                        <li class="tab-li">
                            <a href="#rentandspecial" class="tab-li__link">Rent & Special </a>
                        </li>
                        <li class="tab-li">
                            <a href="#notes-history" class="tab-li__link">Notes</a>
                        </li>
                        <li class="tab-li">
                            <a href="#streetviewfull" class="tab-li__link">Street View </a>
                        </li>
                    </ul>
                </nav>


                <section id="notes-history" data-tab-content>
                    <div class="p-4 bg-white rounded-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold text-primary mb-0">Notes & Interactions</h4>
                            <span class="badge bg-light text-muted p-2" id="notes-count">0 Notes</span>
                        </div>
                        
                        <div id="notes-list-container" class="mb-4" style="max-height: 500px; overflow-y: auto; padding-right: 10px;">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary spinner-border-sm" role="status"></div>
                                <p class="text-muted small mt-2">Loading notes...</p>
                            </div>
                        </div>

                        <div class="reply-box mt-4 p-3 bg-light rounded-4">
                            <h6 class="fw-bold mb-3">Add a Note</h6>
                            <div class="input-group shadow-sm" style="border-radius: 12px; overflow: hidden;">
                                <textarea id="new-note-input" class="form-control border-0" placeholder="Type your message here..." rows="2" style="resize: none;"></textarea>
                                <button class="btn btn-primary-custom" type="button" onclick="submitNewNote()">
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
                
                <section id="maindetails" data-tab-content>
                    <div class="row">
                        <div class="col-md-6 p-0">
                            <input type="hidden" name="" id="lat"
                                value="{{ $propertyDetails['lat'] }}">
                            <input type="hidden" name="" id="long"
                                value="{{ $propertyDetails['lon'] }}">
                            <input type="hidden" name="" id="fieldname"
                                value="{{ $propertyDetails['propertyname'] }}">
                            <input type="hidden" name="" id="fieldaddress"
                                value="{{ $propertyDetails['address'] }}">
                            <span id="map" style="width:100%;height:400px;float:left;"></span>
                        </div>
                        <div class="col-md-6 property-display-street-view">
                            <span id="street_view1" style="width:100%;height:400px;float:left;"></span>
                        </div>
                        <div>
                        </div>
                    </div>
                </section>

                <section id="propertydetails" data-tab-content class="">
                    <div class="active_package">
                        <h4 class="mb-2">Property Details </h4>
                        <div class="table-responsive">
                            <table class="table dashboard_table">
                                <tbody>
                                    <tr>
                                        <td class="active_left">Property Name</td>
                                        <td class="package_right">{{ @$propertyDetails['propertyname'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="active_left">Managed By</td>
                                        <td class="package_right">{{ @$propertyDetails['manageBy'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="active_left">Number of Unit</td>
                                        <td class="package_right">{{ @$propertyDetails['noofunit'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="active_left">Year Built</td>
                                        <td class="package_right">{{ @$propertyDetails['year'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="active_left">Year Remodeled</td>
                                        <td class="package_right">{{ @$propertyDetails['yearremodeled'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="active_left">Address</td>
                                        <td class="package_right">{{ @$propertyDetails['address'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="active_left">State</td>
                                        <td class="package_right">{{ @$propertyDetails['state'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="active_left">City</td>
                                        <td class="package_right">{{ @$propertyDetails['city'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="active_left">Area</td>
                                        <td class="package_right">{{ @$propertyDetails['area'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="active_left">Zip Code</td>
                                        <td class="package_right">{{ @$propertyDetails['zip'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="active_left">Contact No</td>
                                        <td class="package_right">{{ @$propertyDetails['contact'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="active_left">Fax No</td>
                                        <td class="package_right">{{ @$propertyDetails['faxno'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="active_left">Web Site</td>
                                        <td class="package_right"><a
                                                href="{{ @$propertyDetails['website'] }}">{{ @$propertyDetails['website'] }}</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <section id="generaldeatails" data-tab-content class="">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne">
                                    :: Community Description
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    {{ @$propertyDetails['communitydescription'] }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseTwo">
                                    :: Community Amenities
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="row">
                                        @foreach ($amenitiesDetails as $item)
                                        <div class="col-xl-6 col-xxl-4 col-md-6">
                                            <div class="amenities_check_area border">
                                                <div class="wsus__pro_check">
                                                    <div class="form-check">
                                                        <label class="form-check-label"
                                                            for="flexCheckIndeterminate5">
                                                            {{ $item->Amenity }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseThree">
                                    :: Apartment Features
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="row">
                                        @foreach ($featureNames as $item)
                                        <div class="col-xl-4 col-xxl-4 col-md-6">
                                            <div class="amenities_check_area">
                                                <div class="wsus__pro_check">
                                                    <div class="form-check">
                                                        <label class="form-check-label"
                                                            for="flexCheckIndeterminate">
                                                            {{ $item->PropertyFeatureType }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="additionaldetails" data-tab-content class="">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne">
                                    :: Leasing Terms ::
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    {{ $propertyDetails['leaseinfo'] != '' ? $propertyDetails['leaseinfo'] : 'No Records Found' }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseTwo">
                                    :: Qualifying Criteria ::
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    {{ $propertyDetails['qualifycriteria'] != '' ? $propertyDetails['qualifycriteria'] : 'No Records Found' }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseThree">
                                    :: Parking ::
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    {{ @$propertyDetails['parking'] }}
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseFour">
                                    :: Pet Policy ::
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    {{ @$propertyDetails['pets'] }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseFive">
                                    :: Neighborhood ::
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    {{ @$propertyDetails['neighborhood'] }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseSix">
                                    :: Schools ::
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    {{ @$propertyDetails['school'] }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseSeven" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseSeven">
                                    :: Driving Directions ::
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseSeven" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    {{ @$propertyDetails['drivedirection'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="rentandspecial" data-tab-content class="">
                    <div class="row">
                        <form id="compare-form" method="post" action="{{ route('compare-apartments') }}">
                            @csrf
                            <div class="col-lg-12">
                                @foreach ($categories as $category)
                                <h4 class="m-3 border p-2">{{ $category->Name }}</h4>
                                <div class="primary-table table-flex">
                                    <?php
                                    $propertyId = $propertyDetails['id'];
                                    $categoryId = $category['Id'];
                                    $floorDetails = $category->getFloorPlanDetails($propertyId, $categoryId);
                                    $count = count($floorDetails);
                                    ?>
                                    @if ($count > 0)
                                    @foreach ($floorDetails as $floorDetail)
                                    <div class="table-flex">
                                        <div class="tabel-thead">
                                            <div class="td-flex"> Compare </div>
                                            <div class="td-img"> Image </div>
                                            <div class="td-flex">Plan Type</div>
                                            <div class="td-flex">Plan Name</div>
                                            <div class="td-flex">Sq.Footage</div>
                                            <div class="td-flex">Price</div>
                                            <div class="td-flex ">View</div>
                                        </div>

                                        <div class="table-tbody mt-2">
                                            <div class="td-flex">
                                                <input type="hidden" name="propertyid"
                                                    value="{{ $propertyId }}">
                                                <input class="" type="checkbox"
                                                    name="floorId{{ $categoryId }}"
                                                    value="{{ $floorDetail->Id }}" id="flexCheckDefault"
                                                    style="display:block;">
                                            </div>
                                            <div class="td-img">
                                                @if (count($floorDetail->gallerydetail) > 0)
                                                <img
                                                    src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $propertyDetails['id'] }}/Original/{{ $floorDetail->gallerydetail[0]->ImageName ?? 'default.jpg' }}">
                                                @else
                                                <img src="{{ asset('/img/no-img.jpg') }}"
                                                    alt="">
                                                @endif
                                            </div>
                                            <div class="td-flex">{{ $floorDetail->PlanType }}</div>
                                            <div class="td-flex">{{ $floorDetail->PlanName }}</div>
                                            <div class="td-flex">{{ $floorDetail->Footage }}</div>
                                            <div class="td-flex">{{ $floorDetail->Price }}</div>
                                            <div class="td-flex">
                                                <div class="demo-btn-list d-flex" style="gap:5px;">
                                                    <a href=""
                                                        class="btn-primary-icon px-2 py-1 border rounded m-1"
                                                        data-bs-toggle="tooltip" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="table-flex">
                                        <div class="tabel-thead">
                                            <div class="td-img"></div>
                                            <div class="td-img"> Image </div>
                                            <div class="td-img">Plan Type</div>
                                            <div class="td"> Rent & Specials </div>
                                            <div class="td-flex">Plan Name</div>
                                            <div class="td-flex">Sq.Footage</div>
                                            <div class="td-flex">Price</div>
                                        </div>


                                        <div class="table-tbody mt-2 border">
                                            <h5> No Record Found </h5>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <hr>
                                @endforeach
                            </div>
                            <button type="submit" class="btn read_btn float-right">Compare</button>
                        </form>
                    </div>
                </section>

                <section id="streetviewfull" data-tab-content class="">
                    <div class="row">
                        <div class="col-md-12">
                            <span id="streetview-pano" style="width:100%;height:400px;float:left;"></span>
                        </div>
                        <div>
                </section>

            </div>
        </div>
    </div>
</section>


















@endsection
@push('scripts')
<script src="{{ asset('user_asset/js/tabview.js') }}"></script>
<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.google_maps_api_key', env('GOOGLE_MAPS_API_KEY')) }}&callback=initMap" async defer>
</script>

<script type="text/javascript">
    function initMap() {
        var marker;
        var map;
        var latElement = document.getElementById('lat');
        var lonElement = document.getElementById('long');
        var nameElement = document.getElementById('fieldname');
        var addressElement = document.getElementById('fieldaddress');

        var lat = parseFloat(latElement.value);
        var lon = parseFloat(lonElement.value);
        var name = nameElement.value;
        var address = addressElement.value;

        console.log("Latitude value:", lat);
        console.log("Longitude value:", lon);
        console.log("Name:", name);
        console.log("Address:", address);
        var myLatlng = new google.maps.LatLng(lat, lon);
        var marker = null;
        var geocoder = new google.maps.Geocoder();
        var myOptions = {
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var panoramaOptions;
        var map = new google.maps.Map(document.getElementById("map"), myOptions);
        var panorama;
        if (geocoder) {
            geocoder.geocode({
                address: address
            }, function(results, status) {
                var latlon;
                latlon = myLatlng
                map.setCenter(latlon);
                marker = new google.maps.Marker({
                    map: map,
                    title: name,
                    position: latlon,
                    animation: google.maps.Animation.DROP
                });
                var streetViewService = new google.maps.StreetViewService();
                streetViewService.getPanoramaByLocation(latlon, 50, function(data, status) {
                    if (status == google.maps.StreetViewStatus.OK) {
                        panoramaOptions = {
                            position: data.location.latLng,
                            pov: {
                                heading: 34,
                                pitch: 10,
                                zoom: 1
                            }
                        };
                        panorama = new google.maps.StreetViewPanorama(document.getElementById(
                            "street_view1"), panoramaOptions);
                        map.setStreetView(panorama)
                        panorama = new google.maps.StreetViewPanorama(document.getElementById(
                            "streetview-pano"), panoramaOptions);
                        map.setStreetView(panorama)
                    } else {
                        google.maps.event.trigger(map, "resize");
                        document.getElementById("street_view1").innerHTML =
                            "<div class='google_map_back_street_view'><p>Street level photos are not available for this point.</p><p><b >Note:</b> Street views may be available in the area outside of the area shown on the map.</p></div>";
                        document.getElementById("streetview-pano").innerHTML =
                            "<div class='google_map_back_street_view'><p>Street level photos are not available for this point.</p><p><b >Note:</b> Street views may be available in the area outside of the area shown on the map.</p></div>";
                    }
                })
            })
        }
    }
</script>
<script>
    $("#request-quote").submit(function(e) {
        e.preventDefault();
        var url = "{{ route('request-quote') }}";
        var formData = $(this).serialize();
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('.read_btn').html(
                    `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Sending...`
                )
                $('.read_btn').prop('disabled', true);
            },
            success: function(response) {
                if (response.message) {
                    toastr.success(response.message);
                    $("#request-quote")[0].reset();
                    $('.read_btn').html(`Send`)
                    $('.read_btn').prop('disabled', false);
                }
            },
            error: function(xhr) {
                toastr.error("An error occurred. Please try again.");
                $('.read_btn').html(
                    `Send`
                )
                $('.read_btn').prop('disabled', false);
            },
        });

        $(this).addClass('was-validated');
    });


    $('#owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        dots: true,
        nav: true,
        items: 2,
        autoplay: true,
        autoplayTimeout: 2000,
        smartSpeed: 800,
        nav: true,
        responsive: {
            0: {
                items: 1
            },

            600: {
                items: 4
            },

            1024: {
                items: 4
            },

            1366: {
                items: 4
            }
        }
    })

    // TAB NAVIGATION for section titles
    $(document).on('click', '.tab-li__link', function(e) {
        e.preventDefault();
        const target = $(this).attr('href');
        
        // Update active class on links
        $('.tab-li__link').removeClass('active');
        $(this).addClass('active');

        // Show target content
        $('[data-tab-content]').removeClass('active').hide();
        $(target).addClass('active').fadeIn();

        // Load notes if needed
        if (target === '#notes-history') {
            loadNotesHistory();
        }
    });

    function loadNotesHistory() {
        const propertyId = "{{ $propertyDetails['id'] }}";
        const container = $('#notes-list-container');
        
        $.ajax({
            url: "{{ route('get-notes-detail') }}",
            type: "POST",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { propertyId: propertyId },
            success: function(response) {
                let html = '';
                const notes = response.notedetails;
                if (notes) $('#notes-count').text(notes.length + ' Notes');

                if (notes && notes.length > 0) {
                    notes.forEach(note => {
                        const isMe = note.user_id == "{{ Auth::guard('renter')->id() }}";
                        const senderName = isMe ? 'You' : (note.admin_id ? 'Admin' : 'Manager');
                        const alignClass = isMe ? 'flex-row-reverse text-end' : '';
                        const bgColor = isMe ? 'bg-primary text-white' : 'bg-light text-dark';
                        const time = new Date(note.send_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                        html += `
                            <div class="d-flex ${alignClass} mb-3 gap-2">
                                <div class="message-bubble p-3 rounded-4 shadow-sm ${bgColor}" style="max-width: 80%; display: inline-block;">
                                    <div class="d-flex justify-content-between gap-3 mb-1">
                                        <small class="fw-bold">${senderName}</small>
                                        <small class="opacity-75">${time}</small>
                                    </div>
                                    <p class="mb-0 text-start" style="font-size: 0.95rem;">${note.message}</p>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    html = '<div class="text-center py-4 text-muted">No notes found for this property.</div>';
                }
                container.html(html);
                if (container[0] && container[0].scrollHeight) {
                    container.scrollTop(container[0].scrollHeight);
                }
            }
        });
    }

    window.submitNewNote = function() {
        const message = $('#new-note-input').val();
        const propertyId = "{{ $propertyDetails['id'] }}";
        
        if (!message) return;

        $.ajax({
            url: "{{ route('add-notes') }}",
            type: "POST",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { 
                propertyId: propertyId,
                message: message
            },
            success: function(response) {
                if (response.success) {
                    $('#new-note-input').val('');
                    loadNotesHistory();
                    toastr.success('Note added successfully');
                }
            }
        });
    }

</script>
@endpush