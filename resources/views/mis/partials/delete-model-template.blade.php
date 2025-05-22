<!-- Modal -->
<div class="modal fade" id="ModalDelete" data-bs-backdrop="static" tabindex="-1" aria-labelledby="ModalDeleteLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header border-0 h-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('assets/images/warning.svg') }}" alt="warning" class="warning_icon"
                    style="width: 39px; height: 40px;">
                <h4 class="modal-title mb-2" id="ModalDeleteLabel">Are you sure?</h4>
                <p>You want to delete this information permanently.</p>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary btn-width" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="confirmDelete" class="btn btn-danger btn-width">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Land Transfer Details Model -->
<div class="modal fade" id="LTDModalDelete" data-bs-backdrop="static" tabindex="-1" aria-labelledby="ModalDeleteLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header border-0 h-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('assets/images/warning.svg') }}" alt="warning" class="warning_icon"
                    style="width: 39px; height: 40px;">
                <h4 class="modal-title mb-2" id="ModalDeleteLabel">Are you sure?</h4>
                <p>You want to delete this information permanently.</p>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary btn-width" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="confirmLTDDelete" class="btn btn-danger btn-width">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Property Status Change Model -->
<div class="modal fade" id="propertyStatusChangeModel" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="ModalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header border-0 h-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('assets/images/warning.svg') }}" alt="warning" class="warning_icon"
                    style="width: 39px; height: 40px;">
                <h4 class="modal-title mb-2" id="ModalDeleteLabel">Are you sure?</h4>
                <p>You want to change property status permanently.</p>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary btn-width" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="propertyStatusChangeConfirm"
                        class="btn btn-danger btn-width">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>
