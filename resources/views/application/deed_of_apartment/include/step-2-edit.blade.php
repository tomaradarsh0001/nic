<div class="mt-3">
    <div class="container-fluid">
        <div class="row g-2">
            <div class="col-lg-12">

                <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                @php
                    $stepTwoDocs = config('applicationDocumentType.DOA.documents');
                @endphp
                @foreach ($stepTwoDocs as $document)
                    @php
                        $uploadeddocsWithDocType = isset($stepSecondFinalDocuments)
                            ? collect($stepSecondFinalDocuments)
                                ->where('document_type', $document['id'])
                                ->all()
                            : [];
                    @endphp
                    @foreach ($uploadeddocsWithDocType as $i => $uploadeddocsWithDoc)
                        <div class="row row-mb-2">
                            <div class="col-lg-1 icons-flex"></div>
                            <div class="col-lg-11 selected-docs-field">
                                <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group form-box view-f">
                                            <label for="{{ $document['id'] }}"
                                                class="quesLabel">{{ $document['label'] }}</label>
                                            <a href="{{ !is_null($uploadeddocsWithDoc->file_path) ? asset('storage/' . $uploadeddocsWithDoc->file_path) : '' }}"
                                                target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                                aria-label="View Uploaded Files">
                                                <i class="bx bxs-file-pdf"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>
