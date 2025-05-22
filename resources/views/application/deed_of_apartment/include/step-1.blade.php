<div class="mt-3">
    <div class="container-fluid">
        <div class="row g-2">
            <div class="col-lg-12">
                <div class="part-title mb-2">
                    <h5>Fill Flat Details</h5>
                </div>
            </div>
            <input type="hidden" id="old_property_id" name="old_property_id"
                value="{{ isset($application) ? $application->old_property_id : old('old_property_id') }}">
            <input type="hidden" id="property_master_id" name="property_master_id"
                value="{{ isset($application) ? $application->property_master_id : old('property_master_id') }}">
            <input type="hidden" id="new_property_id" name="new_property_id"
                value="{{ isset($application) ? $application->new_property_id : old('new_property_id') }}">
            <input type="hidden" id="splited_property_detail_id" name="splited_property_detail_id"
                value="{{ isset($application) ? $application->splited_property_detail_id : old('splited_property_detail_id') }}">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="applicantName" class="form-label">Name<span
                        class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="applicantName" id="applicantName"
                        placeholder="Enter Name"
                        value="{{ isset($userDetails->name) ? $userDetails->name : old('applicantName') }}" readonly>
                    @error('applicantName')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="text-danger" id="applicantNameError"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="applicantAddress" class="form-label">Communication Address<span
                        class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="applicantAddress" id="applicantAddress"
                        placeholder="Enter Communication Address"
                        value="{{ isset($userDetails->applicantUserDetails->address) ? $userDetails->applicantUserDetails->address : old('applicantAddress') }}" readonly>
                    @error('applicantAddress')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="text-danger" id="applicantAddressError"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="buildingName" class="form-label">Building Name<span
                        class="text-danger">*</span> <small class="form-text text-muted">(In
                            which the apartment exists.)</small></label>
                    <input type="text" class="form-control" name="buildingName" id="buildingName"
                        placeholder="Building name"
                        value="{{ isset($application) ? $application->building_name : old('buildingName') }}">
                    @error('buildingName')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="text-danger" id="buildingNameError"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="originalBuyerName" class="form-label">Name Of Original Buyer<span
                        class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="originalBuyerName" id="originalBuyerName"
                        placeholder="Name Of Original Buyer"
                        value="{{ isset($application) ? $application->original_buyer_name : old('originalBuyerName') }}">
                </div>
                @error('originalBuyerName')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="text-danger" id="originalBuyerNameError"></div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="presentOccupantName" class="form-label">Name Of Present Occupant<span
                        class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="presentOccupantName" id="presentOccupantName"
                        placeholder="Name Of Present Occupant"
                        value="{{ isset($application) ? $application->present_occupant_name : old('presentOccupantName') }}">
                </div>
                @error('presentOccupantName')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="text-danger" id="presentOccupantNameError"></div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="purchasedFrom" class="form-label">Purchased From<span
                        class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="purchasedFrom" id="purchasedFrom"
                        placeholder="Purchased From"
                        value="{{ isset($application) ? $application->purchased_from : old('purchasedFrom') }}">
                </div>
                @error('purchasedFrom')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="text-danger" id="purchasedFromError"></div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="purchaseDate" class="form-label">Date of Purchase<span
                        class="text-danger">*</span></label>
                    <input type="date" name="purchaseDate" class="form-control" id="purchaseDate"
                        pattern="\d{2} \d{2} \d{4}"
                        value="{{ isset($application) ? $application->purchased_date : old('purchaseDate') }}">
                </div>
                @error('purchaseDate')
                <span class="errorMsg">{{ $message }}</span>
                @enderror
                <div id="purchaseDateError" class="text-danger"></div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="apartmentArea" class="form-label">Flat Area<span
                        class="text-danger">*</span> <small class="form-text text-muted">(In
                            Sq.
                            Mtr. including common area.)</small></label>
                    <input type="text" class="form-control" name="apartmentArea" id="apartmentArea"
                        placeholder="Flat Area"
                        value="{{ isset($application) ? $application->flat_area : old('apartmentArea') }}">
                </div>
                @error('apartmentArea')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="text-danger" id="apartmentAreaError"></div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="plotArea" class="form-label">Plot Area<span
                        class="text-danger">*</span> <small class="form-text text-muted">(Leased
                            From L&DO in Sq. Mtr.)</small> </label>
                    <input type="text" class="form-control" name="plotArea" id="plotArea"
                        placeholder="Plot Area"
                        value="{{ isset($application) ? $application->plot_area : old('plotArea') }}">
                </div>
                @error('plotArea')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="text-danger" id="plotAreaError"></div>
            </div>
        </div>
    </div>
</div>