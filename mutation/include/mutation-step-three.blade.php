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
                <div class="row row-mb-2" id="{{ $document['id'] }}_check" style="display: {{ $document['id'] == 'otherDocumentbyApplicant' ? 'flex' : 'none' }};">
                    <div class="col-lg-1 icons-flex"></div>
                    <div class="col-lg-11 selected-docs-field">
                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                        @if($document['multiple'])
                        <div id="{{$document['id']}}_repeater" class="position-relative doc-items">
                            <div class="position-sticky text-end mt-2 {{$document['multiple']}}"
                                style="top: 70px; margin-right: 10px; margin-bottom: 10px; z-index: 9;">
                                <button type="button" class="btn btn-primary repeater-add-btn" data-toggle="tooltip"
                                    data-placement="bottom" title="Click here to add more co-applicant."><i
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
                                                    <!-- added class form-label by anil on 17-04-2025 -->
                                                    <label for="{{ $document['id'] }}"
                                                        class="quesLabel form-label">{{$document['label']}}
                                                        @if ($document['id'] != 'otherDocumentbyApplicant')
                                                            <span class="text-danger">*</span>
                                                        @endif
                                                    </label>

                                                            
                                                        <input type="file" name="{{ $document['id'] }}" class="form-control"
                                                            accept="application/pdf" id="{{ $document['id'] }}"
                                                            @if(!$document['multiple']) onchange="handleFileUpload(this.files[0], '{{ $document['label'] }}', '{{ $document['id'] }}', 'mutation', 'SUB_MUT')"
                                                            @endif data-name="{{ $document['id'] }}" data-should-validate="{{ isset($uploadeddocsWithDoc->file_path) ? '1' : '' }}"
                                                            >
                                                        <div id="{{$document['id']}}Error" class="text-danger text-left"></div>
                                                   <a href="{{asset('storage/' .$uploadeddocsWithDoc->file_path ?? '')}}" data-document-type="{{ $document['id']}}" target="_blank"
                                                   class="fs-6">View Saved Document</a>
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
                                                                <!-- added class form-label by anil on 17-04-2025 -->
                                                                <label for="{{ $input['id'] }}" class="form-label">
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
                                                                    title="Click here to delete this document.">
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
                                                    <!-- added class form-label by anil on 17-04-2025 -->
                                                    <label for="{{ $document['id'] }}"
                                                        class="quesLabel form-label">{{$document['label']}}
                                                        
                                                        @if ($document['id'] != 'otherDocumentbyApplicant')
                                                            <span class="text-danger">*</span>
                                                        @endif
                                                    </label>
                                                        <input type="file" name="{{ $document['id'] }}" class="form-control"
                                                            accept="application/pdf" id="{{ $document['id'] }}"
                                                            @if(!$document['multiple']) onchange="handleFileUpload(this.files[0], '{{ $document['label'] }}', '{{ $document['id'] }}', 'mutation', 'SUB_MUT')"
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
                                                        <!-- added class form-label by anil on 17-04-2025 -->
                                                        <label for="{{ $input['id'] }}" class="form-label">
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
                                                            title="Click here to delete this document.">
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

                <!-- @foreach($documentTypes as $document)
                    <div class="row row-mb-2" style="display:none" id="{{$document->item_code}}">
                        <div class="col-lg-1 icons-flex"></div>
                        <div class="col-lg-11 selected-docs-field">
                            <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group form-box">
                                        <label for="{{$document->item_code}}" class="quesLabel">{{$document->item_name}}</label>
                                        <input type="file" name="{{$document->item_code}}" class="form-control"
                                            accept="application/pdf"
                                            onchange="handleFileUpload(this.files[0],'{{$document->item_name}}','mutation','SUB_MUT')">
                                        <div id="{{$document->item_code}}Error" class="text-danger text-left"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach -->


                <!-- <div class="row row-mb-2">
                    <div class="col-lg-1 icons-flex"></div>
                    <div class="col-lg-11 selected-docs-field">
                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group form-box">
                                    <label for="deathCertificate" class="quesLabel">Death
                                        Certificate</label>
                                    <input type="file" name="deathCertificate" class="form-control"
                                        accept="application/pdf" id="deathCertificate"
                                        onchange="handleFileUpload(this.files[0],'Death Certificate','mutation','SUB_MUT')">
                                    <div id="deathCertificateError" class="text-danger text-left"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="deathCertificateDeceasedName">Name of Deceased</label>
                                    <input type="text" name="deathCertificateDeceasedName"
                                        class="form-control alpha-only" id="deceasedName"
                                        placeholder="Name of Deceased">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="deathCertificateDeathdate">Date of Death</label>
                                    <input type="date" name="deathCertificateDeathdate" class="form-control"
                                        id="deathdate">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="deathCertificateIssuedate">Date of Issue</label>
                                    <input type="date" name="deathCertificateIssuedate" class="form-control"
                                        id="issuedate" placeholder="Date of Issue">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="deathCertificateDocumentCertificate">Document/Certificate No.</label>
                                    <input type="text" name="deathCertificateDocumentCertificate" class="form-control"
                                        id="document_certificate" placeholder="Document/Certificate No.">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-mb-2">
                    <div class="col-lg-1 icons-flex"></div>
                    <div class="col-lg-11 selected-docs-field">
                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group form-box">
                                    <label for="saledeeddoc" class="quesLabel">Sale Deed</label>
                                    <input type="file" name="saledeeddoc" class="form-control" accept="application/pdf"
                                        id="saledeeddoc"
                                        onchange="handleFileUpload(this.files[0],'Sale Deed','mutation','SUB_MUT')">
                                    <div id="saledeeddocError" class="text-danger text-left"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="SaleDeedRegno">Registration No.</label>
                                    <input type="text" name="SaleDeedRegno" class="form-control numericOnly"
                                        id="saledeedregno" placeholder="Registration No.">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="SaleDeedVolume">Volume</label>
                                    <input type="text" min="0" name="SaleDeedVolume" class="form-control numericOnly"
                                        id="saledeedvolume" placeholder="Volume">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="saleDeedBookNo">Book No.</label>
                                    <input type="text" name="saleDeedBookNo" class="form-control numericOnly"
                                        id="saledeedbookno" placeholder="Book No.">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="saleDeedPageNo">Page No.</label>
                                    <input type="text" name="saleDeedPageNo" class="form-control numericOnly"
                                        id="saledeedpageno" placeholder="Page No.">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="saleDeedFrom">From</label>
                                    <input type="date" name="saleDeedFrom" class="form-control" id="saledeedfrom">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="saleDeedTo">To</label>
                                    <input type="date" name="saleDeedTo" class="form-control" id="saledeedto">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="saleDeedRegDate">Regn. Date</label>
                                    <input type="date" name="saleDeedRegDate" class="form-control" id="saledeedregdate">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="saleDeedRegOfficeName">Registration Office Name</label>
                                    <input type="text" name="saleDeedRegOfficeName" class="form-control alpha-only"
                                        id="saledeedregname" placeholder="Registration Office Name">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-mb-2">
                    <div class="col-lg-1 icons-flex"></div>
                    <div class="col-lg-11 selected-docs-field">
                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group form-box">
                                    <label for="regWillDeed" class="quesLabel">Regd. WILL Deed</label>
                                    <input type="file" name="regWillDeed" class="form-control" accept="application/pdf"
                                        id="regWillDeed"
                                        onchange="handleFileUpload(this.files[0],'Regd. WILL Deed','mutation','SUB_MUT')">
                                    <div id="regWillDeedError" class="text-danger text-left"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="regWillDeedTestatorName">Name of Testator</label>
                                    <input type="text" name="regWillDeedTestatorName" class="form-control alpha-only"
                                        id="testatorname" placeholder="Name of Testator">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="regWillDeedRegNo">Registration No.</label>
                                    <input type="text" name="regWillDeedRegNo" class="form-control numericOnly"
                                        id="WillRegNo" placeholder="Registration No.">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="regWillDeedVolume">Volume</label>
                                    <input type="text" min="0" name="regWillDeedVolume" class="form-control numericOnly"
                                        id="Willvolume" placeholder="Volume">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="regWillDeedBookNo">Book No.</label>
                                    <input type="text" name="regWillDeedBookNo" class="form-control numericOnly"
                                        id="Willbookno" placeholder="Book No.">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="regWillDeedPageNo">Page No.</label>
                                    <input type="text" name="regWillDeedPageNo" class="form-control numericOnly"
                                        id="Willpageno" placeholder="Page No.">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="regWillDeedFrom">From</label>
                                    <input type="date" name="regWillDeedFrom" class="form-control" id="Willfrom">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="regWillDeedTo">To</label>
                                    <input type="date" name="regWillDeedTo" class="form-control" id="Willto">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="regWillDeedRegDate">Regn. Date</label>
                                    <input type="date" name="regWillDeedRegDate" class="form-control" id="WillRegdate">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="regWillDeedRegOfficeName">Registration Office Name</label>
                                    <input type="text" name="regWillDeedRegOfficeName" class="form-control alpha-only"
                                        id="Willregname" placeholder="Registration Office Name">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-mb-2">
                    <div class="col-lg-1 icons-flex"></div>
                    <div class="col-lg-11 selected-docs-field">
                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group form-box">
                                    <label for="unregWillCodicil" class="quesLabel">Unregd.
                                        WILL/CODICIL</label>
                                    <input type="file" name="unregWillCodicil" class="form-control"
                                        accept="application/pdf" id="unregWillCodicil"
                                        onchange="handleFileUpload(this.files[0],'Unregd. WILL_CODICIL','mutation','SUB_MUT')">
                                    <div id="unregWillCodicilError" class="text-danger text-left"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="unregWillCodicilTestatorName">Name of Testator</label>
                                    <input type="text" name="unregWillCodicilTestatorName"
                                        class="form-control alpha-only" id="UnWilltestatorname"
                                        placeholder="Name of Testator">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="unregWillCodicilDateOfWillCodicil">Date of WILL/CODICIL</label>
                                    <input type="date" name="unregWillCodicilDateOfWillCodicil" class="form-control"
                                        id="UnWillRegdate">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-mb-2">
                    <div class="col-lg-1 icons-flex"></div>
                    <div class="col-lg-11 selected-docs-field">
                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group form-box">
                                    <label for="relinquishDeed" class="quesLabel">Relinquishment
                                        Deed</label>
                                    <input type="file" name="relinquishDeed" class="form-control"
                                        accept="application/pdf" id="relinquishDeed"
                                        onchange="handleFileUpload(this.files[0],'Relinquishment Deed','mutation','SUB_MUT')">
                                    <div id="relinquishDeedError" class="text-danger text-left"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="relinquishDeedRegNo">Registration No.</label>
                                    <input type="text" name="relinquishDeedRegNo" class="form-control numericOnly"
                                        id="relinqdeedregno" placeholder="Registration No.">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="relinquishDeedVolume">Volume</label>
                                    <input type="text" min="0" name="relinquishDeedVolume"
                                        class="form-control numericOnly" id="relinqvolume">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="relinquishDeedBookno">Book No.</label>
                                    <input type="text" name="relinquishDeedBookno" class="form-control numericOnly"
                                        id="relinqdeedbookno">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="relinquishDeedPageno">Page No.</label>
                                    <input type="text" name="relinquishDeedPageno" class="form-control numericOnly"
                                        id="relinqdeedpageno">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="relinquishDeedFrom">From</label>
                                    <input type="date" name="relinquishDeedFrom" class="form-control"
                                        id="relinqdeedfrom">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="relinquishDeedTo">To</label>
                                    <input type="date" name="relinquishDeedTo" class="form-control" id="relinqdeedto">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="relinquishDeedRegdate">Regn. Date</label>
                                    <input type="date" name="relinquishDeedRegdate" class="form-control"
                                        id="relinqdeedregdate">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="relinquishDeedRegname">Registration office name</label>
                                    <input type="text" name="relinquishDeedRegname" class="form-control alpha-only"
                                        id="relinqdeedregname">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-mb-2">
                    <div class="col-lg-1 icons-flex"></div>
                    <div class="col-lg-11 selected-docs-field">
                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group form-box">
                                    <label for="giftDeed" class="quesLabel">Gift Deed</label>
                                    <input type="file" name="giftDeed" class="form-control" accept="application/pdf"
                                        id="giftDeed" onchange="handleFileUpload(this.files[0],'Gift Deed','mutation','SUB_MUT')">
                                    <div id="giftDeedError" class="text-danger text-left"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="giftdeedRegno">Registration No.</label>
                                    <input type="text" name="giftdeedRegno" class="form-control numericOnly"
                                        id="giftdeedregno">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="giftdeedVolume">Volume</label>
                                    <input type="text" min="0" name="giftdeedVolume" class="form-control numericOnly"
                                        id="giftvolume">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="giftdeedBookno">Book No.</label>
                                    <input type="text" name="giftdeedBookno" class="form-control numericOnly"
                                        id="giftdeedbookno">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="giftdeedPageno">Page No.</label>
                                    <input type="text" name="giftdeedPageno" class="form-control numericOnly"
                                        id="giftdeedpageno">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="giftdeedFrom">From</label>
                                    <input type="date" name="giftdeedFrom" class="form-control" id="giftdeedfrom">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="giftdeedTo">To</label>
                                    <input type="date" name="giftdeedTo" class="form-control" id="giftdeedto">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="giftdeedRegdate">Regn. Date</label>
                                    <input type="date" name="giftdeedRegdate" class="form-control" id="giftdeedregdate">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="giftdeedRegOfficeName">Registration office name</label>
                                    <input type="text" name="giftdeedRegOfficeName" class="form-control alpha-only"
                                        id="giftdeedregname">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-mb-2">
                    <div class="col-lg-1 icons-flex"></div>
                    <div class="col-lg-11 selected-docs-field">
                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group form-box">
                                    <label for="smc" class="quesLabel">Surviving Member
                                        Certificate(SMC)</label>
                                    <input type="file" name="smc" class="form-control" accept="application/pdf" id="smc"
                                        onchange="handleFileUpload(this.files[0],'Surviving Member Certificate(SMC)','mutation','SUB_MUT')">
                                    <div id="smcError" class="text-danger text-left"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="smcCertificateNo">Certificate No.</label>
                                    <input type="text" name="smcCertificateNo" class="form-control"
                                        id="smccertificateno">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="smcDateOfIssue">Date of Issue</label>
                                    <input type="date" name="smcDateOfIssue" class="form-control" id="smcdateissue">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-mb-2">
                    <div class="col-lg-1 icons-flex"></div>
                    <div class="col-lg-11 selected-docs-field">
                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group form-box">
                                    <label for="sbp" class="quesLabel">Sanction Building
                                        Plan(SBP)</label>
                                    <input type="file" name="sbp" class="form-control" accept="application/pdf" id="sbp"
                                        onchange="handleFileUpload(this.files[0],'Sanction Building Plan(SBP)','mutation','SUB_MUT')">
                                    <div id="sbpError" class="text-danger text-left"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="sbpDateOfIssue">Date of Issue</label>
                                    <input type="date" name="sbpDateOfIssue" class="form-control" id="sbpdateissue">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-mb-2">
                    <div class="col-lg-1 icons-flex"></div>
                    <div class="col-lg-11 selected-docs-field">
                        <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group form-box">
                                    <label for="otherDocument" class="quesLabel">Any other Document</label>
                                    <input type="file" name="otherDocument" class="form-control"
                                        accept="application/pdf" id="otherDocument"
                                        onchange="handleFileUpload(this.files[0],'Any other Document','mutation','SUB_MUT')">
                                    <div id="sbpError" class="text-danger text-left"></div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="otherDocumentRemark">Remarks</label>
                                    <textarea name="otherDocumentRemark" class="form-control" id="remarksotherdoc"
                                        placeholder="Remarks" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12">
                <h6 class="mt-3 mb-0">Terms & Conditions</h6>
                <ul class="consent-agree">
                   
                    <li> Processing fee of Rs.{{ getApplicationCharge(getServiceType('SUB_MUT')) }} /- is non-refundable.
                        </li>
                </ul>
                <div class="form-check form-group">
                    @if(isset($application))
                        <input class="form-check-input" name="agreeConsent" type="checkbox" id="agreeconsent">
                    @else
                        <input class="form-check-input" name="agreeConsent" type="checkbox" id="agreeconsent">
                    @endif

                    <label class="form-check-label" for="agreeconsent">I agree, all the
                        information provided by me is accurate to the best of my knowledge. I
                        take full responsibility for any issues or failures that may arise from
                        its use.</label>

                        <div id="MutAgreeconsentError" class="text-danger text-left"></div>
                </div>
            </div>
        </div>
    </div>
</div>