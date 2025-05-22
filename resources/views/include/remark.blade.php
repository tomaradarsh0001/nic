<!-- Reject Reason Modal -->
<div class="modal fade" id="rejectReasonModal" tabindex="-1" role="dialog" aria-labelledby="rejectReasonModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectReasonModalLabel">Reason for Rejection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="rejectionReason" class="form-label">Remark</label>
                    <textarea class="form-control" id="rejectionReason" rows="3" placeholder="Enter reason"></textarea>
                    <div id="rejectionReasonError" class="validation-error">Please provide a reason for rejection.</div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger submit-reason">Submit</button>
            </div>
        </div>
    </div>
</div>