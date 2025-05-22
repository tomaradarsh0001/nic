
<div class="modal fade" id="withdawApplication" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" id="misCheckedForm">
                @csrf
                <input type="hidden" id="serviceType" name="serviceType" value="">
                <input type="hidden" id="modalId" name="modalId" value="">
                <input type="hidden" id="withdrawApplicantNo" name="applicantNo" value="">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure to withdraw?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    You want to withdraw this application? This action can't be revert.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="confirmWithdawApplication" class="btn btn-primary confirm-review-btn">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

