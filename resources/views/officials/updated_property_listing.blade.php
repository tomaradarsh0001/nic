@extends('layouts.app')

@section('title', 'Mis Update Request')

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

        /*.status-block {
                border: 1px solid #FFFFFF;
                text-align: center;
                vertical-align: middle;
                float: right !important;
            }

            .status-circle {
                background: #297373 !important ;
                border-radius: 200px;
                color: white;
                height: 20px;
                width: 20px;
                display: table;
            }

            .status-circle p {
                vertical-align: middle;
                display: table-cell;
            }*/

        .badge {
            align-items: center;
            gap: 5px;
        }

        .status-circle {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            font-size: 14px;
            font-weight: bold;
        }

        .status-circle p {
            margin: 0;
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
                    <li class="breadcrumb-item active" aria-current="page">Update Request List</li>
                </ol>
            </nav>
        </div>
        <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
    </div>

    <hr>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between py-3">
                <h6 class="mb-0 text-uppercase tabular-record_font align-self-end"></h6>
            </div>
            <table id="example" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>PID</th>
                        <th>Application Type</th>
                        <th>Section</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
    <div id="tooltip"></div>
    @include('include.loader')
    @include('include.alerts.ajax-alert')
    @include('include.alerts.edit-permission')
@endsection


@section('footerScript')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('get.update.property.details.list') }}",
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'property_id',
                        name: 'property_id'
                    },
                    {
                        data: 'service_type',
                        name: 'service_type'
                    },
                    {
                        data: 'section_code',
                        name: 'section_code'
                    },
                    {
                        data: 'request',
                        name: 'request',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            let {
                                createdBy,
                                isActive,
                                permissionAt,
                                permissionBy,
                                permissionTo,
                                remarks,
                                totalRequest,
                                permission_asked_by
                            } = data;
                            console.log(totalRequest);

                            // Escape HTML for remarks and assignedBy
                            remarks = remarks ? $('<div>').text(remarks).html() : '';
                            let assignedBy = permission_asked_by ? $('<span>').text(
                                permission_asked_by).html() : 'N/A';

                            // Limit remarks to 20 characters with ellipsis for display
                            let truncatedRemarks = remarks.length > 20 ? remarks.substring(0, 20) +
                                '...' : remarks;

                            // Tooltip content for full remarks on hover
                            let tooltipContent = remarks ?
                                `Remarks: ${remarks} ( By ${assignedBy})` : '';

                            // Handle conditional rendering
                            if (!createdBy || (isActive == 0 && !permissionAt && !permissionBy && !
                                    permissionTo && !remarks)) {
                                return '';
                            } else if (createdBy && !isActive && !permissionAt && permissionTo &&
                                remarks) {
                                return `
                                    <div data-bs-toggle="tooltip" data-bs-html="true" title="${tooltipContent}" class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3">Edit Request 
                                        <div class="status-circle" style="background-color: #ffc107; color: #000;">
                                            <p>${totalRequest}</p>
                                        </div>
                                    </div>
                                    <div class="remarks-section">
                                        <span>${truncatedRemarks}</span><br>
                                        <span class="text-muted small">(${assignedBy})</span>
                                    </div>`;
                            } else if (createdBy && permissionAt && permissionBy &&
                                permissionTo && remarks) {
                                return `<div data-bs-toggle="tooltip" data-bs-html="true" title="${tooltipContent}" class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">Request Granted </div>
                                        <div class="remarks-section">
                                            <span>${truncatedRemarks}</span><br>
                                            <span class="text-muted small">(${assignedBy})</span>
                                        </div>`;
                            }
                            return '';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: '<"top"Blf>rt<"bottom"ip><"clear">', // Custom DOM for button and pagination positioning
                buttons: ['csv', 'excel', 'pdf'],
            });
        });



        // Handle Edit Permission button click
        $(document).on('click', '.edit-permission-btn', function() {
            var sectionMisHistoryId = $(this).data('section-mis-history-id');
            var serviceType = $(this).data('service-type');
            var modelId = $(this).data('model-id');

            // Populate the modal fields with the property data
            $('#sectionMisHistoryId').val(sectionMisHistoryId);
            $('#serviceType').val(serviceType);
            $('#modelId').val(modelId);


        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Handle Save changes button click
        $('#savePermissionChanges').click(function() {
            var formData = $('#editPermissionForm').serialize();
            // Perform an AJAX request to save the permission changes
            $.ajax({
                url: "{{ route('allow.edit.permission') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Handle success (e.g., close modal, reload table, show a success message)
                    // $('#editPermissionModal').modal('hide');
                    // $('#example').DataTable().ajax.reload();
                    if(response.status == 'success'){
                            // Handle success response
                            $('#editPermissionModal').modal('hide');
                            $('.loader_container').addClass('d-none');
                            if ($('.results').hasClass('d-none'))
                                $('.results').removeClass('d-none');
                            showSuccess(response.message);
                            // Ensure checkbox is checked and disabled after success
                            setTimeout(function() {
                                $('#example').DataTable().ajax.reload();
                            }, 500); // Slight delay to ensure modal is fully hidden
                        } else {
                            // Handle success response
                            $('#editPermissionModal').modal('hide');
                            $('.loader_container').addClass('d-none');
                            if ($('.results').hasClass('d-none'))
                                $('.results').removeClass('d-none');
                            showError(response.message);
                            // Ensure checkbox is checked and disabled after success
                            setTimeout(function() {
                                location.reload();
                            }, 100); // Slight delay to ensure modal is fully hidden
                        }
                },
                error: function(response) {
                    // Handle error
                    console.log(response);
                }
            });
        });
    </script>
@endsection
