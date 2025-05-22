@extends('layouts.app')

@section('title', 'Stock History')

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
                    <li class="breadcrumb-item active" aria-current="page">Stock History</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end py-3">
                <a href="{{ route('purchase.index') }}">
                    <button type="button" class="btn btn-danger px-2 mx-2">← Back</button>
                </a>
            </div>
            <!-- <h6 class="mb-0 text-uppercase tabular-record_font pb-4 m-3">History</h6> -->
            <table class="table table-striped table-bordered" id="myDataTable">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Logistic Item</th>
                        <th scope="col">Category</th>
                        <th scope="col">Purchase ID</th>
                        <th scope="col">Request ID</th>
                        <th scope="col">Available Units</th>
                        <th scope="col">Reduced Units</th>
                        <th scope="col">Last Units</th>
                        <th scope="col">Last Added Units</th>
                        <th scope="col">Last Added Date</th>
                        <th scope="col">Last Reduced Units</th>
                        <th scope="col">Last Reduced Date</th>
                        <th scope="col">Issued Units</th>
                        <th scope="col">Issued to User</th>
                        <th scope="col">Issued by</th>
                        <th scope="col">Issued at</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($history as $key => $item)
                        <tr class="">
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $item->logisticItem->name ?? '' }}</td>
                            <td>{{ $item->logisticCategory->name ?? '' }}</td>
                            <td>{{ $item->purchase ? $item->purchase->purchase_id : '' }}</td>
                            <td>{{ $item->logisticRequest ? $item->logisticRequest->request_id : '' }}</td>
                            <td>{{ $item->available_units }}</td>
                            <td>{{ $item->purchase ? $item->purchase->reduced_unit : '' }}</td>
                            <td>{{ $item->last_units }}</td>
                            <td>{{ $item->last_added_units }}</td>
                            <td>{{ $item->last_added_date }}</td>
                            <td>{{ $item->last_reduced_units ?? '' }}</td>
                            <td>{{ $item->last_reduced_date ?? '' }}</td>
                            <td>{{ $item->issued_units ?? '' }}</td>
                            <td>{{ $item->issuedToUser->name ?? '' }}</td>
                            <td>{{ $item->issuedBy->name ?? '' }}</td>
                            <td>{{ $item->issued_at }}</td>
                            <td>{{ $item->action }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var table = $('#myDataTable').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'print']
            });

            table.buttons().container()
                .appendTo('#myDataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
