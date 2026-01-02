@extends('user.layout.app')
@section('content')
@push('style')
<style>
    .about-section {
        position: relative;
        padding: 100px 0px;
    }

    .about-section .content-column {
        position: relative;
        margin-bottom: 40px;
    }

    .about-section .content-column .inner-column {
        position: relative;
        padding-top: 50px;
        padding-right: 100px;
    }

    .about-section .content-column .text {
        position: relative;
        color: #777777;
        font-size: 15px;
        line-height: 2em;
        margin-bottom: 40px;
    }

    .about-section .content-column .email {
        position: relative;
        color: #252525;
        font-weight: 700;
        margin-bottom: 50px;
    }

    .about-section .image-column {
        position: relative;
        margin-bottom: 50px;
    }

    .about-section .image-column .inner-column {
        position: relative;
        padding: 40px 40px 0px 0px;
        margin-left: 50px;
    }

    .about-section .image-column .inner-column:after {
        position: absolute;
        content: '';
        right: 0px;
        top: 0px;
        left: 40px;
        bottom: 100px;
        z-index: -1;
        border: 2px solid var(--colorPrimary, {
                {
                config('settings.site_default_color')
            }
        });
    }

    .about-section .image-column .inner-column .image {
        position: relative;
    }

    .about-section .image-column .inner-column .image:before {
        position: absolute;
        content: '';
        left: -50px;
        bottom: -50px;
        width: 299px;
        height: 299px;
        background: url(img/pattern-2.png) no-repeat;
    }

    .about-section .image-column .inner-column .image img {
        position: relative;
        width: 100%;
        display: block;
        height: 550px;
    }

    .about-section .image-column .inner-column .image .overlay-box {
        position: absolute;
        left: 40px;
        bottom: 48px;
    }

    .about-section .image-column .inner-column .image .overlay-box .year-box {
        position: relative;
        color: #252525;
        font-size: 24px;
        font-weight: 700;
        line-height: 1.4em;
        padding-left: 125px;
    }

    .about-section .image-column .inner-column .image .overlay-box .year-box .number {
        position: absolute;
        left: 0px;
        top: 0px;
        width: 110px;
        height: 110px;
        color: #0d7c66;
        font-size: 68px;
        font-weight: 700;
        line-height: 105px;
        text-align: center;
        background-color: #ffffff;
        border: 1px solid #000000;
    }

    .about-section .btn-style-three:before {
        position: absolute;
        content: '';
        left: 10px;
        top: 10px;
        z-index: -1;
        right: -10px;
        bottom: -10px;
        background: url(https://i.ibb.co/DKn55Qz/pattern-1.jpg) repeat;
    }

    .about-section .btn-style-three:hover {
        color: #ffffff;
        background: #0d7c66;
    }

    .about-section .btn-style-three {
        position: relative;
        line-height: 24px;
        color: #252525;
        font-size: 15px;
        font-weight: 700;
        background: none;
        display: inline-block;
        padding: 11px 40px;
        background-color: #ffffff;
        text-transform: capitalize;
        border: 2px solid #0d7c66;
        font-family: 'Arimo', sans-serif;
    }

    .sec-title2 {
        color: #fff;
    }

    .sec-title {
        position: relative;
        padding-bottom: 40px;
    }

    .sec-title .title {
        position: relative;
        color: #0d7c66;
        font-size: 24px;
        font-weight: 700;
        padding-right: 50px;
        margin-bottom: 15px;
        display: inline-block;
        text-transform: capitalize;
    }

    .sec-title .title:before {
        position: absolute;
        content: '';
        right: 0px;
        bottom: 7px;
        width: 40px;
        height: 1px;
        background-color: #bbbbbb;
    }
</style>
@endpush
@section('title', 'RentApartement | About-Us')
<div id="breadcrumb_part" style="background-image:url('images/breadcroumb_bg.jpg')">
    <div class="bread_overlay">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center text-white">
                    <h4>About Us</h4>
                    <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"> Home </a></li>
                            <li class="breadcrumb-item active" aria-current="page"> listing details </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>


<section class="about-section">
    <div class="container">
        <div class="row clearfix">

            <!--Content Column-->
            <div class="content-column col-md-6 col-sm-12 col-xs-12">
                <div class="inner-column">
                    <div class="sec-title">
                        <div class="title">About Us</div>
                        <h2> Free Relocation Assistance for Denver Apartments. </h2>
                    </div>
                    <div class="text"> Vita is the only Denver relocation company with a proven
                        model to provide free employee relocation assistance for apartment rentals.</div>

                    <div class="text font-weight-bold">We work with hundreds of landlords and have thousands of
                        rentals available every day so your employees will have more options and get a nicer apartment for less
                        money in the area that fits their personality.</div>

                    <div class="email">Request Quote: <span class="theme_color">freequote@gmail.com</span></div>
                    <a href="{{ route('home')}}" class="theme-btn btn-style-three">Home</a>
                </div>
            </div>

            <!--Image Column-->
            <div class="image-column col-md-6 col-sm-12 col-xs-12">
                <div class="inner-column " data-wow-delay="0ms" data-wow-duration="1500ms">
                    <div class="image">
                        <img src="https://images.pexels.com/photos/3184431/pexels-photo-3184431.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="">
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



<div class="container my-5">
    <div class="row mt-5">
        <div class="col-md-12 mx-auto">
            <p style="font-weight: 600;text-align:left;font-size: 1.4rem;">If your employees need a house rental or
                guided tour we also
                provide affordable paid services. </p>
            <p class="h5 mb-4" style="font-weight: 600;">About <span style="color: #94c045;">Paid Services:</span></p>
            <p style="text-align:left;">Full needs assessment by rental consultant to determine rental criteria,
                including area, budget, special needs and commute times
                Research and option process, including scheduling of appointments
                Scheduled tour, set appointments and transportation to rentals
                Area tour and information included with guided tours and private home searches
                Extensive follow-up with you to insure successful rental process
                If employee is not present our rental assistants will tour the private rentals, take pictures, advise,
                and help with the rental process.
            </p>
            <hr>
            <p class="h5 mb-4" style="font-weight: 600;">About <span style="color: #94c045  ;">Prices:</span></p>
            <p style="text-align:left;">
                Half-Day Tour (3-4 hours) includes comprehensive research of rental options, appointments to 4-6
                communities, and any additional relocation services, as requested. Cost: $400.00
                Full Day Tour (5-7 hours) includes rental options, 5-8 community appointments, orientation and preview
                of area. May include additional relocation services, as requested. Cost: $600.00
            </p>
            <p style="text-align:left;">If you are unfamiliar with the local rental market, and your time is at a
                premium, the Rental Tour is a great option to consider because we know Denver. As the leader in
                apartment finding, Vita maintains excellent relationships with hundreds of landlords. With such a large
                sponsorship, we know we can find the rental you are looking for!</p>

            <p style="text-align:left;">We work with all major employers. Using our professional rental consultants can
                alleviate the demands of starting a new job and relocating. We have the local experience and expertise
                to identify needs and options in a timely fashion and take the stress out of your move. Your employer
                may also cover the cost of your tour as part of your relocation benefits.</p>

            <p style="text-align:left;">We take you where you want to live and will tailor your tour to your exact
                needs. Our service covers all suburban and metropolitan areas that make up the Denver Metro. We're the
                experts at finding a place you'll love to call home!
            </p>
            <hr>
            <p class="h5 mb-4" style="font-weight:600;text-align:center;">About <span style="color:#94c045;">Additional
                    Services:</span></p>
            <div class="row">
                <div class="col-md-6">
                    <ul>
                        <li>Hotel or Airport Pick-up</li>
                        <li> City or Neighborhood Tours</li>
                        <li>School Information</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul>
                        <li>Furniture Rental Assistance</li>
                        <li>Moving Company Information</li>
                        <li>Insurance Information</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection