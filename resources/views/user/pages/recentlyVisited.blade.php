@extends('user.layout.app')
@section('title', 'RentApartements | Recently Visited ')
@section('content')
    <div id="breadcrumb_part" style="background-image:url('images/breadcroumb_bg.jpg')">
        <div class="bread_overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h4>Recently Visited </h4>
                        <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"> Home </a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Recently Visited </li>
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
                <div class="col-lg-3">
                    <x-dashboard-sidebar />
                </div>
                <div class="col-lg-9">
                    <div class="dashboard_content">
                        <div class="manage_dasboard">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="px-1">
                                        <div class="project-table">

                                            <div class="container">
                                                <div class="table-responsive">
                                                    @if(count($paginatedRecords) > 0)
                                                    <table class="table table-striped custom-table">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th scope="col">Property Name</th>
                                                                <th scope="col">Visited Date Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($paginatedRecords as $row)
                                                                <tr scope="row">
                                                                    <td>
                                                                        <label class="control control--checkbox">
                                                                            {{ $loop->iteration }}
                                                                        </label>
                                                                    </td>
                                                                    <td>
                                                                        <a href="" class="list-property-name">
                                                                            {{ @$row->propertyinfo->PropertyName ?? '-' }}
                                                                        </a>
                                                                        <small class="d-block">{{ @$row->propertyinfo->Address}}</small>
                                                                    </td>
                                                                    <td>
                                                                        <p class="font-weight-bold">
                                                                            {{ @$row->lastviewed ? $row->lastviewed->format('Y-m-d') : 'Not Available' }}
                                                                        </p>
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
