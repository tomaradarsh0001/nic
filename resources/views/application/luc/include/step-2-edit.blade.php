<div class="mt-3">
    <div class="container-fluid">
        <div class="row g-2">
            <div class="col-lg-12">

                <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                @php
                    $docInputs = config('applicationDocumentType.LUC.documents');
                    $rowNum = 1;
                    $maxRowNum = collect($docInputs)->max('rowOrder');

                @endphp

                @for ($i = $rowNum; $i <= $maxRowNum; $i++)
                    @php
                        $docsForOrder = collect($docInputs)->where('rowOrder', $i)->all();
                    @endphp

                    @if (count($docsForOrder) > 0)
                        <div class="row row-mb-2">
                            <div class="col-lg-1 icons-flex"></div>
                            <div class="col-lg-11 selected-docs-field">
                                <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                                <div class="row">
                                    @foreach ($docsForOrder as $key => $doc)
                                        <div class="col-lg-4">
                                            @php
                                                $showViewLink = false;
                                                $finalDocument = null;
                                                if (
                                                    isset($stepSecondFinalDocuments) &&
                                                    isset($stepSecondFinalDocuments[$key])
                                                ) {
                                                    $finalDocument = $stepSecondFinalDocuments[$key];
                                                    $showViewLink = true;
                                                }
                                            @endphp
                                            @if ($showViewLink)
                                                <div class="form-group form-box">
                                                    <label for="{{ $doc['id'] }}"
                                                        class="quesLabel">{{ $doc['label'] }}
                                                        @if ($doc['required'] == 1)
                                                            <span class="text-danger"></span>
                                                        @endif
                                                    </label>

                                                </div>
                                                <a href="{{ !is_null($finalDocument) ? asset('storage/' . $finalDocument['file_path']) : '' }}"
                                                    target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                                    aria-label="View Uploaded Files">
                                                    <i class="bx bxs-file-pdf"></i>
                                                </a>
                                            @endif


                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endfor

            </div>


        </div>
    </div>
</div>
