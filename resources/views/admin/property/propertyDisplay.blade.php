@extends('admin.layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin_asset/css/tabview.css') }}">
@endpush
@section('content')
@section('title', 'RentApartments Admin | Property Section ')
<div class="slim-mainpanel">

    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Property Display </li>
            </ol>
            <h6 class="slim-pagetitle">Property Display </h6>
        </div>
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card card-latest-activity mg-t-20">
                    <div class="card-body">
                        <div class="row no-gutters">
                            <div class="col-md-4 border">
                                <div class="carousel-gallery-item">
                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            @php
                                                $allImages =
                                                    is_array($propertyDetails['allimages']) ||
                                                    is_object($propertyDetails['allimages'])
                                                        ? $propertyDetails['allimages']
                                                        : [];
                                            @endphp

                                            @foreach ($allImages as $key => $image)
                                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                    <img src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $propertyDetails['id'] }}/Original/{{ $image->ImageName ?? 'default.jpg' }}"
                                                        class="d-block w-100" alt="..."
                                                        style="height: 300px; object-fit: cover; width: 100%;">
                                                </div>
                                            @endforeach
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                            data-slide="prev">
                                            <i class="fa-solid fa-chevron-left"></i>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                            data-slide="next">
                                            <i class="fa-solid fa-chevron-right"></i>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-8 px-4 pt-2">
                                <div class="d-flex justify-content-between border-bottom">
                                    <h2 class="m-0"><a href="">{{ $propertyDetails['propertyname'] }}</a></h2>
                                    {{-- <div class="d-flex" style="gap:12px;">
                                        <a class="add-fav" data-renter-id="" id="favoriteButton"
                                            data-property-id="{{ $propertyDetails['id'] }}"><i
                                                class="fa-solid fa-heart fa-xl" id="isfav"
                                                style="cursor:pointer;"></i></a>
                                        <a><i class="fa-solid fa-print fa-xl" style="cursor:pointer;"></i></a>
                                    </div> --}}
                                </div>
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between">
                                        <a href="" class="h4"> {{ $propertyDetails['address'] }},
                                            {{ $propertyDetails['city'] }} </a>
                                        <h4>{{ $propertyDetails['price'] ? '$' . $propertyDetails['price'] : '' }}</h4>
                                    </div>
                                    <div class="container-fluid p-0">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td class="pl-0">
                                                        <p class="mb-2"><i class="fa fa-address-card"></i>&nbsp&nbsp
                                                            1900 Little Raven St Denver</p>
                                                        <p class="mb-2"><i class="fa fa-envelope"></i>&nbsp&nbsp
                                                            Zip:{{ $propertyDetails['zip'] }}</p>
                                                        <p class="mb-2"><i class="fa fa-phone"></i>&nbsp&nbsp Contact
                                                            No
                                                            : {{ $propertyDetails['faxno'] }}</p>
                                                        <p class="mb-2"><i class="fa fa-map-marker"></i>&nbsp&nbsp
                                                            Area
                                                            of Town: {{ $propertyDetails['city'] }}</p>
                                                    </td>
                                                    <td class="pl-0">
                                                        <p class="mb-2"><i class="fa fa-user"></i>&nbsp&nbsp Managed
                                                            By
                                                            : {{ $propertyDetails['manageBy'] }}</p>
                                                        <p class="mb-2"><i class="fa fa-clock"></i>&nbsp&nbsp Office
                                                            Hours :Mon - Sat 10am - 6pm</p>
                                                        <p class="mb-2"><i class="fa fa-ban"></i>&nbsp&nbsp Sun Closed
                                                        </p>
                                                        <p class="mb-2"><i class="fa fa-phone"></i>&nbsp&nbsp Billing
                                                            Phone:303-552-5967</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-primary active btn-block mg-b-10" data-toggle="modal"
                                            data-target="#modaldemo3">Request Quote </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mg-t-20 mg-lg-t-0">


                </div>

                <div class="col-lg-12 mg-t-20 mg-lg-t-0 mt-4 p-0">
                    <nav>
                        <ul class="tabs">
                            <li class="tab-li">
                                <a href="#maindetails" class="tab-li__link">Main Details</a>
                            </li>
                            <li class="tab-li">
                                <a href="#generaldetails" class="tab-li__link">General Details</a>
                            </li>
                            <li class="tab-li">
                                <a href="#floorplans" class="tab-li__link"> Floor Plan </a>
                            </li>
                            <li class="tab-li">
                                <a href="#imagegallery" class="tab-li__link">Image Gallary </a>
                            </li>
                            <li class="tab-li">
                                <a href="#map" class="tab-li__link">Map</a>
                            </li>
                        </ul>
                    </nav>

                    <section id="maindetails" data-tab-content class="p-0">
                        <div class="table-responsive">
                            <div class="card card-table mg-t-20 mg-sm-t-30">
                                <div class="card-header">
                                    <h6 class="slim-card-title">Property Details </h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover mg-b-0">
                                        <tbody>
                                            <tr>
                                                <td class="px-4">
                                                    <h5 class="detail-h5 mb-0">Property Name</h5>
                                                </td>
                                                <td>{{ $propertyDetails['propertyname'] }}</td>

                                                <td class="">
                                                    <h5 class="detail-h5 mb-0">Managed By</h5>
                                                </td>
                                                <td>{{ $propertyDetails['manageBy'] }}</td>
                                            </tr>

                                            <tr>
                                                <td class="px-4">
                                                    <h5 class="detail-h5 mb-0">Number of Unit</h5>
                                                </td>
                                                <td>{{ $propertyDetails['noofunit'] }}</td>

                                                <td>
                                                    <h5 class="detail-h5 mb-0">Year Built</h5>
                                                </td>
                                                <td>{{ $propertyDetails['year'] }}</td>
                                            </tr>

                                            <tr>
                                                <td class="px-4">
                                                    <h5 class="detail-h5 mb-0">Year Remodeled</h5>
                                                </td>
                                                <td>{{ $propertyDetails['yearremodeled'] != '' ? $propertyDetails['yearremodeled'] : 'N/A' }}
                                                </td>

                                                <td>
                                                    <h5 class="detail-h5 mb-0">Address</h5>
                                                </td>
                                                <td>{{ $propertyDetails['address'] != '' ? $propertyDetails['address'] : 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-4">
                                                    <h5 class="detail-h5 mb-0">State</h5>
                                                </td>
                                                <td>{{ $propertyDetails['state'] != '' ? $propertyDetails['state'] : 'N/A' }}
                                                </td>

                                                <td>
                                                    <h5 class="detail-h5 mb-0">City</h5>
                                                </td>
                                                <td>{{ $propertyDetails['city'] != '' ? $propertyDetails['city'] : 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-4">
                                                    <h5 class="detail-h5 mb-0">Area</h5>
                                                </td>
                                                <td>{{ $propertyDetails['area'] != '' ? $propertyDetails['area'] : 'N/A' }}
                                                </td>

                                                <td>
                                                    <h5 class="detail-h5 mb-0">Zip Code</h5>
                                                </td>
                                                <td>{{ $propertyDetails['zip'] != '' ? $propertyDetails['zip'] : 'N/A' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="px-4">
                                                    <h5 class="detail-h5 mb-0">Contact No</h5>
                                                </td>
                                                <td>{{ $propertyDetails['contact'] != '' ? $propertyDetails['contact'] : 'N/A' }}
                                                </td>

                                                <td>
                                                    <h5 class="detail-h5 mb-0">Fax No</h5>
                                                </td>
                                                <td>{{ $propertyDetails['faxno'] != '' ? $propertyDetails['faxno'] : 'N/A' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="px-4">
                                                    <h5 class="detail-h5 mb-0">Web Site</h5>
                                                </td>
                                                <td>{{ $propertyDetails['website'] }}</td>

                                                <td>
                                                    <h5 class="detail-h5 mb-0"> Office Hours</h5>
                                                </td>
                                                <td>{{ $propertyDetails['officehour'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="generaldetails" data-tab-content class="">
                        <div class="card card-latest-activity mg-t-20 active" role="tabpanel">
                            <div class="card-body">
                                <div class="card-header bg-white">
                                    <h6 class="slim-card-title">General Details & Additional </h6>
                                </div>

                                <div id="accordion mt-3">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse"
                                                    data-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne" style="font-size:20px">
                                                    General Details
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                            data-parent="#accordion">
                                            <div class="card-body">
                                                <table class="table table-hover mg-b-0">
                                                    <thead>
                                                        <tr>
                                                            <th>::&nbsp&nbspCommunity Description</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ @$propertyDetails['communitydescription'] }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-hover mg-b-0 mt-3">
                                                    <thead>
                                                        <tr>
                                                            <th>::&nbsp&nbspCommunity Amenities</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            @if (count($amenities) > 0)
                                                                <td>
                                                                    <div class="row">
                                                                        @foreach ($amenities as $amenty)
                                                                            <div
                                                                                class="col-md-4 col-lg-4 mg-t-20 mg-lg-t-0-force">
                                                                                <ul class="list-group">
                                                                                    <li class="list-group-item">
                                                                                        <p class="mg-b-0">
                                                                                            <i
                                                                                                class="fa-solid fa-chevron-right tx-primary mg-r-8"></i><strong
                                                                                                class="tx-inverse tx-medium">
                                                                                                {{ @$amenty->Amenity }}</strong>
                                                                                        </p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        @endforeach

                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td> No Selected Amenities for this Property Yet !</td>
                                                            @endif

                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-hover mg-b-0 mt-3">
                                                    <thead>
                                                        <tr>
                                                            <th>::&nbsp&nbspApartment Features</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            @if (count($features) > 0)
                                                                <td>
                                                                    <div class="row">
                                                                        @foreach ($features as $feature)
                                                                            <div
                                                                                class="col-md-4 col-lg-4 mg-t-20 mg-lg-t-0-force">
                                                                                <ul class="list-group">
                                                                                    <li class="list-group-item">
                                                                                        <p class="mg-b-0">
                                                                                            <i
                                                                                                class="fa-solid fa-chevron-right tx-primary mg-r-8"></i><strong
                                                                                                class="tx-inverse tx-medium">
                                                                                                {{ $feature->PropertyFeatureType }}</strong>
                                                                                        </p>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td> No Selected Apartment Features for this Property
                                                                    Yet !</td>
                                                            @endif
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-toggle="collapse"
                                                    data-target="#collapseTwo" aria-expanded="false"
                                                    aria-controls="collapseTwo" style="font-size:20px">
                                                    Additional Details
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                            data-parent="#accordion">
                                            <div class="card-body">
                                                <table class="table table-hover mg-b-0">
                                                    <thead>
                                                        <tr>
                                                            <th>::&nbsp&nbspLease Terms</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $propertyDetails['leaseinfo'] != '' ? $propertyDetails['leaseinfo'] : '-- Please call community for details --' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-hover mg-b-0 mt-3">
                                                    <thead>
                                                        <tr>
                                                            <th>::&nbsp&nbspQualifiying Criteria</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $propertyDetails['qualifycriteria'] != '' ? $propertyDetails['qualifycriteria'] : '-- Please call community for details --' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-hover mg-b-0 mt-3">
                                                    <thead>
                                                        <tr>
                                                            <th>::&nbsp&nbspParking</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $propertyDetails['parking'] != '' ? $propertyDetails['parking'] : '-- Please call community for details --' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-hover mg-b-0 mt-3">
                                                    <thead>
                                                        <tr>
                                                            <th>::&nbsp&nbspPet Policy</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $propertyDetails['pets'] != '' ? $propertyDetails['pets'] : '-- Please call community for details --' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-hover mg-b-0 mt-3">
                                                    <thead>
                                                        <tr>
                                                            <th>::&nbsp&nbspNeighborhood</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $propertyDetails['neighborhood'] != '' ? $propertyDetails['neighborhood'] : '-- Please call community for details --' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-hover mg-b-0 mt-3">
                                                    <thead>
                                                        <tr>
                                                            <th>::&nbsp&nbspSchools</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $propertyDetails['school'] != '' ? $propertyDetails['school'] : '-- Please call community for details --' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-hover mg-b-0 mt-3">
                                                    <thead>
                                                        <tr>
                                                            <th>::&nbsp&nbspDriving Direction</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $propertyDetails['drivedirection'] != '' ? $propertyDetails['drivedirection'] : '-- Please call community for details --' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="floorplans" data-tab-content class="">
                        <div class="card-body px-0">
                            @foreach ($categories as $category)
                                <div class="section-wrapper mt-1">
                                    <label class="section-title">{{ $category->Name }}</label>
                                    <div class="table-responsive">
                                        <table class="table mg-b-0">
                                            <?php
                                            $propertyId = $propertyDetails['id'];
                                            $categoryId = $category['Id'];
                                            $floorDetails = $category->getFloorPlanDetails($propertyId, $categoryId);
                                            $count = count($floorDetails);
                                            ?>
                                            @if ($count > 0)
                                                @foreach ($floorDetails as $floorDetail)
                                                    <table class="table mg-b-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Image</th>
                                                                <th>Plan Type</th>
                                                                <th>Plan Name</th>
                                                                <th>Sq.Footage</th>
                                                                <th>Price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><img src="https://images.pexels.com/photos/376464/pexels-photo-376464.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" style="height:70px;width:70px;"></td>
                                                                <td>{{ $floorDetail->PlanType }}</td>
                                                                <td>{{ $floorDetail->PlanName }}</td>
                                                                <td>{{ $floorDetail->Footage }}</td>
                                                                <td>{{ $floorDetail->Price }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @endforeach
                                            @else
                                                <table class="table mg-b-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Image</th>
                                                            <th>Plan Type</th>
                                                            <th>Plan Name</th>
                                                            <th>Sq.Footage</th>
                                                            <th>Price</th>
                                                            <th>View</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td> No Records Found</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section id="imagegallery" data-tab-content>
                        <div id="imagegallery" class="tab-content">
                            <div class="gallery">
                                @php
                                    @$allImages = $propertyDetails['allimages'];
                                    @$imageData = $allImages
                                        ? $allImages
                                            ->map(function ($image) use ($propertyDetails) {
                                                return [
                                                    'src' => "https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{$propertyDetails['id']}/Original/{$image->ImageName}",
                                                    'text' => 'Image description here',
                                                ];
                                            })
                                            ->toArray()
                                        : [];
                                @endphp
                                
                                <script>
                                    window.images = @json($imageData);
                                </script>

                                @if (!empty($allImages) && count($allImages) > 0)
                                    @foreach ($allImages as $index => $row)
                                        <div class="gallery-item" onclick="openModal({{ $index }})">
                                            <img src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $propertyDetails['id'] }}/Original/{{ @$row->ImageName }}"
                                                alt="Property Image">
                                        </div>
                                    @endforeach
                                @else
                                    <p>No image available</p>
                                @endif
                            
                            </div>

                            <div id="modal" class="modal">
                                <span class="close" onclick="closeModal()">&times;</span>
                                <div class="modal-content">
                                    <div class="modal-left">
                                        <img id="modal-img" src="" alt="Modal Image">
                                    </div>
                                    <div class="modal-right">
                                        <p id="modal-text"></p>
                                        <button class="nav-btn" onclick="prevImage()">&#9664;</button>
                                        <button class="nav-btn" onclick="nextImage()">&#9654;</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="map" data-tab-content class="">
                        <div class="card card-dash-chart-one mg-t-20 mg-sm-t-30">
                            <div class="row no-gutters">
                                {{-- <div class="col-lg-4">
                                    <div class="left-panel">
                                        <nav class="nav">
                                            <a href="" class="nav-link active">Today</a>
                                            <a href="" class="nav-link">This Week</a>
                                        </nav>

                                        <div class="active-visitor-wrapper">
                                            <h1>746</h1>
                                            <p>Online Visitors on Site</p>
                                        </div>
                                        <hr class="mg-t-30 mg-b-40">
                                    </div>
                                </div> --}}
                                <div class="col-lg-12">
                                    <div class="right-panel">
                                        <div id="map-location" class="ht-250 ht-sm-350 ht-md-450 bg-gray-300">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>

    </div>
</div>

<div id="modaldemo3" class="modal fade">
    <div class="modal-dialog modal-lg" role="document" style="width:100%;">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Send Inquiry </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">

                <div class="form-layout form-layout-4 p-4">
                    <div class="row">
                        <label class="col-sm-4 form-control-label"><i
                                class="fa fa-address-card "></i>&nbsp&nbspFirstname </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" placeholder="Enter firstname" value=""
                                disabled>
                        </div>
                    </div><!-- row -->
                    <div class="row mg-t-20">
                        <label class="col-sm-4 form-control-label"> <i
                                class="fa fa-address-card "></i>&nbsp&nbspLastname </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" placeholder="Enter lastname" value=""
                                disabled>
                        </div>
                    </div>
                    <div class="row mg-t-20">
                        <label class="col-sm-4 form-control-label"><i class="fa fa-phone"></i>&nbsp&nbsp Phone
                        </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" placeholder="Enter lastname" value=""
                                disabled>
                        </div>
                    </div>

                    <div class="row mg-t-20">
                        <label class="col-sm-4 form-control-label">
                            <i class="fa fa-envelope"></i>&nbsp&nbsp Email </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" placeholder="Enter email address"
                                value="" disabled>
                        </div>
                    </div>

                    <div class="row mg-t-20">
                        <label class="col-sm-4 form-control-label">
                            <i class="fa fa-building" aria-hidden="true"></i>&nbsp&nbsp Property Name </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" placeholder="Enter email address"
                                value="" disabled>
                        </div>
                    </div>
                    <div class="row mg-t-20">
                        <label class="col-sm-4 form-control-label">
                            <i class="fa fa-map-marker"></i>&nbsp&nbsp Subject </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <input type="text" class="form-control" placeholder="Enter email address"
                                value="Inquiry For" disabled>
                        </div>
                    </div>
                    <hr>
                    <div class="row mg-t-20">
                        <label class="col-sm-4 form-control-label">
                            <i class="fa-solid fa-pen"></i>&nbsp&nbsp Your Note </label>
                        <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                            <textarea rows="3" class="form-control" placeholder="Textarea"></textarea>
                        </div>
                    </div>

                    <div class="form-layout-footer mg-t-30">
                        <button class="btn btn-primary bd-0 float-right">Submit Form</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function initMap() {
        var marker;
        var map;
        var lat = "39.5486";
        var lon = "-104.874";
        var name = "One City Block";
        var myLatlng = new google.maps.LatLng(lat, lon);
        var marker = null;
        var geocoder = new google.maps.Geocoder();
        var myOptions = {
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var panoramaOptions;
        var map = new google.maps.Map(document.getElementById("map-location"), myOptions);
        var panorama;
        var address = "444 E. 19th Avenue";
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
                    } else {
                        google.maps.event.trigger(map, "resize");
                        document.getElementById("street_view1").innerHTML =
                            "<div class='google_map_back_street_view'><p>Street level photos are not available for this point.</p><p><b >Note:</b> Street views may be available in the area outside of the area shown on the map.</p></div>";
                    }
                })
            })
        }
    }
    window.initMap = initMap;
</script>
<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer>
</script>

<script>
    let currentIndex = 0;

    function openModal(index) {
        currentIndex = index;
        updateModal();
        document.getElementById('modal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('modal').style.display = 'none';
    }

    function prevImage() {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
        updateModal();
    }

    function nextImage() {
        currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
        updateModal();
    }

    function updateModal() {
        document.getElementById('modal-img').src = images[currentIndex].src;
        document.getElementById('modal-text').innerText = images[currentIndex].text;
    }
</script>

@endsection
@push('adminscripts')
<script src="{{ asset('admin_asset/js/tabviewform.js') }}"></script>
@endpush
