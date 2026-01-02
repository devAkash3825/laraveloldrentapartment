@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Search Renter</li>
                </ol>
                <h6 class="slim-pagetitle">Search Renter</h6>
            </div>


            <div class="section-wrapper">
                
                <form method="GET" action="{{ route('admin-client-search') }}" style="display:block;">

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control" name="searchtype" placeholder="" value="1">
                        </div>
                    </div>
                    
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Status</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="1" checked>
                                <label class="form-check-label">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="0">
                                <label class="form-check-label">Inactive</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="2">
                                <label class="form-check-label">Leased</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="">
                                <label class="form-check-label">All</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Probability Range</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="PR_from" placeholder="From">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="PR_to" placeholder="To">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">First Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="firstname">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Last Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="lastname">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Phone Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="phone">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Created Date</label>
                        <div class="col-sm-5">
                            <input type="date" class="form-control" name="CD_from" id="CD_from" placeholder="From">
                        </div>
                        <div class="col-sm-5">
                            <input type="date" class="form-control" name="CD_to" id="CD_to" placeholder="To">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Move Dates</label>
                        <div class="col-sm-5">
                            <input type="date" class="form-control" name="Emove_date" id="Emove_date"
                                placeholder="Earliest Move Date">
                        </div>
                        <div class="col-sm-5">
                            <input type="date" class="form-control" name="Lmove_date" id="Lmove_date"
                                placeholder="Latest Move Date">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Number of Bedrooms</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="srch_bedroom">
                                <option value="">Bed room</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Desired Rent Range</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="desiredrent_from" placeholder="From">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="desiredrent_to" placeholder="To">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Admin</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="admin">
                                <option value="0">All</option>
                                <option value="94">Administrator</option>
                                <option value="100">Amy Wales</option>
                                <option value="128">Kelsey Haberman</option>
                                <option value="129">Patrick Weseman</option>
                                <option value="130">Support</option>
                                <option value="138">Andrew E. Wiggin</option>
                                <option value="143">Master User</option>
                                <option value="144">Greyson Magana</option>
                                <option value="148">Open CO Springs</option>
                                <option value="149">Open TK</option>
                                <option value="150">Erica Johnson</option>
                                <option value="154">Shane Haberkorn</option>
                                <option value="155">Hs open</option>
                                <option value="158">Michael Sancimino</option>
                                <option value="159">Downtown</option>
                                <option value="160">Amelia Farrell</option>
                                <option value="162">Colorado Springs</option>
                                <option value="163">Madison Sebern</option>
                                <option value="164">Matt open</option>
                                <option value="165">Alex Weseman</option>
                                <option value="166">Alex Aleman</option>
                                <option value="167">Open Slot SN</option>
                                <option value="168">Leadership Admin</option>
                                <option value="170">OPEN Cl</option>
                                <option value="171">Ellen Hawkes</option>
                                <option value="172">Open AF</option>
                                <option value="173">Gene Cordeniz</option>
                                <option value="175">Downtown Manager</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary send-btn" id="search-btn">Search
                                Renter</button>
                        </div>
                    </div>
                </form>

                <div id="back-btn" style="display:none;">
                    <div class="row">
                        <div class="col-md-3">
                            <p class="float-left">
                                <a href="{{ route('admin-search-renter') }}"
                                    class="btn btn-info active btn-block mg-b-10"> <i
                                        class="fa-solid fa-arrow-left-long mr-2"></i> Back </a></a>
                            </p>
                        </div>
                    </div>
                </div>
                <table id="resultsTable" class="display" style="display:none;">
                    <thead>
                        <tr>
                            <th>FirstName</th>
                            <th>LastName</th>
                            <th>Status</th>
                            <th>Admin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script>
        $(document).ready(function() {
            $('#searchrenterform').on('submit', function(e) {
                e.preventDefault();
                let formData = {
                    status: $('input[name="status"]:checked').val(),
                    PR_from: $('input[name="PR_from"]').val(),
                    PR_to: $('input[name="PR_to"]').val(),
                    firstname: $('input[name="firstname"]').val(),
                    lastname: $('input[name="lastname"]').val(),
                    phone: $('input[name="phone"]').val(),
                    CD_from: $('input[name="CD_from"]').val(),
                    CD_to: $('input[name="CD_to"]').val(),
                    Emove_date: $('input[name="Emove_date"]').val(),
                    Lmove_date: $('input[name="Lmove_date"]').val(),
                    srch_bedroom: $('select[name="srch_bedroom"]').val(),
                    desiredrent_from: $('input[name="desiredrent_from"]').val(),
                    desiredrent_to: $('input[name="desiredrent_to"]').val(),
                    Remail: $('input[name="Remail"]').val(),
                    admin: $('select[name="admin"]').val(),
                    keywords_srch: $('input[name="keywords_srch"]').val(),
                    favouritsrch: $('input[name="favouritsrch"]').val()
                };

                $.ajax({
                    url: "{{ route('admin-searched-renter-result') }}",
                    type: "GET",
                    data: formData,
                    beforeSend: function() {
                        $('.send-btn').html(
                            `<span class="spinner-border text-secondary" role="status" aria-hidden="true"></span> Searching `
                        );
                        $('.send-btn').prop('disabled', true);
                    },
                    success: function(response) {
                        console.log("Check Response data", response);
                        $('.send-btn').html(`Search Renter`);
                        $('#back-btn').show();
                        if (response.data && response.data.length > 0) {
                            $('#searchrenterform').hide();
                            $('#resultsTable').show();
                            const tableBody = $('#resultsTable tbody');
                            tableBody.empty();

                            response.data.forEach(renter => {
                                const firstname = renter.renter_info?.Firstname ?? '-';
                                const lastname = renter.renter_info?.Lastname ?? '-';
                                const adminName = renter.renter_info?.admindetails ?.admin_name ?? '-';
                                const viewroute = `{{ url('admin/view-profile') }}/${renter.renter_info.Id}`;
                                const editroute = `{{ url('admin/edit-user') }}/${renter.renter_info.Id}`;
                                const actions = `<div class="table-actions-icons table-actions-icons float-left"> 
                                                    <a href="${viewroute}"> <i class="fa-solid fa-eye px-2 py-2 border px-2 py-2 view-icon"></i>
                                                    </a>
                                                    <a href="${editroute}" class="edit-btn">
                                                        <i class="fa-solid fa-pen px-2 py-2 edit-icon border px-2 py-2 edit-icon"></i> 
                                                    </a>
                                                </div>`;
                                let status;
                                switch (renter.Status) {
                                    case "1":
                                        status =
                                            `<a href="javascript:void(0)" class="c-pill c-pill--success">Active</a>`;
                                        break;
                                    case "0":
                                        status =
                                            `<a href="javascript:void(0)" class="c-pill c-pill--warning">Inactive</a>`;
                                        break;
                                    case "2":
                                        status =
                                            `<a href="javascript:void(0)" class="c-pill c-pill--danger">Leased</a>`;
                                        break;
                                    default:
                                        status = 'Unknown';
                                }

                                tableBody.append(`
                                    <tr>
                                        <td>${firstname}</td>
                                        <td>${lastname}</td>
                                        <td class="valign-middle tx-left">${status}</td>
                                        <td>${adminName}</td>
                                        <td>${actions}</td>
                                    </tr>
                                `);
                            });

                            $('#resultsTable').DataTable({
                                destroy: true,
                            });
                        } else {
                            $('#resultsTable').DataTable({
                                destroy: true,
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching renters:', xhr);
                        alert('An error occurred while searching for renters.');
                        $('#resultsTable').DataTable({
                            destroy: true,
                        });
                    },
                    complete: function() {
                        $('.send-btn').html(`Search Renter`);
                        $('.send-btn').prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush
