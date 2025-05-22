<div class="modal fade" id="rejecNewPropertyStatus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="{{ route('reject.applicant.new.property', ['id' => $data['details']->id]) }}">
                @csrf
                @method('put')
                <div class="modal-header">
                    <h5 class="modal-title">Are You Sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you really want to reject this application? <br>This process cannot be undone.
                </div>
                <div id="modalInputs"></div>
                <div class="modal-body input-class-reject">
                    <label for="rejection">Enter remarks for rejection this application.</label>
                    {{-- <input type="text" name="remarks" class="form-control" placeholder="Enter Remarks"> --}}
                    <textarea name="remarks" class="form-control" placeholder="Enter Remarks"></textarea>
                    <div class="error-label text-danger mt-2" style="display:none; margin-left:0px;">Please enter
                        remarks for rejection.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary confirm-reject-btn">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modelReview" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="{{ route('review.applicant.new.property', ['id' => $data['details']->id]) }}">
                @csrf
                @method('put')
                <input type="hidden" id="sPid" name="sPid"value="{{ $data['suggestedPropertyId'] ?? '' }}">
                <input type="hidden" id="oPid" name="oPid" value="{{ $data['oldPropertyId'] ?? '' }}">
                <div class="modal-header">
                    <h5 class="modal-title">Are You Sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you want to forward this application to Deputy L & DO for review? Lalit
                </div>
                <div class="modal-body input-class-reject">
                    <label for="rejection">Remarks</label>
                    {{-- <input type="text" name="remarks" class="form-control" placeholder="Enter Remarks"> --}}
                    <textarea name="remarks" class="form-control" placeholder="Remarks"></textarea>
                    <div class="error-label text-danger mt-2" style="display:none; margin-left:0px;">Please enter
                        remarks for review.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary confirm-review-btn">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="approvePropertyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are You Sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Do you want to approve this application? <br>This process cannot be undone.
                {{-- <div id="isPropertyFree" class="text-danger py-2"></div> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeApproveModelButton">Close</button>
                <button type="button" name="status" value="submit" class="btn btn-primary btn-width"
                    id="confirmApproveSubmit">Confirm</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="checkProperty" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <img src="{{ asset('assets/images/warning.svg') }}" alt="warning"
                        class="warning_icon" style="height: 39px; width:39px;"> Alert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="isPropertyFree" class="text-danger py-2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary ms-auto" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>