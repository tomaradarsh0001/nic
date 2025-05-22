<style>
    .mt-center{
        margin-top: 2.5rem;
    }
</style>
<div class="row g-3">
    @if(isset($isApplicant))
    <div class="col-12 col-lg-6">
        <label for="colonyName" class="form-label">Select Property to Continue</label>
        <select class="form-control selectpicker" data-live-search="true" name="property" id="property" aria-label="Property">
            <option value="">Select</option>
            @foreach ($properties as $prop)
            <option value="{{$prop->old_property_id}}">{{ $prop->known_as ?? $prop->block.'/'.$prop->plot.'/'.$prop->oldColony->name}}</option>
            @endforeach
        </select>
        @error('colony_id')
        <span class="errorMsg">{{ $message }}</span>
        @enderror
        <div id="colonyIdError" class="text-danger"></div>
    </div>
    @else
    <div class="col-12 col-lg-3">
        <label for="colonyName" class="form-label">Colony Name (Present)</label>
        <select class="form-control selectpicker" data-live-search="true" name="colony_id" id="colony_id" aria-label="Colony Name (Present)">
            <option value="">Select</option>
            @foreach ($colonies as $colony)
            <option value="{{$colony->id}}">{{ $colony->name }}</option>
            @endforeach
        </select>
        @error('colony_id')
        <span class="errorMsg">{{ $message }}</span>
        @enderror
        <div id="colonyIdError" class="text-danger"></div>
    </div>

    <div class="col-12 col-lg-3">
        <label for="LandType" class="form-label">Block</label>
        <select class="form-control selectpicker" id="block" name="block" aria-label="Default select example">
            <option value="">Select</option>

        </select>
        @error('block')
        <span class="errorMsg">{{ $message }}</span>
        @enderror
        <div id="blockError" class="text-danger"></div>
    </div>
    
    <div class="col-12 col-lg-3">
        <label for="LandType" class="form-label">Plot No./Flat No.</label>
        <select class=" form-control selectpicker" id="plot" name="plot" aria-label="Default select example">
            <option value="">Select</option>
        </select>
        {{-- <small id="known-as"></small> --}}
        @error('plot')
        <span class="errorMsg">{{ $message }}</span>
        @enderror
        <div id="plotError" class="text-danger"></div>
    </div>
    @endif
    <div class="col-12 col-lg-1 text-center">
        <h5 class="mt-center">OR</h5>

    </div>
    <div class="col col-lg-2">
        <label for="oldPropertyId" class="form-label">Search By Property Id</label>
        <input type="text" name="oldPropertyId" id="oldPropertyId" class="form-control" placeholder="Enter property id">
    </div>

    

</div><!---end row-->
<div class="row g-3 mt-2" id="knownAsDiv" style="display: none;">
    <!-- known as -->
    <div class="col-12 col-lg-6">
       <div style="
        background: #ffffff;
        padding: 10px 10px;
        border: 1px solid #ced4da;" class="form-group">
            <label class="form-label">Known as: &nbsp; &nbsp;<span id="known-as"></span></label>
       </div>
    </div>
<!-- //known as -->
</div>

<!-- <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script> -->
<script>
    var selectedColonyId;
    var leaseHoldOnly = <?= isset($leaseHoldOnly) ? 1 : 0 ?>;
    $('#colony_id').change(function() {
        selectedColonyId = $(this).val();
        var targetSelect = $('#block')
        targetSelect.html('<option>Select</option>');
        targetSelect.selectpicker('refresh');
        var reponseUrl = leaseHoldOnly ? "{{url('/rgr/blocks-in-colony')}}" + '/' + selectedColonyId + '/' + 1 : "{{url('/rgr/blocks-in-colony')}}" + '/' + selectedColonyId + '/' + 0;
        if (selectedColonyId != "") {
            $.ajax({ // call for subtypes for selected property types
                url: reponseUrl,
                type: "get",
                success: function(res) {
                    if (leaseHoldOnly && res.length == 0) {
                        showError('No lease hold property found in the selected colony');
                    }
                    $.each(res, function(key, value) {

                        var newOption = $('<option>', {
                            value: value.block_no ?? "null",
                            text: value.block_no ?? 'Not Applicable'
                        });
                        targetSelect.append(newOption);
                    });
                    targetSelect.selectpicker('refresh');
                }
            });
        }
    })
    $('#block').change(function() {
        var selectedBlock = $(this).val();
        var targetSelect = $('#plot')
        targetSelect.html('<option value="">Select</option>')
        if (selectedColonyId != "") {
            var reponseUrl = leaseHoldOnly ? "{{url('/rgr/properties-in-block')}}" + '/' + selectedColonyId + '/' + selectedBlock + '/' + 1 : "{{url('/rgr/properties-in-block')}}" + '/' + selectedColonyId + '/' + selectedBlock;
            $.ajax({
                url: reponseUrl,
                type: "get",
                success: function(res) {

                    $.each(res, function(key, value) {
                        var newOption = $('<option>', {
                            value: (value.is_joint_property !== undefined) ? value.old_propert_id : value.property_master_id + '_' + value.id, // if not splited then old property id else parentPropertyId_splitedPropertyId
                            text: value.plot_or_property_no ?? value.plot_flat_no,
                            'data-known-as':value.presently_known_as
                        });
                        targetSelect.append(newOption);
                    });
                    targetSelect.selectpicker('refresh');

                }
            });
        }
    });
    $('#plot').change(function(){
        var knownAs = $(this).find(':selected').attr('data-known-as');
        $('#known-as').html(knownAs);
        $('#knownAsDiv').show();
    });
    $('#colony_id, #block').change(function(){
        $('#knownAsDiv').hide();
    })
</script>