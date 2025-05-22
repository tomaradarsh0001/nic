// Vacant MIS Form Vaidation
//************************************************************************************************************************************** */

// JavaScript - script.js
document.addEventListener('DOMContentLoaded', function () {
  var vacantform1 = document.getElementById('test-vl-1');
  var vacantform2 = document.getElementById('test-vl-2');

  // vacantform 1 Fields
    // Form 1 Fields
    var FileNumberVacant = document.getElementById('FileNumberNew');
    var PresentColonyNameVacant = document.getElementById('colonyNameNew');
    var OldColonyNameVacant = document.getElementById('ColonyNameOldNew');
    var PropertyStatusVacant = document.getElementById('PropertyStatusNew');
    var LandTypeVacant = document.getElementById('LandTypeNew');
  
    // Form 1 Errors
    var FileNumberVacantError = document.getElementById('FileNumberVacantError');
    var PresentColonyNameVacantError = document.getElementById('PresentColonyNameVacantError');
    var OldColonyNameVacantError = document.getElementById('OldColonyNameVacantError');
    var PropertyStatusVacantError = document.getElementById('PropertyStatusVacantError');
    var LandTypeVacantError = document.getElementById('LandTypeVacantError');

    function validateFileNumberVacant() {
      var FileNumberVacantValue = FileNumberVacant.value.trim();
      if (FileNumberVacantValue === '') {
        FileNumberVacantError.textContent = 'File Number is required';
        FileNumberVacantError.style.display = 'block';
        return false;
      } else {
        FileNumberVacantError.style.display = 'none';
        return true;
      }
    }
  
    function validatePresentColonyNameVacant() {
      var PresentColonyNameVacantValue = PresentColonyNameVacant.value.trim();
      if (PresentColonyNameVacantValue === '') {
        PresentColonyNameVacantError.textContent = 'Present Colony Name is required';
        PresentColonyNameVacantError.style.display = 'block';
        return false;
      } else {
        PresentColonyNameVacantError.style.display = 'none';
        return true;
      }
    }
  
    function validateOldColonyNameVacant() {
      var OldColonyNameVacantValue = OldColonyNameVacant.value.trim();
      if (OldColonyNameVacantValue === '') {
        OldColonyNameVacantError.textContent = 'Old Colony Name is required';
        OldColonyNameVacantError.style.display = 'block';
        return false;
      } else {
        OldColonyNameVacantError.style.display = 'none';
        return true;
      }
    }
  
    function validatePropertyStatusVacant() {
      var PropertyStatusVacantValue = PropertyStatusVacant.value.trim();
      if (PropertyStatusVacantValue === '') {
        PropertyStatusVacantError.textContent = 'Property Status is required';
        PropertyStatusVacantError.style.display = 'block';
        return false;
      } else {
        PropertyStatusVacantError.style.display = 'none';
        return true;
      }
    }
  
    function validateLandTypeVacant() {
      var LandTypeVacantValue = LandTypeVacant.value.trim();
      if (LandTypeVacantValue === '') {
        LandTypeVacantError.textContent = 'Land Type is required';
        LandTypeVacantError.style.display = 'block';
        return false;
      } else {
        LandTypeVacantError.style.display = 'none';
        return true;
      }
    }

      // Validate Vacant Form 1
  function validateFormVacant1() {
    var isFileNumberVacantValid = validateFileNumberVacant();
    var isPresentColonyNameVacantValid = validatePresentColonyNameVacant();
    var isOldColonyNameVacantValid = validateOldColonyNameVacant();
    var isPropertyStatusVacantValid = validatePropertyStatusVacant();
    var isLandTypeVacantValid = validateLandTypeVacant();

    return isFileNumberVacantValid && isPresentColonyNameVacantValid && isOldColonyNameVacantValid && isPropertyStatusVacantValid && isLandTypeVacantValid;
  }

  // vacantform 2 Fields
  var vacantplotno = document.getElementById('vacantplotno');
  var vacantareaunitname = document.getElementById('vacantareaunitname');
  var selectvacantareaunit = document.getElementById('selectvacantareaunit');

  // vacantform 2 Errors
  var vacantplotnoError = document.getElementById('vacantplotnoError');
  var vacantareaunitnameError = document.getElementById('vacantareaunitnameError');
  var selectvacantareaunitError = document.getElementById('selectvacantareaunitError');


  function validatevacantplotno() {
    var vacantplotnoValue = vacantplotno.value.trim();
    if (vacantplotnoValue === '') {
      vacantplotnoError.textContent = 'Plot Number is required';
      vacantplotnoError.style.display = 'block';
      return false;
    } else {
      vacantplotnoError.style.display = 'none';
      return true;
    }
  }

  function validateVacantArea() {
    var vacantareaunitnameValue = vacantareaunitname.value.trim();
    if (vacantareaunitnameValue === '') {
      vacantareaunitnameError.textContent = 'Area is required';
      vacantareaunitnameError.style.display = 'block';
      return false;
    } else {
      vacantareaunitnameError.style.display = 'none';
      return true;
    }
  }

  function validateVacantAreaUnit() {
    var selectvacantareaunitValue = selectvacantareaunit.value.trim();
    if (selectvacantareaunitValue === '') {
      selectvacantareaunitError.textContent = 'Unit is required';
      selectvacantareaunitError.style.display = 'block';
      return false;
    } else {
      selectvacantareaunitError.style.display = 'none';
      return true;
    }
  }


  // Validate Form 1
  function validateVacantForm2() {
    var isvacantplotnoValid = validatevacantplotno();
    var isVacantAreaValid = validateVacantArea();
    var isVacantAreaUnitValid = validateVacantAreaUnit();

    return isvacantplotnoValid && isVacantAreaValid && isVacantAreaUnitValid;
  }


  // vacantform 21 Fields
  var selectDepartment = document.getElementById('selectDepartment');
  var dateOfTransferAuth = document.getElementById('dateOfTransferAuth');
  var purposeAuth = document.getElementById('purposeAuth');

  // vacantform 21 Errors
  var selectDepartmentError = document.getElementById('selectDepartmentError');
  var dateOfTransferAuthError = document.getElementById('dateOfTransferAuthError');
  var purposeAuthError = document.getElementById('purposeAuthError');


  function validateselectDepartment() {
    var selectDepartmentValue = selectDepartment.value.trim();
    if (selectDepartmentValue === '') {
      selectDepartmentError.textContent = 'Authority/Department is required';
      selectDepartmentError.style.display = 'block';
      return false;
    } else {
      selectDepartmentError.style.display = 'none';
      return true;
    }
  }

  function validatedateOfTransferAuth() {
    var dateOfTransferAuthValue = dateOfTransferAuth.value.trim();
    if (dateOfTransferAuthValue === '') {
      dateOfTransferAuthError.textContent = 'Date of Transfer is required';
      dateOfTransferAuthError.style.display = 'block';
      return false;
    } else {
      dateOfTransferAuthError.style.display = 'none';
      return true;
    }
  }

  function validatepurposeAuth() {
    var purposeAuthValue = purposeAuth.value.trim();
    if (purposeAuthValue === '') {
      purposeAuthError.textContent = 'Purpose is required';
      purposeAuthError.style.display = 'block';
      return false;
    } else {
      purposeAuthError.style.display = 'none';
      return true;
    }
  }

  function validateVacantForm21() {
    var isselectDepartmentValid = validateselectDepartment();
    var isdateOfTransferAuthValid = validatedateOfTransferAuth();
    var ispurposeAuthValid = validatepurposeAuth();

    return isselectDepartmentValid && isdateOfTransferAuthValid && ispurposeAuthValid;
  }
  

  vacantform1.addEventListener('button', function (event) {
    event.preventDefault();
    if (validateFormVacant1()) {
      alert('Form submitted successfully');
      // You can submit the form here using AJAX or other methods
    }
  });


  var vacantsubmitButton1 = document.getElementById('vacantsubmitButton1');
  vacantsubmitButton1.addEventListener('click', function () {
    if (validateFormVacant1()) {
      stepper2.next()
    }
  });

  // Get required elements
const btnFinalSubmitUnallocated = document.getElementById('btnfinalsubmitunallocated');
const transferredAuthYes = document.getElementById('transferredAuthYes');

// Updated Event Listener
btnFinalSubmitUnallocated.addEventListener('click', function (event) {
  event.preventDefault(); // Prevent form submission initially

  // Check the state of the radio button
  const isTransferredYes = transferredAuthYes.checked;

  // Run validations
  const isForm2Valid = validateVacantForm2();
  let isForm21Valid = true; // Default to true when not checked

  if (isTransferredYes) {
    // Only validate VacantForm21 if transferredAuthYes is checked
    isForm21Valid = validateVacantForm21();
  }

  // Combine validation results
  const isValid = isForm2Valid && isForm21Valid;

  if (isValid) {
    console.log("Validation passed. Submitting the form...");
    this.setAttribute('type', 'submit'); // Allow form submission
    this.form.submit(); // Submit the form programmatically if needed
  } else {
    console.log("Validation failed.");
    this.setAttribute('type', 'button'); // Keep as button
  }
});




});