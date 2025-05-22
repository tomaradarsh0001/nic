<!-- Modal for Recording Upload -->
<div class="modal fade" id="recordingModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="recordingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="display: block !important; padding-bottom: 0px !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="recordingModalLabel" style="font-size: 16px;">Upload Recording</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                @if(session('ticket_id'))
                    <h4 class="ticket_id text-success mt-2"><strong>Ticket ID:</strong> {{ session('ticket_id') }}</h4>
                @endif
            </div>
            <div class="modal-body">
                <!-- Recording Upload File Input -->
                <form id="uploadRecordingForm" action="{{ route('grievance.uploadRecording') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="grievance_id" value="{{ session('grievance_id') }}">
                    <div class="form-group">
                        <label for="recording" class="form-label">Upload Recording <span class="text-danger">*</span></label>
                        <input type="file" name="recording" id="recording" class="form-control" accept="audio/*">
                        <div id="recordingError" class="text-danger text-left"></div>
                    </div>
                    <button type="submit" id="uploadRecordingButton" class="btn btn-primary mt-3">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const uploadRecordingForm = document.getElementById('uploadRecordingForm');
        const recordingInput = document.getElementById('recording');
        const recordingError = document.getElementById('recordingError');
        const uploadButton = document.getElementById('uploadRecordingButton');

        // Validate the recording input
        function validateRecording() {
            if (!recordingInput || recordingInput.files.length === 0) {
                recordingError.textContent = 'Recording is required.';
                return false;
            } else {
                recordingError.textContent = '';
                return true;
            }
        }

        // Attach validation to the form submission
        uploadRecordingForm.addEventListener('submit', function (event) {
            if (!validateRecording()) {
                event.preventDefault(); // Prevent submission if recording is missing
            }
        });

        // Real-time validation on file input change
        recordingInput.addEventListener('change', validateRecording);
    });
</script>
