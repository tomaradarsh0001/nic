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
                    <li class="breadcrumb-item active" aria-current="page">Update Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End -->
    <div>
        <div class="col pt-3">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Name"
                                    value="{{ $user->name ?? '' }}" required>
                                <div id="nameError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                                    value="{{ $user->email ?? '' }}" required>
                                <div id="emailError" class="text-danger"></div>
                            </div>
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
                                                            @if ($country->phonecode == $user->country_code) @selected(true) @endif>
                                                            {{ $country->iso2 }} (+{{ $country->phonecode }})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @endif
                                        <div class="form-box relative-input" style="width: 70%;">
                                            <input type="text" name="mobile_no" data-id="0" id="mobile_no"
                                                maxlength="10" class="form-control numericOnly" placeholder="Mobile Number"
                                                value="{{ $user->mobile_no ?? '' }}">
                                        </div>
                                    </div>
                                    <div id="mobile_noError" class="text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-12 col-lg-4 pb-4">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" name="dob" id="dob" class="form-control" id="dob"
                                    pattern="\d{2} \d{2} \d{4}" value="{{ $user->employeeDetails->dob ?? '' }}" required>
                                <div id="dobError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" name="gender" id="gender" aria-label="gender" required>
                                    <option value="">Select</option>
                                    <option value="male" {{ ($user->employeeDetails->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ ($user->employeeDetails->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                <div id="genderError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="Roles" class="form-label">User Type</label>
                                <select class="form-select" name="sub_user_type" id="sub_user_type" aria-label="Designation"
                                    required onchange="getDesignationAndSection(this.value)">
                                    <option value="">Select</option>
                                    <option value="ldo" {{ ($user->employeeDetails->user_sub_type ?? '') == 'ldo' ? 'selected' : '' }}>
                                        {!! 'L&amp;DO' !!}</option>
                                    <option value="pmu" {{ ($user->employeeDetails->user_sub_type ?? '') == 'pmu' ? 'selected' : '' }}>
                                        {!! 'PMU' !!}</option>
                                </select>
                                <div id="sub_user_typeError" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-12 col-lg-4 pb-4 LNDO" style="display: none;">
                                @if ($designations)
                                    <label for="Roles" class="form-label">Designation</label>
                                    <select class="form-select" name="designation_id" id="designation_id"
                                        aria-label="Designation">
                                        <option value="">Select</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}"
                                                {{ $user->designation_id == $designation->id ? 'selected' : '' }}>
                                                {!! $designation->name !!}</option>
                                        @endforeach
                                    </select>
                                    <div id="designation_idError" class="text-danger"></div>
                                @endif
                            </div>
                            <div class="col-12 col-lg-4 pb-4 LNDO" style="display: none;">
                                @if ($sections)
                                    <label for="Sections" class="form-label">Sections <small class="form-text text-muted">(Hold Ctrl to select multiple)</small></label>
                                    <select class="form-select custom-dropdown" id="sections" name="sections[]"
                                        aria-label="Default select example" multiple>
                                        <option value="">Select</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}"
                                                {{ in_array($section->id, $userSections) ? 'selected' : '' }}>
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
                                        <option value="{{ $role }}" {{ in_array($role, $userRoles) ? 'selected' : '' }}>{{ $role }}</option>
                                    @endforeach
                                </select>
                                <div id="rolesError" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    // Function to hide & show Designation Dropdown & Section Dropdown for L&DO and PMU user - Lalit (22/Oct/2024)
    function getDesignationAndSection(value) {
        if (value === 'ldo') {
            $('.LNDO').show();
        } else {
            $('.LNDO').hide();
            // Reset the selected values for Designation and Sections dropdowns
            $('#designation_id').val(''); // Reset designation dropdown
            $('#sections').val([]); // Reset sections dropdown
        }
    }

    $(document).ready(function() {
        $(".numericOnly").on("input", function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ""));
        });
    });

    // Execute on page load
    document.addEventListener('DOMContentLoaded', function() {
        const selectedValue = document.getElementById('sub_user_type').value;
        if (selectedValue) {
            getDesignationAndSection(selectedValue);
        }
    });
</script>
