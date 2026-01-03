    <div class="registration-form-header mb-4">
        <h3 class="fw-bold text-slate">Register as Manager</h3>
        <p class="text-muted small">Access professional tools to manage your properties efficiently.</p>
    </div>
    <form class="needs-validation" id="manager-registration-form" novalidate>
        @csrf
        <h4 class="mb-4 d-flex align-items-center"><i class="bi bi-building me-2 text-primary"></i> Manager Account Details</h4>
        
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
                <input type="email" class="form-control" name="email" placeholder="manager@example.com" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-4">
                <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                <div class="input-group-custom">
                    <i class="bi bi-lock"></i>
                    <input type="password" class="form-control" id="manager_password" name="password" placeholder="••••••••" required>
                    <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('manager_password')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-12 mb-4">
                <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                <div class="input-group-custom">
                    <i class="bi bi-shield-check"></i>
                    <input type="password" class="form-control" id="manager_password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                </div>
            </div>
        </div>

        <div class="form-navigation mt-5">
            <button type="submit" class="btn btn-primary-custom w-100 py-3 shadow-sm rounded-4 manager-submit-btn">
                <i class="bi bi-building-check me-2"></i> Register as Property Manager
            </button>
        </div>

        <div class="text-center mt-5">
            <p class="text-muted">Already have an account? <a href="{{ route('show-login') }}" class="text-primary fw-bold text-decoration-none underline-hover">Login</a></p>
        </div>
    </form>
</div>

<style>
    .mb-4 {
        margin-bottom: 1.25rem !important;
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


    .btn-primary-custom {
        background: var(--colorPrimary);
        border: none;
        color: white;
        font-weight: 700;
        transition: all 0.3s;
        padding: 12px 25px;
        border-radius: 12px;
        font-size: 0.95rem;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.2);
        filter: brightness(1.1);
    }

    .underline-hover:hover {
        text-decoration: underline !important;
    }
</style>

<script>
    (function() {
        const form = document.getElementById('manager-registration-form');
        const submitBtn = form.querySelector('.manager-submit-btn');

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Basic matching validation
            const password = document.getElementById('manager_password').value;
            const confirm = document.getElementById('manager_password_confirmation').value;
            if (password !== confirm) {
                toastr.error("Passwords do not match");
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