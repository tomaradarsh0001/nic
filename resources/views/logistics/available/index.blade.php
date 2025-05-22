@extends('layouts.app')

@section('title', 'Available Stock')

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
                    <li class="breadcrumb-item active" aria-current="page">Available Stock</li>
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
            <!-- <h6 class="mb-0 text-uppercase tabular-record_font pb-4 m-3">Available Stock</h6> -->
            <table class="table mx-3 table table-striped table-bordered" id="myDataTable">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Logistic Item</th>
                        <th scope="col">Avialable Units</th>
                        <th scope="col">Used Units</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($available as $key => $item)
                        <tr class="">
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $item->logisticItem ? $item->logisticItem->name : 'N/A' }}</td>
                            <td>{{ $item->available_units ? $item->available_units : 0 }}</td>
                            <td>{{ $item->used_units ? $item->used_units : 0 }}</td>
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
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#myDataTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
