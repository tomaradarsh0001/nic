<div class="mt-3">
    <div class="container-fluid">
        {{-- <div class="row g-3 mb-2 mt-3">
            <div class="col-lg-12">
                <div class="part-title mb-2">
                    <h5>Property Details</h5>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <input type="hidden" name="lucid" id="lucid">
                <div class="form-group form-box">
                    <label for="luclocality" class="form-label">Select Locality</label>
                    <select id="luclocality" class="form-select" disabled>

                    </select>
                    <div id="luclocalityError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group form-box">
                    <label for="lucblockno" class="form-label">Block No.</label>
                    <input type="text" name="lucblockno" id="lucblockno"
                        class="form-control alphaNum-hiphenForwardSlash" placeholder="Block No." readonly>
                    <div id="lucblocknoError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group form-box">
                    <label for="lucplotno" class="form-label">Plot No.</label>
                    <input type="text" name="lucplotno" id="lucplotno" class="form-control plotNoAlpaMix"
                        placeholder="Property/Plot No." readonly>
                    <div id="lucplotnoError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group form-box">
                    <label for="lucknownas" class="form-label">Known As (Optional)</label>
                    <input type="text" name="lucknownas" id="lucknownas" class="form-control"
                        placeholder="Knowns As (Optional)" readonly>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group form-box">
                    <label for="lucarea" class="form-label">Area</label>
                    <input type="text" name="lucarea" id="lucarea" class="form-control alpha-only" placeholder="Area"
                        readonly>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="form-group form-box">
                    <label for="leasetype" class="form-label">Lease Type</label>
                    <input type="text" name="leasetype" id="leasetype" class="form-control alpha-only"
                        placeholder="Lease Type" readonly>
                </div>
            </div>
        </div> --}}
        <div class="row g-3 mb-2 mt-3">
            <div class="col-lg-12">
                <div class="part-title mb-2">
                    <h5>Land Use Change Details</h5>
                </div>
            </div>
            <!-- from -->
            <div class="col-lg-3 col-12">
                <div class="form-group">
                    <label for="lucpropertytype" class="form-label">Property Type</label>
                    <select name="lucpropertytype" id="lucpropertytype" class="form-select" disabled>

                    </select>
                    <div id="lucpropertytypeError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="form-group">
                    <label for="lucpropertysubtype" class="form-label">Property Sub Type</label>
                    <select name="lucpropertysubtype" id="lucpropertysubtype" class="form-select" disabled>

                    </select>
                    <div id="lucpropertychangetouseError" class="text-danger text-left"></div>
                </div>
            </div>
            <!-- // from -->
            <!-- to -->
            <div class="col-lg-3 col-12">
                <div class="form-group">
                    <label for="lucpropertytypeto" class="form-label">Change to Property Type<span
                            class="text-danger">*</span></label>
                    <select name="lucpropertytypeto" id="lucpropertytypeto" class="form-select">

                    </select>
                    <div id="lucpropertytypetoError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="form-group">
                    <label for="lucpropertysubtypeto" class="form-label">Change to Property Sub Type<span
                            class="text-danger">*</span> </label>
                    <select name="lucpropertysubtypeto" id="lucpropertysubtypeto" class="form-select">

                    </select>
                    <div id="lucpropertysubtypetoError" class="text-danger text-left"></div>
                </div>
            </div>
            <!--//to-->
        </div>
        <div class="row g-3 estimate d-none">
            <div class="col-lg-12">
                <div class="charges-note-section">
                    <label for="EstimatedCgarges">Estimated Charges</label>
                    <div class="d-flex">
                        <h4 id="estimatedCharges"></h4>
                        <div style="margin-left: 10%;">[<span id="chargesCalculationInfo"></span>]</div>
                    </div>

                    <p id="checkDetailsMessage"></p>
                </div>
            </div>
        </div>
    </div>
</div>