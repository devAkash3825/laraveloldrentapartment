@extends('admin.auth.app')
@section('content')
    <div class="container">
        <form action="{{ url('admin/login') }}" method="POST">
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @csrf
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Admin Login </div>
                    <div class="input-groups">
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="text" class="input" name="admin_login_id" placeholder="Enter your Usename">
                        </div>
                    </div>
                    <div class="input-groups">
                        <div class="input-box">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" class="input" name="password" id="password" placeholder="Enter your password">
                            <i class="fa-regular fa-eye toggle-password show-password" id="togglePassword"
                                style="position: absolute;top:17px;right:10px;"></i>
                        </div>
                    </div>
                    <div class="form-link pass">
                        <a href="{{ route('admin-forgot-password')}}">Forgot Password</a>
                    </div>

                    <div class="input-groups">
                        <div class="button input-box">
                            <button type="submit">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('authscripts')
    <script>
        $(document).ready(function() {
            $(".show-password").on("click", function() {
                const passwordField = $("#password");
                const type = passwordField.attr("type") === "password" ? "text" : "password";
                passwordField.attr("type", type);
                $(this).toggleClass("fa-eye fa-eye-slash");
            });
        });
    </script>
@endpush
