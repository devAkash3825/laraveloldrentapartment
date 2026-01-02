@extends('user.layout.app')
@section('title', 'RentApartements | My Properties ')
@section('content')
    <div id="breadcrumb_part"
        style="background: url(../images/breadcroumb_bg.jpg);background-size: cover;background-repeat: no-repeat;background-position: center;">
        <div class="bread_overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h4>listing</h4>
                        <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"> Home </a></li>
                                <li class="breadcrumb-item active" aria-current="page"> listing </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section id="listing_grid" class="grid_view">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 pb-4">
                    <x-dashboard-sidebar />
                </div>
                <div class="col-lg-9 mt-4 mt-lg-0 px-3 py-0 pb-4">
                    <div class="dashboard_content">
                        <div class="manage_dasboard">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="px-1">
                                        <div class="project-table">
                                            <div class="container">
                                                <div class="table-responsive">
                                                    @if(count($paginatedRecords) > 0)
                                                    <table class="table table-striped custom-table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th style="align-content:center;">S.No</th>
                                                                <th style="align-content:center;">Image</th>
                                                                <th style="align-content:center;">Property Name</th>
                                                                <th style="align-content:center;">Status</th>
                                                                <th style="align-content:center;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($paginatedRecords as $row)
                                                                <tr class="">
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>
                                                                        @if (isset($row->gallerytype->gallerydetail[0]->ImageName))
                                                                            <img src="https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_{{ $row->Id }}/Original/{{ $row->gallerytype->gallerydetail[0]->ImageName }}"
                                                                                class='datatable-img' alt='Property Image'>
                                                                        @else
                                                                            <img src="{{ asset('img/No_Image_Available.jpg') }}"
                                                                                alt="" class='datatable-img'>
                                                                        @endif
                                                                    </td>
                                                                    <td> {{ $row->PropertyName ?? 'N/A' }}</td>
                                                                    <td>
                                                                        @if ($row->Status == 1)
                                                                            <a href="javascript:void(0)"
                                                                                class="badge rounded-pill text-bg-success py-1 px-3">Active</a>
                                                                        @else
                                                                            <a href="javascript:void(0)"
                                                                                class="badge rounded-pill text-bg-danger py-1 px-3">Inactive</a>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <div class="demo-btn-list d-flex" style="gap: 5px;">
                                                                            <a href="{{ route('property-display', ['id' => $row->Id]) }}"
                                                                                class="btn-primary-icon px-2 py-1 border rounded m-1"
                                                                                data-bs-toggle="tooltip" title="View"><i
                                                                                    class="bi bi-eye"></i></a>
                                                                            <a href="{{ route('edit-properties', ['id' => $row->Id]) }}"
                                                                                class="btn-secondary-icon px-2 py-1 border rounded m-1"
                                                                                data-bs-toggle="tooltip" title="Map"><i
                                                                                    class="bi bi-pencil-square"></i></a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    @else
                                                    @include('user.partials.no_record_found')
                                                    @endif
                                                </div>


                                            </div>

                                        </div>

                                        @if ($paginatedRecords->lastPage() > 1)
                                            <div class="col-12">
                                                <div id="pagination">
                                                    <nav aria-label="Page navigation">
                                                        <ul class="pagination">
                                                            <li
                                                                class="page-item {{ $paginatedRecords->currentPage() == 1 ? 'disabled' : '' }}">
                                                                <a class="page-link"
                                                                    href="{{ $paginatedRecords->currentPage() == 1 ? 'javascript:void(0);' : $paginatedRecords->url($paginatedRecords->currentPage() - 1) }}"
                                                                    tabindex="-1"
                                                                    aria-disabled="{{ $paginatedRecords->currentPage() == 1 ? 'true' : 'false' }}">
                                                                    <i class="fas fa-chevron-left" aria-hidden="true"></i>
                                                                </a>
                                                            </li>

                                                            @for ($i = 1; $i <= $paginatedRecords->lastPage(); $i++)
                                                                <li
                                                                    class="page-item {{ $paginatedRecords->currentPage() == $i ? 'active' : '' }}">
                                                                    <a class="page-link"
                                                                        href="{{ $paginatedRecords->url($i) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</a>
                                                                </li>
                                                            @endfor

                                                            <li
                                                                class="page-item {{ $paginatedRecords->currentPage() == $paginatedRecords->lastPage() ? 'disabled' : '' }}">
                                                                <a class="page-link"
                                                                    href="{{ $paginatedRecords->currentPage() == $paginatedRecords->lastPage() ? 'javascript:void(0);' : $paginatedRecords->url($paginatedRecords->currentPage() + 1) }}">
                                                                    <i class="fas fa-chevron-right" aria-hidden="true"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
