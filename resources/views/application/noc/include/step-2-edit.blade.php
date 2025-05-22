    <div class="mt-3">
        <div class="container-fluid">
            <div class="row g-2">
                <div class="col-lg-12">

                    @php
                        $stepTwoDocs = config('applicationDocumentType.NOC.Required');
                    @endphp
                    @foreach ($stepTwoDocs as $document)
                        @php
                            /**UPLOADED DOCS MATCHING $document['id'] */
                            $uploadeddocsWithDocType = isset($stepSecondFinalDocuments)
                                ? collect($stepSecondFinalDocuments)->where('document_type', $document['id'])->all()
                                : [];
                        @endphp
                        <!-- Repeater Items -->
                        <div class="duplicate-field-tab">
                            @foreach ($uploadeddocsWithDocType as $i => $uploadeddocsWithDoc)
                                <div class="row row-mb-2">
                                    <div class="col-lg-1 icons-flex"></div>
                                    <div class="col-lg-11 selected-docs-field">
                                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                                        @if ($document['multiple'])
                                            <div id="{{ $document['id'] }}_repeater"
                                                class="position-relative doc-items">
                                        @endif
                                        <div class="{{ $document['multiple'] == 1 ? 'items' : '' }}"
                                            data-group="{{ $document['id'] }}" data-type="document"
                                            data-document-type="{{ $document['id'] }}">
                                            <!-- Repeater Content -->
                                            <div class="item-content">
                                                <input type="hidden" data-name="indexValue" value="">
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <div class="form-group form-box">
                                                            <!-- added class form-label by anil on 17-04-2025 -->
                                                            <label for="{{ $document['id'] }}"
                                                                class="quesLabel form-label">{{ $document['label'] }}

                                                                @if ($document['id'] != 'otherDocumentbyApplicant' && $document['id'] != 'conveyanceconappdoc')
                                                                    <span class="text-danger">*</span>
                                                                @endif

                                                            </label>

                                                            <a href="{{ asset('storage/' . $uploadeddocsWithDoc->file_path ?? '') }}"
                                                                target="_blank" class="text-danger"><i
                                                                    class="fa-solid fa-file-pdf ml-2"></i></a>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $count = 1;
                                                        $length = count($document['inputs']);
                                                    @endphp

                                                    @foreach ($document['inputs'] as $input)
                                                        @php
                                                            $oldValue = '';
                                                            $id = '';
                                                            if ($uploadeddocsWithDoc) {
                                                                $values = $uploadeddocsWithDoc->values;
                                                                if ($values) {
                                                                    $value = collect($values)
                                                                        ->where('key', $input['id'])
                                                                        ->first();
                                                                    if ($value) {
                                                                        $oldValue = $value->value;
                                                                        $id = $value->id;
                                                                    }
                                                                }
                                                            }

                                                        @endphp
                                                        <div
                                                            class="col-lg-4 {{ $document['multiple'] && $count === $length ? 'mix-field' : '' }}">
                                                            <div class="form-group">
                                                                <!-- added class form-label by anil on 17-04-2025 -->
                                                                <label for="{{ $input['id'] }}" class="form-label">
                                                                    {{ $input['label'] }}<span
                                                                        class="text-danger">*</span>
                                                                </label>
                                                                <span class="fw-bold">{{ $oldValue }}</span>
                                                            </div>
                                                            @php
                                                                $count++;
                                                            @endphp
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        @if ($document['multiple'])
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    </div>
