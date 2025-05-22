<div class="mt-3">
    <div class="container-fluid g-0"><!-- add g-0 class for alignment by anil on 11-02-2025 -->

        <!-- row end -->
        <div class="row g-2">
            <div class="col-lg-12">
                <div class="part-title mb-2">
                    <h5>Name & Details of Registered Applicant</h5>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="convname" class="form-label">Name</label>
                    <input type="text" name="convname" class="form-control alpha-only"
                        id="convname" placeholder="Name" readonly>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="convgender" class="form-label">Gender</label>
                    <select class="form-select" name="convgender" id="convgender" disabled>
                        <option value="">Gender</option>
                        <option value="Male" selected>Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
            <div class="form-group">
                    <label for="dateOfBirth" class="form-label">Date of Birth<span
                            class="text-danger">*</span></label>
                    <div class="mix-field">
                        <input type="date" id="conDateOfBirth" name="dateOfBirth"
                            max="{{ date('Y-m-d') }}" class="form-control" readonly />
                        <div class="age-box">
                            <h4>Age: </h4>
                            <input type="text" id="conAge" name="age"
                                class="form-control" placeholder="0" readonly />
                        </div>
                    </div>
                </div>
                {{-- <div class="form-group">
                    <label for="convage" class="form-label">Age</label>
                    <input type="text" name="convage" class="form-control numericOnly" id="convage"
                        maxlength="2" placeholder="Age" readonly>
                </div> --}}
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="convfathername" class="form-label">S/o, D/o, Spouse Of</label> <!-- changed title as same mutation by anil on 11-02-2025 -->
                    <div class="input-group mb-3"> <span class="input-group-text" id="convprefixApp"></span>
                        <input type="text" name="fathername" class="form-control alpha-only"
                            id="convfathername" placeholder="Name" readonly>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="convaadhar" class="form-label">Aadhaar</label>
                    <input type="text" name="convaadhar" class="form-control numericOnly"
                        id="convaadhar" maxlength="12" placeholder="Aadhar Number" readonly>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="convpan" class="form-label">PAN</label>
                    <input type="text" name="convpan"
                        class="form-control pan_number_format text-uppercase" id="convpan"
                        maxlength="10" placeholder="PAN Number" readonly>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="convmobilenumber" class="form-label">Mobile Number</label>
                    <input type="text" name="convmobilenumber" class="form-control numericOnly"
                        id="convmobilenumber" maxlength="10" placeholder="Mobile Number" readonly>
                </div>
            </div>
        </div>
        <!-- row end -->



        
        <div class="row g-2">
            <div class="col-lg-12">
                <div id="CONrepeater" class="position-relative conversion-coapplicants">
                    <div class="part-title mb-2">
                        <h5>Name & Details of Other Co-Applicants</h5> <!-- add name in title same as in mutation by anil on 11-02-2025 -->
                    </div>
                    <div class="position-sticky text-end mt-2"
                        style="top: 70px; margin-right: 10px; margin-bottom: 10px; z-index: 9;">
                        <!-- <label>Add Co-Applicant</label> -->
                        <button type="button"
                            class="btn btn-primary repeater-add-btn fullwidthbtn"
                            data-toggle="tooltip" data-placement="bottom"
                            title="Click on to add more Co-Applicant below"><i
                                class="bx bx-plus me-0"></i> Add More</button>
                    </div>

                    <!-- Repeater Items -->
                    <div class="duplicate-field-tab">
                        @php
                        $tempCoapplicant = isset($tempCoapplicant) ? $tempCoapplicant :[];
                        @endphp
                        @forelse($tempCoapplicant as $coapplicant)

                        <div class="items" data-group="convcoapplicant" data-type='coapplicant'>
                            <!-- Repeater Content -->
                            <input type="hidden" data-name="coapplicantId" value="{{$coapplicant->id}}">
                            <input type="hidden" data-name="indexNo" value="{{$coapplicant->index_no ?? $loop->iteration}}"><!-- if index-no is not preset (for old data). then assign loop count-->
                            <div class="item-content mb-2">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="namergapp"
                                                class="form-label">Name</label>
                                            <input type="text" name="convcoapplicant"
                                                class="form-control alpha-only"
                                                placeholder="Name" id="convcoapplicant"
                                                data-name="name" value="{{$coapplicant->co_applicant_name}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="gender"
                                                class="form-label">Gender</label>
                                            <select class="form-select" name="gender"
                                                id="gender" data-name="gender">
                                                <option value="">Select</option>
                                                <option value="Male" {{$coapplicant->co_applicant_gender == "Male" ? "selected":""}}>Male</option>
                                                <option value="Female" {{$coapplicant->co_applicant_gender == "Female" ? "selected":"" }}>Female</option>
                                                <option value="Other" {{$coapplicant->co_applicant_gender == "Other" ? "selected":"" }}>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="dateOfBirth" class="quesLabel">Date of Birth<span class="text-danger">*</span></label>
                                            <div class="mix-field">
                                                <input type="date" id="dateOfBirth" name="dateOfBirth" value="{{$coapplicant->co_applicant_age}}" data-name="dateOfBirth" class="form-control">
                                                <div class="age-box">
                                                    <h4>Age: </h4>
                                                    <input type="text" id="age" name="age"  value="" data-name="age" class="form-control" placeholder="0" readonly="">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- <div class="form-group">
                                            <label for="age" class="form-label">Age</label>
                                            <input type="text" name="age"
                                                class="form-control numericOnly" id="age"
                                                maxlength="2" placeholder="Age" data-name="age" value="{{$coapplicant->co_applicant_age}}">
                                        </div> -->
                                    </div>
                                    <!-- <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="fathername" class="form-label">Father's
                                                name</label>
                                            <input type="text" name="fathername"
                                                class="form-control alpha-only" id="fathername"
                                                placeholder="Father's Name"
                                                data-name="fathername" value="{{$coapplicant->co_applicant_father_name}}">
                                        </div>
                                    </div> -->

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                        <label for="IndSecondName" class="quesLabel">S/o, D/o, Spouse Of<span class="text-danger">*</span></label> <!-- changed title as same mutation by anil on 11-02-2025 -->
                                            <div class="mix-field">
                                                <select name="prefixInv" data-name="prefixInv" id="prefix" class="form-select prefix">
                                                    <option value="S/o" {{ $coapplicant->prefix == 'S/o' ? 'selected' : ''
                                                    }}>S/o</option>
                                                <option value="D/o" {{ $coapplicant->prefix == 'D/o' ? 'selected' : ''
                                                    }}>D/o</option>
                                                <option value="Spouse Of" {{ $coapplicant->prefix == 'Spouse Of' ? 'selected' : ''
                                                    }}>Spouse Of</option>
                                                </select>
                                                <input type="text" name="secondnameInv"  value="{{$coapplicant->co_applicant_father_name}}" data-name="secondnameInv" id="IndSecondName" class="form-control alpha-only" placeholder="Relation">
                                            </div>
                                            <div id="IndSecondNameError" class="text-danger text-left"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="aadhar"
                                                class="form-label">Aadhaar</label>
                                            <input type="text" name="aadhar"
                                                class="form-control numericOnly" id="aadhar"
                                                maxlength="12" placeholder="Aadhar Number"
                                                data-name="aadharnumber" value="{{$coapplicant->co_applicant_aadhar}}">
                                        </div>
                                    </div>
                                    <!-- ------------------------ -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="photo" class="form-label">Upload Aadhaar</label>
                                            <input type="file" name="convcoapplicant[0][aadhaarFile]" class="form-control" accept=".pdf" data-name="aadhaarFile">
                                            @if($coapplicant->aadhaar_file_path != "")
                                            <a href="{{asset('storage/' .$coapplicant->aadhaar_file_path )}}" target="_blank" class="fs-6">View Uploaded aadhaar</a>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- ------------------------ -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pan" class="form-label">PAN</label>
                                            <input type="text" name="pan"
                                                class="form-control pan_number_format text-uppercase"
                                                id="pan" maxlength="10" placeholder="PAN Number"
                                                data-name="pannumber" value="{{$coapplicant->co_applicant_pan}}">
                                        </div>
                                    </div>
                                    <!-- ------------------------ -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="photo" class="form-label">Upload PAN</label>
                                            <input type="file" name="convcoapplicant[0][panFile]" class="form-control" accept=".pdf" data-name="panFile">
                                            @if(isset($coapplicant->pan_file_path))
                                            <a href="{{asset('storage/' .$coapplicant->pan_file_path ?? '')}}" target="_blank" class="fs-6">View Uploaded PAN</a>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- ------------------------ -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="mobilenumber" class="form-label">Mobile
                                                Number</label>
                                            <input type="text" name="mobilenumber"
                                                class="form-control numericOnly" maxlength="10"
                                                id="mobilenumber" placeholder="Mobile Number"
                                                data-name="mobilenumber" value="{{$coapplicant->co_applicant_mobile}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 d-flex justify-content-between">
                                        <div class="form-group form-box">
                                            <label for="photo" class="form-label">Photo</label>
                                            <input type="file" name="convcoapplicantphoto[0][photo]" class="form-control" accept=".jpg, .png, .jpeg" data-name="photo">
                                        </div>
                                        <div class="preview_img">
                                            <input type="hidden" data-name="preview_img" class="preview_img_hidden" name="coapplicant[0][preview_img]">
                                            @if(isset($coapplicant) && $coapplicant->image_path)
                                                <img class="preview" alt="Photo Preview"
                                                    src="{{ asset('storage/' . $coapplicant->image_path) }}" style="display: block;" />
                                            @else
                                                <img class="preview" alt="Photo Preview" />
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- Repeater Remove Btn -->
                            <div class="repeater-remove-btn">
                                <button type="button" class="btn btn-danger remove-btn px-4"
                                    data-toggle="tooltip" data-placement="bottom"
                                    title="Click on to delete this form" onclick="removeRepeater($(this).parents('.items'),'{{$coapplicant->index_no ?? $loop->iteration}}')">
                                    <i class="fadeIn animated bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="items coapplicant-block" data-group="convcoapplicant" data-type='coapplicant'><!-- add new class coapplicant-block by anil on 10-02-2025 -->
                            <input type="hidden" data-name="indexNo" value="1">
                            <!-- Repeater Content -->
                            <input type="hidden" name="coapplicantId" value="0">
                            <div class="item-content mb-2">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="namergapp"
                                                class="form-label">Name</label>
                                            <input type="text" name="convcoapplicant"
                                                class="form-control alpha-only"
                                                placeholder="Name" id="convcoapplicant"
                                                data-name="name">
                                                <span class="error-message text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="gender"
                                                class="form-label">Gender</label>
                                            <select class="form-select" name="gender"
                                                id="gender" data-name="gender">
                                                <option value="">Select</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <span class="error-message text-danger"></span>
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

                                        <div class="form-group">
                                            <label for="dateOfBirth" class="quesLabel">Date of Birth<span class="text-danger">*</span></label>
                                            <div class="row merge-inputs"> <!-- ui chagnes by anil on 11-02-2025 for relation input merge with error -->
                                                <div class="col-lg-6">
                                                    <input type="date" id="dateOfBirth" name="dateOfBirth" data-name="dateOfBirth" class="form-control">
                                                    <span class="error-message text-danger"></span>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="age-box">
                                                        <h4>Age: </h4>
                                                        <input type="text" id="age" name="age"  value="" data-name="age" class="form-control" placeholder="0" readonly="">
                                                    </div>
                                                </div>
                                            </div> <!-- ui chagnes by anil on 11-02-2025 for relation input merge with error -->
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
                                    <!-- <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="IndSecondName" class="quesLabel">Relation<span class="text-danger">*</span></label>
                                            <div class="mix-field">
                                                <select name="conPrefixInv" data-name="conPrefixInv" id="prefix" class="form-select prefix">
                                                    <option value="S/o">S/o</option>
                                                <option value="D/o">D/o</option>
                                                <option value="Spouse Of">Spouse Of</option>
                                                </select>
                                                <input type="text" name="fathername" data-name="fathername" id="fathername" class="form-control alpha-only" placeholder="Relation">
                                            </div>
                                            <div id="IndSecondNameError" class="text-danger text-left"></div>
                                        </div>
                                    </div> -->

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="IndSecondName" class="quesLabel">S/o, D/o, Spouse Of<span class="text-danger">*</span></label>
                                            <div class="row merge-inputs"> <!-- ui chagnes by anil on 11-02-2025 for relation input merge with error -->
                                                <div class="col-lg-6">
                                                    <select name="conPrefixInv" data-name="conPrefixInv" id="prefix" class="form-select prefix">
                                                        <option value="S/o">S/o</option>
                                                    <option value="D/o">D/o</option>
                                                    <option value="Spouse Of">Spouse Of</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" name="fathername" data-name="fathername" id="fathername" class="form-control alpha-only" placeholder="Relation">
                                                    <span class="error-message text-danger"></span>
                                                </div>
                                            </div> <!-- ui chagnes by anil on 11-02-2025 for relation input merge with error -->
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="aadhar"
                                                class="form-label">Aadhaar</label>
                                            <input type="text" name="aadhar"
                                                class="form-control numericOnly" id="aadhar"
                                                maxlength="12" placeholder="Aadhar Number"
                                                data-name="aadharnumber">
                                                <span class="error-message text-danger"></span> <!-- add span tag by anil on 11-02-2025 -->
                                        </div>
                                    </div>
                                    <!-- ------------------------ -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="photo" class="form-label">Upload Aadhaar</label>
                                            <input type="file" name="convcoapplicant[0][aadhaarFile]" class="form-control" accept=".pdf" data-name="aadhaarFile">
                                            <span class="error-message text-danger"></span> <!-- add span tag by anil on 11-02-2025 -->
                                        </div>
                                    </div>
                                    <!-- ------------------------ -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="pan" class="form-label">PAN</label>
                                            <input type="text" name="pan"
                                                class="form-control pan_number_format text-uppercase"
                                                id="pan" maxlength="10" placeholder="PAN Number"
                                                data-name="pannumber">
                                                <span class="error-message text-danger"></span> <!-- add span tag by anil on 11-02-2025 -->
                                        </div>
                                    </div>
                                    <!-- ------------------------ -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="photo" class="form-label">Upload PAN</label>
                                            <input type="file" name="convcoapplicant[0][panFile]" class="form-control" accept=".pdf" data-name="panFile">
                                            <span class="error-message text-danger"></span> <!-- add span tag by anil on 11-02-2025 -->
                                        </div>
                                    </div>
                                    <!-- ------------------------ -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="mobilenumber" class="form-label">Mobile
                                                Number</label>
                                            <input type="text" name="mobilenumber"
                                                class="form-control numericOnly" maxlength="10"
                                                id="mobilenumber" placeholder="Mobile Number"
                                                data-name="mobilenumber">
                                                <span class="error-message text-danger"></span> <!-- add span tag by anil on 11-02-2025 -->
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="photo" class="form-label">Photo</label>
                                            <input type="file" name="convcoapplicantphoto[0][photo]" class="form-control" accept=".jpg, .png, .jpeg" data-name="photo">
                                        </div>
                                    </div> -->

                                    <div class="col-lg-4 d-flex justify-content-between">
                                        <!-- <div class="form-group form-box">
                                            <label for="photo" class="form-label">Photo</label>
                                            <input type="file" name="convcoapplicantphoto[0][photo]" class="form-control" accept=".jpg, .png, .jpeg" data-name="photo">
                                        </div> -->
                                        <div class="form-group form-box">
                                            <label for="photo" class="form-label">Upload Photo</label>
                                            <input type="file" name="convcoapplicantphoto[0][photo]" class="form-control" accept=".jpg, .png, .jpeg" data-name="photo" id="convcoapplicantphoto[0][photo]">
                                            <span class="error-message text-danger"></span>
                                        </div>
                                        <div class="preview_img">
                                            <input type="hidden" data-name="preview_img" class="preview_img_hidden" name="coapplicant[0][preview_img]">
                                            @if(isset($coapplicant) && $coapplicant->image_path)
                                                <img class="preview" alt="Photo Preview"
                                                    src="{{ asset('storage/' . $coapplicant->image_path) }}" style="display: block;" />
                                            @else
                                                <img class="preview" alt="Photo Preview" />
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- Repeater Remove Btn -->
                            <div class="repeater-remove-btn">
                                <button type="button" class="btn btn-danger remove-btn px-4"
                                    data-toggle="tooltip" data-placement="bottom"
                                    title="Click on to delete this form" onclick="removeRepeater($(this).parents('.items'),1)">
                                    <i class="fadeIn animated bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforelse

                    </div>
                </div>
            </div>

        </div>
        <!-- row end -->



        <div class="row g-2 mt-2" id="convLeaseDeed"> <!-- convLeaseDeed id added by anil on 24-02-2025 for Regn. No. because of mutation and conversion Regn. No. have same id  -->
            <div class="col-lg-12">
                <div class="part-title mb-2">
                    <h5 id="freeleasetitle">Details of Lease Deed</h5>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="convNameAsOnLease" class="form-label">Executed in favour of<span class="text-danger">*</span></label>
                    <input type="text" name="convNameAsOnLease" class="form-control alpha-only" id="convNameAsOnLease" placeholder="Executed in favour of" value="{{ isset($application) ? $application->name_as_per_lease_conv_deed : '' }}" readonly>
                    <div id="convNameAsOnLeaseError" class="text-danger text-left"></div>
                </div>
            </div>
            <!-- <div class="col-lg-4">
                <div class="form-group">
                    <label for="fathername" class="form-label">Father's name</label>
                    <input type="text" name="fathername" class="form-control alpha-only"
                        id="fathername" placeholder="Father's Name">
                </div>
            </div> -->
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="convExecutedOnAsOnLease" class="form-label">Executed On<span class="text-danger">*</span></label>
                    <input type="date" name="convExecutedOnAsOnLease" class="form-control" id="convExecutedOnAsOnLease"
                        placeholder="Executed On" value="{{ isset($application) ? $application->executed_on : '' }}" readonly>
                    <div id="convExecutedOnAsOnLeaseError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="regno" class="form-label">Regn. No.<span class="text-danger">*</span></label>
                    <input type="text" name="convRegnoAsOnLease" maxlength="30" class="form-control numericOnly" id="regno" placeholder="Registration No." value="{{ isset($application) ? $application->reg_no : '' }}">
                    <div id="regnoError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="bookno" class="form-label">Book No.<span class="text-danger">*</span></label>
                    <input type="text" name="convBooknoAsOnLease" maxlength="10" class="form-control numericOnly" id="convbookno" placeholder="Book No." value="{{ isset($application) ? $application->book_no : '' }}">
                    <div id="convbooknoError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="volumeno" class="form-label">Volume No.<span class="text-danger">*</span></label>
                    <input type="text" name="convVolumenoAsOnLease" maxlength="10" class="form-control numericOnly" id="convvolumeno" placeholder="Volume No." value="{{ isset($application) ? $application->volume_no : '' }}">
                    <div id="convvolumenoError" class="text-danger text-left"></div>
                </div>
            </div>
            @php
            $page_no_from = $page_no_to = '';
            if(isset($application) && !is_null($application->page_no)){
            list($page_no_from, $page_no_to) = explode('-',$application->page_no);
            }
            @endphp
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="pageno" class="form-label">Page No.<span class="text-danger">*</span></label>
                    <div class="row merge-inputs"> <!-- ui chagnes in class by anil on 11-02-2025 as same relation input merge with error -->
                        <div class="col-lg-6">
                            <input type="text" name="convPagenoFrom" maxlength="4" class="form-control numericOnly" id="convPagenoFrom" placeholder="From" value="{{ $page_no_from }}">
                            <div id="convPagenoFromError" class="text-danger text-left"></div>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" name="convPagenoTo" maxlength="4" class="form-control numericOnly" id="convPagenoTo" placeholder="To" value="{{ $page_no_to }}">
                            <div id="convPagenoToError" class="text-danger text-left"></div>
                        </div>
                    </div> <!-- ui chagnes by anil on 11-02-2025 for relation input merge with error -->
                    {{--<div class="mix-field">
                        <input type="text" name="convPagenoFrom" class="form-control numericOnly" id="convPagenoFrom" placeholder="From" value="{{ $page_no_from }}">
                        <span class="w-10">-</span>
                        <input type="text" name="convPagenoTo" class="form-control numericOnly" id="convPagenoTo" placeholder="To" value="{{ $page_no_to }}">
                    </div>
                    <div class="row">
                        <div class="col-lg-5"><input type="text" name="convPagenoFrom" class="form-control numericOnly" id="convPagenoFrom" placeholder="From" value="{{ $page_no_from }}"></div>
                        <div class="col-lg-2">&hyphen;</div>
                        <div class="col-lg-5"><input type="text" name="convPagenoTo" class="form-control numericOnly" id="convPagenoTo" placeholder="To" value="{{ $page_no_to }}"></div>
                    </div> --}}
                    <!-- <input type="text" name="convPagenoAsOnLease" class="form-control numericOnly" id="pageno" placeholder="Page No." value="{{ isset($application) ? $application->page_no_as_per_lease_conv_deed : '' }}"> -->
                    <div id="pagenoError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="regdate" class="form-label">Regn. Date.<span class="text-danger">*</span></label>
                    <input type="date" name="convRegdateAsOnLease" class="form-control" id="convregdate" value="{{ isset($application) ? $application->reg_date : '' }}">
                    <div id="convregdateError" class="text-danger text-left"></div>
                </div>
            </div>
        </div>
        <!-- row end -->
        <div class="container-fluid">
        <div class="row row-mb-2">
                <div class="col-lg-12 items">
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center">
                        <h6 class="mr-5 mb-0">Whether the application is on basis of court order?
                        </h6>
                        <div class="form-check mr-5">
                            <input class="form-check-input" name="courtorderConversion" type="radio"
                                value="1" id="YesCourtOrderConversion" {{isset($application) && $application-> is_court_order ? 'checked':''}}>
                            <label class="form-check-label" for="YesCourtOrderConversion">
                                <h6 class="mb-0">Yes</h6>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="courtorderConversion" type="radio"
                                value="0" id="NoCourtOrderConversion" {{isset($application) && $application-> is_court_order ? '':'checked'}}>
                            <label class="form-check-label" for="NoCourtOrderConversion">
                                <h6 class="mb-0">No</h6>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="yescourtorderConversionDiv" {{ isset($application) && $application->is_court_order ? '' : 'style=display:none;' }}>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="casenosubmut" class="form-label">Case No.<span class="text-danger">*</span></label>
                                <input type="text" name="convCaseNo" class="form-control alphaNum-hiphenForwardSlash" id="convCaseNo" placeholder="Case No." value="{{isset($application) ?  $application-> case_no :''}}">
                                <div id="convCaseNoError" class="text-danger text-left"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="convCaseDetail" class="form-label">Details</label>
                                <textarea name="convCaseDetail" id="convCaseDetail" class="form-control">{{isset($application) ?  $application-> case_detail :''}}</textarea>
                                <div id="convCaseDetailError" class="text-danger text-left"></div>
                            </div>
                        </div>
                        @php
                        $courtOrder = null;
                        if(isset($application) && $application->tempDocument){
                        $courtOrder = $application->tempDocument->where('document_type','convCourtOrderFile')->first();
                        }
                        @endphp
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group form-box">
                                    <label for="convCourtOrderFile" class="quesLabel" data-toggle="tooltip" data-placement="top" title="Certified copies of any court order / decree">Court Order / Decree <span><i class='bx bx-info-circle'></i></span></label>
                                    <input type="file" name="convCourtOrderFile" class="form-control"
                                        accept="application/pdf" id="convCourtOrderFile" data-should-validate = "{{isset($courtOrder) && $courtOrder->file_path != ''}}">
                                    @if($courtOrder)
                                    <a href="{{asset('storage/' .$courtOrder->file_path ?? '')}}" target="_blank">View saved document</a>
                                    @endif
                                    <div id="convCourtOrderFileError" class="text-danger text-left">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="convCourtOrderDate">Date of Document</label>
                                    @php
                                    if($courtOrder){
                                    $courtOrderDate = $courtOrder->tempDocumentKeys->where('key','convCourtOrderDate')->first();
                                    }
                                    @endphp
                                    <input type="date" name="convCourtOrderDate" class="form-control" id="convCourtOrderDate" value="{{empty($courtOrderDate) ?'':$courtOrderDate->value }}">
                                    <div id="convCourtOrderDateError" class="text-danger text-left"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="courtorderattestedbyConversion">IIssuing Agency</label>
                                    @php
                                    if($courtOrder){
                                    $courtOrderIssuingAuthority = $courtOrder->tempDocumentKeys->where('key','courtorderattestedbyConversion')->first();
                                    }
                                    @endphp
                                    <input type="text" name="courtorderattestedbyConversion" class="form-control alpha-only" id="courtorderattestedbyConversion" placeholder="Issuing Agency" value="{{empty($courtOrderIssuingAuthority) ?'':$courtOrderIssuingAuthority->value }}">
                                    <div id="courtorderattestedbyConversionError" class="text-danger text-left"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- row end -->

            <div class="row row-mb-2">
                 <div class="col-lg-12 items">
                     <div class="row">
                         <div class="col-lg-6">
                             <div class="d-flex align-items-center">
                                <h6 class="mr-5 mb-0">Is property mortgaged?</h6>
                                <div class="form-check mr-5">
                                    <input class="form-check-input" name="propertymortgagedConversion" id="YesMortgagedConversion" type="radio"
                                        value="1" {{ isset($application) && $application->is_mortgaged == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="YesMortgagedConversion">
                                        <h6 class="mb-0">Yes</h6>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="propertymortgagedConversion" type="radio"
                                        value="0" id="NoMortgagedConversion" {{ isset($application) && $application->is_mortgaged ==1 ? '':'checked' }}>
                                    <label class="form-check-label" for="NoMortgagedConversion">
                                        <h6 class="mb-0">No</h6>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" id="yesRemarksDivConversion" {{ isset($application) && $application->is_mortgaged ==1 ? '' : 'style=display:none;' }}>
                            @php
                            $morgageNOC = null;
                            if(isset($application) && $application->tempDocument){
                            $morgageNOC = $application->tempDocument->where('document_type','mortgageNoCFile')->first();
                            $NOCAttestationDateConversion = !empty($morgageNOC) ? $morgageNOC->tempDocumentKeys->where('key', 'NOCAttestationDateConversion')->first() : null;
                            $NOCIssuedByConversion = !empty($morgageNOC) ? $morgageNOC->tempDocumentKeys->where('key', 'NOCIssuedByConversion')->first() : null;
                            }
                            @endphp
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group form-box">
                                        <label for="convMortgageeBankNOC" class="quesLabel" data-toggle="tooltip" data-placement="top" title="NOC from Mortgage Bank/Authority">NOC from Mortgage Bank/Authority <span><i class='bx bx-info-circle'></i></span></label>
                                        <input type="file" name="convMortgageeBankNOC" class="form-control" accept="application/pdf" id="convMortgageeBankNOC" data-should-validate = "{{isset($morgageNOC) && $morgageNOC->file_path != ''}}"> <!-- added custome attribute for draft by anil on 11-03-2025 -->
                                        @if ($morgageNOC)
                                        <a href="{{asset('storage/' .$morgageNOC->file_path ?? '')}}" target="_blank">View saved document</a>
                                        @endif
                                        <div id="convMortgageeBankNOCError" class="text-danger text-left"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="NOCAttestationDateConversion">Date of Document</label>
                                        <input type="date" name="NOCAttestationDateConversion" class="form-control" id="NOCAttestationDateConversion" value="{{!empty($NOCAttestationDateConversion) ? $NOCAttestationDateConversion->value:''}}">
                                        <div id="NOCAttestationDateConversionError" class="text-danger text-left"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="NOCIssuedByConversion">Issuing Agency</label>
                                        <input type="text" name="NOCIssuedByConversion" class="form-control alpha-only" id="NOCIssuedByConversion"
                                            placeholder="Issuing Agency" value="{{!empty($NOCIssuedByConversion) ? $NOCIssuedByConversion->value:''}}">
                                            <div id="NOCIssuedByConversionError" class="text-danger text-left"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>







       


    </div>
</div>