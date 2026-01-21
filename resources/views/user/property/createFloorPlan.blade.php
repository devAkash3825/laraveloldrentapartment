@extends('user/layout/app')
@section('content')

<!-- Premium Header -->
<div class="header-premium-gradient py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">Create Floor Plan</h1>
                <p class="text-white opacity-75 lead mb-0">Add a new unit type or floor plan to your property</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('my-properties') }}" class="text-white opacity-75 text-decoration-none small">My Properties</a></li>
                        <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">New Floor Plan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section id="dashboard" class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <x-dashboard-sidebar />
            </div>
            <div class="col-lg-9">
                <div class="dashboard_content">
                    <div class="my_listing list_padding bg-white rounded-3 shadow-sm p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                            <h4 class="fw-bold mb-0">Floor Plan Details</h4>
                            <a href="{{ route('edit-properties', ['id' => $propertyId]) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="bi bi-arrow-left me-1"></i> Back to Property
                            </a>
                        </div>
                        
                        <form id="createfloorplan" method="post" action="{{ route('store-floor-plan') }}">
                            @csrf
                            <input type="hidden" name="propertyId" value="{{ $propertyId }}">



                            <div class="row g-4">
                                <!-- Category & Plan Type -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="my_listing_single">
                                        <label class="form-label fw-600">Category <span class="text-danger">*</span></label>
                                        <div class="input_area">
                                            <select class="form-select select_2" name="category" required>
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->Id }}" {{ old('category') == $category->Id ? 'selected' : '' }}>{{ $category->Name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="my_listing_single">
                                        <label class="form-label fw-600">Plan Type</label>
                                        <div class="input_area">
                                            <input type="text" class="form-control" name="plan_type" value="{{ old('plan_type') }}" placeholder="(e.g. Apartment, Loft, Townhome)">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Floor Plan & Plan Name -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="my_listing_single">
                                        <label class="form-label fw-600">Floor Plan</label>
                                        <div class="input_area">
                                            <input type="text" class="form-control" name="floor_plan" value="{{ old('floor_plan') }}" placeholder="(e.g. Studio, 2 bed 1 bath)">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="my_listing_single">
                                        <label class="form-label fw-600">Plan Name <span class="text-danger">*</span></label>
                                        <div class="input_area">
                                            <input type="text" class="form-control" name="plan_name" value="{{ old('plan_name') }}" placeholder="Enter Plan Name" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stats: Footage, Price, Deposit -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label class="form-label fw-600">Square Footage</label>
                                        <div class="input_area">
                                            <input type="number" class="form-control" name="square_footage" value="{{ old('square_footage') }}" placeholder="e.g. 850">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label class="form-label fw-600">Starting at ($)</label>
                                        <div class="input_area">
                                            <input type="number" class="form-control" name="starting_at" value="{{ old('starting_at') }}" placeholder="Monthly rent">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label class="form-label fw-600">Deposit ($)</label>
                                        <div class="input_area">
                                            <input type="number" class="form-control" name="deposit" value="{{ old('deposit') }}" placeholder="Deposit amount">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Links & Dates -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label class="form-label fw-600">Link</label>
                                        <div class="input_area">
                                            <input type="text" class="form-control" name="link" value="{{ old('link') }}" placeholder="External link">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label class="form-label fw-600">Available URL</label>
                                        <div class="input_area">
                                            <input type="text" class="form-control" name="available_url" value="{{ old('available_url') }}" placeholder="Availability link">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6">
                                    <div class="my_listing_single">
                                        <label class="form-label fw-600">Expiry Date</label>
                                        <div class="input_area">
                                            <input type="date" class="form-control" name="expiry_date" value="{{ old('expiry_date') }}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Rich Text Areas -->
                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label class="form-label fw-600">Unit Description / Specials</label>
                                        <div class="input_area">
                                            <textarea class="form-control" name="unit_description" rows="5">{{ old('unit_description') }}</textarea>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="my_listing_single">
                                        <label class="form-label fw-600">Special Note</label>
                                        <div class="input_area">
                                            <textarea class="form-control" name="special" rows="5">{{ old('special') }}</textarea>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dynamic Available Dates -->
                                <div class="col-xl-12">
                                    <div class="my_listing_single" id="medicine_row">
                                        <label class="form-label fw-600 d-block">Available Dates</label>
                                        <div class="medicine_row_input d-flex gap-2 mb-2">
                                            <input type="date" class="form-control" name="dates[]">
                                            <button type="button" id="add_row" class="btn btn-primary rounded-circle" style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <div id="dynamic_date_rows"></div>
                                    </div>
                                </div>

                                <div class="col-12 text-end mt-5 pt-3 border-top">
                                    <button type="submit" class="read_btn px-5 py-3">
                                        <i class="bi bi-check2-circle me-2"></i> Save Floor Plan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    $(document).ready(function() {

    // Dynamic Date Rows
    $('#add_row').click(function() {
        const row = `
            <div class="medicine_row_input d-flex gap-2 mb-2 animate__animated animate__fadeIn">
                <input type="date" class="form-control" name="dates[]">
                <button type="button" class="btn btn-danger rounded-circle remove_row" style="width: 40px; height: 40px; min-width: 40px;">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        `;
        $('#dynamic_date_rows').append(row);
    });

    $(document).on('click', '.remove_row', function() {
        $(this).closest('.medicine_row_input').remove();
    });


});
</script>
<style>
    .fw-600 { font-weight: 600; }
    .animate__fadeIn {
        animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .medicine_row_input .btn {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        border-color: #e2e8f0;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--colorPrimary);
        box-shadow: 0 0 0 3px rgba(var(--colorPrimaryRgb, 13, 124, 102), 0.1);
    }

    .read_btn {
        background: var(--colorPrimary);
        color: white !important;
        border: none;
        border-radius: 8px;
        padding: 10px 28px;
        font-weight: 600;
        font-size: 0.92rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .read_btn:hover {
        background: #1a1a1a;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        color: white !important;
    }
</style>
@endpush
@endsection
