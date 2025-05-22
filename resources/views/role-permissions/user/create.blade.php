@extends('layouts.app')

@section('title', 'Add User')

<style>
    .mix-field {
        display: flex;
        align-items: center;
    }

    .mix-field .prefix {
        width: 30% !important;
        border-right: 0px;
    }

    .custom-dropdown {
        height: 400px !important;
        overflow-y: auto;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')
    <!--Breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Settings</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">Application Configuration</li>
                    <li class="breadcrumb-item">User</li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End -->
    <div>
        <div class="col pt-3">
            <div class="card">
                <div class="card-body">
                    <form id="userForm" action="{{ route('users.store') }}" method="POST" onsubmit="submitForm(event)">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Name"
                                    value="{{ old('name') }}" required>
                                <div id="nameError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                                    value="{{ old('email') }}" required>
                                <div id="emailError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Password" value="{{ old('password') }}" required>
                                <div id="passwordError" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-4 pb-4">
                                <div class="form-group">
                                    <label for="emp_code" class="form-label">Mobile</label>
                                    <div class="mix-field">
                                        @if (!empty($countries) && count($countries) > 0)
                                            <select name="countryCode" id="countryCode" class="form-select prefix">
                                                {{-- <option value="">Select</option> --}}
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
                                        <div class="form-box relative-input" style="width: 70%;">
                                            <input type="text" name="mobile_no" data-id="0" id="mobile_no"
                                                maxlength="10" class="form-control numericOnly" placeholder="Mobile Number">
                                        </div>
                                    </div>
                                    <div id="mobile_noError" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" name="dob" id="dob" class="form-control" id="dob"
                                    pattern="\d{2} \d{2} \d{4}" value="{{ old('dob') }}" required>
                                <div id="dobError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" name="gender" id="gender" aria-label="gender" required>
                                    <option value="">Select</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                <div id="genderError" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="emp_code" class="form-label">Employee Code</label>
                                <input type="text" name="emp_code" id="emp_code" readonly
                                    value="{{ $empCode ? $empCode : old('emp_code') }}" class="form-control"
                                    placeholder="Employee Code" required>
                                <div id="emp_codeError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="Roles" class="form-label">User Type</label>
                                <select class="form-select" name="sub_user_type" id="sub_user_type"
                                    aria-label="Designation" required onchange="getDesignationAndSection(this.value)">
                                    <option value="">Select</option>
                                    <option value="ldo" {{ old('sub_user_type') == 'lndo' ? 'selected' : '' }}>
                                        {!! 'L&amp;DO' !!}</option>
                                    <option value="pmu" {{ old('sub_user_type') == 'pmu' ? 'selected' : '' }}>
                                        {!! 'PMU' !!}</option>
                                </select>
                                <div id="sub_user_typeError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4 pb-4 LNDO" style="display: none;">
                                @if ($designations)
                                    <label for="Roles" class="form-label">Designation</label>
                                    <select class="form-select" name="designation_id" id="designation_id"
                                        aria-label="Designation">
                                        <option value="">Select</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}"
                                                {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                                {!! $designation->name !!}</option>
                                        @endforeach
                                    </select>
                                    <div id="designation_idError" class="text-danger"></div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-4 pb-4 LNDO" style="display: none;">
                                @if ($sections)
                                    <label for="Sections" class="form-label">Sections <small class="form-text text-muted">(Hold Ctrl to select multiple)</small></label>
                                    <select class="form-select custom-dropdown" id="sections" name="sections[]"
                                        aria-label="Default select example" multiple>
                                        <option value="">Select</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}"
                                                {{ in_array($section->id, old('sections', [])) ? 'selected' : '' }}>
                                                {!! $section->name !!}</option>
                                        @endforeach
                                    </select>
                                    <div id="sectionsError" class="text-danger"></div>
                                @endif
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="Roles" class="form-label">Roles <small class="form-text text-muted">(Hold Ctrl to select multiple)</small></label>
                                <select class="form-select custom-dropdown" id="roles" name="roles[]"
                                    aria-label="Default select example" multiple required>
                                    <option value="">Select</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                                <div id="rolesError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">

                            </div>

                        </div>
                        <div class="col-12 col-lg-2">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    // Function to allow only numbers in the input field
    function isNumberKey(evt) {
        var charCode = evt.which ? evt.which : evt.keyCode;

        // Only allow digits (0-9), backspace, and delete
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }

        return true;
    }

    // Function to clear all error messages
    function clearErrors() {
        const errorElements = document.querySelectorAll('.text-danger');
        errorElements.forEach(function(element) {
            element.innerHTML = ''; // Clear the error message
        });
    }

    // Function to display error messages
    function showError(inputName, message) {
        const errorDiv = document.getElementById(inputName + 'Error');
        errorDiv.innerHTML = message;
    }

    // Function to validate form fields
    function validateForm() {
        let isValid = true;
        clearErrors(); // Clear previous error messages
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const mobile = document.getElementById('mobile_no').value.trim();
        const dob = document.getElementById('dob').value;
        const gender = document.getElementById('gender').value;
        const subUserType = document.getElementById('sub_user_type').value;
        const designation = document.getElementById('designation_id').value;
        var selectedSectionsOptions = document.getElementById('sections').selectedOptions; // Gets all selected options
        var selectedRolesOptions = document.getElementById('roles').selectedOptions; // Gets all selected roles

        // Validate Name
        if (name === "") {
            showError('name', 'Name is required.');
            isValid = false;
        }

        // Validate Email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showError('email', 'Please enter a valid email.');
            isValid = false;
        }

        // Validate Password
        if (password.length < 6) {
            showError('password', 'Password must be at least 6 characters long.');
            isValid = false;
        }

        // Validate Mobile (Indian format)
        const mobileRegex = /^[6-9]\d{9}$/;

        // Check if the input is a number and has a length of 10
        if (isNaN(mobile) || mobile.length !== 10) {
            showError('mobile_no', 'Mobile number must be exactly 10 digits.');
            isValid = false;
        } else if (!mobileRegex.test(mobile)) {
            showError('mobile_no', 'Please enter a valid mobile number (10 digits, start with 6 - 9).');
            isValid = false;
        }

        // Validate Date of Birth
        if (dob === "") {
            showError('dob', 'Date of Birth is required.');
            isValid = false;
        }

        // Validate Gender
        if (gender === "") {
            showError('gender', 'Please select a gender.');
            isValid = false;
        }

        // Validate User Type
        if (subUserType === "") {
            showError('sub_user_type', 'Please select a user type.');
            isValid = false;
        }

        if (subUserType === "" && subUserType === 'ldo') {
            // Validate Designation
            if (designation === "") {
                showError('designation_id', 'Please select a designation.');
                isValid = false;
            }

            // Check if any options are selected
            if (selectedSectionsOptions.length === 0) {
                showError('sections', 'Please select at least one section.');
                isValid = false;
            }
        }

        // Check if any options are selected
        if (selectedRolesOptions.length === 0) {
            showError('roles', 'Please select at least one role.');
            isValid = false;
        }

        return isValid;
    }

    // Function to handle form submission via JavaScript
    function submitForm(event) {
        event.preventDefault(); // Prevent the default form submission

        if (validateForm()) {
            const form = document.getElementById("userForm");
            form.submit(); // Submit the form
        }
    }

    //Function to hide & show Designation Dropdown & Section Dropdown for L&DO and PMU user - Lalit (22/Oct/2024)
    // Function to hide & show Designation Dropdown & Section Dropdown for L&DO and PMU user - Lalit (22/Oct/2024)
    function getDesignationAndSection(value) {
        if (value === 'ldo') {
            $('.LNDO').show();
            // // Add required attribute to Designation and Sections
            // $('#designation_id').attr('required', true);
            // $('#sections').attr('required', true);
        } else {
            $('.LNDO').hide();
            // // Remove required attribute when hidden
            // $('#designation_id').removeAttr('required');
            // $('#sections').removeAttr('required');
        }
    }


    $(document).ready(function() {
        $(".numericOnly").on("input", function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ""));
        });
    });
</script>
