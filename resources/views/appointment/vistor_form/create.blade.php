@extends('layouts.public.app')
@section('title', 'L&DO Visitor Appointment')

@section('content')
<div class="login-8">
    <div class="container">
        <div class="row login-box">
            @if (session('success'))
                <div class="alert alert-success border-0 bg-success alert-dismissible">
                    <div class="text-white">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('failure'))
                <div class="alert alert-danger border-0 bg-danger alert-dismissible">
                    <div class="text-white">{{ session('failure') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif 

            <div class="card">
                <div class="card-body">
                    <div id="appointment">
                        <style>
                            .form-group {
                                width: 100%;
                                position: relative;
                                margin: 12px 0px;
                            }
                            
                            .login-8 .ocean {
                                z-index: -1;
                            }
                            .radio-options label {
                                margin-right: 45px;
                                margin-bottom: 0; 
                            }

                            .form-box .form-label {
                                margin-right: 40px;
                                margin-bottom: 0; 
                            }
                            .flatpickr-disabled {
                                background-color: #6c757d40 !important;
                                color: #0000004f !important;
                            }
                            .available-date {
                                background-color: #1c8b36 !important;
                                color: #fff !important;
                            }
                            .fully-booked-date {
                                background-color: #dc3545ba !important;
                                color: #fff !important;
                            }
                            .holiday-date {
                                background-color: #a60505 !important; /* Orange */
                                color: #fff !important;
                            }
                            .dayContainer {
                                gap: 2px;
                                padding: 10px;
                            }
                            .flatpickr-day {
                                border-radius: 2px !important;
                            }
                            /* Legend styling */
                            .calendar-legend {
                                display: flex;
                                gap: 20px;
                                font-size: 14px;
                                margin-top: 10px;
                            }
                            .legend-item {
                                display: flex;
                                align-items: center;
                            }
                            .legend-color {
                                display: inline-block;
                                width: 15px;
                                height: 15px;
                                border-radius: 2px;
                                margin-right: 8px;
                            }
                            .available-color {
                                background-color: #1c8b36; /* Match the available-date color */
                            }
                            .fully-booked-color {
                                background-color: #dc3545ba; /* Match the fully-booked-date color */
                            }
                            .holiday-color {
                                background-color: #a60505; /* Match the available-date color */
                            }

                        </style>
                        
                        <h3 class="mb-3 form_inner_head-center text-center" style="font-weight: 400;">L&DO Visitor Appointment Form</h3>
                        <hr/>

                        <!-- Start of the Form -->
                        <form action="{{ route('appointmentStore') }}" method="POST" enctype="multipart/form-data" id="appointment_form">
                            @csrf
                            <div id="app_appointmentForm">
                                <div class="row less-padding-input mt-4">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-box">
                                            <label for="app_fullname" class="quesLabel">Full Name<span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control alpha-only" placeholder="Full Name" id="app_fullname">
                                            <div id="app_fullnameError" class="text-danger text-left"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label for="app_mobile" class="quesLabel">Mobile Number<span class="text-danger">*</span></label>
                                            <div class="mix-field">
                                                @if (!empty($countries) && count($countries) > 0)
                                                    <select name="countryCode" id="app_countryCode"
                                                        class="form-select prefix">
                                                        <!-- <option value="">Select</option> -->
                                                        
                                                        @foreach ($countries as $country)
                                                            @if ($country->phonecode == 91)
                                                                <option value="{{ $country->phonecode }}"
                                                                    @if ($country->phonecode == 91) @selected(true) @endif>
                                                                    {{ $country->iso2 }} (+{{ $country->phonecode }})
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    
                                                @endif
                                                <div class="form-box relative-input" style="width:70%">
                                                    <input type="text" name="mobile" data-id="0" id="app_mobile" maxlength="10" class="form-control numericOnly" placeholder="Mobile Number">
                                                    <a href="javascript:void(0);" class="verify_otp"
                                                        id="verify_app_mobile_otp">Verify</a>
                                                    <img src="{{ asset('assets/frontend/assets/img/Green-check-mark-icon2.png') }}"
                                                        id="app_green-tick-icon"
                                                        style="
                                                    width: 28px;
                                                    position: absolute;
                                                    right: 12px;
                                                    top: 10px;
                                                    display:none;
                                                " />
                                                    <div class="loader" id="app_mobile_loader"></div> 
                                                        
                                                </div>
                                            </div>
                                            
                                        </div>
                                            <div id="app_mobileError" class="text-danger text-left" style="margin-top: -12px;"></div>
                                            <div id="app_countryCodeError" class="text-danger text-left" style="margin-top: -12px;"></div>
                                            <div class="text-danger text-start" id="verify_app_mobile_otp_error"></div>
                                            <div class="text-success text-start" id="verify_app_mobile_otp_success"></div>       
                                    </div>
                                    
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label for="app_email" class="quesLabel">Email Address<span class="text-danger">*</span></label>
                                            <div class="form-box relative-input">
                                                <input type="email" name="email" data-id="0" id="app_email" class="form-control" placeholder="Email Address">
                                                <a href="javascript:void(0);" class="verify_otp"
                                                    id="verify_app_email_otp">Verify</a>
                                                <img src="{{ asset('assets/frontend/assets/img/Green-check-mark-icon2.png') }}"
                                                    id="app_green-tick-icon-email"
                                                    style="
                                                width: 28px;
                                                position: absolute;
                                                right: 12px;
                                                top: 10px;
                                                display:none;
                                                " />
                                                <div class="loader" id="app_email_loader"></div>
                                            </div>
                                        </div>
                                        
                                        <div id="app_emailError" class="text-danger text-left" style="margin-top: -12px;"></div> 
                                        <div class="text-danger text-start" id="verify_app_email_otp_error"></div>
                                        <div class="text-success text-start" id="verify_app_email_otp_success"></div>
                                    </div>
                                    
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-box">
                                            <label for="app_pan_number" class="quesLabel">Pan Number<span class="text-danger">*</span></label>
                                            <input type="text" name="pan_number" id="app_pan_number" class="form-control text-transform-uppercase pan_number_format" placeholder="Pan Number" maxlength="10">
                                            <div id="app_panNumberError" class="text-danger text-left"></div>
                                        </div>
                                    </div>
                                </div>

                                <div id="app_ifYesNotChecked">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class=" form-group">
                                                <label for="app_locality" class="quesLabel">Locality<span class="text-danger">*</span></label>
                                                <select name="locality" id="app_locality" class="form-select">
                                                    <option value="">Select</option>
                                                    @foreach($colonyList as $colony)
                                                        <option value="{{ $colony->id }}">{{ $colony->name }}</option>
                                                    @endforeach
                                                </select>
                                            
                                                <div id="app_localityError" class="text-danger text-left"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <label for="app_block" class="quesLabel">Block<span class="text-danger">*</span></label>
                                                <select name="block" id="app_block" class="form-select">
                                                    <option value="">Select</option>
                                                </select>
                                                <div id="app_blockError" class="text-danger text-left"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class=" form-group">
                                                <label for="app_plot" class="quesLabel">Plot<span class="text-danger">*</span></label>
                                                <select name="plot" id="app_plot" class="form-select">
                                                    <option value="">Select</option>
                                                </select>
                                                <div id="app_plotError" class="text-danger text-left"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class=" form-group">
                                                <label for="app_knownas" class="quesLabel">Known As (Optional)</label>
                                                <select name="known_as" id="app_knownas" class="form-select">
                                                    <option value="">Known As</option>
                                                </select>
                                                <div id="app_knownasError" class="text-danger text-left"></div>
                                            </div>
                                        </div>
                                    </div>                                 
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group form-box">
                                            <div class="mix-field">
                                                <label for="propertyId_property" class="quesLabel">Is property details not found in the above list?</label>
                                                <div class="radio-options ml-5">
                                                    <label for="app_Yes">
                                                        <input type="checkbox" name="propertyId" value="1" class="form-check" id="app_Yes"> Yes</label>
                                                </div>
                                            </div>
                                        
                                            <div class="ifyes internal_container my-2" id="app_ifyes" style="display: none;">
                                                <div class="container-fluid">
                                                    <div class="row less-padding-input">
                                                        <div class="col-lg-6 col-12">
                                                            <div class="form-group form-box">
                                                                <label for="app_localityFill" class="quesLabel">Locality<span class="text-danger">*</span></label>
                                                                <select name="localityFill" id="app_localityFill" class="form-select">
                                                                    <option value="">Select</option>
                                                                    @foreach($colonyList as $colony)
                                                                        <option value="{{ $colony->id }}">{{ $colony->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div id="app_localityFillError" class="text-danger text-left"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                            <div class="form-group form-box">
                                                                <label for="app_blocknoFill" class="quesLabel">Block No.<span class="text-danger">*</span></label>
                                                                <input type="text" name="blocknoFill" id="app_blocknoFill" class="form-control alphaNum-hiphenForwardSlash" placeholder="Block No.">
                                                                <div id="app_blocknoFillError" class="text-danger text-left"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                            <div class="form-group form-box">
                                                                <label for="app_plotnoFill" class="quesLabel">Property/Plot No.<span class="text-danger">*</span></label>
                                                                <input type="text" name="plotnoFill" id="app_plotnoFill" class="form-control plotNoAlpaMix" placeholder="Property/Plot No.">
                                                                <div id="app_plotnoFillError" class="text-danger text-left"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                            <div class="form-group form-box">
                                                                <label for="app_knownasFill" class="quesLabel">Known As (Optional)</label>
                                                                <input type="text" name="knownasFill" id="app_knownasFill" class="form-control alpha-only" placeholder="Known As">
                                                                <div id="app_knownasFillError" class="text-danger text-left"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group form-box">
                                            <div class="mix-field">
                                                <label for="stakeholderQuestion" class="quesLabel">Are you a Stakeholder?</label>
                                                <div class="radio-options ml-5">
                                                    <label for="app_isStakeholder">
                                                        <input type="checkbox" name="isStakeholder" value="1" class="form-check" id="app_isStakeholder"> Yes
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="ifStakeholder internal_container my-2" id="app_ifStakeholder" style="display: none;">
                                                <div class="container-fluid">
                                                    <div class="row less-padding-input">
                                                        <div class="col-lg-12 col-12">
                                                            <div class="form-group form-box">
                                                                <label for="stakeholderProof" class="form-label">Upload document: (Proof Of Stakeholder)</label>
                                                                <input type="file" name="stakeholderProof" id="app_stakeholderProof" class="form-control">
                                                                <div id="app_stakeholderProofError" class="text-danger text-left"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group form-box">
                                            <label for="app_natureOfVisit" class="quesLabel">Nature of Visit<span class="text-danger">*</span></label>
                                            <select name="natureOfVisit" id="app_natureOfVisit" class="form-select">
                                                <option value="">Select</option>
                                                <option value="Online">Online</option>
                                                <option value="Offline">Offline</option>
                                            </select>
                                            <div id="app_natureOfVisitError" class="text-danger text-left"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group form-box">
                                            <label for="app_meetingPurpose" class="quesLabel">Meeting Purpose<span class="text-danger">*</span></label>
                                            <select name="meetingPurpose" id="app_meetingPurpose" class="form-select">
                                                <option value="">Select</option>
                                                @foreach($meetingPurposes as $purpose)
                                                    <option value="{{ $purpose }}">{{ $purpose }}</option>
                                                @endforeach
                                            </select>
                                            <div id="app_meetingPurposeError" class="text-danger text-left"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12" id="app_meetingDescriptionDiv" style="display: none;">
                                        <div class="form-group form-box">
                                            <label for="app_meetingDescription" class="quesLabel">Describe your meeting concern in brief<span class="text-danger">*</span></label>
                                            <textarea name="meetingDescription" id="app_meetingDescription" class="form-control" placeholder="Describe your meeting concern in brief" maxlength="255"></textarea>
                                            <div id="app_meetingDescriptionError" class="text-danger text-left"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group form-box">
                                            <label for="app_appointment_date" class="quesLabel">Select an Appointment Date<span class="text-danger">*</span></label>
                                            <input type="text" name="appointmentDate" id="app_appointment_date" class="form-control" placeholder="Select an appointment date">
                                            <div id="app_appointmentDateError" class="text-danger text-left"></div>
                                            <!-- Calendar color legend -->
                                            <div class="calendar-legend mt-3">
                                                <div class="legend-item">
                                                    <span class="legend-color available-color"></span> Available Dates
                                                </div>
                                                <div class="legend-item">
                                                    <span class="legend-color fully-booked-color"></span> Fully Booked Dates
                                                </div>
                                                <div class="legend-item">
                                                    <span class="legend-color holiday-color"></span> Holidays
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12" id="app_timeSlotDiv" style="display: none;">
                                        <div class="form-group form-box">
                                            <label for="app_meeting_time" class="quesLabel">Select a Time Slot<span class="text-danger">*</span></label>
                                            <select name="meetingTime" id="app_meeting_time" class="form-select">
                                                <option value="">Select</option>
                                            </select>
                                            <div id="app_meetingTimeError" class="text-danger text-left"></div>
                                        </div>
                                    </div>
                                </div>

                            
                                <button type="button" class="btn btn-primary btn-lg btn-theme mt-4" id="app_AppointmentSubmitButton">Submit</button>
                            </div>
                            
                        </form>
                        <!-- End of the Form -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ocean">
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
</div>

@include('appointment.vistor_form.otp')
@endsection

@section('footerScript')
<script src="{{asset('assets/frontend/assets/js/appointment-validation.js')}}"></script>

<script>
         function isValidMobile(mobile) {
            var mobilePattern = /^[0-9]{10}$/;
            return mobilePattern.test(mobile);
        }

        function isValidEmail(email) {
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
        }
    //SwatiMishra for Appointment
    $(document).ready(function() {
        $('#app_Yes').change(function() {
            if ($(this).is(':checked')) {
                $('#app_ifyes').show();
                $('#app_locality').val('')
                $('#app_block').val('')
                $('#app_plot').val('')
                $('#app_knownas').val('')
                $('#app_ifYesNotChecked').hide();
            } else {
                $('#app_localityFill').val('')
                $('#app_blocknoInvFill').val('')
                $('#app_plotnoInvFill').val('')
                $('#app_knownasInvFill').val('')
                $('#app_ifyes').hide();
                $('#app_ifYesNotChecked').show();
            }
        });

    });

    //SwatiMishra
    //get all blocks of selected locality
    $('#app_locality').on('change', function () {
        var locality = this.value;
        $("#app_block").html('');
        $.ajax({
            url: "{{route('localityBlocks')}}",
            type: "POST",
            data: {
                locality: locality,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                $('#app_block').html('<option value="">Select</option>');
                $.each(result, function (key,value) {
                    $("#app_block").append('<option value="' + value.block_no + '">' + value.block_no + '</option>');
                });
            }
        });
    });

    //get all plots of selected block
    $('#app_block').on('change', function () {
        var locality = $('#app_locality').val();
        var block = this.value;
        $("#app_plot").html('');
        $.ajax({
            url: "{{route('blockPlots')}}",
            type: "POST",
            data: {
                locality: locality,
                block: block,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                // console.log(result);
                $('#app_plot').html('<option value="">Select Plot</option>');
                $.each(result, function (key,value) {
                    
                    $("#app_plot").append('<option value="' + value + '">' + value + '</option>');
                });
            }
        });
    });

    //get known as of selected plot
    $('#app_plot').on('change', function () {
        var locality = $('#app_locality').val();
        var block = $('#app_block').val();
        var plot = this.value;
        $("#app_knownas").html('');
        $.ajax({
            url: "{{route('plotKnownas')}}",
            type: "POST",
            data: {
                locality: locality,
                block: block,
                plot: plot,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                // console.log(result);
                $('#app_knownas').html('<option value="">Select</option>');
                
                $.each(result, function (key,value) {
                    
                    $("#app_knownas").append('<option value="' + value + '">' + value + '</option>');
                });
            }
        });
    });

    
    
   //Swati Mishra Appointment Form
    //for verifying mobile
        $('#verify_app_mobile_otp').click(function () {
        console.log('called');
        var mobile = $('#app_mobile').val().trim();
        var countryCode = $('#app_countryCode').val().trim(); // Get country code
        var emailToVerify = $('#app_email').val().trim();
        var errorDiv = $('#verify_app_mobile_otp_error');
        var successDiv = $('#verify_app_mobile_otp_success');

        errorDiv.html(''); // Clear previous errors

        if (mobile == '' && countryCode == '') {
            errorDiv.html('Country code & Mobile number is required')
        } else if (countryCode === '') {
            errorDiv.html('Country code is required');
        } else if (mobile === '') {
            errorDiv.html('Mobile number is required');
        } else if (!isValidMobile(mobile)) {
            errorDiv.html('Invalid mobile number');
        } else {
            $('#verify_app_mobile_otp').hide();
            $('#app_mobile_loader').show();

            // AJAX request to generate OTP
            $.ajax({
                url: "{{route('saveAptOtp')}}",
                type: "POST",
                data: {
                    emailToVerify: emailToVerify,
                    countryCode: countryCode, // Include country code
                    mobile: mobile,
                    _token: '{{csrf_token()}}',
                },
                dataType: 'json',
                success: function (result) {
                    $('#verify_app_mobile_otp').show();
                    $('#app_mobile_loader').hide();

                    if (result.success) {
                        errorDiv.html('');
                        successDiv.html(result.message);
                        $('#appOtpMobile').modal("show");
                    } else {
                        successDiv.html('');
                        errorDiv.html(result.message);
                    }
                },
                error: function () {
                    $('#verify_app_mobile_otp').show();
                    $('#app_mobile_loader').hide();
                    errorDiv.html('An error occurred. Please try again.');
                },
            });
        }
    });


        //for verifying email
            $('#verify_app_email_otp').click(function() {
                var email = $('#app_email').val().trim();
                var countryCode = $('#app_countryCode').val().trim(); // Get country code
                var mobileToVerify = $('#app_mobile').val().trim();
                var errorDiv = $('#verify_app_email_otp_error');
                var successDiv = $('#verify_app_email_otp_success');
                if(email == ''){
                    errorDiv.html('Email is required')
                } else if (!isValidEmail(email)) {
                    errorDiv.html('Invalid Email');
                } else {
                    $('#verify_app_email_otp').hide();
                    $('#app_email_loader').show();
                    $.ajax({
                        url: "{{route('saveAptOtp')}}",
                        type: "POST",
                        data: {
                            email: email,
                            countryCode: countryCode, // Include country code
                            mobileToVerify: mobileToVerify,
                            _token: '{{csrf_token()}}'
                        },
                        dataType: 'json',
                        success: function (result) {
                            if(result.success){
                                $('#verify_app_email_otp').show();
                                $('#app_email_loader').hide();
                                errorDiv.html('')
                                successDiv.html(result.message)
                                $('#appOtpEmail').modal("show")
                                
                                // $("#otpMobile").css("display", "block");
                            } else {
                                $('#verify_app_email_otp').show();
                                $('#app_email_loader').hide();
                                successDiv.html('')
                                errorDiv.html(result.message)
                            }
                        }
                    });
                }
            });


        $("#appVerifyMobileOtpBtn").click(function () {
        var otpDigits = [];
        var verifyMobileBtn = $('#verify_app_mobile_otp');
        var mobileVerifyErrorDiv = $('#appMobileOptVerifyError');
        var mobileVerifySuccessDiv = $('#appMobileOptVerifySuccess');
        var errorDiv = $('#verify_app_mobile_otp_error');
        var successDiv = $('#verify_app_mobile_otp_success');
        $(".app_mobile_otp_input").each(function () {
            otpDigits.push($(this).val());
        });
        var mobileOtp = otpDigits.join('');
        var mobile = $('#app_mobile').val().trim();
        var countryCode = $('#app_countryCode').val().trim(); // Get country code

        mobileVerifyErrorDiv.html(''); // Clear previous errors

        if (countryCode === '') {
            mobileVerifyErrorDiv.html('Country code is required');
        } else if (mobile === '' || !isValidMobile(mobile)) {
            mobileVerifyErrorDiv.html('Invalid mobile number');
        } else if (mobileOtp === '') {
            mobileVerifyErrorDiv.html('Please enter OTP');
        } else {
            // AJAX request to verify OTP
            $.ajax({
                url: "{{route('verifyAptOtp')}}",
                method: 'POST',
                data: {
                    mobileOtp: mobileOtp,
                    mobile: mobile,
                    countryCode: countryCode, // Include country code
                    _token: '{{csrf_token()}}',
                },
                success: function (response) {
                    if (response.success) {
                        verifyMobileBtn.hide();
                        errorDiv.html('');
                        successDiv.html('');
                        mobileVerifyErrorDiv.html('');
                        $("#app_mobile").prop("readonly", true);
                        $('#app_green-tick-icon').css("display", "block");
                        $('#app-otp-form')[0].reset();
                        mobileVerifySuccessDiv.html(response.message);
                        $('#appOtpMobile').modal("hide");
                        var Indmobile = document.getElementById('app_mobile');
                        Indmobile.setAttribute('data-id', '1');
                    } else {
                        mobileVerifySuccessDiv.html('');
                        mobileVerifyErrorDiv.html(response.message);
                    }
                },
                error: function () {
                    mobileVerifySuccessDiv.html('');
                    mobileVerifyErrorDiv.html('An error occurred. Please try again.');
                },
            });
        }
    });



    $("#appVerifyEmailOtpBtn").click(function() {
        var otpDigits = [];
        var verifyMobileBtn =  $('#verify_app_email_otp')
        var emailVerifyErrorDiv = $('#appEmailOptVerifyError');
        var emailVerifySuccessDiv = $('#appEmailOptVerifySuccess');
        var errorDiv = $('#verify_app_email_otp_error');
        var successDiv = $('#verify_app_email_otp_success');
        $(".app_otp_input_email").each(function() {
            otpDigits.push($(this).val());
        });
        var emailOtp = otpDigits.join('');
        var email = $('#app_email').val();
        
        if(email != '' && emailOtp !=''){
            $.ajax({
                url: "{{route('verifyAptOtp')}}",
                method: 'POST',
                data: {
                    emailOtp: emailOtp,
                    email: email,
                    _token: '{{csrf_token()}}'
                },
                success: function(response) {
                    if(response.success){
                        verifyMobileBtn.hide()
                        errorDiv.html('')
                        successDiv.html('')
                        emailVerifyErrorDiv.html('')
                        $("#app_email").prop("readonly", true);
                        $('#app_green-tick-icon-email').css("display", "block");
                        $('#app-otp-form-email')[0].reset();
                        emailVerifySuccessDiv.html(response.message)
                        $('#appOtpEmail').modal("hide")
                        var emailInv = document.getElementById('app_email');
                        emailInv.setAttribute('data-id', '1');
                    } else {
                        emailVerifySuccessDiv.html('')
                        emailVerifyErrorDiv.html(response.message)
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle error response (e.g., show error message)
                    alert('Error verifying OTP');
                }
            });
        } else {
            emailVerifySuccessDiv.html('')
            emailVerifyErrorDiv.html('Please enter Otp')
        }

    });

$(document).on('click', '#reSentAptOtpMobileBtn', function(event) {
    handleResendOtp(event, 'mobile');
});

$(document).on('click', '#reSentAptOtpEmailBtn', function(event) {
    handleResendOtp(event, 'email');
});

// Function to handle OTP resending for all cases
function handleResendOtp(event, type) {
    event.preventDefault(); // Prevent default behavior
    console.log(`Resend OTP triggered for ${type}.`);

    let additionalData = {};
    switch (type) {
        case 'mobile':
            additionalData = {
                countryCode: $('#app_countryCode').val(),
                mobile: $('#app_mobile').val().trim(),
            };
            break;
        case 'email':
            additionalData = {
                email: $('#app_email').val().trim(),
            };
            break;
    }

    const successMessageElem = $(`#${type}ResendAptOptSuccess`);
    const errorMessageElem = $(`#${type}ResendAptOptError`);

    // Clear previous messages
    successMessageElem.html('');
    errorMessageElem.html('');

    // AJAX request to resend OTP
    fetch('/resend-apt-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify(additionalData),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                console.log('Resend OTP success:', data.message);
                successMessageElem.html(data.message);
                startTimer(type, {{ config('constants.OTP_EXPIRY_TIME') * 60 }});
                setTimeout(() => successMessageElem.html(''), 3000);
            } else {
                console.error('Resend OTP failed:', data.message);
                errorMessageElem.html(data.message);
                setTimeout(() => errorMessageElem.html(''), 3000);
            }
        })
        .catch((error) => {
            console.error('Resend OTP error:', error);
            errorMessageElem.html('An error occurred. Please try again.');
            setTimeout(() => errorMessageElem.html(''), 3000);
        });
}

// Unified timer function for all types
function startTimer(type, duration) {
    let timer = duration;
    const timerContainer = document.getElementById(`otpTimerContainerApt${capitalize(type)}`);
    const timerDisplay = document.getElementById(`otpTimerApt${capitalize(type)}`);
    const resendBtn = document.getElementById(`reSentAptOtp${capitalize(type)}Btn`);

    timerContainer.style.display = 'block';
    resendBtn.style.pointerEvents = 'none'; // Disable link

    const interval = setInterval(() => {
        timerDisplay.textContent = parseInt(timer % 60, 10);
        if (--timer < 0) {
            clearInterval(interval);
            resendBtn.style.pointerEvents = 'auto'; // Enable link
            timerContainer.style.display = 'none';
        }
    }, 1000);
}


// Helper function to capitalize type names
function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}



    
</script>
@endsection
