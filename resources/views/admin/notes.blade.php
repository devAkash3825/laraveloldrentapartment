@extends('admin.layouts.app')
@section('content')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin-activeRenter') }}">Renters</a></li>
                <li class="breadcrumb-item active" aria-current="page">Notes</li>
            </ol>
            <h6 class="slim-pagetitle">Manage Notes for {{ $renter->renterinfo->Firstname ?? 'User' }} - {{ $property->PropertyName }}</h6>
        </div>

        <div class="section-wrapper">
            <div class="row">
                <!-- Sticky Note / Main Note -->
                <div class="col-md-12 mb-4">
                    <div class="card card-body p-4">
                        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Main Note (Sticky)</h6>
                        <p class="mg-b-20 tx-12 tx-gray-500">This note is the "Current Status". It updates the main record.</p>
                        
                        <form action="{{ route('admin-save-note') }}" method="POST">
                            @csrf
                            <input type="hidden" name="renterId" value="{{ $renterId }}">
                            <input type="hidden" name="propertyId" value="{{ $propertyId }}">
                            
                            <div class="form-group">
                                <textarea class="form-control" name="note" rows="5" placeholder="Enter note here...">{{ $stickyNote }}</textarea>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save & Add to History</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- History Log -->
                <div class="col-md-12">
                    <div class="card card-body p-4">
                        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Note History</h6>
                        <div class="media-list">
                            @forelse($history as $note)
                                <div class="media mg-b-20 border-bottom pb-3">
                                    <div class="media-body">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="tx-14 tx-inverse">
                                                @if($note->user_id == $renterId)
                                                    <span class="text-danger"><i class="fa fa-user"></i> Renter ({{ $renter->UserName }})</span>
                                                @else
                                                    <span class="text-primary"><i class="fa fa-shield"></i> Admin/Manager</span>
                                                @endif
                                            </h6>
                                            <span class="tx-12 tx-gray-500">{{ $note->send_time ? $note->send_time->format('M d, Y h:i A') : 'N/A' }}</span>
                                        </div>
                                        <p class="mg-b-0">{{ $note->message }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted">No history found.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
