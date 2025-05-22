@extends('layouts.app')

@section('title', 'Appointments List')

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


    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 10px #CC5500, 0 0 20px #CC5500, 0 0 30px #CC5500;
        }
        50% {
            transform: scale(1.2);
            box-shadow: 0 0 15px #CC5500, 0 0 30px #CC5500, 0 0 45px #CC5500;
        }
        100% {
            transform: scale(1);
            box-shadow: 0 0 10px #CC5500, 0 0 20px #CC5500, 0 0 30px #CC5500;
        }
    }


</style>

<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Appointments</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Appointment List</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-end">
            <ul class="d-flex gap-3">
                <li class="list-group-item d-flex gap-2 align-items-center flex-wrap">
                    <div class="dot orange"></div>
                    <span class="text-secondary">Have To Take Action</span>
                </li>
            </ul>
        </div>
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Meeting Purpose</th>
                    <th>Meeting Date & Time</th>
                    <th>Meeting Attendance</th>
                   
                    <th>
                        <select class="form-control form-select form-select-sm" id="statusSelect" name="status">
                            <option value="">All</option>
                            <option value="Approved" selected>Approved</option>
                            <option value="Completed">Completed</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Include the attendance confirmation modal -->
@include('include.alerts.appointment-attendance-confirmation')
@include('include.attendanceRemarkModal')
@include('include.alerts.reject-confirmation')
@include('include.remark')

@endsection

@section('footerScript')

