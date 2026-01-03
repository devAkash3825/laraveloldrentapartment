    <div class="registration-form-header mb-4">
        <h3 class="fw-bold text-slate">Register as Renter</h3>
        <p class="text-muted small">Please fill in the details below to complete your profile.</p>
    </div>

    <form class="needs-validation" id="renter-registration-form" novalidate>
        @csrf
        <!-- Step 1: Account Info -->
        <div class="form-step active" id="step0">
            <h4 class="mb-4 d-flex align-items-center"><i class="bi bi-shield-lock me-2 text-primary"></i> Account Security</h4>
            <div class="mb-4">
                <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                <div class="input-group-custom">
                    <i class="bi bi-person"></i>
                    <input type="text" class="form-control" name="username" placeholder="Choose a username" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                <div class="input-group-custom">
                    <i class="bi bi-envelope"></i>
                    <input type="email" class="form-control" name="email" placeholder="email@example.com" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock"></i>
                        <input type="password" class="form-control" id="renter_password" name="password" placeholder="••••••••" required>
                        <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('renter_password')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-shield-check"></i>
                        <input type="password" class="form-control" id="renter_password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Personal Info -->
        <div class="form-step" id="step1">
            <h4 class="mb-4 d-flex align-items-center"><i class="bi bi-person-badge me-2 text-primary"></i> Personal Details</h4>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-tag"></i>
                        <input type="text" class="form-control" name="firstname" placeholder="First Name" required>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-tag"></i>
                        <input type="text" class="form-control" name="lastname" placeholder="Last Name" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Cell Phone <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-phone"></i>
                        <input type="tel" class="form-control" name="cell" placeholder="(555) 000-0000" required>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Other Phone</label>
                    <div class="input-group-custom">
                        <i class="bi bi-telephone"></i>
                        <input type="tel" class="form-control" name="otherphone" placeholder="Other phone (optional)">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">State <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-geo"></i>
                        <select class="form-select state-select" name="renterstate" required>
                            <option value="">Select State</option>
                            @foreach ($state as $row)
                                <option value="{{ $row->Id }}">{{ $row->StateName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-geo-alt"></i>
                        <select class="form-select city-select" name="rentercity" required disabled>
                            <option value="">Select City</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Current Address <span class="text-danger">*</span></label>
                <div class="input-group-custom">
                    <textarea class="form-control" name="currentAddress" rows="2" placeholder="Your full current address" required></textarea>
                    <i class="bi bi-house-door"></i>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Zip Code <span class="text-danger">*</span></label>
                <div class="input-group-custom">
                    <i class="bi bi-mailbox"></i>
                    <input type="text" class="form-control" name="zip" placeholder="Zip Code" required>
                </div>
            </div>
        </div>

        <!-- Step 3: Preferences -->
        <div class="form-step" id="step2">
            <h4 class="mb-4 d-flex align-items-center"><i class="bi bi-cursor me-2 text-primary"></i> Moving Preferences</h4>
            <div class="mb-4">
                <label class="form-label fw-semibold">Target Areas/Neighborhoods <span class="text-danger">*</span></label>
                <div class="input-group-custom">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" name="aboutmovein" placeholder="e.g. Downtown, Uptown" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Earliest Move Date <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-calendar-event"></i>
                        <input type="date" class="form-control" name="earliestdate" required>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Latest Move Date <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-calendar-check"></i>
                        <input type="date" class="form-control" name="latestdate" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Pet Information <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-paw"></i>
                        <input type="text" class="form-control" name="petinfo" placeholder="Dogs, Cats, None" required>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">How did you hear about us? <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-megaphone"></i>
                        <select class="form-select" name="source" required>
                            <option value="">Select Source</option>
                            @foreach ($source as $row)
                                <option value="{{ $row->Id }}">{{ $row->SourceName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Details -->
        <div class="form-step" id="step3">
            <h4 class="mb-4 d-flex align-items-center"><i class="bi bi-list-stars me-2 text-primary"></i> Apartment Details</h4>
            <div class="mb-4">
                <label class="form-label fw-semibold d-block mb-3">Bedrooms Needed <span class="text-danger">*</span></label>
                <div class="bedroom-selector">
                    @foreach (['1', '2', '3', '4', '5+'] as $bed)
                        <input type="checkbox" class="btn-check" name="bedrooms[]" value="{{ $bed }}" id="bed{{ $bed }}">
                        <label class="btn btn-outline-primary-custom" for="bed{{ $bed }}">{{ $bed }} Bed</label>
                    @endforeach
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Additional Information <span class="text-danger">*</span></label>
                <div class="input-group-custom">
                    <textarea class="form-control" name="additional_info" rows="4" placeholder="Any other specific requirements?" required></textarea>
                    <i class="bi bi-chat-left-text"></i>
                </div>
            </div>
        </div>

        <!-- Step 5: Budget -->
        <div class="form-step" id="step4">
            <h4 class="mb-4 d-flex align-items-center"><i class="bi bi-wallet2 me-2 text-primary"></i> Budget Range</h4>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Minimum Monthly Rent ($) <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-cash-stack"></i>
                        <input type="number" class="form-control" name="price_from" placeholder="0" required>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Maximum Monthly Rent ($) <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-cash-stack"></i>
                        <input type="number" class="form-control" name="price_to" placeholder="99999" required>
                    </div>
                </div>
            </div>
            <div class="alert alert-info py-3 rounded-4 border-0" style="background: rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.1); color: var(--colorPrimary);">
                <i class="bi bi-info-circle-fill me-2"></i> Almost done! Review your details before creating your account.
            </div>
        </div>

        <div class="form-navigation mt-4 d-flex justify-content-between">
            <button type="button" class="btn btn-secondary-custom prev-btn shadow-sm" style="display: none;">
                <i class="bi bi-arrow-left me-1"></i> Back
            </button>
            <button type="button" class="btn btn-primary-custom next-btn ms-auto shadow-sm">
                Next <i class="bi bi-arrow-right ms-1"></i>
            </button>
            <button type="submit" class="btn btn-success-custom submit-btn ms-auto shadow-sm" style="display: none;">
                <i class="bi bi-check2-circle me-2"></i> Register Now
            </button>
        </div>
        
        <div class="text-center mt-5">
            <p class="text-muted">Already have an account? <a href="{{ route('show-login') }}" class="text-primary fw-bold text-decoration-none underline-hover">Login</a></p>
        </div>
    </form>
</div>

<style>
    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }


    .mb-4 {
        margin-bottom: 1.25rem !important;
    }

    .row.g-3 {
        --bs-gutter-x: 1rem;
        --bs-gutter-y: 1rem;
    }

    h4 {
        color: #334155 !important;
        font-weight: 700 !important;
        font-size: 1.15rem;
    }

    .form-label {
        color: #475569 !important;
        font-size: 0.9rem;
        margin-bottom: 0.4rem;
    }

    .btn-primary-custom, .btn-secondary-custom, .btn-success-custom {
        padding: 12px 25px;
        border-radius: 12px;
        font-size: 0.95rem;
    }

    .input-group-custom textarea.form-control {
        min-height: 120px;
        padding-top: 15px !important;
        padding-left: 54px !important;
    }

    .input-group-custom textarea.form-control + i {
        position: absolute;
        top: 20px;
        left: 20px;
        transform: none;
        color: #94a3b8;
        font-size: 1.25rem;
    }
</style>

<script>
    (function() {
        let currentStep = 0;
        const totalSteps = 5;
        const steps = document.querySelectorAll('.form-step');
        const indicators = document.querySelectorAll('.step-indicator');
        const progressBar = document.getElementById('progressBar');
        const nextBtn = document.querySelector('.next-btn');
        const prevBtn = document.querySelector('.prev-btn');
        const submitBtn = document.querySelector('.submit-btn');
        const form = document.getElementById('renter-registration-form');

        function updateUI() {
            steps.forEach((step, index) => {
                step.classList.toggle('active', index === currentStep);
            });

            prevBtn.style.display = currentStep === 0 ? 'none' : 'block';
            
            if (currentStep === totalSteps - 1) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'block';
            } else {
                nextBtn.style.display = 'block';
                submitBtn.style.display = 'none';
            }

            // Scroll to top of form when step changes
            document.querySelector('.form-side').scrollTop = 0;
        }

        function validateStep(stepIndex) {
            const currentStepEl = document.getElementById(`step${stepIndex}`);
            const inputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;

            // Password matching validation on step 0
            if (stepIndex === 0) {
                const password = document.getElementById('renter_password').value;
                const confirm = document.getElementById('renter_password_confirmation').value;
                if (password !== confirm) {
                    toastr.error("Passwords do not match");
                    return false;
                }
            }

            inputs.forEach(input => {
                if (!input.value) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                toastr.warning("Please fill in all required fields.");
            }
            return isValid;
        }

        nextBtn.addEventListener('click', () => {
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps - 1) {
                    currentStep++;
                    updateUI();
                }
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                updateUI();
            }
        });

        // City handling
        const stateSelect = document.querySelector('.state-select');
        const citySelect = document.querySelector('.city-select');

        stateSelect.addEventListener('change', async function() {
            const stateId = this.value;
            if (!stateId) {
                citySelect.innerHTML = '<option value="">Select City</option>';
                citySelect.disabled = true;
                return;
            }

            citySelect.disabled = true;
            citySelect.innerHTML = '<option value="">Loading...</option>';

            try {
                const response = await fetch(`/cities/${stateId}`);
                const cities = await response.json();
                
                citySelect.innerHTML = '<option value="">Select City</option>';
                cities.forEach(city => {
                    citySelect.innerHTML += `<option value="${city.Id}">${city.CityName}</option>`;
                });
                citySelect.disabled = false;
            } catch (error) {
                console.error("Error fetching cities:", error);
                toastr.error("Failed to load cities");
            }
        });

        // Form submission
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            if (!validateStep(currentStep)) return;

            const formData = new FormData(this);
            const submitBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...';

            try {
                const response = await fetch("{{ route('renter-register') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    toastr.success(data.success);
                    setTimeout(() => {
                        window.location.href = "/";
                    }, 1500);
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            toastr.error(data.errors[key][0]);
                        });
                    } else if (data.message) {
                        toastr.error(data.message);
                    } else {
                        toastr.error("Registration failed. Please check your inputs.");
                    }
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = submitBtnText;
                }
            } catch (error) {
                console.error("Submission error:", error);
                toastr.error("An error occurred. Please try again later.");
                submitBtn.disabled = false;
                submitBtn.innerHTML = submitBtnText;
            }
        });


        updateUI();
    })();
</script>