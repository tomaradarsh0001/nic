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
                                                <th>Upload Documents</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="document-type-row">
                                                    <h4 class="doc-type-title">Required Documents</h4>
                                                </td>
                                            </tr>

                                            @if (!empty($documents['required']))

                                                @foreach ($documents['required'] as $key => $document)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>
                                                            <span class="doc-name">{{ $document['title'] }} <a
                                                                    href="{{ asset('storage/' . $document['file_path'] ?? '') }}"
                                                                    target="_blank" class="text-danger"><i
                                                                        class="fa-solid fa-file-pdf ml-2"></i></a></span>
                                                        </td>
                                                        <td>
                                                            <div class="checkbox-options">
                                                                <div class="form-check form-check-success">
                                                                    <input class="form-check-input required-for-approve"
                                                                        name="checkedAction" type="checkbox" id="checkedAction"
                                                                        @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                                        @if ($roles === 'deputy-lndo') disabled @endif>
                                                                    <label class="form-check-label"
                                                                        for="checkedAction">Checked</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div id="file-link-{{ $document['id'] }}"
                                                                    class="d-flex justify-content-around">
                                                                    @if ($document['office_file_path'])
                                                                        <strong>View Document &nbsp;&nbsp; <a href="{{ asset('storage/' . $document['office_file_path'] ?? '') }}"
                                                                            target="_blank"
                                                                            class="text-danger uploaded-doc-name"><i
                                                                                class="fa-solid fa-file-pdf"></i></a></strong>
                                                                        
                                                                        <strong>Remove Document &nbsp;&nbsp; <a href="javascript:void(0);"
                                                                            onclick="handleFileDelete({{ $document['id'] }})"
                                                                            title="Delete Document"
                                                                            class="text-danger uploaded-doc-name"><i
                                                                                class="fa-solid fa-times"></i></a></strong>
                                                                        
                                                                    @endif
                                                                </div>
                                                                <input type="file" name="" class="form-control"
                                                                    accept=".pdf"
                                                                    onchange="handleFileUploadForCdv(this.files[0], {{ $document['id'] }})">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif





                                            <tr>
                                                <td colspan="4" class="document-type-row">
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
                                            @if ($uplodedDocCount > 0)
                                                @foreach ($applicantAdditionalDocuments as $key => $ud)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>
                                                            <span class="doc-name">{{ $ud['title'] }} <a
                                                                    href="{{ asset('storage/' . $ud['file_path'] ?? '') }}"
                                                                    target="_blank" class="text-danger"><i
                                                                        class="fa-solid fa-file-pdf ml-2"></i></a></span>
                                                            @if ($ud->documentKeys->count() > 0)
                                                                <div class="required-doc">
                                                                    <ul class="required-list">
                                                                        @foreach ($ud->documentKeys as $data)
                                                                            <li>{{ $document['inputs'][$data->key]['label'] }}:
                                                                                {{ $data->value }}</li>
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
                                                                        @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                                        @if ($roles === 'deputy-lndo') disabled @endif>
                                                                    <label class="form-check-label"
                                                                        for="checkedAction">Checked</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div id="file-link-{{ $ud['id'] }}"
                                                                    class="d-flex justify-content-around">
                                                                    @if ($ud['office_file_path'])
                                                                        <a href="{{ asset('storage/' . $ud['office_file_path'] ?? '') }}"
                                                                            target="_blank"
                                                                            class="text-danger uploaded-doc-name"><i
                                                                                class="fa-solid fa-file-pdf"></i></a>
                                                                        <a href="javascript:void(0);"
                                                                            onclick="handleFileDelete({{ $ud['id'] }})"
                                                                            title="Delete Document"
                                                                            class="text-danger uploaded-doc-name"><i
                                                                                class="fa-solid fa-times"></i></a>
                                                                    @endif
                                                                </div>
                                                                <input type="file" name="" class="form-control"
                                                                    accept=".pdf"
                                                                    onchange="handleFileUploadForCdv(this.files[0], {{ $ud['id'] }})">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="">
                                                        <p class="">No Documents Available</p>
                                                    </td>
                                                </tr>
                                            @endif





                                            <tr>
                                                <td colspan="5" class="document-type-row">
                                                    <h4 class="doc-type-title">Additional Documents By Section</h4>
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
                                            @if ($uplodedDocCount > 0)
                                                @foreach ($cdvAdditionalDocuments as $index => $ud)
                                                    <tr>
                                                        <td>{{ $count }}</td>
                                                        <td colspan="4" style="text-align: left;">
                                                            <span class="doc-name">{{ $ud['title'] }} <a
                                                                    href="{{ asset('storage/' . $ud['office_file_path'] ?? '') }}"
                                                                    target="_blank" title="View Document" class="text-danger"><i
                                                                        class="fa-solid fa-file-pdf ml-2"></i></a>
                                                                        &nbsp;&nbsp; 
                                                                        <strong><a href="javascript:void(0);"
                                                                            onclick="handleFileDeleteAdditionalDocument({{ $ud['id'] }})"
                                                                            title="Delete Document"
                                                                            class="text-danger uploaded-doc-name"><i
                                                                                class="fa-solid fa-times"></i></a></strong>
                                                                    </span>
                                                            @if ($ud->documentKeys->count() > 0)
                                                                <div class="required-doc">
                                                                    <ul class="required-list">
                                                                        @foreach ($ud->documentKeys as $data)
                                                                            <li>{{ $document['inputs'][$data->key]['label'] }}:
                                                                                {{ $data->value }}</li>
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
                                                    <td colspan="4" class="">
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
                <!-- For Add additional documents by Section START ******************************************************************-->
                    @include('application.admin.proof_reading.additional-documents')
                <!-- For Add additional documents by Section END ******************************************************************-->

                    
                    