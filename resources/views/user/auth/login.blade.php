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

        .title-container {
            height: 150px;
            position: relative;
            color: #fff;
            width: 75%;
            left: 60px;

        }

        .title-container div {
            background-color: rgba(255, 255, 255, 0.4);
            -webkit-backdrop-filter: blur(5px);
            backdrop-filter: blur(5px);
            padding: 20px;
        }

        .logo-image {
            width: 100%;
            margin-bottom: 15px;
            object-fit: contain !important;
        }



        .step {
            width: 100%;
            display: none;
            padding: 0px 20px;
        }

        .qbox-container {
            background-repeat: repeat;
            position: relative;
            padding: 30px;
            height: 100% !important;
        }

        .qbox-container {
            background-color: #f7f0f0;
        }

        button#submit-btn {
            font-size: 17px;
            font-weight: bold;
            position: relative;
            width: 130px;
            height: 50px;
            background: #4caa86;
            margin: 0 auto;
            margin-top: 40px;
            overflow: hidden;
            z-index: 1;
            cursor: pointer;
            transition: color .3s;
            text-align: center;
            color: #fff;
            border: 0;
        }

        @media (max-width: 767px) {
            .login-bg {
                height: 60vh;
            }
        }

        @media (max-width: 560px) {
            .login-bg {
                height: 60vh;


                label {
                    font-size: 16px;
                    font-size: 1rem;
                    font-weight: 600;
                    margin-bottom: 5px;
                    color: #00011c;
                }

                button#submit-btn {
                    font-size: 17px;
                    font-weight: bold;
                    position: relative;
                    width: 140px;
                    height: 50px;
                    background: #4caa86;
                    margin: 0 auto;
                    margin-top: 40px;
                    overflow: hidden;
                    z-index: 1;
                    cursor: pointer;
                    transition: color .3s;
                    text-align: center;
                    color: #fff;
                    border: 0;
                }
            }

            .auth-section {
                height: 100%;
            }

            .toggle-password {
                cursor: pointer;
            }
    </style>
<section id="login-section">
    <div class="container">
        <a href="{{ route('home') }}" class="btn back-home-btn">
            <i class="bi bi-caret-left-fill"></i> Back to Home
        </a>
        <div class="row auth-section">
            <div class="col-lg-6  auth-row-col4 p-0">
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
                            <!-- Show error message -->
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <h2>Welcome back!</h2>
                            <p>sign in to continue</p>

                            <form action="{{ route('login') }}" class="login-form needs-validation" id="form-wrapper"
                                method="post" name="form-wrapper" novalidate="">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <label>User Name</label>
                                            <input type="text" placeholder="Username" id="username" name="username">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <label>Password</label>
                                            <div class="d-flex mb-3" style="position:relative;">
                                                <input type="password" placeholder="Password" id="password"
                                                    name="password">
                                                <i class="bi bi-eye-fill toggle-password show-password" id="togglePassword"
                                                    style="position:absolute;top:9px;right:10px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <button type="submit" id="submit-btn float-right grad-btn">login</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="col-xl-12 d-flex justify-content-between">
                                <p class="create_account">Dont’t have an account ? <a
                                        href="{{ route('user-register') }}">Create Account</a></p>
                                <p class="create_account"> <a href="{{ route('forgot-password') }}"> Forgot your password ?
                                    </a> </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
        </section>
@endsection
@push('authscript')
    <script>
        $(document).ready(function() {
            $(".show-password").on("click", function() {
                const passwordField = $("#password");
                const type = passwordField.attr("type") === "password" ? "text" : "password";
                passwordField.attr("type", type);
                $(this).toggleClass("bi-eye-fill bi-eye-slash-fill");
            });
        });
    </script>
@endpush
