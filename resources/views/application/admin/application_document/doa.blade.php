{{--<div class="part-title mt-2">
    <h5>Property Document Details</h5>
</div>
<div class="part-details">
    <div class="container-fluid">
        <div class="row g-2">
            <div class="col-lg-12">
                <table class="table table-bordered property-table-info">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Document Name</th>
                            <th style="text-align:center;">View Docs</th>
                            @if ($roles != 'applicant')
                                <th>Action</th>
                            @endif
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
                                    <td>{{ $document['title'] }}</td>
                                    <td style="text-align:center;">
                                        <a href="{{ asset('storage/' . ($document['file_path'] ?? '')) }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files">
                                            <i class="bx bxs-file-pdf"></i>
                                        </a>
                                    </td>
                                    @if ($roles != 'applicant')
                                        <td>
                                            <div class="form-check form-check-success">
                                                <input class="form-check-input property-document-approval-chk"
                                                    type="checkbox" role="switch"
                                                    @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                    @if ($roles != 'section-officer') disabled @endif>
                                                <label class="form-check-label">Checked</label>
                                            </div>
                                        </td>
                                    @endif
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
                                <tr>
                                    <td>{{ ++$counter }}</td>
                                    <td>{{ $ud['title'] }}</td>
                                    <td style="text-align:center;">
                                        <a href="{{ asset('storage/' . $ud['file_path'] ?? '') }}" target="_blank"
                                            class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files">
                                            <i class="bx bxs-file-pdf"></i>
                                        </a>
                                    </td>
                                    @if ($roles != 'applicant')
                                        <td>
                                            <div class="form-check form-check-success">
                                                <input class="form-check-input property-document-approval-chk"
                                                    type="checkbox" role="switch"
                                                    @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                    @if ($roles != 'section-officer') disabled @endif>
                                                <label class="form-check-label">Checked</label>
                                            </div>
                                        </td>
                                    @endif
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
                            <td colspan="4" class="document-type-row">
                                <h4 class="doc-type-title">Additional Documents By Section</h4>
                            </td>
                        </tr>
                        @php
                            $sectionAdditionalDocument = [];
                            if (!empty($details->documentFinal)) {
                                $sectionAdditionalDocument = $details->documentFinal
                                    ->where('document_type', 'AdditionalDocument')
                                    ->whereNull('file_path')
                                    ->whereNotNull('office_file_path')
                                    ->all();
                            }
                            $uplodedDocCount = count($sectionAdditionalDocument);
                            $count = 1;
                        @endphp
                        @if ($uplodedDocCount > 0)
                            @foreach ($sectionAdditionalDocument as $index => $ud)
                                <tr>
                                    <td>{{ $count }}</td>
                                    <td>{{ $ud['title'] }}</td>
                                    <td style="text-align:center;">
                                        <a href="{{ asset('storage/' . $ud['file_path'] ?? '') }}" target="_blank"
                                            class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files">
                                            <i class="bx bxs-file-pdf"></i>
                                        </a>
                                    </td>
                                    @if ($roles != 'applicant')
                                        <td>
                                            <div class="form-check form-check-success">
                                                <input class="form-check-input property-document-approval-chk"
                                                    type="checkbox" role="switch"
                                                    @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                    @if ($roles != 'section-officer') disabled @endif>
                                                <label class="form-check-label">Checked</label>
                                            </div>
                                        </td>
                                    @endif
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
--}}


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
                                <th>S.No</th>
                                <th>Document Name</th>
                                @if ($roles != 'applicant')
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" class="document-type-row">
                                    <h4 class="doc-type-title">Required Documents</h4>
                                </td>
                            </tr>
                            @if (!empty($documents['required']))
                                @foreach ($documents['required'] as $key => $document)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <span class="doc-name">
                                                {{ $document['title'] }} <a
                                                    href="{{ asset('storage/' . $document['file_path'] ?? '') }}"
                                                    target="_blank" class="text-danger"><i
                                                        class="fa-solid fa-file-pdf ml-2"></i></a>
                                            </span>
                                        </td>
                                        @if ($roles != 'applicant')
                                            <td>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input required-for-approve property-document-approval-chk"
                                                        type="checkbox"
                                                        @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                        @if ($roles != 'section-officer') disabled @endif>
                                                    <label class="form-check-label" for="checkedAction">Checked</label>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
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
                                    <tr>
                                        <td>{{ ++$counter }}</td>
                                        <td><span class="doc-name">{{ $ud['title'] }} <a
                                                    href="{{ asset('storage/' . $ud['file_path'] ?? '') }}"
                                                    target="_blank" class="text-danger"><i
                                                        class="fa-solid fa-file-pdf ml-2"></i></a></span>
                                        </td>
                                        @if ($roles != 'applicant')
                                            <td>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input required-for-approve property-document-approval-chk"
                                                        type="checkbox"
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
                                    <td colspan="3" class="">
                                        <p class="">No Documents Available</p>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="3" class="document-type-row">
                                    <h4 class="doc-type-title">Additional Documents By Section</h4>
                                </td>
                            </tr>
                            @php
                                $sectionAdditionalDocument = [];
                                if (!empty($details->documentFinal)) {
                                    $sectionAdditionalDocument = $details->documentFinal
                                        ->where('document_type', 'AdditionalDocument')
                                        ->whereNull('file_path')
                                        ->whereNotNull('office_file_path')
                                        ->all();
                                }
                                $uplodedDocCount = count($sectionAdditionalDocument);
                                $count = 1;
                            @endphp
                            @if ($uplodedDocCount > 0)
                                @foreach ($sectionAdditionalDocument as $index => $ud)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td><span class="doc-name">{{ $ud['title'] }} <a
                                                    href="{{ asset('storage/' . $ud['office_file_path'] ?? '') }}"
                                                    target="_blank" class="text-danger"><i
                                                        class="fa-solid fa-file-pdf ml-2"></i></a></span></td>
                                        @if ($roles != 'applicant')
                                            <td>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input required-for-approve property-document-approval-chk"
                                                        type="checkbox"
                                                        @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                        @if ($roles != 'section-officer') disabled @endif>
                                                    <label class="form-check-label" for="checkedAction">Checked</label>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                    @php
                                        $count = $count + 1;
                                    @endphp
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="">
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
</div>
