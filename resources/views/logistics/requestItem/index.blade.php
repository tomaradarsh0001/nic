@extends('layouts.app')

@section('title', 'Items Index')

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

        .badge {
            font-weight: 500 !important;
        }
    </style>

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Logistic Management</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users Request List</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content py-3">
                <a href="{{ route('issued_item.create') }}">
                    <button type="button" class="btn btn-primary px-2 mx-2">+ Issue Item</button>
                </a>
            </div>
            <div class="table-responsive m-3">
                <table class="table table-striped table-bordered" id="myDataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Request ID</th>
                            <th>Requested Item List</th>
                            <th>Issued Units</th>
                            <th>Status</th>
                            <th>Request Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logisticRequests as $requestId => $requests)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $requestId }}</td>
                                <td>
                                    @php
                                        $itemDetails = $requests
                                            ->map(function ($request) {
                                                return $request->logisticItem->name .
                                                    ' (' .
                                                    $request->requested_units .
                                                    ')';
                                            })
                                            ->implode(', ');
                                    @endphp
                                    {{ $itemDetails }}
                                </td>
                                <td>
                                    @php
                                        // Display issued_units only if status is Approved
                                        $issuedUnits = $requests
                                            ->map(function ($request) {
                                                return $request->status === 'Approved' ? $request->issued_units : null;
                                            })
                                            ->filter()
                                            ->implode(', ');
                                    @endphp
                                    {{ $issuedUnits ?: 'N/A' }}
                                </td>
                                <td>
                                    @if ($requests->first()->status == 'Approved')
                                        <span class="badge bg-success">{{ $requests->first()->status }}</span>
                                    @elseif ($requests->first()->status == 'Rejected')
                                        <span class="badge bg-danger">{{ $requests->first()->status }}</span>
                                    @else
                                        <span class="badge bg-secondary text-light">{{ $requests->first()->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $requests->first()->created_at->format('Y-m-d') }}</td>
                                @php
                                    $firstRequestStatus = $requests->first()->status;
                                @endphp
                                <td>
                                    @if (!in_array($firstRequestStatus, ['Approved', 'Rejected']))
                                        <a href="{{ route('request.create', ['requestId' => $requestId]) }}">
                                            <button class="btn btn-primary">Take Action</button>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#myDataTable').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#myDataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
