<div class="mt-3">
    <div class="container-fluid">
        <div class="row g-2">
            <div class="col-lg-12">
                @php
                    $inputGroups = config('applicationDocumentType.CONVERSION.optional.groups');
                    $isLeaseDeedLost = isset($application) && $application->is_Lease_deed_lost == 1 ? 'Yes' : 'No';
                @endphp
                @foreach ($inputGroups as $ig)
                    
                    <div class="row row-mb-2">
                        <div class="col-lg-1 icons-flex"></div>
                        <div class="col-lg-11 selected-docs-field">
                            <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                            <div class="row pb-2">
                                @if (isset($ig['input']) && $ig['input']['type'] == 'radio')
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mr-5 mb-2">{{ $ig['input']['label'] }}</h6>
                                            <div class="form-check mr-5">
                                                <label class="form-check-label">
                                                    <h6 class="mb-0">{{ $isLeaseDeedLost }}</h6>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (isset($ig['input']))
                                    <div class="col-lg-12" id="optionalInputs"
                                        style="display: {{ $isLeaseDeedLost ? 'block' : 'none' }};">
                                        <div class="row">
                                @endif
                                @foreach ($ig['documents'] as $document)
                                    @php
                                        /**UPLOADED DOCS MATCHING $ig['id'] */
                                        $uploadeddocsWithDocType = isset($stepSecondFinalDocuments) ? collect($stepSecondFinalDocuments)->where('document_type',$document['id'])->first():[];
                                    @endphp
                                        @if($uploadeddocsWithDocType)
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group form-box">
                                                    <label for="{{ $document['id'] }}"
                                                        class="quesLabel">{{$document['label']}}<span
                                                            class="text-danger">*</span></label>
                                                        
                                                    <a href="{{asset('storage/' .$uploadeddocsWithDocType->file_path)}}" target="_blank" class="text-danger"><i class="fa-solid fa-file-pdf ml-2"></i></a>
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
                                                if($uploadeddocsWithDocType){
                                                    $values = $uploadeddocsWithDocType->values;
                                                    if($values){
                                                        $value = collect($values)->where('key',$input['id'])->first();
                                                        if($value){
                                                            $oldValue = $value->value;
                                                            $id = $value->id;
                                                        }
                                                    }
                                                }
                                                
                                                @endphp
                                                    <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label for="{{ $input['id'] }}">
                                                                    {{ $input['label'] }}<span class="text-danger">*</span>
                                                                </label>
                                                                <span class="fw-bold">{{$oldValue}}</span>   
                                                            </div>
                                                @php
                                                $count++;
                                                @endphp
                                                </div>
                                            @endforeach
                                        </div> 
                                        @endif    
                                @endforeach
                                @if (isset($ig['input']))
                            </div>
                        </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
</div>
</div>
</div>
