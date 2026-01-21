<div class="renter-registration-wrapper">
    <!-- Progress Steps -->
    <div class="renter-step-progress mb-4">
        <div class="renter-step-item active" data-step="0">
            <div class="step-circle"><i class="bi bi-shield-lock"></i></div>
            <div class="step-label d-none d-md-block">Account</div>
        </div>
        <div class="renter-step-line"></div>
        <div class="renter-step-item" data-step="1">
            <div class="step-circle"><i class="bi bi-person-badge"></i></div>
            <div class="step-label d-none d-md-block">Personal</div>
        </div>
        <div class="renter-step-line"></div>
        <div class="renter-step-item" data-step="2">
            <div class="step-circle"><i class="bi bi-cursor"></i></div>
            <div class="step-label d-none d-md-block">Preferences</div>
        </div>
        <div class="renter-step-line"></div>
        <div class="renter-step-item" data-step="3">
            <div class="step-circle"><i class="bi bi-list-stars"></i></div>
            <div class="step-label d-none d-md-block">Details</div>
        </div>
        <div class="renter-step-line"></div>
        <div class="renter-step-item" data-step="4">
            <div class="step-circle"><i class="bi bi-wallet2"></i></div>
            <div class="step-label d-none d-md-block">Budget</div>
        </div>
    </div>

    <form class="needs-validation renter-form" id="renter-registration-form" novalidate>
        @csrf
        
        <!-- Step 1: Account Info -->
        <div class="renter-form-step active" id="renter_step0">
            <h5 class="step-title mb-4"><i class="bi bi-shield-lock me-2"></i> Account Security</h5>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Username <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-person"></i>
                        <input type="text" class="form-control" name="username" placeholder="Choose a username" required>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope"></i>
                        <input type="email" class="form-control" name="email" placeholder="email@example.com" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock"></i>
                        <input type="password" class="form-control" id="renter_password" name="password" placeholder="••••••••" required>
                        <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('renter_password', event)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="form-text mt-1" style="font-size: 0.8rem; color: #64748b;">Min. 8 characters</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-shield-check"></i>
                        <input type="password" class="form-control" id="renter_password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                        <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('renter_password_confirmation', event)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Personal Info -->
        <div class="renter-form-step" id="renter_step1">
            <h5 class="step-title mb-4"><i class="bi bi-person-badge me-2"></i> Personal Details</h5>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-tag"></i>
                        <input type="text" class="form-control" name="firstname" placeholder="First Name" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-tag"></i>
                        <input type="text" class="form-control" name="lastname" placeholder="Last Name" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cell Phone <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-phone"></i>
                        <input type="tel" class="form-control" name="cell" placeholder="(555) 000-0000" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Other Phone</label>
                    <div class="input-group-custom">
                        <i class="bi bi-telephone"></i>
                        <input type="tel" class="form-control" name="otherphone" placeholder="Optional">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">State <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-geo"></i>
                        <select class="form-select state-dropdown" name="renterstate" data-city-target="#renter_city" required>
                            <option value="">Select State</option>
                            @foreach ($state as $row)
                                <option value="{{ $row->Id }}">{{ $row->StateName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">City <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-geo-alt"></i>
                        <select class="form-select city-select" id="renter_city" name="rentercity" required disabled>
                            <option value="">Select City</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Current Address <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-house-door" style="top: 20px; transform: none;"></i>
                        <textarea class="form-control" name="currentAddress" rows="2" placeholder="Your full current address" required style="padding-top: 14px !important;"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-mailbox"></i>
                        <input type="text" class="form-control" name="zip" placeholder="Zip Code" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Preferences -->
        <div class="renter-form-step" id="renter_step2">
            <h5 class="step-title mb-4"><i class="bi bi-cursor me-2"></i> Moving Preferences</h5>
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Target Areas/Neighborhoods <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-search"></i>
                        <input type="text" class="form-control" name="aboutmovein" placeholder="e.g. Downtown, Uptown" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Earliest Move Date <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-calendar-event"></i>
                        <input type="date" class="form-control" name="earliestdate" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Latest Move Date <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-calendar-check"></i>
                        <input type="date" class="form-control" name="latestdate" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pet Information <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-paw"></i>
                        <input type="text" class="form-control" name="petinfo" placeholder="Dogs, Cats, None" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">How did you hear about us? <span class="text-danger">*</span></label>
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
        <div class="renter-form-step" id="renter_step3">
            <h5 class="step-title mb-4"><i class="bi bi-list-stars me-2"></i> Apartment Details</h5>
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label d-block mb-3">Bedrooms Needed <span class="text-danger">*</span></label>
                    <div class="bedroom-selector">
                        @foreach (['1', '2', '3', '4', '5+'] as $bed)
                            <input type="checkbox" class="btn-check" name="bedrooms[]" value="{{ $bed }}" id="bed{{ $bed }}">
                            <label class="btn btn-outline-primary-custom" for="bed{{ $bed }}">{{ $bed }} Bed</label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Additional Information <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-chat-left-text" style="top: 20px; transform: none;"></i>
                        <textarea class="form-control" name="additional_info" rows="4" placeholder="Any other specific requirements?" required style="padding-top: 14px !important;"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 5: Budget -->
        <div class="renter-form-step" id="renter_step4">
            <h5 class="step-title mb-4"><i class="bi bi-wallet2 me-2"></i> Budget Range</h5>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Minimum Monthly Rent ($) <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-cash-stack"></i>
                        <input type="number" class="form-control" name="price_from" placeholder="0" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Maximum Monthly Rent ($) <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-cash-stack"></i>
                        <input type="number" class="form-control" name="price_to" placeholder="99999" required>
                    </div>
                </div>
            </div>

            <div class="alert alert-info border-0 rounded-3 mt-4" style="background: rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.1); color: var(--colorPrimary);">
                <i class="bi bi-info-circle-fill me-2"></i> Almost done! Review your details before creating your account.
            </div>
        </div>

        <!-- Form Navigation -->
        <div class="form-navigation mt-4 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-secondary-custom renter-prev-btn" style="display: none;">
                <i class="bi bi-arrow-left me-1"></i> Back
            </button>
            <button type="button" class="btn btn-primary-custom renter-next-btn ms-auto">
                Next <i class="bi bi-arrow-right ms-1"></i>
            </button>
            <button type="submit" class="btn btn-success-custom renter-submit-btn ms-auto" style="display: none;">
                <i class="bi bi-check2-circle me-2"></i> Register Now
            </button>
        </div>
        
        <div class="text-center mt-4">
            <p class="text-muted mb-0">Already have an account? <a href="{{ route('show-login') }}" class="text-primary fw-bold text-decoration-none underline-hover">Login</a></p>
        </div>
    </form>
</div>

<style>
    /* Step Progress */
    .renter-step-progress {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        padding: 0 10px;
    }

    .renter-step-item {
        text-align: center;
        flex-shrink: 0;
        position: relative;
    }

    .step-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        transition: all 0.3s;
        margin: 0 auto 0.5rem;
    }

    .renter-step-item.active .step-circle {
        background: var(--colorPrimary);
        color: white;
        box-shadow: 0 0 0 4px rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.2);
    }

    .renter-step-item.completed .step-circle {
        background: #10b981;
        color: white;
    }

    .step-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        margin-top: 0.5rem;
    }

    .renter-step-item.active .step-label {
        color: var(--colorPrimary);
    }

    .renter-step-line {
        flex: 1;
        height: 2px;
        background: #e2e8f0;
        margin: 0 8px;
        margin-bottom: 2.5rem;
    }

    /* Multi-step Form */
    .renter-form-step {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    .renter-form-step.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .step-title {
        color: #1e293b;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    /* Form Labels */
    .form-label {
        color: #475569;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    /* Buttons - Standardized Premium */
    .btn-primary-custom, .btn-secondary-custom, .btn-success-custom {
        padding: 10px 24px;
        border-radius: 12px;
        font-size: 0.92rem;
        font-weight: 700;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-primary-custom {
        background: var(--colorPrimary);
        border: 2px solid var(--colorPrimary);
        color: white;
        box-shadow: 0 4px 15px rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.2);
    }

    .btn-primary-custom:hover {
        background: transparent !important;
        color: var(--colorPrimary) !important;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 10px 25px rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.2);
    }

    .btn-secondary-custom {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .btn-secondary-custom:hover {
        background: #e2e8f0;
        color: #1e293b;
        transform: translateY(-2px);
    }

    .btn-success-custom {
        background: #10b981;
        border: 2px solid #10b981;
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
    }

    .btn-success-custom:hover {
        background: transparent !important;
        color: #10b981 !important;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.2);
    }

    /* Bedroom Selector */
    .bedroom-selector {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .bedroom-selector .btn-outline-primary-custom {
        border: 2px solid #e2e8f0;
        color: #64748b;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .bedroom-selector .btn-check:checked + .btn-outline-primary-custom {
        background: var(--colorPrimary);
        color: white;
        border-color: var(--colorPrimary);
    }

    /* Textarea */
    .input-group-custom textarea.form-control {
        min-height: 100px;
        padding-left: 50px !important;
        resize: vertical;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .step-progress {
            padding: 0 5px;
        }

        .step-circle {
            width: 38px;
            height: 38px;
            font-size: 1rem;
        }

        .step-line {
            margin: 0 4px;
            margin-bottom: 2rem;
        }

        .bedroom-selector {
            gap: 6px;
        }

        .bedroom-selector .btn-outline-primary-custom {
            padding: 8px 16px;
            font-size: 0.85rem;
        }

        .btn-primary-custom, .btn-secondary-custom, .btn-success-custom {
            padding: 10px 20px;
            font-size: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        .step-label {
            display: none !important;
        }

        .step-circle {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }

        .step-line {
            margin-bottom: 0.5rem;
        }

        .step-title {
            font-size: 1rem;
        }

        .bedroom-selector .btn-outline-primary-custom {
            flex: 1 0 calc(33.333% - 6px);
            min-width: 0;
            padding: 8px 12px;
            font-size: 0.8rem;
        }
    }

    .underline-hover:hover {
        text-decoration: underline !important;
    }
</style>

<script>
    (function() {
        const formContainer = document.querySelector('.renter-registration-wrapper');
        if (!formContainer) return;

        let currentStep = 0;
        const steps = formContainer.querySelectorAll('.renter-form-step');
        const totalSteps = steps.length;
        const stepItems = formContainer.querySelectorAll('.renter-step-item');
        const nextBtn = formContainer.querySelector('.renter-next-btn');
        const prevBtn = formContainer.querySelector('.renter-prev-btn');
        const submitBtn = formContainer.querySelector('.renter-submit-btn');
        const form = formContainer.querySelector('#renter-registration-form');

        function updateUI() {
            // Update form steps
            steps.forEach((step, index) => {
                step.classList.toggle('active', index === currentStep);
            });

            // Update progress indicators
            stepItems.forEach((item, index) => {
                if (index < currentStep) {
                    item.classList.add('completed');
                    item.classList.remove('active');
                } else if (index === currentStep) {
                    item.classList.add('active');
                    item.classList.remove('completed');
                } else {
                    item.classList.remove('active', 'completed');
                }
            });

            // Update navigation buttons
            prevBtn.style.setProperty('display', currentStep === 0 ? 'none' : 'inline-flex', 'important');
            
            if (currentStep === totalSteps - 1) {
                nextBtn.style.setProperty('display', 'none', 'important');
                submitBtn.style.setProperty('display', 'inline-flex', 'important');
            } else {
                nextBtn.style.setProperty('display', 'inline-flex', 'important');
                submitBtn.style.setProperty('display', 'none', 'important');
            }

            // Scroll to top
            formContainer.querySelector('.form-side')?.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function validateStep(stepIndex) {
            const currentStepEl = formContainer.querySelector(`.renter-form-step#renter_step${stepIndex}`);
            if (!currentStepEl) return true;
            
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
                if (password.length < 8) {
                    toastr.error("Password must be at least 8 characters");
                    return false;
                }
            }

            // Validate bedroom selection on step 3
            if (stepIndex === 3) {
                const bedroomChecked = formContainer.querySelectorAll('input[name="bedrooms[]"]:checked');
                if (bedroomChecked.length === 0) {
                    toastr.warning("Please select at least one bedroom option");
                    return false;
                }
            }

            inputs.forEach(input => {
                if (!input.checkValidity() || (input.type === 'checkbox' && !input.checked)) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                }
            });

            if (!isValid) {
                toastr.warning("Please fill in all required fields correctly.");
            }
            return isValid;
        }

        nextBtn?.addEventListener('click', () => {
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps - 1) {
                    currentStep++;
                    updateUI();
                }
            }
        });

        prevBtn?.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                updateUI();
            }
        });

        // Form submission
        form?.addEventListener('submit', async function(e) {
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