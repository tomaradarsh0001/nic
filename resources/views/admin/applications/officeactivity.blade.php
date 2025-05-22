@extends('layouts.app')

@section('title', 'File Movement')

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


<!-- for Application timeline -->
<div class="card">
    <div class="card-body">
        <div class="application-movement">
            
            <!-- Status -->
            <div class="movement-status-container">
                <div class="movement-status-item__status">
                    <div class="movement-status-item status--new">
                        <span class="status-circle"></span>
                        <h4 class="status-title">New</h4>
                    </div>
                    <div class="movement-status-item status--pending">
                        <span class="status-circle"></span>
                        <h4 class="status-title">Pending</h4>
                    </div>
                    <div class="movement-status-item status--recommend">
                        <span class="status-circle"></span>
                        <h4 class="status-title">Recommend</h4>
                    </div>
                    <div class="movement-status-item status--object">
                        <span class="status-circle"></span>
                        <h4 class="status-title">Object</h4>
                    </div>
                    <div class="movement-status-item status--underproof">
                        <span class="status-circle"></span>
                        <h4 class="status-title">Under Proof Reading</h4>
                    </div>
                    <div class="movement-status-item status--reject">
                        <span class="status-circle"></span>
                        <h4 class="status-title">Reject</h4>
                    </div>
                    <div class="movement-status-item status--approve">
                        <span class="status-circle"></span>
                        <h4 class="status-title">Approve</h4>
                    </div>
                </div>
            </div>
            <!-- End -->
            <div class="container-grid">
                <ol class="application-movement">
                                                            
                    <li class="status__new">
                        <div class="grid-items-status">
                            <div class="movement-status">
                                <span class="status-pin"><i class="fas fa-map-pin fa-fw"></i></span>
                                <h4 class="application-no">APP0000015</h4>
                                <h5 class="officer-name">Sourav Chauhan</h5>
                                <span class="application-date-time">2024-11-25 15:11:55</span>
                            </div>
                        </div>
                    </li>
                                                                                <li class="status__action action-type--recommend">
                        <div class="recommend-action">
                            <h6 class="action-type">Recommend</h6>
                            <h5 class="officer-name">By: Ankur Kumar Lal (Section Officer)</h5>
                            <p class="remarks"><span style="font-weight: 600; font-family: sans-serif;">Remarks:</span> Some corrections needed in this file. Must have to correct them.</p>
                            <h5 class="officer-name">To: Mr. Lakhan Tiwari (Section Officer)</h5>
                            <span class="application-date-time">2024-12-06 10:57:45</span>
                        </div>
                    </li>
                                                                                <li class="status__action action-type--recommend">
                        <div class="recommend-action">
                            <h6 class="action-type">Recommend</h6>
                            <h5 class="officer-name">Rajeev Kumar Das (Deputy Lndo)
                            </h5>
                                                        <span class="application-date-time">2024-12-06 11:11:35</span>
                        </div>
                    </li>
                                                                                <li class="status__action action-type--object last-item-row">
                        <div class="recommend-action">
                            <h6 class="action-type">Object</h6>
                            <h5 class="officer-name">CDV User (CDV)</h5>
                            <p class="remarks"><span style="font-weight: 600;">Remarks:</span> Some corrections needed in this file. Must have to correct them.</p>
                            <span class="application-date-time">2024-12-06 11:13:17</span>
                        </div>
                    </li>
                                                                                <li class="status__action action-type--object">
                        <div class="recommend-action">
                            <h6 class="action-type">Object</h6>
                            <h5 class="officer-name">Rajeev Kumar Das (Deputy Lndo)
                            </h5>
                             <p class="remarks"><span style="font-weight: 600;">Remarks:</span>
                                Please check the details of documents</p>                            <span class="application-date-time">2024-12-09 16:37:55</span>
                        </div>
                    </li>
                                                                                <li class="status__action action-type--object">
                        <div class="recommend-action">
                            <h6 class="action-type">Object</h6>
                            <h5 class="officer-name">Ankur Kumar Lal (Section Officer)
                            </h5>
                             <p class="remarks"><span style="font-weight: 600;">Remarks:</span>
                                I have checked the documents and all documents are correct.</p>                            <span class="application-date-time">2024-12-09 16:40:04</span>
                        </div>
                    </li>
                                                                                <li class="status__action action-type--">
                        <div class="recommend-action">
                            <h6 class="action-type"></h6>
                            <h5 class="officer-name">Rajeev Kumar Das (Deputy Lndo)
                            </h5>
                             <p class="remarks"><span style="font-weight: 600;">Remarks:</span>
                                Dear section please check the application documents</p>                            <span class="application-date-time">2024-12-13 13:34:14</span>
                        </div>
                    </li>
                                                                                <li class="status__action action-type--object last-item-row">
                        <div class="recommend-action">
                            <h6 class="action-type">Object</h6>
                            <h5 class="officer-name">Ankur Kumar Lal (Section Officer)
                            </h5>
                             <p class="remarks"><span style="font-weight: 600;">Remarks:</span>
                                I have checked the documents and fount correct up to my knowledge.</p>                            <span class="application-date-time">2024-12-13 13:35:42</span>
                        </div>
                    </li>
                                                                                
                </ol>
            </div>
        </div>
    </div>
