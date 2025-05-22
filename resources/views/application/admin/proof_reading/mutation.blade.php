<!-- New design for Property Document Details- SOURAV CHAUHAN (13/Dec/2024) -->
<div class="part-title mt-2">
            <h5>Property Document Details</h5>
        </div>
        <div class="part-details">
            <div class="container-fluid pb-3">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered particular-document-table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                    <th>Action By CDV </th>
                                    <th>Upload Documents</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="document-type-row">
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
                                        <tr>
                                            <td>{{ ++$counter }}</td>
                                            <td>
                                                <span class="doc-name">{{ $ud['title'] }} <a
                                                        href="{{ asset('storage/' . $ud['file_path'] ?? '') }}" target="_blank"
                                                        class="text-danger"><i class="fa-solid fa-file-pdf ml-2"></i></a></span>
                                                @if($ud->documentKeys->count()> 0)
                                                <div class="required-doc">
                                                    <ul class="required-list">
                                                        @foreach ($ud->documentKeys as $data)
                                                        <li>{{ $document['inputs'][$data->key]['label'] }}: {{ $data->value }}
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="checkbox-options">
                                                    <div class="form-check form-check-success">
                                                        <input class="form-check-input required-for-approve"
                                                            name="checkedAction" type="checkbox" id="checkedAction"
                                                            @if($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                            @if ($roles === 'deputy-lndo') disabled @endif>
                                                        <label class="form-check-label" for="checkedAction">Checked</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="checkbox-options" style="display: flex;">
                                                    <div class="form-check form-check-success custom-mr-5">
                                                        <!-- <input class="form-check-input required-for-approve" name="cdvStatus1" type="radio" value="1" id="YesCDVStatus1"> -->
                                                        <input class="form-check-input doc-check-yes required-for-approve"
                                                            value="{{ $ud['id'] }}" type="radio"
                                                            name="doc-check-{{ $ud['id'] }}" id="doc-check-yes-{{ $ud['id'] }}"
                                                            @if ($ud->documentFinalChecklist &&
                                                        $ud->documentFinalChecklist->document_id == $ud['id']) disabled
                                                        @if ($ud->documentFinalChecklist->is_correct == 1)
                                                        checked @endif
                                                        @endif>
                                                        <label class="form-check-label"
                                                            for="doc-check-yes-{{ $ud['id'] }}">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-success">
                                                        <!-- <input class="form-check-input required-for-approve" name="cdvStatus1" type="radio" value="0" id="NoCDVStatus1" checked> -->
                                                        <input class="form-check-input doc-check-no required-for-approve"
                                                            type="radio" name="doc-check-{{ $ud['id'] }}"
                                                            id="doc-check-no-{{ $ud['id'] }}" value="{{ $ud['id'] }}" 
                                                            @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id']) disabled
                                                                @if ($ud->documentFinalChecklist->is_correct == 0) checked @endif
                                                            @endif>
                                                        <label class="form-check-label"
                                                            for="doc-check-no-{{ $ud['id'] }}">No</label>
                                                    </div>
                                                </div>
                                                @if (
                                                $ud->documentFinalChecklist &&
                                                $ud->documentFinalChecklist->document_id == $ud['id'] &&
                                                $ud->documentFinalChecklist->remark)
                                                <div class="required-doc">
                                                    <h6 class="required-title">Remarks</h6>
                                                    <div class="d-flex">
                                                        <p class="remarks-content">{{
                                                            substr($ud->documentFinalChecklist->remark, 0, 50) . '...' }}</p>
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
                                                <div class="form-group">
                                                    <div id="file-link-{{$ud['id']}}" class="d-flex justify-content-around">
                                                        @if($ud['office_file_path'])
                                                            <a href="{{ asset('storage/' . $ud['office_file_path'] ?? '') }}" target="_blank" class="text-danger uploaded-doc-name"><i class="fa-solid fa-file-pdf"></i></a>
                                                            <a href="javascript:void(0);" onclick="handleFileDelete({{$ud['id']}})" title="Delete Document" class="text-danger uploaded-doc-name"><i class="fa-solid fa-times"></i></a>
                                                        @endif
                                                    </div>
                                                    <input type="file" name="" class="form-control" accept=".pdf" onchange="handleFileUploadForCdv(this.files[0], {{$ud['id']}})">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach

                                <tr>
                                    <td colspan="5" class="document-type-row">
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
                                        <tr>
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
                                                        <input class="form-check-input required-for-approve"
                                                            name="checkedAction" type="checkbox" id="checkedAction" 
                                                            @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                            @if ($roles === 'deputy-lndo') disabled @endif>
                                                        <label class="form-check-label" for="checkedAction">Checked</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="checkbox-options" style="display: flex;">
                                                    <div class="form-check form-check-success custom-mr-5">
                                                        <!-- <input class="form-check-input required-for-approve" name="cdvStatus1" type="radio" value="1" id="YesCDVStatus1"> -->
                                                        <input class="form-check-input doc-check-yes required-for-approve"
                                                            value="{{ $ud['id'] }}" type="radio"
                                                            name="doc-check-{{ $ud['id'] }}" id="doc-check-yes-{{ $ud['id'] }}"
                                                            @if ($ud->documentFinalChecklist &&
                                                        $ud->documentFinalChecklist->document_id == $ud['id']) disabled
                                                        @if ($ud->documentFinalChecklist->is_correct == 1)
                                                        checked @endif
                                                        @endif>
                                                        <label class="form-check-label"
                                                            for="doc-check-yes-{{ $ud['id'] }}">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-success">
                                                        <!-- <input class="form-check-input required-for-approve" name="cdvStatus1" type="radio" value="0" id="NoCDVStatus1" checked> -->
                                                        <input class="form-check-input doc-check-no required-for-approve"
                                                            type="radio" name="doc-check-{{ $ud['id'] }}"
                                                            id="doc-check-no-{{ $ud['id'] }}" value="{{ $ud['id'] }}" 
                                                            @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id']) disabled
                                                                @if ($ud->documentFinalChecklist->is_correct == 0) checked @endif
                                                            @endif>
                                                        <label class="form-check-label"
                                                            for="doc-check-no-{{ $ud['id'] }}">No</label>
                                                    </div>
                                                </div>
                                                @if (
                                                $ud->documentFinalChecklist &&
                                                $ud->documentFinalChecklist->document_id == $ud['id'] &&
                                                $ud->documentFinalChecklist->remark)
                                                <div class="required-doc">
                                                    <h6 class="required-title">Remarks</h6>
                                                    <div class="d-flex">
                                                        <p class="remarks-content">{{
                                                            substr($ud->documentFinalChecklist->remark, 0, 50) . '...' }}</p>
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
                                            <div class="form-group">
                                                    <div id="file-link-{{$ud['id']}}" class="d-flex justify-content-around">
                                                        @if($ud['office_file_path'])
                                                            <a href="{{ asset('storage/' . $ud['office_file_path'] ?? '') }}" target="_blank" class="text-danger uploaded-doc-name"><i class="fa-solid fa-file-pdf"></i></a>
                                                            <a href="javascript:void(0);" onclick="handleFileDelete({{$ud['id']}})" title="Delete Document" class="text-danger uploaded-doc-name"><i class="fa-solid fa-times"></i></a>
                                                        @endif
                                                    </div>
                                                    <input type="file" name="" class="form-control" accept=".pdf" onchange="handleFileUploadForCdv(this.files[0], {{$ud['id']}})">
                                                </div>
                                            </td>
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
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <span class="doc-name">{{ $ud['title'] }} <a href="{{ asset('storage/' . $ud['file_path'] ?? '') }}" target="_blank" class="text-danger"><i class="fa-solid fa-file-pdf ml-2"></i></a></span>
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
                                                <td>
                                                    <div class="checkbox-options">
                                                    <div class="form-check form-check-success">
                                                        <input class="form-check-input required-for-approve" name="checkedAction" type="checkbox" id="checkedAction" @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                        @if ($roles === 'deputy-lndo') disabled @endif>
                                                        <label class="form-check-label" for="checkedAction">Checked</label>
                                                    </div>
                                                </div>
                                                </td>
                                                <td>
                                                    <div class="checkbox-options" style="display: flex;">
                                                        <div class="form-check form-check-success custom-mr-5">
                                                            <!-- <input class="form-check-input required-for-approve" name="cdvStatus1" type="radio" value="1" id="YesCDVStatus1"> -->
                                                            <input class="form-check-input doc-check-yes required-for-approve"
                                                                value="{{ $ud['id'] }}" type="radio"
                                                                name="doc-check-{{ $ud['id'] }}"
                                                                id="doc-check-yes-{{ $ud['id'] }}"
                                                                @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id']) disabled
                                                                    @if ($ud->documentFinalChecklist->is_correct == 1)
                                                                    checked @endif
                                                                @endif>
                                                            <label class="form-check-label" for="doc-check-yes-{{ $ud['id'] }}">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <!-- <input class="form-check-input required-for-approve" name="cdvStatus1" type="radio" value="0" id="NoCDVStatus1" checked> -->
                                                            <input class="form-check-input doc-check-no required-for-approve"
                                                            type="radio" name="doc-check-{{ $ud['id'] }}"
                                                            id="doc-check-no-{{ $ud['id'] }}"
                                                            value="{{ $ud['id'] }}"
                                                            @if ($ud->documentFinalChecklist && $ud->documentFinalChecklist->document_id == $ud['id']) disabled
                                                                @if ($ud->documentFinalChecklist->is_correct == 0)
                                                                checked @endif
                                                            @endif>
                                                            <label class="form-check-label" for="doc-check-no-{{ $ud['id'] }}">No</label>
                                                        </div>
                                                    </div>
                                                    @if (
                                                        $ud->documentFinalChecklist &&
                                                            $ud->documentFinalChecklist->document_id == $ud['id'] &&
                                                            $ud->documentFinalChecklist->remark)
                                                            <div class="required-doc">
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
                    </div>
                </div>
            </div>
        </div>

        
        <!-- For Add additional documents by CDV START ******************************************************************-->
            @include('application.admin.proof_reading.additional-documents')
        <!-- For Add additional documents by CDV END ******************************************************************-->