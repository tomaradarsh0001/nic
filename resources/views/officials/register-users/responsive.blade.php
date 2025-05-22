@extends('layouts.app')
@section('title', 'Register User Listing')
@section('content')
    <!-- Include CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.4/css/buttons.bootstrap5.min.css" />

    <style>
        .btn-group {
            display: table;
        }

        /* Ensure word wrap in the Remarks column */
        #newPropertyDatatable td.wrap-text {
            white-space: normal;
            word-wrap: break-word;
            max-width: 30px; /* Adjust as per your design */
        }

        /* Ensure both elements are on the same line */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px; /* Adjust spacing as needed */
        }

        /* Align the elements properly */
        .dataTables_wrapper .dataTables_length {
            margin-right: 70%; /* Adjust spacing between length and search box */
        }

        /* Align the buttons */
        .dataTables_wrapper .dataTables_buttons {
            display: inline-block;
            vertical-align: middle;
        }

        .dataTables_length {
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Registrations</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Registration Applications List</li>
                </ol>
            </nav>
        </div>
    </div>

    <hr>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="registerUserDatatable">
                    <thead>
                        <tr>
                            <th>Serial No.</th>
                            <th>Registration No.</th>
                            <th>Name</th>
                            <th>Property Details</th>
                            <th>Registration Type</th>
                            <th>Purpose Of Registration</th>
                            <th>Documents</th>
                            <th>Remarks</th>
                            <th>
                                <select class="form-control" name="status" id="status" style="font-weight: bold;">
                                    <option value="">Status</option>
                                    @foreach ($items as $item)
                                        <option class="text-capitalize" value="{{ $item->id }}">{{ $item->item_name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="tooltip"></div>
@endsection

@section('footerScript')
    <!-- Include JS Files -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script src="https://cdn.datatables.net/2.1.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.4/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.4/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#registerUserDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('regiserUserListings') }}",
                    data: function(d) {
                        d.status = $('#status').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'applicant_number', name: 'applicant_number' },
                    { data: 'name', name: 'name' },
                    { data: 'property_details', name: 'property_details' },
                    { data: 'user_type', name: 'user_type' },
                    { data: 'purpose_of_registation', name: 'purpose_of_registation' },
                    { 
                        data: 'documents', 
                        name: 'documents', 
                        orderable: false, 
                        searchable: false,
                        render: function(data, type, row) {
                            let documentLinks = '';
                            $.each(data, function(key, doc) {
                                if (doc) {
                                    let docParts = doc.split('/');
                                    let docName = docParts[docParts.length - 1];
                                    let docUrl = "{{ asset('storage/') }}/" + doc;
                                    documentLinks += "<span><i class='bx bx-chevron-right'></i> " +
                                        "<a href='" + docUrl +
                                        "' target='_blank' class='link-primary'>" +
                                        docName + "</a></span><br>";
                                }
                            });
    
                            return '<a href="javascript:void(0);" class="text-danger pdf-icons" data-bs-toggle="tooltip" data-bs-html="true"><i class="bx bxs-file-pdf fs-4"></i></a><div class="tooltip-data">' +
                                documentLinks + '</div>';
                        }
                    },
                    { 
                        data: 'remark', 
                        name: 'remark', 
                        orderable: false, 
                        searchable: false,
                        render: function(data, type, row) {
                            return '<div class="text-wrap">' + data + '</div>';
                        }
                    },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                dom: '<"top"Blf>rt<"bottom"ip><"clear">', // Custom DOM for button and pagination positioning
                buttons: [
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                header: function(data, columnIdx) {
                                    return $(data).text().trim(); // Strips HTML tags from headers
                                }
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                header: function(data, columnIdx) {
                                    return $(data).text().trim(); // Strips HTML tags from headers
                                }
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                header: function(data, columnIdx) {
                                    return $(data).text().trim(); // Strips HTML tags from headers
                                }
                            }
                        }
                    }
                ],
                lengthMenu: [10, 25, 50, 100, 500], // Pagination options
                responsive: true,
                createdRow: function(row, data, dataIndex) {
                    // Apply classes to the specific column (assuming documents is the 6th column)
                    $('td', row).eq(6).addClass('view-hover-data show-toggle-data');
                },
                drawCallback: function(settings) {
                    // Initialize tooltips
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
    
            // Optional: Reload data on status change
            $('#status').change(function() {
                table.draw();
            });
        });
    </script>
    
@endsection
