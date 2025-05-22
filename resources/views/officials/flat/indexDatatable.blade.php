@extends('layouts.app')

@section('title', 'Flat Listing')

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
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">MIS</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Flat Details</li>
                </ol>
            </nav>
        </div>

    </div>

    <hr>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between py-3">
                <h6 class="mb-0 text-uppercase tabular-record_font align-self-end"></h6>
                <a href="{{ route('create.flat.form') }}"><button class="btn btn-primary">+ Add Flat</button></a>
            </div>
            <table id="example" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Flat No.</th>
                          {{-- Add new column floor - Lalit tiwari (19/march/2025) --}}
                          <th>Floor</th>
                        <th>Property Id</th>
                        <th>File No.</th>
                        <th>Address</th>
                        <th>Area (In Sq.Mt.)</th>
                        <th>Land Value</th>
                        <th>Builder Name</th>
                        <th>Buyer Name</th>
                        <th>Purchase Date</th>
                        <th>Present Occupant</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
    <div id="tooltip"></div>

    @include('include.loader')
    @include('include.alerts.ajax-alert')
    @include('include.alerts.delete-confirmation')

@endsection


@section('footerScript')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({
                processing: true,
                serverSide: true,
                responsive: false, // Disable responsive behavior
                scrollX: true, // Enable horizontal scroll when columns exceed container width
                ajax: {
                    url: "{{ route('get.flats') }}",
                    // data: function(d) {
                    //     d.status = $('#status').val(); // Add selected status to the request
                    // }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'flat_number',
                        name: 'flat_number'
                    },
                    {
                        data: 'floor',
                        name: 'floor'
                    },
                    {
                        data: 'property_master_id',
                        name: 'property_master_id'
                    },

                    {
                        data: 'unique_file_no',
                        name: 'unique_file_no'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'area',
                        name: 'area'
                    },
                    {
                        data: 'value',
                        name: 'value'
                    },
                    {
                        data: 'builder_developer_name',
                        name: 'builder_developer_name'
                    },
                    {
                        data: 'original_buyer_name',
                        name: 'original_buyer_name'
                    },
                    {
                        data: 'purchase_date',
                        name: 'purchase_date'
                    },
                    {
                        data: 'present_occupant_name',
                        name: 'present_occupant_name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                dom: '<"top"Blf>rt<"bottom"ip><"clear">', // Custom DOM for button and pagination positioning
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
            });
            // Trigger table reload on status filter change
            // $('#status').change(function() {
            //     table.ajax.reload();
            // });
        });

        $(document).ready(function() {
            let deleteId;

            // Trigger the modal and set the record ID
            $(document).on('click', '.delete-btn', function() {
                deleteId = $(this).data('id'); // Get the record ID from the button
                $('#ModalDelete').modal('show'); // Show the modal
            });

            // Handle delete confirmation
            $('#confirmDelete').on('click', function() {
                if (deleteId) {
                    $.ajax({
                        url: "{{ route('flat.destroy') }}",
                        type: 'POST',
                        data: {
                            deleteId: deleteId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                // Handle success response
                                $('#ModalDelete').modal('hide');
                                $('.loader_container').addClass('d-none');
                                if ($('.results').hasClass('d-none'))
                                    $('.results').removeClass('d-none');
                                showSuccess(response.message);
                                // Ensure checkbox is checked and disabled after success
                                setTimeout(function() {
                                    $('#example').DataTable().ajax.reload();
                                }, 3000); // Slight delay to ensure modal is fully hidden
                            } else {
                                // Handle success response
                                $('#ModalDelete').modal('hide');
                                $('.loader_container').addClass('d-none');
                                if ($('.results').hasClass('d-none'))
                                    $('.results').removeClass('d-none');
                                showError(response.message);
                                // Ensure checkbox is checked and disabled after success
                                setTimeout(function() {
                                    $('#example').DataTable().ajax.reload();
                                }, 100); // Slight delay to ensure modal is fully hidden
                            }
                        },
                        error: function(xhr) {
                            alert('Error: ' + xhr.responseText); // Handle errors here
                        }
                    });
                } else {
                    alert('No record selected for deletion.');
                }
            });
        });
    </script>
@endsection
