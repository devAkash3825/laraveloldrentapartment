<div class="property-form-container">
    <!-- Premium Progress Stepper -->
    <div class="prop-stepper mb-5">
        <div class="prop-step-badge active" data-step="0">
            <div class="step-icon"><i class="bi bi-geo-alt"></i></div>
            <span class="step-text">Location</span>
        </div>
        <div class="prop-step-connector"></div>
        <div class="prop-step-badge" data-step="1">
            <div class="step-icon"><i class="bi bi-shield-check"></i></div>
            <span class="step-text">Authorization</span>
        </div>
        <div class="prop-step-connector"></div>
        <div class="prop-step-badge" data-step="2">
            <div class="step-icon"><i class="bi bi-building"></i></div>
            <span class="step-text">Essentials</span>
        </div>
        <div class="prop-step-connector"></div>
        <div class="prop-step-badge" data-step="3">
            <div class="step-icon"><i class="bi bi-telephone"></i></div>
            <span class="step-text">Listing Info</span>
        </div>
        <div class="prop-step-connector"></div>
        <div class="prop-step-badge" data-step="4">
            <div class="step-icon"><i class="bi bi-credit-card"></i></div>
            <span class="step-text">Billing</span>
        </div>
    </div>

    <form class="needs-validation property-modern-form" id="propertySubmitForm" method="post" action="{{ route('add-new-property')}}" novalidate>
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger rounded-3 border-0 shadow-sm mb-4 py-2">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Step 1: Property Location -->
        <div class="prop-form-step active" id="step0">
            <div class="step-header mb-5">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill">Step 1 of 5</span>
                    <h4 class="fw-bold text-dark mb-0">Where is your property?</h4>
                </div>
                <p class="text-muted lead fs-6">Accurate location details ensure your property appears in the right search results.</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">State <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-geo-alt-fill"></i>
                        <select class="form-select state-dropdown" name="add_property_state" id="add-property-state" data-city-target="#add-property-city" required>
                            <option value="">Select State</option>
                            @foreach ($state as $row)
                                <option value="{{ $row->Id }}">{{ $row->StateName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">City <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-buildings-fill"></i>
                        <select class="form-select city-select" id="add-property-city" name="add_property_city" required disabled>
                            <option value="">Select City</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modern-info-box mt-5 p-4 rounded-4 border-0 shadow-sm bg-light">
                <div class="d-flex align-items-start gap-3">
                    <div class="icon-circle bg-white text-primary shadow-sm">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold text-dark">Quick Tip</h6>
                        <p class="mb-0 text-muted small lh-base">The city and state are used to calculate distances for renters. Double-check these to avoid missing out on potential leads.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Terms & Authorization -->
        <div class="prop-form-step" id="step1">
            <div class="step-header mb-5">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill">Step 2 of 5</span>
                    <h4 class="fw-bold text-dark mb-0">Authorization & Terms</h4>
                </div>
                <p class="text-muted lead fs-6">Please verify your legal authorization to list this property.</p>
            </div>

            <div class="terms-premium-card p-5 rounded-5 border-0 shadow-sm bg-white text-center">
                <div class="terms-icon-wrapper mb-4">
                    <div class="main-icon bg-primary text-white shadow-lg">
                        <i class="bi bi-shield-check"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-3 text-dark">Service Authorization</h4>
                <p class="text-muted mb-5 px-md-5 fs-6">By proceeding, you certify that you are the owner or an authorized representative. We will display your listing to our network of active renters.</p>
                
                <div class="terms-action-box p-4 rounded-4 bg-light border">
                    <div class="form-check custom-checkbox-modern d-inline-flex align-items-center gap-2">
                        <input class="form-check-input" type="checkbox" value="1" id="termsCheckbox" name="termsandcondition" required>
                        <label class="form-check-label fw-bold text-dark" for="termsCheckbox">
                            I accept the <a href="#" class="text-primary text-decoration-underline" data-bs-toggle="modal" data-bs-target="#exampleModal">Legal Terms & Conditions</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Core Property Details -->
        <div class="prop-form-step" id="step2">
            <div class="step-header mb-5">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill">Step 3 of 5</span>
                    <h4 class="fw-bold text-dark mb-0">Property Essentials</h4>
                </div>
                <p class="text-muted lead fs-6">Basic identification details for your apartment complex or building.</p>
            </div>
            
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Property Name <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-house-door-fill"></i>
                        <input type="text" class="form-control" name="propertyname" id="prop_name" placeholder="Grand Residents" required>
                    </div>
                    <div class="form-text small">Official name of the listing</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Management Company <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-building-fill-gear"></i>
                        <input type="text" class="form-control" name="managementcompany" placeholder="LLC or Group Name" required>
                    </div>
                    <div class="form-text small">Entity managing the property</div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Primary Contact Person <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-person-badge-fill"></i>
                        <input type="text" class="form-control" name="pcontact" placeholder="John Doe" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Total Apartment Units <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-ui-checks-grid"></i>
                        <input type="number" class="form-control" name="units" placeholder="e.g. 150" min="1" required>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Year Built <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-calendar-event-fill"></i>
                        <input type="date" class="form-control" name="yearbuilt" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Year Remodeled <span class="text-muted small fw-normal">(Optional)</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-stars"></i>
                        <input type="date" class="form-control" name="year_remodeled">
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Contact & Schedule -->
        <div class="prop-form-step" id="step3">
            <div class="step-header mb-5">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill">Step 4 of 5</span>
                    <h4 class="fw-bold text-dark mb-0">Connectivity & Schedule</h4>
                </div>
                <p class="text-muted lead fs-6">How renters will find and interact with your property.</p>
            </div>

            <div class="section-divider mb-4">
                <span class="fw-bold text-uppercase small text-muted letter-spacing-1">Direct Contact</span>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Leasing Email <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" class="form-control" name="addpropertyemail" placeholder="leasing@example.com" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Office Phone Number <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-telephone-fill"></i>
                        <input type="tel" class="form-control" name="contactno" placeholder="(123) 456-7890" required>
                    </div>
                </div>
            </div>

            <div class="section-divider mb-4">
                <span class="fw-bold text-uppercase small text-muted letter-spacing-1">Physical Presence</span>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark-emphasis mb-2">Physical Address <span class="text-danger">*</span></label>
                <div class="input-group-modern">
                    <i class="bi bi-geo-fill" style="top: 24px; transform: none;"></i>
                    <textarea class="form-control" name="address" id="prop_address" rows="3" placeholder="123 Luxury Way, Apt 101" required style="padding-top: 18px !important;"></textarea>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Property Zip Code <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-mailbox2"></i>
                        <input type="text" class="form-control" name="zipcode" id="prop_zip" placeholder="Zip Code" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Neighborhood / Suburb <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-compass-fill"></i>
                        <input type="text" class="form-control" name="area" placeholder="e.g. West End" required>
                    </div>
                </div>
            </div>

            <div class="section-divider mb-4 mt-5">
                <span class="fw-bold text-uppercase small text-muted letter-spacing-1">Operating Details</span>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark-emphasis mb-2">Office Operating Hours</label>
                <div class="input-group-modern">
                    <i class="bi bi-clock-fill" style="top: 24px; transform: none;"></i>
                    <textarea class="form-control" name="officehours" rows="2" placeholder="e.g. Mon-Fri 9AM-5PM" style="padding-top: 18px !important;"></textarea>
                </div>
            </div>

            <div class="mb-5">
                <label class="form-label fw-bold text-dark-emphasis mb-2">Google Maps Embed Code <span class="text-danger">*</span></label>
                <div class="input-group-modern">
                    <i class="bi bi-map-fill" style="top: 24px; transform: none;"></i>
                    <textarea class="form-control" name="embddedmap" rows="3" placeholder="Paste the <iframe...> tag here" required style="padding-top: 18px !important;"></textarea>
                </div>
                <div class="form-text small"><i class="bi bi-info-circle me-1"></i> We use this to correctly calculate the latitude and longitude for your pin.</div>
            </div>

            <div class="row g-4 pb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Live Status</label>
                    <div class="input-group-modern">
                        <i class="bi bi-eye-fill"></i>
                        <select class="form-select" name="activeonsearch">
                            <option value="1">Listed (Public)</option>
                            <option value="0">Draft (Hidden)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Property Website</label>
                    <div class="input-group-modern">
                        <i class="bi bi-globe"></i>
                        <input type="url" class="form-control" name="website" placeholder="https://www.yourproperty.com">
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 5: Billing Address -->
        <div class="prop-form-step" id="step4">
            <div class="step-header mb-5">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill">Step 5 of 5</span>
                    <h4 class="fw-bold text-dark mb-0">Financial & Billing</h4>
                </div>
                <p class="text-muted lead fs-6">Where should we direct invoices for this listing?</p>
            </div>
            
            <div class="premium-notice-card p-4 rounded-4 mb-5 border-0 shadow-sm bg-primary-soft d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="pulse-circle bg-primary text-white">
                        <i class="bi bi-arrow-down-up"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-primary">Same as Property Address?</h6>
                        <p class="mb-0 text-muted small">Auto-fill all billing fields for convenience.</p>
                    </div>
                </div>
                <div class="form-check form-switch custom-switch-premium">
                    <input class="form-check-input" type="checkbox" id="sameaspropertyaddress">
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Bill To (Legal Name) <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-journal-text"></i>
                        <input type="text" class="form-control" name="billto" id="bill_to" placeholder="Entity Legal Name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Billing Zip Code <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-mailbox"></i>
                        <input type="text" class="form-control" name="copyzipcode" id="bill_zip" placeholder="Zip Code" required>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Billing State <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-map"></i>
                        <select class="form-select state-dropdown" name="bill_address_state" id="bill_address_state" data-city-target="#bill_address_city" required>
                            <option value="">Select State</option>
                            @foreach ($state as $row)
                                <option value="{{ $row->Id }}">{{ $row->StateName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Billing City <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-buildings"></i>
                        <select class="form-select city-select" id="bill_address_city" name="bill_address_city" required disabled>
                            <option value="">Select City</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <label class="form-label fw-bold text-dark-emphasis mb-2">Billing Address <span class="text-danger">*</span></label>
                <div class="input-group-modern">
                    <i class="bi bi-card-text" style="top: 24px; transform: none;"></i>
                    <textarea class="form-control" name="billaddress" id="bill_address" rows="2" placeholder="Full Billing Address Line" required style="padding-top: 18px !important;"></textarea>
                </div>
            </div>

            <div class="modern-header-line mb-4"> 
                <span class="bg-white px-3 fw-bold text-muted small">BILLING PERSONNEL</span>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Billing Contact Person <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-person-circle"></i>
                        <input type="text" class="form-control" name="billcontact" id="bill_contact" placeholder="Accounts Dept." required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Billing Email <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-envelope-check"></i>
                        <input type="email" class="form-control" name="billemail" id="bill_email" placeholder="billing@company.com" required>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Billing Phone <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-phone-fill"></i>
                        <input type="tel" class="form-control" name="billphone" id="bill_phone" placeholder="Office Phone" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark-emphasis mb-2">Fax Number <span class="text-danger">*</span></label>
                    <div class="input-group-modern">
                        <i class="bi bi-printer-fill"></i>
                        <input type="text" class="form-control" name="billfax" id="bill_fax" placeholder="Fax" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Multi-Step Navigation -->
        <div class="form-navigation mt-5 pt-4 border-top">
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="read_btn prop-prev-btn" style="display: none;">
                    <i class="bi bi-arrow-left me-2"></i> Back
                </button>
                <div class="ms-auto">
                    <button type="button" class="read_btn prop-next-btn">
                        Next Step <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                    <button type="submit" class="read_btn prop-submit-btn" style="display: none !important;">
                        <i class="bi bi-check2-all me-2"></i> Submit Listing
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    /* Premium Modern Form Styles - Decongested & Airtight */
    .property-form-container {
        background: #ffffff;
        padding: 60px;
        border-radius: 40px;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.06);
        max-width: 1000px;
        margin: 0 auto;
    }

    /* Stepper Enhancement */
    .prop-stepper {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 0 20px;
        position: relative;
    }

    .prop-step-badge {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        position: relative;
        z-index: 2;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        flex: 0 0 85px;
    }

    .step-icon {
        width: 54px;
        height: 54px;
        background: #f8fafc;
        color: #94a3b8;
        border-radius: 20px; /* Modern squircle */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        border: 2px solid #f1f5f9;
        transition: all 0.4s ease;
    }

    .step-text {
        font-size: 0.65rem;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        white-space: nowrap;
    }

    .prop-step-badge.active .step-icon {
        background: var(--colorPrimary);
        color: white;
        border-color: var(--colorPrimary);
        box-shadow: 0 10px 20px rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.2);
        transform: translateY(-5px);
    }

    .prop-step-badge.active .step-text {
        color: var(--colorPrimary);
    }

    .prop-step-badge.completed .step-icon {
        background: #10b981;
        color: white;
        border-color: #10b981;
    }

    .prop-step-connector {
        flex: 1;
        height: 4px;
        background: #f1f5f9;
        margin-top: 25px;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
    }

    .prop-step-connector::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 0;
        background: var(--colorPrimary);
        transition: width 0.5s ease;
    }

    .prop-step-connector.active::after {
        width: 100%;
    }

    /* Input Modernization */
    .input-group-modern {
        position: relative;
    }

    .input-group-modern i {
        position: absolute;
        left: 22px;
        color: #adb5bd;
        font-size: 1.25rem;
        z-index: 5;
        top: 50%;
        transform: translateY(-50%);
        transition: color 0.3s;
    }

    .input-group-modern:focus-within i {
        color: var(--colorPrimary);
    }

    .input-group-modern .form-control, 
    .input-group-modern .form-select {
        height: 60px;
        padding: 10px 25px 10px 60px !important;
        background: #fdfdfd;
        border: 2px solid #f1f5f9;
        border-radius: 18px;
        font-weight: 500;
        font-size: 1rem;
        color: #334155;
        transition: all 0.3s ease;
    }

    .input-group-modern textarea.form-control {
        height: auto;
    }

    .input-group-modern .form-control:focus, 
    .input-group-modern .form-select:focus {
        background: #fff;
        border-color: var(--colorPrimary);
        box-shadow: 0 10px 25px rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.08);
        outline: none;
    }

    /* Section Spacing Helpers */
    .section-divider {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .section-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #f1f5f9;
    }

    .modern-header-line {
        position: relative;
        text-align: center;
    }
    .modern-header-line::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 1px;
        background: #e2e8f0;
        left: 0;
        top: 50%;
        z-index: 1;
    }
    .modern-header-line span {
        position: relative;
        z-index: 2;
    }

    /* Cards */
    .bg-primary-soft { background: rgba(106, 100, 241, 0.05); }
    
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .main-icon {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin: 0 auto;
    }

    .pulse-circle {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 4px 12px rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.2);
    }

    /* Steps Logic */
    .prop-form-step { display: none; animation: premiumFade 0.6s cubic-bezier(0.23, 1, 0.32, 1); }
    .prop-form-step.active { display: block; }

    @keyframes premiumFade {
        from { opacity: 0; transform: scale(0.98) translateY(15px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    /* Buttons - Standardized to project look */
    

    .custom-switch-premium .form-check-input {
        width: 3.5rem;
        height: 1.75rem;
        background-color: #e2e8f0;
        border: none;
        cursor: pointer;
    }
    .custom-switch-premium .form-check-input:checked {
        background-color: var(--colorPrimary);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .property-form-container { padding: 30px 20px; border-radius: 0; }
        .step-text { display: none; }
        .prop-step-badge { flex: 0 0 54px; }
        .prop-stepper { padding: 0; margin-bottom: 2.5rem !important; }
        .step-icon { width: 44px; height: 44px; font-size: 1.1rem; border-radius: 14px; }
        .prop-step-connector { margin-top: 20px; }
    }
</style>

<script>
    (function() {
        const formContainer = document.querySelector('.property-form-container');
        if (!formContainer) return;

        let currentStep = 0;
        const steps = formContainer.querySelectorAll('.prop-form-step');
        const totalSteps = steps.length;
        const stepBadges = formContainer.querySelectorAll('.prop-step-badge');
        const nextBtn = formContainer.querySelector('.prop-next-btn');
        const prevBtn = formContainer.querySelector('.prop-prev-btn');
        const submitBtn = formContainer.querySelector('.prop-submit-btn');
        const connectors = formContainer.querySelectorAll('.prop-step-connector');

        function updateUI() {
            steps.forEach((step, index) => {
                step.classList.toggle('active', index === currentStep);
            });

            stepBadges.forEach((badge, index) => {
                badge.classList.remove('active', 'completed');
                if (index < currentStep) badge.classList.add('completed');
                if (index === currentStep) badge.classList.add('active');
            });

            connectors.forEach((conn, index) => {
                conn.classList.toggle('active', index < currentStep);
            });

            // Update button visibility
            if (currentStep === 0) {
                prevBtn.style.display = 'none';
            } else {
                prevBtn.style.setProperty('display', 'inline-flex', 'important');
            }
            
            if (currentStep === totalSteps - 1) {
                // Last step: hide Next, show Submit
                nextBtn.style.display = 'none';
                submitBtn.style.setProperty('display', 'inline-flex', 'important');
            } else {
                // Other steps: show Next, hide Submit
                nextBtn.style.setProperty('display', 'inline-flex', 'important');
                submitBtn.style.setProperty('display', 'none', 'important');
            }

            window.scrollTo({ top: 100, behavior: 'smooth' });
        }

        function validateStep() {
            const currentStepEl = formContainer.querySelector(`.prop-form-step#step${currentStep}`);
            if (!currentStepEl) return true;

            const inputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.checkValidity() || (input.type === 'checkbox' && !input.checked)) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!isValid) toastr.error("Please fill in all mandatory fields correctly.");
            return isValid;
        }

        nextBtn?.addEventListener('click', () => {
            if (validateStep()) {
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

        // Initialize UI
        updateUI();

        // City/State dropdowns are now handled by the global city-state-handler.js
        // No inline code needed - just use class="state-dropdown" and data-city-target="#city-id"


        // Billing Auto-fill logic
        document.getElementById('sameaspropertyaddress')?.addEventListener('change', function() {
            if (this.checked) {
                const stateId = document.getElementById('add-property-state').value;
                const cityId = document.getElementById('add-property-city').value;
                const addr = document.getElementById('prop_address').value;
                const zip = document.getElementById('prop_zip').value;
                const name = document.getElementById('prop_name').value;
                const contact = document.querySelector('input[name="pcontact"]').value;
                const email = document.querySelector('input[name="addpropertyemail"]').value;
                const phone = document.querySelector('input[name="contactno"]').value;

                document.getElementById('bill_to').value = name;
                document.getElementById('bill_address').value = addr;
                document.getElementById('bill_zip').value = zip;
                document.getElementById('bill_contact').value = contact;
                document.getElementById('bill_email').value = email;
                document.getElementById('bill_phone').value = phone;

                const billState = document.getElementById('bill_address_state');
                billState.value = stateId;
                if (typeof jQuery !== 'undefined' && jQuery.fn.niceSelect) {
                    jQuery(billState).niceSelect('update');
                }
                billState.dispatchEvent(new Event('change'));

                const interval = setInterval(() => {
                    const billCity = document.getElementById('bill_address_city');
                    if (!billCity.disabled && billCity.options.length > 1) {
                        billCity.value = cityId;
                        clearInterval(interval);
                    }
                }, 100);

                toastr.success("Billing data synchronized with property details.");
            }
        });

    })();
</script>