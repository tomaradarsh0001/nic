@extends('layouts.app')

@section('title', 'Add Supplier Vendor')

@section('content')

    <style>
        .alert-danger {
            display: none !important;
        }
    </style>

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Logistic</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Vendors/Suppliers</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end py-3">
                <a href="{{ route('supplier.index') }}">
                    <button type="button" class="btn btn-danger px-2 mx-2">← Back</button>
                </a>
            </div>
            <form method="POST" id="category-form" action="{{ route('supplier_vendor_details.store') }}">
                @csrf

                <div class="form-row m-3">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" maxlength="30"
                            onkeypress="validateInputName(event)" onpaste="validatePasteName(event)">
                        <span class="text-danger"></span>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label" for="contact_no">Contact:</label>
                        <input type="text" id="contact_no" name="contact_no" class="form-control"
                            oninput="checkContactNo()" maxlength="10" onkeypress="validateInputContact(event)"
                            onpaste="validatePasteContact(event)">
                        <span id="contact-error" class="text-danger"></span>
                        @error('contact_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-row m-3">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control"
                            oninput="checkEmailExists()">
                        <span id="email-error" class="text-danger"></span>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label" for="office_address">Address:</label>
                        <input type="textarea" id="office_address" name="office_address" class="form-control">
                        <span class="text-danger"></span>
                        @error('office_address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-row m-3">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="status">Status:</label>
                        <select id="status" name="status" class="form-control mb-3">
                            <option value='active'>Active</option>
                            <option value='inactive'>Inactive</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="is_tender" name="is_tender" class="form-control">Is Tender:</label>
                        <select id="is_tender" name="is_tender" class="form-control mb-3">
                            <option value='active'>Active</option>
                            <option value='inactive'>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-row m-3">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="from_tender">From Tender:</label>
                        <input type="date" id="from_tender" name="from_tender" class="form-control"
                            onchange="updateFromTenderMinDate()">
                        <span class="text-danger"></span>
                        @error('from_tender')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="to_tender">To Tender:</label>
                        <input type="date" id="to_tender" name="to_tender" class="form-control"
                            onchange="updateToTenderMaxDate()">
                        <span class="text-danger"></span>
                        @error('to_tender')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" id="submit-button" class="btn btn-primary mt-3 mx-3 mb-4">Submit</button>
            </form>
        </div>
    </div>
    <script>
        function validateInputContact(event) {
            const inputField = event.target;
            const inputValue = inputField.value;

            // Allow control keys (like backspace, delete, arrows) and check input length
            const controlKeys = ['Backspace', 'ArrowLeft', 'ArrowRight', 'Delete'];
            if (controlKeys.includes(event.key) || (inputValue.length < 10 && /^\d$/.test(event.key))) {
                return true;
            }

            // Prevent any other input
            event.preventDefault();
            return false;
        }

        function validatePasteContact(event) {
            const paste = (event.clipboardData || window.clipboardData).getData('text');

            // Check if the paste contains only numbers and does not exceed 10 characters
            if (!/^\d{1,10}$/.test(paste) || paste.length + event.target.value.length > 10) {
                event.preventDefault();
            }
        }

        function validateInputName(event) {
            const inputField = event.target;
            const inputValue = inputField.value;

            // Allow control keys (like backspace, delete, arrows) and check input length
            const controlKeys = ['Backspace', 'ArrowLeft', 'ArrowRight', 'Delete', 'Tab'];
            if (controlKeys.includes(event.key) || (inputValue.length < 30 && /^[a-zA-Z\s]$/.test(event.key))) {
                return true;
            }

            // Prevent any other input
            event.preventDefault();
            return false;
        }

        function validatePasteName(event) {
            const paste = (event.clipboardData || window.clipboardData).getData('text');

            // Check if the paste contains only alphabetic characters and spaces, and does not exceed 30 characters
            if (!/^[a-zA-Z\s]{1,30}$/.test(paste) || paste.length + event.target.value.length > 30) {
                event.preventDefault();
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

        async function checkContactNo() {
            let contactNo = $('#contact_no').val();
            if (contactNo.length === 10 && /^\d+$/.test(contactNo)) {
                try {
                    let response = await $.ajax({
                        url: `/check-contact/${contactNo}`,
                        method: 'GET'
                    });
                    if (response.exists) {
                        $('#contact-error').text('This contact number is already in use.');
                        $('#submit-button').attr('disabled', true);
                    } else {
                        $('#contact-error').text('');
                        $('#submit-button').attr('disabled', false);
                    }
                } catch (error) {
                    console.error('An error occurred:', error);
                }
            } else {
                $('#contact-error').text('Contact number must be exactly 10 digits.');
            }
        }
        async function checkEmailExists() {
            let email = $('#email').val();
            if (email) {
                try {
                    let response = await $.ajax({
                        url: `/check-email/${email}`,
                        method: 'GET'
                    });
                    if (response.exists) {
                        $('#email-error').text('This email address is already in use.');

                    } else {
                        $('#email-error').text('');
                    }
                } catch (error) {
                    console.error('An error occurred:', error);
                }
            } else {
                $('#email-error').text('');
            }
        }

        $(document).ready(function() {
            $('#category-form').on('submit', function(event) {
                if ($('#contact-error').text() || $('#email-error').text()) {
                    event.preventDefault();
                }
            });
        });

        $(document).ready(function() {
            $('#category-form').on('submit', function(event) {
                event.preventDefault();
                let formData = $(this).serialize();
                $('.text-danger').text('');
                checkContactNo()

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = response.redirect_url;

                    },
                    error: function(response) {
                        if (response.status === 422) {
                            let errors = response.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                $('#' + field).next('.text-danger').text(messages[0]);
                            });
                        } else {}
                    }
                });
            });
        });
    </script>

@endsection
