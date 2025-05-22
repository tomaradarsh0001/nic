 <!-- New design for Property Document Details- SOURAV CHAUHAN (13/Dec/2024) -->
 <div class="part-title mt-2">
    <h5>Property Document Details</h5>
</div>
<div class="part-details">
    <div class="container-fluid pb-3">
        <div class="row">
            <div class="col-lg-12">

            <div class="table-responsive">
                <table class="table table-bordered theme-table">
                    <thead>
                        <tr>
                            <th width="50">S.No</th>
                            <th>Document Name</th>
                            @if ($roles != 'applicant')
                                <th>Action by SO</th>
                            @endif
                            <!-- show if assined to is CDV and action not null SOURAV CHAUHAN (23/Dec/2024) -->
                            @if($showCdvActionInDocuments && $roles != 'applicant')
                                <th>Action By CDV </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td colspan="{{ $showCdvActionInDocuments ? 4 : 3 }}" class="document-type-row"><h4 class="doc-type-title">Required Documents</h4></td>
                            </tr>
                            @php
                            $stepTwoDocs = config('applicationDocumentType.MUTATION.Required');
                            $counter = 0;
                        @endphp
                        @foreach ($stepTwoDocs as $document)
                            @php
                                $uploadedDocuments = [];
                                if (!empty($details->documentFinal)) {
                                    $uploadedDocuments = $details->documentFinal
                                        ->where('document_type', $document['id'])
                                        ->all();
                                }
                                $uplodedDocCount = count($uploadedDocuments);
                            @endphp
                            @foreach ($uploadedDocuments as $ud)
                            <tr id="{{ $ud['id'] }}">
                                <td>{{ ++$counter }}.</td>
                                <td>
                                    <span class="doc-name">
                                    {{ $ud['title'] }} <a href="{{ asset('storage/' . $ud['file_path'] ?? '') }}" target="_blank" class="text-danger"><i class="fa-solid fa-file-pdf ml-2"></i></a>
                                    </span>



                                    @if($ud->documentKeys->count()> 0)
                                        <div class="required-info">
                                            <ul class="required-info-list">
                                                @foreach ($ud->documentKeys as $data)
                                                    @if(isset($document['inputs'][$data->key]['label']))
                                                        <li>{{ $document['inputs'][$data->key]['label'] }}: {{ $data->value }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </td>

                                @if ($roles != 'applicant')
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input required-for-approve property-document-approval-chk" type="checkbox" name="checkedAction" id="checkedAction" @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif @if ($roles != 'section-officer') disabled @endif>
                                            <label class="form-check-label" for="checkedAction">Checked</label>
                                        </div>
                                    </td>
                                @endif

                                @if($showCdvActionInDocuments && $roles != 'applicant')
                                <td>
                                    <div class="cdv-wrapper" style="display: flex;">
                                        <div class="cdv-action">
                                            <div class="form-check form-check-inline">
                                            <input class="form-check-input doc-check-yes"
                                                value="{{ $ud['id'] }}" type="radio"
                                                name="doc-check-{{ $ud['id'] }}"
                                                id="doc-check-yes-{{ $ud['id'] }}"
                                                @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id'])
                                                    @if ($ud->documentFinalChecklist->is_correct == 1)
                                                    checked @endif
                                                @endif
                                                @if ($roles != 'CDV' || $applicationAppointmentLink) disabled @endif>
                                            <label class="form-check-label" for="doc-check-yes-{{ $ud['id'] }}">Yes</label> 
                                            </div>
                                            <div class="form-check form-check-inline">


                                            <input class="form-check-input doc-check-no"
                                            type="radio" name="doc-check-{{ $ud['id'] }}"
                                            id="doc-check-no-{{ $ud['id'] }}"
                                            value="{{ $ud['id'] }}"
                                            @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id'])
                                            @if ($ud->documentFinalChecklist->is_correct == 0)
                                            checked @endif
                                            @endif
                                            @if ($roles != 'CDV' || $applicationAppointmentLink) disabled @endif>
                                            <label class="form-check-label" for="doc-check-no-{{ $ud['id'] }}">No</label>
                                            </div>
                                        </div>

                                        @if (
                                        $ud->documentFinalChecklist &&
                                            $ud->documentFinalChecklist->document_id == $ud['id'] &&
                                            $ud->documentFinalChecklist->remark)
                                        <div class="remark-wrap notCorrectRemark">
                                            <div class="remark-title">Remarks: </div>
                                            <p class="remarks-content">
                                            {{ substr($ud->documentFinalChecklist->remark, 0, 50) . '...' }}
                                            </p>
                                            <a href="javascript:;"
                                            onclick="getRemark('{{ $ud->documentFinalChecklist->document_id }}')">View</a>
                                        </div>
                                        <input type="hidden"
                                            id="fullRemark_{{ $ud->documentFinalChecklist->document_id }}"
                                            value="{{ $ud->documentFinalChecklist->remark }}" />
                                    @endif

                                    @if($ud['office_file_path'])
                                        <div class="doc-cdv">
                                            <a href="{{ asset('storage/' . $ud['office_file_path'] ?? '') }}" target="_blank" class="text-danger uploaded-doc-name">
                                                <i class="fa-solid fa-file-pdf"></i>
                                            </a>
                                        </div>
                                    @endif
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                            @endforeach




                            <tr>
                                <td colspan="{{ $showCdvActionInDocuments ? 4 : 3 }}" class="document-type-row"><h4 class="doc-type-title">Optional Documents</h4></td>
                            </tr>
                            @php
                            $stepTwoDocs = config('applicationDocumentType.MUTATION.Optional');
                            $counter = 0;
                        @endphp
                        @foreach ($stepTwoDocs as $document)
                            @php
                                $uploadedDocuments = [];
                                if (!empty($details->documentFinal)) {
                                    $uploadedDocuments = $details->documentFinal
                                        ->where('document_type', $document['id'])
                                        ->all();
                                }
                                $uplodedDocCount = count($uploadedDocuments);
                            @endphp
                            @foreach ($uploadedDocuments as $ud)
                            <tr id="{{ $ud['id'] }}">
                                <td>{{ ++$counter }}.</td>
                                <td>
                                    <span class="doc-name">
                                    {{ $ud['title'] }} <a href="{{ asset('storage/' . $ud['file_path'] ?? '') }}" target="_blank" class="text-danger"><i class="fa-solid fa-file-pdf ml-2"></i></a>
                                    </span>

                                    @if($ud->documentKeys->count()> 0)
                                        <div class="required-info">
                                            <ul class="required-info-list">
                                                @foreach ($ud->documentKeys as $data)
                                                    @if(isset($document['inputs'][$data->key]['label']))
                                                        <li>{{ $document['inputs'][$data->key]['label'] }}: {{ $data->value }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </td>

                                @if ($roles != 'applicant')
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input required-for-approve property-document-approval-chk" type="checkbox" name="checkedAction" id="checkedAction" @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif @if ($roles != 'section-officer') disabled @endif>
                                            <label class="form-check-label" for="checkedAction">Checked</label>
                                        </div>
                                    </td>
                                @endif

                                @if($showCdvActionInDocuments && $roles != 'applicant')
                                <td>
                                    <div class="cdv-wrapper" style="display: flex;">
                                        <div class="cdv-action">
                                            <div class="form-check form-check-inline">
                                            <input class="form-check-input doc-check-yes"
                                                value="{{ $ud['id'] }}" type="radio"
                                                name="doc-check-{{ $ud['id'] }}"
                                                id="doc-check-yes-{{ $ud['id'] }}"
                                                @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id'])
                                                    @if ($ud->documentFinalChecklist->is_correct == 1)
                                                    checked @endif
                                                @endif
                                                @if ($roles != 'CDV' || $applicationAppointmentLink) disabled @endif>
                                            <label class="form-check-label" for="doc-check-yes-{{ $ud['id'] }}">Yes</label> 
                                            </div>
                                            <div class="form-check form-check-inline">


                                            <input class="form-check-input doc-check-no"
                                            type="radio" name="doc-check-{{ $ud['id'] }}"
                                            id="doc-check-no-{{ $ud['id'] }}"
                                            value="{{ $ud['id'] }}"
                                            @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id'])
                                            @if ($ud->documentFinalChecklist->is_correct == 0)
                                            checked @endif
                                            @endif
                                            @if ($roles != 'CDV' || $applicationAppointmentLink) disabled @endif>
                                            <label class="form-check-label" for="doc-check-no-{{ $ud['id'] }}">No</label>
                                            </div>
                                        </div>

                                        @if (
                                        $ud->documentFinalChecklist &&
                                            $ud->documentFinalChecklist->document_id == $ud['id'] &&
                                            $ud->documentFinalChecklist->remark)
                                        <div class="remark-wrap notCorrectRemark">
                                            <div class="remark-title">Remarks: </div>
                                            <p class="remarks-content">
                                            {{ substr($ud->documentFinalChecklist->remark, 0, 50) . '...' }}
                                            </p>
                                            <a href="javascript:;"
                                            onclick="getRemark('{{ $ud->documentFinalChecklist->document_id }}')">View</a>
                                        </div>
                                        <input type="hidden"
                                            id="fullRemark_{{ $ud->documentFinalChecklist->document_id }}"
                                            value="{{ $ud->documentFinalChecklist->remark }}" />
                                    @endif

                                    @if($ud['office_file_path'])
                                        <div class="doc-cdv">
                                            <a href="{{ asset('storage/' . $ud['office_file_path'] ?? '') }}" target="_blank" class="text-danger uploaded-doc-name">
                                                <i class="fa-solid fa-file-pdf"></i>
                                            </a>
                                        </div>
                                    @endif
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                            @endforeach



                            <tr>
                                <td colspan="{{ $showCdvActionInDocuments ? 4 : 3 }}" class="document-type-row"><h4 class="doc-type-title">Additional Documents By Applicant</h4></td>
                            </tr>
                            @php
                                $applicantAdditionalDocuments = [];
                                $counter = 0;
                                if (!empty($details->documentFinal)) {
                                    $applicantAdditionalDocuments = $details->documentFinal
                                        ->where('document_type', 'AdditionalDocument')
                                        ->whereNotNull('file_path')
                                        ->all();
                                }
                                $uplodedDocCount = count($applicantAdditionalDocuments);
                            @endphp
                            @if($uplodedDocCount > 0)
                                @foreach ($applicantAdditionalDocuments as $ud)
                            <tr id="{{ $ud['id'] }}">
                                <td>{{ ++$counter }}.</td>


                                <td>
                                    <span class="doc-name">{{ $ud['title'] }} <a href="{{ asset('storage/' . $ud['file_path'] ?? '') }}" target="_blank" class="text-danger"><i class="fa-solid fa-file-pdf ml-2"></i></a></span>
                                    @if($ud->documentKeys->count()> 0)
                                    <div class="required-doc">
                                        <ul class="required-list">               
                                            @foreach ($ud->documentKeys as $data)
                                                @if(isset($document['inputs'][$data->key]['label']))
                                                    <li>{{ $document['inputs'][$data->key]['label'] }}: {{ $data->value }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </td>

                                @if ($roles != 'applicant')
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input required-for-approve property-document-approval-chk" type="checkbox" name="checkedAction" id="checkedAction" @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif @if ($roles != 'section-officer') disabled @endif>
                                            <label class="form-check-label" for="checkedAction">Checked</label>
                                        </div>
                                    </td>
                                @endif

                                @if($showCdvActionInDocuments && $roles != 'applicant')
                                <td>
                                    <div class="cdv-wrapper" style="display: flex;">
                                        <div class="cdv-action">
                                            <div class="form-check form-check-inline">
                                            <input class="form-check-input doc-check-yes"
                                                value="{{ $ud['id'] }}" type="radio"
                                                name="doc-check-{{ $ud['id'] }}"
                                                id="doc-check-yes-{{ $ud['id'] }}"
                                                @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id'])
                                                    @if ($ud->documentFinalChecklist->is_correct == 1)
                                                    checked @endif
                                                @endif
                                                @if ($roles != 'CDV' || $applicationAppointmentLink) disabled @endif>
                                            <label class="form-check-label" for="doc-check-yes-{{ $ud['id'] }}">Yes</label> 
                                            </div>
                                            <div class="form-check form-check-inline">


                                            <input class="form-check-input doc-check-no"
                                            type="radio" name="doc-check-{{ $ud['id'] }}"
                                            id="doc-check-no-{{ $ud['id'] }}"
                                            value="{{ $ud['id'] }}"
                                            @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id'])
                                            @if ($ud->documentFinalChecklist->is_correct == 0)
                                            checked @endif
                                            @endif
                                            @if ($roles != 'CDV' || $applicationAppointmentLink) disabled @endif>
                                            <label class="form-check-label" for="doc-check-no-{{ $ud['id'] }}">No</label>
                                            </div>
                                        </div>

                                        @if (
                                        $ud->documentFinalChecklist &&
                                            $ud->documentFinalChecklist->document_id == $ud['id'] &&
                                            $ud->documentFinalChecklist->remark)
                                        <div class="remark-wrap notCorrectRemark">
                                            <div class="remark-title">Remarks: </div>
                                            <p class="remarks-content">
                                            {{ substr($ud->documentFinalChecklist->remark, 0, 50) . '...' }}
                                            </p>
                                            <a href="javascript:;"
                                            onclick="getRemark('{{ $ud->documentFinalChecklist->document_id }}')">View</a>
                                        </div>
                                        <input type="hidden"
                                            id="fullRemark_{{ $ud->documentFinalChecklist->document_id }}"
                                            value="{{ $ud->documentFinalChecklist->remark }}" />
                                    @endif

                                    @if($ud['office_file_path'])
                                        <div class="doc-cdv">
                                            <a href="{{ asset('storage/' . $ud['office_file_path'] ?? '') }}" target="_blank" class="text-danger uploaded-doc-name">
                                                <i class="fa-solid fa-file-pdf"></i>
                                            </a>
                                        </div>
                                    @endif
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="">
                                    <p class="text-center">No Documents Available</p>
                                </td>
                            </tr>
                            @endif




                            <tr>
                                <td colspan="5" class="document-type-row">
                                    <h4 class="doc-type-title">Additional Documents By CDV</h4>
                                </td>
                            </tr>
                                @php
                                    $cdvAdditionalDocuments = [];
                                    if (!empty($details->documentFinal)) {
                                        $cdvAdditionalDocuments = $details->documentFinal
                                            ->where('document_type', 'AdditionalDocument')
                                            ->whereNull('file_path')
                                            ->whereNotNull('office_file_path')
                                            ->all();
                                    }
                                    $uplodedDocCount = count($cdvAdditionalDocuments);
                                    $count = 1;
                                @endphp
                                @if($uplodedDocCount > 0)
                                    @foreach ($cdvAdditionalDocuments as $index => $ud)
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td colspan="4" style="text-align: left;">
                                                <span class="doc-name">{{ $ud['title'] }} <a href="{{ asset('storage/' . $ud['office_file_path'] ?? '') }}" target="_blank" class="text-danger"><i class="fa-solid fa-file-pdf ml-2"></i></a></span>
                                                @if($ud->documentKeys->count()> 0)
                                                <div class="required-doc">
                                                    <ul class="required-list">
                                                        @foreach ($ud->documentKeys as $data)
                                                            <li>{{ $document['inputs'][$data->key]['label'] }}: {{ $data->value }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif
                                            </td>
                                    
                                        </tr>
                                        @php
                                        $count = $count + 1;
                                        @endphp
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="">
                                        <p class="text-center">No Documents Available</p>
                                    </td>
                                </tr>
                                @endif
                            <!-- <tr>
                                <td>2.</td>
                                <td>
                                    <span class="doc-name">Public Notice in National Daily (English)
                                        <a href="" target="_blank" class="text-danger">
                                            <i class="fa-solid fa-file-pdf ml-2"></i>
                                        </a>
                                    </span>
                                    <div class="required-info">
                                        <ul class="required-info-list">
                                            <li>Name of Newspaper (English): <span>Times Of India</span></li>
                                            <li>Name of Newspaper (Hindi): <span>Hindustan</span></li>
                                            <li>Date of Public Notice: <span>20-11-2024</span></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                        <label class="form-check-label" for="flexCheckChecked">Checked</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="cdv-wrapper">
                                        <div class="cdv-action">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                        </div>
                                        <div class="remark-wrap">
                                            <div class="remark-title">Remarks: </div>
                                            <p class="remarks-content">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus fermentum, nulla in bibendum sollicitudin, arcu odio mollis dolor
                                            </p>
                                        </div>
                                        <div class="doc-cdv">
                                            <a href="" target="_blank" class="text-danger uploaded-doc-name">
                                                <i class="fa-solid fa-file-pdf"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>
                                    <span class="doc-name">Relinquishment Deed
                                        <a href="" target="_blank" class="text-danger">
                                            <i class="fa-solid fa-file-pdf ml-2"></i>
                                        </a>
                                    </span>
                                    <div class="required-info">
                                        <ul class="required-info-list">
                                            <li>Registration No.: <span>455</span></li>
                                            <li>Volume: <span>3</span></li>
                                            <li>Book No.: <span>4</span></li>
                                            <li>Regn. Date: <span>09-10-2024</span></li>
                                            <li>Registration office name: <span>Hira Thakur</span></li>
                                            <li>Page No.: <span>3</span> - <span>5</span></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                                        <label class="form-check-label" for="flexCheckChecked">Checked</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="cdv-wrapper">
                                        <div class="cdv-action">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                                <label class="form-check-label" for="inlineRadio1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                        </div>
                                        <div class="remark-wrap">
                                            <div class="remark-title">Remarks: </div>
                                            <p class="remarks-content">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus fermentum, nulla in bibendum sollicitudin, arcu odio mollis dolor
                                            </p>
                                        </div>
                                        <div class="doc-cdv">
                                            <a href="" target="_blank" class="text-danger uploaded-doc-name">
                                                <i class="fa-solid fa-file-pdf"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr> -->
                        </tbody>
                </table>
            </div>


            {{--
                <table class="table table-bordered particular-document-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            @if ($roles != 'applicant')
                                <th>Action</th>
                            @endif
                            <!-- show if assined to is CDV and action not null SOURAV CHAUHAN (23/Dec/2024) -->
                            @if($showCdvActionInDocuments && $roles != 'applicant')
                                <th>Action By CDV </th>
                                <th>Documents By CDV</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="{{ $showCdvActionInDocuments ? 5 : 3 }}" class="document-type-row">
                                <h4 class="doc-type-title">Required Documents</h4>
                            </td>
                        </tr>
                        @php
                            $stepTwoDocs = config('applicationDocumentType.MUTATION.Required');
                            $counter = 0;
                        @endphp
                        @foreach ($stepTwoDocs as $document)
                            @php
                                $uploadedDocuments = [];
                                if (!empty($details->documentFinal)) {
                                    $uploadedDocuments = $details->documentFinal
                                        ->where('document_type', $document['id'])
                                        ->all();
                                }
                                $uplodedDocCount = count($uploadedDocuments);
                            @endphp
                            @foreach ($uploadedDocuments as $ud)
                        <tr id="{{ $ud['id'] }}">
                            <td>{{ ++$counter }}</td>
                            <td>
                                <span class="doc-name">{{ $ud['title'] }} <a href="{{ asset('storage/' . $ud['file_path'] ?? '') }}" target="_blank" class="text-danger"><i class="fa-solid fa-file-pdf ml-2"></i></a></span>
                            
                                @if($ud->documentKeys->count()> 0)
                                <div class="required-doc">
                                    <ul class="required-list">
                                        @foreach ($ud->documentKeys as $data)
                                            @if(isset($document['inputs'][$data->key]['label']))
                                                <li>{{ $document['inputs'][$data->key]['label'] }}: {{ $data->value }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </td>
                            @if ($roles != 'applicant')
                                <td>
                                    <div class="checkbox-options">
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input required-for-approve property-document-approval-chk" name="checkedAction" type="checkbox" id="checkedAction" @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                            @if ($roles != 'section-officer') disabled @endif>
                                            <label class="form-check-label" for="checkedAction">Checked</label>
                                        </div>
                                    </div>
                                </td>
                            @endif
                            <!-- show if assined to is CDV and action not null SOURAV CHAUHAN (23/Dec/2024) -->
                            @if($showCdvActionInDocuments && $roles != 'applicant')
                                <td>
                                    <div class="checkbox-options" style="display: flex;">
                                        <div class="form-check form-check-success custom-mr-5">
                                            <!-- <input class="form-check-input required-for-approve" name="cdvStatus1" type="radio" value="1" id="YesCDVStatus1"> -->
                                            <input class="form-check-input doc-check-yes"
                                                value="{{ $ud['id'] }}" type="radio"
                                                name="doc-check-{{ $ud['id'] }}"
                                                id="doc-check-yes-{{ $ud['id'] }}"
                                                @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id'])
                                                    @if ($ud->documentFinalChecklist->is_correct == 1)
                                                    checked @endif
                                                @endif
                                                @if ($roles != 'CDV' || $applicationAppointmentLink) disabled @endif>
                                            <label class="form-check-label" for="doc-check-yes-{{ $ud['id'] }}">Yes</label>
                                        </div>
                                        <div class="form-check form-check-success">
                                            <!-- <input class="form-check-input required-for-approve" name="cdvStatus1" type="radio" value="0" id="NoCDVStatus1" checked> -->
                                            <input class="form-check-input doc-check-no"
                                            type="radio" name="doc-check-{{ $ud['id'] }}"
                                            id="doc-check-no-{{ $ud['id'] }}"
                                            value="{{ $ud['id'] }}"
                                            @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id'])
                                            @if ($ud->documentFinalChecklist->is_correct == 0)
                                            checked @endif
                                            @endif
                                            @if ($roles != 'CDV' || $applicationAppointmentLink) disabled @endif>
                                            <label class="form-check-label" for="doc-check-no-{{ $ud['id'] }}">No</label>
                                        </div>
                                    </div>
                                    @if (
                                        $ud->documentFinalChecklist &&
                                            $ud->documentFinalChecklist->document_id == $ud['id'] &&
                                            $ud->documentFinalChecklist->remark)
                                            <div class="required-doc notCorrectRemark">
                                                <h6 class="required-title">Remarks</h6>
                                                <div class="d-flex">
                                                    <p class="remarks-content">{{ substr($ud->documentFinalChecklist->remark, 0, 50) . '...' }}</p>
                                                    <a href="javascript:;"
                                                        onclick="getRemark('{{ $ud->documentFinalChecklist->document_id }}')">View</a>
                                                </div>
                                        </div>
                                        <input type="hidden"
                                            id="fullRemark_{{ $ud->documentFinalChecklist->document_id }}"
                                            value="{{ $ud->documentFinalChecklist->remark }}" />
                                    @endif
                                </td>
                                <td>
                                    @if($ud['office_file_path'])
                                        <a href="{{ asset('storage/' . $ud['office_file_path'] ?? '') }}" target="_blank" class="text-danger uploaded-doc-name"><i class="fa-solid fa-file-pdf"></i></a>
                                    @endif
                                </td>
                            @endif
                        </tr>
                        @endforeach
                        @endforeach

                        <tr>
                        <td colspan="{{ $showCdvActionInDocuments ? 5 : 3 }}" class="document-type-row">
                            <h4 class="doc-type-title">Optional Documents</h4>
                        </td>
                        </tr>
                        @php
                            $stepTwoDocs = config('applicationDocumentType.MUTATION.Optional');
                            $counter = 0;
                        @endphp
                        @foreach ($stepTwoDocs as $document)
                            @php
                                $uploadedDocuments = [];
                                if (!empty($details->documentFinal)) {
                                    $uploadedDocuments = $details->documentFinal
                                        ->where('document_type', $document['id'])
                                        ->all();
                                }
                                $uplodedDocCount = count($uploadedDocuments);
                            @endphp
                            @foreach ($uploadedDocuments as $ud)
                                <tr id="{{ $ud['id'] }}">
                                    <td>{{ ++$counter }}</td>
                                    <td>
                                        <span class="doc-name">{{ $ud['title'] }} <a href="{{ asset('storage/' . $ud['file_path'] ?? '') }}" target="_blank" class="text-danger"><i class="fa-solid fa-file-pdf ml-2"></i></a></span>
                                        @if($ud->documentKeys->count()> 0)
                                        <div class="required-doc">
                                            <ul class="required-list">
                                                @php
                                                    $from = null;
                                                    $to = null;
                                                @endphp

                                                @foreach ($ud->documentKeys as $data)
                                                    @isset($document['inputs'][$data->key])
                                                        @if($document['inputs'][$data->key]['label'] == 'Page No.')
                                                        @elseif($document['inputs'][$data->key]['label'] == 'From')
                                                            @php $from = $data->value; @endphp
                                                        @elseif($document['inputs'][$data->key]['label'] == 'To')
                                                            @php $to = $data->value; @endphp
                                                        @else
                                                            <li>{{ $document['inputs'][$data->key]['label'] }}: {{ $data->value }}</li>
                                                        @endif
                                                    @endisset
                                                @endforeach

                                                @if ($from && $to)
                                                    <li>Page No.: {{ $from }} - {{ $to }}</li>
                                                @elseif ($from)
                                                    <li>Page No.: {{ $from }}</li>
                                                @elseif ($to)
                                                    <li>Page No.: {{ $to }}</li>
                                                @endif

                                            </ul>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="checkbox-options">
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input required-for-approve property-document-approval-chk" name="checkedAction" type="checkbox" id="checkedAction" @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                            @if ($roles != 'section-officer') disabled @endif>
                                            <label class="form-check-label" for="checkedAction">Checked</label>
                                        </div>
                                    </div>
                                    </td>
                                    <!-- show if assined to is CDV and action not null SOURAV CHAUHAN (23/Dec/2024) -->
                                    @if($showCdvActionInDocuments)
                                    <td>
                                        <div class="checkbox-options" style="display: flex;">
                                            <div class="form-check form-check-success custom-mr-5">
                                                <!-- <input class="form-check-input required-for-approve" name="cdvStatus1" type="radio" value="1" id="YesCDVStatus1"> -->
                                                <input class="form-check-input doc-check-yes"
                                                    value="{{ $ud['id'] }}" type="radio"
                                                    name="doc-check-{{ $ud['id'] }}"
                                                    id="doc-check-yes-{{ $ud['id'] }}"
                                                    @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id'])
                                                        @if ($ud->documentFinalChecklist->is_correct == 1)
                                                        checked @endif
                                                    @endif
                                                    @if ($roles != 'CDV' || $applicationAppointmentLink) disabled @endif>
                                                <label class="form-check-label" for="doc-check-yes-{{ $ud['id'] }}">Yes</label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <!-- <input class="form-check-input required-for-approve" name="cdvStatus1" type="radio" value="0" id="NoCDVStatus1" checked> -->
                                                <input class="form-check-input doc-check-no"
                                                type="radio" name="doc-check-{{ $ud['id'] }}"
                                                id="doc-check-no-{{ $ud['id'] }}"
                                                value="{{ $ud['id'] }}"
                                                @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id'])
                                                    @if ($ud->documentFinalChecklist->is_correct == 0)
                                                    checked @endif
                                                @endif
                                                @if ($roles != 'CDV' || $applicationAppointmentLink) disabled @endif>
                                                <label class="form-check-label" for="doc-check-no-{{ $ud['id'] }}">No</label>
                                            </div>
                                        </div>
                                        @if (
                                            $ud->documentFinalChecklist &&
                                                $ud->documentFinalChecklist->document_id == $ud['id'] &&
                                                $ud->documentFinalChecklist->remark)
                                                <div class="required-doc notCorrectRemark">
                                                    <h6 class="required-title">Remarks</h6>
                                                    <div class="d-flex">
                                                        <p class="remarks-content">{{ substr($ud->documentFinalChecklist->remark, 0, 50) . '...' }}</p>
                                                        <a href="javascript:;"
                                                            onclick="getRemark('{{ $ud->documentFinalChecklist->document_id }}')">View</a>
                                                    </div>
                                            </div>
                                            <input type="hidden"
                                                id="fullRemark_{{ $ud->documentFinalChecklist->document_id }}"
                                                value="{{ $ud->documentFinalChecklist->remark }}" />
                                        @endif
                                    </td>
                                    <td>
                                        @if($ud['office_file_path'])
                                            <a href="{{ asset('storage/' . $ud['office_file_path'] ?? '') }}" target="_blank" class="text-danger uploaded-doc-name"><i class="fa-solid fa-file-pdf"></i></a>
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach



                        <tr>
                            <td colspan="5" class="document-type-row">
                                <h4 class="doc-type-title">Additional Documents By Applicant</h4>
                            </td>
                        </tr>
                            @php
                                $applicantAdditionalDocuments = [];
                                $counter = 0;
                                if (!empty($details->documentFinal)) {
                                    $applicantAdditionalDocuments = $details->documentFinal
                                        ->where('document_type', 'AdditionalDocument')
                                        ->whereNotNull('file_path')
                                        ->all();
                                }
                                $uplodedDocCount = count($applicantAdditionalDocuments);
                            @endphp
                            @if($uplodedDocCount > 0)
                                @foreach ($applicantAdditionalDocuments as $ud)
                                    <tr id="{{ $ud['id'] }}">
                                        <td>{{ ++$counter }}</td>
                                        <td>
                                            <span class="doc-name">{{ $ud['title'] }} <a href="{{ asset('storage/' . $ud['file_path'] ?? '') }}" target="_blank" class="text-danger"><i class="fa-solid fa-file-pdf ml-2"></i></a></span>
                                            @if($ud->documentKeys->count()> 0)
                                            <div class="required-doc">
                                                <ul class="required-list">               
                                                    @foreach ($ud->documentKeys as $data)
                                                        @if(isset($document['inputs'][$data->key]['label']))
                                                            <li>{{ $document['inputs'][$data->key]['label'] }}: {{ $data->value }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="checkbox-options">
                                            <div class="form-check form-check-success">
                                                <input class="form-check-input property-document-approval-chk required-for-approve" name="checkedAction" type="checkbox" id="checkedAction" @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($roles != 'section-officer') disabled @endif>
                                                <label class="form-check-label" for="checkedAction">Checked</label>
                                            </div>
                                        </div>
                                        </td>
                                        @if($showCdvActionInDocuments)
                                        <td>
                                            <div class="checkbox-options" style="display: flex;">
                                                <div class="form-check form-check-success custom-mr-5">
                                                    <!-- <input class="form-check-input required-for-approve" name="cdvStatus1" type="radio" value="1" id="YesCDVStatus1"> -->
                                                    <input class="form-check-input doc-check-yes required-for-approve"
                                                        value="{{ $ud['id'] }}" type="radio"
                                                        name="doc-check-{{ $ud['id'] }}"
                                                        id="doc-check-yes-{{ $ud['id'] }}"
                                                        @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id'])
                                                            @if ($ud->documentFinalChecklist->is_correct == 1)
                                                            checked @endif
                                                        @endif
                                                        @if ($roles != 'CDV' || $applicationAppointmentLink) disabled @endif
                                                        >
                                                    <label class="form-check-label" for="doc-check-yes-{{ $ud['id'] }}">Yes</label>
                                                </div>
                                                <div class="form-check form-check-success">
                                                    <!-- <input class="form-check-input required-for-approve" name="cdvStatus1" type="radio" value="0" id="NoCDVStatus1" checked> -->
                                                    <input class="form-check-input doc-check-no required-for-approve"
                                                    type="radio" name="doc-check-{{ $ud['id'] }}"
                                                    id="doc-check-no-{{ $ud['id'] }}"
                                                    value="{{ $ud['id'] }}"
                                                    @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id'])
                                                        @if ($ud->documentFinalChecklist->is_correct == 0)
                                                        checked @endif
                                                    @endif
                                                    @if ($roles != 'CDV' || $applicationAppointmentLink) disabled @endif>
                                                    <label class="form-check-label" for="doc-check-no-{{ $ud['id'] }}">No</label>
                                                </div>
                                            </div>
                                            @if (
                                                $ud->documentFinalChecklist &&
                                                    $ud->documentFinalChecklist->document_id == $ud['id'] &&
                                                    $ud->documentFinalChecklist->remark)
                                                    <div class="required-doc notCorrectRemark">
                                                        <h6 class="required-title">Remarks</h6>
                                                        <div class="d-flex">
                                                            <p class="remarks-content">{{ substr($ud->documentFinalChecklist->remark, 0, 50) . '...' }}</p>
                                                            <a href="javascript:;"
                                                                onclick="getRemark('{{ $ud->documentFinalChecklist->document_id }}')">View</a>
                                                        </div>
                                                </div>
                                                <input type="hidden"
                                                    id="fullRemark_{{ $ud->documentFinalChecklist->document_id }}"
                                                    value="{{ $ud->documentFinalChecklist->remark }}" />
                                            @endif
                                        </td>
                                        @endif
                                        <td>
                                            @if($ud['office_file_path'])
                                                <a href="{{ asset('storage/' . $ud['office_file_path'] ?? '') }}" target="_blank" class="text-danger uploaded-doc-name"><i class="fa-solid fa-file-pdf"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="">
                                    <p class="">No Documents Available</p>
                                </td>
                            </tr>
                            @endif





                            <tr>
                                <td colspan="5" class="document-type-row">
                                    <h4 class="doc-type-title">Additional Documents By CDV</h4>
                                </td>
                            </tr>
                                @php
                                    $cdvAdditionalDocuments = [];
                                    if (!empty($details->documentFinal)) {
                                        $cdvAdditionalDocuments = $details->documentFinal
                                            ->where('document_type', 'AdditionalDocument')
                                            ->whereNull('file_path')
                                            ->whereNotNull('office_file_path')
                                            ->all();
                                    }
                                    $uplodedDocCount = count($cdvAdditionalDocuments);
                                    $count = 1;
                                @endphp
                                @if($uplodedDocCount > 0)
                                    @foreach ($cdvAdditionalDocuments as $index => $ud)
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td colspan="4" style="text-align: left;">
                                                <span class="doc-name">{{ $ud['title'] }} <a href="{{ asset('storage/' . $ud['office_file_path'] ?? '') }}" target="_blank" class="text-danger"><i class="fa-solid fa-file-pdf ml-2"></i></a></span>
                                                @if($ud->documentKeys->count()> 0)
                                                <div class="required-doc">
                                                    <ul class="required-list">
                                                        @foreach ($ud->documentKeys as $data)
                                                            <li>{{ $document['inputs'][$data->key]['label'] }}: {{ $data->value }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif
                                            </td>
                                    
                                        </tr>
                                        @php
                                        $count = $count + 1;
                                        @endphp
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="">
                                        <p class="">No Documents Available</p>
                                    </td>
                                </tr>
                                @endif
                    </tbody>
                </table>
                --}}
            </div>
        </div>
    </div>
</div>