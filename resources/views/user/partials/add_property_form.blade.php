<div class="property-form-wrapper">
    <!-- Progress Steps -->
    <div class="step-progress mb-4">
        <div class="step-item active" data-step="0">
            <div class="step-circle"><i class="bi bi-geo-alt"></i></div>
            <div class="step-label d-none d-md-block">Location</div>
        </div>
        <div class="step-line"></div>
        <div class="step-item" data-step="1">
            <div class="step-circle"><i class="bi bi-file-earmark-check"></i></div>
            <div class="step-label d-none d-md-block">Terms</div>
        </div>
        <div class="step-line"></div>
        <div class="step-item" data-step="2">
            <div class="step-circle"><i class="bi bi-building"></i></div>
            <div class="step-label d-none d-md-block">Property Details</div>
        </div>
        <div class="step-line"></div>
        <div class="step-item" data-step="3">
            <div class="step-circle"><i class="bi bi-credit-card"></i></div>
            <div class="step-label d-none d-md-block">Billing</div>
        </div>
    </div>

    <form class="needs-validation property-form" id="propertySubmitForm" method="post" action="{{ route('add-new-property')}}" novalidate>
        @csrf
        
        <!-- Step 1: Location -->
        <div class="form-step active" id="step0">
            <h5 class="step-title mb-4"><i class="bi bi-geo-alt me-2"></i> Property Location</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">State <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-geo"></i>
                        <select class="form-select state-select" name="add_property_state" id="add-property-state" required>
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
                        <i class="bi bi-map"></i>
                        <select class="form-select city-select" id="add-property-city" name="add_property_city" required disabled>
                            <option value="">Select City</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="alert alert-info mt-3 border-0 rounded-4" style="background: rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.1); color: var(--colorPrimary);">
                <i class="bi bi-info-circle me-2"></i> Starting with location helps us categorize your property accurately.
            </div>
        </div>

        <!-- Step 2: Terms -->
        <div class="form-step" id="step1">
            <h5 class="step-title mb-4"><i class="bi bi-file-earmark-check me-2"></i> Terms & Authorization</h5>
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 bg-light rounded-4">
                    <p class="mb-4 text-center">To list your property on RentApartments.info, please review and accept our professional service agreement.</p>
                    <div class="d-flex justify-content-center mb-3">
                        <div class="form-check custom-checkbox">
                            <input class="form-check-input" type="checkbox" value="1" id="termsCheckbox" name="termsandcondition" required>
                            <label class="form-check-label fw-600" for="termsCheckbox">
                                I have read and agree to the <a href="#" class="text-primary text-decoration-none fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">Terms and Conditions</a>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Property Details -->
        <div class="form-step" id="step2">
            <h5 class="step-title mb-4"><i class="bi bi-building me-2"></i> Listing Information</h5>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Property Name <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-house"></i>
                        <input type="text" class="form-control" name="propertyname" id="prop_name" placeholder="Grand Apartments" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Management Company <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-briefcase"></i>
                        <input type="text" class="form-control" name="managementcompany" placeholder="Company Name" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Primary Contact Person <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-person"></i>
                        <input type="text" class="form-control" name="pcontact" placeholder="Contact Name" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Total Units <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-collection"></i>
                        <input type="number" class="form-control" name="units" placeholder="0" min="1" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Year Built <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-calendar-plus"></i>
                        <input type="date" class="form-control" name="yearbuilt" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Year Remodeled</label>
                    <div class="input-group-custom">
                        <i class="bi bi-stars"></i>
                        <input type="date" class="form-control" name="year_remodeled">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Leasing Email <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope"></i>
                        <input type="email" class="form-control" name="addpropertyemail" placeholder="leasing@property.com" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Area / Neighborhood <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-compass"></i>
                        <input type="text" class="form-control" name="area" placeholder="Downtown" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Property Address <span class="text-danger">*</span></label>
                <div class="input-group-custom">
                    <i class="bi bi-geo-alt" style="top: 20px; transform: none;"></i>
                    <textarea class="form-control" name="address" id="prop_address" rows="2" placeholder="Street Address" required style="padding-top: 14px !important;"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-mailbox"></i>
                        <input type="text" class="form-control" name="zipcode" id="prop_zip" placeholder="Zip Code" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contact Phone <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-phone"></i>
                        <input type="tel" class="form-control" name="contactno" placeholder="(555) 000-0000" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Website URL</label>
                <div class="input-group-custom">
                    <i class="bi bi-globe"></i>
                    <input type="url" class="form-control" name="website" placeholder="https://www.property.com">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Office Hours</label>
                <div class="input-group-custom">
                    <i class="bi bi-clock" style="top: 20px; transform: none;"></i>
                    <textarea class="form-control" name="officehours" rows="2" placeholder="e.g. Mon-Fri: 9AM-6PM" style="padding-top: 14px !important;"></textarea>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Embedded Map (iframe code) <span class="text-danger">*</span></label>
                <div class="input-group-custom">
                    <i class="bi bi-code-slash" style="top: 20px; transform: none;"></i>
                    <textarea class="form-control" name="embddedmap" rows="2" placeholder="Paste Google Maps iframe here..." required style="padding-top: 14px !important;"></textarea>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Listing Status</label>
                    <div class="input-group-custom">
                        <i class="bi bi-toggle-on"></i>
                        <select class="form-select" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Search Visibility</label>
                    <div class="input-group-custom">
                        <i class="bi bi-search"></i>
                        <select class="form-select" name="activeonsearch">
                            <option value="1">Show in Search</option>
                            <option value="0">Hide from Search</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Billing Address -->
        <div class="form-step" id="step3">
            <h5 class="step-title mb-4"><i class="bi bi-credit-card me-2"></i> Billing Information</h5>
            
            <div class="d-flex align-items-center bg-light p-3 rounded-4 mb-4 border" style="border-style: dashed !important; border-color: #cbd5e1 !important;">
                <div class="form-check custom-checkbox mb-0">
                    <input class="form-check-input" type="checkbox" id="sameaspropertyaddress">
                    <label class="form-check-label fw-600 mb-0" for="sameaspropertyaddress" style="cursor: pointer;">
                        Billing address is same as property address
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Bill To (Entity Name) <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-person-badge"></i>
                        <input type="text" class="form-control" name="billto" id="bill_to" placeholder="Entity Name" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Billing Zip Code <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-mailbox"></i>
                        <input type="text" class="form-control" name="copyzipcode" id="bill_zip" placeholder="Zip Code" required>
                    </div>
                </div>
            </div>

            <div id="billing_location_fields">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Billing State <span class="text-danger">*</span></label>
                        <div class="input-group-custom">
                            <i class="bi bi-geo"></i>
                            <select class="form-select state-select" name="bill_address_state" id="bill_address_state" required>
                                <option value="">Select State</option>
                                @foreach ($state as $row)
                                    <option value="{{ $row->Id }}">{{ $row->StateName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Billing City <span class="text-danger">*</span></label>
                        <div class="input-group-custom">
                            <i class="bi bi-map"></i>
                            <select class="form-select city-select" id="bill_address_city" name="bill_address_city" required disabled>
                                <option value="">Select City</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Billing Address <span class="text-danger">*</span></label>
                <div class="input-group-custom">
                    <i class="bi bi-file-text" style="top: 20px; transform: none;"></i>
                    <textarea class="form-control" name="billaddress" id="bill_address" rows="2" placeholder="Full Billing Address" required style="padding-top: 14px !important;"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Billing Phone <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-telephone"></i>
                        <input type="tel" class="form-control" name="billphone" id="bill_phone" placeholder="Phone Number" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Billing Contact Personnel <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-person"></i>
                        <input type="text" class="form-control" name="billcontact" id="bill_contact" placeholder="Contact Person" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Billing Fax <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-printer"></i>
                        <input type="text" class="form-control" name="billfax" id="bill_fax" placeholder="Fax Number" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Billing Email <span class="text-danger">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope-at"></i>
                        <input type="email" class="form-control" name="billemail" id="bill_email" placeholder="billing@example.com" required>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-success mt-4 border-0 rounded-4" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                <i class="bi bi-shield-check me-2"></i> review all details before submitting. You can edit them later.
            </div>
        </div>

        <!-- Form Navigation -->
        <div class="form-navigation mt-4 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-secondary-custom prev-btn" style="display: none;">
                <i class="bi bi-arrow-left me-1"></i> Back
            </button>
            <button type="button" class="btn btn-primary-custom next-btn ms-auto">
                Next <i class="bi bi-arrow-right ms-1"></i>
            </button>
            <button type="submit" class="btn btn-success-custom submit-btn ms-auto" style="display: none;">
                <i class="bi bi-check2-circle me-2"></i> Register Property
            </button>
        </div>
    </form>
</div>

<style>
    .property-form-wrapper {
        background: #fff;
        padding: 2rem;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }
    
    /* Progress Bar */
    .step-progress {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 4rem;
        padding: 0 20px;
    }

    .step-item {
        text-align: center;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    .step-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        margin: 0 auto 0.5rem;
        border: 2px solid #e2e8f0;
    }

    .step-item.active .step-circle {
        background: var(--colorPrimary);
        color: white;
        border-color: var(--colorPrimary);
        box-shadow: 0 0 0 5px rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.15);
        transform: scale(1.1);
    }

    .step-item.completed .step-circle {
        background: #10b981;
        color: white;
        border-color: #10b981;
    }

    .step-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #64748b;
        position: absolute;
        width: 120px;
        left: 50%;
        transform: translateX(-50%);
        margin-top: 5px;
    }

    .step-item.active .step-label {
        color: var(--colorPrimary);
    }

    .step-line {
        flex: 1;
        height: 3px;
        background: #e2e8f0;
        margin: 0 10px;
        margin-bottom: 2.2rem;
        border-radius: 10px;
        position: relative;
    }

    /* Multi-step Logic */
    .form-step {
        display: none;
        animation: slideIn 0.4s ease-out;
    }

    .form-step.active {
        display: block;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .step-title {
        color: #0f172a;
        font-weight: 800;
        font-size: 1.4rem;
        letter-spacing: -0.02em;
    }

    /* Input Styling */
    .input-group-custom {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-group-custom i {
        position: absolute;
        left: 18px;
        color: #94a3b8;
        font-size: 1.1rem;
        z-index: 5;
    }

    .input-group-custom .form-control, 
    .input-group-custom .form-select {
        padding: 14px 18px 14px 50px !important;
        border-radius: 14px !important;
        border: 1.5px solid #e2e8f0 !important;
        font-weight: 500;
        color: #1e293b;
        transition: all 0.2s;
        background: #fcfdfe;
    }

    .input-group-custom .form-control:focus, 
    .input-group-custom .form-select:focus {
        border-color: var(--colorPrimary) !important;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.1) !important;
    }

    .input-group-custom select.form-select {
        cursor: pointer;
    }

    /* Buttons */
    .btn-primary-custom, .btn-secondary-custom, .btn-success-custom {
        padding: 14px 32px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        border: none;
    }

    .btn-primary-custom {
        background: var(--colorPrimary);
        color: white;
    }

    .btn-primary-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.3);
        filter: brightness(1.1);
    }

    .btn-secondary-custom {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-secondary-custom:hover {
        background: #e2e8f0;
    }

    .btn-success-custom {
        background: #10b981;
        color: white;
    }

    .btn-success-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }

    .custom-checkbox .form-check-input {
        width: 1.3rem;
        height: 1.3rem;
        border-radius: 6px;
        border: 2px solid #cbd5e1;
        margin-right: 10px;
        cursor: pointer;
    }

    .custom-checkbox .form-check-input:checked {
        background-color: var(--colorPrimary);
        border-color: var(--colorPrimary);
    }

    .custom-checkbox .form-check-label {
        padding-top: 2px;
        cursor: pointer;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .property-form-wrapper { padding: 1.5rem; }
        .step-progress { margin-bottom: 3rem; }
        .step-circle { width: 42px; height: 42px; font-size: 1rem; }
        .step-line { margin-bottom: 2rem; }
        .step-label { display: none; }
    }
