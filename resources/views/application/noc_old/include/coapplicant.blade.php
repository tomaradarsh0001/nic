<div class="row g-2">
    <div class="col-lg-12">
        <div id="conveyanceRepeater" class="position-relative coapplicant-block">
            <div class="part-title mb-2">
                <h5>Name & Details of Other Co-Applicants</h5>
            </div>
            <div class="position-sticky text-end mt-2"
                style="top: 70px; margin-right: 10px; margin-bottom: 10px; z-index: 9;">
                <button type="button" class="btn btn-primary repeater-add-btn fullwidthbtn" data-toggle="tooltip"
                    data-placement="bottom" title="Click on to add more Co-Applicant below">
                    <i class="bx bx-plus me-0"></i> Add More
                </button>
            </div>
            <!-- Repeater Items -->
            <div class="duplicate-field-tab">
                @php
                    $tempCoapplicant = isset($tempCoapplicant) ? $tempCoapplicant : [];
                @endphp
                @forelse($tempCoapplicant as $coapplicant)
                    <div class="items" data-group="noccoapplicant" data-type='coapplicant'>
                        <!-- Repeater Content -->
                        <input type="hidden" data-name="coapplicantId" value="{{ $coapplicant->id }}">
                        <input type="hidden" data-name="indexNo"
                            value="{{ $coapplicant->index_no ?? $loop->iteration }}"><!-- if index-no is not preset (for old data). then assign loop count-->
                        <div class="item-content mb-2">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="namergapp" class="form-label">Name</label>
                                        <input type="text" name="noccoapplicant" class="form-control alpha-only"
                                            placeholder="Name" id="noccoapplicant" data-name="name"
                                            value="{{ $coapplicant->co_applicant_name }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select" name="gender" id="gender" data-name="gender">
                                            <option value="">Select</option>
                                            <option value="Male"
                                                {{ $coapplicant->co_applicant_gender == 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="Female"
                                                {{ $coapplicant->co_applicant_gender == 'Female' ? 'selected' : '' }}>
                                                Female</option>
                                            <option value="Other"
                                                {{ $coapplicant->co_applicant_gender == 'Other' ? 'selected' : '' }}>
                                                Other
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="dateOfBirth" class="quesLabel form-label">Date of Birth
                                            <!-- <span class="text-danger">*</span> -->
                                        </label>
                                        <div class="mix-field">
                                            <input type="date" id="dateOfBirth" name="dateOfBirth"
                                                value="{{ $coapplicant->co_applicant_age }}" data-name="dateOfBirth"
                                                class="form-control">
                                            <!-- remove max-date attribute form DOB input by anil on 6-02-2025 -->
                                            <div class="age-box">
                                                <h4>Age: </h4>
                                                <input type="text" id="age" name="age" value=""
                                                    data-name="age" class="form-control" placeholder="0" readonly="">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="form-group">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="text" name="age"
                                        class="form-control numericOnly" id="age"
                                        maxlength="2" placeholder="Age" data-name="age" value="{{ $coapplicant->co_applicant_age }}">
                                </div> -->
                                </div>
                                <!-- <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="fathername" class="form-label">Father's
                                        name</label>
                                    <input type="text" name="fathername"
                                        class="form-control alpha-only" id="fathername"
                                        placeholder="Father's Name"
                                        data-name="fathername" value="{{ $coapplicant->co_applicant_father_name }}">
                                </div>
                            </div> -->

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <!-- added form-label class on lable by anil on 27-03-2025 -->
                                        <label for="IndSecondName" class="quesLabel form-label">S/o, D/o, Spouse Of<span
                                                class="text-danger">*</span></label>
                                        <!-- changed title as same mutation by anil on 11-02-2025 -->
                                        <div class="mix-field">
                                            <select name="conPrefixInv" data-name="conPrefixInv" id="prefix"
                                                class="form-select prefix">
                                                <option value="S/o"
                                                    {{ $coapplicant->prefix == 'S/o' ? 'selected' : '' }}>S/o</option>
                                                <option value="D/o"
                                                    {{ $coapplicant->prefix == 'D/o' ? 'selected' : '' }}>D/o</option>
                                                <option value="Spouse Of"
                                                    {{ $coapplicant->prefix == 'Spouse Of' ? 'selected' : '' }}>Spouse
                                                    Of</option>
                                            </select>
                                            <input type="text" name="fathername"
                                                value="{{ $coapplicant->co_applicant_father_name }}"
                                                data-name="fathername" id="IndSecondName"
                                                class="form-control alpha-only" placeholder="Relation">
                                        </div>
                                        <div id="IndSecondNameError" class="text-danger text-left"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="aadhar" class="form-label">Aadhaar</label>
                                        <input type="text" name="aadhar" class="form-control numericOnly"
                                            id="aadhar" maxlength="12" placeholder="Aadhaar Number"
                                            data-name="aadharnumber" value="{{ $coapplicant->co_applicant_aadhar }}">
                                    </div>
                                </div>
                                <!-- ------------------------ -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="photo" class="form-label">Upload Aadhaar</label>
                                        <input type="file" name="noccoapplicant[0][aadhaarFile]"
                                            class="form-control" accept=".pdf" data-name="aadhaarFile">
                                        @if ($coapplicant->aadhaar_file_path != '')
                                            <a href="{{ asset('storage/' . $coapplicant->aadhaar_file_path) }}"
                                                target="_blank" class="fs-6">View Uploaded aadhaar</a>
                                        @endif
                                    </div>
                                </div>
                                <!-- ------------------------ -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pan" class="form-label">PAN</label>
                                        <input type="text" name="pan"
                                            class="form-control pan_number_format text-uppercase" id="pan"
                                            maxlength="10" placeholder="PAN Number" data-name="pannumber"
                                            value="{{ $coapplicant->co_applicant_pan }}">
                                    </div>
                                </div>
                                <!-- ------------------------ -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="photo" class="form-label">Upload PAN</label>
                                        <input type="file" name="noccoapplicant[0][panFile]" class="form-control"
                                            accept=".pdf" data-name="panFile">
                                        @if (isset($coapplicant->pan_file_path))
                                            <a href="{{ asset('storage/' . $coapplicant->pan_file_path ?? '') }}"
                                                target="_blank" class="fs-6">View Uploaded PAN</a>
                                        @endif
                                    </div>
                                </div>
                                <!-- ------------------------ -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="mobilenumber" class="form-label">Mobile
                                            Number</label>
                                        <input type="text" name="mobilenumber" class="form-control numericOnly"
                                            maxlength="10" id="mobilenumber" placeholder="Mobile Number"
                                            data-name="mobilenumber" value="{{ $coapplicant->co_applicant_mobile }}">
                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex justify-content-between">
                                    <div class="form-group form-box">
                                        <label for="photo" class="form-label">Photo</label>
                                        <input type="file" name="noccoapplicantphoto[0][photo]"
                                            class="form-control" accept=".jpg, .png, .jpeg" data-name="photo">
                                    </div>
                                    <div class="preview_img">
                                        <input type="hidden" data-name="preview_img" class="preview_img_hidden"
                                            name="coapplicant[0][preview_img]">
                                        @if (isset($coapplicant) && $coapplicant->image_path)
                                            <img class="preview" alt="Photo Preview"
                                                src="{{ asset('storage/' . $coapplicant->image_path) }}"
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
                                data-placement="bottom" title="Click on to delete this form" editmode="true"
                                onclick="removeRepeater($(this).parents('.items'),'{{ $coapplicant->index_no ?? $loop->iteration }}')">
                                <i class="fadeIn animated bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="items coapplicant-block" data-group="noccoapplicant" data-type='coapplicant'>
                        <!-- add new class coapplicant-block by anil on 10-02-2025 -->
                        <input type="hidden" data-name="indexNo" value="1">
                        <!-- Repeater Content -->
                        <input type="hidden" name="coapplicantId" value="0">
                        <div class="item-content mb-2">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="namergapp" class="form-label">Name</label>
                                        <input type="text" name="noccoapplicant" class="form-control alpha-only"
                                            placeholder="Name" id="noccoapplicant" data-name="name">
                                        <span class="error-message text-danger"></span>
                                        <!-- add span tag by anil on 10-02-2025 -->
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
                                        <!-- add span tag by anil on 10-02-2025 -->
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <!-- <div class="form-group">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="text" name="age"
                                        class="form-control numericOnly" id="age"
                                        maxlength="2" placeholder="Age" data-name="age">
                                </div> -->


                                    <!-- <div class="form-group">
                                    <label for="dateOfBirth" class="quesLabel">Date of Birth<span class="text-danger">*</span></label>
                                    <div class="mix-field">
                                        <input type="date" id="dateOfBirth" name="dateOfBirth" data-name="dateOfBirth" max="2006-12-26" class="form-control">
                                        <div class="age-box">
                                            <h4>Age: </h4>
                                            <input type="text" id="age" name="age"  value="" data-name="age" class="form-control" placeholder="0" readonly="">
                                        </div>
                                    </div>
                                </div> -->
                                    <!-- commented by anil and using new html code for this date of birth on 10-02-2025 -->

                                    <div class="form-group">
                                        <label for="dateOfBirth" class="quesLabel form-label">Date of Birth
                                            <!-- <span class="text-danger">*</span> -->
                                        </label>
                                        <div class="row merge-inputs">
                                            <!-- ui chagnes by anil on 11-02-2025 for relation input merge with error -->
                                            <div class="col-lg-6">
                                                <input type="date" id="dateOfBirth" name="dateOfBirth"
                                                    data-name="dateOfBirth" class="form-control">
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
                                        <!-- ui chagnes by anil on 11-02-2025 for relation input merge with error -->
                                    </div>

                                </div>
                                <!-- <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="fathername" class="form-label">Father's
                                        name</label>
                                    <input type="text" name="fathername"
                                        class="form-control alpha-only" id="fathername"
                                        placeholder="Father's Name"
                                        data-name="fathername">
                                </div>
                            </div> -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <!-- added form-label class on lable by anil on 27-03-2025 -->
                                        <label for="IndSecondName" class="quesLabel form-label">S/o, D/o, Spouse
                                            Of<span class="text-danger">*</span></label>
                                        <div class="row merge-inputs">
                                            <!-- ui chagnes by anil on 11-02-2025 for relation input merge with error -->
                                            <div class="col-lg-6">
                                                <select name="conPrefixInv" data-name="conPrefixInv" id="prefix"
                                                    class="form-select prefix">
                                                    <option value="S/o">S/o</option>
                                                    <option value="D/o">D/o</option>
                                                    <option value="Spouse Of">Spouse Of</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" name="fathername" data-name="fathername"
                                                    id="fathername" class="form-control alpha-only"
                                                    placeholder="Relation">
                                                <span class="error-message text-danger"></span>
                                            </div>
                                        </div>
                                        <!-- ui chagnes by anil on 11-02-2025 for relation input merge with error -->
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="aadhar" class="form-label">Aadhaar</label>
                                        <input type="text" name="aadhar" class="form-control numericOnly"
                                            id="aadhar" maxlength="12" placeholder="Aadhaar Number"
                                            data-name="aadharnumber">
                                        <span class="error-message text-danger"></span>
                                    </div>
                                </div>
                                <!-- ------------------------ -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="photo" class="form-label">Upload Aadhaar</label>
                                        <input type="file" name="noccoapplicant[0][aadhaarFile]"
                                            class="form-control" accept=".pdf" data-name="aadhaarFile">
                                        <span class="error-message text-danger"></span>
                                        <!-- add span tag by anil on 11-02-2025 -->
                                    </div>
                                </div>
                                <!-- ------------------------ -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="pan" class="form-label">PAN</label>
                                        <input type="text" name="pan"
                                            class="form-control pan_number_format text-uppercase" id="pan"
                                            maxlength="10" placeholder="PAN Number" data-name="pannumber">
                                        <span class="error-message text-danger"></span>
                                        <!-- add span tag by anil on 11-02-2025 -->
                                    </div>
                                </div>
                                <!-- ------------------------ -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="photo" class="form-label">Upload PAN</label>
                                        <input type="file" name="noccoapplicant[0][panFile]" class="form-control"
                                            accept=".pdf" data-name="panFile">
                                        <span class="error-message text-danger"></span>
                                    </div>
                                </div>
                                <!-- ------------------------ -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="mobilenumber" class="form-label">Mobile
                                            Number</label>
                                        <input type="text" name="mobilenumber" class="form-control numericOnly"
                                            maxlength="10" id="mobilenumber" placeholder="Mobile Number"
                                            data-name="mobilenumber">
                                        <span class="error-message text-danger"></span>
                                        <!-- add span tag by anil on 11-02-2025 -->
                                    </div>
                                </div>
                                <!-- <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="photo" class="form-label">Photo</label>
                                    <input type="file" name="noccoapplicantphoto[0][photo]" class="form-control" accept=".jpg, .png, .jpeg" data-name="photo">
                                </div>
                            </div> --> <!-- changed UI to fix design and image privew by anil on 11-02-2025 -->

                                <div class="col-lg-4 d-flex justify-content-between">
                                    <div class="form-group form-box">
                                        <label for="photo" class="form-label">Upload Photo</label>
                                        <input type="file" name="noccoapplicantphoto[0][photo]"
                                            class="form-control" accept=".jpg, .png, .jpeg" data-name="photo"
                                            id="noccoapplicantphoto[0][photo]">
                                        <span class="error-message text-danger"></span>
                                    </div>
                                    <div class="preview_img">
                                        <input type="hidden" data-name="preview_img" class="preview_img_hidden"
                                            name="coapplicant[0][preview_img]">
                                        @if (isset($coapplicant) && $coapplicant->image_path)
                                            <img class="preview" alt="Photo Preview"
                                                src="{{ asset('storage/' . $coapplicant->image_path) }}"
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
                                data-placement="bottom" title="Click on to delete this form"
                                onclick="removeRepeater($(this).parents('.items'),1)">
                                <i class="fadeIn animated bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
