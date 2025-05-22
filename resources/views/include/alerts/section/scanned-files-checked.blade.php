@php
    if ($serviceType == 'RS_NEW_REG') {
        $modalId = $data['details']->id;
        $applicationNo = $data['details']->applicant_number;
    } else {
        $serviceType = getServiceCodeById($actionServiceType);
        $modalId = $details->id;
        $applicationNo = $details->application_no;
    }
@endphp

<div class="modal fade" id="ModelScannFile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" id="scannFileCheckedForm">
                @csrf
                <input type="hidden" id="serviceType" name="serviceType" value="{{ $serviceType }}">
                <input type="hidden" id="modalId" name="modalId" value="{{ $modalId }}">
                <input type="hidden" id="applicantNo" name="applicantNo" value="{{ $applicationNo }}">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure you want to check this?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Have you checked all the scanned files of this property?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="confirmScannFileChecked"
                        class="btn btn-primary confirm-review-btn">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
