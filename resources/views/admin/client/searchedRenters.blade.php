@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle">Searched Results </h6>
            </div>

            <div class="section-wrapper">
                {{-- <table id="rentersTable" class="display">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($renters as $renter)
                            <tr>
                                <td>{{ $renter->renterInfo->Firstname ?? '-' }}</td>
                                <td>{{ $renter->renterInfo->Lastname ?? '-' }}</td>
                                <td>{{ $renter->renterInfo->phone ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> --}}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#rentersTable').DataTable();
        });
    </script>
@endpush
