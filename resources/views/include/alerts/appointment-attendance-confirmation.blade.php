<!-- resources/views/appointment-attendance-confirmation.blade.php -->
<!-- Submit Modal for Attendance Confirmation -->
<div class="modal fade" id="confirmUpdateModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="submitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header border-0 h-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('assets/images/update.svg') }}" alt="success" class="success_icon">
                <h4 class="modal-title mb-2" id="ModalSuccessLabel">Are you sure?</h4>
                <p>Are you sure you want to update the attendance status?</p>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary btn-width" data-bs-dismiss="modal">No</button>
                    <button type="button" name="status" value="submit" class="btn btn-warning btn-width" id="confirmSubmitAttendance">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>
