@extends('user.auth.layout.app')
@section('authcontent')
    <style>
        .login-bg a {
            color: white;
        }

        .login-bg {
            background-image: url("{{ asset('img/login-bg.jpg') }}");
            height: 100vh;
            align-content: center;
            align-items: center;
        }
    </style>


<section id="login-section">
    <div class="container">
        <a href="{{ route('home') }}" class="btn back-home-btn"> <i class="bi bi-caret-left-fill"></i> Back to Home </a>
        <div class="row auth-section">
            <div class="col-lg-6 auth-row-col4 p-0">
                <div class="title-containers">
                <div class="login-left-img-block">
                        <div> <img src="{{ asset('img/login-bg.jpg') }}" alt=""></div>
                        <div class="brand-logo"><img class="logo-images" src="{{ asset('img/logovitalg.png') }}" width="250" height="100"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-12">
                <section class="wsus__login_page p-0">
                    <div class="container">
                        <div class="wsus__login_area">
                            <h2>Welcome !</h2>

                            <nav class="section-t3">
                                <ul class="tabs">
                                    <li class="tab-li">
                                        <a href="#renterregister" class="tab-li__link"> Renter Registration </a>
                                    </li>
                                    
                                    <li class="tab-li">
                                        <a href="#managerregister" class="tab-li__link">Property Manager Registration </a>
                                    </li>
                                    
                                </ul>
                            </nav>

                            <section id="renterregister" data-tab-content class="">
                                <x-renterregister /> 
                            </section>

                            <section id="managerregister" data-tab-content class="">
                                <x-managerregister />
                            </section>

                           
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    </section>
@endsection
