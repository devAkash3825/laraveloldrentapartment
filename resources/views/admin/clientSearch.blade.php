@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="slim-pagetitle">Client Search</h6>
            </div>

            <div>
                <div class="section-wrapper">
                    <div class="table-responsive">
                        <table class="table mg-b-0">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Area to Move</th>
                                    <th>Admin</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                            @foreach ($rentersdata as $index => $data)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $data->renterinfo->Firstname ?? '-' }}</td>
                                    <td>{{ $data->renterinfo->Lastname ?? '-' }}</td>
                                    <td>{{ $data->renterinfo->Area_move ?? '-' }}</td>
                                    <td>
                                        @if ($data->Status == '0')
                                            <span class="c-pill c-pill--warning">Inactive</span>
                                        @elseif ($data->Status == '1')
                                            <span class="c-pill c-pill--success">Active</span>
                                        @else
                                            <span class="c-pill c-pill--danger">Leased</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="table-actions-icons">
                                            <a href="{{ route('admin-view-profile', ['id' => $data->Id]) }}" class="">
                                                <i class="fa-regular fa-eye border px-2 py-2 view-icon"></i>
                                            </a>
                                            <a href="#" class="edit-btn">
                                                <i class="fa-regular fa-pen-to-square border px-2 py-2 edit-icon"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody> --}}
                            <tbody>
                                @forelse ($rentersdata as $index => $data)
                                    <tr>
                                        <th scope="row">{{ $rentersdata->firstItem() + $index }}</th>
                                        <td>{{ $data->renterinfo->Firstname ?? '-' }}</td>
                                        <td>{{ $data->renterinfo->Lastname ?? '-' }}</td>
                                        <td>{{ $data->renterinfo->Area_move ?? '-' }}</td>
                                        <td>
                                            @if ($data->Status == '0')
                                                <span class="c-pill c-pill--warning">Inactive</span>
                                            @elseif ($data->Status == '1')
                                                <span class="c-pill c-pill--success">Active</span>
                                            @else
                                                <span class="c-pill c-pill--danger">Leased</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="table-actions-icons">
                                                <a href="{{ route('admin-view-profile', ['id' => $data->Id]) }}"
                                                    class="">
                                                    <i class="fa-regular fa-eye border px-2 py-2 view-icon"></i>
                                                </a>
                                                <a href="#" class="edit-btn">
                                                    <i class="fa-regular fa-pen-to-square border px-2 py-2 edit-icon"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                    {{ $rentersdata->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
