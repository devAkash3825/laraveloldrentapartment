@extends('admin/layouts/app')
@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="slim-pagetitle"> ADD LEASE </h6>
        </div>

        <div class="form-layout section-wrapper">
            <form action="{{ route('admin-store-lease') }}" data-parsley-validate method="Post">
                @csrf
                <div class="row mg-b-25">
                    <div class="col-lg-12">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label">Assign Agent:</label>
                            <select class="form-control select2" data-placeholder="Choose Agent" name="editassignAgent">
                                <option label="Choose Agent"></option>
                                @foreach($admins as $agent)
                                <option value="{{$agent->id}}">{{$agent->admin_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">First Name: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="firstname" value="" placeholder="Enter First Name" required>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">Last Name: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="lastname" value="" placeholder="Enter Last Name" required>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">New Rental Address: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="new_rental_adddress"
                                value="" placeholder="Enter Address" required>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">Unit / Apt. #: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="unit"
                                value="" placeholder="Enter Unit" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label">Email address: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editemail" value=""
                                placeholder="Enter email address">
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label">State: <span class="tx-danger">*</span></label>
                            <select class="form-control select2 state-dropdown" data-placeholder="Choose State" name="editstate"
                                id="editstate" data-city-target="#editcity">
                                <option label="Choose country"></option>
                                @foreach($state as $row)
                                <option value="{{$row->Id}}">{{$row->StateName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label">City: <span class="tx-danger">*</span></label>
                            <select class="form-control select2" data-placeholder="Choose City" name="editcity"
                                id="editcity">
                                <option label="Choose City"></option>
                                <option value="USA">United States of America</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">UserName: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editusername" value=""
                                placeholder="Enter UserName">
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">Zip: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editzip"
                                value="" placeholder="Enter Zip">
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label"> Cell: <span class="tx-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-phone tx-16 lh-0 op-6"></i>
                                    </div>
                                </div>
                                <input id="phoneMask" type="text" class="form-control" placeholder="(999) 999-9999"
                                    name="editcell" value="">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label"> Other Phone : <span class="tx-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-phone tx-16 lh-0 op-6"></i>
                                    </div>
                                </div>
                                <input id="phoneMask" type="text" class="form-control" placeholder="(999) 999-9999"
                                    name="editothercell" value="">
                            </div>
                        </div>
                    </div>




                    <!-- Beds -->
                    <div class="col-lg-6">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label">Beds: <span class="tx-danger">*</span></label>
                            <select class="form-control select2" data-placeholder="Beds" name="editbeds">
                                <option label="Beds"></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">Landlord / Community: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="landloard" value="" placeholder="Enter Landlord">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">Rent Amount: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="rent_amount" value="" placeholder="Enter Rent Amount">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">Move-in Date: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="date" name="Emove_date" value="">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">Lease End Date:</label>
                            <input class="form-control" type="date" name="LeaseEndDate" value="">
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ready_to_invoice" id="ready_to_invoice" value="1">
                            <label class="form-check-label" for="ready_to_invoice" style="font-weight: 600; color: #1b84ff;">
                                Ready to Invoice (Check to start billing process)
                            </label>
                        </div>
                    </div>

                    <!-- Beds -->

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">Floor Preference: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editfloorpref"
                                value="" placeholder="Enter Floor">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">Garage Preference: <span
                                    class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editgarage"
                                value="" placeholder="Enter Garage">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label"> Laundry Preference: <span
                                    class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editlaundry"
                                value="" placeholder="Enter Laundry">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label"> Specific Cross Street : <span
                                    class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editcrossstreet"
                                value="" placeholder="Enter Cross street">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label"> Current Address: <span class="tx-danger">*</span></label>
                            <textarea rows="3" class="form-control" placeholder="Textarea"
                                value=""></textarea>
                        </div>
                    </div>




                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">Communities Visited: <span
                                    class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editcommunitiesvisited"
                                value="" placeholder="Enter Communities visited">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label">Credit History: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editcredithistory"
                                value="" placeholder="Enter Credit history">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label"> Rental History: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editrentalhistory"
                                value="" placeholder="Enter Rental history">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-control-label"> Criminal History : <span
                                    class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editcriminalhistory"
                                value="" placeholder="Enter Criminal History">
                        </div>
                    </div>




                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-control-label">Lease Term: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editlease"
                                value="" placeholder="Enter Floor">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-control-label">Garage Preference: <span
                                    class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editworknameaddress"
                                value="" placeholder="Enter Work_name_address">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-control-label"> Pet Info : <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editpetinfo"
                                value="" placeholder="Enter Pet Info">
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-control-label"> Earliest Move Date : <span
                                    class="tx-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                    </div>
                                </div>
                                <input type="date" class="form-control" id="dateMask" name="editemovedate"
                                    placeholder="MM/DD/YYYY" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-control-label"> Latest Move-in Date : <span
                                    class="tx-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                    </div>
                                </div>
                                <input type="date" class="form-control" id="dateMask" name="editelmovedate"
                                    placeholder="MM/DD/YYYY" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-control-label"> Set Reminder: <span class="tx-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                    </div>
                                </div>
                                <input type="date" class="form-control" id="setremainder" name="birthday"
                                    placeholder="Set Remainder" value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label"> What area are you wanting to move to?
                                /Other: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="editareamove"
                                value="" placeholder="Enter Area move">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label"> Desired Rent Range :</label>
                            <div class="d-md-flex pd-y-20 pd-md-y-0">
                                <input type="text" class="form-control" placeholder="From"
                                    value="" name="editstartrange">
                                <span class="ml-1 mr-2 p-1"
                                    style="align-content: center;font-size: 1.1rem;font-weight:600;">To</span>
                                <input type="text" class="form-control" placeholder="To"
                                    value="" name="editendrange">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label"> Additional Info: <span class="tx-danger">*</span></label>
                            <textarea rows="3" class="form-control" placeholder="Textarea" name="editadditionalinfo"
                                value=""></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label"> Locator Comments: <span
                                    class="tx-danger">*</span></label>
                            <textarea rows="3" class="form-control" placeholder="Textarea" name="editlocatorinfo"
                                value=""></textarea>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label"> Tour Info: <span class="tx-danger">*</span></label>
                            <textarea rows="3" class="form-control" placeholder="Textarea" name="edittourinfo"
                                value=""> </textarea>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label"> Remainder Note: <span class="tx-danger">*</span></label>
                            <textarea rows="3" class="form-control" placeholder="Textarea" name="editremaindernote"
                                value=""> </textarea>
                        </div>
                    </div>



                    <!-- col-8 -->

                </div>

                <div class="form-layout-footer">
                    <button class="btn btn-primary bd-0" type="submit">Submit Form</button>
                </div>
            </form>
        </div> 

    </div>
</div>   
@push('adminscripts')
<script>
</script>
@endpush
@endsection