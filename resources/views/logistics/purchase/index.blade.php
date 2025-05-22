@extends('layouts.app')

@section('title', 'Purchase List')

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-editable.css') }}">
    <script src="{{ asset('assets/js/editableui.min.js') }}"></script>
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

        .unit-green {
            color: green;
        }

        .unit-red {
            color: red;
        }

        .wrap-column {
            white-space: normal !important;
            word-wrap: break-word;
        }
    </style>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Logistic</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Purchase List</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content py-3">
                <a href="{{ route('purchase.create') }}">
                    <button type="button" class="btn btn-primary px-2 mx-2">+ Add Purchase</button>
                </a>
            </div>

            <div class="table-responsive m-3">
                <table class="table table-striped table-bordered" id="myDataTable">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="10%">Purchase ID</th>
                            <th width="10%">Purchased Date</th>
                            <th width="40%" class="wrap-column">Items</th>
                            @can('purchase.action')
                                <th width="10%">Action</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchases as $loop => $purchase)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $purchase->purchase_id }}</td>
                                <td>{{ $purchase->purchased_date }}</td>
                                <td class="wrap-column">
                                    @php
                                        $items = $purchase->items
                                            ->map(function ($item) {
                                                $unit = $item->purchased_unit ?? $item->reduced_unit;
                                                $unitClass = $item->purchased_unit ? 'unit-green' : 'unit-red';
                                                return $item->logisticItem->name .
                                                    ' <span class="' .
                                                    $unitClass .
                                                    '">(' .
                                                    $unit .
                                                    ')</span>';
                                            })
                                            ->implode(', ');
                                    @endphp
                                    {!! $items !!}
                                </td>
                                @can('purchase.action')
                                    <td>
                                        <a href="{{ route('purchase.edit', $purchase->purchase_id) }}"
                                            class="btn btn-primary px-4">Edit</a>
                                        <!-- <a href="{{ route('inventory/purchase/' . $purchase->purchase_id . '/delete') }}" class="btn btn-sm btn-danger">Delete</a> -->
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        // File export Functionality by ADARSH on 20-July-2024
        $(document).ready(function() {
            var table = $('#myDataTable').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#myDataTable_wrapper .col-md-6:eq(0)');
        });
        //end here
    </script>
@endsection
