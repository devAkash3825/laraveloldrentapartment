@extends('admin.auth.app')
@section('content')
    <div class="container">
        <form id="reset-password-main-form">
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @csrf
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Forgot Password</div>

                    <!-- Request OTP Form -->
                    <div id="request-otp-section">
                        <div class="input-groups">
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="email" class="input" name="adminemail" placeholder="Enter your Email" required>
                            </div>
                        </div>
                        <div class="input-groups">
                            <div class="button input-box">
                                <button type="submit" id="request-otp-btn" class="submit-spinner">Reset Password Link</button>
                            </div>
                        </div>
                    </div>

                    <!-- Verify OTP Form -->
                    <div id="verify-otp-section" style="display:none;">
                        <div class="input-groups">
                            <div class="input-box">
                                <i class="fas fa-key"></i>
                                <input type="hidden" name="emailwithotp" value="">
                                <input type="text" class="input" name="otp" placeholder="Enter your OTP" required>
                            </div>
                        </div>
                        <div class="input-groups">
                            <div class="button input-box">
                                <button type="submit" id="verify-otp-btn" class="submit-spinner">Verify OTP</button>
                            </div>
                        </div>
                    </div>

                    <!-- Reset Password Form -->
                    <div id="reset-password-section" style="display:none;">
                        <div class="input-groups">
                            <div class="input-box">
                                <input type="hidden" name="resetpasswordemail" value="">
                                <input type="password" class="input" name="password" placeholder="Enter new password" required>
                            </div>
                        </div>
                        <div class="input-groups">
                            <div class="input-box">
                                <input type="password" class="input" name="password_confirmation" placeholder="Confirm new password" required>
                            </div>
                        </div>
                        <div class="input-groups">
                            <div class="button input-box">
                                <button type="submit" id="reset-password-btn" class="submit-spinner">Create New Password</button>
                            </div>
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
            $('#request-otp-btn').click(function(e) {
                e.preventDefault();
                let formData = $('#reset-password-main-form').serialize();
                let url = "{{ route('admin-request-password-reset') }}";
                
                $.post(url, formData, function(response) {
                    if (response.success) {
                        $('#request-otp-section').hide();
                        $('#verify-otp-section').show();
                        $('#verify-otp-section input[name="emailwithotp"]').val(response.email);
                        // $('#verify-otp-section input[name="emailwithotp"]').val($('input[name="emailwithotp"]').val());
                    } else {
                        toastr.error(response.message);
                    }
                }).fail(function(xhr) {
                    toastr.error(xhr.responseJSON.message || "An error occurred.");
                });
            });
            
            $('#verify-otp-btn').click(function(e) {
                e.preventDefault();
                let formData = $('#reset-password-main-form').serialize();
                let url = "{{ route('admin-verify-otp') }}";
                
                $.post(url, formData, function(response) {
                    if (response.success) {
                        // toastr.success(response.message);
                        $('#verify-otp-section').hide();
                        $('#reset-password-section').show();
                        $('#reset-password-section input[name="resetpasswordemail"]').val(response.email);
                    } else {
                        toastr.error(response.message);
                    }
                }).fail(function(xhr) {
                    toastr.error(xhr.responseJSON.message || "An error occurred.");
                });
            });
            
            $('#reset-password-btn').click(function(e) {
                e.preventDefault();
                let formData = $('#reset-password-main-form').serialize();
                let url = "{{ route('admin-reset-password') }}";
                
                $.post(url, formData, function(response) {
                    if (response.success) {
                        // toastr.success(response.message);
                        window.location.href = "{{ route('admin-login') }}";
                    } else {
                        toastr.error(response.message);
                    }
                }).fail(function(xhr) {
                    toastr.error(xhr.responseJSON.message || "An error occurred.");
                });
            });
        });
    </script>
@endpush


