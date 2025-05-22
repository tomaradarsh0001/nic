<!-- Approve Modal -->
<div class="modal fade" id="approveModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header border-0 h-0">
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('assets/images/approve.svg') }}" alt="warning" class="warning_icon">
                <h4 class="modal-title mb-2" id="ModalDeleteLabel">Are you sure?</h4>
                <p>Are You Surely Want to Approve the Request.</p>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary btn-width" data-dismiss="modal">No</button>
                    <button type="submit" name="status" value="approved"
                        class="btn btn-warning btn-width">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>