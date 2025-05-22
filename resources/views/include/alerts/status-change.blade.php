<!-- status change modal -->
<div class="modal fade" id="statusChangeModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="statusChangeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header border-0 h-0">
                <button type="button" class="btn-close" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('assets/images/approve.svg') }}" alt="warning" class="warning_icon">
                <h4 class="modal-title mb-2" id="ModalStatusChangeLabel">Are you sure?</h4>
                <p>Are You Surely Want to Change the Status.</p>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary btn-width" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-success btn-width confirm-approve">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>
