@extends('layouts.app')

@section('title', 'Purchase List')

@section('content')
    <style>
        div.dt-buttons {
            float: none !important;
            width: 19%;
        }

        div.dt-buttons.btn-group {
            margin-bottom: 20px;
        }

        div.dt-buttons.btn-group .btn {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 4px;
        }

        /* Ensure responsiveness on smaller screens */
        @media (max-width: 768px) {
            div.dt-buttons.btn-group {
                flex-direction: column;
                align-items: flex-start;
            }

            div.dt-buttons.btn-group .btn {
                width: 100%;
                text-align: left;
            }
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
    <!--breadcrumb-->
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
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->

    <hr>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content py-3">
                <a href="{{ route('purchase.create') }}">
                    <button type="button" class="btn btn-primary px-2 mx-2">+ Add Purchase</button>
                </a>
            </div>

            <table id="example" class="display nowrap" style="width:100%">
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
            </table>
        </div>
    </div>


@endsection
@section('footerScript')
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('get.purchase.items') }}",
                    type: "GET",
                },
                columns: [{
                        data: null,
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Auto-increment ID based on row index
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'purchase_id',
                        name: 'purchase_id'
                    },
                    {
                        data: 'purchased_date',
                        name: 'purchased_date'
                    },
                    {
                        data: 'items',
                        name: 'items',
                        orderable: false,
                        searchable: false
                    },
                    @can('purchase.action')
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    @endcan
                ],
                dom: '<"top"Blf>rt<"bottom"ip><"clear">',
                buttons: ['csv', 'excel', 'pdf']
            });
        });
    </script>

@endsection
