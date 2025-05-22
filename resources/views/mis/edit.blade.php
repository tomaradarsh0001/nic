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
                <form method="POST" action="{{route('mis.update', $propertyDetail->id)}}">
                    @csrf
                    @method('PUT')

                    <!-- Added by Lalit on 17/09/2024 Get additinal data from query params & set into hidden field to insert record into application_status & section_mis_histories table-->
                    <input type="hidden" id="serviceType" name="serviceType" value="{{ isset($additionalData[0]) ? $additionalData[0] : '' }}">
                        <input type="hidden" id="modalId" name="modalId" value="{{ isset($additionalData[1]) ? $additionalData[1] : '' }}">
                        <input type="hidden" id="applicantNo" name="applicantNo" value="{{ isset($additionalData[2]) ? $additionalData[2] : '' }}">
                        <input type="hidden" id="masterId" name="masterId" value="{{ isset($additionalData[3]) ? $additionalData[3] : '' }}">
                        <input type="hidden" id="newPropertyId" name="newPropertyId" value="{{ isset($additionalData[4]) ? $additionalData[4] : '' }}">
                        <input type="hidden" id="oldPropertyId" name="oldPropertyId" value="{{ isset($additionalData[5]) ? $additionalData[5] : '' }}">
                        <input type="hidden" id="sectionCode" name="sectionCode" value="{{ isset($additionalData[6]) ? $additionalData[6] : '' }}">
                        <!--End -->
                        
                    <input type="hidden" id="propertyId" name="propertyId" value="{{ $propertyDetail->id }}">
                    <input type="hidden" id="oldPropertyDbStatusId" name="oldPropertyDbStatusId"
                        value="{{ $propertyDetail->status }}">
                    <div id="test-vl-1" role="tabpane3" class="bs-stepper-pane content fade"
                        aria-labelledby="stepper3trigger1">
                        <h5 class="mb-1">BASIC DETAILS</h5>
                        <p class="mb-4">Enter your basic information</p>

                        <div class="row g-3">
                            <div class="row align-items-end">

                                <div class="col-12 col-lg-4">
                                    <label for="PropertyID" class="form-label">Property ID</label>
                                    <input type="text" name="property_id" class="form-control" id="PropertyID"
                                        placeholder="Property ID" value="{{ $propertyDetail->old_propert_id }}"
                                        oninput="validateInputLength(this)">
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
                                        <input class="form-check-input" name="is_multiple_prop_id" type="checkbox"
                                            {{$propertyDetail->is_multiple_ids == 1 ? 'checked' : ''}} value="1"
                                            id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            <h6 class="mb-0">Yes</h6>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="FileNumber" class="form-label">File Number</label>
                                <input type="text" class="form-control" name="file_number" id="FileNumber"
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
                                    id="fileNumberGenerated" placeholder="Generated File No." readonly disabled>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="colonyName" class="form-label">Colony Name (Present)</label>
                                <select class="form-select" name="present_colony_name" id="colonyName"
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
                                <select class="form-select" name="old_colony_name" id="ColonyNameOld"
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
                                    @foreach ($propertyStatus[0]->items as $status)
                                                                    <option value="{{$status->id}}" {{$propertyDetail->status == $status->id ?
                                        'selected' : ''}}>{{ $status->item_name }}</option>
                                    @endforeach
                                </select>
                                @error('property_status')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="PropertyStatusError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="LandType" class="form-label">Land Type</label>
                                <select class="form-select" id="LandType" name="land_type"
                                    aria-label="Default select example">
                                    <option value="">Select</option>
                                    @foreach ($landTypes[0]->items as $landType)
                                                                    <option value="{{$landType->id}}" {{$propertyDetail->land_type == $landType->id ?
                                        'selected' : ''}}>{{ $landType->item_name }}</option>
                                    @endforeach
                                </select>
                                @error('land_type')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="LandTypeError" class="text-danger"></div>
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
                                <select class="form-select" name="lease_type" id="TypeLease" aria-label="Type of Lease">
                                    <option value="">Select</option>
                                    @foreach ($leaseTypes[0]->items as $leaseType)
                                                                    <option value="{{$leaseType->id}}"
                                                                        {{$propertyLeaseDetail->type_of_lease ==
                                        $leaseType->id ? 'selected' : ''}}>
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
                                <input type="date" name="date_of_execution" class="form-control" id="dateexecution"
                                    pattern="\d{2} \d{2} \d{4}" value="{{ $propertyLeaseDetail->doe }}">
                                @error('date_of_execution')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="dateexecutionError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="LeaseAllotmentNo" class="form-label">Lease/Allotment
                                    No.</label>
                                <input type="text" name="lease_no" class="form-control" id="LeaseAllotmentNo"
                                    placeholder="Lease/Allotment No." value="{{ $propertyDetail->lease_no }}">
                                @error('lease_no')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="LeaseAllotmentNoError" class="text-danger"></div>
                            </div>

                            <div class="col-12 col-lg-4">
                                <label for="dateOfExpiration" class="form-label">Date of Expiration</label>
                                <input type="date" class="form-control" name="date_of_expiration" id="dateOfExpiration"
                                    value="{{ $propertyLeaseDetail->date_of_expiration }}">
                                @error('date_of_expiration')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="dateOfExpirationError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="dateallotment" class="form-label">Date of Allotment</label>
                                <input type="date" name="date_of_allotment" class="form-control" id="dateallotment"
                                    value="{{ $propertyLeaseDetail->doa }}">
                                @error('date_of_allotment')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="dateallotmentError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="blockno" class="form-label">Block No. (Only alphanumeric allowed)</label>
                                <input type="text" name="block_no" class="form-control" id="blockno" maxlength="4"
                                    placeholder="Block No." value="{{ $propertyDetail->block_no }}">
                                @error('block_no')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <!-- <div id="blocknoError" class="text-danger"></div> -->
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="plotno" class="form-label">Plot No. (Only alphanumeric allowed)</label>
                                <input type="text" name="plot_no" class="form-control" id="plotno"
                                    placeholder="Plot No." value="{{ $propertyDetail->plot_or_property_no }}">
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
                                        <button type="button" class="btn btn-outline-primary repeater-add-btn-in-favor"
                                            data-toggle="tooltip" data-placement="bottom"
                                            title="Click on Add More to add more options below"><i
                                                class="bx bx-plus me-0"></i></button>
                                    </div>
                                    <!-- Repeater Items -->
                                    <div class="duplicate-field-tab-in-favor">
                                        @php $i = 0; @endphp
                                        @foreach($original as $originalData)
                                            @php    $i++; @endphp
                                            <div class="items">
                                                <!-- Repeater Content -->
                                                <div class="item-content">
                                                    <div class="mb-3">
                                                        <label for="favourName1" class="form-label">Name</label>
                                                        <input type="text" class="form-control"
                                                            name="original[{{$originalData->id}}]" id="original"
                                                            placeholder="Name" data-name="name"
                                                            value="{{$originalData->lessee_name}}">
                                                        <div id="favourName1Error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <!-- Repeater Remove Btn -->
                                                <div class="repeater-remove-btn">
                                                    <button type="button" class="btn btn-danger remove-btn px-4"
                                                        data-toggle="tooltip" data-placement="bottom"
                                                        title="Click on to delete this form" {{ $i == 1 ? 'disabled' : '' }}>
                                                        <i class="fadeIn animated bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="presentlyknownsas" class="form-label">Presently Known
                                    As</label>
                                <input type="text" class="form-control" id="presentlyknownsas" name="presently_known"
                                    value="{{$propertyLeaseDetail->presently_known_as}}">
                                @error('presently_known')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="areaunitname" class="form-label">Area</label>
                                <div class="unit-field">
                                    <input type="text" class="form-control unit-input" id="areaunitname" name="area"
                                        value="{{$propertyLeaseDetail->plot_area}}">
                                    <select class="form-select unit-dropdown" id="selectareaunit"
                                        aria-label="Select Unit" name="area_unit">
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
                                        value="{{$propertyLeaseDetail->premium}}">
                                    <input type="text" class="form-control unit-input" id="premiumunit2" name="premium2"
                                        value="{{$propertyLeaseDetail->premium_in_paisa != null ? $propertyLeaseDetail->premium_in_paisa : $propertyLeaseDetail->premium_in_aana}}">
                                    <select class="form-select unit-dropdown" name="premium_unit" id="selectpremiumunit"
                                        aria-label="Select Unit">
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
                                        value="{{$propertyLeaseDetail->gr_in_re_rs}}">
                                    <input type="text" class="form-control unit-input" id="groundRent2"
                                        name="ground_rent2"
                                        value="{{$propertyLeaseDetail->gr_in_paisa != null ? $propertyLeaseDetail->gr_in_paisa : $propertyLeaseDetail->gr_in_aana}}">
                                    <select class="form-select unit-dropdown" id="selectGroundRentUnit"
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
                                    value="{{$propertyLeaseDetail->start_date_of_gr}}">
                                <div id="startdateGRError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-2">
                                <label for="RGRduration" class="form-label">RGR Duration (Yrs)</label>
                                <input type="text" class="form-control" id="RGRduration" name="rgr_duration"
                                    maxlength="2" value="{{$propertyLeaseDetail->rgr_duration}}">
                                <div id="RGRdurationError" class="text-danger"></div>
                            </div>
                            @php
                                $endDate = date('Y-m-d', strtotime(
                                    "+$propertyLeaseDetail->rgr_duration years",
                                    strtotime($propertyLeaseDetail->start_date_of_gr)
                                )
                                );
                            @endphp
                            <div class="col-12 col-lg-3">
                                <label for="frevisiondateGR" class="form-label">First Revision of GR due
                                    on</label>
                                <input type="date" class="form-control" id="frevisiondateGR"
                                    name="first_revision_of_gr_due" value="{{$endDate}}">
                                <div id="frevisiondateGRError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="oldPropertyType" class="form-label">Purpose for which leased/
                                    allotted (As per lease)</label>
                                <select class="form-select" id="oldPropertyType" aria-label="Type of Lease"
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
                                <select class="form-select" id="oldPropertySubType" aria-label="Type of Lease"
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
                                                                <input class="form-check-input" type="checkbox" value="1" id="landusechange"
                                                                    name="land_use_changed" {{$propertyLeaseDetail->is_land_use_changed == 1 ?
                                'checked' : ''}}>
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
                                                                                    <select class="form-select" id="propertyType" aria-label="Type of Lease"
                                                                                        name="purpose_lease_type_alloted_present">
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
                                                                                    <select class="form-select" id="propertySubType" aria-label="Type of Lease"
                                                                                        name="purpose_lease_sub_type_alloted_present">
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
                                            <input class="form-check-input" type="checkbox" value="1" id="landusechange"
                                                name="land_use_changed">
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
                                            <select class="form-select" id="propertyType" aria-label="Type of Lease"
                                                name="purpose_lease_type_alloted_present">
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
                                            <select class="form-select" id="propertySubType" aria-label="Type of Lease"
                                                name="purpose_lease_sub_type_alloted_present">
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
                                <div class="transferred-container" id="transferredContainer">
                                    <div class="row">
                                        <div class="col-12 col-lg-12">
                                            <div id="container">

                                                @php
                                                    $count = 1;
                                                @endphp
                                                @php $k = $l = $m = 0; @endphp
                                                @foreach ($filteredTransferDetails as $date => $TransferDate)
                                                                                            @foreach($TransferDate as $process => $details)
                                                                                                                                        @php        $k++; @endphp
                                                                                                                                        <input type="hidden" name="idNewAdd[{{ $m }}]"
                                                                                                                                            value="{{ $details[0]->id }}">

                                                                                                                                        <div class="parent-container">
                                                                                                                                            <div class="text-align-right">
                                                                                                                                                <button type="button"
                                                                                                                                                    class="remove-parent-btn btn btn-outline-danger"
                                                                                                                                                    data-batch-transfer-id="{{ $details[0]->batch_transfer_id }}"
                                                                                                                                                    data-property-master-id="{{ $details[0]->property_master_id }}"
                                                                                                                                                    {{ $k == 1 ? 'disabled' : '' }}><i
                                                                                                                                                        class="fadeIn animated bx bx-trash"></i>
                                                                                                                                                    Delete</button>
                                                                                                                                            </div>
                                                                                                                                            <div class="row mb-3">
                                                                                                                                                <div class="col-12 col-lg-4 my-4">
                                                                                                                                                    <label for="ProcessTransfer" class="form-label">Process of
                                                                                                                                                        transfer</label>
                                                                                                                                                    <select name="land_transfer_type[]"
                                                                                                                                                        class="form-select processtransfer form-required"
                                                                                                                                                        data-name="processtransfer" id="ProcessTransfer"
                                                                                                                                                        aria-label="Type of Lease">
                                                                                                                                                        <option value="">Select</option>
                                                                                                                                                        <option value="Substitution" {{$process == 'Substitution'
                                                                                                    ? 'selected' : '' }}>Substitution</option>
                                                                                                                                                        <option value="Mutation" {{$process == 'Mutation'
                                                                                                    ? 'selected' : '' }}>Mutation</option>
                                                                                                                                                        <option value="Substitution cum Mutation"
                                                                                                                                                            {{$process == 'Substitution cum Mutation' ? 'selected'
                                                                                                    : '' }}>Substitution cum Mutation</option>
                                                                                                                                                        <option value="Mutation cum Substitution"
                                                                                                                                                            {{$process == 'Mutation cum Substitution' ? 'selected'
                                                                                                    : '' }}>Mutation cum Substitution</option>
                                                                                                                                                        <option value="Successor in interest"
                                                                                                                                                            {{$process == 'Successor in interest' ? 'selected'
                                                                                                    : '' }}>Successor in
                                                                                                                                                            interest</option>
                                                                                                                                                        <option value="Others" {{$process == 'Others' ? 'selected'
                                                                                                    : '' }}>Others</option>
                                                                                                                                                    </select>
                                                                                                                                                    <div id="ProcessTransferError" class="text-danger"></div>
                                                                                                                                                </div>
                                                                                                                                                <div class="col-12 col-lg-4 my-4">
                                                                                                                                                    <label for="transferredDate" class="form-label">Date</label>
                                                                                                                                                    <input type="date" name="transferDate[]"
                                                                                                                                                        class="form-control form-required" value="{{$date}}"
                                                                                                                                                        id="transferredDate">
                                                                                                                                                    <div id="transferredDateError" class="text-danger"></div>
                                                                                                                                                </div>
                                                                                                                                            </div>

                                                                                                                                            {{-- @if ($l == 1) --}}
                                                                                                                                            <button type="button" class="add-button-new-update btn btn-dark"
                                                                                                                                                data-index="{{ $m }}"><i class="fadeIn animated bx bx-plus"></i>
                                                                                                                                                Add Lessee
                                                                                                                                                Details</button>
                                                                                                                                            <div class="text-danger addLesseeBtnError" style="display: block;">
                                                                                                                                                Please click on Add Lessee
                                                                                                                                                Button</div>
                                                                                                                                            {{-- @endif --}}

                                                                                                                                            <div id="appendChildElementOnUpdate{{ $m }}">
                                                                                                                                            </div>

                                                                                                                                            @foreach ($details as $key => $detail)
                                                                                                                                                @php            $l++; @endphp
                                                                                                                                                <div class="child-item-individuals">
                                                                                                                                                    <div class="child-item">
                                                                                                                                                        <div class="duplicate-field-tab">
                                                                                                                                                            <div class="items1" data-group="test">
                                                                                                                                                                <div class="item-content row">
                                                                                                                                                                    <input type="hidden" value="{{ $detail->id }}"
                                                                                                                                                                        name="id{{ $count }}[]" />
                                                                                                                                                                    <div class="col-lg-4 mb-3">
                                                                                                                                                                        <label for="name"
                                                                                                                                                                            class="form-label">Name</label>
                                                                                                                                                                        <input type="text" name="name{{ $count }}[]"
                                                                                                                                                                            class="form-control form-required"
                                                                                                                                                                            id="name" placeholder="Name"
                                                                                                                                                                            value="{{ $detail->lessee_name }}"
                                                                                                                                                                            data-name="name">
                                                                                                                                                                        <div id="nameError" class="text-danger">
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class="col-lg-4 mb-3">
                                                                                                                                                                        <label for="age"
                                                                                                                                                                            class="form-label">Age</label>
                                                                                                                                                                        <input type="number"
                                                                                                                                                                            name="age{{ $count }}[]"
                                                                                                                                                                            class="form-control" id="age"
                                                                                                                                                                            placeholder="Age" min="0"
                                                                                                                                                                            value="{{ $detail->lessee_age }}"
                                                                                                                                                                            data-name="age">
                                                                                                                                                                        <div id="ageError" class="text-danger">
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class="col-lg-4 mb-3">
                                                                                                                                                                        <label for="share"
                                                                                                                                                                            class="form-label">Share</label>
                                                                                                                                                                        <input type="text"
                                                                                                                                                                            class="form-control form-required"
                                                                                                                                                                            id="share" name="share{{ $count }}[]"
                                                                                                                                                                            placeholder="Share"
                                                                                                                                                                            value="{{ $detail->property_share }}"
                                                                                                                                                                            data-name="share">
                                                                                                                                                                        <div id="shareError" class="text-danger">
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class="col-lg-4 mb-3">
                                                                                                                                                                        <label for="pannumber"
                                                                                                                                                                            class="form-label">PAN
                                                                                                                                                                            Number</label>
                                                                                                                                                                        <input type="text"
                                                                                                                                                                            class="form-control text-uppercase"
                                                                                                                                                                            id="pannumber"
                                                                                                                                                                            name="panNumber{{ $count }}[]"
                                                                                                                                                                            placeholder="PAN Number"
                                                                                                                                                                            value="{{ $detail->lessee_pan_no }}"
                                                                                                                                                                            data-name="pannumber">
                                                                                                                                                                        <div id="pannumberError"
                                                                                                                                                                            class="text-danger">
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class="col-lg-4 mb-3">
                                                                                                                                                                        <label for="aadharnumber"
                                                                                                                                                                            class="form-label">Aadhar
                                                                                                                                                                            Number</label>
                                                                                                                                                                        <input type="text"
                                                                                                                                                                            class="form-control text-uppercase"
                                                                                                                                                                            id="aadharnumber"
                                                                                                                                                                            name="aadharNumber{{ $count }}[]"
                                                                                                                                                                            placeholder="Aadhar Number"
                                                                                                                                                                            value="{{ $detail->lessee_aadhar_no }}"
                                                                                                                                                                            data-name="aadharnumber" maxlength="12">
                                                                                                                                                                        <div id="aadharnumberError"
                                                                                                                                                                            class="text-danger">
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                            </div>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                    <button type="button"
                                                                                                                                                        class="remove-child-parent-btn btn btn-danger"
                                                                                                                                                        data-land-transfer-id="{{ $detail->id }}"
                                                                                                                                                        data-batch-transfer-id="{{ $detail->batch_transfer_id }}"
                                                                                                                                                        data-property-master-id="{{ $detail->property_master_id }}"
                                                                                                                                                        {{ $l == 1 ? 'disabled' : '' }}><i
                                                                                                                                                            class="fadeIn animated bx bx-trash"></i>
                                                                                                                                                        Delete Lessee Details</button>
                                                                                                                                                </div>
                                                                                                                                            @endforeach
                                                                                                                                            <div class="child-item-individuals-update{{ $m }}">

                                                                                                                                            </div>
                                                                                                                                        </div>

                                                                                                                                        @php
                                                                                                                                            $count = $count + 1;
                                                                                                                                            $m++;
                                                                                                                                        @endphp
                                                                                            @endforeach
                                                @endforeach

                                                <!-- <button class="add-parent-button btn btn-outline-primary"><i class="fadeIn animated bx bx-plus"></i> Add Transfer</button> -->
                                            </div>
                                            <div id="addTransferBtnError" class="text-danger"></div>
                                            <div id="containerNew">
                                            </div>
                                            <button type="button" class="add-parent-button-new btn btn-outline-primary"
                                                id="addTransferBtnNew"><i class="fadeIn animated bx bx-plus"></i>
                                                Add
                                                Transfer Details</button>
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
                                        {{-- <div class="form-check mr-2">
                                            <input class="form-check-input" type="radio" name="freeHold" value="Yes"
                                                id="freeHoldFormYes" {{$propertyDetail->status == 952 ? 'checked' :
                                            'disabled'}}>
                                            <label class="form-check-label" for="freeHoldFormYes">
                                                <h6 class="mb-0">Yes</h6>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="freeHold" value="No"
                                                id="freeHoldFormNo" {{$propertyDetail->status != 952 ? 'checked' :
                                            'disabled'}}>
                                            <label class="form-check-label" for="freeHoldFormNo">
                                                <h6 class="mb-0">No</h6>
                                            </label>
                                        </div> --}}




                                        <div class="form-check mr-2">
                                            {{-- <input class="form-check-input" type="radio" name="freeHold"
                                                value="Yes" id="freeHoldFormYes" {{ $propertyDetail->status == 952 ?
                                            'checked' : 'disabled' }}> --}}
                                            <input class="form-check-input" type="radio" name="freeHold" value="Yes"
                                                id="freeHoldFormYes" {{ $propertyDetail->status == 952 ? 'checked' : ''
                                            }}>
                                            <label class="form-check-label" for="freeHoldFormYes">
                                                <h6 class="mb-0">Yes</h6>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            {{-- <input class="form-check-input" type="radio" name="freeHold" value="No"
                                                id="freeHoldFormNo" {{ $propertyDetail->status != 952 ?
                                            'checked' : 'disabled' }}> --}}
                                            <input class="form-check-input" type="radio" name="freeHold" value="No"
                                                id="freeHoldFormNo" {{ $propertyDetail->status != 952 ? 'checked' : ''
                                            }}>
                                            <label class="form-check-label" for="freeHoldFormNo">
                                                <h6 class="mb-0">No</h6>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="freehold-container" id="freeHoldContainer"
                                        style="{{ $propertyDetail->status != 952 ? 'display: none;' : '' }}">
                                        {{--@if($propertyDetail->status == 952)--}}
                                        <div class="col-12 col-lg-12">
                                            <label for="ConveyanceDate" class="form-label">Date of
                                                Conveyance Deed</label>
                                            @if($conversion)
                                                <div class="col-12 col-lg-4">
                                                    <input type="date"
                                                        value="{{($conversion[0]->transferDate) ? $conversion[0]->transferDate : $propertyLeaseDetail->date_of_conveyance_deed}}"
                                                        class="form-control" name="conveyanc_date" id="ConveyanceDate">
                                                </div>
                                            @else
                                                <div class="col-12 col-lg-4">
                                                    <input type="date" class="form-control form-required"
                                                        name="conveyanc_date" id="ConveyanceDate">
                                                    <div class="text-danger"></div>
                                                </div>
                                                <div class="items" data-group="test">
                                                    <div class="item-content row">
                                                        <div class="mb-3 col-lg-12 col-12">
                                                            <label for="newInFavourConversion"
                                                                class="form-label">Name</label>
                                                            <input type="text" name="newInFavourConversion[]"
                                                                id="newInFavourConversion"
                                                                class="form-control form-required alpha-only"
                                                                placeholder="Name" data-name="name">
                                                            <div class="text-danger"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-12 col-lg-12 mt-4">
                                            <!-- Repeater Content -->
                                            <div>
                                                <div class="col-12 col-lg-12">
                                                    <label for="plotno" class="form-label">In favour
                                                        of</label>
                                                    <button type="button"
                                                        class="btn btn-outline-primary repeater-add-btn-in-favor-conversion"
                                                        data-toggle="tooltip" data-placement="bottom" data-index="0"
                                                        title="Click on Add More to add more options below"><i
                                                            class="bx bx-plus me-0"></i></button>


                                                </div>
                                                <!-- Repeater Items -->
                                                <div class="duplicate-field-tab-conversion">
                                                    @php $j = 0; @endphp
                                                    @foreach ($conversion as $conver)
                                                                                                    @php    $j++; @endphp
                                                                                                    <div class="items">

                                                                                                        <div class="item-content row">

                                                                                                            <div class="mb-3 col-lg-8 col-12">
                                                                                                                <label for="inputName1" class="form-label">Name</label>
                                                                                                                <input type="text" id="conversion"
                                                                                                                    name="conversion[{{$conver->id}}]"
                                                                                                                    class="form-control form-required" id="inputName1"
                                                                                                                    placeholder="Name" data-name="name"
                                                                                                                    value="{{$conver->lessee_name}}">
                                                                                                            </div>

                                                                                                        </div>



                                                                                                        <!-- By Lalit for Repeater Remove Btn 19/July/2024 -->
                                                                                                        <div class="repeater-remove-btn">
                                                                                                            <button type="button"
                                                                                                                class="btn btn-danger remove-btn-conversion px-4"
                                                                                                                data-toggle="tooltip" data-placement="bottom"
                                                                                                                title="Click on to delete this form" {{ $j == 1
                                                        ? 'disabled' : '' }}>
                                                                                                                <i class="fadeIn animated bx bx-trash"></i>
                                                                                                            </button>
                                                                                                        </div>

                                                                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>


                            <div id="property_status_vacant">
                                <div class="col-12 col-lg-12">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2 mb-0">Land Type: Vacant</h6>
                                        <div class="form-check mr-2">
                                            <input class="form-check-input" type="radio" name="landType" value="Yes"
                                                id="landTypeFormYes" {{$propertyDetail->status == 1124 ? 'checked' :
    'disabled'}}>
                                            <label class="form-check-label" for="landTypeFormYes">
                                                <h6 class="mb-0">Yes</h6>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="landType" value="No"
                                                id="landTypeFormNo" {{$propertyDetail->status != 1124 ? 'checked' :
    'disabled'}}>
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
                                                                                            {{$propertyLeaseDetail->in_possession_of_if_vacant
                                            == 1 ? 'checked' : ''}}>DDA</option>
                                                                                        <option value="2"
                                                                                            {{$propertyLeaseDetail->in_possession_of_if_vacant
                                            == 2 ? 'checked' : ''}}>NDMC</option>
                                                                                        <option value="3"
                                                                                            {{$propertyLeaseDetail->in_possession_of_if_vacant
                                            == 3 ? 'checked' : ''}}>MCD</option>
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
                                                value="Yes" id="landTypeFormOthersYes" {{$propertyDetail->status == 1342
    ? 'checked' : 'disabled'}}>
                                            <label class="form-check-label" for="landTypeFormOthersYes">
                                                <h6 class="mb-0">Yes</h6>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="landTypeOthers"
                                                value="No" id="landTypeFormOthersNo" {{$propertyDetail->status != 1342 ?
    'checked' : 'disabled'}}>
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
                                        Previous </button>

                                        <button type="button" class="btn btn-primary px-4" id="submitButton4">Next <i class='bx bx-right-arrow-alt ms-2'></i></button>

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
                            @if(
                                    isset($propertyMiscDetail->is_gr_revised_ever) &&
                                    $propertyMiscDetail->is_gr_revised_ever == 1
                                )
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

                            @if (
                                    isset($propertyMiscDetail->is_supplimentry_lease_deed_executed) &&
                                    $propertyMiscDetail->is_supplimentry_lease_deed_executed == 1
                                )

                                                            <hr>
                                                            <div class="col-12 col-lg-12">
                                                                <div class="d-flex align-items-center">
                                                                    <h6 class="mr-2 mb-0">Supplementary Lease Deed Executed</h6>
                                                                    <div class="form-check mr-2">
                                                                        <input class="form-check-input" type="radio" name="Supplementary" value="1"
                                                                            id="SupplementaryFormYes" {{
                                        $propertyMiscDetail->is_supplimentry_lease_deed_executed == 1 ? 'checked' :
                                        '' }}>
                                                                        <label class="form-check-label" for="SupplementaryFormYes">
                                                                            <h6 class="mb-0">Yes</h6>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="Supplementary" value="0"
                                                                            id="SupplementaryFormNo" {{
                                        $propertyMiscDetail->is_supplimentry_lease_deed_executed == 0 ? 'checked' :
                                        '' }}>
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
                                                                <div class="Supplementary-container row" id="SupplementaryContainer" {{
                                        $propertyMiscDetail->is_supplimentry_lease_deed_executed == 1 ? '' :
                                        'style="display: none;"' }}>
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
                                                                                                                                <option value="{{ $unit->id }}" {{ $propertyMiscDetail->
                                                                                        supplementary_area_unit == $unit->id ? 'selected' : '' }}>
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
                                                                                    <option value="1" {{ $propertyMiscDetail->
                                        supplementary_premium_in_paisa != null ? 'selected' : '' }}>
                                                                                        Paise</option>
                                                                                    <option value="2" {{ $propertyMiscDetail->
                                        supplementary_premium_in_aana != null ? 'selected' : '' }}>
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
                                                                                    <option value="1" {{ $propertyMiscDetail->supplementary_gr_in_paisa
                                        != null ? 'selected' : '' }}>
                                                                                        Paise</option>
                                                                                    <option value="2" {{ $propertyMiscDetail->supplementary_gr_in_aana
                                        != null ? 'selected' : '' }}>
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
                                                                    id="ReenteredFormYes" {{$propertyMiscDetail->is_re_rented == 1 ? 'checked' :
                                ''}}>
                                                                <label class="form-check-label" for="ReenteredFormYes">
                                                                    <h6 class="mb-0">Yes</h6>
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="Reentered" value="0"
                                                                    id="ReenteredFormNo" {{$propertyMiscDetail->is_re_rented == 0 ? 'checked' :
                                ''}}>
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
                            <div class="col-12 col-lg-4">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" id="address"
                                    placeholder="Address" value="{{$propertyContactDetail->address}}">
                                @error('address')
                                    <span class="errorMsg">{{ $message }}</span>
                                @enderror
                                <div id="addressError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="phoneno" class="form-label">Phone No.</label>
                                <input type="text" name="phone" class="form-control" id="phoneno"
                                    placeholder="Phone No." value="{{$propertyContactDetail->phone_no}}">
                                <div id="phonenoError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="Email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="Email" placeholder="Email"
                                    value="{{$propertyContactDetail->email}}">
                                <div id="EmailError" class="text-danger"></div>
                            </div>
                            @php
                                // Convert UTC time to IST using Carbon
                                $utcTime = $propertyContactDetail->created_at;
                                $istTime = $utcTime->setTimezone('Asia/Kolkata');
                            @endphp
                            <div class="col-12 col-lg-4">
                                <label for="asondate" class="form-label">As on Date</label>
                                <input type="date" name="date" class="form-control" id="asondate"
                                    value="{{$propertyContactDetail->as_on_date}}">
                                <div id="asondateError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="additional_remark" class="form-label">Remark</label>
                                <input type="input" name="additional_remark" value="{{ $propertyDetail->additional_remark }}" placeholder="remark" class="form-control"
                                    id="additional_remark">
                            </div>

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
@include('mis.partials.delete-model-template')
@endsection

