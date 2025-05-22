document.addEventListener('DOMContentLoaded', () => {
    const setupForm = (formId, submitId) => {
        const form = document.getElementById(formId);
        const inputs = [...form.querySelectorAll('input[type=text]')];
        const submit = form.querySelector(submitId);

        const handleKeyDown = (e) => {
            const index = inputs.indexOf(e.target);

            if (!/^[0-9]{1}$/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete' && e.key !== 'Tab' && !e.metaKey) {
                e.preventDefault();
            }

            if ((e.key === 'Delete' || e.key === 'Backspace') && index >= 0) {
                if (inputs[index].value === '') {
                    if (index > 0) {
                        inputs[index - 1].focus();
                        inputs[index - 1].value = '';
                    }
                } else {
                    inputs[index].value = '';  // Clear current input if not empty
                }
                e.preventDefault();  // Prevent default behavior
            }
        };

        const handleInput = (e) => {
            const { target } = e;
            const index = inputs.indexOf(target);
            if (target.value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            } else if (index === inputs.length - 1) {
                submit.focus();
            }
        };

        const handleFocus = (e) => {
            e.target.select();
        };

        const handlePaste = (e) => {
            e.preventDefault();
            const text = e.clipboardData.getData('text');
            if (!/^[0-9]{1,}$/.test(text)) return;
            const digits = text.split('').slice(0, inputs.length);
            inputs.forEach((input, i) => input.value = digits[i] || '');
            if (digits.length === inputs.length) {
                submit.focus();
            }
        };

        inputs.forEach((input) => {
            input.addEventListener('input', handleInput);
            input.addEventListener('keydown', handleKeyDown);
            input.addEventListener('focus', handleFocus);
            input.addEventListener('paste', handlePaste);
        });
    };

    setupForm('otp-form', '#verifyMobileOtpBtn');
    setupForm('otp-form-email', '#verifyEmailOtpBtn');
    setupForm('org-otp-form', '#orgVerifyMobileOtpBtn');
    setupForm('org-otp-form-email', '#orgVerifyEmailOtpBtn');
});

// Field Data Validation in All Inputs - 31-07-2024 by Diwakar Sinha

$(document).ready(function () {
    $('.alpha-only').keypress(function (event) {
        var charCode = event.which;
        // Allow only alphabetic characters (a-z, A-Z), space (32), and dot (46)
        if (
            (charCode < 65 || (charCode > 90 && charCode < 97) || charCode > 122) &&
            charCode !== 32 && charCode !== 46
        ) {
            event.preventDefault();
        }
    });
    $('.numericDecimal').on('input', function () {
        var value = $(this).val();
        if (!/^\d*\.?\d*$/.test(value)) {
            $(this).val(value.slice(0, -1));
        }
    });

    $(".numericOnly").on('input', function (e) {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });

    $('.alphaNum-hiphenForwardSlash').on('input', function () {
        var value = $(this).val();
        // Allow only alphanumeric, hyphen, and forward slash
        var filteredValue = value.replace(/[^a-zA-Z0-9\-\/]/g, '');
        $(this).val(filteredValue);
    });

    //   Date Format
    $('.date_format').on('input', function (e) {
        var input = $(this).val().replace(/\D/g, '');
        if (input.length > 8) {
            input = input.substring(0, 8);
        }

        var formattedDate = '';
        if (input.length > 0) {
            formattedDate = input.substring(0, 2);
        }
        if (input.length >= 3) {
            formattedDate += '-' + input.substring(2, 4);
        }
        if (input.length >= 5) {
            formattedDate += '-' + input.substring(4, 8);
        }

        $(this).val(formattedDate);
    });

    // Plot No.
    $('.plotNoAlpaMix').on('input', function () {
        var pattern = /[^a-zA-Z0-9+\-/]/g;
        var sanitizedValue = $(this).val().replace(pattern, '');
        $(this).val(sanitizedValue);
    });

    $('.alphaNum-hiphenForwardSlash').on('input', function () {
        var value = $(this).val();
        // Allow only alphabetic, numeric, space, forward slash, parentheses, and hyphen
        var filteredValue = value.replace(/[^a-zA-Z0-9 \/\(\)\-]/g, '');
        $(this).val(filteredValue);
    });

    // Flat Field

    $('.alphaNumHypSlashParenthspace').on('input', function () {
        var value = $(this).val();
        // Allow only alphabetic, numeric, space, forward slash, parentheses, and hyphen
        var filteredValue = value.replace(/[^a-zA-Z0-9 \/\(\)\-]/g, '');
        $(this).val(filteredValue);
    });

    // PAN
    $('.pan_number_format').on('input', function (event) {
        var value = $(this).val().toUpperCase();
        var newValue = '';
        var valid = true;

        // PAN format: AAAAA9999A

        for (var i = 0; i < value.length; i++) {
            var char = value[i];

            if (i < 5) {
                if (/[A-Z]/.test(char)) {
                    newValue += char;
                } else {
                    valid = false;
                    break;
                }
            }

            else if (i >= 5 && i < 9) {
                if (/[0-9]/.test(char)) {
                    newValue += char;
                } else {
                    valid = false;
                    break;
                }
            }

            else if (i === 9) {
                if (/[A-Z]/.test(char)) {
                    newValue += char;
                } else {
                    valid = false;
                    break;
                }
            }
        }

        if (value.length > 10) {
            valid = false;
        }

        if (valid) {
            $(this).val(newValue);
        } else {
            $(this).val(newValue);
        }
    });
    // End PAN


});

