@extends('layouts.app')
@section('title', isset($grievance) ? 'Edit Public Grievance' : 'Create Public Grievance')

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Public Grievances</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ isset($grievance) ? 'Edit Grievance' : 'Create New Grievance' }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-end py-3">
            <a href="{{ url('public-services/grievances') }}">
                <button type="button" class="btn btn-dark px-2 mx-2">← Back</button>
            </a>
        </div>
        <!-- Form to Save Initial Data -->
        <form id="grievanceForm" action="{{ isset($grievance) ? route('grievance.update', $grievance->id) : route('grievance.storeInitial') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($grievance))
                @method('PUT')
            @endif
            <div id="grievanceForm" class="grievanceForm m-3" style="border: 1px solid #ddd; padding: 5px; margin-bottom: 10px; border-radius: 5px;">
                <!-- User Information Fields -->
                <div class="row m-3">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fullname" class="form-label">Name<span class="text-danger">*</span> </label>
                            <input type="text" name="name" class="form-control alpha-only" id="fullname" value="{{ old('name', $grievance->name ?? '') }}">
                            <div id="fullnameError" class="text-danger text-left"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mobile" class="form-label">Mobile<span class="text-danger">*</span></label>
                            <div class="mix-field d-flex">
                                @if (!empty($countries) && count($countries) > 0)
                                    <select name="countryCode" id="grievance_countryCode" class="form-select prefix" style="width:30%">
                                        <option value="">Select</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->phonecode }}"
                                                @if ($country->phonecode == 91) @selected(true) @endif>
                                                {{ $country->iso2 }} (+{{ $country->phonecode }})
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                                <div class="form-box relative-input" style="width:70%">
                                    <input type="text" name="mobile" id="mobile" maxlength="10" 
                                        class="form-control numericOnly" 
                                        value="{{ old('mobile', $grievance->mobile ?? '') }}" 
                                        placeholder="Mobile Number">
                                    
                                </div>
                            </div>
                            <div id="mobileError" class="text-danger text-left"></div>
                            <div id="countryCodeError" class="text-danger text-left"></div>
                        </div>
                    </div>

                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $grievance->email ?? '') }}"> 
                            <div id="emailError" class="text-danger text-left"></div>
                        </div>
                    </div>
                </div>  

                <!-- Property Details -->
                <div class="row m-3">
                    <div class="col-lg-12">
                        <h6 class="text-start mb-0">Property Details</h6>
                    </div>
                </div>
                <div class="row m-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="localityFill" class="form-label">Locality<span class="text-danger">*</span></label>
                            <select name="localityFill" id="localityFill" class="form-select">
                                <option value="">Select Locality</option>
                                @foreach($colonyList as $colony)
                                    <option value="{{ $colony->id }}" {{ (isset($grievance) && $grievance->colony == $colony->id) ? 'selected' : '' }}>
                                        {{ $colony->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="localityFillError" class="text-danger text-left"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="property_id" class="form-label">Property ID</label>
                            <input type="text" name="property_id" id="property_id" maxlength="5" class="form-control numericOnly" value="{{ old('property_id', $grievance->old_property_id ?? '') }}">
                            <div id="propertyIdError" class="text-danger text-left"></div>
                        </div>
                    </div>
                       
                </div>

                

                <!-- Description Text Box -->
                <div class="row m-3">
                     
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $grievance->description ?? '') }}</textarea>
                            <div id="descriptionError" class="text-danger text-left"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="comm_address" class="form-label">Communication Address<span class="text-danger">*</span></label>
                            <textarea name="comm_address" id="comm_address" class="form-control" rows="4"> {{ old('comm_address', default: $grievance->communication_address ?? '') }}</textarea>
                            <div id="addressError" class="text-danger text-left"></div> 
                        </div>
                    </div>
                </div>

                <!-- Conditional Recording Upload or Display for Edit Mode -->
                    @if(isset($grievance))
                    <div class="row m-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                @if($grievance->recording)
                                    <label for="recording" class="form-label">Current Recording:</label>
                                    <p>{{ basename($grievance->recording) }}</p> <!-- Display the file name -->
                                @else
                                    <label for="recording" class="form-label">Upload Recording</label>
                                    <input type="file" name="recording" id="recording" class="form-control" accept="audio/*">
                                    <div id="recordingError" class="text-danger text-left"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                <!-- Proceed Button -->
                <!-- <button type="button" class="btn btn-primary mx-4 mb-4 mt-2" id="ProceedButton">{{ isset($grievance) ? 'Update' : 'Proceed' }}</button> -->
                <button type="button" class="btn btn-primary mx-4 mb-4 mt-2" id="ProceedButton"
                    data-processing-text="{{ isset($grievance) ? 'Updating...' : 'Proceeding...' }}">
                    {{ isset($grievance) ? 'Update' : 'Proceed' }}
                </button>
            </div>
        </form>
    </div>
</div>

@include('admin_public_grievances.recordingUpload')

<!-- JavaScript to Open Modal if Session Data is Set -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('open_modal'))
            const recordingModal = new bootstrap.Modal(document.getElementById('recordingModal'));
            recordingModal.show();
        @endif
    });
</script>
@endsection
@section( 'footerScript')
<script src="{{asset(path: 'assets/js/grievance.js')}}"></script>
@endsection
