@extends('layouts.app')

@section('title', 'Edit Property Details')

@section('content')

<link href="{{asset('assets/plugins/bs-stepper/css/bs-stepper.css')}}" rel="stylesheet" />


<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">MIS</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">MIS</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>
<!--end breadcrumb-->



<!--start stepper three-->
<!-- <h6 class="text-uppercase">MIS</h6> -->
<hr>
<div class="card">
    <div class="card-body">
        <div id="stepper3" class="bs-stepper gap-4 vertical">
            <div class="bs-stepper-header" role="tablist">
                <div class="step" data-target="#test-vl-1">
                    <div class="step-trigger" role="tab" id="stepper3trigger1" aria-controls="test-vl-1">
                        <div class="bs-stepper-circle">1</div>
                        <div class="bs-stepper-circle-content">
                            <!-- <h5 class="mb-0 steper-title">Basic Details</h5> -->
                            <!-- <p class="mb-0 steper-sub-title">Enter Your Details</p> -->
                        </div>
                    </div>
                </div>

                <div class="step" data-target="#test-vl-2">
                    <div class="step-trigger" role="tab" id="stepper3trigger2" aria-controls="test-vl-2">
                        <div class="bs-stepper-circle">2</div>
                        <div class="bs-stepper-circle-content">
                            <!-- <h5 class="mb-0 steper-title">Lease Details</h5> -->
                            <!-- <p class="mb-0 steper-sub-title">Enter Lease Details</p> -->
                        </div>
                    </div>
                </div>

                <div class="step" data-target="#test-vl-3">
                    <div class="step-trigger" role="tab" id="stepper3trigger3" aria-controls="test-vl-3">
                        <div class="bs-stepper-circle">3</div>
                        <div class="bs-stepper-circle-content">
                            <!-- <h5 class="mb-0 steper-title">Land Transfer <br> Details</h5> -->
                            <!-- <p class="mb-0 steper-sub-title">Enter Land Transfer Details</p> -->
                        </div>
                    </div>
                </div>


                <div class="step" data-target="#test-vl-4">
                    <div class="step-trigger" role="tab" id="stepper3trigger4" aria-controls="test-vl-4">
                        <div class="bs-stepper-circle">4</div>
                        <div class="bs-stepper-circle-content">
                            <!-- <h5 class="mb-0 steper-title">Property Status <br> Details</h5> -->
                            <!-- <p class="mb-0 steper-sub-title">Enter Property Status Details</p> -->
                        </div>
                    </div>
                </div>

                <div class="step" data-target="#test-vl-5">
                    <div class="step-trigger" role="tab" id="stepper3trigger5" aria-controls="test-vl-5">
                        <div class="bs-stepper-circle">5</div>
                        <div class="bs-stepper-circle-content">
                            <!-- <h5 class="mb-0 steper-title">Inspection & <br>Demand Details</h5> -->
                            <!-- <p class="mb-0 steper-sub-title">Enter Inspection & Demand Details</p> -->
                        </div>
                    </div>
                </div>

                <div class="step" data-target="#test-vl-6">
                    <div class="step-trigger" role="tab" id="stepper3trigger6" aria-controls="test-vl-6">
                        <div class="bs-stepper-circle">6</div>
                        <div class="bs-stepper-circle-content">
                            <!-- <h5 class="mb-0 steper-title">Miscellaneous <br>Details</h5> -->
                            <!-- <p class="mb-0 steper-sub-title">Enter Miscellaneous Details</p> -->
                        </div>
                    </div>
                </div>

                <div class="step" data-target="#test-vl-7">
                    <div class="step-trigger" role="tab" id="stepper3trigger7" aria-controls="test-vl-7">
                        <div class="bs-stepper-circle">7</div>
                        <div class="bs-stepper-circle-content">
                            <!-- <h5 class="mb-0 steper-title">Latest Contact Details</h5> -->
                            <!-- <p class="mb-0 steper-sub-title">Enter Latest Contact Details</p> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="bs-stepper-content">
                <form method="POST" action="{{route('mis.update.child', $childDetails->id)}}">
                    @csrf
                    @method('PUT')
                    <div id="test-vl-1" role="tabpane3" class="bs-stepper-pane content fade"
                        aria-labelledby="stepper3trigger1">
                        <h5 class="mb-1">BASIC DETAILS</h5>
                        <p class="mb-4">Enter your basic information</p>

                        <div class="row g-3">
                            <div class="row align-items-end">

                                <div class="col-12 col-lg-4">
                                    <label for="PropertyID" class="form-label">Property ID</label>
                                    <input type="text" disabled name="property_id" class="form-control"
                                        style="background-color:#ffaa072b;border:1px solid #ffaa07" id="PropertyID"
                                        placeholder="Property ID"
                                        value="{{ isset($childDetails->old_property_id) ? $childDetails->old_property_id : ''}}">
                                </div>

                                @error('property_id')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="propertIdError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <div class="d-flex align-items-center">
                                    <h6 class="mr-2 mb-0">Are there more than 1 Property IDs apparently
                                        visible:</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled name="is_multiple_prop_id"
                                            type="checkbox" {{$propertyDetail->is_multiple_ids == 1 ? 'checked' : ''}}
                                            value="1" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <h6 class="mb-0">Yes</h6>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="FileNumber" class="form-label">File Number</label>
                                <input type="text" class="form-control" disabled name="file_number" id="FileNumber"
                                    placeholder="File Number" value="{{ $propertyDetail->file_no }}">
                                @error('file_number')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="FileNumberError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="fileNumberGenerated" class="form-label">Computer generated
                                    file no</label>
                                <input type="text" class="form-control" value="{{ $propertyDetail->unique_file_no }}"
                                    id="fileNumberGenerated" placeholder="Generated File No." disabled>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="colonyName" class="form-label">Colony Name (Present)</label>
                                <select class="form-select" disabled name="present_colony_name" id="colonyName"
                                    aria-label="Colony Name (Present)">
                                    <option value="">Select</option>
                                    @foreach ($colonyList as $colony)
                                                                    <option value="{{$colony->id}}" {{$propertyDetail->new_colony_name == $colony->id ?
                                        'selected' : ''}}>{{ $colony->name }}</option>
                                    @endforeach
                                </select>
                                @error('present_colony_name')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="PresentColonyNameError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="ColonyNameOld" class="form-label">Colony Name (Old)</label>
                                <select class="form-select" disabled name="old_colony_name" id="ColonyNameOld"
                                    aria-label="Default select example">
                                    <option value="">Select</option>
                                    @foreach ($colonyList as $colony)
                                                                    <option value="{{$colony->id}}" {{$propertyDetail->old_colony_name == $colony->id ?
                                        'selected' : ''}}>{{ $colony->name }}</option>
                                    @endforeach
                                </select>
                                @error('old_colony_name')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="OldColonyNameError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="PropertyStatus" class="form-label">Property Status</label>
                                <select class="form-select" id="PropertyStatus" name="property_status"
                                    aria-label="Default select example">
                                    <option value="">Select</option>
                                    <option value="951" {{$childDetails->property_status == '951' ? 'selected' : ''}}>
                                        Lease Hold</option>
                                    <option value="952" {{$childDetails->property_status == '952' ? 'selected' : ''}}>Free
                                        Hold</option>
                                </select>
                                @error('property_status')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="PropertyStatusError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="LandType" class="form-label">Land Type</label>
                                <select class="form-select" disabled id="LandType" name="land_type"
                                    aria-label="Default select example">
                                    <option value="">Select</option>
                                    @foreach ($landTypes[0]->items as $landType)
                                        <option value="{{$landType->id}}" {{$propertyDetail->land_type == $landType->id ? 'selected' : ''}}>{{ $landType->item_name }}</option>
                                    @endforeach
                                </select>
                                @error('land_type')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="LandTypeError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="plotNo" class="form-label">Plot no</label>
                                <input type="text" name="plot_no" class="form-control" id="plotNo"
                                    placeholder="Plot Number" value="{{ $childDetails->plot_flat_no }}">
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="plotNo" class="form-label">Area</label>
                                <div class="unit-field">
                                    <input type="text" class="form-control unit-input numericDecimal" id="area"
                                        name="area" placeholder="Enter Area" data-name="area"
                                        value="{{$childDetails->original_area}}">
                                    <select class="form-select unit-dropdown" id="jointproperty_0_jointpropertyunit"
                                        aria-label="Select Unit" name="unit" value="">
                                        <option value="" selected="">Select Unit</option>
                                        @foreach ($areaUnit[0]->items as $unit)
                                            <option value="{{$unit->id}}" {{$childDetails->unit == $unit->id ? 'selected' : ''}}>{{ $unit->item_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="presently_known_as" class="form-label">Presently Known as</label>
                                <input type="text" name="presently_known_as" class="form-control"
                                    id="presently_known_as" placeholder="Presently known as"
                                    value="{{ $childDetails->presently_known_as }}">
                            </div>
                            <div class="col-12 col-lg-4">

                                <button type="button" class="btn btn-primary px-4" id="submitButton1">Next<i
                                        class='bx bx-right-arrow-alt ms-2'></i></button>
                            </div>
                        </div><!---end row-->

                    </div>

                    <div id="test-vl-2" role="tabpane3" class="bs-stepper-pane content fade"
                        aria-labelledby="stepper3trigger2">

                        <h5 class="mb-1">LEASE DETAILS</h5>
                        <p class="mb-4">Enter Your Lease Details</p>

                        <div class="row g-3">
                            <div class="col-12 col-lg-4">
                                <label for="TypeLease" class="form-label">Type of Lease</label>
                                <select class="form-select" disabled name="lease_type" id="TypeLease"
                                    aria-label="Type of Lease">
                                    <option value="">Select</option>
                                    @foreach ($leaseTypes[0]->items as $leaseType)
                                        <option value="{{$leaseType->id}}"
                                            {{$propertyLeaseDetail->type_of_lease == $leaseType->id ? 'selected' : ''}}>
                                            {{ $leaseType->item_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lease_type')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="TypeLeaseError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="dateexecution" class="form-label">Date of Execution</label>
                                <input type="date" class="form-control" pattern="\d{2} \d{2} \d{4}"
                                    value="{{ $propertyLeaseDetail->doe }}" disabled>
                                @error('date_of_execution')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="dateexecutionError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="LeaseAllotmentNo" class="form-label">Lease/Allotment
                                    No.</label>
                                <input type="text" name="lease_no" class="form-control" id="LeaseAllotmentNo"
                                    placeholder="Lease/Allotment No." value="{{ $propertyDetail->lease_no }}" disabled>
                                @error('lease_no')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="LeaseAllotmentNoError" class="text-danger"></div>
                            </div>

                            <div class="col-12 col-lg-4">
                                <label for="dateOfExpiration" class="form-label">Date of Expiration</label>
                                <input type="date" class="form-control" name="date_of_expiration" id="dateOfExpiration"
                                    value="{{ $propertyLeaseDetail->date_of_expiration }}" disabled>
                                @error('date_of_expiration')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="dateOfExpirationError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="dateallotment" class="form-label">Date of Allotment</label>
                                <input type="date" name="date_of_allotment" class="form-control" id="dateallotment"
                                    value="{{ $propertyLeaseDetail->doa }}" disabled>
                                @error('date_of_allotment')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="dateallotmentError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="blockno" class="form-label">Block No. (Only alphanumeric allowed)</label>
                                <input type="text" name="block_no" class="form-control" id="blockno" maxlength="4"
                                    placeholder="Block No." value="{{ $propertyDetail->block_no }}" disabled>
                                @error('block_no')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <!-- <div id="blocknoError" class="text-danger"></div> -->
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="plotno" class="form-label">Plot No. (Only alphanumeric allowed)</label>
                                <input type="text" name="plot_no" class="form-control" id="plotno"
                                    placeholder="Plot No." value="{{ $propertyDetail->plot_or_property_no }}" disabled>
                                @error('plot_no')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="plotnoError" class="text-danger"></div>
                            </div>

                            <div class="col-12 col-lg-12">
                                <!-- Repeater Content -->
                                <div>
                                    <div class="col-12 col-lg-12">
                                        <label for="plotno" class="form-label">In favour of</label>
                                        <!-- <button class="btn btn-primary repeater-add-btn px-4"><i class="fadeIn animated bx bx-plus"></i></button> -->
                                    </div>
                                    <!-- Repeater Items -->
                                    <div class="duplicate-field-tab">
                                        @foreach($original as $originalData)
                                            <div class="items">
                                                <!-- Repeater Content -->
                                                <div class="item-content">
                                                    <div class="mb-3">
                                                        <label for="favourName1" class="form-label">Name</label>
                                                        <input type="text" class="form-control"
                                                            name="original[{{$originalData->id}}]" placeholder="Name"
                                                            data-name="name" value="{{$originalData->lessee_name}}"
                                                            disabled>
                                                        <div id="favourName1Error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <!-- Repeater Remove Btn -->
                                                <!-- <div class="repeater-remove-btn">
                                                                                        <button class="btn btn-danger remove-btn px-4" data-toggle="tooltip"
                                                                                            data-placement="bottom" title="Click on to delete this form">
                                                                                            <i class="fadeIn animated bx bx-trash"></i>
                                                                                        </button>
                                                                                    </div> -->
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="presentlyknownsas" class="form-label">Presently Known
                                    As</label>
                                <input type="text" class="form-control" id="presentlyknownsas" name="presently_known"
                                    value="{{$propertyLeaseDetail->presently_known_as}}" disabled>
                                @error('presently_known')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="areaunitname" class="form-label">Area</label>
                                <div class="unit-field">
                                    <input type="text" class="form-control unit-input" id="areaunitname" name="area"
                                        value="{{$propertyLeaseDetail->plot_area}}" disabled>
                                    <select class="form-select unit-dropdown" id="selectareaunit"
                                        aria-label="Select Unit" name="area_unit" disabled>
                                        <option value="" selected>Select Unit</option>
                                        @foreach ($areaUnit[0]->items as $unit)
                                                                            <option value="{{$unit->id}}" {{$propertyLeaseDetail->unit == $unit->id ?
                                            'selected' : ''}}>{{ $unit->item_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('area')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                @error('area_unit')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="selectareaunitError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="premiumunit1" class="form-label">Premium (Re/ Rs)</label>
                                <div class="unit-field">
                                    <input type="text" class="form-control mr-2" id="premiumunit1" name="premium1"
                                        value="{{$propertyLeaseDetail->premium}}" disabled>
                                    <input type="text" class="form-control unit-input" id="premiumunit2" name="premium2"
                                        value="{{$propertyLeaseDetail->premium_in_paisa != null ? $propertyLeaseDetail->premium_in_paisa : $propertyLeaseDetail->premium_in_aana}}"
                                        disabled>
                                    <select class="form-select unit-dropdown" name="premium_unit" id="selectpremiumunit"
                                        aria-label="Select Unit" disabled>
                                        <option value="">Unit</option>
                                        <option value="1" {{$propertyLeaseDetail->premium_in_paisa != null ? 'selected'
    : ''}}>Paise</option>
                                        <option value="2" {{$propertyLeaseDetail->premium_in_aana != null ? 'selected' :
    ''}}>Ana</option>
                                    </select>
                                </div>
                                @error('premium1')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                @error('premium2')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                @error('premium_unit')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="premiumunit2Error" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="groundRent1" class="form-label">Ground Rent (Re/ Rs)</label>
                                <div class="unit-field">
                                    <input type="text" class="form-control mr-2" id="groundRent1" name="ground_rent1"
                                        value="{{$propertyLeaseDetail->gr_in_re_rs}}" disabled>
                                    <input type="text" class="form-control unit-input" id="groundRent2"
                                        name="ground_rent2"
                                        value="{{$propertyLeaseDetail->gr_in_paisa != null ? $propertyLeaseDetail->gr_in_paisa : $propertyLeaseDetail->gr_in_aana}}"
                                        disabled>
                                    <select class="form-select unit-dropdown" disabled id="selectGroundRentUnit"
                                        aria-label="Select Unit" name="ground_rent_unit">
                                        <option value="">Unit</option>
                                        <option value="1" {{$propertyLeaseDetail->gr_in_paisa != null ? 'selected' :
    ''}}>Paise</option>
                                        <option value="2" {{$propertyLeaseDetail->gr_in_aana != null ? 'selected' :
    ''}}>
                                            Ana</option>
                                    </select>
                                </div>
                                <div id="groundRent2Error" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <label for="startdateGR" class="form-label">Start Date of Ground
                                    Rent</label>
                                <input type="date" class="form-control" id="startdateGR" name="start_date_of_gr"
                                    value="{{$propertyLeaseDetail->start_date_of_gr}}" disabled>
                                <div id="startdateGRError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-2">
                                <label for="RGRduration" class="form-label">RGR Duration (Yrs)</label>
                                <input type="text" class="form-control" id="RGRduration" name="rgr_duration"
                                    maxlength="2" value="{{$propertyLeaseDetail->rgr_duration}}" disabled>
                                <div id="RGRdurationError" class="text-danger"></div>
                            </div>
                            @php
                                $endDate = date('Y-m-d', strtotime("+$propertyLeaseDetail->rgr_duration years", strtotime($propertyLeaseDetail->start_date_of_gr)));
                            @endphp
                            <div class="col-12 col-lg-3">
                                <label for="frevisiondateGR" class="form-label">First Revision of GR due
                                    on</label>
                                <input type="date" class="form-control" id="frevisiondateGR"
                                    name="first_revision_of_gr_due" value="{{$endDate}}" disabled>
                                <div id="frevisiondateGRError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="oldPropertyType" class="form-label">Purpose for which leased/
                                    allotted (As per lease)</label>
                                <select class="form-select" disabled id="oldPropertyType" aria-label="Type of Lease"
                                    name="purpose_property_type">
                                    <option value="" selected>Select</option>
                                    @foreach ($propertyTypes[0]->items as $propertyType)
                                                                    <option value="{{$propertyType->id}}" {{$propertyLeaseDetail->
                                        property_type_as_per_lease == $propertyType->id ? 'selected' : ''}}>{{
                                        $propertyType->item_name }}</option>
                                    @endforeach
                                </select>
                                <div id="oldPropertyTypeError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="oldPropertySubType" class="form-label">Sub-Type (Purpose , at
                                    present)</label>
                                <select class="form-select" disabled id="oldPropertySubType" aria-label="Type of Lease"
                                    name="purpose_property_sub_type">
                                    @foreach($subTypes as $subType)
                                                                    <option value="{{$subType->id}}" {{$propertyLeaseDetail->
                                        property_sub_type_as_per_lease == $subType->id ? 'selected' :
                                        ''}}>
                                                                        {{$subType->item_name}}
                                                                    </option>
                                    @endforeach
                                </select>
                                <div id="oldPropertySubTypeError" class="text-danger"></div>
                            </div>

                            @if($propertyLeaseDetail->is_land_use_changed == 1)
                                            <div class="col-12 col-lg-12">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">Land Use Change</h6>
                                                    <div class="form-check">
                                                        <input class="form-check-input" disabled type="checkbox" value="1"
                                                            id="landusechange" name="land_use_changed"
                                                            {{$propertyLeaseDetail->is_land_use_changed == 1 ? 'checked' : ''}}>
                                                        <label class="form-check-label" for="landusechange">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12" id="hideFields" style="display: none;">
                                                @if($propertyLeaseDetail->is_land_use_changed == 1)
                                                                    <div class="row">
                                                                        <div class="col-12 col-lg-6">
                                                                            <label for="PropertyType" class="form-label">Purpose for which
                                                                                leased/ allotted (At present)</label>
                                                                            <select disabled class="form-select" id="propertyType"
                                                                                aria-label="Type of Lease" name="purpose_lease_type_alloted_present">
                                                                                <option value="" selected>Select</option>
                                                                                @foreach ($propertyTypes[0]->items as $propertyType)
                                                                                                                <option value="{{$propertyType->id}}" {{$propertyLeaseDetail->
                                                                                    property_type_at_present == $propertyType->id ? 'selected' : ''}}>{{
                                                                                    $propertyType->item_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div id="propertyTypeError" class="text-danger"></div>
                                                                        </div>
                                                                        <div class="col-12 col-lg-6">
                                                                            <label for="propertySubType" class="form-label">Sub-Type (Purpose , at
                                                                                present)</label>
                                                                            <select disabled class="form-select" id="propertySubType"
                                                                                aria-label="Type of Lease" name="purpose_lease_sub_type_alloted_present">
                                                                                @foreach($subTypesNew as $subType)
                                                                                                                <option value="{{$subType->id}}" {{$propertyLeaseDetail->
                                                                                    property_sub_type_at_present == $subType->id ? 'selected' :
                                                                                    ''}}>
                                                                                                                    {{$subType->item_name}}
                                                                                                                </option>
                                                                                @endforeach
                                                                            </select>

                                                                            <div id="propertySubTypeError" class="text-danger"></div>
                                                                        </div>
                                                                    </div>
                                                @endif
                                            </div>
                            @else
                                <div class="col-12 col-lg-12">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2 mb-0">Land Use Change</h6>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox" value="1"
                                                id="landusechange" name="land_use_changed">
                                            <label class="form-check-label" for="landusechange">
                                                <h6 class="mb-0">Yes</h6>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12" id="hideFields" style="display: none;">
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <label for="PropertyType" class="form-label">Purpose for which
                                                leased/ allotted (At present)</label>
                                            <select disabled class="form-select" id="propertyType"
                                                aria-label="Type of Lease" name="purpose_lease_type_alloted_present">
                                                <option value="" selected>Select</option>
                                                @foreach ($propertyTypes[0]->items as $propertyType)
                                                    <option value="{{ $propertyType->id }}">
                                                        {{ $propertyType->item_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div id="propertyTypeError" class="text-danger"></div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label for="propertySubType" class="form-label">Sub-Type (Purpose , at
                                                present)</label>
                                            <select disabled class="form-select" id="propertySubType"
                                                aria-label="Type of Lease" name="purpose_lease_sub_type_alloted_present">
                                                <option value="" selected>Select</option>
                                            </select>
                                            <div id="propertySubTypeError" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="d-flex align-items-center gap-3">
                                    <!-- <button class="btn btn-outline-secondary px-4" onclick="stepper3.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button> -->
                                    <button type="button" class="btn btn-outline-secondary px-4"
                                        onclick="stepper3.previous()"><i
                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>



                                    <button type="button" class="btn btn-primary px-4" id="submitButton2">Next<i
                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                </div>
                            </div>
                        </div><!---end row-->

                    </div>

                    <div id="test-vl-3" role="tabpane3" class="bs-stepper-pane content fade"
                        aria-labelledby="stepper3trigger3">
                        <h5 class="mb-1">LAND TRANSFER DETAILS</h5>
                        <p class="mb-4">Enter Land Transfer Details</p>

                        <div class="row g-3">
                            <div class="col-12 col-lg-12 mb-3">
                                <div class="d-flex align-items-center">
                                    <h6 class="mr-2 mb-0">Transferred</h6>
                                    <div class="form-check mr-2">
                                        <input class="form-check-input" type="checkbox" name="transferred" value="1"
                                            id="transferredFormYes" {{count($filteredTransferDetails) > 0 ? 'checked' :
    ''}}>
                                        <label class="form-check-label" for="transferredFormYes">
                                            <h6 class="mb-0">Yes</h6>
                                        </label>
                                    </div>
                                    <!-- <div class="form-check">
                                                <input class="form-check-input" type="radio" name="transferred" value="0" id="transferredFormNo">
                                                <label class="form-check-label" for="transferredFormNo">
                                                    <h6 class="mb-0">No</h6>
                                                </label>
                                            </div> -->
                                </div>
                                @error('transferred')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>

                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="transferred-container">
                                    <div class="row">
                                        <div class="col-12 col-lg-12">
                                            <div>

                                                @php
                                                    $count = 1;
                                                @endphp
                                                @foreach ($filteredTransferDetails as $date => $TransferDate)
                                                                                            @foreach($TransferDate as $process => $details)
                                                                                                                                        <div class="parent-container">
                                                                                                                                            <div class="row mb-3">
                                                                                                                                                <div class="col-12 col-lg-4 my-4">
                                                                                                                                                    <label for="ProcessTransfer" class="form-label">Process of
                                                                                                                                                        transfer</label>
                                                                                                                                                    <select name="pre_land_transfer_type[]"
                                                                                                                                                        class="form-select processtransfer form-required"
                                                                                                                                                        data-name="processtransfer" id="ProcessTransfer"
                                                                                                                                                        aria-label="Type of Lease">
                                                                                                                                                        <option value="">Select</option>
                                                                                                                                                        <option value="Substitution" {{$process == 'Substitution'
                                                                                                    ? 'selected' : '' }}>Substitution</option>
                                                                                                                                                        <option value="Mutation" {{$process == 'Mutation' ? 'selected'
                                                                                                    : '' }}>Mutation</option>
                                                                                                                                                        <option value="Substitution cum Mutation"
                                                                                                                                                            {{$process == 'Substitution cum Mutation' ? 'selected'
                                                                                                    : '' }}>Substitution cum Mutation</option>
                                                                                                                                                        <option value="Mutation cum Substitution"
                                                                                                                                                            {{$process == 'Mutation cum Substitution' ? 'selected'
                                                                                                    : '' }}>Mutation cum Substitution</option>
                                                                                                                                                        <option value="Successor in interest"
                                                                                                                                                            {{$process == 'Successor in interest' ? 'selected' : ''
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            }}>Successor in
                                                                                                                                                            interest</option>
                                                                                                                                                        <option value="Others" {{$process == 'Others' ? 'selected'
                                                                                                    : '' }}>Others</option>
                                                                                                                                                    </select>
                                                                                                                                                    <div id="ProcessTransferError" class="text-danger"></div>
                                                                                                                                                </div>
                                                                                                                                                <div class="col-12 col-lg-4 my-4">
                                                                                                                                                    <label for="transferredDate" class="form-label">Date</label>
                                                                                                                                                    <input type="date" name="pre_transferDate[]"
                                                                                                                                                        class="form-control form-required" value="{{$date}}"
                                                                                                                                                        id="transferredDate">
                                                                                                                                                    <div id="transferredDateError" class="text-danger"></div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            @foreach($details as $key => $detail)
                                                                                                                                                <div class="child-item">
                                                                                                                                                    <div class="duplicate-field-tab">
                                                                                                                                                        <div class="items1" data-group="test">
                                                                                                                                                            <div class="item-content row">
                                                                                                                                                                <input type="hidden" value="{{$detail->id}}"
                                                                                                                                                                    name="pre_id{{$count}}[]" />
                                                                                                                                                                <div class="col-lg-4 mb-3">
                                                                                                                                                                    <label for="name"
                                                                                                                                                                        class="form-label">Name</label>
                                                                                                                                                                    <input type="text" name="pre_name{{$count}}[]"
                                                                                                                                                                        class="form-control form-required" id="name"
                                                                                                                                                                        placeholder="Name"
                                                                                                                                                                        value="{{$detail->lessee_name}}"
                                                                                                                                                                        data-name="name">
                                                                                                                                                                    <div id="nameError" class="text-danger"></div>
                                                                                                                                                                </div>
                                                                                                                                                                <div class="col-lg-4 mb-3">
                                                                                                                                                                    <label for="age" class="form-label">Age</label>
                                                                                                                                                                    <input type="number" name="pre_age{{$count}}[]"
                                                                                                                                                                        class="form-control" id="age"
                                                                                                                                                                        placeholder="Age" min="0"
                                                                                                                                                                        value="{{$detail->lessee_age}}"
                                                                                                                                                                        data-name="age">
                                                                                                                                                                    <div id="ageError" class="text-danger"></div>
                                                                                                                                                                </div>
                                                                                                                                                                <div class="col-lg-4 mb-3">
                                                                                                                                                                    <label for="share"
                                                                                                                                                                        class="form-label">Share</label>
                                                                                                                                                                    <input type="text"
                                                                                                                                                                        class="form-control form-required"
                                                                                                                                                                        id="share" name="pre_share{{$count}}[]"
                                                                                                                                                                        placeholder="Share"
                                                                                                                                                                        value="{{$detail->property_share}}"
                                                                                                                                                                        data-name="share">
                                                                                                                                                                    <div id="shareError" class="text-danger"></div>
                                                                                                                                                                </div>
                                                                                                                                                                <div class="col-lg-4 mb-3">
                                                                                                                                                                    <label for="pannumber" class="form-label">PAN
                                                                                                                                                                        Number</label>
                                                                                                                                                                    <input type="text"
                                                                                                                                                                        class="form-control text-uppercase"
                                                                                                                                                                        id="pannumber"
                                                                                                                                                                        name="pre_panNumber{{$count}}[]"
                                                                                                                                                                        placeholder="PAN Number"
                                                                                                                                                                        value="{{$detail->lessee_pan_no}}"
                                                                                                                                                                        data-name="pannumber">
                                                                                                                                                                    <div id="pannumberError" class="text-danger">
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                                <div class="col-lg-4 mb-3">
                                                                                                                                                                    <label for="aadharnumber"
                                                                                                                                                                        class="form-label">Aadhar
                                                                                                                                                                        Number</label>
                                                                                                                                                                    <input type="text"
                                                                                                                                                                        class="form-control text-uppercase"
                                                                                                                                                                        id="aadharnumber"
                                                                                                                                                                        name="pre_aadharNumber{{$count}}[]"
                                                                                                                                                                        placeholder="Aadhar Number"
                                                                                                                                                                        value="{{$detail->lessee_aadhar_no}}"
                                                                                                                                                                        data-name="aadharnumber" maxlength="12">
                                                                                                                                                                    <div id="aadharnumberError" class="text-danger">
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                            </div>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            @endforeach
                                                                                                                                        </div>

                                                                                                                                        @php
                                                                                                                                            $count = $count + 1;
                                                                                                                                        @endphp
                                                                                            @endforeach
                                                @endforeach

                                                <!-- <button class="add-parent-button btn btn-outline-primary"><i class="fadeIn animated bx bx-plus"></i> Add Transfer</button> -->
                                            </div>
                                            <div id="addTransferBtnError" class="text-danger"></div>
                                        </div>


                                        <div class="col-lg-12" id="addTransferDetailsUpdateSL" style="display:{{count($filteredTransferDetails) > 0 ? 'block' :
    'none'}}">
                                            <div class="transferred-container">
                                                <div class="row">
                                                    <div class="col-12 col-lg-12">
                                                        <div id="container">
                                                            <!-- <button class="add-parent-button btn btn-outline-primary"><i class="fadeIn animated bx bx-plus"></i> Add Transfer</button> -->
                                                            <button type="button"
                                                                class="add-parent-button btn btn-outline-primary"
                                                                id="addTransferBtn"><i
                                                                    class="fadeIn animated bx bx-plus"></i> Add Transfer
                                                                Details</button>
                                                        </div>
                                                        <div id="addTransferBtnError" class="text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>





                                    </div>

                                </div>
                            </div>
                            <!-- Duplicate Form End -->

                            <div class="col-12 mt-4">
                                <div class="d-flex align-items-center gap-3">

                                    <button type="button" class="btn btn-outline-secondary px-4"
                                        onclick="stepper3.previous()"><i class='bx bx-left-arrow-alt me-2'></i>
                                        Previous</button>

                                    <button type="button" class="btn btn-primary px-4" id="submitButton3">Next <i
                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                </div>
                            </div>
                        </div>
                        <!---end row-->

                    </div>

                    <div id="test-vl-4" role="tabpane3" class="bs-stepper-pane content fade"
                        aria-labelledby="stepper3trigger4">
                        <h5 class="mb-1">PROPERTY STATUS DETAILS</h5>
                        <p class="mb-4">Please enter Property Status Details</p>

                        <div class="row g-3">

                            <div id="property_status_free_hold">
                                <div class="col-12 col-lg-12">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2 mb-0">Free Hold (F/H)</h6>
                                        <div class="form-check mr-2">
                                            <input class="form-check-input" type="radio" name="freeHold" value="Yes"
                                                id="freeHoldFormYes" {{$childDetails->property_status == 952 ? 'checked' : ''}}>
                                            <label class="form-check-label" for="freeHoldFormYes">
                                                <h6 class="mb-0">Yes</h6>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="freeHold" value="No"
                                                id="freeHoldFormNo" {{$childDetails->property_status != 952 ? 'checked' : ''}}>
                                            <label class="form-check-label" for="freeHoldFormNo">
                                                <h6 class="mb-0">No</h6>
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="freehold-container" id="freeHoldContainer">
                                        @if($childDetails->property_status == 952)
                                            <div class="col-12 col-lg-4">
                                                <label for="ConveyanceDate" class="form-label">Date of
                                                    Conveyance Deed</label>

                                                @if(!empty($conversion))
                                                    <input type="date"
                                                        value="{{($conversion[0]->transferDate) ? $conversion[0]->transferDate : $propertyLeaseDetail->date_of_conveyance_deed}}"
                                                        class="form-control" name="conveyanc_date" id="ConveyanceDate">
                                                @endif
                                            </div>
                                            <div class="col-12 col-lg-12 mt-4">
                                                <!-- Repeater Content -->
                                                <div>
                                                    <div class="col-12 col-lg-12">
                                                        <label for="plotno" class="form-label">In favour
                                                            of</label>

                                                        <!-- <button class="btn btn-primary repeater-add-btn px-4"><i class="fadeIn animated bx bx-plus"></i></button> -->
                                                    </div>
                                                    <!-- Repeater Items -->
                                                    <div class="duplicate-field-tab">
                                                        @foreach($conversion as $conver)
                                                            <div class="items">
                                                                <!-- Repeater Content -->
                                                                <!-- <div class="item-content">
                                                                                                                                                    <div class="mb-3">
                                                                                                                                                        <label for="inputName1" class="form-label">Name</label>
                                                                                                                                                        <input type="text" name="free_hold_in_favour_name[]" class="form-control" id="inputName1" placeholder="Name" data-name="name">
                                                                                                                                                    </div>
                                                                                                                                                </div> -->
                                                                <div class="item-content row">

                                                                    <div class="mb-3 col-lg-8 col-12">
                                                                        <label for="inputName1" class="form-label">Name</label>
                                                                        <input type="text" name="conversion[{{$conver->id}}]"
                                                                            class="form-control" id="inputName1"
                                                                            placeholder="Name" data-name="name"
                                                                            value="{{$conver->lessee_name}}">
                                                                    </div>
                                                                    <!-- <div class="mb-3 col-lg-4 col-12">
                                                                                                                                                <label for="InputProperty_known_as"
                                                                                                                                                    class="form-label">Property Known as
                                                                                                                                                    (Present)</label>
                                                                                                                                                <input type="text"
                                                                                                                                                    name="free_hold_in_property_known_as_present[]"
                                                                                                                                                    class="form-control" id="InputProperty_known_as"
                                                                                                                                                    placeholder="Property Known as (Present)"
                                                                                                                                                    data-name="pkap">
                                                                                                                                            </div> -->
                                                                    <!-- <div class="mb-3 col-lg-4 col-12">
                                                                                                                                                <label for="inputArea" class="form-label">Area</label>
                                                                                                                                                <input type="text" name="free_hold_in_favour_name[]"
                                                                                                                                                    class="form-control" id="inputArea"
                                                                                                                                                    placeholder="Area" data-name="area">
                                                                                                                                            </div> -->
                                                                </div>

                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="freehold-container" id="freeHoldContainer">
                                        @if($childDetails->property_status != 952)
                                            <div class="col-12 col-lg-4">
                                                <label for="ConveyanceDate" class="form-label">Date of
                                                    Conveyance Deed</label>
                                                <input type="date" class="form-control" name="conveyanc_date"
                                                    id="ConveyanceDate">
                                            </div>
                                        @endif
                                        <div class="col-12 col-lg-12 mt-4">
                                            <!-- Repeater Content -->
                                            <div id="repeater4">
                                                <div class="col-12 col-lg-12">
                                                    <label for="plotno" class="form-label">In favour
                                                        of</label>
                                                    <button type="button"
                                                        class="btn btn-outline-primary repeater-add-btn"
                                                        data-toggle="tooltip" data-placement="bottom"
                                                        title="Click on Add More to add more options below"><i
                                                            class="bx bx-plus me-0"></i></button>
                                                    <!-- <button class="btn btn-primary repeater-add-btn px-4"><i class="fadeIn animated bx bx-plus"></i></button> -->
                                                </div>
                                                <!-- Repeater Items -->
                                                <div class="duplicate-field-tab">
                                                    <div class="items" data-group="stepFour">
                                                        <!-- Repeater Content -->
                                                        <!-- <div class="item-content">
                                                                    <div class="mb-3">
                                                                        <label for="inputName1" class="form-label">Name</label>
                                                                        <input type="text" name="free_hold_in_favour_name[]" class="form-control" id="inputName1" placeholder="Name" data-name="name">
                                                                    </div>
                                                                </div> -->

                                                        <div class="item-content row">
                                                            <div class="mb-3 col-lg-12 col-12">
                                                                <label for="inputName1" class="form-label">Name</label>
                                                                <input type="text" name="free_hold_in_favour_name[]"
                                                                    class="form-control" id="inputName1"
                                                                    placeholder="Name" data-name="name">
                                                            </div>
                                                        </div>
                                                        <!-- Repeater Remove Btn -->
                                                        <div class="repeater-remove-btn">
                                                            <button class="btn btn-danger remove-btn px-4"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Click on delete this form">
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


                            <div id="property_status_vacant">
                                <div class="col-12 col-lg-12">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2 mb-0">Land Type: Vacant</h6>
                                        <div class="form-check mr-2">
                                            <input class="form-check-input" type="radio" name="landType" value="Yes"
                                                id="landTypeFormYes" {{$propertyDetail->status == 1124 ? 'checked' : 'disabled'}}>
                                            <label class="form-check-label" for="landTypeFormYes">
                                                <h6 class="mb-0">Yes</h6>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="landType" value="No"
                                                id="landTypeFormNo" {{$propertyDetail->status != 1124 ? 'checked' : 'disabled'}}>
                                            <label class="form-check-label" for="landTypeFormNo">
                                                <h6 class="mb-0">No</h6>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="landType-container row" id="landTypeContainer">
                                        @if($propertyDetail->status == 1124)
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <label for="ConveyanceDate" class="form-label">In possession
                                                        of</label>
                                                    <select class="form-select" id="TypeLease" name="in_possession_of"
                                                        aria-label="Type of Lease">
                                                        <option value="">Select</option>
                                                        <option value="1"
                                                            {{$propertyLeaseDetail->in_possession_of_if_vacant == 1 ? 'checked' : ''}}>DDA</option>
                                                        <option value="2"
                                                            {{$propertyLeaseDetail->in_possession_of_if_vacant == 2 ? 'checked' : ''}}>NDMC</option>
                                                        <option value="3"
                                                            {{$propertyLeaseDetail->in_possession_of_if_vacant == 3 ? 'checked' : ''}}>MCD</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <label for="dateTransfer" class="form-label">Date of
                                                        Transfer</label>
                                                    <input type="date" class="form-control" name="date_of_transfer"
                                                        id="dateTransfer"
                                                        value="{{$propertyLeaseDetail->date_of_transfer}}">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>


                            <div id="property_status_others">
                                <div class="col-12 col-lg-12">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2 mb-0">Land Type : Others</h6>
                                        <div class="form-check mr-2">
                                            <input class="form-check-input" type="radio" name="landTypeOthers"
                                                value="Yes" id="landTypeFormOthersYes" {{$propertyDetail->status == 1342 ? 'checked' : 'disabled'}}>
                                            <label class="form-check-label" for="landTypeFormOthersYes">
                                                <h6 class="mb-0">Yes</h6>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="landTypeOthers"
                                                value="No" id="landTypeFormOthersNo" {{$propertyDetail->status != 1342 ? 'checked' : 'disabled'}}>
                                            <label class="form-check-label" for="landTypeFormOthersNo">
                                                <h6 class="mb-0">No</h6>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="landType-container row" id="landTypeOthersContainer">
                                        @if($propertyDetail->status == 1342)
                                            <div class="col-12 col-lg-4">
                                                <label for="remarks" class="form-label">Remarks</label>
                                                <input type="text" class="form-control" id="remarks" name="remark"
                                                    value="{{$propertyLeaseDetail->remarks}}">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>




                            <div class="col-12 mt-4">
                                <div class="d-flex align-items-center gap-3">

                                    <button type="button" class="btn btn-outline-secondary px-4"
                                        onclick="stepper3.previous()"><i class='bx bx-left-arrow-alt me-2'></i>
                                        Previous</button>



                                    <button type="button" class="btn btn-primary px-4" onclick="stepper3.next()">Next <i
                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                </div>
                            </div>
                        </div><!---end row-->

                    </div>

                    <div id="test-vl-5" role="tabpane3" class="bs-stepper-pane content fade"
                        aria-labelledby="stepper3trigger5">
                        <h5 class="mb-1">INSPECTION & DEMAND DETAILS</h5>
                        <p class="mb-4">Please enter Inspection & Demand Details</p>

                        <div class="row g-3">
                            <div class="col-12 col-lg-12">
                                <label for="lastInsReport" class="form-label">Date of Last Inspection
                                    Report</label>
                                <input type="date" class="form-control" id="lastInsReport"
                                    name="date_of_last_inspection_report"
                                    value="{{$propertyInspectionDemandDetail ? $propertyInspectionDemandDetail->last_inspection_ir_date : ''}}">
                                <div id="lastInsReportError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="LastDemandLetter" class="form-label">Date of Last Demand
                                    Letter</label>
                                <input type="date" class="form-control" name="date_of_last_demand_letter"
                                    id="LastDemandLetter"
                                    value="{{$propertyInspectionDemandDetail ? $propertyInspectionDemandDetail->last_demand_letter_date : ''}}">
                                <div id="LastDemandLetterError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="DemandID" class="form-label">Demand ID</label>
                                <input type="number" class="form-control" name="demand_id" id="DemandID"
                                    placeholder="Demand ID"
                                    value="{{$propertyInspectionDemandDetail ? $propertyInspectionDemandDetail->last_demand_id : ''}}">
                                <div id="DemandIDError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <label for="amountDemandLetter" class="form-label">Amount of Last Demand
                                    Letter</label>
                                <input type="text" name="amount_of_last_demand" class="form-control"
                                    id="amountDemandLetter"
                                    value="{{$propertyInspectionDemandDetail ? $propertyInspectionDemandDetail->last_demand_amount : ''}}">
                                <div id="amountDemandLetterError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="LastAmount" class="form-label">Last Amount Received</label>
                                <input type="text" class="form-control" id="LastAmount" name="last_amount_reveived"
                                    placeholder="Last Amount Received"
                                    value="{{$propertyInspectionDemandDetail ? $propertyInspectionDemandDetail->last_amount_received : ''}}">
                                <div id="LastAmountError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="lastamountdate" class="form-label">Date</label>
                                <input type="date" class="form-control" name="last_amount_date" id="lastamountdate"
                                    value="{{$propertyInspectionDemandDetail ? $propertyInspectionDemandDetail->last_amount_received_date : ''}}">
                                <div id="lastamountdateError" class="text-danger"></div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-flex align-items-center gap-3">

                                    <button type="button" class="btn btn-outline-secondary px-4"
                                        onclick="stepper3.previous()"><i
                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>



                                    <button type="button" class="btn btn-primary px-4" id="submitButton5">Next<i
                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                </div>
                            </div>
                        </div><!---end row-->

                    </div>

                    <div id="test-vl-6" role="tabpane3" class="bs-stepper-pane content fade"
                        aria-labelledby="stepper3trigger6">
                        <h5 class="mb-1">MISCELLANEOUS DETAILS</h5>
                        <p class="mb-4">Please enter Miscellaneous Details</p>

                        <div class="row g-3">
                            @if(isset($propertyMiscDetail->is_gr_revised_ever) && $propertyMiscDetail->is_gr_revised_ever == 1)
                                <div class="col-12 col-lg-12">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2 mb-0">GR Revised Ever</h6>
                                        <div class="form-check mr-2">
                                            <input class="form-check-input" type="radio" name="GR" value="1" id="GRFormYes"
                                                {{$propertyMiscDetail->is_gr_revised_ever == 1 ? 'checked' : ''}}>
                                            <label class="form-check-label" for="GRFormYes">
                                                <h6 class="mb-0">Yes</h6>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="GR" value="0" id="GRFormNo"
                                                {{$propertyMiscDetail->is_gr_revised_ever == 0 ? 'checked' : ''}}>
                                            <label class="form-check-label" for="GRFormNo">
                                                <h6 class="mb-0">No</h6>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="GR-container" id="GRContainer">
                                        @if($propertyMiscDetail->is_gr_revised_ever == 1)
                                            <div class="col-12 col-lg-4">
                                                <label for="GRrevisedDate" class="form-label">Date</label>
                                                <input type="date" name="gr_revised_date" class="form-control"
                                                    id="GRrevisedDate" value="{{$propertyMiscDetail->gr_revised_date}}">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="col-12 col-lg-12">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2 mb-0">GR Revised Ever</h6>
                                        <div class="form-check mr-2">
                                            <input class="form-check-input" type="radio" name="GR" value="1" id="GRFormYes">
                                            <label class="form-check-label" for="GRFormYes">
                                                <h6 class="mb-0">Yes</h6>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="GR" value="0" id="GRFormNo"
                                                checked>
                                            <label class="form-check-label" for="GRFormNo">
                                                <h6 class="mb-0">No</h6>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="GR-container" id="GRContainer" style="display: none;">
                                        <div class="col-12 col-lg-4">
                                            <label for="GRrevisedDate" class="form-label">Date</label>
                                            <input type="date" name="gr_revised_date" class="form-control"
                                                id="GRrevisedDate">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(isset($propertyMiscDetail->is_supplimentry_lease_deed_executed) && $propertyMiscDetail->is_supplimentry_lease_deed_executed == 1)
                                <!-- <div class="col-12 col-lg-12">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mr-2 mb-0">Supplementary Lease Deed Executed</h6>
                                                        <div class="form-check mr-2">
                                                            <input class="form-check-input" type="radio" name="Supplementary" value="1"
                                                                id="SupplementaryFormYes"
                                                                {{$propertyMiscDetail->is_supplimentry_lease_deed_executed == 1 ? 'checked' : ''}}>
                                                            <label class="form-check-label" for="SupplementaryFormYes">
                                                                <h6 class="mb-0">Yes</h6>
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="Supplementary" value="0"
                                                                id="SupplementaryFormNo"
                                                                {{$propertyMiscDetail->is_supplimentry_lease_deed_executed == 0 ? 'checked' : ''}}>
                                                            <label class="form-check-label" for="SupplementaryFormNo">
                                                                <h6 class="mb-0">No</h6>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="Supplementary-container row" id="SupplementaryContainer">
                                                        <div class="row">
                                                            @if($propertyMiscDetail->is_supplimentry_lease_deed_executed == 1)
                                                                <div class="col-12 col-lg-6">
                                                                    <label for="SupplementaryDate" class="form-label">Date</label>
                                                                    <input type="date" class="form-control" name="supplementary_date"
                                                                        id="SupplementaryDate"
                                                                        value="{{$propertyMiscDetail->supplimentry_lease_deed_executed_date}}">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div> -->




                                <hr>
                                <div class="col-12 col-lg-12">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2 mb-0">Supplementary Lease Deed Executed</h6>
                                        <div class="form-check mr-2">
                                            <input class="form-check-input" type="radio" name="Supplementary" value="1"
                                                id="SupplementaryFormYes" {{ $propertyMiscDetail->is_supplimentry_lease_deed_executed == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="SupplementaryFormYes">
                                                <h6 class="mb-0">Yes</h6>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="Supplementary" value="0"
                                                id="SupplementaryFormNo" {{ $propertyMiscDetail->is_supplimentry_lease_deed_executed == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="SupplementaryFormNo">
                                                <h6 class="mb-0">No</h6>
                                            </label>
                                        </div>
                                    </div>
                                    @error('Supplementary')
                                        <span class="errorMsg">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <div class="Supplementary-container row" id="SupplementaryContainer" {{ $propertyMiscDetail->is_supplimentry_lease_deed_executed == 1 ? '' : 'style="display: none;"' }}>
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <label for="SupplementaryDate" class="form-label">Date</label>
                                                <input type="date" min="1600-01-01" max="2050-12-31" class="form-control"
                                                    name="supplementary_date"
                                                    value="{{ $propertyMiscDetail->supplimentry_lease_deed_executed_date }}"
                                                    id="SupplementaryDate">
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="areaunitname" class="form-label">Area</label>
                                                <div class="unit-field">
                                                    <input type="text" class="form-control numericDecimal" id=""
                                                        name="supplementary_area"
                                                        value="{{ $propertyMiscDetail->supplementary_area }}">
                                                    <select class="form-select unit-dropdown" id="" aria-label="Select Unit"
                                                        name="supplementary_area_unit">
                                                        <option value="">Select Unit</option>
                                                        @foreach ($areaUnit[0]->items as $unit)
                                                            <option value="{{ $unit->id }}" {{ $propertyMiscDetail->supplementary_area_unit == $unit->id ? 'selected' : '' }}>
                                                                {{ $unit->item_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div id="selectareaunitError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6 mt-3">
                                                <label for="premiumunit1" class="form-label">Premium (Re/ Rs)</label>
                                                <div class="unit-field">
                                                    <input type="text" class="form-control mr-2 numericOnly" id=""
                                                        name="supplementary_premium1"
                                                        value="{{$propertyMiscDetail->supplementary_premium}}">
                                                    <input type="text" class="form-control numericOnly" id=""
                                                        name="supplementary_premium2"
                                                        value="{{ $propertyMiscDetail->supplementary_premium_in_paisa != null ? $propertyMiscDetail->supplementary_premium_in_paisa : $propertyMiscDetail->supplementary_premium_in_aana }}">
                                                    <select class="form-select unit-dropdown"
                                                        name="supplementary_premium_unit" id="" aria-label="Select Unit">
                                                        <option value="">Unit</option>
                                                        <option value="1" {{ $propertyMiscDetail->supplementary_premium_in_paisa != null ? 'selected' : '' }}>
                                                            Paise</option>
                                                        <option value="2" {{ $propertyMiscDetail->supplementary_premium_in_aana != null ? 'selected' : '' }}>
                                                            Ana</option>
                                                    </select>
                                                </div>
                                                <div id="premiumunit2Error" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6 mt-3">
                                                <label for="groundRent1" class="form-label">Ground Rent (Re/ Rs)</label>
                                                <div class="unit-field">
                                                    <input type="text" class="form-control mr-2 numericOnly" id=""
                                                        name="supplementary_ground_rent1"
                                                        value="{{$propertyMiscDetail->supplementary_gr_in_re_rs}}">
                                                    <input type="text" class="form-control numericOnly" id=""
                                                        name="supplementary_ground_rent2"
                                                        value="{{ $propertyMiscDetail->supplementary_gr_in_paisa != null ? $propertyMiscDetail->supplementary_gr_in_paisa : $propertyMiscDetail->supplementary_gr_in_aana }}">
                                                    <select class="form-select unit-dropdown" id="" aria-label="Select Unit"
                                                        name="supplementary_ground_rent_unit">
                                                        <option value="">Unit</option>
                                                        <option value="1" {{ $propertyMiscDetail->supplementary_gr_in_paisa != null ? 'selected' : '' }}>
                                                            Paise</option>
                                                        <option value="2" {{ $propertyMiscDetail->supplementary_gr_in_aana != null ? 'selected' : '' }}>
                                                            Ana</option>
                                                    </select>
                                                </div>
                                                <div id="" class="text-danger"></div>
                                            </div>
                                        </div>

                                        <div class="row mt-4 mb-3">
                                            <div class="col-12 col-lg-12">
                                                <label for="SupplementaryRemark" class="form-label">Remark</label>
                                                <textarea id="SupplementaryRemark" name="supplementary_remark" rows="4"
                                                    style="width: 100%;">{{$propertyMiscDetail->supplementary_remark}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>











                            @else
                                <!-- <div class="col-12 col-lg-12">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mr-2 mb-0">Supplementary Lease Deed Executed</h6>
                                                        <div class="form-check mr-2">
                                                            <input class="form-check-input" type="radio" name="Supplementary" value="1"
                                                                id="SupplementaryFormYes">
                                                            <label class="form-check-label" for="SupplementaryFormYes">
                                                                <h6 class="mb-0">Yes</h6>
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="Supplementary" value="0"
                                                                id="SupplementaryFormNo" checked>
                                                            <label class="form-check-label" for="SupplementaryFormNo">
                                                                <h6 class="mb-0">No</h6>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div> -->
                                <!-- <div class="col-lg-12">
                                                    <div class="Supplementary-container row" id="SupplementaryContainer"
                                                        style="display: none;">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-6">
                                                                <label for="SupplementaryDate" class="form-label">Date</label>
                                                                <input type="date" class="form-control" name="supplementary_date"
                                                                    id="SupplementaryDate">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->




                                <hr>
                                <div class="col-12 col-lg-12">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2 mb-0">Supplementary Lease Deed Executed</h6>
                                        <div class="form-check mr-2">
                                            <input class="form-check-input" type="radio" name="Supplementary" value="1"
                                                id="SupplementaryFormYes">
                                            <label class="form-check-label" for="SupplementaryFormYes">
                                                <h6 class="mb-0">Yes</h6>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="Supplementary" value="0"
                                                id="SupplementaryFormNo" checked>
                                            <label class="form-check-label" for="SupplementaryFormNo">
                                                <h6 class="mb-0">No</h6>
                                            </label>
                                        </div>
                                    </div>
                                    @error('Supplementary')
                                        <span class="errorMsg">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <div class="Supplementary-container row" id="SupplementaryContainer"
                                        style="display: none;">
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <label for="SupplementaryDate" class="form-label">Date</label>
                                                <input type="date" min="1600-01-01" max="2050-12-31" class="form-control"
                                                    name="supplementary_date" id="SupplementaryDate">
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="areaunitname" class="form-label">Area</label>
                                                <div class="unit-field">
                                                    <input type="text" class="form-control numericDecimal" id=""
                                                        name="supplementary_area">
                                                    <select class="form-select unit-dropdown" id="" aria-label="Select Unit"
                                                        name="supplementary_area_unit">
                                                        <option value="" selected="">Select Unit</option>
                                                        <option value="27">Acre</option>
                                                        <option value="28">Sq Feet</option>
                                                        <option value="29">Sq Meter</option>
                                                        <option value="30">Sq Yard</option>
                                                        <option value="589">Hectare</option>
                                                    </select>
                                                </div>
                                                <div id="selectareaunitError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6 mt-3">
                                                <label for="premiumunit1" class="form-label">Premium (Re/ Rs)</label>
                                                <div class="unit-field">
                                                    <input type="text" class="form-control mr-2 numericOnly" id=""
                                                        name="supplementary_premium1">
                                                    <input type="text" class="form-control numericOnly" id=""
                                                        name="supplementary_premium2">
                                                    <select class="form-select unit-dropdown"
                                                        name="supplementary_premium_unit" id="" aria-label="Select Unit">
                                                        <option value="">Unit</option>
                                                        <option selected="" value="1">Paise</option>
                                                        <option value="2">Ana</option>
                                                    </select>
                                                </div>
                                                <div id="premiumunit2Error" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6 mt-3">
                                                <label for="groundRent1" class="form-label">Ground Rent (Re/ Rs)</label>
                                                <div class="unit-field">
                                                    <input type="text" class="form-control mr-2 numericOnly" id=""
                                                        name="supplementary_ground_rent1">
                                                    <input type="text" class="form-control numericOnly" id=""
                                                        name="supplementary_ground_rent2">
                                                    <select class="form-select unit-dropdown" id="" aria-label="Select Unit"
                                                        name="supplementary_ground_rent_unit">
                                                        <option value="">Unit</option>
                                                        <option selected="" value="1">Paise</option>
                                                        <option value="2">Ana</option>
                                                    </select>
                                                </div>
                                                <div id="" class="text-danger"></div>
                                            </div>
                                        </div>

                                        <div class="row mt-4 mb-3">
                                            <div class="col-12 col-lg-12">
                                                <label for="SupplementaryRemark" class="form-label">Remark</label>
                                                <textarea id="SupplementaryRemark" name="supplementary_remark" rows="4"
                                                    style="width: 100%;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endif


                            @if(isset($propertyMiscDetail->is_re_rented) && $propertyMiscDetail->is_re_rented == 1)

                                <div class="col-12 col-lg-12">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2 mb-0">Re-entered</h6>
                                        <div class="form-check mr-2">
                                            <input class="form-check-input" type="radio" name="Reentered" value="1"
                                                id="ReenteredFormYes" {{$propertyMiscDetail->is_re_rented == 1 ? 'checked' : ''}}>
                                            <label class="form-check-label" for="ReenteredFormYes">
                                                <h6 class="mb-0">Yes</h6>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="Reentered" value="0"
                                                id="ReenteredFormNo" {{$propertyMiscDetail->is_re_rented == 0 ? 'checked' : ''}}>
                                            <label class="form-check-label" for="ReenteredFormNo">
                                                <h6 class="mb-0">No</h6>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="Reentered-container row" id="ReenteredContainer">
                                        @if($propertyMiscDetail->is_re_rented == 1)
                                            <div class="col-12 col-lg-4">
                                                <label for="reentryDate" class="form-label">Date of re-entry</label>
                                                <input type="date" class="form-control" id="reentryDate" name="date_of_reentry"
                                                    value="{{$propertyMiscDetail->re_rented_date}}">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="col-12 col-lg-12">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2 mb-0">Re-entered</h6>
                                        <div class="form-check mr-2">
                                            <input class="form-check-input" type="radio" name="Reentered" value="1"
                                                id="ReenteredFormYes">
                                            <label class="form-check-label" for="ReenteredFormYes">
                                                <h6 class="mb-0">Yes</h6>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="Reentered" value="0"
                                                id="ReenteredFormNo" checked>
                                            <label class="form-check-label" for="ReenteredFormNo">
                                                <h6 class="mb-0">No</h6>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="Reentered-container row" id="ReenteredContainer" style="display: none;">

                                        <div class="col-12 col-lg-4">
                                            <label for="reentryDate" class="form-label">Date of re-entry</label>
                                            <input type="date" class="form-control" id="reentryDate" name="date_of_reentry">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 mt-4">
                                <div class="d-flex align-items-center gap-3">

                                    <button type="button" class="btn btn-outline-secondary px-4"
                                        onclick="stepper3.previous()"><i
                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>

                                    <button type="button" class="btn btn-primary px-4" onclick="stepper3.next()">Next<i
                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                </div>
                            </div>
                        </div><!---end row-->

                    </div>

                    <div id="test-vl-7" role="tabpane3" class="bs-stepper-pane content fade"
                        aria-labelledby="stepper3trigger7">
                        <h5 class="mb-1">Latest Contact Details</h5>
                        <p class="mb-4">Please enter Latest Contact Details</p>
                        <div class="row g-3">
                            <div class="col-12 col-lg-11 border p-3">
                                <h5 class="pb-2">Property Master Details</h5>
                                <div class="d-flex justify-content-between">
                                    <p><b>Address:-
                                        </b>{{isset($propertyContactDetail->address) ? $propertyContactDetail->address : ''}}
                                    </p>
                                    <p><b>Phone No.:- </b>
                                        {{isset($propertyContactDetail->phone_no) ? $propertyContactDetail->phone_no : ''}}
                                    </p>
                                    <p><b>Email:- </b>
                                        {{isset($propertyContactDetail->email) ? $propertyContactDetail->email : ''}}
                                    </p>
                                    <p><b>As on Date:- </b>
                                        {{isset($propertyContactDetail->as_on_date) ? $propertyContactDetail->as_on_date : ''}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" id="address"
                                    placeholder="Address"
                                    value="{{isset($childContactDetail->address) ? $childContactDetail->address : ''}}">
                                <div id="addressError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="phoneno" class="form-label">Phone No.</label>
                                <input type="text" name="phone" class="form-control" id="phoneno"
                                    placeholder="Phone No."
                                    value="{{isset($childContactDetail->phone_no) ? $childContactDetail->phone_no : ''}}">
                                <div id="phonenoError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="Email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="Email" placeholder="Email"
                                    value="{{isset($childContactDetail->email) ? $childContactDetail->email : ''}}">
                                <div id="EmailError" class="text-danger"></div>
                            </div>

                            <div class="col-12 col-lg-4">
                                <label for="asondate" class="form-label">As on Date</label>
                                <input type="date" name="date" class="form-control" id="asondate"
                                    value="{{isset($childContactDetail->as_on_date) ? $childContactDetail->as_on_date : ''}}">
                                <div id="asondateError" class="text-danger"></div>
                            </div>
                            @if(isset($propertyContactDetail))

                            @endif
                            <div class="col-12">
                                <div class="d-flex align-items-center gap-3">
                                    <!-- <button class="btn btn-primary px-4" onclick="stepper3.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button> -->
                                    <button type="button" class="btn btn-outline-secondary px-4"
                                        onclick="stepper3.previous()"><i
                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>

                                    <button type="button" class="btn btn-success px-4"
                                        id="btnfinalsubmit">Update</button>
                                </div>
                            </div>
                        </div><!---end row-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end stepper three-->

@endsection

@section('footerScript')
<script src="{{asset('assets/plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
<script src="{{asset('assets/plugins/bs-stepper/js/main.js')}}"></script>
<script src="{{asset('assets/plugins/form-repeater/repeaterEdit.js')}}"></script>
<script src="{{asset('assets/plugins/form-repeater/repeater2Edit.js')}}"></script>
<script src="{{asset('assets/plugins/form-repeater/repeaterChild.js')}}"></script>
<script src="{{asset('assets/js/mis.js')}}"></script>
<script src="{{ asset('assets/js/masterMis.js') }}"></script>


<script>
    $("#PropertyIDSearchBtn").on('click', function () {

        var PropertyId = $('#PropertyID').val();

        if (PropertyId) {

            $.ajax({
                url: "{{route('propertySearch')}}",
                type: "POST",
                dataType: "JSON",
                data: {
                    property_id: PropertyId,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    //console.log(response);
                    if (response.status === true) {
                        //console.log(response);
                        $('#propertIdError').hide();
                        $("input[name='file_number']").val(response.data.file_number);
                        $("#ColonyNameOld option[value=" + response.data.colony_id + "]").attr('selected', true);
                        $("#PropertyStatus option[value=" + response.data.property_status + "]").attr('selected', true);
                        $("#LandType option[value=" + response.data.land_type + "]").attr('selected', true);
                    } else if (response.status === false) {
                        $('#propertIdError').text(response.message);
                        $("input[name='file_number']").val('');
                        /* $("#ColonyNameOld")[0].selectedIndex = 0;
                        $("#PropertyStatus")[0].selectedIndex = 0;
                        $("#LandType")[0].selectedIndex = 0; */
                    } else {
                        $('#propertIdError').text('Property Id not available');
                        $("input[name='file_number']").val('');
                        /* $("#ColonyNameOld")[0].selectedIndex = 0;
                        $("#PropertyStatus")[0].selectedIndex = 0;
                        $("#LandType")[0].selectedIndex = 0; */
                    }
                },
                error: function (response) {
                    console.log(response);
                }

            })

        } else {
            $('#propertIdError').text('Please provide a valid Property ID');
        }

    });


    $(document).ready(function () {
        $('#propertyType').on('change', function () {
            var idPropertyType = this.value;
            $("#propertySubType").html('');
            $.ajax({
                url: "{{route('prpertySubTypes')}}",
                type: "POST",
                data: {
                    property_type_id: idPropertyType,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {

                    $('#propertySubType').html('<option value="">Select Sub Type</option>');
                    $.each(result, function (key, value) {
                        $("#propertySubType").append('<option value="' + value
                            .id + '">' + value.item_name + '</option>');
                    });
                }
            });
        });


        $('#oldPropertyType').on('change', function () {
            var idPropertyType = this.value;
            $("#oldPropertySubType").html('');
            $.ajax({
                url: "{{route('prpertySubTypes')}}",
                type: "POST",
                data: {
                    property_type_id: idPropertyType,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {

                    $('#oldPropertySubType').html('<option value="">Select Sub Type</option>');
                    $.each(result, function (key, value) {
                        $("#oldPropertySubType").append('<option value="' + value
                            .id + '">' + value.item_name + '</option>');
                    });
                }
            });
        });

        // for hide and show the transfer button if data not available - Sourav Chauhan (18/July/2024)
        $('#transferredFormYes').change(function () {
            if ($(this).is(':checked')) {
                $('#addTransferDetailsUpdateSL').show();
            } else {
                $('#addTransferDetailsUpdateSL').hide();
            }
        });

    });

</script>
@endsection