</div>





<div class="card">
    <div class="card-body">
        <div class="part-title mt-2">
            <h5>Particular Document Details</h5>
        </div>
        <div class="part-details">
            <div class="container-fluid pb-3">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered particular-document-table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                    <th>Status by CDV</th>
                                    <th>Uploaded Doc.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="document-type-row">
                                        <h4 class="doc-type-title">Required Documents</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <span class="doc-name">Affidavits <a href="#" class="text-danger"><i class="fa-solid fa-file-pdf"></i></a></span>
                                        <div class="required-doc">
                                            <ul class="required-list">
                                                <li>Date of attestation: 12-12-2024</li>
                                                <li>Attested by:  Kunal</li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-options">
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input required-for-approve" name="checkedAction" type="checkbox" value="1" id="checkedAction">
                                            <label class="form-check-label" for="checkedAction">Checked</label>
                                        </div>
                                    </div>
                                </td>
                                    <td>
                                        <div class="checkbox-options" style="display: flex;">
                                            <div class="form-check form-check-success custom-mr-5">
                                                <input class="form-check-input required-for-approve" name="cdvStatus" type="radio" value="1" id="YesCDVStatus" checked>
                                                <label class="form-check-label" for="YesCDVStatus">Yes</label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <input class="form-check-input required-for-approve" name="cdvStatus" type="radio" value="0" id="NoCDVStatus">
                                                <label class="form-check-label" for="NoCDVStatus">No</label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="text-danger uploaded-doc-name"><i class="fa-solid fa-file-pdf"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        <span class="doc-name">Affidavits <a href="#" class="text-danger"><i class="fa-solid fa-file-pdf"></i></a></span>
                                        <div class="required-doc">
                                            <ul class="required-list">
                                                <li>Date of attestation: 12-12-2024</li>
                                                <li>Attested by:  Kunal</li>
                                                <li>Attested by:  Kunal</li>
                                                <li>Attested by:  Kunal</li>
                                                <li>Attested by:  Kunal</li>
                                                <li>Attested by:  Kunal</li>
                                                <li>Attested by:  Kunal</li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-options">
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input required-for-approve" name="checkedAction" type="checkbox" value="1" id="checkedAction">
                                            <label class="form-check-label" for="checkedAction">Checked</label>
                                        </div>
                                    </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-options" style="display: flex;">
                                            <div class="form-check form-check-success custom-mr-5">
                                                <input class="form-check-input required-for-approve" name="cdvStatus1" type="radio" value="1" id="YesCDVStatus1">
                                                <label class="form-check-label" for="YesCDVStatus1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <input class="form-check-input required-for-approve" name="cdvStatus1" type="radio" value="0" id="NoCDVStatus1" checked>
                                                <label class="form-check-label" for="NoCDVStatus1">No</label>
                                            </div>
                                        </div>
                                        <div class="required-doc">
                                            <h6 class="required-title">Remarks</h6>
                                            <p class="remarks-content">Lorem ipsum dolor sit amet cons...</p>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="text-danger uploaded-doc-name"><i class="fa-solid fa-file-pdf"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="part-title mt-2">
            <h5>OFFICE ACTIVITY</h5>
        </div>
        <div class="part-details">
            <form id="approvalForm" method="POST" action="http://127.0.0.1:8000/approve/user/registration">
                <input type="hidden" name="_token" value="PIRimVlnbV4rYsQMo4T1ed5DrN1fGjBLQtJZklyC" autocomplete="off">
                <div class="container-fluid pb-3">
                    <div class="row">
                        <div class="col-lg-9">
                            <input type="hidden" name="emailId" id="emailId" value="8978945645@gmail.com">
                        <input type="hidden" name="registrationId" id="registrationId" value="77">
                        <input type="hidden" name="oldPropertyId" id="oldPropertyId" value="">
                        <input type="hidden" name="flatId" id="flatId" value="">
                        <div class="mis-view-group-btn">
                            <div class="btn-group">
                                <a href="http://127.0.0.1:8000/flat-form">
                                    <button type="button" id="PropertyIDSearchBtn" class="btn btn-warning ml-2">Go to
                                        MIS</button>
                                </a>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="checkbox-options">
                                <div class="form-check form-check-success">
                                    <label class="form-check-label" for="isUnderReview">
                                        Send To Deputy L&amp;DO For Review
                                    </label>
                                    <input class="form-check-inputs" type="checkbox" value="review" id="isUnderReview">
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-lg-12 mt-4">
                                <div class="checkbox-options">
                                    <div class="form-check form-check-success">
                                        <label class="form-check-label" for="isMISCorrect">

                                            MIS Checked &amp; Found Correct
                                        </label>
                                        <input class="form-check-input required-for-approve" name="is_mis_checked"
                                            type="checkbox" value="1" id="isMISCorrect">

                                    </div>
                                </div>

                                <div class="checkbox-options">
                                    <div class="form-check form-check-success">
                                        <label class="form-check-label" for="isScanningCorrect">

                                            Scanned File Checked &amp; Found Correct
                                        </label>
                                        <input class="form-check-input required-for-approve" name="is_scan_file_checked"
                                            type="checkbox" value="1" id="isScanningCorrect">

                                    </div>
                                </div>

                                <div class="checkbox-options">
                                    <div class="form-check form-check-success">
                                        <label class="form-check-label" for="isDocumentCorrect">

                                            Uploaded Documents Checked &amp; Found Correct
                                        </label>
                                        <input class="form-check-input required-for-approve"
                                            name="is_uploaded_doc_checked" type="checkbox" value="1"
                                            id="isDocumentCorrect">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        </div>
                        <div class="col-lg-3 mt-4">
                            <div class="payment-due">
                                <div class="pending-amount-group">
                                    <h4 class="pending-title">Pending Dues</h4>
                                    <p class="pending-amount">₹  451.55</p>
                                </div>
                                <div class="view-details">
                                    <a href="#">View Details</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="row border-top-1">
                    <div class="col-lg-12">
                        <div class="remark-container">
                            <h4 class="remark-title">Remark</h4>
                            <p class="remark-content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions Lorem Ipsum. <span class="author-name">- Mr. Dharamveer Singh Chauhan (JE)</span>, <span class="author-time">04:45 PM - 29/11/2024</span></p>
                            <div class="revert-btn">
                                <a href="#">Revert <i class="fa-solid fa-reply-all"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 mt-4">
                        <div class="container-fluid pb-3 forward_department">
                            <div class="row">
                                <div class="checkbox-options">
                                    <div class="form-check">
                                        <label class="form-check-label" for="forwardToDepartment">
                                            Forward To Department
                                        </label>
                                        <input class="form-check-input" name="forwardToDepartment" type="checkbox"
                                            id="forwardToDepartment">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12 items" id="divForwardAppDept" style="display: none;">
                                    <form id="forwardAppForm" method="POST">
                                        <div class="row mb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="forwardTo">Select Department</label>
                                                <select id="forwardTo" name="forwardTo" class="form-select" required>
                                                    <option value="">Select Department</option>
                                                  
                                                    <option value="">
                                                    </option>
                                                   
                                                </select>
                                                <div id="forwardToError" class="text-danger" style="display: none;">Please select
                                                    a department.</div>
                                                </div>
                                                
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group" style="margin-bottom: 10px;">
                                                    <label for="forwardRemark">Remarks</label>
                                                <textarea name="forwardRemark" id="forwardRemark" class="form-control"
                                                    placeholder="Remarks" rows="3" required></textarea>
                                                <div id="forwardRemarkError" class="text-danger" style="display: none;">Please
                                                    enter remarks.</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <button type="submit" id="forwardAppBtn" class="btn btn-secondary">Send Remark <i class="fa-regular fa-paper-plane"></i></button>
                                            </div>
                                        </div>
                                        
                                    </form>
            
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-4">
                        <div class="upload-signed-form">
                            <div class="upload-signed-head">
                                <h4 class="upload-signed-title">Upload Signed Letter</h4>
                                <div class="view-generated">
                                    <a href="#">View Generated Letter</a>
                                </div>
                            </div>
                            <div class="file-upload-wrapper">
                                <label class="file-upload-box mb-0">
                                    <input type="file" class="file-upload-input" multiple>
                                    <div class="upload-content">
                                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                        <h5 class="mb-2">Choose a file or drag & drop it here</h5>
                                        <p class="text-muted mb-0">JPEG, PNG, JPG, and PDF formats, up to 2MB</p>
                                        <span class="browse-file mb-0">Browse File</span>
                                    </div>
                                </label>
                                <div class="file-list">
                                    <!-- Files will be listed here -->
                                </div>
                            </div>
                            <div class="signed-btn">
                                <button type="button" class="btn btn-primary upload-signed-submit">Final Submit</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-4">
                        <div class="proof-reading-details">
                            <h4 class="proof-reading-details">Proof Reading Details</h4>
                            <div class="proof-reading-content">
                                <p class="appointment-link"><span>Appointment Link:</span> http://127.0.0.1:8000/applications/movement/new</p>
                                <p class="appointment-schedule-date"><span>Schedule Date:</span> 05-12-2024</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex justify-content-end gap-4 col-lg-12">
                        <button type="button" class="btn btn-primary" id="approveBtn">Approve</button>
                        <button type="button" id="rejectButton" class="btn btn-danger">Reject</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('footerScript')
