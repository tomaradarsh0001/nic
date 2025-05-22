@extends('layouts.app')

@section('title', 'Application Listing')

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


    .alertDot {
        width: 9px;
        height: 9px;
        background-color: #007bff;
        border-radius: 50%;
        box-shadow: 0 0 10px #007bff, 0 0 20px #007bff, 0 0 30px #007bff;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 10px #007bff, 0 0 20px #007bff, 0 0 30px #007bff;
        }

        50% {
            transform: scale(1.2);
            box-shadow: 0 0 15px #007bff, 0 0 30px #007bff, 0 0 45px #007bff;
        }

        100% {
            transform: scale(1);
            box-shadow: 0 0 10px #007bff, 0 0 20px #007bff, 0 0 30px #007bff;
        }
    }
</style>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Applications</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Applications List</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>

<hr>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-end">
            <ul class="d-flex gap-3">
                <li class="list-group-item d-flex gap-2 align-items-center flex-wrap">
                    <div class="alertDot"></div>
                    <span class="text-secondary">Have To Take Action</span>
                </li>
                <li class="list-group-item d-flex gap-2 align-items-center flex-wrap">
                    <i class="lni lni-spellcheck fs-5" style="color:#6610f2"></i>
                    <span class="text-secondary">Mis Is Checked</span>
                </li>
                <li class="list-group-item d-flex gap-2 align-items-center flex-wrap">|</li>
                <li class="list-group-item d-flex gap-2 align-items-center flex-wrap">
                    <i class="fadeIn animated bx bx-file-find fs-5" style="color:#20c997"></i>
                    <span class="text-secondary">Scanned Files Checked</span>
                </li>
                <li class="list-group-item d-flex gap-2 align-items-center flex-wrap">|</li>
                <li class="list-group-item d-flex gap-2 align-items-center flex-wrap">
                    <i class="lni lni-cloud-upload fs-5" style="color:#fd7e14"></i>
                    <span class="text-secondary">Uploaded Documents Checked</span>
                </li>
            </ul>
        </div>
        <table id="example" class="display nowrap applicant_list_table" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Applicant No.</th>
                    <th>Property ID</th>
                    <th>Locality</th>
                    <th>Block</th>
                    <th>Plot No.</th>
                    <th>Flat No. (ID)</th>
                    <th>Known As</th>
                    <th>Section</th>
                    <th>Applied For</th>
                    <th>Activity</th>
                    <th>
                        <select class="form-control form-select form-select-sm" name="status" id="status"
                            style="font-weight: bold;">
                            <option value="">Status</option>
                            @foreach ($items as $item)
                            <option class="text-capitalize" value="{{ $item->id }}" @if ($getStatusId==$item->id)
                                @selected(true)
                                @endif>{{ $item->item_name }}
                            </option>
                            @endforeach
                        </select>
                    </th>
                    <th>Applied At</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

    </div>
</div>
<div id="tooltip"></div>

<div class="modal fade" id="fileMovementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="">
                    <h5 class="modal-title">File Movement</h5>
                    <div class="my-2">Presently Known as: <span  id="movPresentlyKnown"></span></div>
                    <div>Application Type: <span class="badge bg-info mx-1" id="movapplictionTye"></span></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a target="_blank" href=""><button type="button" class="btn btn-primary">View More</button></a>
            </div>
        </div>
    </div>
</div>

@include('include.alerts.application.schedule-meeting-link-application')
@include('include.alerts.ajax-alert')
@endsection


@section('footerScript')

