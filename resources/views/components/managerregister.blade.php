<div class="manager-registration-wrapper">
    <div class="registration-header text-center mb-4">
        <div class="icon-badge mb-3">
            <i class="bi bi-building"></i>
        </div>
        <h5 class="fw-bold mb-2" style="color: #1e293b;">Manager Account Registration</h5>
        <p class="text-muted mb-0" style="font-size: 0.95rem;">Access professional tools to manage your properties efficiently.</p>
    </div>

    <form class="needs-validation manager-form" id="manager-registration-form" novalidate>
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Username <span class="text-danger">*</span></label>
            <div class="input-group-custom">
                <i class="bi bi-person"></i>
                <input type="text" class="form-control" name="username" placeholder="Choose a username" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address <span class="text-danger">*</span></label>
            <div class="input-group-custom">
                <i class="bi bi-envelope"></i>
                <input type="email" class="form-control" name="email" placeholder="manager@example.com" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="form-label">Password <span class="text-danger">*</span></label>
                <div class="input-group-custom">
                    <i class="bi bi-lock"></i>
                    <input type="password" class="form-control" id="manager_password" name="password" placeholder="••••••••" required>
                    <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('manager_password', event)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div class="form-text mt-1" style="font-size: 0.8rem; color: #64748b;">Min. 8 characters</div>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                <div class="input-group-custom">
                    <i class="bi bi-shield-check"></i>
                    <input type="password" class="form-control" id="manager_password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                    <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('manager_password_confirmation', event)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="alert alert-info border-0 rounded-3 mb-4" style="background: rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.08); color: #475569; font-size: 0.9rem;">
            <div class="d-flex align-items-start">
                <i class="bi bi-info-circle-fill me-2 mt-1" style="color: var(--colorPrimary);"></i>
                <div>
                    <strong>Manager Benefits:</strong>
                    <ul class="mb-0 mt-2 ps-3" style="line-height: 1.8;">
                        <li>List unlimited properties</li>
                        <li>Advanced analytics dashboard</li>
                        <li>Direct communication with renters</li>
                        <li>Professional property showcase</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="form-navigation mt-4">
            <button type="submit" class="btn btn-primary-custom w-100 py-3 manager-submit-btn">
                <i class="bi bi-building-check me-2"></i> Register as Property Manager
            </button>
        </div>

        <div class="text-center mt-4">
            <p class="text-muted mb-0">Already have an account? <a href="{{ route('show-login') }}" class="text-primary fw-bold text-decoration-none underline-hover">Login</a></p>
        </div>
    </form>
</div>

<style>
    /* Icon Badge */
    .icon-badge {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--colorPrimary) 0%, rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.8) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 8px 24px rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.25);
    }

    .icon-badge i {
        font-size: 2rem;
        color: white;
    }

    /* Form Labels */
    .manager-form .form-label {
        color: #475569;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    /* Button Styling */
    .btn-primary-custom {
        background: var(--colorPrimary);
        background: linear-gradient(135deg, var(--colorPrimary) 0%, rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.8) 100%);
        border: none;
        color: white;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        border-radius: 12px;
        font-size: 0.95rem;
        box-shadow: 0 4px 15px rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.2);
    }

    .btn-primary-custom:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 10px 25px rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.35);
        filter: brightness(1.1);
        color: white;
    }

    .btn-primary-custom:active {
        transform: translateY(-1px);
    }

    /* Alert Styling */
    .alert-info ul {
        margin-bottom: 0;
        padding-left: 1.2rem;
    }

    .alert-info li {
        font-size: 0.85rem;
        color: #475569;
    }

    .underline-hover:hover {
        text-decoration: underline !important;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .icon-badge {
            width: 60px;
            height: 60px;
        }

        .icon-badge i {
            font-size: 1.75rem;
        }

        .registration-header h5 {
            font-size: 1.1rem;
        }

        .registration-header p {
            font-size: 0.85rem;
        }
    }
</style>

<script>
    (function() {
        const form = document.getElementById('manager-registration-form');
        const submitBtn = form?.querySelector('.manager-submit-btn');

        form?.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Basic validation
            const password = document.getElementById('manager_password').value;
            const confirm = document.getElementById('manager_password_confirmation').value;
            
            if (password !== confirm) {
                toastr.error("Passwords do not match");
                return;
            }

            if (password.length < 8) {
                toastr.error("Password must be at least 8 characters");
                return;
            }

            // Check required fields
            const inputs = form.querySelectorAll('input[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value || (input.type === 'email' && !input.validity.valid)) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                }
            });

            if (!isValid) {
                toastr.warning("Please fill in all required fields correctly.");
                return;
            }

            const formData = new FormData(this);
            const submitBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Registering...';

            try {
                const response = await fetch("{{ route('manager-register') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    toastr.success(data.success);
                    setTimeout(() => {
                        window.location.href = "/";
                    }, 1500);
                } else if (response.status === 422) {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            toastr.error(data.errors[key][0]);
                        });
                    } else {
                        toastr.error("Please check your inputs.");
                    }
                } else {
                    toastr.error(data.message || "An error occurred during registration");
                }
            } catch (error) {
                console.error("Submission error:", error);
                toastr.error("An error occurred. Please try again later.");
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = submitBtnText;
            }
        });
    })();
</script>