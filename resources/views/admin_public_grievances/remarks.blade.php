<!-- Modal for Adding Remarks -->
<div class="modal fade" id="remarksModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="remarksModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="remarksModalLabel">Add Remarks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="remarksForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="grievance_remark" class="form-label">Add Remark:</label>
                        <textarea name="grievance_remark" id="grievance_remark" class="form-control" rows="4" required maxlength="255"></textarea>
                        <div id="grievanceRemarkError" class="text-danger text-left"></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Update Status:</label>
                            <select id="status" name="status" class="form-control"></select>
                            <!-- Placeholder for the hidden input, to be dynamically inserted if needed -->
                        </div>    
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="validateAndSubmitRemark()">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script>
function validateAndSubmitRemark() {
    var textarea = document.getElementById('grievance_remark');
    var statusSelect = document.getElementById('status'); // Get the status select element
    var errorMessage = document.getElementById('grievanceRemarkError');

    // Debug the selected status value
    console.log("Selected Status: ", statusSelect.value);

    if (!textarea.value.trim()) {
        errorMessage.textContent = 'Remark cannot be blank.';
        return; // Stop here if the validation fails
    } else if (textarea.value.length > 255) {
        errorMessage.textContent = 'Remark cannot exceed 255 characters.';
        return; // Stop here if the validation fails
    } else {
        errorMessage.textContent = ''; // Clear the message if no issues
        document.getElementById('remarksForm').submit(); // Submit the form if all is good
    }
}
</script>
