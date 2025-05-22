<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header border-0 h-0">
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('assets/images/warning.svg') }}" alt="warning" class="warning_icon">
                <h4 class="modal-title mb-2" id="ModalDeleteLabel">Are you sure?</h4>
                <p>Are You Surely Want to Reject the Request.</p>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger confirm-reject">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>