<script>
      $(document).ready(function() {
            const fileUploadBox = $('.file-upload-box');
            const fileList = $('.file-list');
            const fileInput = $('.file-upload-input');

            // Handle drag and drop events
            fileUploadBox
                .on('dragover dragenter', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).addClass('drag-over');
                })
                .on('dragleave dragend drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).removeClass('drag-over');
                });

            // Handle file selection
            fileInput.on('change', function(e) {
                const files = e.target.files;
                handleFiles(files);
            });

            // Handle dropped files
            fileUploadBox.on('drop', function(e) {
                const files = e.originalEvent.dataTransfer.files;
                handleFiles(files);
            });

            function handleFiles(files) {
                Array.from(files).forEach(file => {
                    // Create progress bar element
                    const progressBar = $('<div class="upload-progress"></div>');
                    
                    const fileItem = $(`
                        <div class="file-item">
                            <i class="fas fa-file file-icon"></i>
                            <span class="file-name" title="${file.name}">${file.name}</span>
                            <i class="fas fa-times remove-file"></i>
                            ${progressBar.prop('outerHTML')}
                        </div>
                    `);

                    fileList.append(fileItem);

                    // Remove progress bar after animation
                    setTimeout(() => {
                        fileItem.find('.upload-progress').remove();
                    }, 1000);

                    // Handle file removal
                    fileItem.find('.remove-file').on('click', function(e) {
                        e.stopPropagation();
                        fileItem.fadeOut(300, function() {
                            $(this).remove();
                        });
                    });

                    // Get appropriate FontAwesome icon based on file type
                    const fileIcon = fileItem.find('.file-icon');
                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    
                    const iconMap = {
                        'pdf': 'fa-file-pdf',
                        'jpg': 'fa-file-image',
                        'jpeg': 'fa-file-image',
                        'png': 'fa-file-image',
                    };

                    if (iconMap[fileExtension]) {
                        fileIcon.removeClass('fa-file').addClass(iconMap[fileExtension]);
                    }
                });
            }



            // Forward To Department

            $('#forwardToDepartment').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#divForwardAppDept').show();
                } else {
                    $('#divForwardAppDept').hide();
                }
            });
            // End
        });
</script>
@endsection