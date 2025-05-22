@extends('layouts.app')

@section('title', 'Stock History')

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
                    <li class="breadcrumb-item active" aria-current="page">Stock History</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->

    <hr>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end py-3">
                <a href="{{ route('purchase.index') }}">
                    <button type="button" class="btn btn-danger px-2 mx-2 ">← Back</button>
                </a>
            </div>

            <table id="example" class="display nowrap table table-striped table-bordered" style="width:100%">
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
                        <th scope="col">Created at</th>
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
                    url: "{{ route('get.logistic.histories') }}",
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
                        data: 'logistic_item',
                        name: 'logistic_item'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'purchase_id',
                        name: 'purchase_id'
                    },
                    {
                        data: 'request_id',
                        name: 'request_id'
                    },
                    {
                        data: 'available_units',
                        name: 'available_units'
                    },
                    {
                        data: 'reduced_units',
                        name: 'reduced_units'
                    },
                    {
                        data: 'last_units',
                        name: 'last_units'
                    },
                    {
                        data: 'last_added_units',
                        name: 'last_added_units'
                    },
                    {
                        data: 'last_added_date',
                        name: 'last_added_date'
                    },
                    {
                        data: 'last_reduced_units',
                        name: 'last_reduced_units'
                    },
                    {
                        data: 'last_reduced_date',
                        name: 'last_reduced_date'
                    },
                    {
                        data: 'issued_units',
                        name: 'issued_units'
                    },
                    {
                        data: 'issued_to_users',
                        name: 'issued_to_users'
                    },
                    {
                        data: 'issued_by',
                        name: 'issued_by'
                    },
                    {
                        data: 'issued_at',
                        name: 'issued_at'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },

                ],
                dom: '<"top"Blf>rt<"bottom"ip><"clear">',
                buttons: ['csv', 'excel', 'pdf']
            });
        });
    </script>

@endsection
