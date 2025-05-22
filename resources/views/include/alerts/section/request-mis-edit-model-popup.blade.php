<div class="modal fade" id="requestMisEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" id="requestEditMisForm">
                @csrf
                <input type="hidden" id="serviceType" name="serviceType" value="{{isset($additionalData[0]) ? $additionalData[0] : ''}}">
                <input type="hidden" id="modalId" name="modalId" value="{{isset($additionalData[1]) ? $additionalData[1] : ''}}">
                <input type="hidden" id="applicantNo" name="applicantNo" value="{{isset($additionalData[2]) ? $additionalData[2] : ''}}">
                <input type="hidden" id="newPropertyId" name="newPropertyId" value="{{$viewDetails->unique_propert_id}}">
                <input type="hidden" id="oldPropertyId" name="oldPropertyId" value="{{$viewDetails->old_propert_id}}">
                <input type="hidden" id="masterId" name="masterId" value="{{$viewDetails->id}}">
                <input type="hidden" id="sectionCode" name="sectionCode" value="{{$viewDetails->section_code}}">
                <input type="hidden" id="flatId" name="flatId" value="{{isset($flatData['flatDetails']->flat_id) ? $flatData['flatDetails']->flat_id : ''}}">
                <div class="modal-header">
                    <h4 class="modal-title mb-2">Are you sure?</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Do you want to send edit request.</p>
                    <textarea id="remarks" name="remarks" class="form-control" placeholder="Enter remarks"></textarea>
                    <div id="remarksError" class="error-label text-danger mt-2" style="display:none; margin-left:0px;">Please enter
                        remarks.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="confirmrequestEditMisCheckedCloseBtn" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="confirmrequestEditMisChecked" class="btn btn-primary confirm-review-btn">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>