<script type="text/javascript">
    function getFileMovement(applicationNo, button) {
        $(button).prop('disabled', true);
        $(button).html('Fetching...');
        $.ajax({
            url: "{{ route('applications.get.movements')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                _token: '{{ csrf_token() }}',
                applicationNo: applicationNo,
            },
            success: function(response) {
                console.log(response);
                
                if (response.status === true) {
                    let htmlContent = '';
                    let color = '';
                    let statusValue = '';
                    response.data.forEach(item => {
                        statusValue = item.action ? item.action : '';
                        color = getColor(statusValue);
                        // console.log(statusValue, color)
                        htmlContent += `
                                <div class="col">
                                    <div class="card radius-15">
                                        <div class="card-body">
                                            <div class="float-end text-muted">${item.created_at}</div>
                                           <p class="card-text">
                                                Action:- <span class="fs-6 badge rounded-pill p-2 text-uppercase px-3 ${color}">${item.action ? item.action : item.status}</span>
                                            </p>
                                             <p class="card-title text-muted">${item.assigned_by} <span style="
                                                font-size: 15px;
                                                font-weight: 500;
                                                font-style: italic;
                                                color: #259965;
                                            ">(${item.assigned_by_role})</span></p>
                                            ${item.remark ? 
                                                `<p class="card-text">
                                                    <b>Remark:-</b> <span>${item.remark}</span>
                                                </p>` 
                                                : ""
                                            }
                                        </div>
                                    </div>
                                </div>
                            `;
                    });

                    // Set the generated HTML content into the modal-body
                    $('#fileMovementModal .modal-body').html(htmlContent);
                    $('#fileMovementModal .modal-title').html('File Movement (' + applicationNo + ')');
                    $('#fileMovementModal #movapplictionTye').html(response.applicationType);
                    $('#fileMovementModal #movPresentlyKnown').html(response.presentlyKnownAs);
                    

                    /** code modified by Nitin to fix - viewMoreUrl containing url for only once. it was not updating for second time onwards */
                    let viewMoreUrl = "{{ route('applications.movements', ['appNo' => '__appNo__']) }}";
                    

                    viewMoreUrl = viewMoreUrl.replace('__appNo__', applicationNo);
                    
                    $('#fileMovementModal a').attr('href', viewMoreUrl);

                    $('#fileMovementModal').modal('show');
                    $(button).prop('disabled', false);
                    $(button).html('File Movement');
                } else {
                    $(button).prop('disabled', false);
                    $(button).html('File Movement');
                }

                //     showSuccess(response.message,window.location.href)
                // } else {
                //     error.html(response.details)
                //     button.prop('disabled', false);
                //     button.html('Approve');
                // }
            },

        });

    }

    function getColor(status) {
        let color;
        switch (status) {
            case 'New Application':
                color = 'text-primary bg-light-primary'; // Assign color for "New Application"
                break;
            case 'Object':
                color = 'text-warning bg-light-warning'; // Assign color for "In Progress"
                break;
            case 'Recommend':
                color = 'text-primary bg-light-primary'; // Assign color for "Completed"
                break;
            case 'Rejected':
                color = 'red'; // Assign color for "Rejected"
                break;
            default:
                color = 'text-primary bg-light-primary'; // Default color for unknown status
                break;
        }
        return color;
    }
    $(document).ready(function() {
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            // responsive: false,
            ajax: {
                url: "{{ route('admin.getApplicationsAssignedToUser') }}",
                data: function(d) {
                    d.status = $('#status').val(); // Add selected status to the request
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'application_no',
                    name: 'application_no'
                },
                {
                    data: 'old_property_id',
                    name: 'old_property_id'
                },
                {
                    data: 'new_colony_name',
                    name: 'new_colony_name'
                },
                {
                    data: 'block_no',
                    name: 'block_no'
                },
                {
                    data: 'plot_or_property_no',
                    name: 'plot_or_property_no'
                },
                {
                    data: 'flat_id',
                    name: 'flat_id'
                },
                {
                    data: 'presently_known_as',
                    name: 'presently_known_as'
                },
                {
                    data: 'section',
                    name: 'section'
                },
                {
                    data: 'applied_for',
                    name: 'applied_for',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'activity',
                    name: 'activity',
                    render: function(data, type, row) {
                        console.log(data);

                        let mis = $('<div>').text(data.mis).html();
                        let scannedFiles = $('<div>').text(data.scanned_files).html();
                        let uploadedDoc = $('<div>').text(data.uploaded_doc).html();
                        console.log(mis, scannedFiles, uploadedDoc);
                        let misCheckedBy = data.mis_checked_by || '';
                        let scanFileCheckedBy = data.scan_file_checked_by || '';
                        let uploadedDocCheckedBy = data.uploaded_doc_checked_by || '';
                        let misColor = data.mis_color_code || '';
                        let scannedFilesColor = data.scan_file_color_code || '';
                        let uploadedDocColor = data.uploaded_doc_color_code || '';

                        let misHtml = mis == 1 ? `<div class="list-inline-item d-flex align-items-center">
            <i class="lni lni-spellcheck fs-5" style="color:${misColor}"></i> <span class="px-2 fst-italic">${misCheckedBy}</span></div>` : '';

                        let scannedFilesHtml = scannedFiles == 1 ?
                            `<div class="list-inline-item d-flex align-items-center pt-1">
            <i class="fadeIn animated bx bx-file-find fs-5" style="color:${scannedFilesColor}"></i><span class="px-2 fst-italic">${scanFileCheckedBy}</span></div>` : '';

                        let uploadedDocHtml = uploadedDoc == 1 ?
                            `<div class="list-inline-item d-flex align-items-center pt-1">
            <i class="lni lni-cloud-upload fs-5" style="color:${uploadedDocColor}"></i> <span class="px-2 fst-italic">${uploadedDocCheckedBy}</span></div>` : '';

                        return `<div>
                            ${misHtml}
                            ${scannedFilesHtml}
                            ${uploadedDocHtml}
                        </div>`;
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            dom: '<"top"Blf>rt<"bottom"ip><"clear">', // Custom DOM for buttons and pagination
            buttons: ['csv', 'excel', 'pdf'], // Export buttons
            scrollX: true, // Enable horizontal scrolling
            createdRow: function(row, data, dataIndex) {
                // Adding dynamic IDs to the 'status' and 'action' columns
                $('td', row).eq(6).attr('id', 'status-' + data.id); // Status column
                $('td', row).eq(7).attr('id', 'action-' + data.id); // Action column
            }
        });
        $('#status').change(function() {
            table.ajax.reload();
        });

    });




    /* Send Meeting Link To Applicant*/
    let applicationId = null;
    let applicationNo = null;
    let applicationModelName = null;

    $(document).on('click', '.send-meeting-link', function() {
        applicationId = $(this).data('application-id');
        applicationNo = $(this).data('application-no');
        applicationModelName = $(this).data('application-model_name');
        $('#sendMeetingLinkConfirmationModal').modal('show'); // Show the confirmation modal
    });

    $('#confirmSendMeetingLink').on('click', function() {
        if (applicationId && applicationNo && applicationModelName) {
            $('#confirmSendMeetingLink').prop('disabled', true).text('Sending...');
            $.ajax({
                url: "{{ route('applications.send.appointment.link')}}",
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    applicationId: applicationId,
                    applicationNo: applicationNo,
                    applicationModelName: applicationModelName,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('#confirmSendMeetingLink').prop('disabled', false).text('Confirm');
                        $('#sendMeetingLinkConfirmationModal').modal('hide');
                        showSuccess(response.message);
                    } else {
                        showError(response.message);
                    }
                },
                error: function(xhr) {
                    showError('An error occurred while sending the meeting link.');
                }
            });
        }
    });
</script>
@endsection