</style>

<script>
    (function() {
        let currentStep = 0;
        const totalSteps = 4;
        const steps = document.querySelectorAll('.form-step');
        const stepItems = document.querySelectorAll('.step-item');
        const nextBtn = document.querySelector('.next-btn');
        const prevBtn = document.querySelector('.prev-btn');
        const submitBtn = document.querySelector('.submit-btn');
        const form = document.getElementById('propertySubmitForm');
        
        const stateSelects = document.querySelectorAll('.state-select');
        const citySelects = document.querySelectorAll('.city-select');

        function updateUI() {
            steps.forEach((step, index) => {
                step.classList.toggle('active', index === currentStep);
            });

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

            prevBtn.style.display = currentStep === 0 ? 'none' : 'inline-flex';
            
            if (currentStep === totalSteps - 1) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'inline-flex';
            } else {
                nextBtn.style.display = 'inline-flex';
                submitBtn.style.display = 'none';
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function validateStep(stepIndex) {
            const currentStepEl = document.getElementById(`step${stepIndex}`);
            const inputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value || (input.type === 'email' && !input.validity.valid) || (input.type === 'checkbox' && !input.checked)) {
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

        // Billing Logic
        const sameAsCheck = document.getElementById('sameaspropertyaddress');
        sameAsCheck?.addEventListener('change', function() {
            if (this.checked) {
                const propName = document.getElementById('prop_name').value;
                const propAddress = document.getElementById('prop_address').value;
                const propZip = document.getElementById('prop_zip').value;
                const propState = document.getElementById('add-property-state').value;
                const propCity = document.getElementById('add-property-city').value;

                document.getElementById('bill_to').value = propName;
                document.getElementById('bill_address').value = propAddress;
                document.getElementById('bill_zip').value = propZip;
                
                if (propState) {
                    const billStateSel = document.getElementById('bill_address_state');
                    billStateSel.value = propState;
                    billStateSel.dispatchEvent(new Event('change'));

                    // We wait for cities to load then set it
                    const checkInterval = setInterval(() => {
                        const citySel = document.getElementById('bill_address_city');
                        if (!citySel.disabled && citySel.options.length > 1) {
                            citySel.value = propCity;
                            clearInterval(checkInterval);
                        }
                    }, 100);
                }
            }
        });

        // City Loader
        stateSelects.forEach((stateSel, index) => {
            stateSel.addEventListener('change', async function() {
                const citySel = citySelects[index];
                const stateId = this.value;
                
                if (!stateId) {
                    citySel.innerHTML = '<option value="">Select City</option>';
                    citySel.disabled = true;
                    return;
                }

                citySel.disabled = true;
                citySel.innerHTML = '<option value="">Loading...</option>';

                try {
                    const response = await fetch(`/cities/${stateId}`);
                    const cities = await response.json();
                    
                    citySel.innerHTML = '<option value="">Select City</option>';
                    cities.forEach(city => {
                        citySel.innerHTML += `<option value="${city.Id}">${city.CityName}</option>`;
                    });
                    citySel.disabled = false;
                } catch (error) {
                    console.error("Error fetching cities:", error);
                    toastr.error("Failed to load cities");
                }
            });
        });

        updateUI();
    })();
</script>