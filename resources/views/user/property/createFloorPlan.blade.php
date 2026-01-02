@extends('user/layout/app')
@section('content')
    <div id="breadcrumb_part"
        style="background: url(../images/breadcroumb_bg.jpg);background-size: cover;background-repeat: no-repeat;background-position: center;">
        <div class="bread_overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h4> Create Floor Plan </h4>
                        <nav style="" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"> Home </a></li>
                                <li class="breadcrumb-item active" aria-current="page"> listing </li>
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
                <div class="col-lg-3">
                    <x-dashboard-sidebar />
                </div>
                <div class="col-lg-9">
                    <div class="dashboard_content">
                        <div class="my_listing">
                            <h4> Create Floor Plan </h4>
                            <form id="createfloorplan" method="post" action="{{ route('store-floor-plan') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12 col-md-12">
                                        <div class="row">
                                            
                                            <div class="col-xl-6 col-md-6">
                                                <div class="my_listing_single">
                                                    <label for="category">Category</label>
                                                    <div class="input_area">
                                                        <select
                                                            class="form-control form-select form-control-a state-select-box mt-1"
                                                            name="category" id="add-property-state" required>
                                                            <option value="">Select Category</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->Id }}">{{ $category->Name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-md-6">
                                                <div class="my_listing_single">
                                                    <label for="plan_type">Plan Type</label>
                                                    <div class="input_area">
                                                        <input type="text" id="plan_type" name="plan_type"
                                                            placeholder="(e.g. Apartment, Loft, Townhome)" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-md-6">
                                                <div class="my_listing_single">
                                                    <label for="floor_plan">Floor Plan</label>
                                                    <div class="input_area">
                                                        <input type="text" id="floor_plan" name="floor_plan"
                                                            placeholder="(e.g. Studio, 2 bed 1 bath Plus Den)"
                                                            value="">
                                                    </div>
                                                </div>
                                            </div>

                                            

                                            <div class="col-xl-6 col-md-6">
                                                <div class="my_listing_single">
                                                    <label for="plan_name">Plan Name</label>
                                                    <div class="input_area">
                                                        <input type="text" id="plan_name" name="plan_name"
                                                            placeholder="Enter Plan Name" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-md-6">
                                                <div class="my_listing_single">
                                                    <label for="square_footage">Square Footage</label>
                                                    <div class="input_area">
                                                        <input type="text" id="square_footage" name="square_footage"
                                                            placeholder="Enter Square Footage" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-md-6">
                                                <div class="my_listing_single">
                                                    <label for="starting_at">Starting at</label>
                                                    <div class="input_area">
                                                        <input type="number" id="starting_at" name="starting_at"
                                                            placeholder="Enter Starting Price" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-md-6">
                                                <div class="my_listing_single">
                                                    <label for="deposit">Deposit</label>
                                                    <div class="input_area">
                                                        <input type="text" id="deposit" name="deposit"
                                                            placeholder="Enter Deposit Amount" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-md-6">
                                                <div class="my_listing_single">
                                                    <label for="link">Link</label>
                                                    <div class="input_area">
                                                        <input type="text" id="link" name="link"
                                                            placeholder="Enter Link" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-md-6">
                                                <div class="my_listing_single">
                                                    <label for="available_url">Available URL</label>
                                                    <div class="input_area">
                                                        <input type="text" id="available_url" name="available_url" placeholder="Enter Available URL" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-md-6">
                                                <div class="my_listing_single">
                                                    <label for="expiry_date">Expiry Date</label>
                                                    <div class="input_area">
                                                        <input type="date" id="expiry_date" name="expiry_date"
                                                            value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <div class="my_listing_single">
                                                    <label for="unit_description">Unit Description / Specials / Available
                                                        Dates</label>
                                                    <textarea class="form-control summer_note mt-1" name="unit_description"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <div class="my_listing_single">
                                                    <label for="special">Special</label>
                                                    <textarea class="form-control summer_note mt-1" name="special"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-6">
                                                <div id="medicine_row">
                                                    <label for="available_dates">Available Dates</label>
                                                    <div class="medicine_row_input">
                                                        <input type="date" name="dates[]" id="available_dates">
                                                        <button type="button" id="add_row"><i class="fas fa-plus" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="propertyId" name="propertyId"
                                            placeholder="(e.g. Studio, 2 bed 1 bath Plus Den)"
                                            value="{{$propertyId}}">

                                            <div class="col-12">
                                                <button type="submit" class="read_btn float-right">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
