@extends('admin.auth.app')
@section('title', 'RentApartments Admin | Forgot Password')
@section('content')

<div class="container">
    <form id="reset-password-main-form" method="POST">
        @csrf
        <div class="form-content">
            <div class="login-form">
                <div class="title">Forgot Password</div>
                <p class="text-muted text-center mb-4" id="step-description">
                    Enter your email address and we'll send you an OTP to reset your password.
                </p>

                {{-- Step 1: Request OTP --}}
                <div id="request-otp-section">
                    <div class="input-groups">
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="email" class="input" name="adminemail" id="adminemail" 
                                   placeholder="Enter your Email" required>
                        </div>
                        <div class="invalid-feedback" id="email-error"></div>
                    </div>
                    <div class="input-groups">
                        <div class="button input-box">
                            <button type="button" id="request-otp-btn" class="submit-btn">
                                <span class="btn-text">Send OTP</span>
                                <span class="btn-loader d-none">
                                    <i class="fas fa-spinner fa-spin"></i> Sending...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Step 2: Verify OTP --}}
                <div id="verify-otp-section" style="display:none;">
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-envelope-open-text me-2"></i>
                        OTP sent to <strong id="otp-sent-email"></strong>
                    </div>
                    <div class="input-groups">
                        <div class="input-box">
                            <i class="fas fa-key"></i>
                            <input type="hidden" name="emailwithotp" id="emailwithotp" value="">
                            <input type="text" class="input" name="otp" id="otp" 
                                   placeholder="Enter 6-digit OTP" maxlength="6" required>
                        </div>
                        <div class="invalid-feedback" id="otp-error"></div>
                    </div>
                    <div class="input-groups">
                        <div class="button input-box">
                            <button type="button" id="verify-otp-btn" class="submit-btn">
                                <span class="btn-text">Verify OTP</span>
                                <span class="btn-loader d-none">
                                    <i class="fas fa-spinner fa-spin"></i> Verifying...
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="javascript:void(0)" id="resend-otp-link" class="text-muted">
                            <i class="fas fa-redo me-1"></i> Resend OTP
                        </a>
                    </div>
                </div>

                {{-- Step 3: Reset Password --}}
                <div id="reset-password-section" style="display:none;">
                    <div class="alert alert-success mb-3">
                        <i class="fas fa-check-circle me-2"></i>
                        OTP verified! Create your new password.
                    </div>
                    <div class="input-groups">
                        <input type="hidden" name="resetpasswordemail" id="resetpasswordemail" value="">
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" class="input" name="password" id="new_password" 
                                   placeholder="Enter new password" required>
                        </div>
                        <small class="text-muted">Minimum 8 characters</small>
                        <div class="invalid-feedback" id="password-error"></div>
                    </div>
                    <div class="input-groups">
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" class="input" name="password_confirmation" 
                                   id="password_confirmation" placeholder="Confirm new password" required>
                        </div>
                        <div class="invalid-feedback" id="confirm-error"></div>
                    </div>
                    <div class="input-groups">
                        <div class="button input-box">
                            <button type="button" id="reset-password-btn" class="submit-btn">
                                <span class="btn-text">Reset Password</span>
                                <span class="btn-loader d-none">
                                    <i class="fas fa-spinner fa-spin"></i> Resetting...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Back to Login --}}
                <div class="text-center mt-4">
                    <a href="{{ route('admin-login') }}" class="text-muted">
                        <i class="fas fa-arrow-left me-1"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('authscripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Helper to show/hide loader
    function setLoading($btn, loading) {
        if (loading) {
            $btn.prop('disabled', true);
            $btn.find('.btn-text').addClass('d-none');
            $btn.find('.btn-loader').removeClass('d-none');
        } else {
            $btn.prop('disabled', false);
            $btn.find('.btn-text').removeClass('d-none');
            $btn.find('.btn-loader').addClass('d-none');
        }
    }

    function showError(elementId, message) {
        $(elementId).text(message).show();
    }

    function clearErrors() {
        $('.invalid-feedback').hide().text('');
        $('.input').removeClass('is-invalid');
    }

    // Step 1: Request OTP
    $('#request-otp-btn').click(function(e) {
        e.preventDefault();
        clearErrors();
        
        const email = $('#adminemail').val().trim();
        if (!email) {
            showError('#email-error', 'Please enter your email address');
            $('#adminemail').addClass('is-invalid');
            return;
        }

        const $btn = $(this);
        setLoading($btn, true);

        $.ajax({
            url: "{{ route('admin-request-password-reset') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                adminemail: email
            },
            success: function(response) {
                if (response.success) {
                    $('#request-otp-section').slideUp(300, function() {
                        $('#verify-otp-section').slideDown(300);
                        $('#emailwithotp').val(response.email);
                        $('#otp-sent-email').text(response.email);
                        $('#step-description').text('Enter the 6-digit OTP sent to your email.');
                    });
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'OTP Sent!',
                        text: response.message,
                        confirmButtonColor: '#fe5c24'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        confirmButtonColor: '#fe5c24'
                    });
                }
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg,
                    confirmButtonColor: '#fe5c24'
                });
            },
            complete: function() {
                setLoading($btn, false);
            }
        });
    });

    // Step 2: Verify OTP
    $('#verify-otp-btn').click(function(e) {
        e.preventDefault();
        clearErrors();

        const otp = $('#otp').val().trim();
        if (!otp || otp.length !== 6) {
            showError('#otp-error', 'Please enter a valid 6-digit OTP');
            $('#otp').addClass('is-invalid');
            return;
        }

        const $btn = $(this);
        setLoading($btn, true);

        $.ajax({
            url: "{{ route('admin-verify-otp') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                emailwithotp: $('#emailwithotp').val(),
                otp: otp
            },
            success: function(response) {
                if (response.success) {
                    $('#verify-otp-section').slideUp(300, function() {
                        $('#reset-password-section').slideDown(300);
                        $('#resetpasswordemail').val(response.email);
                        $('#step-description').text('Create a new secure password for your account.');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid OTP',
                        text: response.message,
                        confirmButtonColor: '#fe5c24'
                    });
                }
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || 'Invalid OTP. Please try again.';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg,
                    confirmButtonColor: '#fe5c24'
                });
            },
            complete: function() {
                setLoading($btn, false);
            }
        });
    });

    // Step 3: Reset Password
    $('#reset-password-btn').click(function(e) {
        e.preventDefault();
        clearErrors();

        const password = $('#new_password').val();
        const confirm = $('#password_confirmation').val();

        if (password.length < 8) {
            showError('#password-error', 'Password must be at least 8 characters');
            $('#new_password').addClass('is-invalid');
            return;
        }

        if (password !== confirm) {
            showError('#confirm-error', 'Passwords do not match');
            $('#password_confirmation').addClass('is-invalid');
            return;
        }

        const $btn = $(this);
        setLoading($btn, true);

        $.ajax({
            url: "{{ route('admin-reset-password') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                resetpasswordemail: $('#resetpasswordemail').val(),
                password: password,
                password_confirmation: confirm
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Reset!',
                        text: 'Your password has been successfully reset. You can now login.',
                        confirmButtonColor: '#fe5c24'
                    }).then(() => {
                        window.location.href = "{{ route('admin-login') }}";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        confirmButtonColor: '#fe5c24'
                    });
                }
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || 'Failed to reset password.';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg,
                    confirmButtonColor: '#fe5c24'
                });
            },
            complete: function() {
                setLoading($btn, false);
            }
        });
    });

    // Resend OTP
    $('#resend-otp-link').click(function(e) {
        e.preventDefault();
        const email = $('#emailwithotp').val();
        
        if (!email) return;

        $(this).html('<i class="fas fa-spinner fa-spin"></i> Sending...');

        $.ajax({
            url: "{{ route('admin-request-password-reset') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                adminemail: email
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'OTP Resent!',
                        text: 'A new OTP has been sent to your email.',
                        confirmButtonColor: '#fe5c24'
                    });
                }
            },
            complete: function() {
                $('#resend-otp-link').html('<i class="fas fa-redo me-1"></i> Resend OTP');
            }
        });
    });
});
</script>
@endpush
