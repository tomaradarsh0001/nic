<div class="mt-3">
    <div class="container-fluid">
        <div class="row g-2">
            <div class="col-lg-12" id="stepThreeDiv">
               

                @php
                $stepThreeDocs = config('applicationDocumentType.MUTATION.Optional');
                @endphp
                @foreach($stepThreeDocs as $document)
                @php
                    /**UPLOADED DOCS MATCHING $document['id'] */
                    $uploadeddocsWithDocType =  isset($stepSecondFinalDocuments) ? collect($stepSecondFinalDocuments)->where('document_type',$document['id'])->all():[];
                @endphp
                <div class="row row-mb-2" id="{{ $document['id'] }}_check" style="display: none;">
                    <div class="col-lg-1 icons-flex"></div>
                    <div class="col-lg-11 selected-docs-field">
                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                        @if($document['multiple'])
                        <div id="{{$document['id']}}_repeater" class="position-relative doc-items">
                            <div class="position-sticky text-end mt-2 {{$document['multiple']}}"
                                style="top: 70px; margin-right: 10px; margin-bottom: 10px; z-index: 9;">
                                <button type="button" class="btn btn-primary repeater-add-btn" data-toggle="tooltip"
                                    data-placement="bottom" title="Click on to add more Co-Applicant below"><i
                                        class="bx bx-plus me-0"></i></button>
                            </div>
                            @endif
                            <!-- Repeater Items -->
                            <div class="duplicate-field-tab">
                            @forelse($uploadeddocsWithDocType as $i=>$uploadeddocsWithDoc)
                                <div class="{{ $document['multiple'] == 1 ? 'items' : '' }}"
                                    data-group="{{ $document['id'] }}">
                                    <!-- Repeater Content -->
                                    <div class="item-content mb-2">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group form-box">
                                                    <label for="{{ $document['id'] }}"
                                                        class="quesLabel">{{$document['label']}}<span
                                                            class="text-danger">*</span></label>
                                                   <a href="{{asset('storage/' .$uploadeddocsWithDoc->file_path ?? '')}}" target="_blank" class="text-danger"><i class="fa-solid fa-file-pdf ml-2"></i></a>
                                                </div>
                                            </div>
                                            @php
                                            $count = 1;
                                            $length = count($document['inputs']);
                                            @endphp

                                            @foreach($document['inputs'] as $input)
                                                @php 
                                                $oldValue = '';
                                                $id = '';
                                                if($uploadeddocsWithDoc){
                                                    $values = $uploadeddocsWithDoc->values;
                                                    if($values){
                                                        $value = collect($values)->where('key',$input['id'])->first();
                                                        if($value){
                                                            $oldValue = $value->value;
                                                            $id = $value->id;
                                                        }
                                                    }
                                                }
                                                
                                                @endphp
                                                    <div class="col-lg-4 {{($document['multiple'] && $count === $length) ? 'mix-field':''}}">
                                                            <div class="form-group">
                                                                <label for="{{ $input['id'] }}">
                                                                    {{ $input['label'] }}<span class="text-danger">*</span>
                                                                </label>
                                                                <span class="fw-bold">{{$oldValue}}</span>
                                                            </div>

                                                            @if($document['multiple'] && $count === $length)
                                                            <div class="repeater-remove-btn" style="margin-bottom: 0px;">
                                                                <button type="button" class="btn-invisible remove-btn px-4"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Click to delete this form">
                                                                    <i class="fadeIn animated bx bx-trash"></i>
                                                                </button>
                                                            </div>
                                                            @endif

                                                            @php
                                                            $count++;
                                                            @endphp
                                                    </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="{{ $document['multiple'] == 1 ? 'items' : '' }}"
                                    data-group="{{ $document['id'] }}">
                                    <!-- Repeater Content -->
                                    <div class="item-content mb-2">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group form-box">
                                                    <label for="{{ $document['id'] }}"
                                                        class="quesLabel">{{$document['label']}}<span
                                                            class="text-danger">*</span></label>
                                                        <input type="file" name="{{ $document['id'] }}" class="form-control"
                                                            accept="application/pdf" id="{{ $document['id'] }}"
                                                            @if(!$document['multiple']) onchange="handleFileUploadEdit(this.files[0], '{{ $document['label'] }}', '{{ $document['id'] }}', 'mutation', 'SUB_MUT')"
                                                            @endif data-name="{{ $document['id'] }}">
                                                    <div id="{{$document['id']}}Error" class="text-danger text-left">
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                            $count = 1;
                                            $length = count($document['inputs']);
                                            @endphp

                                            @foreach($document['inputs'] as $input)
                                            <div class="col-lg-4 {{($document['multiple'] && $count === $length) ? 'mix-field':''}}">
                                                    <div class="form-group">
                                                        <label for="{{ $input['id'] }}">
                                                            {{ $input['label'] }}<span class="text-danger">*</span>
                                                        </label>
                                                        <input type="{{ $input['type'] }}" name="{{ $input['id'] }}"
                                                            class="form-control" id="{{ $input['id'] }}"
                                                            data-name="{{ $input['id'] }}">
                                                        <div id="{{ $input['id'] }}Error" class="text-danger text-left">
                                                        </div>
                                                    </div>

                                                    @if($document['multiple'] && $count === $length)
                                                    <div class="repeater-remove-btn" style="margin-bottom: 0px;">
                                                        <button type="button" class="btn-invisible remove-btn px-4"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Click to delete this form">
                                                            <i class="fadeIn animated bx bx-trash"></i>
                                                        </button>
                                                    </div>
                                                    @endif

                                                    @php
                                                    $count++;
                                                    @endphp
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforelse

                            </div>
                            @if($document['multiple'])
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>