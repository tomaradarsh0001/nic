@extends('layouts.app')

@section('title', 'Edit Supplier Vendor')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Logistic</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Vendors/Suppliers</li>
                </ol>
            </nav>
        </div>
    </div>

    <div>
        <div class="col pt-3">
            <div class="card">
                <div class="card-body m-3">
                    <form action="{{ route('supplier.update', $data->id) }}" id="category-form" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row align-items-end my-3">
                            <div class="col-12 col-lg-4">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $data->name }}" placeholder="Update Name">
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="contact_no" class="form-label">Number:</label>
                                <input type="text" name="contact_no" id="contact_no" class="form-control"
                                    value="{{ $data->contact_no }}" placeholder="Update Number" onblur="checkContactNo()">
                                <span id="contact-error" class="text-danger" style="display:none;"></span>
                                <!-- Real-time validation error -->
                                @error('contact_no')
                                    <span class="text-danger">{{ $message }}</span> <!-- Server-side validation error -->
                                @enderror
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $data->email }}" placeholder="Update Email" onblur="checkEmailExists()">
                                <span id="email-error" class="text-danger" style="display:none;"></span>
                                <!-- Real-time validation error -->
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span> <!-- Server-side validation error -->
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-lg-12">
                            <label for="office_address" class="form-label">Address:</label>
                            <input type="text" name="office_address" id="office_address" class="form-control"
                                value="{{ $data->office_address }}" placeholder="Update Address">
                        </div>

                        <div class="row align-items-end my-3">
                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="status">Status:</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="active" {{ $data->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $data->status == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="is_tender">Is Tender:</label>
                                <select id="is_tender" name="is_tender" class="form-control">
                                    <option value="active" {{ $data->is_tender == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ $data->is_tender == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="row align-items-end my-3">
                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="from_tender">From Tender:</label>
                                <input type="date" id="from_tender" name="from_tender" value="{{ $data->from_tender }}"
                                    class="form-control" onchange="updateFromTenderMinDate()">
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="to_tender">To Tender:</label>
                                <input type="date" id="to_tender" name="to_tender" value="{{ $data->to_tender }}"
                                    class="form-control" onchange="updateToTenderMaxDate()">
                            </div>
                        </div>

                        <div class="col-12 col-lg-2 my-4">
                            <button type="submit" id="submit-button" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Real-time check for contact number
        async function checkContactNo() {
            let contactNo = $('#contact_no').val();
            if (contactNo.length === 10) {
                try {
                    let response = await $.ajax({
                        url: `/check-contact/${contactNo}`,
                        method: 'GET'
                    });
                    if (response.exists) {
                        $('#contact-error').text('This contact number is already in use.').show();
                        $('#submit-button').attr('disabled', true); // Disable the submit button
                    } else {
                        $('#contact-error').text('').hide();
                        $('#submit-button').attr('disabled', false); // Enable the submit button
                    }
                } catch (error) {
                    console.error('An error occurred:', error);
                }
            } else {
                $('#contact-error').text('Contact number must be 10 digits.').show();
                $('#submit-button').attr('disabled', true); // Disable the submit button
            }
        }

        // Date Validation added by ADARSH TOMAR on 14 oct 2024
        function updateFromTenderMinDate() {
            const fromTenderInput = document.getElementById('to_tender');
            const toTenderInput = document.getElementById('from_tender');

            const toDate = new Date(toTenderInput.value);

            if (!isNaN(toDate.getTime())) {
                const minDate = new Date(toDate);
                minDate.setDate(minDate.getDate() + 1);
                fromTenderInput.setAttribute('min', minDate.toISOString().split('T')[0]);

                if (new Date(fromTenderInput.value) < minDate) {
                    fromTenderInput.value = '';
                }
            } else {
                fromTenderInput.removeAttribute('min');
            }
        }

        function updateToTenderMaxDate() {
            const toTenderInput = document.getElementById('to_tender');
            const fromTenderInput = document.getElementById('from_tender');

            if (toTenderInput.value) {
                updateFromTenderMinDate();
            }
        }


        // Check if the email already exists
        async function checkEmailExists() {
            let email = $('#email').val();
            if (email) {
                try {
                    let response = await $.ajax({
                        url: `/check-email/${email}`,
                        method: 'GET'
                    });
                    if (response.exists) {
                        $('#email-error').text('This email address is already in use.').show();
                        $('#submit-button').attr('disabled', true); // Disable the submit button
                    } else {
                        $('#email-error').text('').hide();
                        $('#submit-button').attr('disabled', false); // Enable the submit button
                    }
                } catch (error) {
                    console.error('An error occurred:', error);
                }
            } else {
                $('#email-error').text('Email is required.').show();
                $('#submit-button').attr('disabled', true); // Disable the submit button
            }
        }

        $(document).ready(function() {
            // Disable submit button when input is focused
            $('#contact_no, #email').on('focus', function() {
                $('#submit-button').attr('disabled', true); // Disable the submit button
            });

            $('#category-form').on('submit', function(event) {
                // Check if there are any error messages before submitting
                if ($('#contact-error').text() || $('#email-error').text()) {
                    event.preventDefault(); // Prevent form submission
                } else {
                    $('#submit-button').text('Submitting...');
                    $('#submit-button').attr('disabled',
                        true); // Disable the button to prevent double submissions
                }
            });
        });
    </script>

    {{-- <script>
        // Real-time check for contact number
        async function checkContactNo() {
            let contactNo = $('#contact_no').val();
            if (contactNo.length === 10) {
                try {
                    let response = await $.ajax({
                        url: `/check-contact/${contactNo}`,
                        method: 'GET'
                    });
                    if (response.exists) {
                        $('#contact-error').text('This contact number is already in use.').show();
                        // $('#submit-button').attr('disabled', true); 
                    } else {
                        $('#contact-error').text('').hide();
                        $('#submit-button').attr('disabled', false); // Enable the submit button
                    }
                } catch (error) {
                    console.error('An error occurred:', error);
                }
            } else {
                $('#contact-error').text('Contact number must be 10 digits.').show();
                $('#submit-button').attr('disabled', true);
            }
        }

        // Check if the email already exists
        async function checkEmailExists() {
            let email = $('#email').val();
            if (email) {
                try {
                    let response = await $.ajax({
                        url: `/check-email/${email}`,
                        method: 'GET'
                    });
                    if (response.exists) {
                        $('#email-error').text('This email address is already in use.').show();
                        // $('#submit-button').attr('disabled', true); 
                    } else {
                        $('#email-error').text('').hide();
                        $('#submit-button').attr('disabled', false); // Enable the submit button
                    }
                } catch (error) {
                    console.error('An error occurred:', error);
                }
            } else {
                $('#email-error').text('Email is required.').show();
                $('#submit-button').attr('disabled', true); // Disable the submit button
            }
        }

        $(document).ready(function() {
            $('#category-form').on('submit', function(event) {
                // Check if there are any error messages before submitting
                if ($('#contact-error').text() || $('#email-error').text()) {
                    event.preventDefault(); // Prevent form submission
                } else {
                    $('#submit-button').text('Submitting...');
                    $('#submit-button').attr('disabled',
                        true); // Disable the button to prevent double submissions
                }
            });
        });
    </script> --}}
@endsection
