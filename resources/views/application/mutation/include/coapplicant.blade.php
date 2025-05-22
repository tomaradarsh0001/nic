<!-- row end -->
<style>
    .age-box {
        display: flex;
        align-items: center;
        width: 45%;
        background: #e9ecef;
        border: 1px solid #b0b0b0;
        border-left: 0px;
        padding: 0px 0px 0px 10px;
    }
</style>
@php
    $isEditDisabled = !empty($application->id) && request()->is('applications/edit*');
@endphp
<div class="row g-2">
    <div class="col-lg-12">
        <div id="repeater" class="position-relative">
            <div class="part-title align-items-center">
                <div class="col-12 col-lg-12">
                    <h5>Name & Details of Other Co-Applicants</h5>
                </div>
            </div>
            <div class="position-sticky text-end mt-2"
                style="top: 70px; margin-right: 10px; margin-bottom: 10px; z-index: 9;">
                <button type="button" class="btn btn-primary repeater-add-btn fullwidthbtn" data-toggle="tooltip"
                    data-placement="bottom" title="Click here to add more co-applicant."><i
                        class="bx bx-plus me-0"></i> Add
                    More</button>
            </div>
            <!-- Repeater Items -->
            <div class="duplicate-field-tab">
                @if (isset($tempCoapplicant) && count($tempCoapplicant) > 0)
                    @foreach ($tempCoapplicant as $index => $tc)
                        <div class="items coapplicant-block" data-group="coapplicant" data-type='coapplicant'>
                            <!-- Repeater Content -->
                            <input type="hidden" data-name="coapplicantId" value="{{ $tc->id }}">
                            <input type="hidden" data-name="indexNo" value="{{ $tc->index_no ?? $loop->iteration }}">
                            <!-- Repeater Content -->
                            <div class="item-content mb-2">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="" class="form-label">Name</label>
                                            <input type="text" name="testname" class="form-control alpha-only"
                                                placeholder="Name" id="" data-name="name"
                                                value="{{ $tc->co_applicant_name }}">
                                            <!-- add error span tag by anil on 03-04-2025 for show error in draft view-->
                                            <span class="error-message text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-select" name="gender" id="gender"
                                                data-name="gender">
                                                <option value="">Select</option>
                                                <option value="Male"
                                                    {{ $tc->co_applicant_gender == 'Male' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="Female"
                                                    {{ $tc->co_applicant_gender == 'Female' ? 'selected' : '' }}>Female
                                                </option>
                                                <option value="Other"
                                                    {{ $tc->co_applicant_gender == 'Other' ? 'selected' : '' }}>Other
                                                </option>
                                            </select>
                                            <!-- add error span tag by anil on 03-04-2025 for show error in draft view-->
                                            <span class="error-message text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="dateOfBirth" class="quesLabel form-label">Date of Birth</label>
                                            <div class="row merge-inputs">
                                                <div class="col-lg-6">
                                                    <input type="date" id="dateOfBirth" name="dateOfBirth"
                                                        value="{{ $tc->co_applicant_age }}" data-name="dateOfBirth"
                                                        class="form-control">
                                                    <!-- add error span tag by anil on 03-04-2025 for show error in draft view-->
                                                    <span class="error-message text-danger"></span>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="age-box">
                                                        <h4>Age: </h4>
                                                        <input type="text" id="age" name="age"
                                                            value="" data-name="age" class="form-control"
                                                            placeholder="0" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="text" name="age" class="form-control numericOnly" id="age"
                                        maxlength="2" placeholder="Age" data-name="age"
                                        value="{{ $tc->co_applicant_age }}">
                                </div> -->
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <!-- added form-label class on lable by anil on 27-03-2025 -->
                                            <label for="IndSecondName" class="quesLabel form-label">S/o, D/o, Spouse
                                                Of</label>
                                            <div class="row merge-inputs">
                                                <div class="col-lg-6">
                                                    <select name="prefixInv" data-name="prefixInv" id="prefix"
                                                        class="form-select prefix">

                                                        <option value="S/o"
                                                            {{ $tc->prefix == 'S/o' ? 'selected' : '' }}>S/o</option>
                                                        <option value="D/o"
                                                            {{ $tc->prefix == 'D/o' ? 'selected' : '' }}>D/o</option>
                                                        <option value="Spouse Of"
                                                            {{ $tc->prefix == 'Spouse Of' ? 'selected' : '' }}>Spouse
                                                            Of</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" name="secondnameInv"
                                                        value="{{ $tc->co_applicant_father_name }}"
                                                        data-name="secondnameInv" id="IndSecondName"
                                                        class="form-control alpha-only" placeholder="Relation">
                                                    <!-- add error span tag by anil on 03-04-2025 for show error in draft view-->
                                                    <span class="error-message text-danger"></span>
                                                </div>
                                            </div>
                                            <div id="IndSecondNameError" class="text-danger text-left"></div>
                                        </div>
                                        <!-- <div class="form-group">
                                    <label for="fathername" class="form-label">Father's
                                        name</label>
                                    <input type="text" name="fathername" class="form-control alpha-only" id="fathername"
                                        placeholder="Father's Name" data-name="fathername"
                                        value="{{ $tc->co_applicant_father_name }}">
                                </div> -->
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="aadhar" class="form-label">Aadhaar Number</label>
                                            <input type="text" name="aadhar" class="form-control numericOnly"
                                                id="aadhar" maxlength="12" placeholder="Aadhaar Number"
                                                data-name="aadharnumber" value="{{ $tc->co_applicant_aadhar }}">
                                            <!-- add error span tag by anil on 03-04-2025 for show error in draft view-->
                                            <span class="error-message text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="coapplicant_0_aadhaarfile" class="form-label">Upload
                                                Aadhaar</label>
                                            <input type="file" name="coapplicant[0][aadhaarFile]"
                                                class="form-control" accept=".pdf" data-name="aadhaarFile"
                                                id="coapplicant_0_aadhaarfile"
                                                data-should-validate = "{{ isset($tc) && $tc->aadhaar_file_path != '' }}"
                                                @if ($isEditDisabled) disabled @endif>
                                            @if (isset($tc->aadhaar_file_path))
                                                <a href="{{ asset('storage/' . $tc->aadhaar_file_path ?? '') }}"
                                                    target="_blank" class="fs-6">View Uploaded Aadhaar</a>
                                            @endif
                                            <!-- add error span tag by anil on 03-04-2025 for show error in draft view-->
                                            <span class="error-message text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pan" class="form-label">PAN Number</label>
                                            <input type="text" name="pan"
                                                class="form-control pan_number_format text-transform-uppercase" id="pan"
                                                maxlength="10" placeholder="PAN Number" data-name="pannumber"
                                                value="{{ $tc->co_applicant_pan }}">
                                            <!-- add error span tag by anil on 03-04-2025 for show error in draft view-->
                                            <span class="error-message text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="coapplicant_0_panfile" class="form-label">Upload PAN</label>
                                            <input type="file" name="coapplicant[0][panFile]" class="form-control"
                                                accept=".pdf" data-name="panFile" id="coapplicant_0_panfile"
                                                data-should-validate = "{{ isset($tc) && $tc->pan_file_path != '' }}"
                                                @if ($isEditDisabled) disabled @endif>
                                            @if (isset($tc->pan_file_path))
                                                <a href="{{ asset('storage/' . $tc->pan_file_path ?? '') }}"
                                                    target="_blank" class="fs-6">View Uploaded PAN</a>
                                            @endif
                                            <!-- add error span tag by anil on 03-04-2025 for show error in draft view-->
                                            <span class="error-message text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="mobilenumber" class="form-label">Mobile
                                                Number</label>
                                            <input type="text" name="mobilenumber"
                                                class="form-control numericOnly" maxlength="10" id="mobilenumber"
                                                placeholder="Mobile Number" data-name="mobilenumber"
                                                value="{{ $tc->co_applicant_mobile }}">
                                            <!-- add error span tag by anil on 03-04-2025 for show error in draft view-->
                                            <span class="error-message text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 d-flex justify-content-between" id="coapplicant_0">
                                        <div class="form-group form-box">
                                            <label for="coapplicant_0_photo" class="form-label">Upload Passport Size
                                                Photo</label>
                                            <input type="file" name="coapplicant[0][photo]" class="form-control"
                                                accept=".jpg, .jpeg, image/jpeg" data-name="photo"
                                                id="coapplicant_0_photo"
                                                data-should-validate = "{{ isset($tc->image_path) && $tc->image_path != '' }}"
                                                @if ($isEditDisabled) disabled @endif>
                                            <!-- add error span tag by anil on 03-04-2025 for show error in draft view-->
                                            <span class="error-message text-danger"></span>
                                        </div>
                                        <div class="preview_img">
                                            <input type="hidden" data-name="preview_img" class="preview_img_hidden"
                                                name="coapplicant[0][preview_img]">
                                            @if (isset($tc->image_path) && $tc->image_path)
                                                <img class="preview" alt="Photo Preview"
                                                    src="{{ asset('storage/' . $tc->image_path) }}"
                                                    style="display: block;" />
                                            @else
                                                <img class="preview" alt="Photo Preview" />
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Repeater Remove Btn -->
                            <div class="repeater-remove-btn">
                                <button type="button" class="btn btn-danger remove-btn px-4" data-toggle="tooltip"
                                    data-placement="bottom" title="Click on to delete this co-applicant."
                                    @if ($isEditDisabled) not-deletable="ture" @endif>
                                    <i class="fadeIn animated bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="items coapplicant-block" data-group="coapplicant" data-type='coapplicant'>
                        <input type="hidden" data-name="indexNo" value="1">
                        <!-- Repeater Content -->
                        <input type="hidden" name="coapplicantId" value="null">
                        <!-- <input type="hidden" data-name="coapplicantId" value="0" name="coapplicant[0][coapplicantId]" id="coapplicant_0_coapplicantid"></input> -->
                        <!-- <div class="items coapplicant-block" data-group="coapplicant"> -->
                        <div class="item-content mb-2">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="namergapp" class="form-label">Name</label>
                                        <input type="text" name="namergapp" class="form-control alpha-only"
                                            placeholder="Name" id="namergapp" data-name="name">
                                        <span class="error-message text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select" name="gender" id="gender"
                                            data-name="gender">
                                            <option value="">Select</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <span class="error-message text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="dateOfBirth" class="quesLabel form-label">Date of Birth</label>
                                        <div class="row merge-inputs">
                                            <div class="col-lg-6">
                                                <input type="date" id="dateOfBirth" data-name="dateOfBirth"
                                                    name="dateOfBirth" class="form-control">
                                                <span class="error-message text-danger"></span>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="age-box">
                                                    <h4>Age: </h4>
                                                    <input type="text" id="age" data-name="age"
                                                        name="age" class="form-control" placeholder="0"
                                                        readonly="">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="text" name="age" class="form-control numericOnly" id="age"
                                        maxlength="2" placeholder="Age" data-name="age">
                                </div> -->
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="IndSecondName" class="quesLabel form-label">S/o, D/o, Spouse
                                            Of</label>
                                        <div class="row merge-inputs">
                                            <div class="col-lg-6">
                                                <select name="prefixInv" id="prefix" data-name="prefixInv"
                                                    class="form-select prefix">
                                                    <option value="S/o">S/o</option>
                                                    <option value="D/o">D/o</option>
                                                    <option value="Spouse Of">Spouse Of</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" name="secondnameInv" data-name="secondnameInv"
                                                    id="IndSecondName" class="form-control alpha-only"
                                                    placeholder="Relation">
                                                <span class="error-message text-danger"></span>
                                            </div>
                                        </div>
                                        <!-- <div id="IndSecondNameError" class="text-danger text-left"></div> -->
                                    </div>
                                    <!-- <div class="form-group">
                                    <label for="fathername" class="form-label">Father's
                                        name</label>
                                    <input type="text" name="fathername" class="form-control alpha-only" id="fathername"
                                        placeholder="Father's Name" data-name="fathername">
                                </div> -->
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="aadhar" class="form-label">Aadhaar Number</label>
                                        <input type="text" name="aadhar" class="form-control numericOnly"
                                            id="aadhar" maxlength="12" placeholder="Aadhaar Number"
                                            data-name="aadharnumber">
                                        <span class="error-message text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="coapplicant_0_aadhaarfile" class="form-label">Upload
                                            Aadhaar</label>
                                        <input type="file" name="coapplicant[0][aadhaarFile]" class="form-control"
                                            accept=".pdf" data-name="aadhaarFile" id="coapplicant_0_aadhaarfile">
                                        <span class="error-message text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pan" class="form-label">PAN Number</label>
                                        <input type="text" name="pan"
                                            class="form-control pan_number_format text-transform-uppercase" id="pan"
                                            maxlength="10" placeholder="PAN Number" data-name="pannumber">
                                        <span class="error-message text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="coapplicant_0_panfile" class="form-label">Upload PAN</label>
                                        <input type="file" name="coapplicant[0][panFile]" class="form-control"
                                            accept=".pdf" data-name="panFile" id="coapplicant_0_panfile">
                                        <span class="error-message text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="mobilenumber" class="form-label">Mobile
                                            Number</label>
                                        <input type="text" name="mobilenumber" class="form-control numericOnly"
                                            maxlength="10" id="mobilenumber" placeholder="Mobile Number"
                                            data-name="mobilenumber">
                                        <span class="error-message text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex justify-content-between">
                                    <div class="form-group form-box">
                                        <label for="coapplicant_0_photo" class="form-label">Upload Passport Size
                                            Photo</label>
                                        <input type="file" name="coapplicant[0][photo]" class="form-control"
                                            data-name="photo" accept=".jpg, .jpeg, image/jpeg"
                                            id="coapplicant_0_photo">
                                        <span class="error-message text-danger"></span>
                                    </div>
                                    <div class="preview_img">
                                        <input type="hidden" data-name="preview_img" class="preview_img_hidden"
                                            name="coapplicant[0][preview_img]">
                                        <img class="preview" alt="Photo Preview" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Repeater Remove Btn -->
                        <div class="repeater-remove-btn">
                            <button type="button" class="btn btn-danger remove-btn px-4" data-toggle="tooltip"
                                data-placement="bottom" title="Click here to delete this co-applicant.">
                                <i class="fadeIn animated bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- row end -->
