 <!-- For Add additional documents by CDV START ******************************************************************-->
 <div class="pb-5">
            <form method="POST" id="uploadAdditionalDocumentForm" action="{{route('saveOfficialDocs')}}" enctype="multipart/form-data">
                <div class="py-3 px-4 proof-reading-content">
                    @csrf
                    <input type="hidden" name="applicationId" value="{{$details->id}}" >
                    <input type="hidden" name="encryptedModel" value="{{$encryptedModel}}" >
                    <h5 class="mb-1">ADDITIONAL DOCUMENTS</h5>
                    <p class="mb-4">Upload the additional documents</p>
                    <div class="row row-mb-2">
                        <div class="col-lg-1 icons-flex"></div>
                        <div class="col-lg-11 selected-docs-field">
                            <div class="files-sorting-abs"><i class="bx bxs-file"></i></div>
                            <div class="position-relative doc-items">
                                <!-- Add More Button -->
                                <div class="position-sticky text-end mt-2"
                                    style="top: 70px; margin-right: 10px; margin-bottom: 10px; z-index: 9;">
                                    <button type="button" id="add-more-btn" class="btn btn-primary repeater-add-btn" data-toggle="tooltip"
                                        data-placement="bottom" title="Click to add one more document below"><i
                                            class="bx bx-plus me-0"></i></button>
                                </div>
                                <!-- File Input Container -->
                                <div id="file-inputs-container">
                                    <div class="items file-input-group" data-index="0">
                                        <div class="item-content mb-2">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group form-box">
                                                        <label for="documentTitle" class="quesLabel">Document Title</label>
                                                        <input type="text" name="additional_document_titles[]" class="form-control"
                                                            placeholder="Enter document title">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="uploadDocument" class="quesLabel">Upload Document</label>
                                                        <input type="file" name="additional_documents[]" class="form-control"
                                                            accept="application/pdf">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <!-- Updated Remove Button -->
                                                    <div class="repeater-remove-btn remove-add-doc" style="margin-bottom: 0px; margin-top: 18px;">
                                                        <button type="button" class="btn-invisible remove-btn px-4" data-toggle="tooltip"
                                                            data-placement="bottom" disabled aria-label="Click on to delete this form">
                                                            <i class="fadeIn animated bx bx-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" id="" class="btn btn-primary mt-3" style="float: right; margin-right: 25px;">Save</button>
            </form>
        </div>
        <!-- For Add additional documents by CDV END ******************************************************************-->