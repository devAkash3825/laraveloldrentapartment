@extends('admin.layouts.app')
@section('title', 'RentApartments Admin | Manage Profile')
@section('content')

<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Profile</li>
            </ol>
            <h6 class="slim-pagetitle">Manage Profile</h6>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="slim-card-title mb-0">Profile Information</h6>
                    </div>
                    <div class="card-body">
                        <form id="adminProfileForm" action="{{ route('admin-update-profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="profile-image-upload">
                                        <div class="avatar-container">
                                            <div class="avatar-preview" id="imagePreview">
                                                @if($admin->admin_headshot && file_exists(public_path('uploads/profile_pics/' . $admin->admin_headshot)))
                                                    <img src="{{ asset('uploads/profile_pics/' . $admin->admin_headshot) }}" alt="Profile" id="previewImg">
                                                @else
                                                    <div class="avatar-placeholder">
                                                        <i class="fa-solid fa-user"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <label for="imageUpload" class="avatar-edit-btn">
                                                <i class="fa-solid fa-camera"></i>
                                                <span>Change Photo</span>
                                            </label>
                                            <input type="file" id="imageUpload" name="admin_headshot" accept=".png,.jpg,.jpeg" class="d-none">
                                        </div>
                                        <small class="text-muted d-block text-center mt-2">JPG, PNG max 2MB</small>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('admin_name') is-invalid @enderror" 
                                               name="admin_name" value="{{ old('admin_name', $admin->admin_name ?? '') }}" 
                                               placeholder="Enter your full name" required>
                                        @error('admin_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('admin_login_id') is-invalid @enderror" 
                                               name="admin_login_id" value="{{ old('admin_login_id', $admin->admin_login_id ?? '') }}" 
                                               placeholder="Enter username" required>
                                        @error('admin_login_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               name="email" value="{{ old('email', $admin->admin_email ?? '') }}" 
                                               placeholder="Enter email address" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-save me-1"></i> Update Profile
                                        </button>
                                        <a href="{{ route('admin-change-password') }}" class="btn btn-outline-secondary ms-2">
                                            <i class="fa-solid fa-key me-1"></i> Change Password
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="slim-card-title mb-0">Account Details</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <small class="text-muted d-block">Account Type</small>
                                <span class="badge badge-{{ $admin->admin_type === 'S' ? 'success' : 'primary' }}">
                                    {{ $admin->admin_type === 'S' ? 'Super Admin' : 'Admin' }}
                                </span>
                            </li>
                            <li class="mb-3">
                                <small class="text-muted d-block">Phone</small>
                                <strong>{{ $admin->phone ?? 'Not set' }}</strong>
                            </li>
                            <li class="mb-3">
                                <small class="text-muted d-block">Title</small>
                                <strong>{{ $admin->title ?? 'Not set' }}</strong>
                            </li>
                            <li>
                                <small class="text-muted d-block">Company</small>
                                <strong>{{ $admin->company ?? 'Not set' }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .profile-image-upload {
        text-align: center;
        padding: 20px;
    }
    
    .avatar-container {
        position: relative;
        display: inline-block;
    }
    
    .avatar-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #f0f0f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .avatar-placeholder {
        font-size: 48px;
        color: #ccc;
    }
    
    .avatar-edit-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 12px;
        padding: 8px 16px;
        background: #f0f0f0;
        border-radius: 20px;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.2s ease;
    }
    
    .avatar-edit-btn:hover {
        background: #e0e0e0;
    }
</style>
@endpush

@push('adminscripts')
<script>
$(document).ready(function() {
    // Image preview on file select
    $('#imageUpload').on('change', function() {
        const file = this.files[0];
        if (file) {
            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                showToast('Image size should be less than 2MB', 'error');
                this.value = '';
                return;
            }
            
            // Validate file type
            if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                showToast('Only JPG and PNG images are allowed', 'error');
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').html('<img src="' + e.target.result + '" alt="Preview" id="previewImg">');
            };
            reader.readAsDataURL(file);
        }
    });

    // Form validation
    $('#adminProfileForm').validate({
        rules: {
            admin_name: {
                required: true,
                minlength: 2
            },
            admin_login_id: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            admin_name: {
                required: 'Please enter your name',
                minlength: 'Name must be at least 2 characters'
            },
            admin_login_id: {
                required: 'Please enter a username',
                minlength: 'Username must be at least 3 characters'
            },
            email: {
                required: 'Please enter your email',
                email: 'Please enter a valid email address'
            }
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });
});
</script>
@endpush
