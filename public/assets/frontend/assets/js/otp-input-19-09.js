document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('otp-form')
    const inputs = [...form.querySelectorAll('input[type=text]')]
    const submit = form.querySelector('#verifyMobileOtpBtn')


    const form2 = document.getElementById('otp-form-email')
    const inputs2 = [...form2.querySelectorAll('input[type=text]')]
    const submit2 = form2.querySelector('#verifyEmailOtpBtn')


    const form3 = document.getElementById('org-otp-form')
    const inputs3 = [...form3.querySelectorAll('input[type=text]')]
    const submit3 = form3.querySelector('#orgVerifyMobileOtpBtn')

    const form4 = document.getElementById('org-otp-form-email')
    const inputs4 = [...form4.querySelectorAll('input[type=text]')]
    const submit4 = form4.querySelector('#orgVerifyEmailOtpBtn')



    const handleKeyDown = (e) => {
        if (
            !/^[0-9]{1}$/.test(e.key)
            && e.key !== 'Backspace'
            && e.key !== 'Delete'
            && e.key !== 'Tab'
            && !e.metaKey
        ) {
            e.preventDefault()
        }

        if (e.key === 'Delete' || e.key === 'Backspace') {
            const index = inputs.indexOf(e.target);
            if (index > 0) {
                inputs[index - 1].value = '';
                inputs[index - 1].focus();
            }

            const index2 = inputs2.indexOf(e.target);
            if (index2 > 0) {
                inputs2[index2 - 1].value = '';
                inputs2[index2 - 1].focus();
            }

            const index3 = inputs3.indexOf(e.target);
            if (index3 > 0) {
                inputs3[index3 - 1].value = '';
                inputs3[index3 - 1].focus();
            }

            const index4 = inputs4.indexOf(e.target);
            if (index4 > 0) {
                inputs4[index4 - 1].value = '';
                inputs4[index4 - 1].focus();
            }
        }
    }

    const handleInput = (e) => {
        const { target } = e
        const index = inputs.indexOf(target)
        if (target.value) {
            if (index < inputs.length - 1) {
                inputs[index + 1].focus()
            } else {
                submit.focus()
            }
        }
    }
    const handleInput2 = (e) => {
        const { target } = e
        const index2 = inputs2.indexOf(target)
        if (target.value) {
            if (index2 < inputs2.length - 1) {
                inputs2[index2 + 1].focus()
            } else {
                submit2.focus()
            }
        }
    }

    const handleInput3 = (e) => {
        const { target } = e
        const index3 = inputs3.indexOf(target)
        if (target.value) {
            if (index3 < inputs3.length - 1) {
                inputs3[index3 + 1].focus()
            } else {
                submit3.focus()
            }
        }
    }

    const handleInput4 = (e) => {
        const { target } = e
        const index4 = inputs4.indexOf(target)
        if (target.value) {
            if (index4 < inputs4.length - 1) {
                inputs4[index4 + 1].focus()
            } else {
                submit4.focus()
            }
        }
    }

    const handleFocus = (e) => {
        e.target.select()
    }

    const handlePaste = (e) => {
        e.preventDefault()
        const text = e.clipboardData.getData('text')
        if (!new RegExp(`^[0-9]{${inputs.length}}$`).test(text)) {
            return
        }
        const digits = text.split('')
        inputs.forEach((input, index) => input.value = digits[index])
        submit.focus()

        if (!new RegExp(`^[0-9]{${inputs2.length}}$`).test(text)) {
            return
        }
        inputs2.forEach((input, index) => input.value = digits[index])
        submit2.focus()


        if (!new RegExp(`^[0-9]{${inputs3.length}}$`).test(text)) {
            return
        }
        inputs3.forEach((input, index) => input.value = digits[index])
        submit3.focus()

        if (!new RegExp(`^[0-9]{${inputs4.length}}$`).test(text)) {
            return
        }
        inputs4.forEach((input, index) => input.value = digits[index])
        submit4.focus()
    }

    inputs.forEach((input) => {
        input.addEventListener('input', handleInput)
        input.addEventListener('keydown', handleKeyDown)
        input.addEventListener('focus', handleFocus)
        input.addEventListener('paste', handlePaste)
    })

    inputs2.forEach((input) => {
        input.addEventListener('input', handleInput2)
        input.addEventListener('keydown', handleKeyDown)
        input.addEventListener('focus', handleFocus)
        input.addEventListener('paste', handlePaste)
    })

    inputs3.forEach((input) => {
        input.addEventListener('input', handleInput3)
        input.addEventListener('keydown', handleKeyDown)
        input.addEventListener('focus', handleFocus)
        input.addEventListener('paste', handlePaste)
    })

    inputs4.forEach((input) => {
        input.addEventListener('input', handleInput4)
        input.addEventListener('keydown', handleKeyDown)
        input.addEventListener('focus', handleFocus)
        input.addEventListener('paste', handlePaste)
    })
})


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
    $('.pan_number_format').on('keypress', function (event) {
        var charCode = event.which;

        if (charCode === 0 || charCode === 8 || charCode === 9 || charCode === 13) {
            return;
        }

        var charStr = String.fromCharCode(charCode).toUpperCase();

        var currentLength = $(this).val().length;

        if (currentLength < 5 && !/[A-Z]/.test(charStr)) {
            event.preventDefault();
        }

        else if (currentLength >= 5 && currentLength < 9 && !/[0-9]/.test(charStr)) {
            event.preventDefault();
        }

        else if (currentLength === 9 && !/[A-Z]/.test(charStr)) {
            event.preventDefault();
        }
    });
});

