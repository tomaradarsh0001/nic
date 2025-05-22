<div class="mt-3">
    <div class="container-fluid">
        <div class="row g-2">
            <div class="col-lg-12">

                @php
                $stepTwoDocs = config('applicationDocumentType.MUTATION.Required');
                @endphp
                @foreach($stepTwoDocs as $document)
                @php
                /**UPLOADED DOCS MATCHING $document['id'] */
                $uploadeddocsWithDocType = isset($stepSecondFinalDocuments) ? collect($stepSecondFinalDocuments)->where('document_type',$document['id'])->all():[];
                @endphp

                <div class="row row-mb-2">
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
                                    data-group="{{ $document['id'] }}" data-type="document" data-document-type="{{ $document['id'] }}">
                                    <!-- Repeater Content -->
                                    <div class="item-content mb-2">
                                    <input type="hidden" data-name="indexValue" value="">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group form-box">
                                                <label for="{{ $document['id'] }}" class="quesLabel">
                                                    {{ ($document['label'] == "Property Photo") ? $document['label'] . ' (Showing the use of property)' : $document['label'] }}
                                                    <span class="text-danger">*</span>
                                                </label>

                                                        <input type="file" name="{{ $document['id'] }}" class="form-control"
                                                            accept="application/pdf" id="{{ $document['id'] }}"
                                                            @if(!$document['multiple']) onchange="handleFileUpload(this.files[0], '{{ $document['label'] }}', '{{ $document['id'] }}', 'mutation', 'SUB_MUT')"
                                                            @endif data-name="{{ $document['id'] }}" data-should-validate="{{ isset($uploadeddocsWithDoc->file_path) ? '1' : '' }}"
                                                            >
                                                        <input type="hidden" value="{{ $uploadeddocsWithDoc->id }}" name="{{ $uploadeddocsWithDoc->id }}" data-name="{{ $document['id'] }}_oldId" data-repeaterId="id" >
                                                        <div id="{{$document['id']}}Error" class="text-danger text-left"></div>
                                                   <a href="{{asset('storage/' .$uploadeddocsWithDoc->file_path ?? '')}}" data-document-type="{{ $document['id']}}" target="_blank"
                                                   class="fs-6">View saved document</a>
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
                                                                <input type="{{ $input['type'] }}" name="{{ $input['id'] }}"
                                                                    class="form-control" id="{{ $input['id'] }}"
                                                                    data-name="{{ $input['id'] }}" value="{{$oldValue}}"
                                                                    >
                                                                    <input type="hidden" value="{{ $id }}" name="{{ $id }}" data-name="{{ $input['id'] }}_oldId" >
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
                                @empty

                                <div class="{{ $document['multiple'] == 1 ? 'items' : '' }}"
                                    data-group="{{ $document['id'] }}" data-type="document" data-document-type="{{ $document['id'] }}">
                                    <!-- Repeater Content -->
                                    <div class="item-content mb-2">
                                        <input type="hidden" name="indexValue" value="">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group form-box">
                                                    <label for="{{ $document['id'] }}" class="quesLabel">
                                                        {{ ($document['label'] == "Property Photo") ? $document['label'] . ' (Showing the use of property)' : $document['label'] }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="file" name="{{ $document['id'] }}" class="form-control"
                                                        accept="application/pdf" id="{{ $document['id'] }}"
                                                        @if(!$document['multiple']) onchange="handleFileUpload(this.files[0], '{{ $document['label'] }}', '{{ $document['id'] }}', 'mutation', 'SUB_MUT')"
                                                        @endif data-name="{{ $document['id'] }}">
                                                    <input type="hidden" value="" name="{{ $document['id'] }}" data-name="{{ $document['id'] }}_oldId" data-repeaterId="id" >
                                                    <div id="{{$document['id']}}Error" class="text-danger text-left"></div>
                                                </div>
                                            </div>
                                            @php
                                            $count = 1;
                                            $length = count($document['inputs']);
                                            @endphp

                                            @foreach($document['inputs'] as $input)

                                            <div class="col-lg-4 {{($document['multiple'] && $count === $length) ? 'icon-feild':''}}">
                                                <div class="row">
                                                    <div class="col-lg-9">
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
                                                    </div>

                                                   <div class="col-lg-3">
                                                    @if($document['multiple'] && $count === $length)
                                                        <div class="repeater-remove-btn" style="margin-bottom: 0px;">
                                                            <button type="button" class="btn-invisible remove-btn px-4"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Click to delete this form">
                                                                <i class="fadeIn animated bx bx-trash"></i>
                                                            </button>
                                                        </div>
                                                        @endif
                                                   </div>
                                                </div>

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