<script>
    let selectedAppointmentId = null;

    function openRejectConfirmationModal(appointmentId) {
        selectedAppointmentId = appointmentId;
        const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
        rejectModal.show();
    }

    document.querySelector('.confirm-reject').addEventListener('click', function() {
        const rejectModal = bootstrap.Modal.getInstance(document.getElementById('rejectModal'));
        rejectModal.hide();

        const rejectReasonModal = new bootstrap.Modal(document.getElementById('rejectReasonModal'));
        rejectReasonModal.show();
    });

    document.querySelector('.submit-reason').addEventListener('click', function() {
        const reasonInput = document.getElementById('rejectionReason');
        const reasonError = document.getElementById('rejectionReasonError');
        const reason = reasonInput.value.trim();
        const submitButton = this;

        if (reason) {
            reasonError.style.display = 'none';
            submitButton.disabled = true;
            submitButton.innerText = 'Submitting...';

            updateStatus(selectedAppointmentId, 'Rejected', reason);
        } else {
            reasonError.style.display = 'block';
            reasonInput.focus();
        }
    });

    function updateStatus(appointmentId, status, reason) {
        fetch(`/appointments/update-status/${appointmentId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: status,
                    remark: reason
                })
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    throw new Error('Failed to update status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.querySelector('.submit-reason').disabled = false;
                document.querySelector('.submit-reason').innerText = 'Submit';
            });
    }

    $(document).ready(function() {
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [[1, 'desc']],
            ajax: {
                url: "{{ route('get.appointments') }}",
                data: function(d) {
                    d.status = $('#statusSelect').val();
                }
            },
            columns: [
                {
                    data: null,
                    name: 'id',
                    render: function (data, type, row, meta) {
                        // Calculate the row number
                        let rowNumber = meta.row + meta.settings._iDisplayStart + 1;

                        // Check if the orange dot should be displayed
                        // let orangeDot = row.show_orange_dot
                        //     ? '<span class="dot orange" style="height: 10px; width: 10px; background-color: orange; border-radius: 50%; display: inline-block; margin-right: 5px;"></span>'
                        //     : '';

                        // Return the row number with the optional orange dot
                        return `${rowNumber}`;
                    },
                    searchable: false,
                    orderable: false
                },
                // { data: 'id', name: 'id' },
                {
                    data: 'unique_id',
                    name: 'unique_id',
                    render: function (data, type, row) {
                        // Check if the orange dot should be displayed
                        let orangeDot = row.show_orange_dot
                            ? '<span class="dot orange" style="height: 10px; width: 10px; border-radius: 50%; display: inline-block; margin-right: 5px;"></span>'
                            : '';

                        // Return the unique_id with the optional orange dot
                        return `${data}&nbsp;&nbsp;${orangeDot}`;
                    },
                    searchable: true,
                    orderable: true
                },
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address' },
                { data: 'meeting_purpose', name: 'meeting_purpose' },
                {
                    data: null,
                    name: 'meeting_date_time',
                    render: function(data, type, row) {
                        let meetingDate = data.meeting_date_time.meeting_date || '';
                        let meetingTimeslot = data.meeting_date_time.meeting_timeslot || '';
                        let natureOfVisit = data.meeting_date_time.nature_of_visit === 'Online' ? '<i class="bx bxs-circle me-1" style="color: green;"></i> Online' : '<i class="bx bxs-circle me-1" style="color: red;"></i> Offline';

                        if (type === 'display') {
                            return `<i class="bx bx-calendar"></i> ${meetingDate}<br>
                                    <i class="bx bx-time-five" style="color: blue;"></i>
                                    <span style="font-size: 0.875em; color: blue;">${meetingTimeslot}</span><br>
                                    ${natureOfVisit}`;
                        }

                        if (type === 'export') {
                            return `${meetingDate}\n${meetingTimeslot}\n${natureOfVisit === 'Online' ? 'Online' : 'Offline'}`;
                        }

                        return '';
                    }
                },
                {
                    data: null,
                    name: 'is_attended',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        if (row.plain_status === 'Approved' && row.can_update_attendance) {
                            let radioButtons = `
                                <div class="form-check">
                                    <input class="form-check-input attend-radio" type="radio" name="attended_${row.id}" value="1" ${data.is_attended == 1 ? 'checked' : ''} data-id="${row.id}">
                                    <label class="form-check-label">Attended</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input attend-radio" type="radio" name="attended_${row.id}" value="0" ${data.is_attended == 0 ? 'checked' : ''} data-id="${row.id}">
                                    <label class="form-check-label">Not Attended</label>
                                </div>`;
                            return radioButtons;
                        } else if (row.plain_status === 'Completed') {
                            if (row.is_attended == 1) {
                                return `<span class="badge bg-primary">Attended</span>`;
                            } else {
                                return `<span class="badge bg-danger">Not Attended</span>`;
                            }
                        } else {
                            return ''; // No attendance option for other statuses or future dates
                        }
                    }
                },                
                { data: 'status', name: 'status' },
                {
                    data: 'remark',
                    name: 'remark',
                    render: function(data, type, row) {
                        if (data && data.length > 25) {
                            return `<span data-bs-toggle="tooltip" data-bs-placement="top" title="${data}">${data.substring(0, 20)}...</span>`;
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            dom: '<"top"Blf>rt<"bottom"ip><"clear">',
            buttons: ['csv', 'excel'],
            createdRow: function(row, data, dataIndex) {
                $('td', row).eq(6).attr('id', 'status-' + data.id);
                $('td', row).eq(8).attr('id', 'action-' + data.id);
            }
        });

        $('[data-toggle="tooltip"]').tooltip();

        $('#statusSelect').change(function () {
    const status = $(this).val();

    // Set default sorting column and order
    const defaultSorting = [1, 'desc']; // Sorting by 'unique_id' (index 1) in descending order

    if (status === '' || status === 'All') {
        table.order(defaultSorting); // Sort by 'unique_id' in descending order
    } else {
        table.order(defaultSorting); // Always sort by 'unique_id' in descending order for all statuses
    }

    table.ajax.reload(null, false); // Reload table without resetting pagination
});



        // Handle the change event on the radio buttons for attendance update
        $(document).on('change', '.attend-radio', function() {
            let appointmentId = $(this).data('id');
            let isAttended = $(this).val();

            // Show the confirmation modal before submitting the update
            const updateModal = new bootstrap.Modal(document.getElementById('confirmUpdateModal'));
            updateModal.show();

            // When the user clicks "Yes" in the confirmation modal
            $('#confirmSubmitAttendance').off('click').on('click', function() {
                // After confirming attendance update, show the remark modal
                updateModal.hide(); // Hide the confirmation modal

                const attendanceRemarkModal = new bootstrap.Modal(document.getElementById('attendanceRemarkModal'));
                attendanceRemarkModal.show(); // Show the optional remark modal

                // When user submits the attendance reason modal
                $('.submit-attendance-reason').off('click').on('click', function() {
                    const remark = $('#attendanceRemark').val().trim(); // Optional remark

                    // Send AJAX request to update attendance with or without the remark
                    updateAttendanceStatus(appointmentId, isAttended, remark);

                    // Hide the remark modal after submission
                    attendanceRemarkModal.hide();
                });
            });
        });
    });

    // AJAX function to handle attendance update
    function updateAttendanceStatus(appointmentId, isAttended, remark = '') {
        $.ajax({
            url: `/appointments/update-attendance/${appointmentId}`,
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: { 
                is_attended: isAttended,
                remark: remark // Optional remark
            },
            success: function(response) {
                if (response.success) {
                    // Reload the table to reflect the new status
                    $('#example').DataTable().ajax.reload();
                } else {
                    alert(response.message); // Handle any error messages
                }
            },
            error: function() {
                alert('Error updating attendance status.');
            }
        });
    }
</script>


@endsection
