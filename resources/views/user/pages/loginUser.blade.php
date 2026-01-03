@extends('user.layout.app')
@section('content')
@section('title', 'RentApartement | Contact-Us')
<style>
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
</style>
<div id="breadcrumb_part"
    style="background: url(../images/breadcroumb_bg.jpg);background-size: cover;background-repeat: no-repeat;background-position: center;">
    <div class="bread_overlay">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center text-white">
                    <h4> Login </h4>
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"> Home </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Login  </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <section id="get_in_touch">
    <div class="container">
        
    </div>
</section> --}}
<section class="wsus__login_page">
    <div class="container">
        <div class="row">
            {{-- <div class="col-xl-6 col-md-4 col-lg-7">
                <div class="title-containers">
                    <div class="login-left-img-block">
                        <div> <img src="{{ asset('img/login-bg.jpg') }}" alt=""></div>
                        <div class="brand-logo"><img class="logo-images" src="{{ asset('img/logovitalg.png') }}" width="250" height="100"></div>
                    </div>
                </div>
            </div> --}}
            <div class="col-lg-6  auth-row-col4 p-0">
                <div class="title-containers">
                    <div class="login-left-img-block">
                        <div> <img src="{{ asset('img/login-bg.jpg') }}" alt=""></div>
                        <div class="brand-logo"><img class="logo-images" src="{{ asset('img/logovitalg.png') }}" width="250" height="100"></div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-5 col-xl-6 col-md-8 col-lg-7">
                <div class="wsus__login_area">
                    <h2>Welcome back!</h2>
                    <p>sign in to continue</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="wsus__login_imput">
                                    <label>Email or Username</label>
                                    <input type="text" placeholder="Email or Username" name="login_id" value="{{ old('login_id') }}" required>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="wsus__login_imput" style="position: relative;">
                                    <label>password</label>
                                    <input type="password" placeholder="Password" name="password" id="login_user_pass" required >
                                    <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('login_user_pass', event)" style="position: absolute; right: 15px; top: 40px; border: none; background: none; color: #999;">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="wsus__login_imput wsus__login_check_area">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault" name="remember">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Remeber Me
                                        </label>
                                    </div>
                                    <a href="">Forget Password ?</a>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="wsus__login_imput">
                                    <button type="submit">login</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p class="or"><span>or</span></p>
                    <ul class="d-flex">
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                    </ul>
                    <p class="create_account">Dont’t have an aceount ? <a href="">Create Account</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
    $("#submitcontactus").submit(function(e) {
        e.preventDefault();
        var url = "{{ route('submit-contact-us') }}";
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
                    `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Submitting...`
                )
                $('.read_btn').prop('disabled', true);
            },
            success: function(response) {
                if (response.message) {
                    toastr.success(response.message);
                    $("#submitcontactus")[0].reset();
                    $('.read_btn').html(`Submit`)
                    $('.read_btn').prop('disabled', false);
                }
            },
            error: function(xhr) {
                toastr.error("An error occurred. Please try again.");
                $('.read_btn').html(
                    `Submit`
                )
                $('.read_btn').prop('disabled', false);
            },
        });
        
        $(this).addClass('was-validated');
    });
</script>
@endpush
