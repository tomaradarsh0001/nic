@extends('layouts.app')

@section('title', 'Issued Item List')

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
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->

    <hr>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content py-3">
                <a href="{{ route('issued_item.create') }}">
                    <button type="button" class="btn btn-primary px-2 mx-2">+ Issue Item</button>
                </a>
            </div>

            <table id="example" class="display nowrap " style="width:100%">
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
                    url: "{{ route('get.logistic.request.items') }}",
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
                        data: 'request_id',
                        name: 'request_id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'request_item_list',
                        name: 'request_item_list'
                    },
                    {
                        data: 'issued_units',
                        name: 'issued_units'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'request_date',
                        name: 'request_date'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ],
                dom: '<"top"Blf>rt<"bottom"ip><"clear">',
                buttons: ['csv', 'excel', 'pdf']
            });
        });
    </script>

@endsection
