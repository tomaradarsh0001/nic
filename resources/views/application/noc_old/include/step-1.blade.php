<div class="mt-3">
    <div class="container-fluid g-0">
        <div class="row g-2">
            <div class="col-lg-12">
                <div class="part-title mb-2">
                    <h5>Name & Details of Registered Applicant</h5>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="nocNameApp" class="form-label">Name</label>
                    <input type="text" name="nocNameApp" class="form-control alpha-only" id="nocNameApp"
                        placeholder="Name" readonly>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="nocGenderApp" class="form-label">Gender</label>
                    <input type="text" name="nocGenderApp" class="form-control alpha-only" id="nocGenderApp"
                        placeholder="Gender" readonly>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="nocDateOfBirth" class="form-label">Date of Birth<span
                            class="text-danger">*</span></label>
                    <div class="mix-field">
                        <input type="date" id="nocDateOfBirthApp" name="nocDateOfBirthApp" max="{{ date('Y-m-d') }}"
                            class="form-control" readonly />
                        <div class="age-box">
                            <h4>Age: </h4>
                            <input type="text" id="nocAgeApp" name="nocAgeApp" class="form-control" placeholder="0"
                                readonly />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <label for="nocFathernameApp" class="form-label">S/o, D/o, Spouse Of</label>
                <div class="input-group mb-3"> <span class="input-group-text" style="border-radius: 0;"
                        id="nocprefixApp"></span>
                    <input type="text" name="nocFathernameApp" id="nocFathernameApp" class="form-control alpha-only"
                        placeholder="Full Name*" readonly>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="nocAadharApp" class="form-label">Aadhaar</label>
                    <input type="text" name="nocAadharApp" class="form-control numericOnly" id="nocAadharApp"
                        maxlength="12" placeholder="Aadhar Number" readonly>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="nocPanApp" class="form-label">PAN</label>
                    <input type="text" name="nocPanApp" class="form-control pan_number_format text-uppercase"
                        id="nocPanApp" maxlength="10" placeholder="PAN Number" readonly>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="nocMobilenumberApp" class="form-label">Mobile Number</label>
                    <input type="text" name="nocMobilenumberApp" class="form-control numericOnly"
                        id="nocMobilenumberApp" maxlength="10" placeholder="Mobile Number" readonly>
                </div>
            </div>
        </div>
        <!-- co applicants ******************************************************** -->
        @include('application.noc.include.coapplicant')

        <div class="row g-2 mt-2" id="conveyanceDeedDetail">
            <div class="col-lg-12">
                <div class="part-title mb-2">
                    <h5 id="">Details of Conveyance Deed</h5>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="conveyanceDeedName" class="form-label">Executed in favour of<span
                            class="text-danger">*</span></label>
                    <input type="text" name="conveyanceDeedName" class="form-control alpha-only"
                        id="conveyanceDeedName" placeholder="Executed in favour of"
                        value="{{ isset($application) ? $application->name_as_per_noc_conv_deed : '' }}" readonly>
                    <div id="conveyanceDeedNameError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="conveyanceExecutedOn" class="form-label">Executed On<span
                            class="text-danger">*</span></label>
                    <input type="date" name="conveyanceExecutedOn" class="form-control" id="conveyanceExecutedOn"
                        placeholder="Executed On"
                        value="{{ isset($application) ? $application->executed_on_as_per_noc_conv_deed : '' }}"
                        readonly>
                    <div id="conveyanceExecutedOnError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="conveyanceRegnoDeed" class="form-label">Regn. No.<span
                            class="text-danger">*</span></label>
                    <input type="text" name="conveyanceRegnoDeed" maxlength="30" class="form-control numericOnly"
                        id="conveyanceRegnoDeed" placeholder="Registration No."
                        value="{{ isset($application) ? $application->reg_no_as_per_noc_conv_deed : '' }}">
                    <div id="conveyanceRegnoDeedError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="conveyanceBookNoDeed" class="form-label">Book No.<span
                            class="text-danger">*</span></label>
                    <input type="text" name="conveyanceBookNoDeed" maxlength="10"
                        class="form-control numericOnly" id="conveyanceBookNoDeed" placeholder="Book No."
                        value="{{ isset($application) ? $application->book_no_as_per_noc_conv_deed : '' }}">
                    <div id="conveyanceBookNoDeedError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="conveyanceVolumeNo" class="form-label">Volume No.<span
                            class="text-danger">*</span></label>

                    <input type="text" name="conveyanceVolumeNo" maxlength="10" class="form-control numericOnly"
                        id="conveyanceVolumeNo" placeholder="Volume No."
                        value="{{ isset($application) ? $application->volume_no_as_per_noc_conv_deed : '' }}">
                    <div id="conveyanceVolumeNoError" class="text-danger text-left"></div>
                </div>
            </div>

            <div class="col-lg-4">
                @php
                    $num1 = $num2 = ''; // Initialize variables
                    if (isset($application)) {
                        $pageNos = $application->page_no_as_per_noc_conv_deed;
                        $numbers = explode('-', $pageNos);
                        $num1 = isset($numbers[0]) ? (int) $numbers[0] : ''; // First number
                        $num2 = isset($numbers[1]) ? (int) $numbers[1] : ''; // Second number
                    }
                @endphp
                <div class="form-group">
                    <label for="conveyancePageNo" class="form-label">Page No.<span
                            class="text-danger">*</span></label>
                    <div class="row merge-inputs">
                        <div class="col-lg-6">
                            <input type="text" name="conveyancePagenoFrom" maxlength="4"
                                class="form-control numericOnly" id="conveyancePagenoFrom" placeholder="From"
                                value="{{ $num1 }}">
                            <div id="conveyancePagenoFromError" class="text-danger text-left"></div>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" name="conveyancePagenoTo" maxlength="4"
                                class="form-control numericOnly" id="conveyancePagenoTo" placeholder="To"
                                value="{{ $num2 }}">
                            <div id="conveyancePagenoToError" class="text-danger text-left"></div>
                        </div>
                    </div>
                    <div id="conveyancePageNoError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="conveyanceRegDate" class="form-label">Regn. Date.<span
                            class="text-danger">*</span></label>
                    <input type="date" name="conveyanceRegDate" class="form-control" id="conveyanceRegDate"
                        value="{{ isset($application) ? $application->reg_date_as_per_noc_conv_deed : '' }}">
                    <div id="conveyanceRegDateError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="conveyanceConAppDate" class="form-label">Date of Conversion Application<span
                            class="text-danger">*</span></label>
                    <input type="date" name="conveyanceConAppDate" class="form-control" id="conveyanceConAppDate"
                        value="{{ isset($application) ? $application->con_app_date_as_per_noc_conv_deed : '' }}">
                    <div id="conveyanceConAppDateError" class="text-danger text-left"></div>
                </div>
            </div>
        </div>
    </div>
</div>
