<div class="mt-3">
    <div class="container-fluid">

        <!-- row end -->
        <div class="row g-2">
            <div class="col-lg-12">
                <div class="part-title mb-2">
                    <h5>Details of Registered Applicant</h5>
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
                    <label for="convage" class="form-label">Age</label>
                    <input type="text" name="convage" class="form-control numericOnly" id="convage"
                        maxlength="2" placeholder="Age" readonly>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="convfathername" class="form-label">Relation</label>
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
                        <h5>Details of Other Co-Applicants</h5>
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
                                                <input type="date" id="dateOfBirth" name="dateOfBirth" value="{{$coapplicant->co_applicant_age}}" data-name="dateOfBirth" max="2006-12-26" class="form-control">
                                                <div class="age-box">
                                                    <h4>Age: </h4>
                                                    <input type="text" id="age" name="age"  value="" data-name="age" class="form-control" placeholder="0" readonly="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="IndSecondName" class="quesLabel">Relation<span class="text-danger">*</span></label>
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
                                    <div class="col-lg-4 mix-field">
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
                        <div class="items" data-group="convcoapplicant" data-type='coapplicant'>
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
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="age" class="form-label">Age</label>
                                            <input type="text" name="age"
                                                class="form-control numericOnly" id="age"
                                                maxlength="2" placeholder="Age" data-name="age">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="fathername" class="form-label">Father's
                                                name</label>
                                            <input type="text" name="fathername"
                                                class="form-control alpha-only" id="fathername"
                                                placeholder="Father's Name"
                                                data-name="fathername">
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
                                        </div>
                                    </div>
                                    <!-- ------------------------ -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="photo" class="form-label">Upload Aadhaar</label>
                                            <input type="file" name="convcoapplicant[0][aadhaarFile]" class="form-control" accept=".pdf" data-name="aadhaarFile">
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
                                        </div>
                                    </div>
                                    <!-- ------------------------ -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="photo" class="form-label">Upload PAN</label>
                                            <input type="file" name="convcoapplicant[0][panFile]" class="form-control" accept=".pdf" data-name="panFile">
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
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="photo" class="form-label">Photo</label>
                                            <input type="file" name="convcoapplicantphoto[0][photo]" class="form-control" accept=".jpg, .png, .jpeg" data-name="photo">
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
        <div class="row g-2 mt-2">
            <div class="col-lg-12">
                <div class="part-title mb-2">
                    <h5 id="freeleasetitle">Details of Lease Deed</h5>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="convNameAsOnLease" class="form-label">Executed in favour of<span class="text-danger">*</span></label>
                    <input type="text" name="convNameAsOnLease" class="form-control alpha-only" id="convNameAsOnLease" placeholder="Executed in favour of" value="{{ isset($application) ? $application->applicant_name : '' }}">
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
                        placeholder="Executed On" value="{{ isset($application) ? $application->executed_on : '' }}">
                    <div id="convExecutedOnAsOnLeaseError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="regno" class="form-label">Regn. No.<span class="text-danger">*</span></label>
                    <input type="text" name="convRegnoAsOnLease" class="form-control numericOnly" id="regno" placeholder="Registration No." value="{{ isset($application) ? $application->reg_no : '' }}">
                    <div id="regnoError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="bookno" class="form-label">Book No.<span class="text-danger">*</span></label>
                    <input type="text" name="convBooknoAsOnLease" class="form-control numericOnly" id="bookno" placeholder="Book No." value="{{ isset($application) ? $application->book_no : '' }}">
                    <div id="booknoError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="volumeno" class="form-label">Volume No.<span class="text-danger">*</span></label>
                    <input type="text" name="convVolumenoAsOnLease" class="form-control numericOnly" id="volumeno" placeholder="Volume No." value="{{ isset($application) ? $application->volume_no : '' }}">
                    <div id="volumenoError" class="text-danger text-left"></div>
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
                    <div class="row">
                        <div class="col-lg-5"><input type="text" name="convPagenoFrom" class="form-control numericOnly" id="convPagenoFrom" placeholder="From" value="{{ $page_no_from }}"></div>
                        <div class="col-lg-2">&hyphen;</div>
                        <div class="col-lg-5"><input type="text" name="convPagenoTo" class="form-control numericOnly" id="convPagenoTo" placeholder="To" value="{{ $page_no_to }}"></div>
                    </div>
                    <!-- <input type="text" name="convPagenoAsOnLease" class="form-control numericOnly" id="pageno" placeholder="Page No." value="{{ isset($application) ? $application->page_no_as_per_lease_conv_deed : '' }}"> -->
                    <div id="pagenoError" class="text-danger text-left"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="regdate" class="form-label">Regn. Date.<span class="text-danger">*</span></label>
                    <input type="date" name="convRegdateAsOnLease" class="form-control" id="regdate" value="{{ isset($application) ? $application->reg_date : '' }}">
                    <div id="regdateError" class="text-danger text-left"></div>
                </div>
            </div>
        </div>
        <!-- row end -->
         <div class="container-fluid">
             <div class="row row-mb-2">
                <div class="col-lg-12 items">
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center">
                            <h6 class="mr-5">Whether the application is on basis of court order?
                            </h6>
                            <div class="form-check mr-5">
                                <label class="form-check-label" for="YesCourtOrderConversion">
                                    <h6 class="mb-0"><h6 class="mb-0">{{ isset($application) && $application->is_court_order == 1 ? 'YES' : 'No' }}</h6></h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-3" id="yescourtorderConversionDiv" {{ isset($application) && $application->is_court_order ? '' : 'style=display:none;' }}>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Case No.</label>
                                    <span class="fw-bold">{{isset($application) ?  $application->case_no :''}}</span>   
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Details</label>
                                    <span class="fw-bold">{{isset($application) ?  $application->case_detail :''}}</span>   
                                </div>
                            </div>
                            @php
                                $uploadeddocsWithDocTypeNew = isset($stepSecondFinalDocuments) ? collect($stepSecondFinalDocuments)->where('document_type','convCourtOrderFile')->first():[];
                            @endphp   
                            @if($uploadeddocsWithDocTypeNew)
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group form-box">
                                            <label for="{{ $uploadeddocsWithDocTypeNew['id'] }}"
                                                class="quesLabel">{{$uploadeddocsWithDocTypeNew['title']}}</label>
                                            @if ($uploadeddocsWithDocTypeNew['file_path'])
                                                <a href="{{asset('storage/' .$uploadeddocsWithDocTypeNew->file_path ?? '')}}" target="_blank" class="text-danger"><i class="fa-solid fa-file-pdf ml-2"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                    @php
                                        if($uploadeddocsWithDocTypeNew){
                                            $values = $uploadeddocsWithDocTypeNew->values;
                                        }
                                    @endphp
                                    <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>
                                                Date of Document
                                                </label>
                                                <span class="fw-bold">{{$values[0]['value']}}</span>   
                                            </div>
                                    </div>
                                    <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>
                                                Issuing Authority
                                                </label>
                                                <span class="fw-bold">{{$values[1]['value']}}</span>   
                                            </div>
                                    </div>
                                </div>
                            @endif
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
                                 <h6 class="mr-5">Whether the Property is mortgaged?</h6>
                                 <div class="form-check mr-5">
                                     <label class="form-check-label" for="YesMortgagedConversion">
                                         <h6 class="mb-0">{{ isset($application) && $application->is_mortgaged == 1 ? 'YES' : 'No' }}</h6>
                                     </label>
                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-12 mt-3" id="yesRemarksDivConversion" {{ isset($application) && $application->is_mortgaged ==1 ? '' : 'style=display:none;' }}>
                            @php
                                $uploadeddocsWithDocType = isset($stepSecondFinalDocuments) ? collect($stepSecondFinalDocuments)->where('document_type','mortgageNoCFile')->first():[];
                            @endphp   
                            @if($uploadeddocsWithDocType)
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group form-box">
                                        <label for="{{ $uploadeddocsWithDocType['id'] }}"
                                            class="quesLabel">{{$uploadeddocsWithDocType['title']}}</label>
                                        @if ($uploadeddocsWithDocType['file_path'])
                                            <a href="{{asset('storage/' .$uploadeddocsWithDocType->file_path ?? '')}}" target="_blank" class="text-danger"><i class="fa-solid fa-file-pdf ml-2"></i></a>
                                        @endif
                                    </div>
                                </div>
                                @php
                                    if($uploadeddocsWithDocType){
                                        $values = $uploadeddocsWithDocType->values;
                                    }
                                @endphp
                                <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>
                                            Date of Document
                                            </label>
                                            <span class="fw-bold">{{$values[0]['value']}}</span>   
                                        </div>
                                </div>
                                <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>
                                            Issuing Authority
                                            </label>
                                            <span class="fw-bold">{{$values[1]['value']}}</span>   
                                        </div>
                                </div>
                            </div>
                            @endif
                         </div>
                     </div>
                 </div>
             </div>
         </div>


    </div>
</div>