@extends('admin.auth.app')
@section('title', 'RentApartments Admin | Login')
@section('content')

<div class="container">
    <form id="loginForm" action="{{ url('admin/login') }}" method="POST">
        @csrf
        <div class="form-content">
            <div class="login-form">
                <div class="title">Admin Login</div>
                
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="input-groups">
                    <div class="input-box">
                        <i class="fas fa-user"></i>
                        <input type="text" class="input @error('admin_login_id') is-invalid @enderror" 
                               name="admin_login_id" id="admin_login_id"
                               value="{{ old('admin_login_id') }}"
                               placeholder="Enter your Username" required>
                    </div>
                    @error('admin_login_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-groups">
                    <div class="input-box">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" class="input @error('password') is-invalid @enderror" 
                               name="password" id="password" 
                               placeholder="Enter your password" required>
                        <i class="fa-regular fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-link pass">
                    <a href="{{ route('admin-forgot-password') }}">
                        <i class="fas fa-key me-1"></i> Forgot Password?
                    </a>
                </div>

                <div class="input-groups">
                    <div class="button input-box">
                        <button type="submit" id="loginBtn">
                            <span class="btn-text">Login</span>
                        </button>
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
    // Toggle password visibility
    $("#togglePassword").on("click", function() {
        const passwordField = $("#password");
        const type = passwordField.attr("type") === "password" ? "text" : "password";
        passwordField.attr("type", type);
        $(this).toggleClass("fa-eye fa-eye-slash");
    });

    // Basic client-side validation
    $('#loginForm').on('submit', function(e) {
        let isValid = true;
        const username = $('#admin_login_id').val().trim();
        const password = $('#password').val();

        // Clear previous errors
        $('.input').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        if (!username) {
            $('#admin_login_id').addClass('is-invalid');
            $('#admin_login_id').closest('.input-groups').append(
                '<div class="invalid-feedback">Please enter your username</div>'
            );
            isValid = false;
        }

        if (!password) {
            $('#password').addClass('is-invalid');
            $('#password').closest('.input-groups').append(
                '<div class="invalid-feedback">Please enter your password</div>'
            );
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut(300);
    }, 5000);
});
</script>
@endpush
