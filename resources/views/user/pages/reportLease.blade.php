@extends('user/layout/app')
@section('content')
    <div class="header-premium-gradient mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="text-white fw-bold display-5 mb-2">Report Lease</h1>
                    <p class="text-white opacity-75 lead mb-0">Submit your lease report for tracking</p>
                </div>
                <div class="col-md-6 text-md-end mt-4 mt-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-md-end mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Report Lease</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section id="listing_grid" class="grid_view">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <x-dashboard-sidebar />
                </div>
                <div class="col-lg-9">
                    <div class="dashboard_content">
                        <div class="dashboard_content">
                            <div class="my_listing">
                                <h4> Report Lease </h4>
                                
                                <form id="reportLease">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12">
                                            <div class="row">
                                                
                                                <div class="col-xl-12 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="username">Name or names on lease <span class="text-danger">*</span></label>
                                                        <div class="input_area">
                                                            <textarea name="" id="" cols="30" rows="3" id="username" name="username"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="email">New Rental Address <span class="text-danger"> *</span></label>
                                                        <div class="input_area">
                                                            <input type="email" id="email" name="email"
                                                                placeholder="Email" value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-12">
                                                    <div class="my_listing_single">
                                                        <label for="firstname">Apt. #(Required if Applicable) </label>
                                                        <div class="input_area">
                                                            <input type="text" id="apt" name="apt" placeholder="First Name" value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="lastname">State  <span
                                                                class="text-danger">*</span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="lastname" name="lastname"
                                                                placeholder="Last Name"
                                                                value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="lastname">City  <span
                                                                class="text-danger">*</span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="lastname" name="lastname"
                                                                placeholder="Last Name"
                                                                value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="zipcode">Zip Code <span class="text-danger"> * </span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="zipcode" name="zipcode"
                                                                placeholder="Zip Code" value="" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="cell">Phone </label>
                                                        <div class="input_area">
                                                            <input type="text" id="phpne" name="phone" placeholder="Phone" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="cell"> Email ID <span class="text-danger">*</span> </label>
                                                        <div class="input_area">
                                                            <input type="email" id="email" name="email" placeholder="Email" value="" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="lastname">Move-in Date  <span
                                                                class="text-danger">*</span></label>
                                                        <div class="input_area">
                                                            <input type="date" id="movedate" name="movedate" placeholder="Move Date" value="" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="lastname">Length of Lease  <span
                                                                class="text-danger">*</span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="lengthlease" name="lengthlease" placeholder="Length Lease" value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="zipcode">Rent Amount<span class="text-danger"> * </span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="rentamount" name="rentamount" placeholder="Zip Code" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="lastname">Name of Community or Landlord  <span
                                                                class="text-danger">*</span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="namecommunityorlandlord" name="namecommunityorlandlords" placeholder="Name of Community or Landlord" value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="lastname">Landlord's Telephone </label>
                                                        <div class="input_area">
                                                            <input type="text" id="landlordtelephone" name="landlordtelephone" placeholder="Landlord's Telephone" value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="zipcode">Name of Person Who assisted You <span class="text-danger"> * </span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="zipcode" name="zipcode" placeholder="Zip Code" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                                <div class="col-12">
                                                    <button type="button" class="read_btn float-right" id="submitBtn">Submit</button>
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
        </div>
    </section>
@endsection
