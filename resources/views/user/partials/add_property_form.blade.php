<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    :root {
        --primary-color: #3b71ca;
        --secondary-color: #f8f9fa;
        --accent-color: #14a44d;
        --warning-color: #e4a11b;
        --danger-color: #dc4c64;
        --text-color: #333;
        --border-radius: 8px;
        --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    body {
        background-color: #f5f7f9;
        color: var(--text-color);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-container {
        max-width: 900px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 2rem;
    }

    .form-header {
        color: var(--primary-color);
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .step {
        text-align: center;
        position: relative;
        z-index: 2;
        flex: 1;
    }

    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        font-weight: bold;
        border: 2px solid #e9ecef;
    }

    .step.active .step-number {
        background-color: white;
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .step.completed .step-number {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        color: white;
    }

    .step-label {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .step.active .step-label {
        color: var(--primary-color);
        font-weight: 500;
    }

    .form-section {
        display: none;
        animation: fadeIn 0.5s ease;
    }

    .form-section.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
    }

    .form-card-header {
        /* background-color: var(--secondary-color); */
        /* border-bottom: 1px solid #e9ecef; */
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #495057;
    }

    .required::after {
        content: '*';
        color: var(--danger-color);
        margin-left: 0.25rem;
    }

    .form-control,
    .form-select {
        border-radius: var(--border-radius);
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        transition: all 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(59, 113, 202, 0.25);
    }

    .nav-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e9ecef;
    }

    .btn-nav {
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-prev {
        background-color: var(--btnColor);
        color: white;
    }

    .btn-next,
    .btn-submit {
        background-color: var(--btnColor);
        color: white;
    }

    .btn-submit {
        background-color: var(--accent-color);
    }

    .btn-nav:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .checkbox-input {
        display: flex;
        align-items: center;
    }

    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-right: 0.5rem;
    }

    .form-check-input:checked {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
    }

    .terms-link {
        color: var(--primary-color);
        text-decoration: none;
    }

    .terms-link:hover {
        text-decoration: underline;
    }

    .progress {
        height: 8px;
        margin-bottom: 2rem;
        border-radius: 4px;
    }

    .same-as-check {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .form-container {
            margin: 1rem;
            padding: 1.5rem;
        }

        .step-label {
            font-size: 0.75rem;
        }

        .btn-nav {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<div class="form-container">
    <h2 class="mb-4 form-header">Add Property </h2>

    <!-- Progress Bar -->
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <form class="needs-validation" id="propertySubmitForm" method="post" name="form-wrapper" action="{{ route('add-new-property')}}" novalidate>
        @csrf
        <div class="form-section active" id="step-1">
            <div class="form-card">
                <div class="form-card-header">
                    <h4 class="font-weight-bold mb-0">Select State & City</h4>
                </div>
                <div class="card-body p-3">
                    <p class="text-muted">Select location details for your property listing.</p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="add-property-state" class="form-label required">State</label>
                            <select class="form-select state-select-box" name="add_property_state" id="add-property-state" required>
                                <option value="">Select State</option>
                                @foreach ($state as $row)
                                <option value="{{ $row->Id }}">{{ $row->StateName }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Please select a state.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="add-property-city" class="form-label required">City</label>
                            <select class="form-select" id="add-property-city" name="add_property_city" required>
                                <option value="">Select City</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a city.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Terms -->
        <div class="form-section" id="step-2">
            <div class="form-card">
                <div class="form-card-header">
                    <h4 class="font-weight-bold mb-0">Terms and Conditions</h4>
                </div>
                <div class="card-body p-3">
                    <p class="text-muted text-center">After reading our terms and conditions, accept them by checking the box below.</p>

                    <div class="form-check mb-3 d-flex align-items-center justify-content-center">
                        <input class="form-check-input" type="checkbox" value="1" id="termsCheckbox" name="termsandcondition" required>
                        <label class="form-check-label" for="termsCheckbox">
                            I agree to these <a href="#" class="terms-link" data-bs-toggle="modal" data-bs-target="#exampleModal">Terms and Conditions</a>.
                        </label>
                        <div class="invalid-feedback">
                            You must accept the terms and conditions.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Property Details -->
        <div class="form-section" id="step-3">
            <div class="form-card">
                <div class="form-card-header">
                    <h4 class="font-weight-bold mb-0">Property Details</h4>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="propertyname" class="form-label required">Property Name</label>
                            <input class="form-control" id="propertyname" name="propertyname" type="text" required>
                            <div class="invalid-feedback">
                                Please enter property name.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="managementcompany" class="form-label required">Management Company</label>
                            <input class="form-control" id="managementcompany" name="managementcompany" type="text" required>
                            <div class="invalid-feedback">
                                Please enter company name.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pcontact" class="form-label required">Property Contact</label>
                            <input class="form-control" id="pcontact" name="pcontact" type="text" required>
                            <div class="invalid-feedback">
                                Please enter property contact.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="units" class="form-label required">No of Units</label>
                            <input class="form-control" id="units" name="units" type="number" min="1" required>
                            <div class="invalid-feedback">
                                Please enter number of units.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="yearbuilt" class="form-label required">Year Built</label>
                            <input type="date" name="yearbuilt" id="yearbuilt" class="form-control" required>
                            <div class="invalid-feedback">
                                Please select year built.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="year_remodeled" class="form-label">Year Remodeled</label>
                            <input type="date" name="year_remodeled" id="year_remodeled" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="addpropertyemail" class="form-label required">Leasing Email</label>
                            <input class="form-control" id="addpropertyemail" name="addpropertyemail" type="email" required>
                            <div class="invalid-feedback">
                                Please enter a valid email.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="area" class="form-label required">Area</label>
                            <input class="form-control" id="area" name="area" type="text" required>
                            <div class="invalid-feedback">
                                Please enter area.
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="address" class="form-label required">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            <div class="invalid-feedback">
                                Please enter address.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="filledstate" class="form-label">State</label>
                            <input class="form-control" id="filledstate" name="filledstate" type="text" disabled>
                            <input type="hidden" id="fillstateid" name="fillstateid">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="filledcity" class="form-label">City</label>
                            <input class="form-control" id="filledcity" name="filledcity" type="text" disabled>
                            <input type="hidden" id="filledcityid" name="filledcityid">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="zipcode" class="form-label required">Zip Code</label>
                            <input class="form-control" id="zipcode" name="zipcode" type="text" required>
                            <div class="invalid-feedback">
                                Please enter zip code.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="contactno" class="form-label required">Contact No</label>
                            <input class="form-control" id="contactno" name="contactno" type="tel" required>
                            <div class="invalid-feedback">
                                Please enter contact number.
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input class="form-control" id="website" name="website" type="url">
                        </div>

                        <div class="col-12 mb-3">
                            <label for="officehours" class="form-label">Office Hours</label>
                            <textarea class="form-control" id="officehours" name="officehours" rows="2"></textarea>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="embddedmap" class="form-label">Embedded Map</label>
                            <textarea class="form-control" id="embddedmap" name="embddedmap" rows="2"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="activeonsearch" class="form-label">Active on Search</label>
                            <select class="form-select" id="activeonsearch" name="activeonsearch">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Billing Address -->
        <div class="form-section" id="step-4">
            <div class="form-card">
                <div class="form-card-header">
                    <h4 class="font-weight-bold mb-0">Billing Address Details</h4>
                </div>
                <div class="card-body p-3">
                    <div class="same-as-check">
                        <input class="form-check-input" type="checkbox" id="sameaspropertyaddress">
                        <label class="form-check-label" for="sameaspropertyaddress">
                            Same as Property Address
                        </label>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="billto" class="form-label required">Bill To</label>
                            <input class="form-control" id="billto" name="billto" type="text" required>
                            <div class="invalid-feedback">
                                Please enter bill to.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="copyzipcode" class="form-label required">Zip Code</label>
                            <input class="form-control" id="copyzipcode" name="copyzipcode" type="text" required>
                            <div class="invalid-feedback">
                                Please enter zip code.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3" id="billingStateContainer">
                            <label for="bill_address_state" class="form-label required">State</label>
                            <select class="form-select state-select-box" name="bill_address_state" id="bill_address_state" required>
                                <option value="">Select State</option>
                                @foreach ($state as $row)
                                <option value="{{ $row->Id }}">{{ $row->StateName }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Please select a state.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3" id="billingCityContainer">
                            <label for="bill_address_city" class="form-label required">City</label>
                            <select class="form-select" id="bill_address_city" name="bill_address_city" required>
                                <option value="">Select City</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a city.
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="billaddress" class="form-label required">Bill Address</label>
                            <textarea class="form-control" id="billaddress" name="billaddress" rows="3" required></textarea>
                            <div class="invalid-feedback">
                                Please enter bill address.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="billphone" class="form-label required">Bill Phone</label>
                            <input class="form-control" id="billphone" name="billphone" type="tel" required>
                            <div class="invalid-feedback">
                                Please enter bill phone.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="billcontact" class="form-label required">Bill Contact</label>
                            <input class="form-control" id="billcontact" name="billcontact" type="text" required>
                            <div class="invalid-feedback">
                                Please enter bill contact.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="billfax" class="form-label required">Bill Fax</label>
                            <input class="form-control" id="billfax" name="billfax" type="text" required>
                            <div class="invalid-feedback">
                                Please enter bill fax.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="billemail" class="form-label required">Bill Email</label>
                            <input class="form-control" id="billemail" name="billemail" type="email" required>
                            <div class="invalid-feedback">
                                Please enter a valid email.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="nav-buttons">
            <button type="button" class="btn btn-prev btn-nav" id="prevBtn" disabled>
                <i class="bi bi-chevron-left"></i> Previous
            </button>
            <button type="button" class="btn btn-next btn-nav" id="nextBtn">
                Next <i class="bi bi-chevron-right"></i>
            </button>
            <button type="submit" class="btn btn-submit btn-nav" id="submitBtn" style="display: none;">
                <i class="bi bi-check2-circle"></i> Submit
            </button>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form navigation
        const formSections = document.querySelectorAll('.form-section');
        const stepIndicators = document.querySelectorAll('.step');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');
        const progressBar = document.querySelector('.progress-bar');
        let currentStep = 1;
        const totalSteps = formSections.length;

        // Update progress
        function updateProgress() {
            const progress = (currentStep / totalSteps) * 100;
            progressBar.style.width = `${progress}%`;
            progressBar.setAttribute('aria-valuenow', progress);
        }

        // Update navigation buttons
        function updateButtons() {
            prevBtn.disabled = currentStep === 1;
            nextBtn.style.display = currentStep === totalSteps ? 'none' : 'block';
            submitBtn.style.display = currentStep === totalSteps ? 'block' : 'none';

            // Update step indicators
            stepIndicators.forEach((step, index) => {
                if (index + 1 < currentStep) {
                    step.classList.add('completed');
                    step.classList.remove('active');
                } else if (index + 1 === currentStep) {
                    step.classList.add('active');
                    step.classList.remove('completed');
                } else {
                    step.classList.remove('active', 'completed');
                }
            });
        }

        // Show current step
        function showStep(step) {
            formSections.forEach((section, index) => {
                section.classList.toggle('active', index + 1 === step);
            });
            updateButtons();
            updateProgress();
        }

        // Next button click
        nextBtn.addEventListener('click', function() {
            const currentSection = document.getElementById(`step-${currentStep}`);
            const inputs = currentSection.querySelectorAll('input, select, textarea');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    isValid = false;
                }
            });

            if (isValid) {
                if (currentStep === 1) {
                    // Auto-fill state and city fields in property details
                    const stateSelect = document.getElementById('add-property-state');
                    const citySelect = document.getElementById('add-property-city');
                    const filledState = document.getElementById('filledstate');
                    const filledCity = document.getElementById('filledcity');
                    const fillStateId = document.getElementById('fillstateid');
                    const filledCityId = document.getElementById('filledcityid');

                    if (stateSelect.value && citySelect.value) {
                        filledState.value = stateSelect.options[stateSelect.selectedIndex].text;
                        filledCity.value = citySelect.options[citySelect.selectedIndex].text;
                        fillStateId.value = stateSelect.value;
                        filledCityId.value = citySelect.value;
                    }
                }

                currentStep++;
                showStep(currentStep);
            }
        });

        // Previous button click
        prevBtn.addEventListener('click', function() {
            currentStep--;
            showStep(currentStep);
        });

        // Same as property address functionality
        const sameAsCheckbox = document.getElementById('sameaspropertyaddress');
        const billingStateContainer = document.getElementById('billingStateContainer');
        const billingCityContainer = document.getElementById('billingCityContainer');

        sameAsCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // Copy address & zip
                document.getElementById('billaddress').value = document.getElementById('address').value;
                document.getElementById('copyzipcode').value = document.getElementById('zipcode').value;

                // Get property state/city
                const propState = document.getElementById('add-property-state').value;
                const propCity = document.getElementById('add-property-city').value;

                if (propState) {
                    $("#bill_address_state").val(propState).trigger("change");

                    // Load billing cities then select city
                    $.ajax({
                        url: "/cities/" + propState,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $("#bill_address_city").empty().append('<option value="">Select City</option>');
                            $.each(data, function(key, value) {
                                $("#bill_address_city").append(
                                    '<option value="' + value.Id + '">' + value.CityName + "</option>"
                                );
                            });

                            if (propCity) {
                                $("#bill_address_city").val(propCity);
                            }
                        },
                    });
                }

                // Disable required check since we’re auto-filling
                document.getElementById('bill_address_state').required = false;
                document.getElementById('bill_address_city').required = false;
            } else {
                // Clear values and allow manual selection
                document.getElementById('billaddress').value = "";
                document.getElementById('copyzipcode').value = "";
                $("#bill_address_state").val("").trigger("change");
                $("#bill_address_city").empty().append('<option value="">Select City</option>');

                document.getElementById('bill_address_state').required = true;
                document.getElementById('bill_address_city').required = true;
            }
        });

        document.querySelectorAll('.state-select-box').forEach(select => {
            select.addEventListener('change', function() {
                const stateId = this.value;
                const citySelect = this.id === 'add-property-state' ? document.getElementById('add-property-city') : document.getElementById('bill_address_city');

                if (stateId) {
                    citySelect.innerHTML = '<option value="">Loading cities...</option>';
                } else {
                    citySelect.innerHTML = '<option value="">Select City</option>';
                }
            });
        });
        
        document.getElementById('propertySubmitForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let isFormValid = true;
            formSections.forEach(section => {
                const inputs = section.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    if (!input.checkValidity()) {
                        input.reportValidity();
                        isFormValid = false;
                    }
                });
            });

            if (isFormValid) {
                this.submit();
            } else {
                for (let i = 0; i < formSections.length; i++) {
                    const inputs = formSections[i].querySelectorAll('input, select, textarea');
                    for (let j = 0; j < inputs.length; j++) {
                        if (!inputs[j].checkValidity()) {
                            currentStep = i + 1;
                            showStep(currentStep);
                            inputs[j].focus();
                            return;
                        }
                    }
                }
            }
        });
        
        updateProgress();
    });
</script>