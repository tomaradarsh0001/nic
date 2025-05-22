@extends('layouts.app')

@section('title', 'Templates')

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
    </style>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Settings</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item">Application Configuration</li>
                    <li class="breadcrumb-item active" aria-current="page">Templates</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between py-3">
                <h6 class="mb-0 text-uppercase tabular-record_font align-self-end">Templates</h6>
                <a href="{{ route('templates.create') }}"><button class="btn btn-primary">+ Add Template</button></a>
            </div>
            <table id="example" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Action</th>
                        <th scope="col">Type</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Templates</th>
                        <th scope="col">Variables</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('footerScript')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                // responsive: true,
                ajax: {
                    url: "{{ route('getMessageTemplateListing') }}",
                    type: "GET",
                },
                columns: [{
                        data: null,
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Auto-increment ID based on row index
                        },
                        orderable: false, // Disable ordering on this column
                        searchable: false // Disable searching on this column
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'template',
                        name: 'template'
                    },
                    {
                        data: 'variables',
                        name: 'variables'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'userAction',
                        name: 'userAction'
                    }
                ],
                dom: '<"top"Blf>rt<"bottom"ip><"clear">', // Custom DOM for button and pagination positioning
                buttons: ['csv', 'excel', 'pdf'],
                scrollX: true
            });

            // Filter button click event
            $('#filter').click(function() {
                table.draw(); // Redraw the DataTable to apply the date filters
            });
        });
    </script>
@endsection
