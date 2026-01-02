@extends('user.layout.app')
@section('content')
@section('title', 'RentApartement | Favorite Properties ')
@php
    @$amenities = App\Models\CommunityAmenities::all();
    @$apartmentfeatures = App\Models\ApartmentFeature::all();
    @$pets = App\Models\Pets::all();
    @$userid = Auth::guard('renter')->user();
    @$notifications = App\Models\Notification::where('to_id', $userid->Id)
        ->where('to_user_type', $userid->user_type)
        ->orderBy('id', 'desc')
        ->get();
    @$notificationsnotseencount = App\Models\Notification::where('to_id', $userid->Id)
        ->where('to_user_type', $userid->user_type)
        ->where('seen', 0)
        ->count();
@endphp
<style>
    .header-row th {
        border-bottom: 1px solid #eaeaea !important;
    }
    
</style>
<div id="breadcrumb_part"
    style="background: url(../images/breadcroumb_bg.jpg);background-size: cover;background-repeat: no-repeat;background-position: center;">
    <div class="bread_overlay">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center text-white">
                    <h4> {{ $pagetitle }} </h4>
                    <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"> Home </a></li>
                            <li class="breadcrumb-item active" aria-current="page"> {{ $pagetitle }} </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<section id="dashboard">
    <div class="container">
        <div class="row">
             <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 p-0  ">
                  <div class="keyword-form-img">
                       <img src="../../img/advanced-search.jpg" alt="">
                  </div>
             </div>
             <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 search-propert-from-col">
                  <div class="form-keyword">
                      <!-- Main Property Search Form -->
                  <form class="form-a px-3" method="GET" id="propertySearchForm"
                        action="{{ route('search-property') }}">
                        @csrf
                        <div class="row">
                            <div class="row ">
                                <!-- Keyword Search -->
                                <div class="col-md-4">
                                    <label for="keywords" class="form-label f-w700">Keyword</label>
                                    <input type="text" id="keywords" class="form-control" name="keywords"
                                        placeholder="Enter keyword">
                                </div>

                                <div class="col-md-4">
                                    <label for="area" class="form-label f-w700">Area</label>
                                    <input type="text" id="area" class="form-control" name="area"
                                        placeholder="Enter area">
                                </div>

                                <div class="col-md-4">
                                    <label for="zip_code" class="form-label f-w700">Zip Code</label>
                                    <input type="text" id="zip_code" class="form-control" name="zip_code"
                                        placeholder="Enter zip code">
                                </div>

                                <div class="col-md-4">
                                    <label for="advsearchstate" class="form-label f-w700">State</label>
                                    <select id="advsearchstate" class="form-select" name="advsearchstate">
                                        <option value="">All States</option>
                                        @foreach ($state as $row)
                                            <option value="{{ $row->Id }}">{{ $row->StateName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="advsearchcity" class="form-label f-w700">City</label>
                                    <select id="advsearchcity" class="form-select" name="advsearchcity">
                                        <option value="">All Cities</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="managed_by" class="form-label f-w700">Managed By</label>
                                    <input type="text" id="managed_by" class="form-control" name="managed_by"
                                        placeholder="Managed By">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label f-w700">Price Range</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="price_rangefrom"
                                            placeholder="From">
                                        <input type="text" class="form-control" name="price_rangeto"
                                            placeholder="To">
                                    </div>
                                </div>
                            </div>


                            <div class="row g-3">
                                <label for="addressInput" class="f-w700">Beds:</label>
                                <div class="col-xl-6 col-xxl-6 col-md-6">
                                    <div class="amenities_check_area border">
                                        <div class="wsus__pro_check">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    name="bedrooms[]" id="flexCheckIndeterminate5">
                                                <label class="form-check-label" for="flexCheckIndeterminate5">
                                                    Studio- 1 Bedroom
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-xxl-6 col-md-6">
                                    <div class="amenities_check_area border">
                                        <div class="wsus__pro_check">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="2"
                                                    name="bedrooms[]" id="flexCheckIndeterminate5">
                                                <label class="form-check-label" for="flexCheckIndeterminate5">
                                                    1 Bedroom Den - 2 Bedroom
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-xxl-6 col-md-6">
                                    <div class="amenities_check_area border">
                                        <div class="wsus__pro_check">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="3"
                                                    name="bedrooms[]" id="flexCheckIndeterminate5">
                                                <label class="form-check-label" for="flexCheckIndeterminate5">
                                                    2 Bedroom Den - 3 Bedroom
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-xxl-6 col-md-6">
                                    <div class="amenities_check_area border">
                                        <div class="wsus__pro_check">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="4"
                                                    name="bedrooms[]" id="flexCheckIndeterminate5">
                                                <label class="form-check-label" for="flexCheckIndeterminate5">
                                                    3 Bedroom Den - 4 Bedroom
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-xxl-6 col-md-6">
                                    <div class="amenities_check_area border">
                                        <div class="wsus__pro_check">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="5"
                                                    name="bedrooms[]" id="flexCheckIndeterminate5">
                                                <label class="form-check-label" for="flexCheckIndeterminate5">
                                                    5 Bedroom
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-xxl-6 col-md-6">
                                    <div class="amenities_check_area border">
                                        <div class="wsus__pro_check">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="allbedroom" id="allbedroom">
                                                <label class="form-check-label" for="flexCheckIndeterminate5">
                                                    All
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <!-- Submit Button -->
                            <div class="row g-3">
                                <div class="col-md-12 p-2 mt-0 text-center">
                                    <button class="main-btn" type="submit">Search Property</button>
                                </div>
                            </div>
                        </div>
                    </form>
                  </div>
             </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mt-4 px-4">
                <div>
                    <!-- Additional Filters Form -->
                    <form class="form-a px-3" method="GET" action="{{ url('search-property') }}">
                        @csrf
                        <div class="row mt-4">
                            <!-- Pet Policy -->
                            <div class="col-md-12 mt-3">
                                <label class="f-w700">Pet Policy:</label>
                                <select class="form-control form-select form-control-a Pet-Policy-search" name="pet_policy">
                                    <option value="">All Types</option>
                                    @foreach ($pets as $item)
                                        <option value="{{ $item->id }}">{{ $item->Pets }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label class="f-w700">Community Services & Amenities:</label>
                                <div class="row mt-2">
                                    @foreach ($amenities as $item)
                                        <div class="col-xl-6 col-xxl-4 col-md-6">
                                            <div class="amenities_check_area border">
                                                <div class="wsus__pro_check">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ $item->Id }}" name="amenities[]"
                                                            id="amenity{{ $item->Id }}">
                                                        <label class="form-check-label ml-2"
                                                            for="amenity{{ $item->Id }}">{{ $item->Amenity }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label class="f-w700">Apartment Features:</label>
                                <div class="row mt-2">
                                    @foreach ($apartmentfeatures as $item)
                                        <div class="col-xl-6 col-xxl-4 col-md-6">
                                            <div class="amenities_check_area border">
                                                <div class="wsus__pro_check">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ $item->Id }}" name="apartmentfeatures[]"
                                                            id="feature{{ $item->Id }}">
                                                        <label class="form-check-label"
                                                            for="feature{{ $item->Id }}">{{ $item->PropertyFeatureType }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-12 mt-3 built">
                                <label class="form-label f-w700">Year Built: </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fromyearbuilt"
                                        placeholder="From">
                                    <input type="text" class="form-control" name="toyearbuilt" placeholder="To">
                                </div>
                            </div>


                            <div class="col-md-12 mt-3 built">
                                <label class="form-label f-w700">Year Remodeled: </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fromremodeled"
                                        placeholder="From">
                                    <input type="text" class="form-control" name="toremodeled" placeholder="To">
                                </div>
                            </div>

                            <div class="col-md-12 p-2 mt-3 text-center">
                                <button class="main-btn" type="submit">Apply Filters</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
