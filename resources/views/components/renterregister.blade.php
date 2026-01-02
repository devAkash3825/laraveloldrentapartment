<style>
    #q-box__buttons {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 20px;
    }

    #q-box__buttons button {
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }

    .prev-btn {
        background-color: #007bff;
        color: white;
    }

    .next-btn {
        background-color: #6c757d;
        color: white;
    }

    .submit-btn {
        background-color: #28a745;
        color: white;
    }

    button:hover {
        opacity: 0.9;
    }
    
    /* Password toggle styles */
    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
    }
    
    .password-input-group {
        position: relative;
    }
    
    .password-input-group input {
        padding-right: 40px;
    }
</style>
<div class="qbox-container">
    <form class="needs-validation" id="form-wrapper" name="form-wrapper" novalidate="">
        <!-- Step 1 -->
        <div class="step d-block">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-1">
                        <label class="form-label f-w700"><i class="fa-solid fa-user"
                                style="color:var(--btn-color1);"></i>
                            Username <small style="color:red;">*</small></label>
                        <input class="form-control" id="username" name="username" type="text" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mt-3">
                        <label class="form-label f-w700"><i class="fa-solid fa-envelope"
                                style="color:var(--btn-color1);"></i>
                            Email <small style="color:red;">*</small></label>
                        <input class="form-control" id="email" name="email" type="email" required>
                        <div class="invalid-feedback" id="error-email">Please enter a valid email.</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mt-3 password-input-group">
                        <label class="form-label f-w700"><i class="fa-solid fa-key"
                                style="color:var(--btn-color1);"></i>
                            Password <small style="color:red;">*</small></label>
                        <input class="form-control" id="password" name="password" type="password" required>
                        <span class="password-toggle mt-1" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </span>
                        <div class="invalid-feedback" id="error-password">Please enter a password.</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mt-3 password-input-group">
                        <label class="form-label f-w700"><i class="fa-solid fa-key"
                                style="color:var(--btn-color1);"></i>
                            Confirm Password <small style="color:red;">*</small></label>
                        <input class="form-control" id="password_confirmation" name="password_confirmation"
                            type="password" required>
                        <span class="password-toggle mt-1" id="togglePasswordConfirmation">
                            <i class="bi bi-eye"></i>
                        </span>
                        <div class="invalid-feedback" id="error-password_confirmation">Passwords do not match.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="step d-none">
            <div class="row">
                <div class="col-md-4">
                    <div class="mt-1">
                        <label class="form-label f-w700">
                            First Name <small style="color:red;">*</small></label>
                        <input class="form-control" id="firstname" name="firstname" type="text" required>
                        <div class="invalid-feedback" id="error-firstname"></div>
                        <div class="invalid-feedback" id="error-zip">First Name is Required </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mt-1">
                        <label class="form-label f-w700">
                            Last Name <small style="color:red;">*</small></label>
                        <input class="form-control" id="lastname" name="lastname" type="text">
                        <div class="invalid-feedback" id="error-lastname"></div>
                        <div class="invalid-feedback" id="error-zip">Last Name is Required </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mt-1">
                        <label class="form-label"><i class="fa-solid fa-user" style="color:var(--btn-color1);"></i> Zip
                            <small style="color:red;">*</small></label>
                        <input class="form-control" id="zip" name="zip" type="text" pattern="\d*"
                            required>
                        <div class="invalid-feedback" id="error-zip">Please enter a valid zip code.</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="form-label f-w700">
                            Cell<small style="color:red;">*</small> </label>
                        <input class="form-control" id="cell" name="cell" type="text">
                        <div class="invalid-feedback" id="error-cell"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="form-label f-w700">Other Phone </label>
                        <input class="form-control" id="otherphone" name="otherphone" type="text">
                        <div class="invalid-feedback" id="error-otherphone"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="form-label f-w700">State
                            <small style="color:red;">*</small> </label>
                        <select class="form-control form-select form-control-a state-select-box" name="renterstate"
                            id="renterstate" required>
                            <option value="">Select State</option>
                            @foreach ($state as $row)
                            <option value="{{ $row->Id }}">{{ $row->StateName }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please select a state.
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="form-label f-w700">City
                            <small style="color:red;">*</small> </label>
                        <select class="form-control form-select form-control-a" id="rentercity" name="rentercity"
                            required>
                            <option value="">Select City</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a city.
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mt-3">
                        <label class="form-label"><i class="fa-solid fa-key" style="color:var(--btn-color1);"></i>
                            Moving To
                            <small style="color:red;">*</small> </label>
                        <textarea rows="3" name="currentAddress" id="currentAddress" placeholder="Type your message"
                            class="formbold-form-input" required></textarea>
                        <div class="invalid-feedback">
                            This Field is Required .
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="step d-none">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-1">
                        <label class="form-label f-w700">What area/neighborhoods are you wanting to move to </label>
                        <input class="form-control" id="aboutmovein" name="aboutmovein" type="text">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mt-3">
                        <label for="dob" class="form-label f-w700"> Earliest Move Date </label>
                        <input type="date" name="earliestdate" id="earliestdate" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mt-3">
                        <label for="dob" class="form-label f-w700"> Latest Move Date </label>
                        <input type="date" name="latestdate" id="latestdate" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="form-label f-w700">Pet Info </label>
                        <input class="form-control" id="petinfo" name="petinfo" type="text">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mt-3">
                        <label class="form-label f-w700">Hear About </label>
                        <select class="form-control form-select form-control-a" id="source" name="source"
                            required>
                            <option value="">Source</option>
                            @foreach ($source as $row)
                            <option value="{{ $row->Id }}">{{ $row->SourceName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="step d-none">
            <div class="row">
                <div class="col-md-12">
                    <div class="css-ehvwec er0i63m2">
                        <div class="css-frayro er0i63m0 mt-2">
                            <h4> Select how many bedrooms you want. </h4>
                            <div class="selectbeds-div erdrl0c0 mt-3">
                                <label class="css-17p3mg6 eyqmukb3">
                                    <input type="checkbox" name="bedrooms[]" value="1" aria-label="1 Bed"
                                        class="d-none" />
                                    <div aria-hidden="true" class="css-fmv2zp eyqmukb2">1</div>
                                    <div class="css-hh5vnd eyqmukb0">1 Bed</div>
                                </label>
                                <label class="css-17p3mg6 eyqmukb3">
                                    <input type="checkbox" name="bedrooms[]" value="2" aria-label="2 Bed"
                                        class="d-none" />
                                    <div aria-hidden="true" class="css-fmv2zp eyqmukb2">2</div>
                                    <div class="css-hh5vnd eyqmukb0">2 Beds</div>
                                </label>
                                <label class="css-17p3mg6 eyqmukb3">
                                    <input type="checkbox" name="bedrooms[]" value="3" aria-label="3 Beds"
                                        class="d-none" />
                                    <div aria-hidden="true" class="css-fmv2zp eyqmukb2">3</div>
                                    <div class="css-hh5vnd eyqmukb0">3 Beds</div>
                                </label>
                                <label class="css-17p3mg6 eyqmukb3">
                                    <input type="checkbox" name="bedrooms[]" value="4" aria-label="4 Beds"
                                        class="d-none" />
                                    <div aria-hidden="true" class="css-fmv2zp eyqmukb2">4</div>
                                    <div class="css-hh5vnd eyqmukb0">4 Beds</div>
                                </label>
                                <label class="css-17p3mg6 eyqmukb3">
                                    <input type="checkbox" name="bedrooms[]" value="5" aria-label="5+ Beds"
                                        class="d-none" />
                                    <div aria-hidden="true" class="css-fmv2zp eyqmukb2">5+</div>
                                    <div class="css-hh5vnd eyqmukb0">5+ Beds</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mt-4">
                        <h4> Additional Information. </h4>
                        <textarea class="form-control mt-3" id="additional_info" name="additional_info" rows="4"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="step d-none" id="step-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-4">
                        <label class="form-label">
                            <i class="fa-solid fa-bed" style="color:var(--btn-color1);"></i>
                            What are you looking to pay? <small style="color:red;">*</small>
                        </label>
                        <div class="css-ehvwec er0i63m2">
                            <div class="css-frayro er0i63m0">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <!-- From Price -->
                                        <label for="price-from" class="form-label">From</label>
                                        <input type="number" class="form-control" id="price-from" name="price_from"
                                            placeholder="Min Price" required>
                                        <div class="invalid-feedback" id="error-price-from">Please enter a minimum
                                            price.</div>
                                    </div>
                                    <div class="col-lg-6">
                                        <!-- To Price -->
                                        <label for="price-to" class="form-label">To</label>
                                        <input type="number" class="form-control" id="price-to" name="price_to"
                                            placeholder="Max Price" required>
                                        <div class="invalid-feedback" id="error-price-to">Please enter a maximum
                                            price.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="q-box__buttons" style="display: flex; gap: 15px; justify-content: flex-end;">
            <button id="before-btn" type="button" class="prev-btn btn-primary w-10">
                <span><i class="bi bi-chevron-left text-white"></i></span> Previous
            </button>
            <button id="after-btn" type="button" class="next-btn">
                Next <span><i class="bi bi-chevron-right text-white"></i></span>
            </button>
            <button id="renterRegister-btn" class="submit-btn" type="submit">
                <span><i class="bi bi-check2-circle text-white"></i></span> Submit
            </button>
        </div>

        <div class="d-flex justify-content-betweens">
            <p class="create_account">Already have an account ? <a href="{{ route('show-login') }}"> Login </a></p>
        </div>
    </form>
</div>

<script>
// Password toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelector('#togglePassword');
    const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
    const password = document.querySelector('#password');
    const passwordConfirmation = document.querySelector('#password_confirmation');
    
    if (togglePassword && password) {
        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle the eye icon
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
    
    if (togglePasswordConfirmation && passwordConfirmation) {
        togglePasswordConfirmation.addEventListener('click', function() {
            // Toggle the type attribute
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            
            // Toggle the eye icon
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
});

// Your existing JavaScript code would go here...
// Make sure to include the JavaScript code I provided earlier for validation
</script>