// Required Validation - 27-09-2024 by Diwakar Sinha
// This is working final for Individual Owner
$(document).ready(function () {
    var form = $('.dynamicForm');

    function updateFormId() {
        if ($('#propertyowner').is(':checked')) {
            form.attr('id', 'propertyOwnerForm');
        } else if ($('#organization').is(':checked')) {
            form.attr('id', 'organizationForm');
        }
    }

    $('#propertyowner, #organization').change(function () {
        updateFormId();
    });

    $('#IndsubmitButton').click(function (event) {
        event.preventDefault();

        updateFormId();

        var updatedFormId = form.attr('id');
        var updatedForm = $('#' + updatedFormId);

        if (validateForm()) {
            $('#IndsubmitButton').attr('disabled', true).text('Submitting...');
            updatedForm[0].submit();
        }
    });

    function toggleAddressFields() {
        if ($('#Yes').is(':checked')) {
            $('#ifyes').show();
            $('#ifYesNotChecked').hide();
        } else {
            $('#ifyes').hide();
            $('#ifYesNotChecked').show();
        }
    }

    toggleAddressFields();
    $('#Yes').change(function () {
        toggleAddressFields();
    });

    function validateForm() {
        let firstInvalidField = null;
        let isValid = true;

        const basicFields = [
            { id: '#indfullname', errorId: '#IndFullNameError' },
            { id: '#Indgender', errorId: '#IndGenderError' },
            { id: '#dateOfBirth', errorId: '#dateOfBirthError' },
            { id: '#mobileInv', errorId: '#IndMobileError' },
            { id: '#emailInv', errorId: '#IndEmailError' },
            { id: '#IndSecondName', errorId: '#IndSecondNameError' },
            { id: '#IndPanNumber', errorId: '#IndPanNumberError' },
            { id: '#IndAadhar', errorId: '#IndAadharError' },
            { id: '#commAddress', errorId: '#IndCommAddressError' },
            { id: '#file-input', errorId: '#file-inputError' },
            
        ];

        basicFields.forEach(function (field) {
            const inputField = $(field.id);
            const errorField = $(field.errorId);

            inputField.on('input', function () {
                if (inputField.val().trim() !== "") {
                    inputField.removeClass('required');
                    errorField.hide();
                }
            });

            if (inputField.val().trim() === "") {
                inputField.addClass('required');
                errorField.text("This field is required").show();
                isValid = false;
                if (firstInvalidField === null) {
                    firstInvalidField = inputField;
                }
            } else {
                inputField.removeClass('required');
                errorField.hide();
            }
        });


        // Country Code Validation
        const $countryCode = $('#countryCode');
        const $countryCodeError = $('#countryCodeError');
        const countryCodeValue = $countryCode.val().trim();

        // Validate Country Code input
        if (countryCodeValue === '') {
            $countryCodeError.text('Country Code is required');
            $countryCodeError.show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $countryCode;
            }
        } else {
            $countryCodeError.hide();
        }
        // Mobile number validation
        const $Indmobile = $('#mobileInv');
        const $IndMobileError = $('#IndMobileError');
        const IndMobileValue = $Indmobile.val().trim();
        const dataIdValue = $Indmobile.attr('data-id');

        // Validate mobile number input
        if (IndMobileValue === '') {
            $IndMobileError.text('Mobile Number is required');
            $IndMobileError.show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $Indmobile;
            }
        } else if (IndMobileValue.length !== 10) {
            $IndMobileError.text('Mobile Number must be exactly 10 digit');
            $IndMobileError.show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $Indmobile;
            }
        } else if (dataIdValue === "0") {
            $IndMobileError.text('Please verify your mobile number');
            $IndMobileError.show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $Indmobile;
            }
        } else if (dataIdValue === "1") {
            $IndMobileError.hide();
        } else {
            $IndMobileError.hide();
        }

        // Email validation
        const $IndEmail = $('#emailInv');
        const $IndEmailError = $('#IndEmailError');
        const IndEmailValue = $IndEmail.val().trim();
        const dataIdEmailValue = $IndEmail.attr('data-id');

        // Validate Email input
        if (IndEmailValue === '') {
            $IndEmailError.text('Email is required');
            $IndEmailError.show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $IndEmail;
            }
        } else if (dataIdEmailValue === "0") {
            $IndEmailError.text('Please verify your email');
            $IndEmailError.show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $IndEmail;
            }
        } else if (dataIdEmailValue === "1") {
            $IndEmailError.hide();
        } else {
            $IndEmailError.hide();
        }

        // PAN Number Validation
        const $IndPanNumber = $('#IndPanNumber');
        const $IndPanNumberError = $('#IndPanNumberError');
        const IndPanNumberValue = $IndPanNumber.val().trim();

        // Validate PAN number input
        if (IndPanNumberValue === '') {
            $IndPanNumber.addClass('required');
            $IndPanNumberError.text('This field is required').show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $IndPanNumber;
            }
        } else if (IndPanNumberValue.length !== 10) {
            $IndPanNumber.addClass('required');
            $IndPanNumberError.text('PAN Number must be exactly 10 characters').show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $IndPanNumber;
            }
        } else {
            $IndPanNumber.removeClass('required');
            $IndPanNumberError.hide();
        }

        // Aadhaar Number Validation
        const $IndAadhar = $('#IndAadhar');
        const $IndAadharError = $('#IndAadharError');
        const IndAadharValue = $IndAadhar.val().trim();

        if (IndAadharValue === '') {
            $IndAadhar.addClass('required');
            $IndAadharError.text('This field is required').show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $IndAadhar;
            }
        } else if (IndAadharValue.length !== 12) {
            $IndAadhar.addClass('required');
            $IndAadharError.text('Aadhar Number must be exactly 12 digit').show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $IndAadhar;
            }
        } else {
            $IndAadhar.removeClass('required');
            $IndAadharError.hide();
        }


        // Special validation for #commAddress (address field)
        const commAddress = $('#commAddress');
        const IndCommAddressError = $('#IndCommAddressError');
        const orgAddressValue = commAddress.val().trim();
        const addressRegex = /^[a-zA-Z0-9\s,#\-()/]*$/;  // Regex allowing specific characters

        // Reset error state
        commAddress.removeClass('required');
        IndCommAddressError.hide();

        // Required field validation
        if (orgAddressValue.length === 0) {
            commAddress.addClass('required');
            IndCommAddressError.text("This field is required").show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = commAddress;
            }
        }
        // Maxlength validation (200 characters) and regex validation
        else if (orgAddressValue.length > 200) {
            commAddress.addClass('required');
            IndCommAddressError.text("Address cannot exceed 200 characters").show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = commAddress;
            }
        }
        // Regex validation for allowed characters
        else if (!addressRegex.test(orgAddressValue)) {
            commAddress.addClass('required');
            IndCommAddressError.text("Only letters, digits, hyphen (-), comma (,), hash (#), parenthesis ( ), forward slash (/), and spaces are allowed").show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = commAddress;
            }
        }

        // Photo upload validation (only .jpg or .png files allowed)
