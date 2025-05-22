<div class="modal fade" id="submitModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="submitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header border-0 h-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('assets/images/submit.svg') }}" alt="success" class="success_icon">
                <h4 class="modal-title mb-2" id="ModalSuccessLabel">Are you sure?</h4>
                <p>Are You Surely Want to Submit.</p>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary btn-width" data-bs-dismiss="modal">No</button>
                    <button type="button" name="status" value="submit" class="btn btn-success btn-width" id="confirmSubmit">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>