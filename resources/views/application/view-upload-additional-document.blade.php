@if (count($additionalDocuments) > 0)
<h5 class="mb-1">VIEW UPLOADED ADDITIONAL DOCUMENTS</h5>
<div class="mt-3">
    <div class="container-fluid">
        <div class="row g-2">
            <div class="col-lg-12">
                <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                    @foreach ($additionalDocuments as $key => $value)
                        {{-- <pre>{{ print_r($value, true) }}</pre> --}}
                        @if ($value->document_type == 'AdditionalDocument')
                            <div class="row row-mb-2">
                                <div class="col-lg-1 icons-flex"></div>
                                <div class="col-lg-11 selected-docs-field">
                                    <div class="files-sorting-abs"><i class='bx bxs-file'></i></div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group form-box view-f">
                                                <label for="{{ $value->id }}"
                                                    class="quesLabel">{{ $value->title }}</label>
                                                <a href="{{ !is_null($value->file_path) ? asset('storage/' . $value->file_path) : '' }}"
                                                    target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                                    aria-label="View Uploaded Files">
                                                    <i class="bx bxs-file-pdf"></i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
