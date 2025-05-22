@extends('layouts.app')
@section('title', 'Register Users')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <style>
        .pagination .active a {
            color: #ffffff !important;
        }

        .pdf-icon {
            cursor: pointer;
            display: inline-block;
        }

        .pdf-icon .fa-file-pdf {
            font-size: 18px;
            color: red;
        }
    </style>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">USER APPLICATIONS</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Reviews</li>
                </ol>
            </nav>
        </div>
    </div>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date" class="form-label">Filter By Status</label>
                        <select class="form-control" name="status" id="status">
                            {{-- <option value="new" selected>New</option> --}}
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="pending">Pending</option>
                            <option value="review" selected>Under Review</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-1 align-self-end">
                    <div class="form-group">
                        <button id="filter" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered data-table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Application No.</th>
                            <th>Service Type</th>
                            <th>Assigned By</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('footerScript')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/moment.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('reviewApplicationsListings') }}",
                    data: function(d) {
                        d.search = $('input[type="search"]').val();
                        d.status = $('#status').val();
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'application_no',
                        name: 'application_no'
                    },
                    {
                        data: 'service_type',
                        name: 'service_type'
                    },
                    {
                        data: 'assigned_by',
                        name: 'assigned_by'
                    },
                    {
                        data: 'remarks',
                        name: 'remarks'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                    // {
                    //     data: 'description',
                    //     name: 'description',
                    //     render: function(data, type, row, meta) {
                    //         return data;
                    //     }
                    // },
                    // {
                    //     data: 'created_at',
                    //     name: 'created_at',
                    //     render: function(data, type, row, meta) {
                    //         return moment(data).format('DD/MM/YYYY HH:mm:ss');
                    //     }
                    // },
                    //   {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                // // Initialize tooltips
                // initComplete: function() {
                //     $('[data-toggle="tooltip"]').tooltip();
                // }
            });
            $('#filter').click(function() {
                table.draw();
            });
            // $(".searchEmail").keyup(function() {
            //     table.draw();
            // });

        });

       
        $(document).ready(function() {
           
            // Event delegation for dynamically added elements by lalit on 01/08-2024 for remarks validation
            $(document).on('click', '.confirm-reject-btn', function(event) {
                event.preventDefault();

                var form = $(this).closest('form');
                var remarksInput = form.find('input[name="remarks"]');
                // var remarksValue = remarksInput.val().trim();
                var remarksValue = remarksInput.val();
                var errorLabel = form.find('.error-label');

                if (remarksValue === '') {
                    // Show the error label if remarks are empty
                    if (errorLabel.length === 0) {
                        // If the error label doesn't exist, create it
                        form.find('.input-class-reject').append(
                            '<div class="error-label text-danger mt-2">Please enter remarks for rejection.</div>'
                        );
                    } else {
                        // If the error label exists, just show it
                        errorLabel.show();
                    }
                } else {
                    // Hide the error label and submit the form
                    if (errorLabel.length > 0) {
                        errorLabel.hide();
                    }
                    form.submit();
                }
            });
        });
    </script>
@endsection
