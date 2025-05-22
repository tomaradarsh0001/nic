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

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" class="document-type-row">
                                    <h4 class="doc-type-title">Required Documents</h4>
                                </td>
                            </tr>
                            @php
                                $stepTwoDocs = config('applicationDocumentType.NOC.Required');
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
                                                {{ $ud['title'] }} <a
                                                    href="{{ asset('storage/' . $ud['file_path'] ?? '') }}"
                                                    target="_blank" class="text-danger"><i
                                                        class="fa-solid fa-file-pdf ml-2"></i></a>
                                            </span>



                                            @if ($ud->documentKeys->count() > 0)
                                                <div class="required-info">
                                                    <ul class="required-info-list">
                                                        @foreach ($ud->documentKeys as $data)
                                                            @if (isset($document['inputs'][$data->key]['label']))
                                                                <li>{{ $document['inputs'][$data->key]['label'] }}:
                                                                    {{ $data->value }}</li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </td>

                                        @if ($roles != 'applicant')
                                            <td>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input required-for-approve property-document-approval-chk"
                                                        type="checkbox" name="checkedAction" id="checkedAction"
                                                        @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                        @if ($roles != 'section-officer') disabled @endif>
                                                    <label class="form-check-label" for="checkedAction">Checked</label>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach

                            <tr>
                                <td colspan="3" class="document-type-row">
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
                            @if ($uplodedDocCount > 0)
                                @foreach ($applicantAdditionalDocuments as $ud)
                                    <tr id="{{ $ud['id'] }}">
                                        <td>{{ ++$counter }}.</td>


                                        <td>
                                            <span class="doc-name">{{ $ud['title'] }} <a
                                                    href="{{ asset('storage/' . $ud['file_path'] ?? '') }}"
                                                    target="_blank" class="text-danger"><i
                                                        class="fa-solid fa-file-pdf ml-2"></i></a></span>
                                            @if ($ud->documentKeys->count() > 0)
                                                <div class="required-doc">
                                                    <ul class="required-list">
                                                        @foreach ($ud->documentKeys as $data)
                                                            @if (isset($document['inputs'][$data->key]['label']))
                                                                <li>{{ $document['inputs'][$data->key]['label'] }}:
                                                                    {{ $data->value }}</li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </td>

                                        @if ($roles != 'applicant')
                                            <td>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input required-for-approve property-document-approval-chk"
                                                        type="checkbox" name="checkedAction" id="checkedAction"
                                                        @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                        @if ($roles != 'section-officer') disabled @endif>
                                                    <label class="form-check-label" for="checkedAction">Checked</label>
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

                            {{-- <tr>
                                <td colspan="5" class="document-type-row">
                                    <h4 class="doc-type-title">Additional Documents By SO</h4>
                                </td>
                            </tr>
                            @php
                                $soAdditionalDocuments = [];
                                if (!empty($details->documentFinal)) {
                                    $soAdditionalDocuments = $details->documentFinal
                                        ->where('document_type', 'AdditionalDocument')
                                        ->whereNull('file_path')
                                        ->whereNotNull('office_file_path')
                                        ->all();
                                }
                                $uplodedDocCount = count($soAdditionalDocuments);
                                $count = 1;
                            @endphp
                            @if ($uplodedDocCount > 0)
                                @foreach ($soAdditionalDocuments as $index => $ud)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td colspan="4" style="text-align: left;">
                                            <span class="doc-name">{{ $ud['title'] }} <a
                                                    href="{{ asset('storage/' . $ud['office_file_path'] ?? '') }}"
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
                            @endif --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