const photoField = $('#file-input');
const photoErrorField = $('#file-inputError');

// Function to validate file input
function validatePhotoField() {
    const fileName = photoField.val().toLowerCase();
    if (photoField[0].files.length === 0) {
        photoErrorField.text("Photo upload is required").show();
        return false;
    } else if (!fileName.endsWith('.jpg') && !fileName.endsWith('.png')) {
        photoErrorField.text("Only .jpg or .png files are allowed").show();
        return false;
    } else {
        photoErrorField.hide();
        return true;
    }
}

// Trigger validation on file change
photoField.on('change', function () {
    validatePhotoField();
});

// Perform validation without focusing
if (!validatePhotoField()) {
    isValid = false; // Keep validation status but don't alter focus or `firstInvalidField`
}

        if ($('#Yes').is(':checked')) {
            //Checked if is Your Property Flat check box is checked - Lalit Tiwari (09/dec/2024)
            const addressFieldsYes = $('#isPropertyFlat').is(':checked') ? [
                { id: '#localityFill', errorId: '#localityFillError' },
                { id: '#blocknoInvFill', errorId: '#blocknoInvFillError' },
                { id: '#plotnoInvFill', errorId: '#plotnoInvFillError' },
                { id: '#landUseInvFill', errorId: '#landUseInvFillError' },
                { id: '#landUseSubtypeInvFill', errorId: '#landUseSubtypeInvFillError' },
                { id: '#flat_no_after_Checked_Address_notfound', errorId: '#flat_no_after_Checked_Address_notfoundError' }
            ] : [
                { id: '#localityFill', errorId: '#localityFillError' },
                { id: '#blocknoInvFill', errorId: '#blocknoInvFillError' },
                { id: '#plotnoInvFill', errorId: '#plotnoInvFillError' },
                { id: '#landUseInvFill', errorId: '#landUseInvFillError' },
                { id: '#landUseSubtypeInvFill', errorId: '#landUseSubtypeInvFillError' }
            ] ;
            addressFieldsYes.forEach(function (field) {
                const inputField = $(field.id);
                const errorField = $(field.errorId);

                // On change or input, hide the error message
                inputField.on('input', function () {
                    if (inputField.val().trim() !== "") {
                        inputField.removeClass('required');
                        errorField.hide();
                    }
                });

                if (inputField.val().trim() === "") {
                    inputField.addClass('required');
                    errorField.text("This field is required").show();
                    isValid = false;
                    if (firstInvalidField === null) {
                        firstInvalidField = inputField;
                    }
                } else {
                    inputField.removeClass('required');
                    errorField.hide();
                }

            });
        } else {
            const addressFieldsNo = [
                { id: '#locality', errorId: '#localityError' },
                { id: '#block', errorId: '#blockError' },
                { id: '#plot', errorId: '#plotError' },
                { id: '#landUse', errorId: '#landUseError' },
                { id: '#landUseSubtype', errorId: '#landUseSubtypeError' }
                
            ];

            addressFieldsNo.forEach(function (field) {
                const inputField = $(field.id);
                const errorField = $(field.errorId);

                // On change or input, hide the error message
                inputField.on('input', function () {
                    if (inputField.val().trim() !== "") {
                        inputField.removeClass('required');
                        errorField.hide();
                    }
                });


                if (inputField.val().trim() === "") {
                    inputField.addClass('required');
                    errorField.text("This field is required").show();
                    isValid = false;
                    if (firstInvalidField === null) {
                        firstInvalidField = inputField;
                    }
                } else {
                    inputField.removeClass('required');
                    errorField.hide();
                }


                    // Helper function to validate a single field
        function validateField(fieldId, errorId, condition) {
            const inputField = $(fieldId);
            const errorField = $(errorId);

            // Add event listener to remove errors on user input
            inputField.on('input', function () {
                if (inputField.val().trim() !== "") {
                    inputField.removeClass('required');
                    errorField.hide();
                }
            });

            // Validation logic
            if (condition && inputField.val().trim() === "") {
                inputField.addClass('required');
                errorField.text("This field is required").show();
                isValid = false;
                if (firstInvalidField === null) {
                    firstInvalidField = inputField;
                }
            } else {
                inputField.removeClass('required');
                errorField.hide();
            }
        }
        // End

        // Check if the property is a flat
        if ($('#isPropertyFlat').is(':checked')) {
            // If flat is not available
            if ($('#flatAvailableInv').val() === "FlatNotAvailable" && $('#landUse').val() !== '' && $('#landUseSubtype').val() !== '') {
                validateField('#flat_no_rec_not_found', '#flat_no_rec_not_foundError', true);
            }

            // If flat is available
            if ($('#flatAvailableInv').val() === "FlatAvailable" && $('#landUse').val() !== '' && $('#landUseSubtype').val() !== '') {
                // Validate the #flat field only if #isFlatNotInList is not checked
                validateField('#flat', '#flatError', !$('#isFlatNotInList').is(':checked'));

                // If #isFlatNotInList is checked, validate #flat_no field
                if ($('#isFlatNotInList').is(':checked')) {
                    validateField('#flat_no', '#flat_noError', true);
                }
            }
        }

            });
        }

        const fileFields = [
            { id: '#IndSaleDeed', errorId: '#IndSaleDeedError' },
            { id: '#IndBuildAgree', errorId: '#IndBuildAgreeError' },
            { id: '#IndSubMut', errorId: '#IndSubMutError' },
            { id: '#IndOther', errorId: '#IndOtherError' }
        ];

        let isValidFiles = true;
        let firstInvalidFieldFiles = null;
        let atLeastOneFile = false;

        fileFields.forEach(function (field) {
            const inputField = $(field.id);
            const errorField = $(field.errorId);
            inputField.removeClass('required');
            errorField.hide();

            inputField.on('change', function () {
                const files = inputField[0].files;
                if (files.length > 0) {
                    let allFilesArePDF = true;

                    for (let i = 0; i < files.length; i++) {
                        const fileName = files[i].name;
                        if (!fileName.endsWith('.pdf')) {
                            allFilesArePDF = false;
                            break;
                        }
                    }

                    if (allFilesArePDF) {
                        inputField.removeClass('required');
                        errorField.hide();
                    } else {
                        inputField.addClass('required');
                        errorField.text("Only PDF files are allowed").show();
                        isValidFiles = false;
                        if (firstInvalidFieldFiles === null) {
                            firstInvalidFieldFiles = inputField;
                        }
                    }
                }
            });
        });

        fileFields.forEach(function (field) {
            const inputField = $(field.id);
            const errorField = $(field.errorId);
            const files = inputField[0].files;

            // Check if there are files in this input
            if (files.length > 0) {
                atLeastOneFile = true;

                let allFilesArePDF = true;
                for (let i = 0; i < files.length; i++) {
                    const fileName = files[i].name;
                    if (!fileName.endsWith('.pdf')) {
                        allFilesArePDF = false;
                        break;
                    }
                }

                // Show error message if not all files are PDF
                if (!allFilesArePDF) {
                    inputField.addClass('required');
                    errorField.text("Only PDF files are allowed").show();
                    isValidFiles = false;
                    if (firstInvalidFieldFiles === null) {
                        firstInvalidFieldFiles = inputField;
                    }
                }
            }
        });



        if (!atLeastOneFile) {
            fileFields.forEach(function (field) {
                const inputField = $(field.id);
                const errorField = $(field.errorId);
                inputField.addClass('required');
                errorField.text("At least one file is required").show();
                isValidFiles = false;
                if (firstInvalidFieldFiles === null) {
                    firstInvalidFieldFiles = inputField;
                }
            });
        }

        if (firstInvalidFieldFiles) {
            firstInvalidFieldFiles.focus();
        }

        // Owner Lessee Doc
        const ownerLessField = $('#IndOwnerLess');
        const ownerLessError = $('#IndOwnerLessError');
        ownerLessField.removeClass('required');
        ownerLessError.hide();
        let isValidFiles2 = true;
        let firstInvalidFieldFiles2 = null;

        // Reusable validation function
        function validateOwnerLessField() {
            const files = ownerLessField[0].files;

            if (files.length === 0) {
                // No file uploaded
                ownerLessField.addClass('required');
                ownerLessError.text("This field is mandatory. Upload a PDF file").show();
                return false;
            }

            // Check file extensions
            const allFilesArePDF = Array.from(files).every(file => file.name.endsWith('.pdf'));

            if (!allFilesArePDF) {
                ownerLessField.addClass('required');
                ownerLessError.text("Only PDF files are allowed").show();
                return false;
            }

            // If all checks pass
            ownerLessField.removeClass('required');
            ownerLessError.hide();
            return true;
        }

        // Event listener for file input changes
        ownerLessField.on('change', function () {
            validateOwnerLessField();
        });

        // Initial validation (outside event listener)
        if (!validateOwnerLessField()) {
            isValidFiles2 = false;
            firstInvalidFieldFiles2 = ownerLessField;
        }

        // Set focus to the first invalid field if any
        if (firstInvalidFieldFiles2) {
            firstInvalidFieldFiles2.focus();
        }

        // End
        // Lease Deed/Conyenance Deed

        const IndLeaseDeed = $('#IndLeaseDeed');
        const IndLeaseDeedError = $('#IndLeaseDeedError');
        IndLeaseDeed.removeClass('required');
        IndLeaseDeedError.hide();
        let isValidFiles3 = true;
        let firstInvalidFieldFiles3 = null;

        // Reusable validation function
        function validateIndLeaseDeedField() {
            const files = IndLeaseDeed[0].files;

            if (files.length === 0) {
                // No file uploaded
                IndLeaseDeed.addClass('required');
                IndLeaseDeedError.text("This field is mandatory. Upload a PDF file").show();
                return false;
            }

            // Check file extensions
            const allFilesArePDF = Array.from(files).every(file => file.name.endsWith('.pdf'));

            if (!allFilesArePDF) {
                IndLeaseDeed.addClass('required');
                IndLeaseDeedError.text("Only PDF files are allowed").show();
                return false;
            }

            // If all checks pass
            IndLeaseDeed.removeClass('required');
            IndLeaseDeedError.hide();
            return true;
        }

        // Event listener for file input changes
        IndLeaseDeed.on('change', function () {
            validateIndLeaseDeedField();
        });

        // Initial validation (outside event listener)
        if (!validateIndLeaseDeedField()) {
            isValidFiles3 = false;
            firstInvalidFieldFiles3 = IndLeaseDeed;
        }

        // Set focus to the first invalid field if any
        if (firstInvalidFieldFiles3) {
            firstInvalidFieldFiles3.focus();
        }

        // End

        // firstInvalidField
        if (firstInvalidField !== null) {
            firstInvalidField.focus();
        }

        const consentField = $('#IndConsent');
        const consentErrorField = $('#IndConsentError');
        if (!consentField.is(':checked')) {
            consentField.addClass('required');
            consentErrorField.text("You must agree to the terms").show();
            isValid = false;
        } else {
            consentField.removeClass('required');
            consentErrorField.hide();
        }

        if (firstInvalidField !== null) {
            firstInvalidField.focus();
        }

        return isValid && isValidFiles && isValidFiles2 && isValidFiles3;
    }

});


