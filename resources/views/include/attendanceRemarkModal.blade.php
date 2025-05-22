<!-- Attendance Remark Modal -->
<div class="modal fade" id="attendanceRemarkModal" tabindex="-1" role="dialog" aria-labelledby="attendanceRemarkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attendanceRemarkModalLabel">Optional Remark for Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="attendanceRemark" class="form-label">Remark (Optional)</label>
                    <textarea class="form-control" id="attendanceRemark" rows="3" placeholder="Enter remark (optional)"></textarea>
                    <div id="attendanceRemarkError" class="validation-error" style="display:none;">Please provide a reason.</div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning submit-attendance-reason">Submit</button>
            </div>
        </div>
    </div>
</div>
