<div class="mt-3">
    <div class="container-fluid">
        <div class="row g-2">
            <div class="col-lg-12">
                @php
                $stepTwoDocs = config('applicationDocumentType.CONVERSION.Required');
                @endphp
                @foreach($stepTwoDocs as $document)
                <div class="row row-mb-2">
                    <div class="col-lg-1 icons-flex"></div>
                    <div class="col-lg-11 selected-docs-field">
                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                        @if($document['multiple'])
                        <div id="{{$document['id']}}_repeater" class="position-relative doc-items">
                            <div class="position-sticky text-end mt-2 {{$document['multiple']}}"
                                style="top: 70px; margin-right: 10px; margin-bottom: 10px; z-index: 9;">
                                <button type="button" class="btn btn-primary repeater-add-btn" data-toggle="tooltip"
                                    data-placement="bottom" title="Click to add one more document below"><i
                                        class="bx bx-plus me-0"></i></button>
                            </div>
                            @endif
                            @php
                            $uploadedDocuments = [];
                            if(!empty($application->tempDocument)){
                            $uploadedDocuments = $application->tempDocument->where('document_type',$document['id'])->all();
                            }

                            @endphp
                            <!-- Repeater Items -->
                            <div class="duplicate-field-tab">

                                @forelse($uploadedDocuments as $ud)
                                <div class="{{ $document['multiple'] == 1 ? 'items' : '' }}" data-group="{{ $document['id'] }}_conversion" data-type="document" data-document-type="{{ $document['id'] }}">
                                    <input type="hidden" data-name="indexNo" value="{{$ud->index_no ?? $loop->iteration}}"><!-- if index-no is not preset (for old data). then assign loop count-->
                                    <input type="hidden" data-repeaterId="id" value="{{$ud->id}}">
                                    <div class="item-content mb-2">
                                        <div class="row">
                                            @if(!isset($document['isFirstInput']) || ($document['isFirstInput'] === true) )
                                            <div class="col-lg-4 {{  empty($document['inputs']) ? 'icon-feild' : '' }}">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-9">
                                                        <div class="form-group form-box">
                                                            <label for="{{ $document['id'] }}" class="quesLabel">{{$document['label']}}<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="hidden" name="{{ $document['id'].'Id' }}" value="{{$ud['id']}}" data-name="id"><!--To be used in edit -->
                                                            <input type="file" name="{{ $document['id'] }}" class="form-control"
                                                                accept="application/pdf" id="{{ $document['id'] }}"
                                                                @if(!$document['multiple']) onchange="handleFileUpload(this.files[0], '{{ $document['label'] }}','{{ $document['id'] }}', 'conversion', 'CONVERSION')" @endif data-name="{{ $document['id'] }}" data-should-validate = "{{isset($ud) && $ud['file_path'] != ''}}">
                                                            <a href="{{asset('storage/'.$ud['file_path'] ?? '')}}" target="_blank"
                                                                class="fs-6">View saved document</a>
                                                            <div id="{{$document['id']}}Error" class="text-danger text-left">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($document['multiple'] && empty($document['inputs']))
                                                    <div class="col-lg-3">
                                                        <div class="repeater-remove-btn" style="margin-bottom: 0px;">
                                                            <button type="button" class="btn-invisible remove-btn px-4"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Click on to delete this form">
                                                                <i class="fadeIn animated bx bx-x-circle"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            @if(isset($document['inputs']))
                                            @foreach($document['inputs'] as $input)
                                            @php
                                            $uploadedValue = $ud->tempDocumentKeys->where('key',$input['id'])->first();
                                            @endphp
                                            <div class="col-lg-4 {{($document['multiple'] && $loop->iteration === count($document['inputs'])) ? 'mix-field':''}}">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-9">
                                                        <div class="form-group">
                                                            <label for="dateattestation">{{$input['label']}}<span
                                                            class="text-danger">*</span></label>
                                                            @if($input['type'] == 'select')
                                                            <select name="{{$input['id']}}" id="{{$input['id']}}" class="form-select">
                                                                <option value="">Select</option>
                                                                @foreach($input['options'] as $option)
                                                                <option value="{{$option}}" {{$uploadedValue->value == $option ? 'selected': ''}}>{{$option}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div id="{{$input['id']}}Error" class="text-danger text-left"></div>
                                                            @else
                                                            <input type="{{$input['type']}}" name="{{$input['id']}}" class="form-control"
                                                            id="{{$input['id']}}" data-name="{{ $input['id'] }}" value="{{$uploadedValue->value ??''}}">
                                                            
                                                            <div id="{{$input['id']}}Error" class="text-danger text-left"></div>
                                                            @endif
                                                            
                                                        </div>
                                                    </div>
                                                    {{-- <pre>{{print_r($ud)}}</pre> --}}
                                                    @if($document['multiple'] && $loop->iteration === count($document['inputs']))
                                                    <div class="col-lg-3">
                                                        <div class="repeater-remove-btn" style="margin-bottom: 0px;">
                                                            <button type="button" class="btn-invisible remove-btn px-4"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Click on to delete this form" onclick="removeRepeater($(this).parents('.items'),'{{$ud->index_no ?? $loop->iteration}}')">
                                                                <i class="fadeIn animated bx bx-x-circle"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>

                                            @if(isset($document['isFirstInput']) && $document['isFirstInput'] === false && $document['displayAtIndex'] == $loop->iteration)
                                            <div class="col-lg-4">
                                                <div class="form-group form-box">
                                                    <label for="{{ $document['id'] }}" class="quesLabel">{{$document['label']}}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" name="{{ $document['id'] }}" class="form-control"
                                                        accept="application/pdf" id="{{ $document['id'] }}"
                                                        onchange="handleFileUpload(this.files[0], '{{ $document['label'] }}','{{ $document['id'] }}', 'conversion', 'CONVERSION')" data-name="{{ $document['id'] }}" data-should-validate = "{{isset($ud) && $ud['file_path'] != ''}}">
                                                    <a href="{{asset('storage/'.$ud['file_path'] ?? '')}}" target="_blank"
                                                        class="fs-6">View saved document</a>
                                                    <div id="{{$document['id']}}Error" class="text-danger text-left">
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="{{ $document['multiple'] == 1 ? 'items' : '' }}" data-group="{{ $document['id'] }}_conversion" data-type="document" data-document-type="{{ $document['id'] }}">
                                    <input type="hidden" data-name="indexNo" value="1">
                                    <!-- Repeater Content -->
                                    <div class="item-content mb-2">
                                        <div class="row">
                                            @if(!isset($document['isFirstInput']) || ($document['isFirstInput'] === true) )
                                            <div class="col-lg-4 {{  empty($document['inputs']) ? 'icon-feild' : '' }}">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-9">
                                                        <div class="form-group form-box">
                                                            <label for="{{ $document['id'] }}" class="quesLabel">{{$document['label']}}<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="hidden" name="{{ $document['id'].'Id' }}" value="" data-name="id"><!--To be used in edit -->
                                                            <input type="file" name="{{ $document['id'] }}" class="form-control"
                                                                accept="application/pdf" id="{{ $document['id'] }}"
                                                                @if(!$document['multiple']) onchange="handleFileUpload(this.files[0], '{{ $document['label'] }}','{{ $document['id'] }}', 'conversion', 'CONVERSION')" @endif data-name="{{ $document['id'] }}">
                                                            <div id="{{$document['id']}}Error" class="text-danger text-left">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($document['multiple'] && empty($document['inputs']))
                                                    <div class="col-lg-3">
                                                        <div class="repeater-remove-btn" style="margin-bottom: 0px;">
                                                            <button type="button" class="btn-invisible remove-btn px-4"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Click on to delete this form">
                                                                <i class="fadeIn animated bx bx-x-circle"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            @if(isset($document['inputs']))
                                            @foreach($document['inputs'] as $input)
                                            <div class="col-lg-4 {{($document['multiple'] && $loop->iteration === count($document['inputs'])) ? 'icon-feild':''}}">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-9">
                                                        <div class="form-group">
                                                            <label for="dateattestation">{{$input['label']}}<span
                                                                    class="text-danger">*</span></label>
                                                            @if($input['type'] == 'select')
                                                            <select name="{{$input['id']}}" id="{{$input['id']}}" class="form-select">
                                                                <option value="">Select</option>
                                                                @foreach($input['options'] as $option)
                                                                <option value="{{$option}}">{{$option}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div id="{{$input['id']}}Error" class="text-danger text-left"></div>
                                                            @else
                                                            <input type="{{$input['type']}}" name="{{$input['id']}}" class="form-control"
                                                                id="{{$input['id']}}" data-name="{{ $input['id'] }}">
                                                            <div id="{{$input['id']}}Error" class="text-danger text-left"></div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    @if($document['multiple'] && $loop->iteration === count($document['inputs']))
                                                    <div class="col-lg-9">
                                                        <div class="repeater-remove-btn" style="margin-bottom: 0px;">
                                                            <button type="button" class="btn-invisible remove-btn px-4"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Click on to delete this form" onclick="removeRepeater($(this).parents('.items'),1)">
                                                                <i class="fadeIn animated bx bx-x-circle"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>

                                            @if(isset($document['isFirstInput']) && $document['isFirstInput'] === false && $document['displayAtIndex'] == $loop->iteration)
                                            <div class="col-lg-4">
                                                <div class="form-group form-box">
                                                    <label for="{{ $document['id'] }}" class="quesLabel">{{$document['label']}}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" name="{{ $document['id'] }}" class="form-control"
                                                        accept="application/pdf" id="{{ $document['id'] }}"
                                                        onchange="handleFileUpload(this.files[0], '{{ $document['label'] }}','{{ $document['id'] }}', 'conversion', 'CONVERSION')" data-name="{{ $document['id'] }}">
                                                    <div id="{{$document['id']}}Error" class="text-danger text-left">
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                            @endif

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