<!-- <div class="qbox-container">
    <form id="manager-form" class="needs-validation" novalidate="">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-1">
                    <label class="form-label f-w700"><i class="fa-solid fa-user" style="color:var(--btn-color1);"></i>
                        Username <small style="color:red;">*</small></label>
                    <input class="form-control" name="username" type="text" required>
                    <div class="invalid-feedback" id="error-username">
                        Please Enter UserName.
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="mt-3">
                    <label class="form-label f-w700"><i class="fa-solid fa-envelope"
                            style="color:var(--btn-color1);"></i>
                        Email <small style="color:red;">*</small></label>
                    <input class="form-control" name="email" type="email" required>
                    <div class="invalid-feedback" id="error-email">
                        Please Enter a Valid Email Address.
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="mt-3">
                    <label class="form-label f-w700"><i class="fa-solid fa-key" style="color:var(--btn-color1);"></i>
                        Password <small style="color:red;">*</small></label>
                    <input class="form-control" name="password" type="password" required>
                    <div class="invalid-feedback" id="error-password">Please enter a password.</div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="mt-3">
                    <label class="form-label f-w700"><i class="fa-solid fa-key" style="color:var(--btn-color1);"></i>
                        Confirm Password <small style="color:red;">*</small>
                    </label>
                    <input class="form-control" name="password_confirmation" type="password" required>
                    <div class="invalid-feedback" id="error-password_confirmation">Passwords do not match.</div>
                </div>
            </div>

            <div class="col-md-12">
                <div id="q-box__buttons" style="display:flex;justify-content:space-between;">
                    <p class="create_account">Already have an account? <a href="{{ route('show-login') }}"> Login
                        </a>
                    </p>
                    <div class="d-flex gap-5">
                        <button type="submit" class="btn btn-primary-sm1 send-btn main-btn">Register</button>
                    </div>
                </div>
            </div>
        </div>




        {{-- <div class="mt-4">
            <label class="form-label"><i class="fa-solid fa-key" style="color:var(--btn-color1);"></i> Password</label>
            <input class="form-control" name="password" type="password" required>
            <div class="invalid-feedback" id="error-password">
                Please Enter Password.
            </div>
        </div>
        <div class="mt-4">
            <label class="form-label"><i class="fa-solid fa-key" style="color:var(--btn-color1);"></i> Confirm Password</label>
            <input class="form-control" name="password_confirmation" type="password" required>
            <div class="invalid-feedback" id="error-password_confirmation">
                Passwords do not match.
            </div>
        </div> --}}


    </form>
</div> -->

<style>
    /* Password toggle styles */
    .password-input-group {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 10px;
        top: 70%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
        background: none;
        border: none;
        padding: 0;
    }

    .password-input-group input {
        padding-right: 40px;
    }
</style>

<div class="qbox-container">
    <form id="manager-form" class="needs-validation" novalidate="" action="{{ route('manager-register') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="mt-1">
                    <label class="form-label f-w700"><i class="fa-solid fa-user" style="color:var(--btn-color1);"></i>
                        Username <small style="color:red;">*</small></label>
                    <input class="form-control" name="username" type="text" required>
                    <div class="invalid-feedback" id="error-username">
                        Please Enter UserName.
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="mt-3">
                    <label class="form-label f-w700"><i class="fa-solid fa-envelope"
                            style="color:var(--btn-color1);"></i>
                        Email <small style="color:red;">*</small></label>
                    <input class="form-control" name="email" type="email" required>
                    <div class="invalid-feedback" id="error-email">
                        Please Enter a Valid Email Address.
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="mt-3 password-input-group">
                    <label class="form-label f-w700"><i class="fa-solid fa-key" style="color:var(--btn-color1);"></i>
                        Password <small style="color:red;">*</small></label>
                    <input class="form-control" id="manager-password" name="password" type="password" required>
                    <span class="password-toggle mt-1" id="toggleManagerPassword">
                        <i class="bi bi-eye"></i>
                    </span>
                    <div class="invalid-feedback" id="error-password">Please enter a password.</div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="mt-3 password-input-group">
                    <label class="form-label f-w700"><i class="fa-solid fa-key" style="color:var(--btn-color1);"></i>
                        Confirm Password <small style="color:red;">*</small>
                    </label>
                    <input class="form-control" id="manager-password-confirmation" name="password_confirmation" type="password" required>
                    <span class="password-toggle mt-1" id="toggleManagerPasswordConfirmation">
                        <i class="bi bi-eye"></i>
                    </span>
                    <div class="invalid-feedback" id="error-password_confirmation">Passwords do not match.</div>
                </div>
            </div>

            <div class="col-md-12">
                <div id="q-box__buttons" style="display:flex;justify-content:space-between;">
                    <p class="create_account">Already have an account? <a href="{{ route('show-login') }}"> Login
                        </a>
                    </p>
                    <div class="d-flex gap-5">
                        <button type="submit" class="btn btn-primary-sm1 send-btn main-btn">Register</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Password toggle functionality for manager form
    document.addEventListener('DOMContentLoaded', function() {
        const toggleManagerPassword = document.querySelector('#toggleManagerPassword');
        const toggleManagerPasswordConfirmation = document.querySelector('#toggleManagerPasswordConfirmation');
        const managerPassword = document.querySelector('#manager-password');
        const managerPasswordConfirmation = document.querySelector('#manager-password-confirmation');

        // Toggle main password visibility
        if (toggleManagerPassword && managerPassword) {
            toggleManagerPassword.addEventListener('click', function() {
                // Toggle the type attribute
                const type = managerPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                managerPassword.setAttribute('type', type);

                // Toggle the eye icon
                const icon = this.querySelector('i');
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        }

        // Toggle confirmation password visibility
        if (toggleManagerPasswordConfirmation && managerPasswordConfirmation) {
            toggleManagerPasswordConfirmation.addEventListener('click', function() {
                // Toggle the type attribute
                const type = managerPasswordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
                managerPasswordConfirmation.setAttribute('type', type);

                // Toggle the eye icon
                const icon = this.querySelector('i');
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        }
    });
</script>