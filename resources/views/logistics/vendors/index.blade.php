@extends('layouts.app')

@section('title', 'Supplier Vendor')

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .btn-group {
            gap: 0 !important;
            border-radius: 0.375rem !important;
        }

        .btn-group,
        .btn-group-vertical {
            position: relative !important;
            display: inline-flex !important;
            vertical-align: middle !important;
            margin-bottom: 25px !important;
        }
    </style>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Logistic</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Vendors/Suppliers List</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between py-3">
                <a href="{{ route('supplier.create') }}">
                    <button type="button" class="btn btn-primary px-2">+ Add Vendors</button>
                </a>
                <a href="{{ route('purchase.index') }}">
                    <button type="button" class="btn btn-danger px-2 mx-2">← Back</button>
                </a>
            </div>
            <table class="table mx-3 table-striped table-bordered" id="myDataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Contact No.</th>
                        <th scope="col">Email</th>
                        <th scope="col">Office Address</th>
                        @can('vendors.action')
                            <th scope="col">Status</th>
                        @endcan
                        <th scope="col">Is Tender</th>
                        <th scope="col">From Tender</th>
                        <th scope="col">To Tender</th>
                        @can('vendors.action')
                            <th scope="col">Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendors as $key => $item)
                        <tr class="">
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->contact_no }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->office_address }}</td>
                            @can('vendors.action')
                                <td>
                                    <div class="form-check form-switch form-check-success">
                                        <input class="form-check-input status-switch" type="checkbox" role="switch"
                                            id="status-{{ $item->id }}" name="status"
                                            {{ $item->status === 'active' ? 'checked' : '' }}
                                            data-item-id="{{ $item->id }}">
                                    </div>
                                </td>
                            @endcan
                            <td>{{ $item->is_tender }}</td>
                            <td>{{ $item->from_tender }}</td>
                            <td>{{ $item->to_tender }}</td>
                            <td>
                                @can('vendors.action')
                                    <div class="d-flex gap-3">
                                        <a href="{{ route('supplier.edit', ['id' => $item->id]) }}"><button type="button"
                                                class="btn btn-primary px-5">Edit</button></a>
                                        {{-- <a href="{{ route('/logistic/vendor/' . $item->id . '/delete') }}"> <button type="button"
                                            class="btn btn-danger px-5">Delete</button></a> --}}
                                    </div>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include the modal -->
    @include('include.alerts.status-change')

    <script>
        $(document).ready(function() {
            var table = $('#myDataTable').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#myDataTable_wrapper .col-md-6:eq(0)');

            function reapplyEventListeners() {
                $('.status-switch').off('change').on('change', function(event) {
                    event.preventDefault();
                    var itemId = $(this).data('item-id');
                    $('#statusChangeModal').modal('show');

                    $('.confirm-approve').off('click').on('click', function() {
                        $('#statusChangeModal').modal('hide');
                        statusUpdate(itemId);
                    });
                });
            }

            reapplyEventListeners();

            table.on('draw', function() {
                reapplyEventListeners();
            });
        });

          const vendorStatusUrlTemplate = "{{ route('supplier.updateStatus', ['itemId' => '__ID__']) }}";

    function statusUpdate(id) {
        const finalUrl = vendorStatusUrlTemplate.replace('__ID__', id);

        $.ajax({
            url: finalUrl,
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response.message);
            },
            error: function(response) {
                console.log('Error:', response);
            }
        });
    }
    </script>
@endsection
