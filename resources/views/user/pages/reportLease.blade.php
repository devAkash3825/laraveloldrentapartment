@extends('user/layout/app')
@section('content')
<!-- Premium Header -->
<div class="header-premium-gradient py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">Report Lease</h1>
                <p class="text-white opacity-75 lead mb-0">Submit your lease report for tracking</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">Report Lease</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

    <section id="listing_grid" class="grid_view">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <x-dashboard-sidebar />
                </div>
                <div class="col-lg-9">
                    <div class="dashboard_content">
                        <div class="dashboard_content">
                            <div class="my_listing">
                                <h4> Report Lease </h4>
                                
                                <form id="reportLeaseForm">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12">
                                            <div class="row">
                                                
                                                <div class="col-xl-12 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="username">Name or names on lease <span class="text-danger">*</span></label>
                                                        <div class="input_area">
                                                            <textarea cols="30" rows="3" id="username" name="username" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="address">New Rental Address <span class="text-danger"> *</span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="address" name="address" placeholder="Address" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-12">
                                                    <div class="my_listing_single">
                                                        <label for="apt">Apt. #(Required if Applicable) </label>
                                                        <div class="input_area">
                                                            <input type="text" id="apt" name="apt" placeholder="Apt #">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="state">State  <span class="text-danger">*</span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="state" name="state" placeholder="State" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="city">City  <span class="text-danger">*</span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="city" name="city" placeholder="City" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="zipcode">Zip Code <span class="text-danger"> * </span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="zipcode" name="zipcode" placeholder="Zip Code" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="phone">Phone </label>
                                                        <div class="input_area">
                                                            <input type="text" id="phone" name="phone" placeholder="Phone">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="email"> Email ID <span class="text-danger">*</span> </label>
                                                        <div class="input_area">
                                                            <input type="email" id="email" name="email" placeholder="Email" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="movedate">Move-in Date  <span class="text-danger">*</span></label>
                                                        <div class="input_area">
                                                            <input type="date" id="movedate" name="movedate" placeholder="Move Date" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="lengthlease">Length of Lease  <span class="text-danger">*</span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="lengthlease" name="lengthlease" placeholder="Length of Lease">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="rentamount">Rent Amount<span class="text-danger"> * </span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="rentamount" name="rentamount" placeholder="Rent Amount" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="namecommunityorlandlords">Name of Community or Landlord  <span class="text-danger">*</span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="namecommunityorlandlords" name="namecommunityorlandlords" placeholder="Name of Community or Landlord">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="landlordtelephone">Landlord's Telephone </label>
                                                        <div class="input_area">
                                                            <input type="text" id="landlordtelephone" name="landlordtelephone" placeholder="Landlord's Telephone">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    <div class="my_listing_single">
                                                        <label for="assisted_by">Name of Person Who assisted You <span class="text-danger"> * </span></label>
                                                        <div class="input_area">
                                                            <input type="text" id="assisted_by" name="assisted_by" placeholder="Agent Name">
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                                <div class="col-12">
                                                    <button type="submit" class="read_btn float-right" id="submitBtn">Submit <span id="loader" class="spinner-border spinner-border-sm d-none"></span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#reportLeaseForm').on('submit', function(e) {
            e.preventDefault();
            
            // Basic validation
            if (!$('#reportLeaseForm')[0].checkValidity()) {
                $('#reportLeaseForm')[0].reportValidity();
                return;
            }

            let formData = new FormData(this);
            $('#submitBtn').prop('disabled', true);
            $('#loader').removeClass('d-none');

            $.ajax({
                url: "{{ route('submit-report-lease') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#submitBtn').prop('disabled', false);
                    $('#loader').addClass('d-none');
                    
                    if (response.success) {
                        toastr.success(response.message);
                        $('#reportLeaseForm')[0].reset();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    $('#submitBtn').prop('disabled', false);
                    $('#loader').addClass('d-none');
                    
                    let errorMsg = 'An error occurred.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                         // Show first validation error
                         errorMsg = Object.values(xhr.responseJSON.errors)[0][0];
                    }
                    toastr.error(errorMsg);
                }
            });
        });
    });
</script>
@endpush
