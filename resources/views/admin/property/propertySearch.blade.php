@extends('admin.layouts.app')
@section('content')
    <div class="slim-mainpanel">
        <div class="container">
            <div class="slim-pageheader">
                <ol class="breadcrumb slim-breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Search Property</li>
                </ol>
                <h6 class="slim-pagetitle">Property Search</h6>
            </div>

            <div>
                <div class="section-wrapper">
                    <div class="table-responsive">
                        <table id="propertyTable" class="display">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Property Name</th>
                                    <th>City</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('adminscripts')
    <script>
        $(document).ready(function() {
            const properties = @json($searchproperties);
            handleCommissionsResponse(properties);

            $('#searchInput').on('keyup', function() {
                $('#propertyTable').DataTable().ajax.reload();
            });

            function handleCommissionsResponse(data) {
                $('#propertyTable').DataTable({
                    data: data,
                    columns: [{
                            data: null,
                            title: 'S.no',
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'PropertyName',
                            title: 'Property Name',
                            render: function(data, type, row) {
                                var url = "{{ route('admin-property-display', ['id' => ':id']) }}"
                                    .replace(':id', row.Id);
                                return `<a class="btn delete-btn font-weight-bold bg-link" href="${url}">${data}</a>`;
                            }
                        },
                        {
                            data: 'Cityid',
                            title: 'City',
                            render: function(data, type, row) {
                                return row.city && row.city.CityName ? row.city.CityName : '';
                            }

                        },
                        {
                            data: 'status',
                            title: 'Status',
                            render: function(data, type, row) {
                                if (row.Status == 1) {
                                    return `<a href='javascript:void(0)' id='changetopropertystatus' class='changetopropertystatus c-pill c-pill--success' data-status='${row.Status}' onclick='changeStatus(${row.Id})'> Active </a>`;
                                } else if (row.Status == 2) {
                                    return `<a href='javascript:void(0)' id='changetopropertystatus' class='changetopropertystatus c-pill c-pill--danger' data-status='${row.Status}' onclick='changeStatus(${row.Id})'> Leased </a>`;
                                } else {
                                    return `<a href='javascript:void(0)' id='changetopropertystatus' class='changetopropertystatus c-pill c-pill--warning' data-status='${row.Status}' onclick='changeStatus(${row.Id})'> InActive </a>`;
                                }
                            }
                        },
                        {
                            data: null,
                            title: 'Actions',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                var editUrl = "{{ route('admin-edit-property', ['id' => ':id']) }}"
                                    .replace(':id', row.Id);
                                var deleteurl =
                                    "{{ route('admin-delete-property', ['id' => ':id']) }}".replace(
                                        ':id', row.Id);
                                var dataid = row.Id;
                                return `<div class="table-actionss-icon table-actions-icons float-none">
                                    <a href="${editUrl }" class="edit-btn">
                                        <i class="fa-solid fa-pen px-2 py-2 edit-icon border px-2 py-2 edit-icon"></i>
                                    </a>
                                    <a href="javascript:void(0)" id="delete-property" class="propertyDlt" data-id="${dataid}" data-url="${deleteurl}'">
                                        <i class="fa-solid fa-trash px-2 py-2 delete-icon border"></i>
                                    </a>
                                    </div>`;
                            }
                        }
                    ],
                    paging: true,
                    pageLength: 10,
                    // lengthMenu: [5, 10, 25, 50],
                    // responsive: true
                });
            }
        });
    </script>
@endpush
