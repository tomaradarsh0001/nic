@extends('layouts.app')

@section('title', 'Users List')

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
    <div>
        <div class="col pt-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex pb-5 justify-content-between">
                        <a href="{{ route('users.create') }}" class="btn btn-primary">+ Add User</a>

                        <div class="d-flex gap-3">
                            @haspermission('view role')
                                <a href="{{ route('roles.index') }}" class="btn btn-info">Roles</a>
                            @endhaspermission
                        
                            @haspermission('view permission')
                                <a href="{{ route('permissions.index') }}" class="btn btn-warning">Permissions</a>
                            @endhaspermission
                        </div>
                        
                    </div>
                    <h6 class="mb-0 text-uppercase tabular-record_font pb-4">Users</h6>
                    <table id="example" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Roles</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
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
                    url: "{{ route('getUserList') }}",
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'roles',
                        name: 'roles'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },

                ],
                dom: '<"top"Blf>rt<"bottom"ip><"clear">',
                buttons: ['csv', 'excel', 'pdf']
            });
        });
    </script>

@endsection
