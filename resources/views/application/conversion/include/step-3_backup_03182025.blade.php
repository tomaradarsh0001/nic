<div class="mt-3">
    <div class="container-fluid">
        <div class="row g-2">
            <div class="col-lg-12">
                @php
                $inputGroups = config('applicationDocumentType.CONVERSION.optional.groups');
                $isLeaseDeedLost= isset($application) && $application->is_Lease_deed_lost==1 ? 1:0;
                @endphp
                @foreach($inputGroups as $ig)
                <div class="row row-mb-2">
                    <div class="col-lg-1 icons-flex"></div>
                    <div class="col-lg-11 selected-docs-field">
                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                        <div class="row pb-2">
                            @if(isset($ig['input']) && $ig['input']['type']=='radio')
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <h6 class="mr-5 mb-0">{{$ig['input']['label']}}</h6>
                                    @foreach($ig['input']['options'] as $opt)
                                    <div class="form-check mr-5">
                                        <input class="form-check-input" name="{{$ig['input']['name']}}" type="radio"
                                            value="{{$opt['value']}}" id="{{$ig['input']['name'].$opt['label']}}" {{ $isLeaseDeedLost == $opt['value'] ? 'checked':''}}>
                                        <label class="form-check-label" for="{{$ig['input']['name'].$opt['label']}}">
                                            <h6 class="mb-0">{{$opt['label']}}</h6>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if(isset($ig['input']))
                            <div class="col-lg-12" id="optionalInputs" style="display: {{ $isLeaseDeedLost ? 'block':'none' }};">
                                <div class="row">
                                    @endif
                                    @foreach($ig['documents'] as $document)
                                    @php 
                                    $uploadedDocument = null;
                                    if(isset($application)&& $application->tempDocument){
                                        $uploadedDocument = $application->tempDocument->where('document_type',$document['id'])->first();
                                    }
                                        
                                    @endphp
                                    <div class="col-lg-4">
                                        <div class="form-group form-box">
                                            <label for="{{$document['id']}}">{{$document['label']}}</i></span></label><!-- class="quesLabel" data-toggle="tooltip" data-placement="top" title="Affidavit to the effect that the Lessee is alive" -->
                                            <input type="file" name="{{$document['id']}}" class="form-control"
                                                accept="application/pdf" id="{{$document['id']}}" onchange="handleFileUpload(this.files[0], '{{ $document['label'] }}','{{ $document['id'] }}', 'conversion', 'CONVERSION')">
                                                @if ($uploadedDocument)
                                                <a href="{{asset('storage/'.$uploadedDocument->file_path)}}" target="_blank" class="fs-6">View saved document</a>
                                                @endif
                                            <div id="{{$document['id']}}Error" class="text-danger text-left">
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($document['inputs'] as $docInput)
                                    @php
                                        $documentKey = $value = null;
                                        if(isset($uploadedDocument)){
                                            $documentKey = $uploadedDocument->tempDocumentKeys->where('key',$docInput['id'])->first();
                                            $value = !empty($documentKey) ? $documentKey->value :'';
                                        }
                                    @endphp
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="{{$docInput['id']}}">{{$docInput['label']}}</label>
                                            <input type="{{$docInput['type']}}" name="{{$docInput['id']}}"
                                                class="form-control" id="{{$docInput['id']}}" value="{{$value}}">
                                        </div>
                                    </div>

                                    @endforeach
                                    @endforeach
                                    @if (isset($ig['input']))
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                <!--  <div class="row row-mb-2">
                    <div class="col-lg-1 icons-flex"></div>
                    <div class="col-lg-11 selected-docs-field">
                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                        <div class="row pb-2">
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <h6 class="mr-5 mb-0">Where the Lease deed is lost?</h6>
                                    <div class="form-check mr-5">
                                        <input class="form-check-input" name="DeedLostConversion" type="radio"
                                            value="Yes" id="YesDeedLostConversion">
                                        <label class="form-check-label" for="YesDeedLostConversion">
                                            <h6 class="mb-0">Yes</h6>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="DeedLostConversion" type="radio"
                                            value="No" id="NoDeedLostConversion" checked>
                                        <label class="form-check-label" for="NoDeedLostConversion">
                                            <h6 class="mb-0">No</h6>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="yesDeedLostDivConversion" style="display: none;">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group form-box">
                                            <label for="AffidavitsConversiondeedlost" class="quesLabel" data-toggle="tooltip" data-placement="top" title="Affidavit for Lease Deed is Lost">Affidavits <span><i class='bx bx-info-circle'></i></span></label>
                                            <input type="file" name="AffidavitsConversiondeedlost" class="form-control"
                                                accept="application/pdf" id="AffidavitsConversiondeedlost">
                                            <div id="AffidavitsConversiondeedlostError" class="text-danger text-left">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="dateattestationConversiondeedlost">Date of Document</label>
                                            <input type="date" name="dateattestationConversiondeedlost"
                                                class="form-control" id="dateattestationConversiondeedlost">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="attestedbyConversiondeedlost">Issuing Authority</label>
                                            <input type="text" name="attestedbyConversiondeedlost"
                                                class="form-control alpha-only" id="attestedbyConversiondeedlost"
                                                placeholder="Issuing Authority">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group form-box">
                                            <label for="publicnoticeenhinLeaseDeed" class="quesLabel">Public
                                                Notice in National Daily (English &amp; Hindi)</label>
                                            <input type="file" name="publicnoticeenhinLeaseDeed" class="form-control" accept="application/pdf" id="publicnoticeenhinLeaseDeed">
                                            <div id="publicnoticeenhinLeaseDeedError" class="text-danger text-left"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="newspapernameengligh">Name of Newspaper
                                                (English or Hindi)</label>
                                            <input type="text" name="newspapernameengligh" class="form-control alpha-only" id="newspapernameengligh" placeholder="Name of Newspaper (English)">
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="publicnoticedate">Date of Public Notice<span class="text-danger">*</span></label>
                                                                    <input type="date" name="publicnoticedate" class="form-control" id="publicnoticedate">
                                                                </div>
                                                            </div> --
            </div>
        </div>
    </div>
</div>
</div>

<div class="row row-mb-2">
    <div class="col-lg-1 icons-flex"></div>
    <div class="col-lg-11 selected-docs-field">
        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>

    </div>
</div> -->
            </div>


        </div>

        <div class="row mt-2">
            <div class="col-lg-12">
                <h6 class="mt-3 mb-0">Terms & Conditions</h6>
                <ul class="consent-agree">
                    <li>Declaration is given by applicant(s) that all facts details given by
                        him/her are correct and true to his knowledge otherwise his application
                        will be liable to be rejected. and,</li>
                    <li>Undertaking that applicant is agreeing with the terms and conditions as
                        mentioned in <span id="terms-content">substitution/Mutation</span> brochure/manual.</li>
                    <li>Payment of Non-Refundable Processing Fee {{ getApplicationCharge(getServiceType('CONVERSION')) }} /- Rs. (INR)</li>
                </ul>
                <div class="form-check form-group">
                    <input class="form-check-input" type="checkbox" value=""
                        id="agreeConsentConversion" {{isset($application) && $application->consent ? 'checked':''}}>
                    <label class="form-check-label" for="agreeconsent">I agree, all the
                        information provided by me is accurate to the best of my knowledge. I
                        take full responsibility for any issues or failures that may arise from
                        its use.</label>
                </div>

            </div>
        </div>
    </div>
</div>