@extends('layouts.app')
@section('title', 'Application | Start Proof Reading')
@section('content')
<style>
    .pagination .active a {
        color: #ffffff !important;
    }

    .required-error-message {
        display: none;
    }

    .required-error-message {
        margin-left: -1.5em;
        margin-top: 3px;
    }

    .form-check-inputs[type=checkbox] {
        border-radius: .25em;
    }

    .form-check .form-check-inputs {
        float: left;
        margin-left: -1.5em;
    }

    .form-check-inputs {
        width: 1.5em;
        height: 1.5em;
        margin-top: 0;
    }

    /** Added By Nitin */
    .duesDetails {
        display: flex;
    }

    .duesDetails span {
        flex: 1;
    }

    #spinnerOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        /* Ensure it covers other content */
    }

    .spinner {
        border: 8px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top: 8px solid #ffffff;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* for offic activity By Diwakar */
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

    .form-check .form-check-inputs {
        float: left;
        margin-left: -1.5em;
    }

    .form-check-inputs[type=checkbox] {
        border-radius: .25em;
    }

    .form-check-inputs {
        width: 1.5em;
        height: 1.5em;
        margin-top: 0;
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

    .text-muted {
        color: #6c757dad !important;
    }
</style>

<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">APPLICATION</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item">{{ $applicationType }}</li>
                <li class="breadcrumb-item active" aria-current="page">Proofreading</li>
            </ol>
        </nav>
    </div>
</div>

<hr>
<div class="card">
    <div class="card-body">
    <div>
            <div class="parent_table_container pb-3">
                <table class="table report-item">
                    <tbody>

                        <tr>
                            <td>Application No: <span
                                    class="highlight_value">{{ $details->application_no ?? '' }}</span></td>
                            <td>Application Type: <span class="highlight_value">
                                    <div
                                        class="ml-2 badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
                                        {{ $applicationType }}
                                    </div>
                                </span></td>
                            <td>Application Current Satus: <span class="highlight_value lessee_address">
                                    @switch(getStatusDetailsById( $details->status ?? '' )->item_code)
                                    @case('APP_REJ')
                                    <div
                                        class="ml-2 badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </div>
                                    @break

                                    @case('APP_NEW')
                                    <div
                                        class="ml-2 badge rounded-pill text-primary bg-light-primary p-2 text-uppercase px-3">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </div>
                                    @break

                                    @case('RS_UREW')
                                    <div
                                        class="ml-2 badge rounded-pill text-white bg-secondary p-2 text-uppercase px-3">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </div>
                                    @break

                                    @case('RS_REW')
                                    <div
                                        class="ml-2 badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </div>
                                    @break

                                    @case('RS_PEN')
                                    <div
                                        class="ml-2 badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </div>
                                    @break

                                    @case('APP_APR')
                                    <div
                                        class="ml-2 badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </div>
                                    @break
                                    @case('HOLD')
                                    <div
                                        class="ml-2 badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </div>
                                    @break

                                    @default
                                    <div
                                        class="ml-2 badge rounded-pill text-secondary bg-light p-2 text-uppercase px-3">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </div>
                                    @endswitch
                                </span></td>
                            <td>Status of Applicant: <span
                                    class="highlight_value">{{ getServiceNameById($details->status_of_applicant ?? '') }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @switch($applicationType)
        @case('Mutation')
            @include('application.admin.proof_reading.mutation')
        @break
        @case('Land Use Change')
            @include('application.admin.proof_reading.luc')
        @break
        @case('Deed Of Apartment')
            @include('application.admin.proof_reading.doa')
        @break
        @case('Conversion')
            @include('application.admin.proof_reading.conversion')
        @break
        @default
        <div class="part-title mt-2">
            <h5>Property Document Details</h5>
        </div>
        <div class="part-details">
            <div class="container-fluid">
                <div class="row g-2">
                    <div class="col-lg-12">
                        <p>Property Documents Not Available</p>
                    </div>
                </div>
            </div>
        </div>
        @endswitch
    </div>
</div>

@include('include.alerts.ajax-alert')
<div id="spinnerOverlay" style="display:none;">
    <img src="{{ asset('assets/images/chatbot_icongif.gif') }}">
</div>

<!-- Modal -->
<div class="modal fade" id="remarkScrollableModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remark</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="remarkInModal"></p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footerScript')
<script>
    //For showing remark of document checked before proof reading- SOURAV CHAUHAN (13/Dec/2024)
    function getRemark(documentId) {
            var remark = $('#fullRemark_' + documentId).val()
            console.log(remark);

            $('.remarkInModal').html(remark)
            $('#remarkScrollableModal').modal('show');
        }


    //For uploading files by CDV - SOURAV CHAUHAN (13/Dec/2024)
    function handleFileUploadForCdv(file,id){
        const spinnerOverlay = document.getElementById('spinnerOverlay');
        spinnerOverlay.style.display = 'flex';
        const baseUrl = "{{ asset('storage') }}";

        const formData = new FormData();
        formData.append('file', file); // Append the file to the FormData object
        formData.append('id', id); // Append the document id
        formData.append('_token', '{{ csrf_token() }}'); // Append the CSRF token

        $.ajax({
            url: "{{ route('uploadFileforCdv') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    // var anchorTag = $('a[data-document-type="' + name + '"]');
                    // if (anchorTag.length > 0) {
                    const newPath = baseUrl + '/' + response.path;
                    //     anchorTag.attr('href', newPath);
                    // }
                    spinnerOverlay.style.display = 'none';
                    const mainDiv = $('#file-link-' + id);
                    mainDiv.empty();

                    // Create the div structure with the necessary links in one go
                    mainDiv.append(`
                            <strong>View Document &nbsp;&nbsp; <a href="${newPath}" target="_blank" class="text-danger uploaded-doc-name">
                                <i class="fa-solid fa-file-pdf"></i>
                            </a> </strong>
                            <strong>Remove Document &nbsp;&nbsp; <a href="javascript:void(0);" onclick="handleFileDelete(${id})" title="Delete Document" class="text-danger uploaded-doc-name">
                                <i class="fa-solid fa-times"></i>
                            </a> </strong>
                    `);
                    showSuccess('File Uploaded Successfully')
                }
            },
            error: function(response) {
                spinnerOverlay.style.display = 'none'
                showError('File Not Uploaded')
            }
        });
    }

    //For deleting files by CDV - SOURAV CHAUHAN (13/Dec/2024)
    function handleFileDelete(id){
        const spinnerOverlay = document.getElementById('spinnerOverlay');
        spinnerOverlay.style.display = 'flex';

        const formData = new FormData();
        formData.append('id', id); // Append the document id
        formData.append('_token', '{{ csrf_token() }}'); // Append the CSRF token

        $.ajax({
            url: "{{ route('deleteFileforCdv') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    spinnerOverlay.style.display = 'none';
                    const mainDiv = $('#file-link-' + id);
                    mainDiv.empty();
                    showSuccess('File Deleted Successfully')
                }
            },
            error: function(response) {
                spinnerOverlay.style.display = 'none'
                showError('File Not Deleted')
            }
        });
    }

    //For deleting additional files - LALIT TIWARI (24/Dec/2024)
    function handleFileDeleteAdditionalDocument(id){
        const spinnerOverlay = document.getElementById('spinnerOverlay');
        spinnerOverlay.style.display = 'flex';

        const formData = new FormData();
        formData.append('id', id); // Append the document id
        formData.append('_token', '{{ csrf_token() }}'); // Append the CSRF token

        $.ajax({
            url: "{{ route('deleteFileforCdv') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    showSuccess('File Deleted Successfully')
                    window.location.reload(true);
                }
            },
            error: function(response) {
                spinnerOverlay.style.display = 'none'
                showError('File Not Deleted')
            }
        });
    }

    //For repeating the additional files - SOURAV CHAUHAN (16/Dec/2024)
    document.getElementById('add-more-btn').addEventListener('click', function() {
            var container = document.getElementById('file-inputs-container');

            // Clone the existing file input group and clear its fields
            var newItem = container.querySelector('.file-input-group').cloneNode(true);
            var inputs = newItem.querySelectorAll('input');

            inputs.forEach(input => {
                if (input.type === 'text' || input.type === 'file') {
                    input.value = ''; // Clear text and file inputs
                }
            });

            // Enable the remove button for the new group
            var removeButton = newItem.querySelector('.remove-btn');
            removeButton.disabled = false;

            // Append the cloned item to the container
            container.appendChild(newItem);

            // Update remove button state
            updateRemoveButtonState();
        });

        document.getElementById('file-inputs-container').addEventListener('click', function(event) {
            if (event.target && event.target.closest('.remove-btn')) {
                var group = event.target.closest('.file-input-group');

                // Check if more than one group exists before removing
                if (document.querySelectorAll('.file-input-group').length > 1) {
                    group.remove();
                    updateRemoveButtonState();
                }
            }
        });

        function updateRemoveButtonState() {
            var groups = document.querySelectorAll('.file-input-group');
            groups.forEach((group, index) => {
                var removeButton = group.querySelector('.remove-btn');
                removeButton.disabled = groups.length === 1; // Disable if it's the only group
            });
        }

        // Initialize remove button state on page load
        updateRemoveButtonState();
        // Add 5MB validation for Additional Document & title - Lalit Tiwari (11/02/2025)
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("uploadAdditionalDocumentForm").addEventListener("submit", function (event) {
                let fileInputs = document.querySelectorAll('input[name="additional_documents[]"]');
                let titleInputs = document.querySelectorAll('input[name="additional_document_titles[]"]');
                let maxSize = 5 * 1024 * 1024; // 5MB
                let allowedTypes = ["application/pdf"];
                let isValid = true;

                // Clear previous error messages
                document.querySelectorAll(".error-message").forEach(el => el.remove());

                fileInputs.forEach((fileInput, index) => {
                    let titleInput = titleInputs[index];
                    let file = fileInput.files[0]; // Get selected file
                    
                    // Remove previous error messages (if any)
                    titleInput.classList.remove("is-invalid");
                    fileInput.classList.remove("is-invalid");

                    if (file) { // Validate only if file is selected
                        if (!titleInput.value.trim()) {
                            showError(titleInput, "Please enter a document title.");
                            isValid = false;
                        }
                        if (!allowedTypes.includes(file.type)) {
                            showError(fileInput, "Only PDF files are allowed.");
                            isValid = false;
                        }
                        if (file.size > maxSize) {
                            showError(fileInput, "File size must not exceed 5MB.");
                            isValid = false;
                        }
                    }
                });

                if (!isValid) {
                    event.preventDefault(); // Stop form submission
                }
            });

            function showError(inputElement, message) {
                let errorDiv = document.createElement("div");
                errorDiv.className = "error-message text-danger mt-1";
                errorDiv.textContent = message;
                inputElement.classList.add("is-invalid"); // Add red border
                inputElement.parentNode.appendChild(errorDiv);
            }
        });
</script>
@endsection