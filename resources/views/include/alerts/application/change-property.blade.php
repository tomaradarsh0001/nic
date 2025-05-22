
<div class="modal fade" id="appChangeProperty" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" id="misCheckedForm">
                @csrf
                <input type="hidden" id="appModalId" name="modalId" value="">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure to change Property ID?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    All the data related to your last application will be deleted?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="confirmApplicationDelete" class="btn btn-primary confirm-review-btn">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>



