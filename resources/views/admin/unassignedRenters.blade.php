@extends('admin.layouts.app')
@section('content')
@section('title', 'RentApartments Admin | Unassigned Renters')
<div class="slim-mainpanel">
    <div class="container">
        <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Unassigned Renters </li>
            </ol>
            <h6 class="slim-pagetitle">Unassigned Renter</h6>
        </div>
        <div class="section-wrapper">
            <div class="table-wrapper">
                <table id="unassigned-renter" class="table display responsive">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th class="text-center">Full Name</th>
                            <th class="text-center">Probability</th>
                            <th class="text-center">Area</th>
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
@endsection

@push('adminscripts')
<script>
    $(document).ready(function() {
        $('#unassigned-renter').DataTable($.extend(DataTableHelpers.getConfig("{{ route('admin-unassigned-renters') }}", [
            { data: "DT_RowIndex", orderable: false, searchable: false },
            { data: "fullname", name: "fullname" },
            { data: "probability", name: "probability" },
            { data: "area", name: "area" },
            { data: "actions", name: "actions", orderable: false, searchable: false }
        ]), {
            order: [[1, 'asc']]
        }));
    });

    function claimrenter(renterId) {
        ConfirmDialog.show({
            title: 'Claim Renter',
            text: 'Are you sure you want to claim this renter?',
            onConfirm: function() {
                AdminAjax.request("{{ route('admin-claim-renter') }}", 'POST', { renterId: renterId }, {
                    success: function(response) {
                        toastr.success(response.message || "Renter claimed successfully!");
                        $('#unassigned-renter').DataTable().ajax.reload();
                    }
                });
            }
        });
    }
</script>
@endpush
