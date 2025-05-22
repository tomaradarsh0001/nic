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
                            @if($roles != 'applicant')
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($documents))
                        @foreach ($documents as $key => $docs)
                        @if(count($docs) > 0)
                        <tr>
                            <td colspan="5" class="address_data">{{ucfirst($key)}} Documents</td>
                        </tr>
                        @foreach($docs as $i => $doc)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $doc['title'] }}</td>
                            <td style="text-align:center;">
                                @if($doc['file_path'] )
                                <a href="{{ asset('storage/' . ($doc['file_path'] )) }}"
                                    target="_blank" class="text-danger view_docs"
                                    data-toggle="tooltip" title="View Uploaded Files">
                                    <i class="bx bxs-file-pdf"></i>
                                </a>
                                @endif
                            </td>
                            @if($roles != 'applicant')
                            <td>
                                @if($doc['file_path'] )
                                <div class="form-check form-check-success">
                                    <input class="form-check-input property-document-approval-chk"
                                        type="checkbox" role="switch"
                                        @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                    @if ($roles === 'deputy-lndo') disabled @endif>
                                    <label class="form-check-label">Checked</label>
                                </div>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        @endif
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>  --}}

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
                            @if (!empty($documents))
                            @foreach ($documents as $key => $docs)
                            @if(count($docs) > 0)
                            <tr>
                                <td colspan="3" class="document-type-row">
                                    <h4 class="doc-type-title">{{ucfirst($key)}} Documents</h4>
                                </td>
                            </tr>
                            @foreach($docs as $i => $doc)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <span class="doc-name">
                                    {{ $doc['title'] }} 
                                    @if($doc['file_path'] )
                                        <a href="{{ asset('storage/' . $doc['file_path'] ?? '') }}"
                                            target="_blank" class="text-danger view_docs" title="View Uploaded Files">
                                            <i class="bx bxs-file-pdf"></i>
                                        </a>
                                    @endif
                                    </span>
                                </td>
                                @if($roles != 'applicant')
                                    <td>
                                        @if($doc['file_path'] )
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input required-for-approve property-document-approval-chk"
                                                    type="checkbox" role="switch"
                                                    @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                    @if ($roles != 'section-officer') disabled @endif>
                                                <label class="form-check-label" for="checkedAction">Checked</label>
                                            </div>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                            @endif
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 