// Required Validation - 31-07-2024 by Diwakar Sinha

document.addEventListener('DOMContentLoaded', function () {
    var form1 = document.getElementById('propertyownerDiv');

    // Form 1 Fields
    var IndFullName = document.getElementById('indfullname');
    var IndGender = document.getElementById('Indgender');
    var IndSecondName = document.getElementById('IndSecondName');
    var Indmobile = document.getElementById('mobileInv');
    var IndEmail = document.getElementById('emailInv');
    var IndPanNumber = document.getElementById('IndPanNumber');
    var IndAadhar = document.getElementById('IndAadhar');

    var IndSaleDeed = document.getElementById('IndSaleDeed');
    var IndBuildAgree = document.getElementById('IndBuildAgree');
    var IndLeaseDeed = document.getElementById('IndLeaseDeed');
    var IndSubMut = document.getElementById('IndSubMut');

    var IndOwnerLess = document.getElementById('IndOwnerLess');

    // Form 1 Errors
    var IndFullNameError = document.getElementById('IndFullNameError');
    var IndGenderError = document.getElementById('IndGenderError');
    var IndSecondNameError = document.getElementById('IndSecondNameError');
    var IndMobileError = document.getElementById('IndMobileError');
    var IndEmailError = document.getElementById('IndEmailError');
    var IndPanNumberError = document.getElementById('IndPanNumberError');
    var IndAadharError = document.getElementById('IndAadharError');

    var IndSaleDeedError = document.getElementById('IndSaleDeedError');
    var IndBuildAgreeError = document.getElementById('IndBuildAgreeError');
    var IndLeaseDeedError = document.getElementById('IndLeaseDeedError');
    var IndSubMutError = document.getElementById('IndSubMutError');

    var IndOwnerLessError = document.getElementById('IndOwnerLessError');


    function validateIndFullName() {
        var IndFullNameValue = IndFullName.value.trim();
        if (IndFullNameValue === '') {
            IndFullNameError.textContent = 'Full Name is required';
            IndFullNameError.style.display = 'block';
            return false;
        } else {
            IndFullNameError.style.display = 'none';
            return true;
        }
    }

    function validateIndGender() {
        var IndGenderValue = IndGender.value.trim();
        if (IndGenderValue === '') {
            IndGenderError.textContent = 'Gender is required';
            IndGenderError.style.display = 'block';
            return false;
        } else {
            IndGenderError.style.display = 'none';
            return true;
        }
    }

    function validateIndSecondName() {
        var IndSecondNameValue = IndSecondName.value.trim();
        if (IndSecondNameValue === '') {
            IndSecondNameError.textContent = 'Full Name is required';
            IndSecondNameError.style.display = 'block';
            return false;
        } else {
            IndSecondNameError.style.display = 'none';
            return true;
        }
    }

    function validateIndMobile() {
        var IndMobileValue = Indmobile.value.trim();
        if (IndMobileValue === '') {
            IndMobileError.textContent = 'Mobile Number is required';
            IndMobileError.style.display = 'block';
            return false;
        } else {
            IndMobileError.style.display = 'none';
            return true;
        }
    }

    // function validateIndEmail() {
    //     var IndEmailValue = IndEmail.value.trim();
    //     if (IndEmailValue === '') {
    //         IndEmailError.textContent = 'Email is required';
    //         IndEmailError.style.display = 'block';
    //         return false;
    //     } else {
    //         IndEmailError.style.display = 'none';
    //         return true;
    //     }
    // }

    function validateIndEmail() {
        var IndEmailValue = IndEmail.value.trim();
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
        if (IndEmailValue === '') {
            IndEmailError.textContent = 'Email is required';
            IndEmailError.style.display = 'block';
            return false;
        } else if (!emailPattern.test(IndEmailValue)) {
            IndEmailError.textContent = 'Invalid email format';
            IndEmailError.style.display = 'block';
            return false;
        } else {
            IndEmailError.style.display = 'none';
            return true;
        }
    }

    
    function validateIndPAN() {
        var IndPanNumberValue = IndPanNumber.value.trim();
        if (IndPanNumberValue === '') {
            IndPanNumberError.textContent = 'PAN Number is required';
            IndPanNumberError.style.display = 'block';
            return false;
        } else {
            IndPanNumberError.style.display = 'none';
            return true;
        }
    }

    function validateIndAadhar() {
        var IndAadharValue = IndAadhar.value.trim();
        if (IndAadharValue === '') {
            IndAadharError.textContent = 'Aadhar Number is required';
            IndAadharError.style.display = 'block';
            return false;
        } else {
            IndAadharError.style.display = 'none';
            return true;
        }
    }

    // Doc

    function validateIndSaleDeed() {
        if (IndSaleDeed.files.length === 0) {
            IndSaleDeedError.textContent = 'This file is required';
            IndSaleDeedError.style.display = 'block';
            return false;
        } else {
            var file = IndSaleDeed.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                IndSaleDeedError.textContent = 'Only PDF files are allowed';
                IndSaleDeedError.style.display = 'block';
                return false;
            } else {
                IndSaleDeedError.style.display = 'none';
                return true;
            }
        }
    }
    

    function validateIndBuildAgree() {
        if (IndBuildAgree.files.length === 0) {
            IndBuildAgreeError.textContent = 'This file is required';
            IndBuildAgreeError.style.display = 'block';
            return false;
        } else {
            var file = IndBuildAgree.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                IndBuildAgreeError.textContent = 'Only PDF files are allowed';
                IndBuildAgreeError.style.display = 'block';
                return false;
            } else {
                IndBuildAgreeError.style.display = 'none';
                return true;
            }
        }
    }

    function validateIndLeaseDeed() {
        if (IndLeaseDeed.files.length === 0) {
            IndLeaseDeedError.textContent = 'This file is required';
            IndLeaseDeedError.style.display = 'block';
            return false;
        } else {
            var file = IndLeaseDeed.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                IndLeaseDeedError.textContent = 'Only PDF files are allowed';
                IndLeaseDeedError.style.display = 'block';
                return false;
            } else {
                IndLeaseDeedError.style.display = 'none';
                return true;
            }
        }
    }

    function validateIndSubMut() {
        if (IndSubMut.files.length === 0) {
            IndSubMutError.textContent = 'This file is required';
            IndSubMutError.style.display = 'block';
            return false;
        } else {
            var file = IndSubMut.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                IndSubMutError.textContent = 'Only PDF files are allowed';
                IndSubMutError.style.display = 'block';
                return false;
            } else {
                IndSubMutError.style.display = 'none';
                return true;
            }
        }
    }

    function validateIndOwnerLess() {
        if (IndOwnerLess.files.length === 0) {
            IndOwnerLessError.textContent = 'This file is required';
            IndOwnerLessError.style.display = 'block';
            return false;
        } else {
            var file = IndOwnerLess.files[0];
            var fileType = file.type;
            var fileName = file.name;
            var validExtension = /(\.pdf)$/i;
    
            if (!validExtension.test(fileName)) {
                IndOwnerLessError.textContent = 'Only PDF files are allowed';
                IndOwnerLessError.style.display = 'block';
                return false;
            } else {
                IndOwnerLessError.style.display = 'none';
                return true;
            }
        }
    }



    // Validate Form 1
    function validateForm1() {
        var isIndFullNameValid = validateIndFullName();
        var isIndGenderValid = validateIndGender();
        var isIndSecondNameValid = validateIndSecondName();
        var isIndMobileValid = validateIndMobile();
        var isIndEmailValid = validateIndEmail();
        var isIndPANValid = validateIndPAN();
        var isIndAadharValid = validateIndAadhar();
        // Doc
        var isIndSaleDeedValid = validateIndSaleDeed();
        var isIndBuildAgreeValid = validateIndBuildAgree();
        var isIndLeaseDeedValid = validateIndLeaseDeed();
        var isIndSubMutValid = validateIndSubMut();

        var isIndOwnerLessValid = validateIndOwnerLess();

        return isIndFullNameValid && isIndGenderValid && isIndSecondNameValid && isIndMobileValid && isIndEmailValid && isIndPANValid && isIndAadharValid && isIndSaleDeedValid && isIndBuildAgreeValid && isIndLeaseDeedValid && isIndSubMutValid && isIndOwnerLessValid;
    }


    form1.addEventListener('button', function (event) {
        event.preventDefault();
        if (validateForm1()) {
            alert('Form submitted successfully');
        }
    });


    var IndsubmitButton = document.getElementById('IndsubmitButton');
    IndsubmitButton.addEventListener('click', function () {
        if (validateForm1()) {
            this.removeAttribute("type", "submit");
        } else {
            this.setAttribute("type", "button");
        }
    });

})