$(document).ready(function () {
    var form = $('.dynamicForm');

    function updateFormId() {
        if ($('#propertyowner').is(':checked')) {
            form.attr('id', 'propertyOwnerForm');
        } else if ($('#organization').is(':checked')) {
            form.attr('id', 'organizationForm');
        }
    }


    $('#propertyowner, #organization').change(function () {
        updateFormId();
    });

    $('#OrgsubmitButton').click(function (event) {
        event.preventDefault();

        updateFormId();

        var updatedFormId = form.attr('id');
        var updatedForm = $('#' + updatedFormId);

        if (validateForm()) {
            $('#OrgsubmitButton').attr('disabled', true).text('Submitting...');
            updatedForm[0].submit();
        }
    });

    function toggleAddressFields() {
        if ($('#YesOrg').is(':checked')) {
            $('#ifyesOrg').show();
            $('#ifYesNotCheckedOrg').hide();
        } else {
            $('#ifyesOrg').hide();
            $('#ifYesNotCheckedOrg').show();
        }
    }

    toggleAddressFields();
    $('#YesOrg').change(function () {
        toggleAddressFields();
    });

    function validateForm() {
        let firstInvalidField = null;
        let isValid = true;

        // Basic details validation
        const basicFields = [
            { id: '#OrgName', errorId: '#OrgNameError' },
            { id: '#OrgPAN', errorId: '#OrgPANError' },
            { id: '#orgAddressOrg', errorId: '#orgAddressOrgError' },
            { id: '#OrgNameAuthSign', errorId: '#OrgNameAuthSignError' },
            { id: '#authsignatory_mobile', errorId: '#authsignatory_mobileError' },
            { id: '#emailauthsignatory', errorId: '#emailauthsignatoryError' },
            { id: '#orgAadharAuth', errorId: '#orgAadharAuthError' },
        ];

        basicFields.forEach(function (field) {
            const inputField = $(field.id);
            const errorField = $(field.errorId);

            // On change or input, hide the error message
            inputField.on('input', function () {
                if (inputField.val().trim() !== "") {
                    inputField.removeClass('required');
                    errorField.hide();
                }
            });

            if (inputField.val().trim() === "") {
                inputField.addClass('required');
                errorField.text("This field is required").show();
                isValid = false;
                if (firstInvalidField === null) {
                    firstInvalidField = inputField;
                }
            } else {
                inputField.removeClass('required');
                errorField.hide();
            }
        });

        // Special validation for #orgAddressOrg (address field)
        const orgAddressOrg = $('#orgAddressOrg');
        const orgAddressOrgError = $('#orgAddressOrgError');
        const orgAddressValue = orgAddressOrg.val().trim();
        const addressRegex = /^[a-zA-Z0-9\s,#\-()/]*$/;  // Regex allowing specific characters

        // Reset error state
        orgAddressOrg.removeClass('required');
        orgAddressOrgError.hide();

        // Required field validation
        if (orgAddressValue.length === 0) {
            orgAddressOrg.addClass('required');
            orgAddressOrgError.text("This field is required").show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = orgAddressOrg;
            }
        }
        // Maxlength validation (200 characters) and regex validation
        else if (orgAddressValue.length > 200) {
            orgAddressOrg.addClass('required');
            orgAddressOrgError.text("Address cannot exceed 200 characters").show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = orgAddressOrg;
            }
        }
        // Regex validation for allowed characters
        else if (!addressRegex.test(orgAddressValue)) {
            orgAddressOrg.addClass('required');
            orgAddressOrgError.text("Only letters, digits, hyphen (-), comma (,), hash (#), parenthesis ( ), forward slash (/), and spaces are allowed").show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = orgAddressOrg;
            }
        }

        // Mobile number validation
        const $Orgmobile = $('#authsignatory_mobile');
        const $OrgMobileError = $('#OrgMobileAuthError');
        const OrgMobileValue = $Orgmobile.val().trim();
        const dataIdValue = $Orgmobile.attr('data-id');

        // Validate mobile number input
        if (OrgMobileValue === '') {
            $OrgMobileError.text('Mobile Number is required');
            $OrgMobileError.show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $Orgmobile;
            }
        } else if (OrgMobileValue.length !== 10) {
            $OrgMobileError.text('Mobile Number must be exactly 10 digit');
            $OrgMobileError.show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $Orgmobile;
            }
        } else if (dataIdValue === "0") {
            $OrgMobileError.text('Please verify your mobile number');
            $OrgMobileError.show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $Orgmobile;
            }
        } else if (dataIdValue === "1") {
            $OrgMobileError.hide();
        } else {
            $OrgMobileError.hide();
        }

        // Email validation
        const $OrgEmail = $('#emailauthsignatory');
        const $OrgEmailError = $('#OrgEmailAuthSignError');
        const OrgEmailValue = $OrgEmail.val().trim();
        const dataIdEmailValue = $OrgEmail.attr('data-id');

        // Validate Email input
        if (OrgEmailValue === '') {
            $OrgEmailError.text('Email is required');
            $OrgEmailError.show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $OrgEmail;
            }
        } else if (dataIdEmailValue === "0") {
            $OrgEmailError.text('Please verify your email');
            $OrgEmailError.show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $OrgEmail;
            }
        } else if (dataIdEmailValue === "1") {
            $OrgEmailError.hide();
        } else {
            $OrgEmailError.hide();
        }

        // PAN Number Validation
        const $OrgPAN = $('#OrgPAN');
        const $OrgPANError = $('#OrgPANError');
        const OrgPANValue = $OrgPAN.val().trim();

        // Validate PAN number input length
        if (OrgPANValue === '') {
            $OrgPAN.addClass('required');
            $OrgPANError.text('This field is required').show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $OrgPAN;
            }
        } else if (OrgPANValue.length !== 10) {
            $OrgPAN.addClass('required');
            $OrgPANError.text('PAN Number must be exactly 10 characters').show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $OrgPAN;
            }
        } else {
            $OrgPAN.removeClass('required');
            $OrgPANError.hide();
        }

        // Aadhaar Number Validation
        const $orgAadharAuth = $('#orgAadharAuth');
        const $orgAadharAuthError = $('#orgAadharAuthError');
        const orgAadharAuthValue = $orgAadharAuth.val().trim();

        // Validate PAN number input length
        if (orgAadharAuthValue === '') {
            $orgAadharAuth.addClass('required');
            $orgAadharAuthError.text('This field is required').show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $orgAadharAuth;
            }
        } else if (orgAadharAuthValue.length !== 12) {
            $orgAadharAuth.addClass('required');
            $orgAadharAuthError.text('Aadhar Number must be exactly 12 digit').show();
            isValid = false;
            if (firstInvalidField === null) {
                firstInvalidField = $orgAadharAuth;
            }
        } else {
            $orgAadharAuth.removeClass('required');
            $orgAadharAuthError.hide();
        }
        // Address details validation based on checkbox
        if ($('#YesOrg').is(':checked')) {
            const addressFieldsYes = $('#isPropertyFlatOrg').is(':checked') ? [
                { id: '#localityOrgFill', errorId: '#localityOrgFillError' },
                { id: '#blocknoOrgFill', errorId: '#blocknoOrgFillError' },
                { id: '#plotnoOrgFill', errorId: '#plotnoOrgFillError' },
                { id: '#landUseOrgFill', errorId: '#landUseOrgFillError' },
                { id: '#landUseSubtypeOrgFill', errorId: '#landUseSubtypeOrgFillError' },
                { id: '#flat_no_org_after_checked_Address_notfound', errorId: '#flat_no_org_after_checked_Address_notfoundError' }
            ]: [
                { id: '#localityOrgFill', errorId: '#localityOrgFillError' },
                { id: '#blocknoOrgFill', errorId: '#blocknoOrgFillError' },
                { id: '#plotnoOrgFill', errorId: '#plotnoOrgFillError' },
                { id: '#landUseOrgFill', errorId: '#landUseOrgFillError' },
                { id: '#landUseSubtypeOrgFill', errorId: '#landUseSubtypeOrgFillError' }
            ];
            addressFieldsYes.forEach(function (field) {
                const inputField = $(field.id);
                const errorField = $(field.errorId);

                // On change or input, hide the error message
                inputField.on('input', function () {
                    if (inputField.val().trim() !== "") {
                        inputField.removeClass('required');
                        errorField.hide();
                    }
                });


                if (inputField.val().trim() === "") {
                    inputField.addClass('required');
                    errorField.text("This field is required").show();
                    isValid = false;
                    if (firstInvalidField === null) {
                        firstInvalidField = inputField;
                    }
                } else {
                    inputField.removeClass('required');
                    errorField.hide();
                }
            });
        } else {

            const addressFieldsNo = [
                { id: '#locality_org', errorId: '#locality_orgError' },
                { id: '#block_org', errorId: '#block_orgError' },
                { id: '#plot_org', errorId: '#plot_orgError' },
                { id: '#landUse_org', errorId: '#landUse_orgError' },
                { id: '#landUseSubtype_org', errorId: '#landUseSubtype_orgError' }
            ];

            addressFieldsNo.forEach(function (field) {
                const inputField = $(field.id);
                const errorField = $(field.errorId);

                // On change or input, hide the error message
                inputField.on('input', function () {
                    if (inputField.val().trim() !== "") {
                        inputField.removeClass('required');
                        errorField.hide();
                    }
                });


                if (inputField.val().trim() === "") {
                    inputField.addClass('required');
                    errorField.text("This field is required").show();
                    isValid = false;
                    if (firstInvalidField === null) {
                        firstInvalidField = inputField;
                    }
                } else {
                    inputField.removeClass('required');
                    errorField.hide();
                }

                  // Helper function to validate a single field
        function validateField(fieldId, errorId, condition) {
            const inputField = $(fieldId);
            const errorField = $(errorId);

            // Add event listener to remove errors on user input
            inputField.on('input', function () {
                if (inputField.val().trim() !== "") {
                    inputField.removeClass('required');
                    errorField.hide();
                }
            });

            // Validation logic
            if (condition && inputField.val().trim() === "") {
                inputField.addClass('required');
                errorField.text("This field is required").show();
                isValid = false;
                if (firstInvalidField === null) {
                    firstInvalidField = inputField;
                }
            } else {
                inputField.removeClass('required');
                errorField.hide();
            }
        }
        // End

        // Check if the property is a flat
        if ($('#isPropertyFlatOrg').is(':checked')) {
            // If flat is not available
            if ($('#flatAvailableOrg').val() === "FlatNotAvailable" && $('#landUse_org').val() !== '' && $('#landUseSubtype_org').val() !== '') {
                validateField('#flat_no_org_rec_not_found', '#flat_no_org_rec_not_foundError', true);
            }

            // If flat is available
            if ($('#flatAvailableOrg').val() === "FlatAvailable" && $('#landUse_org').val() !== '' && $('#landUseSubtype_org').val() !== '') {
                // Validate the #flat field only if #isFlatNotInListOrg is not checked
                validateField('#flatOrg', '#flatOrgError', !$('#isFlatNotInListOrg').is(':checked'));

                // If #isFlatNotInListOrg is checked, validate #flat_no field
                if ($('#isFlatNotInListOrg').is(':checked')) {
                    validateField('#flat_no_org', '#flat_no_orgError', true);
                }
            }
        }
        // End
            });
        }
        const fileFields = [
            { id: '#OrgSaleDeedDoc', errorId: '#OrgSaleDeedDocError' },
            { id: '#OrgBuildAgreeDoc', errorId: '#OrgBuildAgreeDocError' },
            { id: '#OrgSubMutDoc', errorId: '#OrgSubMutDocError' },
            { id: '#OrgOther', errorId: '#OrgOtherError' }
        ];

        let isValidFiles = true;
        let firstInvalidFieldFiles = null;
        let atLeastOneFile = false;

        fileFields.forEach(function (field) {
            const inputField = $(field.id);
            const errorField = $(field.errorId);
            inputField.removeClass('required');
            errorField.hide();

            inputField.on('change', function () {
                const files = inputField[0].files;
                if (files.length > 0) {
                    let allFilesArePDF = true;

                    for (let i = 0; i < files.length; i++) {
                        const fileName = files[i].name;
                        if (!fileName.endsWith('.pdf')) {
                            allFilesArePDF = false;
                            break;
                        }
                    }

                    if (allFilesArePDF) {
                        inputField.removeClass('required');
                        errorField.hide();
                    } else {
                        inputField.addClass('required');
                        errorField.text("Only PDF files are allowed").show();
                        isValidFiles = false;
                        if (firstInvalidFieldFiles === null) {
                            firstInvalidFieldFiles = inputField;
                        }
                    }
                }
            });
        });

        fileFields.forEach(function (field) {
            const inputField = $(field.id);
            const errorField = $(field.errorId);
            const files = inputField[0].files;

            // Check if there are files in this input
            if (files.length > 0) {
                atLeastOneFile = true;

                let allFilesArePDF = true;
                for (let i = 0; i < files.length; i++) {
                    const fileName = files[i].name;
                    if (!fileName.endsWith('.pdf')) {
                        allFilesArePDF = false;
                        break;
                    }
                }

                // Show error message if not all files are PDF
                if (!allFilesArePDF) {
                    inputField.addClass('required');
                    errorField.text("Only PDF files are allowed").show();
                    isValidFiles = false;
                    if (firstInvalidFieldFiles === null) {
                        firstInvalidFieldFiles = inputField;
                    }
                }
            }
        });


        // Check if at least one file is selected
        if (!atLeastOneFile) {
            fileFields.forEach(function (field) {
                const inputField = $(field.id);
                const errorField = $(field.errorId);
                inputField.addClass('required');
                errorField.text("At least one file is required").show();
                isValidFiles = false;
                if (firstInvalidFieldFiles === null) {
                    firstInvalidFieldFiles = inputField;
                }
            });
        }

        if (firstInvalidFieldFiles) {
            firstInvalidFieldFiles.focus();
        }
        const fileFields2 = [
            { id: '#OrgSignAuthDoc', errorId: '#OrgSignAuthDocError' },
            { id: '#scannedIDOrg', errorId: '#scannedIDOrgError' },
            { id: '#OrgLeaseDeedDoc', errorId: '#OrgLeaseDeedDocError' }
        ];

        let isValidFiles2 = true;
        let firstInvalidFieldFiles2 = null;

        fileFields2.forEach(function (field) {
            const inputField = $(field.id);
            const errorField = $(field.errorId);
            inputField.removeClass('required');
            errorField.hide();

            inputField.on('change', function () {
                const files = inputField[0].files;
                if (files.length > 0) {
                    let allFilesArePDF = true;

                    for (let i = 0; i < files.length; i++) {
                        const fileName = files[i].name;
                        if (!fileName.endsWith('.pdf')) {
                            allFilesArePDF = false;
                            break;
                        }
                    }

                    if (allFilesArePDF) {
                        inputField.removeClass('required');
                        errorField.hide();
                    } else {
                        inputField.addClass('required');
                        errorField.text("Only PDF files are allowed").show();
                        isValidFiles2 = false;
                        if (firstInvalidFieldFiles2 === null) {
                            firstInvalidFieldFiles2 = inputField;
                        }
                    }
                }
            });
        });

        // Validate all fields
        fileFields2.forEach(function (field) {
            const inputField = $(field.id);
            const errorField = $(field.errorId);
            const files = inputField[0].files;

            // Check if files exist in this input
            if (files.length > 0) {
                let allFilesArePDF = true;
                for (let i = 0; i < files.length; i++) {
                    const fileName = files[i].name;
                    if (!fileName.endsWith('.pdf')) {
                        allFilesArePDF = false;
                        break;
                    }
                }

                // Show error if not all files are PDFs
                if (!allFilesArePDF) {
                    inputField.addClass('required');
                    errorField.text("Only PDF files are allowed").show();
                    isValidFiles2 = false;
                    if (firstInvalidFieldFiles2 === null) {
                        firstInvalidFieldFiles2 = inputField;
                    }
                }
            } else {
                // Show error if no file is selected
                inputField.addClass('required');
                errorField.text("This field is required").show();
                isValidFiles2 = false;
                if (firstInvalidFieldFiles2 === null) {
                    firstInvalidFieldFiles2 = inputField;
                }
            }
        });

        if (firstInvalidFieldFiles2 !== null && firstInvalidField === null) {
            firstInvalidField = firstInvalidFieldFiles2;
        }

        // Adjusting firstInvalidField handling to avoid overwrites
        if (firstInvalidFieldFiles !== null && firstInvalidField === null) {
            firstInvalidField = firstInvalidFieldFiles;
        }

        if (firstInvalidField !== null) {
            firstInvalidField.focus();
        }

        // Agreement checkbox validation
    //     const consentField = $('#OrgConsent');
    //     const consentErrorField = $('#OrgConsentError');

    //     if (!consentField.is(':checked')) {
    //         consentField.addClass('required');
    //         consentErrorField.text("You must agree to the terms").show();
    //         isValid = false;
    //     } else {
    //         consentField.removeClass('required');
    //         consentErrorField.hide();
    //     }

    //     if (firstInvalidField !== null) {
    //         firstInvalidField.focus();
    //     }

    //     return isValid && isValidFiles && isValidFiles2;
    // }

    const consentField = $('#OrgConsent');
    const consentErrorField = $('#OrgConsentError');

    if (!consentField.is(':checked')) {
        consentField.addClass('required');
        consentErrorField.text("You must agree to the terms").show();
        isValid = false;
    } else {
        consentField.removeClass('required');
        consentErrorField.hide();
    }

    // Focus the first invalid field (except for OrgConsent)
    if (firstInvalidField !== null) {
        firstInvalidField.focus();
    }

    return isValid && isValidFiles && isValidFiles2;
}

});