@section('footerScript')
<script src="{{asset('assets/plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
<script src="{{asset('assets/plugins/bs-stepper/js/main.js')}}"></script>
<script src="{{asset('assets/plugins/form-repeater/repeaterEdit.js')}}"></script>
<script src="{{asset('assets/plugins/form-repeater/repeater2Edit.js')}}"></script>
<script src="{{asset('assets/plugins/form-repeater/repeaterChild.js')}}"></script>
<!-- <script src="{{asset('assets/js/mis.js')}}"></script> -->
<script src="{{ asset('assets/js/misEdit.js') }}"></script>
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

    });

    $(document).ready(function () {
        var deleteItem;
        var deleteUrl;
        var deleteParentItem;
        $('.remove-btn').on('click', function (e) {
            e.preventDefault();
            deleteItem = $(this).closest('.items'); // Store the item to delete
            var id = $(this).closest('.items').find('input[name^="original"]').attr('name').match(
                /\d+/)[0]; // Extract ID from input name
            deleteUrl = "{{ route('original.destroy', ':id') }}".replace(':id', id);
            $('#ModalDelete').modal('show');
        });
        $('.remove-btn-conversion').on('click', function (e) {
            e.preventDefault();
            deleteItem = $(this).closest('.items'); // Store the item to delete
            var id = $(this).closest('.items').find('input[name^="conversion"]').attr('name').match(
                /\d+/)[0]; // Extract ID from input name
            deleteUrl = "{{ route('original.destroy', ':id') }}".replace(':id', id);
            $('#ModalDelete').modal('show');
        });
        $('.remove-parent-btn').on('click', function (e) {
            e.preventDefault();
            deleteItem = $(this).closest('.parent-container'); // Store the item to delete
            var propertyMasterId = $(this).data('property-master-id');
            var batchTransferId = $(this).data('batch-transfer-id');
            deleteUrl =
                "{{ route('property.land.batch.transfer.destroy', ['batchId' => ':batchId', 'propertyMasterId' => ':propertyMasterId']) }}"
                    .replace(':batchId', batchTransferId)
                    .replace(':propertyMasterId', propertyMasterId);
            $('#ModalDelete').modal('show');
        });
        $('#confirmDelete').click(function (e) {
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    "_method": "POST",
                    " _token": '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.status === true) {
                        deleteItem.remove();
                        $('#ModalDelete').modal('hide');
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr) {
                    alert('An error occurred. Please try again.');
                }
            });
        });
        $('.remove-child-parent-btn').on('click', function (e) {
            e.preventDefault();
            deleteItem = $(this).closest('.child-item-individuals'); // Store the item to delete
            deleteParentItem = $(this).closest('.parent-container');
            var propertyMasterId = $(this).data('property-master-id');
            var batchTransferId = $(this).data('batch-transfer-id');
            var landTransferId = $(this).data('land-transfer-id');
            deleteUrl =
                "{{ route('property.land.batch.transfer.individual.destroy', ['landTransferId' => ':landTransferId', 'batchId' => ':batchId', 'propertyMasterId' => ':propertyMasterId']) }}"
                    .replace(':landTransferId', landTransferId)
                    .replace(':batchId', batchTransferId)
                    .replace(':propertyMasterId', propertyMasterId);
            $('#LTDModalDelete').modal('show');
        });
        $('#confirmLTDDelete').click(function (e) {
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    "_method": "POST",
                    " _token": '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.status === true && response.data === 'exist') {
                        deleteItem.remove();
                        $('#LTDModalDelete').modal('hide');
                    } else if (response.status === true && response.data === 'notexist') {
                        deleteParentItem.remove();
                        $('#LTDModalDelete').modal('hide');
                    } else {
                        alert(response.message);
                        $('#LTDModalDelete').modal('hide');
                    }
                },
                error: function (xhr) {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
    $(document).ready(function () {
        $('#addTransferBtnNew').click(function () {
            var index = $('.parent-container-new').length;
            var transferHtml = `
        <div class="parent-container-new">
            <div class="text-align-right">
                <button type="button" class="delete-parent-button-new btn btn-outline-danger"><i class="fadeIn animated bx bx-trash"></i> Delete</button>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-lg-4 my-4">
                    <label for="ProcessTransfer${index}" class="form-label">Process of transfer</label>
                    <select name="landTransferTypeNew[${index}]" class="form-select processtransfer form-required" data-name="processtransfer" id="ProcessTransfer${index}" aria-label="Type of Lease">
                        <option value="" selected="">Select</option>
                        <option value="Substitution">Substitution</option>
                        <option value="Mutation">Mutation</option>
                        <option value="Substitution cum Mutation">Substitution cum Mutation</option>
                        <option value="Mutation cum Substitution">Mutation cum Substitution</option>
                        <option value="Successor in interest">Successor in interest</option>
                        <option value="Others">Others</option>
                    </select>
                    <div id="ProcessTransferError${index}" class="text-danger">This field is required</div>
                </div>
                <div class="col-12 col-lg-4 my-4">
                    <label for="transferredDate${index}" class="form-label">Date</label>
                    <input type="date" name="transferDateNew[${index}]" class="form-control transferredDate form-required" id="transferredDate${index}">
                    <div id="transferredDateError${index}" class="text-danger">This field is required</div>
                </div>
            </div>
            <button type="button" class="add-button-new btn btn-dark" data-index="${index}"><i class="fadeIn animated bx bx-plus"></i> Add Lessee Details</button>
            <div class="text-danger addLesseeBtnError" style="display: block;">Please click on Add Lessee Button</div>
            <div id="appendChildElement${index}"></div>
        </div>
        `;
            $('#container').append(transferHtml);
        });
        $(document).on('click', '.add-button-new', function () {
            var index = $(this).data('index');
            var childHtml = `
        <div class="child-item">
            <div class="duplicate-field-tab">
                <div class="items1">
                    <div class="item-content row">
                        <div class="col-lg-4 mb-3">
                            <label for="name${index}" class="form-label">Name</label>
                            <input type="text" name="nameNew${index}[]" class="form-control lesseeName form-required alpha-only" id="name${index}" placeholder="Name" data-name="name">
                            <div id="nameError${index}" class="text-danger">This field is required</div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="age${index}" class="form-label">Age</label>
                            <input type="text" name="ageNew${index}[]" class="form-control numericOnly" id="age${index}" placeholder="Age" data-name="age" maxlength="3">
                            <div id="ageError${index}" class="text-danger"></div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="share${index}" class="form-label">Share</label>
                            <input type="text" class="form-control lesseeShare form-required" id="share${index}" name="shareNew${index}[]" placeholder="Share" data-name="share">
                            <div id="shareError${index}" class="text-danger">This field is required</div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="pannumber${index}" class="form-label">PAN Number</label>
                            <input type="text" class="form-control text-uppercase pan_number_format" id="pannumber${index}" maxlength="10" name="panNumberNew${index}[]" placeholder="PAN Number" data-name="pannumber">
                            <div id="pannumberError${index}" class="text-danger"></div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="aadharnumber${index}" class="form-label">Aadhar Number</label>
                            <input type="text" class="form-control text-uppercase" id="aadharnumber${index}" name="aadharNumberNew${index}[]" placeholder="Aadhar Number" data-name="aadharnumber" maxlength="16">
                            <div id="aadharnumberError${index}" class="text-danger"></div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="delete-button-new btn btn-danger"><i class="fadeIn animated bx bx-trash"></i> Delete Lessee Details</button>
        </div>
    `;
            $(`#appendChildElement${index}`).before(childHtml);
        });
        $(document).on('click', '.add-button-new-update', function () {
            var index = $(this).data('index');
            var updateChildHtml = `
        <div class="child-item">
            <div class="duplicate-field-tab">
                <div class="items1">
                    <div class="item-content row">
                        <div class="col-lg-4 mb-3">
                            <label for="name${index}" class="form-label">Name</label>
                            <input type="text" name="nameNewAdd${index}[]" class="form-control lesseeName form-required alpha-only" id="name${index}" placeholder="Name" data-name="name">
                            <div id="nameError${index}" class="text-danger">This field is required</div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="age${index}" class="form-label">Age</label>
                            <input type="text" name="ageNewAdd${index}[]" class="form-control numericOnly" id="age${index}" placeholder="Age" data-name="age" maxlength="3">
                            <div id="ageError${index}" class="text-danger"></div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="share${index}" class="form-label">Share</label>
                            <input type="text" class="form-control lesseeShare form-required" id="share${index}" name="shareNewAdd${index}[]" placeholder="Share" data-name="share">
                            <div id="shareError${index}" class="text-danger">This field is required</div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="pannumber${index}" class="form-label">PAN Number</label>
                            <input type="text" class="form-control text-uppercase pan_number_format" id="pannumber${index}" maxlength="10" name="panNumberNewAdd${index}[]" placeholder="PAN Number" data-name="pannumber">
                            <div id="pannumberError${index}" class="text-danger"></div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="aadharnumber${index}" class="form-label">Aadhar Number</label>
                            <input type="text" class="form-control text-uppercase" id="aadharnumber${index}" name="aadharNumberNewAdd${index}[]" placeholder="Aadhar Number" data-name="aadharnumber" maxlength="16">
                            <div id="aadharnumberError${index}" class="text-danger"></div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="delete-button-new btn btn-danger"><i class="fadeIn animated bx bx-trash"></i> Delete Lessee Details</button>
        </div>
    `;
            $(`.child-item-individuals-update${index}`).before(updateChildHtml);
            index++;
        });
        $(document).on('input', '.alpha-only', function () {
            this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
        });
        $(document).on('input', '.numericOnly', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $(document).on('input', '.pan_number_format', function () {
            // Convert the input value to uppercase
            this.value = this.value.toUpperCase();
            // Remove any characters that are not alphanumeric
            this.value = this.value.replace(/[^A-Z0-9]/g, '');
            // Ensure the first part is 5 alphabetic characters
            let firstPart = this.value.slice(0, 5).replace(/[^A-Z]/g, '');
            // Ensure the second part is 4 numeric digits
            let secondPart = this.value.slice(5, 9).replace(/[^0-9]/g, '');
            // Ensure the third part is 1 alphabetic character
            let thirdPart = this.value.slice(9, 10).replace(/[^A-Z]/g, '');
            // Combine the parts back together
            this.value = firstPart + secondPart + thirdPart;
            // Ensure the input does not exceed 10 characters
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });
        $(document).on('input', '[id^="aadharnumber"]', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 12) {
                this.value = this.value.slice(0, 12);
            }
        });
        $(document).on('click', '.delete-parent-button-new', function () {
            var parentContainer = $(this).closest('.parent-container-new');
            parentContainer.remove();
            // Update indexes for remaining parent containers
            $('.parent-container-new').each(function (newIndex) {
                var currentIndex = newIndex;
                $(this).find('[name^="landTransferTypeNew"]').attr('name',
                    `landTransferTypeNew[${currentIndex}]`);
                $(this).find('[name^="transferDateNew"]').attr('name',
                    `transferDateNew[${currentIndex}]`);
                $(this).find('.add-button-new').data('index', currentIndex);
                // Update indexes for child items within this parent container
                $(this).find('.child-item').each(function () {
                    $(this).find('[name^="nameNew"]').attr('name',
                        `name${currentIndex}[]`);
                    $(this).find('[name^="ageNew"]').attr('name',
                        `age${currentIndex}[]`);
                    $(this).find('[name^="shareNew"]').attr('name',
                        `share${currentIndex}[]`);
                    $(this).find('[name^="panNumberNew"]').attr('name',
                        `panNumber${currentIndex}[]`);
                    $(this).find('[name^="aadharNumberNew"]').attr('name',
                        `aadharNumber${currentIndex}[]`);
                });
            });
        });
        $(document).on('click', '.delete-button-new', function () {
            $(this).closest('.child-item').remove();
        });
        $(document).on('click', '.delete-button', function () {
            $(this).closest('.parent-container-new').find('.child-item:last').remove();
        });

        $(document).on('change', '#PropertyStatus', function () {
            if (this.value != '' && this.value != undefined) {
                var propertyId = document.getElementById('propertyId').value;
                var propertyStatusId = this.value;
                if (propertyId != '' && propertyStatusId != '') {
                    softDeleteOldPropertyStatusRecordUrl =
                        "{{ route('get.old.property.value', ['propertyId' => ':propertyId', 'propertyStatusId' => ':propertyStatusId']) }}"
                            .replace(':propertyId', propertyId)
                            .replace(':propertyStatusId', propertyStatusId);
                    $.ajax({
                        url: softDeleteOldPropertyStatusRecordUrl,
                        type: 'POST',
                        data: {
                            "_method": "POST",
                            " _token": '{{ csrf_token() }}'
                        },
                        dataType: "JSON",
                        success: function (response) {
                            if (response.status === true && response.data === 'true') {
                                document.getElementById('oldPropertyDbStatusId').value =
                                    response.oldStatusId;
                                $('#propertyStatusChangeModel').modal('show');
                            }
                        },
                        error: function (xhr) {
                            alert('An error occurred. Please try again.');
                        }
                    });
                }
            }
        });

        $('#propertyStatusChangeConfirm').click(function (e) {
            var propertyId = document.getElementById('propertyId').value;
            var propertyStatusId = document.getElementById('PropertyStatus').value;
            var oldPropertyDbStatusId = document.getElementById('oldPropertyDbStatusId').value;
            // Collect all input values
            var conversionArr = {};
            $('input[name^="conversion"]').each(function () {
                var id = $(this).attr('name').match(/\d+/)[0];
                var value = $(this).val();
                conversionArr[id] = value;
                // conversionArr[] = id;
            });
            if (propertyId != '' && propertyStatusId != '') {
                $.ajax({
                    url: '{{ route('soft.delete.old.property.status.record') }}',
                    method: 'POST',
                    data: {
                        " _token": '{{ csrf_token() }}',
                        "propertyId": propertyId,
                        "propertyStatusId": propertyStatusId,
                        "oldPropertyDbStatusId": oldPropertyDbStatusId,
                        "conversion": conversionArr
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.success === true) {
                            $('#propertyStatusChangeModel').modal('hide');
                        } else {
                            $('#propertyStatusChangeModel').modal('hide');
                        }
                    },
                    error: function (xhr) {
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        });
    });
</script>
@endsection