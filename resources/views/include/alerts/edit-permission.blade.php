<!-- Edit Permission Modal -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title mb-2">Are you sure?</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Do you want to allow permission on this property.</p>
            <form id="editPermissionForm">
                <input type="hidden" id="sectionMisHistoryId" name="sectionMisHistoryId">
                <input type="hidden" id="serviceType" name="serviceType">
                <input type="hidden" id="modelId" name="modelId">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="savePermissionChanges">Confirm</button>
        </div>
    </div>
</div>
</div>