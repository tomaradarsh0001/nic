@extends('layouts.app')

@section('title', 'Multiple Property Form')

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
                                <li class="breadcrumb-item active" aria-current="page">Multiple Property Form</li>
                            </ol>
                        </nav>

                    </div>
                    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
                </div>
                <!--end breadcrumb-->



                <!--start stepper three-->
                <!-- <h6 class="text-uppercase">MIS</h6> -->
                <hr class="mob-none">
                <div class="card">
                    <div class="card-body">
                        <div id="stepper3" class="bs-stepper gap-4 vertical">
                            <div class="bs-stepper-header" role="tablist">
                                <div class="step" data-target="#test-vl-1">
                                    <div class="step-trigger" role="tab" id="stepper3trigger1"
                                        aria-controls="test-vl-1">
                                        <div class="bs-stepper-circle">1</div>
                                        <!-- <div class="bs-stepper-circle-content">
                                    <h5 class="mb-0 steper-title">Basic Details</h5>
                                </div> -->
                                    </div>
                                </div>

                                <div class="step" data-target="#test-vl-2">
                                    <div class="step-trigger" role="tab" id="stepper3trigger2"
                                        aria-controls="test-vl-2">
                                        <div class="bs-stepper-circle">2</div>
                                        <!-- <div class="bs-stepper-circle-content">
                                    <h5 class="mb-0 steper-title">Lease Details</h5>
                                </div> -->
                                    </div>
                                </div>

                                <div class="step" data-target="#test-vl-3">
                                    <div class="step-trigger" role="tab" id="stepper3trigger3"
                                        aria-controls="test-vl-3">
                                        <div class="bs-stepper-circle">3</div>
                                        <!-- <div class="bs-stepper-circle-content">
                                    <h5 class="mb-0 steper-title">Land Transfer <br> Details</h5>
                                </div> -->
                                    </div>
                                </div>


                                <div class="step" data-target="#test-vl-4">
                                    <div class="step-trigger" role="tab" id="stepper3trigger4"
                                        aria-controls="test-vl-4">
                                        <div class="bs-stepper-circle">4</div>
                                        <!-- <div class="bs-stepper-circle-content">
                                    <h5 class="mb-0 steper-title">Property Status <br> Details</h5>
                                </div> -->
                                    </div>
                                </div>

                                <div class="step" data-target="#test-vl-5">
                                    <div class="step-trigger" role="tab" id="stepper3trigger5"
                                        aria-controls="test-vl-5">
                                        <div class="bs-stepper-circle">5</div>
                                        <!-- <div class="bs-stepper-circle-content">
                                    <h5 class="mb-0 steper-title">Inspection & <br>Demand Details</h5>
                                </div> -->
                                    </div>
                                </div>

                                <div class="step" data-target="#test-vl-6">
                                    <div class="step-trigger" role="tab" id="stepper3trigger6"
                                        aria-controls="test-vl-6">
                                        <div class="bs-stepper-circle">6</div>
                                        <!-- <div class="bs-stepper-circle-content">
                                    <h5 class="mb-0 steper-title">Miscellaneous <br>Details</h5>
                                </div> -->
                                    </div>
                                </div>

                                <div class="step" data-target="#test-vl-7">
                                    <div class="step-trigger" role="tab" id="stepper3trigger7"
                                        aria-controls="test-vl-7">
                                        <div class="bs-stepper-circle">7</div>
                                        <!-- <div class="bs-stepper-circle-content">
                                    <h5 class="mb-0 steper-title">Latest Contact Details</h5>
                                </div> -->
                                    </div>
                                </div>
                            </div>

                            <div class="bs-stepper-content">
                                <form method="POST" action="{{route('mis.store.multiple')}}">
                                    @csrf
                                    <div id="test-vl-1" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger1">
                                        <h5 class="mb-1">BASIC DETAILS</h5>
                                        <p class="mb-4">Enter your basic information</p>

                                        <div class="row g-3">
                                            <div class="row align-items-end">

                                                <div class="col-9 col-lg-4">
                                                    <label for="PropertyID" class="form-label">Property ID</label>
                                                    <input type="text" name="property_id" class="form-control"
                                                        id="PropertyID" placeholder="Property ID"
                                                        value="{{ old('property_id') }}"
                                                        oninput="validateInputLength(this)">
                                                </div>
                                                <div class="col-3 col-lg-2">
                                                    <button type="button" id="PropertyIDSearchBtn"
                                                        class="btn btn-primary">Search</button>
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
                                                        <input class="form-check-input" name="is_multiple_prop_id"
                                                            type="checkbox" value="1" id="flexCheckChecked">
                                                        <label class="form-check-label" for="flexCheckChecked">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="FileNumber" class="form-label">File Number</label>
                                                <input type="text" class="form-control" name="file_number"
                                                    id="FileNumber" placeholder="File Number"
                                                    value="{{ old('file_number') }}">
                                                <!-- @error('file_number')
                                            <span class="errorMsg">{{ $message }}</span>
                                        @enderror -->
                                                <div id="FileNumberError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="fileNumberGenerated" class="form-label">Computer generated
                                                    file no</label>
                                                <input type="text" class="form-control" id="fileNumberGenerated"
                                                    placeholder="Generated File No." readonly disabled>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="colonyName" class="form-label">Colony Name (Present)</label>
                                                <select class="form-select" name="present_colony_name" id="colonyName"
                                                    aria-label="Colony Name (Present)">
                                                    <option value="">Select</option>
                                                    @foreach ($colonyList as $colony)
                                                    <option value="{{$colony->id}}">{{ $colony->name }}</option>
                                                    @endforeach
                                                </select>
                                                <!-- @error('present_colony_name')
                                            <span class="errorMsg">{{ $message }}</span>
                                        @enderror -->
                                                <div id="PresentColonyNameError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="ColonyNameOld" class="form-label">Colony Name (Old)</label>
                                                <select class="form-select" name="old_colony_name" id="ColonyNameOld"
                                                    aria-label="Default select example">
                                                    <option value="">Select</option>
                                                    @foreach ($colonyList as $colony)
                                                    <option value="{{$colony->id}}">{{ $colony->name }}</option>
                                                    @endforeach
                                                </select>
                                                <!-- @error('old_colony_name')
                                            <span class="errorMsg">{{ $message }}</span>
                                        @enderror -->
                                                <div id="OldColonyNameError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="PropertyStatus" class="form-label">Property Status</label>
                                                <select class="form-select" id="PropertyStatus" name="property_status"
                                                    aria-label="Default select example">
                                                    <option value="">Select</option>
                                                    @foreach ($propertyStatus[0]->items as $status)
                                                    <option value="{{$status->id}}">{{ $status->item_name }}</option>
                                                    @endforeach
                                                </select>
                                                <!-- @error('property_status')
                                            <span class="errorMsg">{{ $message }}</span>
                                        @enderror -->
                                                <div id="PropertyStatusError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="LandType" class="form-label">Land Type</label>
                                                <select class="form-select" id="LandType" name="land_type"
                                                    aria-label="Default select example">
                                                    <option value="">Select</option>
                                                    @foreach ($landTypes[0]->items as $landType)
                                                    <option value="{{$landType->id}}">{{ $landType->item_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <!-- @error('land_type')
                                            <span class="errorMsg">{{ $message }}</span>
                                        @enderror -->
                                                <div id="LandTypeError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">

                                                <button type="button" class="btn btn-primary px-4 btn-next-form"
                                                    id="submitButton1">Next<i
                                                        class='bx bx-right-arrow-alt ms-2'></i></button>
                                            </div>
                                        </div><!---end row-->

                                    </div>

                                    <div id="test-vl-2" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger2">

                                        <h5 class="mb-1">LEASE DETAILS</h5>
                                        <p class="mb-4">Enter Your Lease Details</p>

                                        <div class="row g-3">
                                            <div class="col-12 col-lg-3">
                                                <label for="TypeLease" class="form-label">Type of Lease</label>
                                                <select class="form-select" name="lease_type" id="TypeLease"
                                                    aria-label="Type of Lease">
                                                    <option value="">Select</option>
                                                    @foreach ($leaseTypes[0]->items as $leaseType)
                                                    <option value="{{$leaseType->id}}">{{ $leaseType->item_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('lease_type')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="TypeLeaseError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <label for="dateexecution" class="form-label">Date of Execution</label>
                                                <input type="date" name="date_of_execution" class="form-control"
                                                    id="dateexecution" pattern="\d{2} \d{2} \d{4}"
                                                    value="{{ old('date_of_execution') }}">
                                                @error('date_of_execution')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="dateexecutionError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <label for="lease_exp_duration" class="form-label">Duration</label>
                                                <input type="text" maxlength="2" name="lease_exp_duration"
                                                    class="form-control numericOnly" id="lease_exp_duration"
                                                    placeholder="Duration" value="">
                                                <div id="leaseExpDurationError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <label for="LeaseAllotmentNo" class="form-label">Lease/Allotment
                                                    No.</label>
                                                <input type="text" name="lease_no" class="form-control"
                                                    id="LeaseAllotmentNo" placeholder="Lease/Allotment No."
                                                    value="{{ old('lease_no') }}">
                                                @error('lease_no')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="LeaseAllotmentNoError" class="text-danger"></div>
                                            </div>

                                            <div class="col-12 col-lg-4">
                                                <label for="dateOfExpiration" class="form-label">Date of
                                                    Expiration</label>
                                                <input type="date" class="form-control" name="date_of_expiration"
                                                    id="dateOfExpiration" value="{{ old('date_of_expiration') }}">
                                                @error('date_of_expiration')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="dateOfExpirationError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="dateallotment" class="form-label">Date of Allotment</label>
                                                <input type="date" name="date_of_allotment" class="form-control"
                                                    id="dateallotment" value="{{ old('date_of_allotment') }}">
                                                @error('date_of_allotment')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="dateallotmentError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="blockno" class="form-label">Block No. (Only alphanumeric
                                                    allowed)</label>
                                                <input type="text" name="block_no" class="form-control alphaNum-hiphenForwardSlash" id="blockno"
                                                    maxlength="6" placeholder="Block No." value="{{ old('block_no') }}">
                                                @error('block_no')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <!-- <div id="blocknoError" class="text-danger"></div> -->
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="plotno" class="form-label">Plot No. (Only alphanumeric
                                                    allowed)</label>
                                                <input type="text" name="plot_no" class="form-control plotNoAlpaMix"
                                                    id="plotno" placeholder="Plot No." value="{{ old('plot_no') }}">
                                                @error('plot_no')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="plotnoError" class="text-danger"></div>
                                            </div>
                                            
                                            <div class="col-12 col-lg-12">
                                                <!-- Repeater Content -->
                                                <div id="repeater" class="repeater-super-container">
                                                    <div class="col-12 col-lg-12">
                                                        <label for="plotno" class="form-label add-label-title">In favour
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
                                                        <div class="items" data-group="test">
                                                            <!-- Repeater Content -->
                                                            <div class="item-content">
                                                                <div class="mb-3">
                                                                    <label for="favourName1"
                                                                        class="form-label">Name</label>
                                                                    <input type="text" class="form-control alpha-only"
                                                                        name="favour_name[]" id="favourName1"
                                                                        placeholder="Name" data-name="name">
                                                                    <div id="favourName1Error" class="text-danger">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Repeater Remove Btn -->
                                                            <div class="repeater-remove-btn">
                                                                <button type="button"
                                                                    class="btn btn-danger remove-btn px-4"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Click on to delete this form">
                                                                    <i class="fadeIn animated bx bx-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Begin Joint Property -->
                                            <div class="col-12 col-lg-12">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">Is it a joint property?</h6>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="1"
                                                            id="jointproperty" name="is_jointproperty">
                                                        <label class="form-check-label" for="jointproperty">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12" id="jointPropertyHideFields" style="display: none;">
                                                <div class="row">
                                                    <div class="col-12 col-lg-12">
                                                        <!-- Repeater Content -->
                                                        <div id="repeaterjointproperty"
                                                            class="repeater-super-container">
                                                            <div class="col-12 col-lg-12">
                                                                <label for="plotno"
                                                                    class="form-label add-label-title">Add More
                                                                    Plot</label>
                                                                <button type="button" class="btn btn-outline-primary repeater-add-btn" data-toggle="tooltip" data-placement="bottom"
                                                                    title="Click on Add More Joint Property"><i class="bx bx-plus me-0"></i></button>
                                                            </div>
                                                            <!-- Repeater Items -->
                                                            <div class="duplicate-field-tab">
                                                                <div class="items" data-group="jointProperty">
                                                                    <!-- Repeater Content -->
                                                                    <div class="item-content row">
                                                                        <div class="col-lg-2 col-12 mb-3">
                                                                            <label for="jointplotno"
                                                                                class="form-label">Plot No.</label>
                                                                            <input type="text"
                                                                                class="plotNoAlpaMix form-control"
                                                                                name="jointplotno[]" id="jointplotno"
                                                                                placeholder="Enter Plot No"
                                                                                data-name="jointplotno">
                                                                                <div class="text-danger"></div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-12 mb-3">
                                                                            <label for="jointpropertyarea"
                                                                                class="form-label">Area</label>
                                                                                <div class="unit-field">
                                                                                    <div>
                                                                                    <input type="text"
                                                                                    class="numericDecimal form-control"
                                                                                    name="jointpropertyarea[]"
                                                                                    id="jointpropertyarea"
                                                                                    placeholder="Enter Area"
                                                                                    data-name="jointpropertyarea">
                                                                                    <div class="text-danger"></div>
                                                                                    </div>
                                                                         
                                                                                <div>
                                                                                <select class="form-select"
                                                                                    id="jointpropertyunit"
                                                                                    name="jointpropertyuit[]"
                                                                                    data-name="jointpropertyuit">
                                                                                    <option value="" selected>Select Unit</option>
                                                                                    <option value="27">Acre</option>
                                                                                    <option value="28">Sq Feet</option>
                                                                                    <option value="29">Sq Meter</option>
                                                                                    <option value="30">Sq Yard</option>
                                                                                    <option value="589">Hectare</option>
                                                                                </select>
                                                                                <div class="text-danger"></div>
                                                                                </div>
                                                                                </div>
                                                                            
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-4 col-12 mb-3">
                                                                            <label for="jointpresently_knownas"
                                                                                class="form-label">Property Known as
                                                                                (Present)</label>
                                                                            <input type="text" class="form-control"
                                                                                name="jointpresently_knownas[]"
                                                                                id="jointpresently_knownas"
                                                                                placeholder="Enter Property Known as"
                                                                                data-name="jointpresently_knownas">
                                                                        </div>
                                                                        <div class="col-lg-2 col-12 mb-3">
                                                                            <label for="jointpropertyid"
                                                                                class="form-label">PID</label>
                                                                            <input type="text"
                                                                                class="numericOnly form-control plotPropId"
                                                                                maxlength="5" name="jointpropertyid[]"
                                                                                id="jointpropertyid"
                                                                                placeholder="Enter PID"
                                                                                data-name="jointpropertyid">
                                                                                <div class="text-danger childPidDanger" id="childPidDanger"></div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <!-- Repeater Remove Btn -->
                                                                    <div class="repeater-remove-btn">
                                                                        <button type="button"
                                                                            class="btn btn-danger remove-btn px-4"
                                                                            data-toggle="tooltip"
                                                                            data-placement="bottom"
                                                                            title="Click on to delete this form">
                                                                            <i class="fadeIn animated bx bx-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- End Joint Property -->
                                            <div class="col-12 col-lg-4">
                                                <label for="presentlyknownsas" class="form-label">Presently Known
                                                    As</label>
                                                <input type="text" class="form-control" id="presentlyknownsas"
                                                    name="presently_known">
                                                @error('presently_known')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="areaunitname" class="form-label">Area</label>
                                                <div class="unit-field">
                                                    <input type="text" class="numericDecimal form-control unit-input"
                                                        id="areaunitname" name="area">
                                                    <select class="form-select unit-dropdown" id="selectareaunit"
                                                        aria-label="Select Unit" name="area_unit">
                                                        <option value="" selected>Select Unit</option>
                                                        @foreach ($areaUnit[0]->items as $unit)
                                                        <option value="{{$unit->id}}">{{ $unit->item_name }}</option>
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
                                                    <div>
                                                    <input type="text" class="form-control mr-2" id="premiumunit1"
                                                    name="premium1">
                                                    <div class="text-danger" id="premiumunit1Error"></div>
                                                    </div>
                                                    <div>
                                                    <input type="text" class="form-control unit-input" id="premiumunit2"
                                                        name="premium2">
                                                        <div class="text-danger" id="premiumunit2Error"></div>
                                                    </div>
                                                    <div>
                                                    <select class="form-select unit-dropdown" name="premium_unit"
                                                        id="selectpremiumunit" aria-label="Select Unit">
                                                        <option value="">Unit</option>
                                                        <option selected value="1">Paise</option>
                                                        <option value="2">Ana</option>
                                                    </select>
                                                    </div>
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
                                                    <div>
                                                        <input type="text" class="form-control mr-2" id="groundRent1"
                                                        name="ground_rent1">
                                                        <div class="text-danger" id="groundRent1Error"></div>
                                                    </div>
                                                    <div>
                                                    <input type="text" class="form-control unit-input" id="groundRent2"
                                                        name="ground_rent2">
                                                    <div class="text-danger" id="groundRent2Error"></div>
                                                    </div>
                                                    <div>
                                                    <select class="form-select unit-dropdown" id="selectGroundRentUnit"
                                                        aria-label="Select Unit" name="ground_rent_unit">
                                                        <option value="">Unit</option>
                                                        <option selected value="1">Paise</option>
                                                        <option value="2">Ana</option>
                                                    </select>
                                                    <div class="text-danger" id="premiumunit2Error"></div>
                                                    </div>
                                                </div>
                                                <div id="groundRent2Error" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <label for="startdateGR" class="form-label">Start Date of Ground
                                                    Rent</label>
                                                <input type="date" class="form-control" id="startdateGR"
                                                    name="start_date_of_gr">
                                                <div id="startdateGRError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-2">
                                                <label for="RGRduration" class="form-label">RGR Duration (Yrs)</label>
                                                <input type="text" class="form-control" id="RGRduration"
                                                    name="rgr_duration" maxlength="2">
                                                <div id="RGRdurationError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <label for="frevisiondateGR" class="form-label">First Revision of GR due
                                                    on</label>
                                                <input type="date" class="form-control" id="frevisiondateGR"
                                                    name="first_revision_of_gr_due">
                                                <div id="frevisiondateGRError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="oldPropertyType" class="form-label">Purpose for which
                                                    leased/
                                                    allotted (As per lease)</label>
                                                <select class="form-select" id="oldPropertyType"
                                                    aria-label="Type of Lease" name="purpose_property_type">
                                                    <option value="" selected>Select</option>
                                                    @foreach ($propertyTypes[0]->items as $propertyType)
                                                    <option value="{{$propertyType->id}}">{{ $propertyType->item_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div id="oldPropertyTypeError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="oldPropertySubType" class="form-label">Sub-Type (Purpose ,
                                                    at
                                                    present)</label>
                                                <select class="form-select" id="oldPropertySubType"
                                                    aria-label="Type of Lease" name="purpose_property_sub_type">
                                                    <option value="" selected>Select</option>
                                                </select>
                                                <div id="oldPropertySubTypeError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-12">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">Land Use Change</h6>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="1"
                                                            id="landusechange" name="land_use_changed">
                                                        <label class="form-check-label" for="landusechange">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12" id="hideFields" style="display: none;">
                                                <div class="row">
                                                <div class="col-12 col-lg-4">
                                                    <label for="dateOfLandChange" class="form-label">Date of Change</label>
                                                    <input type="date" class="form-control" name="date_of_land_change" id="dateOfLandChange" value="">
                                                    <div id="dateOfLandChangeError" class="text-danger"></div>
                                                </div>
                                                    <div class="col-12 col-lg-4">
                                                        <label for="PropertyType" class="form-label">Purpose for which
                                                            leased/ allotted (At present)</label>
                                                        <select class="form-select" id="propertyType"
                                                            aria-label="Type of Lease"
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
                                                    <div class="col-12 col-lg-4">
                                                        <label for="propertySubType" class="form-label">Sub-Type
                                                            (Purpose , at
                                                            present)</label>
                                                        <select class="form-select" id="propertySubType"
                                                            aria-label="Type of Lease"
                                                            name="purpose_lease_sub_type_alloted_present">
                                                            <option value="" selected>Select</option>
                                                        </select>
                                                        <div id="propertySubTypeError" class="text-danger"></div>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center gap-3">
                                                    <!-- <button class="btn btn-outline-secondary px-4" onclick="stepper3.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button> -->
                                                    <button type="button" class="btn btn-outline-secondary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                                    <button type="button" class="btn btn-primary px-4 btn-next-form"
                                                        id="submitButton2">Next<i
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
                                                        <input class="form-check-input" type="checkbox"
                                                            name="transferred" value="1" id="transferredFormYes">
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
                                                            <div class="if-all-select">
                                                                <h4>All Together/Combined</h4>
                                                                <div id="container">
                                                                    <div class="parent-container">
                                                                        <div class="row mb-3">
                                                                            <div class="col-12 col-lg-4 my-4">
                                                                                <label for="ProcessTransfer"
                                                                                    class="form-label">Process of
                                                                                    transfer</label>
                                                                                <select name="land_transfer_type[]"
                                                                                    class="form-select processtransfer form-required"
                                                                                    data-name="processtransfer"
                                                                                    id="ProcessTransfer"
                                                                                    aria-label="Type of Lease">
                                                                                    <option value="" selected="">Select
                                                                                    </option>
                                                                                    <option value="Substitution">
                                                                                        Substitution</option>
                                                                                    <option value="Mutation">Mutation
                                                                                    </option>
                                                                                    <option
                                                                                        value="Substitution cum Mutation">
                                                                                        Substitution cum Mutation
                                                                                    </option>
                                                                                    <option
                                                                                        value="Mutation cum Substitution">
                                                                                        Mutation cum Substitution 
                                                                                    </option>
                                                                                    <option
                                                                                        value="Successor in interest">
                                                                                        Successor in interest</option>
                                                                                    <option value="Others">Others
                                                                                    </option>
                                                                                </select>
                                                                                <div id="ProcessTransferError"
                                                                                    class="text-danger">This field is
                                                                                    required</div>
                                                                            </div>
                                                                            <div class="col-12 col-lg-4 my-4">
                                                                                <label for="transferredDate"
                                                                                    class="form-label">Date</label>
                                                                                <input type="date" name="transferDate[]"
                                                                                    class="form-control transferredDate form-required"
                                                                                    id="transferredDate">
                                                                                <div id="transferredDateError"
                                                                                    class="text-danger">This field is
                                                                                    required</div>
                                                                            </div>
                                                                        </div>
                                                                        <button type="button"
                                                                            class="add-button btn btn-dark"
                                                                            id="addLesseeBtn"><i
                                                                                class="fadeIn animated bx bx-plus"></i>
                                                                            Add Lessee Details</button>
                                                                        <div id="addLesseeBtnError" class="text-danger"
                                                                            style="display: block;">Please click on Add
                                                                            Lessee Button</div>
                                                                        <div class="child-item">
                                                                            <div class="duplicate-field-tab">
                                                                                <div class="items1">
                                                                                    <div class="item-content row">
                                                                                        <div class="col-lg-4 mb-3">
                                                                                            <label for="name"
                                                                                                class="form-label">Name</label>
                                                                                            <input type="text"
                                                                                                name="name0[]"
                                                                                                class="form-control lesseeName form-required alpha-only"
                                                                                                id="name"
                                                                                                placeholder="Name"
                                                                                                data-name="name">
                                                                                            <div id="nameError"
                                                                                                class="text-danger">This
                                                                                                field is required</div>
                                                                                        </div>
                                                                                        <div class="col-lg-4 mb-3">
                                                                                            <label for="age"
                                                                                                class="form-label">Age</label>
                                                                                            <input type="text"
                                                                                                name="age0[]"
                                                                                                class="form-control numericOnly"
                                                                                                id="age"
                                                                                                placeholder="Age"
                                                                                                maxlength="3" data-name="age">
                                                                                            <div id="ageError"
                                                                                                class="text-danger">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-4 mb-3">
                                                                                            <label for="share"
                                                                                                class="form-label">Share</label>
                                                                                            <input type="text"
                                                                                                class="form-control lesseeShare form-required"
                                                                                                id="share"
                                                                                                name="share0[]"
                                                                                                placeholder="Share"
                                                                                                data-name="share">
                                                                                            <div id="shareError"
                                                                                                class="text-danger">This
                                                                                                field is required</div>
                                                                                        </div>
                                                                                        <div class="col-lg-4 mb-3">
                                                                                            <label for="pannumber"
                                                                                                class="form-label">PAN
                                                                                                Number</label>
                                                                                            <input type="text"
                                                                                                class="form-control text-uppercase pan_number_format"
                                                                                                id="pannumber"
                                                                                                name="panNumber0[]"
                                                                                                maxlength="10"
                                                                                                placeholder="PAN Number"
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
                                                                                                class="form-control text-uppercase numericOnly"
                                                                                                id="aadharnumber"
                                                                                                name="aadharNumber0[]"
                                                                                                placeholder="Aadhar Number"
                                                                                                data-name="aadharnumber"
                                                                                                maxlength="12">
                                                                                            <div id="aadharnumberError"
                                                                                                class="text-danger">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- <button type="button"
                                                                                class="delete-button btn btn-danger"><i
                                                                                    class="fadeIn animated bx bx-trash"></i>
                                                                                Delete Lessee Details</button> -->
                                                                        </div>
                                                                    </div>
                                                                    <button type="button"
                                                                        class="add-parent-button btn btn-primary"
                                                                        id="addTransferBtn"><i
                                                                            class="fadeIn animated bx bx-plus"></i> Add
                                                                        Transfer Details</button>
                                                                </div>
                                                                <div id="addTransferBtnError" class="text-danger"></div>
                                                            </div>
                                                            <div class="else-select-tabs mt-2">
                                                                <h5 id="jointPropertyPlot_title" style="display: none;">Tabs Group</h5>
                                                                <!-- Begin Tabs Container -->
                                                                <div id="dvTabHtml" class="tab"></div>
                                                                <div id="dvTabHtm2" class="tabcontent-container"></div>
                                                                <!-- End Tabs Container -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- Duplicate Form End -->

                                            <div class="col-12 mt-4">
                                                <div class="d-flex align-items-center gap-3">

                                                    <button type="button" class="btn btn-outline-secondary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i> Previous</button>

                                                    <button type="button"
                                                        class="btn btn-primary px-4 btn-next-form submitButton3"
                                                        id="submitButton3">Next <i
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
                                        <div class="row g-3 mb-5">
                                            <div id="property_status_free_hold">
                                                <div class="col-12 col-lg-12">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mr-2 mb-0">Free Hold (F/H)</h6>
                                                        <div class="form-check mr-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="freeHold[]" value="yes" id="freeHoldFormYes">
                                                            <label class="form-check-label" for="freeHoldFormYes">
                                                                <h6 class="mb-0">Yes</h6>
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="freeHold[]" value="no" id="freeHoldFormNo"
                                                                checked>
                                                            <label class="form-check-label" for="freeHoldFormNo">
                                                                <h6 class="mb-0">No</h6>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="freehold-container" id="freeHoldContainer"
                                                        style="display: none;">
                                                        <div class="col-12 col-lg-4">
                                                            <label for="ConveyanceDate" class="form-label">Date of
                                                                Conveyance Deed</label>
                                                            <input type="date" class="form-control"
                                                                name="conveyanc_date[]" id="ConveyanceDate">
                                                            <span class="text-danger"></span>
                                                        </div>
                                                        <div class="col-12 col-lg-12 mt-4">
                                                            <!-- Repeater Content -->
                                                            <div id="repeater4" class="repeater-super-container">
                                                                <div class="col-12 col-lg-12">
                                                                    <label for="plotno"
                                                                        class="form-label add-label-title">In favour
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

                                                                        <div class="item-content row">
                                                                            <div class="mb-3 col-lg-12 col-12">
                                                                                <label for="inputName1"
                                                                                    class="form-label">Name</label>
                                                                                <input type="text"
                                                                                    name="free_hold_in_favour_name[]"
                                                                                    class="alpha-only form-control"
                                                                                    id="inputName1" placeholder="Name"
                                                                                    data-name="name">
                                                                                <span class="text-danger"></span>
                                                                            </div>
                                                                            <!-- <div class="mb-3 col-lg-4 col-12">
                                                                        <label for="InputProperty_known_as" class="form-label">Property Known as (Present)</label>
                                                                        <input type="text" name="free_hold_in_property_known_as_present[]" class="form-control" id="InputProperty_known_as" placeholder="Property Known as (Present)" data-name="pkap">
                                                                    </div>
                                                                    <div class="mb-3 col-lg-4 col-12">
                                                                        <label for="inputArea" class="form-label">Area</label>
                                                                        <input type="text" name="free_hold_in_favour_name[]" class="form-control" id="inputArea" placeholder="Area" data-name="area">
                                                                        <span class="text-danger"></span>
                                                                    </div> -->
                                                                        </div>
                                                                        <!-- Repeater Remove Btn -->
                                                                        <div class="repeater-remove-btn">
                                                                            <button
                                                                                class="btn btn-danger remove-btn px-4"
                                                                                data-toggle="tooltip"
                                                                                data-placement="bottom"
                                                                                title="Click on delete this form">
                                                                                <i
                                                                                    class="fadeIn animated bx bx-trash"></i>
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
                                                            <input class="form-check-input" type="radio"
                                                                name="landType[]" value="yes" id="landTypeFormYes">
                                                            <label class="form-check-label" for="landTypeFormYes">
                                                                <h6 class="mb-0">Yes</h6>
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="landType[]" value="no" id="landTypeFormNo"
                                                                checked>
                                                            <label class="form-check-label" for="landTypeFormNo">
                                                                <h6 class="mb-0">No</h6>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="landType-container row" id="landTypeContainer"
                                                        style="display: none;">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-6">
                                                                <label for="ConveyanceDate" class="form-label">In
                                                                    possession
                                                                    of</label>
                                                                <select class="form-select" id="TypeLease"
                                                                    name="in_possession_of[]"
                                                                    aria-label="Type of Lease">
                                                                    <option value="" selected>Select</option>
                                                                    <option value="1">DDA</option>
                                                                    <option value="2">NDMC</option>
                                                                    <option value="3">MCD</option>
                                                                </select>
                                                                <span class="text-danger"></span>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label for="dateTransfer" class="form-label">Date of
                                                                    Transfer</label>
                                                                <input type="date" class="form-control"
                                                                    name="date_of_transfer[]" id="dateTransfer">
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="property_status_others">
                                                <div class="col-12 col-lg-12">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mr-2 mb-0">Land Type : Others</h6>
                                                        <div class="form-check mr-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="landTypeOthers[]" value="yes"
                                                                id="landTypeFormOthersYes">
                                                            <label class="form-check-label" for="landTypeFormOthersYes">
                                                                <h6 class="mb-0">Yes</h6>
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="landTypeOthers[]" value="no"
                                                                id="landTypeFormOthersNo" checked>
                                                            <label class="form-check-label" for="landTypeFormOthersNo">
                                                                <h6 class="mb-0">No</h6>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="landType-container row" id="landTypeOthersContainer"
                                                        style="display: none;">

                                                        <div class="col-12 col-lg-4">
                                                            <label for="remarks" class="form-label">Remarks</label>
                                                            <input type="text" class="form-control" id="remarks"
                                                                name="remark[]">
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="dvPropertyStatusHtml" class="row g-3"></div>
                                        <div class="row g-3 mt-5">
                                            <div class="col-12 mt-4">
                                                <div class="d-flex align-items-center gap-3">

                                                    <button type="button" class="btn btn-outline-secondary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i> Previous</button>
                                                    <button type="button" class="btn btn-primary px-4 btn-next-form"
                                                        id="submitButton4">Next <i
                                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                                </div>
                                            </div>
                                        </div>

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
                                                    name="date_of_last_inspection_report[]">
                                                <div id="lastInsReportError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="LastDemandLetter" class="form-label">Date of Last Demand
                                                    Letter</label>
                                                <input type="date" class="form-control"
                                                    name="date_of_last_demand_letter[]" id="LastDemandLetter">
                                                <div id="LastDemandLetterError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="DemandID" class="form-label">Demand ID</label>
                                                <input type="text" class="form-control numericOnly" name="demand_id[]"
                                                    id="DemandID" placeholder="Demand ID">
                                                <div id="DemandIDError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-12">
                                                <label for="amountDemandLetter" class="form-label">Amount of Last Demand
                                                    Letter</label>
                                                <input type="text" name="amount_of_last_demand[]"
                                                    class="numericDecimal form-control" id="amountDemandLetter">
                                                <div id="amountDemandLetterError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="LastAmount" class="form-label">Last Amount Received</label>
                                                <input type="text" class="numericDecimal form-control" id="LastAmount"
                                                    name="last_amount_reveived[]" placeholder="Last Amount Received">
                                                <div id="LastAmountError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="lastamountdate" class="form-label">Date</label>
                                                <input type="date" class="form-control" name="last_amount_date[]"
                                                    id="lastamountdate">
                                                <div id="lastamountdateError" class="text-danger"></div>
                                            </div>

                                        </div>
                                        <div id="dvInspectionDet" class="row g-3"></div>

                                        <!---end row-->
                                        <div class="row g-3 mt-5">
                                            <div class="col-12 mt-4">
                                                <div class="d-flex align-items-center gap-3">

                                                    <button type="button" class="btn btn-outline-secondary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>



                                                    <button type="button" class="btn btn-primary px-4 btn-next-form"
                                                        id="submitButton5">Next<i
                                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="test-vl-6" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger6">
                                        <h5 class="mb-1">MISCELLANEOUS DETAILS</h5>
                                        <p class="mb-4">Please enter Miscellaneous Details</p>

                                        <div class="row g-3">
                                            <div class="col-12 col-lg-12">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">GR Revised Ever</h6>
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="radio" name="GR[]"
                                                            value="1" id="GRFormYes">
                                                        <label class="form-check-label" for="GRFormYes">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="GR[]"
                                                            value="0" id="GRFormNo" checked>
                                                        <label class="form-check-label" for="GRFormNo">
                                                            <h6 class="mb-0">No</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                                @error('GR')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="GR-container" id="GRContainer" style="display: none;">
                                                    <div class="col-12 col-lg-4">
                                                        <label for="GRrevisedDate" class="form-label">Date</label>
                                                        <input type="date" name="gr_revised_date[]" class="form-control form-required"
                                                            id="GRrevisedDate">
                                                            <div class="text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>




                                            <hr>
                                            <div class="col-12 col-lg-12">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">Supplementary Lease Deed Executed</h6>
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="Supplementary[]" value="1" id="SupplementaryFormYes">
                                                        <label class="form-check-label" for="SupplementaryFormYes">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="Supplementary[]" value="0" id="SupplementaryFormNo"
                                                            checked>
                                                        <label class="form-check-label" for="SupplementaryFormNo">
                                                            <h6 class="mb-0">No</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="Supplementary-container row" id="SupplementaryContainer"
                                                    style="display: none;">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6">
                                                            <label for="SupplementaryDate"
                                                                class="form-label">Date</label>
                                                            <input type="date" min="1600-01-01" max="2050-12-31"
                                                                class="form-control form-required" name="supplementary_date[]"
                                                                id="SupplementaryDate">
                                                                <div class="text-danger"></div>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <label for="areaunitname" class="form-label">Area</label>
                                                            <div class="unit-field">
                                                                <div>
                                                                <input type="text" class="form-control numericDecimal form-required"
                                                                id="" name="supplementary_area[]">
                                                                <div class="text-danger"></div>
                                                                </div>
                                                                <div>
                                                                <select class="form-select unit-dropdown" id=""
                                                                    aria-label="Select Unit"
                                                                    name="supplementary_area_unit[]">
                                                                    <option value="" selected="">Select Unit</option>
                                                                    <option value="27">Acre</option>
                                                                    <option value="28">Sq Feet</option>
                                                                    <option value="29">Sq Meter</option>
                                                                    <option value="30">Sq Yard</option>
                                                                    <option value="589">Hectare</option>
                                                                </select>
                                                                <div class="text-danger"></div>
</div>
                                                            </div>
                                                            <div id="selectareaunitError" class="text-danger"></div>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mt-3">
                                                            <label for="premiumunit1" class="form-label">Premium (Re/
                                                                Rs)</label>
                                                            <div class="unit-field">
                                                                <div>
                                                                    <input type="text" class="form-control mr-2 numericOnly form-required"
                                                                    id="" name="supplementary_premium1[]">
                                                                    <div class="text-danger"></div>
                                                                </div>
                                                                <div>
                                                                    <input type="text" class="form-control numericOnly form-required"
                                                                    id="" name="supplementary_premium2[]">
                                                                    <div class="text-danger"></div>
                                                                </div>
                                                                <div>
                                                                    <select class="form-select unit-dropdown form-required"
                                                                    name="supplementary_premium_unit[]" id=""
                                                                    aria-label="Select Unit">
                                                                    <option value="">Unit</option>
                                                                    <option selected="" value="1">Paise</option>
                                                                    <option value="2">Ana</option>
                                                                </select>
                                                                <div class="text-danger"></div>
                                                                </div>
                                                            </div>
                                                            <div id="premiumunit2Error" class="text-danger"></div>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mt-3">
                                                            <label for="groundRent1" class="form-label">Ground Rent (Re/
                                                                Rs)</label>
                                                            <div class="unit-field">
                                                                <div>
                                                                    <input type="text" class="form-control mr-2 numericOnly form-required"
                                                                    id="" name="supplementary_ground_rent1[]">
                                                                    <div class="text-danger"></div>
                                                                </div>
                                                                <div>
                                                                    <input type="text" class="form-control numericOnly form-required"
                                                                    id="" name="supplementary_ground_rent2[]">
                                                                    <div class="text-danger"></div>s
                                                                </div>
                                                                <div>
                                                                    <select class="form-select unit-dropdown form-required" id=""
                                                                    aria-label="Select Unit"
                                                                    name="supplementary_ground_rent_unit[]">
                                                                    <option value="">Unit</option>
                                                                    <option selected="" value="1">Paise</option>
                                                                    <option value="2">Ana</option>
                                                                </select>
                                                                <div class="text-danger"></div>
                                                                </div>
                                                            </div>
                                                            <!-- <div id="" class="text-danger"></div> -->
                                                        </div>
                                                    </div>

                                                    <div class="row mt-4 mb-3">
                                                        <div class="col-12 col-lg-12">
                                                            <label for="SupplementaryRemark"
                                                                class="form-label">Remark</label>
                                                            <textarea id="SupplementaryRemark" class="form-required"
                                                                name="supplementary_remark[]" rows="4"
                                                                style="width: 100%;"></textarea>
                                                                <div class="text-danger"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>


                                            <!-- <div class="col-12 col-lg-12">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">Supplementary Lease Deed Executed</h6>
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="Supplementary[]" value="1" id="SupplementaryFormYes">
                                                        <label class="form-check-label" for="SupplementaryFormYes">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="Supplementary[]" value="0" id="SupplementaryFormNo"
                                                            checked>
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
                                                            <label for="SupplementaryDate"
                                                                class="form-label">Date</label>
                                                            <input type="date" class="form-control"
                                                                name="supplementary_date[]" id="SupplementaryDate">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->



                                            <div class="col-12 col-lg-12">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">Re-entered</h6>
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="radio" name="Reentered[]"
                                                            value="1" id="ReenteredFormYes">
                                                        <label class="form-check-label" for="ReenteredFormYes">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="Reentered[]"
                                                            value="0" id="ReenteredFormNo" checked>
                                                        <label class="form-check-label" for="ReenteredFormNo">
                                                            <h6 class="mb-0">No</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                                @error('Reentered')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="Reentered-container row" id="ReenteredContainer"
                                                    style="display: none;">

                                                    <div class="col-12 col-lg-4">
                                                        <label for="reentryDate" class="form-label">Date of
                                                            re-entry</label>
                                                        <input type="date" class="form-control form-required" id="reentryDate"
                                                            name="date_of_reentry[]">
                                                            <div class="text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="miscellDetailsHtml" class="row g-3"></div>
                                        <div class="row g-3 mt-5">
                                            <div class="col-12 mt-4">
                                                <div class="d-flex align-items-center gap-3">

                                                    <button type="button" class="btn btn-outline-secondary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>

                                                    <button type="button" id="submitButton6"
                                                        class="btn btn-primary px-4 btn-next-form">Next<i
                                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="test-vl-7" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger7">
                                        <h5 class="mb-1">Latest Contact Details</h5>
                                        <p class="mb-4">Please enter Latest Contact Details</p>
                                        <div class="row g-3">
                                            <div class="col-12 col-lg-4">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" name="address[]" class="form-control" id="address"
                                                    placeholder="Address">
                                                @error('address')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="addressError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="phoneno" class="form-label">Phone No.</label>
                                                <input type="text" name="phone[]" class="form-control" id="phoneno"
                                                    placeholder="Phone No." maxlength="10">
                                                <div id="phonenoError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="Email" class="form-label">Email</label>
                                                <input type="email" name="email[]" class="form-control" id="Email"
                                                    placeholder="Email">
                                                <div id="EmailError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="asondate" class="form-label">As on Date</label>
                                                <input type="date" name="date[]" class="form-control" id="asondate">
                                                <div id="asondateError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="additional_remark" class="form-label">Remark</label>
                                                <input type="input" name="additional_remark" placeholder="remark"
                                                    class="form-control" id="additional_remark">
                                            </div>
                                            <div class="col-lg-3 d-flex align-items-end">
                                                <div class="form-check d-flex gap-2">
                                                    <input class="form-check-input" type="checkbox" name="alert_flag"
                                                        value="1" id="flexCheckCheckedDanger">
                                                    <label class="form-check-label" for="flexCheckCheckedDanger">
                                                        Is Problemetic
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="plotcontactDetails" class="row g-3"></div>
                                        <div class="row g-3 mt-5">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center gap-3">
                                                    <!-- <button class="btn btn-primary px-4" onclick="stepper3.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button> -->
                                                    <button type="button" class="btn btn-outline-secondary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                                    <button type="button" class="btn btn-primary px-4"
                                                        id="btnfinalsubmit">Submit</button>
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
    <script src="{{asset('assets/js/multipleForm/repeaterPlot.js')}}"></script>
    <script src="{{asset('assets/plugins/form-repeater/repeater.js')}}"></script>
    <script src="{{asset('assets/plugins/form-repeater/repeater2.js')}}"></script>
    <script src="{{asset('assets/plugins/form-repeater/repeaterChild.js')}}"></script>
    <script src="{{asset('assets/js/multipleForm/mis.js')}}"></script>
    <script src="{{ asset('assets/js/multipleForm/masterMis.js') }}"></script>

    <script src="{{asset('assets/js/multipleForm/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/multipleForm/jquery.repeater.min.js')}}"></script>
    <script>
        //for check PID of plots exists in database or not - Sourav Chauhan (31 july 2024)
        $('#repeaterjointproperty').on('change','.plotPropId', function() {
            var $input = $(this);
            var inputValue = $input.val();
            
            // Find the closest parent `.item-content` or `.items` to ensure we're targeting the correct section
            var $parentItem = $input.closest('.items');
            
            // Find the error message container within this parent
            var $messageContainer = $parentItem.find('.childPidDanger');

            var plotUniqueId = $(this).attr('id');
            var inputValue = $(this).val();
            if(inputValue){
                $.ajax({
                    url: "{{route('isPropertyAvailable')}}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        property_id: inputValue,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        if (response.status === true) {
                            $messageContainer.hide()
                        } else if (response.status === false) {
                            var url = ''
                            if(response.data.location == 'parent'){
                                url = 'property-details/'+response.data.id+'/view';

                            } else {

                                url = 'property-details/child/'+response.data.id
                            }
                            $messageContainer.show()
                            $messageContainer.html(response.message+' <a target="_blank" href='+url+'><i class="fadeIn animated bx bx-info-circle"></i></a>')
                        }
                    },
                    error: function (response) {
                        console.log(response);
                    }

                })

            }
            
        });
        //END

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


        // Tabs
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        $(document).ready(function () {
            var $alertElement = $('.alert');
            if ($alertElement.length) {
                setTimeout(function () {
                    $alertElement.fadeOut();
                }, 3000);
            }
        });
    </script>
@endsection