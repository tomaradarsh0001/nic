const transferredCheckboxYes = document.getElementById("transferredFormYes");

const transferredContainer = document.getElementById("transferredContainer");

transferredCheckboxYes.addEventListener("change", function () {
  if (this.checked) {
    transferredContainer.style.display = "block"; // Show the div if checkbox is checked
  } else {
    transferredContainer.style.display = "none"; // Hide the div if checkbox is not checked
  }
});

// Free Hold

const freeHoldCheckboxYes = document.getElementById("freeHoldFormYes");
const freeHoldCheckboxNo = document.getElementById("freeHoldFormNo");

$(document).on("change", 'input[id^="freeHoldFormYes"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("freeHoldFormYes", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  const freeHoldContainer =
    index == 0 ? $("#freeHoldContainer") : $("#freeHoldContainer" + index);
  var isChecked = $(this).is(":checked");
  if (isChecked) {
    freeHoldContainer.show();
  } else {
    freeHoldContainer.hide();
  }
});

$(document).on("change", 'input[id^="freeHoldFormNo"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("freeHoldFormNo", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  const freeHoldContainer =
    index == 0 ? $("#freeHoldContainer") : $("#freeHoldContainer" + index);
  var isChecked = $(this).is(":checked");
  if (isChecked) {
    freeHoldContainer.hide();
  } else {
    freeHoldContainer.show();
  }
});

// Land Type: Vacant

const landTypeCheckboxYes = document.getElementById("landTypeFormYes");
const landTypeCheckboxNo = document.getElementById("landTypeFormNo");

$(document).on("change", 'input[id^="landTypeFormYes"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("landTypeFormYes", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  const landTypeContainer =
    index == 0 ? $("#landTypeContainer") : $("#landTypeContainer" + index);
  var isChecked = $(this).is(":checked");
  if (isChecked) {
    landTypeContainer.show();
  } else {
    landTypeContainer.hide();
  }
});

$(document).on("change", 'input[id^="landTypeFormNo"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("landTypeFormNo", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  const landTypeContainer =
    index == 0 ? $("#landTypeContainer") : $("#landTypeContainer" + index);
  var isChecked = $(this).is(":checked");
  if (isChecked) {
    landTypeContainer.hide();
  } else {
    landTypeContainer.show();
  }
});

// Land Type : Others

const landTypeOthersCheckboxYes = document.getElementById(
  "landTypeFormOthersYes"
);
const landTypeOthersCheckboxNo = document.getElementById(
  "landTypeFormOthersNo"
);

$(document).on("change", 'input[id^="landTypeFormOthersYes"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("landTypeFormOthersYes", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  const landTypeOthersContainer =
    index == 0
      ? $("#landTypeOthersContainer")
      : $("#landTypeOthersContainer" + index);
  var isChecked = $(this).is(":checked");
  if (isChecked) {
    landTypeOthersContainer.show();
  } else {
    landTypeOthersContainer.hide();
  }
});

$(document).on("change", 'input[id^="landTypeFormOthersNo"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("landTypeFormOthersNo", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  const landTypeOthersContainer =
    index == 0
      ? $("#landTypeOthersContainer")
      : $("#landTypeOthersContainer" + index);
  var isChecked = $(this).is(":checked");
  if (isChecked) {
    landTypeOthersContainer.hide();
  } else {
    landTypeOthersContainer.show();
  }
});

// MISCELLANEOUS DETAILS: GR Revised Ever

const GRCheckboxYes = document.getElementById("GRFormYes");
const GRCheckboxNo = document.getElementById("GRFormNo");

$(document).on("change", 'input[id^="GRFormYes"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("GRFormYes", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  const GRContainer =
    index == 0 ? $("#GRContainer") : $("#GRContainer" + index);
  var isChecked = $(this).is(":checked");
  if (isChecked) {
    GRContainer.show();
  } else {
    GRContainer.hide();
  }
});

$(document).on("change", 'input[id^="GRFormNo"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("GRFormNo", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  const GRContainer =
    index == 0 ? $("#GRContainer") : $("#GRContainer" + index);
  var isChecked = $(this).is(":checked");
  if (isChecked) {
    GRContainer.hide();
  } else {
    GRContainer.show();
  }
});

// MISCELLANEOUS DETAILS: Supplementary

const SupplementaryCheckboxYes = document.getElementById(
  "SupplementaryFormYes"
);
const SupplementaryCheckboxNo = document.getElementById("SupplementaryFormNo");

$(document).on("change", 'input[id^="SupplementaryFormYes"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("SupplementaryFormYes", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  const SupplementaryContainer =
    index == 0
      ? $("#SupplementaryContainer")
      : $("#SupplementaryContainer" + index);
  var isChecked = $(this).is(":checked");
  if (isChecked) {
    SupplementaryContainer.show();
  } else {
    SupplementaryContainer.hide();
  }
});

$(document).on("change", 'input[id^="SupplementaryFormNo"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("SupplementaryFormNo", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  const SupplementaryContainer =
    index == 0
      ? $("#SupplementaryContainer")
      : $("#SupplementaryContainer" + index);
  var isChecked = $(this).is(":checked");
  if (isChecked) {
    SupplementaryContainer.hide();
  } else {
    SupplementaryContainer.show();
  }
});

// MISCELLANEOUS DETAILS: Re-Entered

const ReenteredCheckboxYes = document.getElementById("ReenteredFormYes");
const ReenteredCheckboxNo = document.getElementById("ReenteredFormNo");

$(document).on("change", 'input[id^="ReenteredFormYes"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("ReenteredFormYes", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  const ReenteredContainer =
    index == 0 ? $("#ReenteredContainer") : $("#ReenteredContainer" + index);
  var isChecked = $(this).is(":checked");
  if (isChecked) {
    ReenteredContainer.show();
  } else {
    ReenteredContainer.hide();
  }
});

$(document).on("change", 'input[id^="ReenteredFormNo"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("ReenteredFormNo", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  const ReenteredContainer =
    index == 0 ? $("#ReenteredContainer") : $("#ReenteredContainer" + index);
  var isChecked = $(this).is(":checked");
  if (isChecked) {
    ReenteredContainer.hide();
  } else {
    ReenteredContainer.show();
  }
});

// MIS Form Vaidation
//************************************************************************************************************************************** */

// JavaScript - script.js
document.addEventListener("DOMContentLoaded", function () {
  var form1 = document.getElementById("test-vl-1");
  var form2 = document.getElementById("test-vl-2");
  var form3 = document.getElementById("test-vl-3");
  var form4 = document.getElementById("test-vl-4");
  var form5 = document.getElementById("test-vl-5");
  var form6 = document.getElementById("test-vl-6");
  var form7 = document.getElementById("test-vl-7");

  // Form 1 Fields
  var FileNumber = document.getElementById("FileNumber");
  var PresentColonyName = document.getElementById("colonyName");
  var OldColonyName = document.getElementById("ColonyNameOld");
  var PropertyStatus = document.getElementById("PropertyStatus");
  var LandType = document.getElementById("LandType");

  // Form 1 Errors
  var FileNumberError = document.getElementById("FileNumberError");
  var PresentColonyNameError = document.getElementById(
    "PresentColonyNameError"
  );
  var OldColonyNameError = document.getElementById("OldColonyNameError");
  var PropertyStatusError = document.getElementById("PropertyStatusError");
  var LandTypeError = document.getElementById("LandTypeError");

  function validateFileNumber() {
    var FileNumberValue = FileNumber.value.trim();
    if (FileNumberValue === "") {
      FileNumberError.textContent = "File Number is required";
      FileNumberError.style.display = "block";
      return false;
    } else {
      FileNumberError.style.display = "none";
      return true;
    }
  }

  function validatePresentColonyName() {
    var PresentColonyNameValue = PresentColonyName.value.trim();
    if (PresentColonyNameValue === "") {
      PresentColonyNameError.textContent = "Present Colony Name is required";
      PresentColonyNameError.style.display = "block";
      return false;
    } else {
      PresentColonyNameError.style.display = "none";
      return true;
    }
  }

  function validateOldColonyName() {
    var OldColonyNameValue = OldColonyName.value.trim();
    if (OldColonyNameValue === "") {
      OldColonyNameError.textContent = "Old Colony Name is required";
      OldColonyNameError.style.display = "block";
      return false;
    } else {
      OldColonyNameError.style.display = "none";
      return true;
    }
  }

  function validatePropertyStatus() {
    var PropertyStatusValue = PropertyStatus.value.trim();
    if (PropertyStatusValue === "") {
      PropertyStatusError.textContent = "Property Status is required";
      PropertyStatusError.style.display = "block";
      return false;
    } else {
      PropertyStatusError.style.display = "none";
      return true;
    }
  }

  function validateLandType() {
    var LandTypeValue = LandType.value.trim();
    if (LandTypeValue === "") {
      LandTypeError.textContent = "Land Type is required";
      LandTypeError.style.display = "block";
      return false;
    } else {
      LandTypeError.style.display = "none";
      return true;
    }
  }

  // Form 2 Fields
  var TypeLease = document.getElementById("TypeLease");
  var dateexecution = document.getElementById("dateexecution");
  var leaseExpDuration = document.getElementById("lease_exp_duration");
  var plotno = document.getElementById("plotno");
  var areaunitname = document.getElementById("areaunitname");
  var selectareaunit = document.getElementById("selectareaunit");
  var premiumunit1 = document.getElementById("premiumunit1");
  var premiumunit2 = document.getElementById("premiumunit2");
  var selectpremiumunit = document.getElementById("selectpremiumunit");
  var groundRent1 = document.getElementById("groundRent1");
  var groundRent2 = document.getElementById("groundRent2");
  var selectGroundRentUnit = document.getElementById("selectGroundRentUnit");
  var startdateGR = document.getElementById("startdateGR");
  var RGRduration = document.getElementById("RGRduration");
  var frevisiondateGR = document.getElementById("frevisiondateGR");
  var oldPropertyType = document.getElementById("oldPropertyType");
  var oldPropertySubType = document.getElementById("oldPropertySubType");
  var propertyType = document.getElementById("propertyType");
  var propertySubType = document.getElementById("propertySubType");

  // Form 2 Errors
  var TypeLeaseError = document.getElementById("TypeLeaseError");
  var dateexecutionError = document.getElementById("dateexecutionError");
  var leaseExpDurationError = document.getElementById("leaseExpDurationError");
  var dateallotmentError = document.getElementById("dateallotmentError");
  var plotnoError = document.getElementById("plotnoError");
  var selectareaunitError = document.getElementById("selectareaunitError");
  var premiumunit1Error = document.getElementById("premiumunit1Error");
  var premiumunit2Error = document.getElementById("premiumunit2Error");
  var groundRent1Error = document.getElementById("groundRent1Error");
  var groundRent2Error = document.getElementById("groundRent2Error");
  var selectGroundRentUnitError = document.getElementById(
    "selectGroundRentUnitError"
  );
  var startdateGRError = document.getElementById("startdateGRError");
  var RGRdurationError = document.getElementById("RGRdurationError");
  var frevisiondateGRError = document.getElementById("frevisiondateGRError");
  var oldPropertyTypeError = document.getElementById("oldPropertyTypeError");
  var oldPropertySubTypeError = document.getElementById(
    "oldPropertySubTypeError"
  );
  var propertyTypeError = document.getElementById("propertyTypeError");
  var propertySubTypeError = document.getElementById("propertySubTypeError");

  // Form 2 Functions Validate
  function validateTypeLease() {
    var TypeLeaseValue = TypeLease.value.trim();
    if (TypeLeaseValue === "") {
      TypeLeaseError.textContent = "Type Lease is required";
      TypeLeaseError.style.display = "block";
      return false;
    } else {
      TypeLeaseError.style.display = "none";
      return true;
    }
  }

  function validatedateexecutionNo() {
    var typeLeaseValue = document.getElementById("TypeLease").value.trim();
    if (typeLeaseValue === "1351") {
      dateexecution.disabled = true;
      dateexecutionError.style.display = "none";
      return true;
    } else {
      dateexecution.disabled = false;
      var dateexecutionValue = dateexecution.value.trim();
      if (dateexecutionValue === "") {
        dateexecutionError.textContent = "Date Execution is required";
        dateexecutionError.style.display = "block";
        return false;
      } else {
        dateexecutionError.style.display = "none";
        return true;
      }
    }
  }

  function validateLeaseExpDuration() {
    var leaseExpDurationValue = leaseExpDuration.value.trim();
    if (leaseExpDurationValue === "") {
      leaseExpDurationError.textContent = "Duration is required";
      leaseExpDurationError.style.display = "block";
      return false;
    } else {
      leaseExpDurationError.style.display = "none";
      return true;
    }
  }

  function validatedateallotment() {
    var dateallotmentValue = dateallotment.value.trim();
    if (dateallotmentValue === "") {
      dateallotmentError.textContent = "Date Allotment is required";
      dateallotmentError.style.display = "block";
      return false;
    } else {
      dateallotmentError.style.display = "none";
      return true;
    }
  }

  function validateplotno() {
    var plotnoValue = plotno.value.trim();
    if (plotnoValue === "") {
      plotnoError.textContent = "Plot Number is required";
      plotnoError.style.display = "block";
      return false;
    } else {
      plotnoError.style.display = "none";
      return true;
    }
  }

  function validateareaunitname() {
    var areaunitnameValue = areaunitname.value.trim();
    if (areaunitnameValue === "") {
      selectareaunitError.textContent = "Area & Unit is required";
      selectareaunitError.style.display = "block";
      return false;
    } else {
      selectareaunitError.style.display = "none";
      return true;
    }
  }

  function validateselectareaunit() {
    var selectareaunitValue = selectareaunit.value.trim();
    if (selectareaunitValue === "") {
      selectareaunitError.textContent = "Area & Unit is required";
      selectareaunitError.style.display = "block";
      return false;
    } else {
      selectareaunitError.style.display = "none";
      return true;
    }
  }

  function validatepremiumunit1() {
    var premiumunit1Value = premiumunit1.value.trim();
    if (premiumunit1Value === "") {
      premiumunit1Error.textContent = "Premium is required";
      premiumunit1Error.style.display = "block";
      return false;
    } else {
      premiumunit1Error.style.display = "none";
      return true;
    }
  }

  function validatepremiumunit2() {
    var premiumunit2Value = premiumunit2.value.trim();
    if (premiumunit2Value === "") {
      premiumunit2Error.textContent = "Premium is required";
      premiumunit2Error.style.display = "block";
      return false;
    } else {
      premiumunit2Error.style.display = "none";
      return true;
    }
  }

  function validategroundRent1() {
    var groundRent1Value = groundRent1.value.trim();
    if (groundRent1Value === "") {
      groundRent1Error.textContent = "GR is required";
      groundRent1Error.style.display = "block";
      return false;
    } else {
      groundRent1Error.style.display = "none";
      return true;
    }
  }

  function validategroundRent2() {
    var groundRent2Value = groundRent2.value.trim();
    if (groundRent2Value === "") {
      groundRent2Error.textContent = "GR is required";
      groundRent2Error.style.display = "block";
      return false;
    } else {
      groundRent2Error.style.display = "none";
      return true;
    }
  }

  function validatestartdateGR() {
    var startdateGRValue = startdateGR.value.trim();
    if (startdateGRValue === "") {
      startdateGRError.textContent = "Start Date GR is required";
      startdateGRError.style.display = "block";
      return false;
    } else {
      startdateGRError.style.display = "none";
      return true;
    }
  }

  function validateRGRduration() {
    var RGRdurationValue = RGRduration.value.trim();
    if (RGRdurationValue === "") {
      RGRdurationError.textContent = "RGR Duration is required";
      RGRdurationError.style.display = "block";
      return false;
    } else {
      RGRdurationError.style.display = "none";
      return true;
    }
  }

  function validatefrevisiondateGR() {
    var frevisiondateGRValue = frevisiondateGR.value.trim();
    if (frevisiondateGRValue === "") {
      frevisiondateGRError.textContent = "First Revision Date is required";
      frevisiondateGRError.style.display = "block";
      return false;
    } else {
      frevisiondateGRError.style.display = "none";
      return true;
    }
  }

  function validateoldPropertyType() {
    var oldPropertyTypeValue = oldPropertyType.value.trim();
    if (oldPropertyTypeValue === "") {
      oldPropertyTypeError.textContent =
        "Purpose for which leased/ allotted (As per lease) is required";
      oldPropertyTypeError.style.display = "block";
      return false;
    } else {
      oldPropertyTypeError.style.display = "none";
      return true;
    }
  }

  function validateSubTypeLease() {
    var oldPropertySubTypeValue = oldPropertySubType.value.trim();
    if (oldPropertySubTypeValue === "") {
      oldPropertySubTypeError.textContent =
        "Sub-Type (Purpose , at present) is required";
      oldPropertySubTypeError.style.display = "block";
      return false;
    } else {
      oldPropertySubTypeError.style.display = "none";
      return true;
    }
  }

  function validatePropertyType() {
    var propertyTypeValue = propertyType.value.trim();
    if (propertyTypeValue === "") {
      propertyTypeError.textContent =
        "Purpose for which leased/ allotted (At present) is required";
      propertyTypeError.style.display = "block";
      return false;
    } else {
      propertyTypeError.style.display = "none";
      return true;
    }
  }

  function validatePropertySubType() {
    var propertySubTypeValue = propertySubType.value.trim();
    if (propertySubTypeValue === "") {
      propertySubTypeError.textContent =
        "Sub-Type (Purpose , at present) is required";
      propertySubTypeError.style.display = "block";
      return false;
    } else {
      propertySubTypeError.style.display = "none";
      return true;
    }
  }

  // Form 3 Fields
  var ProcessTransfer = document.getElementById("ProcessTransfer");
  var transferredDate = document.getElementById("transferredDate");
  var name = document.getElementById("name");
  var age = document.getElementById("age");
  var share = document.getElementById("share");
  var pannumber = document.getElementById("pannumber");
  var aadharnumber = document.getElementById("aadharnumber");

  // Form 3 Errors
  var ProcessTransferError = document.getElementById("ProcessTransferError");
  var transferredDateError = document.getElementById("transferredDateError");
  var nameError = document.getElementById("nameError");
  var ageError = document.getElementById("ageError");
  var shareError = document.getElementById("shareError");
  var pannumberError = document.getElementById("pannumberError");
  var aadharnumberError = document.getElementById("aadharnumberError");

  // Form 5 Fields
  var LastDemandLetter = document.getElementById("LastDemandLetter");
  var amountDemandLetter = document.getElementById("amountDemandLetter");
  var lastamountdate = document.getElementById("lastamountdate");

  // Form 5 Errors
  var LastDemandLetterError = document.getElementById("LastDemandLetterError");
  var amountDemandLetterError = document.getElementById(
    "amountDemandLetterError"
  );
  var LastAmountError = document.getElementById("LastAmountError");
  var lastamountdateError = document.getElementById("lastamountdateError");

  // Form 7 Fields
  var address = document.getElementById("address");
  var asondate = document.getElementById("asondate");

  // Form 7 Errors
  var addressError = document.getElementById("addressError");
  var asondateError = document.getElementById("asondateError");

  // Form 7
  // Form 5
  function validateaddress() {
    var addressValue = address.value.trim();
    if (addressValue === "") {
      addressError.textContent = "Address is required";
      addressError.style.display = "block";
      return false;
    } else {
      addressError.style.display = "none";
      return true;
    }
  }

  function validateasondate() {
    var asondateValue = asondate.value.trim();
    if (asondateValue === "") {
      asondateError.textContent = "As on Date is required";
      asondateError.style.display = "block";
      return false;
    } else {
      asondateError.style.display = "none";
      return true;
    }
  }

  // Validate Form 1
  function validateForm1() {
    // var isPropertyValid = validateProperty();
    var isFileNumberValid = validateFileNumber();
    var isPresentColonyNameValid = validatePresentColonyName();
    var isOldColonyNameValid = validateOldColonyName();
    var isPropertyStatusValid = validatePropertyStatus();
    var isLandTypeValid = validateLandType();
    // var isPasswordValid = validatePassword();

    return (
      isFileNumberValid &&
      isPresentColonyNameValid &&
      isOldColonyNameValid &&
      isPropertyStatusValid &&
      isLandTypeValid
    );
  }
  // Validate Form 2
  function validateForm2() {
    var isTypeLeaseValid = validateTypeLease();
    // var isdateOfExpirationValid = validatedateOfExpiration();
    // var isLeaseAllotmentNoValid = validateLeaseAllotmentNo();
    // var isvalidatedateexecutionNoValid = validatedateexecutionNo();
    var isvalidatedateexecutionNoValid = validatedateexecutionNo();
    var isvalidateLeaseExpDurationValid = validateLeaseExpDuration();
    var isvalidatedateallotmentValid = validatedateallotment();
    var isvalidateplotnoValid = validateplotno();
    var isvalidateareaunitnameValid = validateareaunitname();
    var isvalidateselectareaunitValid = validateselectareaunit();
    var isvalidatepremiumunit1Valid = validatepremiumunit1();
    var isvalidatepremiumunit2Valid = validatepremiumunit2();
    // var isvalidateselectpremiumunitValid = validateselectpremiumunit();
    var isvalidategroundRent1Valid = validategroundRent1();
    var isvalidategroundRent2Valid = validategroundRent2();
    // var isvalidateselectGroundRentUnitValid = validateselectGroundRentUnit();
    var isvalidatestartdateGRValid = validatestartdateGR();
    var isvalidateRGRdurationValid = validateRGRduration();
    var isvalidatefrevisiondateGRValid = validatefrevisiondateGR();
    var isvalidateoldPropertyTypeValid = validateoldPropertyType();
    var isvalidateSubTypeLeaseValid = validateSubTypeLease();
    // var isvalidatepurposeLeasedAtPresentValid = validatepurposeLeasedAtPresent();
    // var isvalidatepurposeSubTypeLeasedAtPresentValid = validatepurposeSubTypeLeasedAtPresent();

    if (dateexecution) {
      return (
        isTypeLeaseValid &&
        isvalidatedateexecutionNoValid &&
        isvalidateLeaseExpDurationValid &&
        isvalidatedateallotmentValid &&
        isvalidateplotnoValid &&
        isvalidateareaunitnameValid &&
        isvalidateselectareaunitValid &&
        isvalidatepremiumunit1Valid &&
        isvalidatepremiumunit2Valid &&
        isvalidategroundRent1Valid &&
        isvalidategroundRent2Valid &&
        isvalidatestartdateGRValid &&
        isvalidateRGRdurationValid &&
        isvalidatefrevisiondateGRValid &&
        isvalidateoldPropertyTypeValid &&
        isvalidateSubTypeLeaseValid
      );
    } else {
      return (
        isTypeLeaseValid &&
        isvalidatedateallotmentValid &&
        isvalidateplotnoValid &&
        isvalidateareaunitnameValid &&
        isvalidateselectareaunitValid &&
        isvalidatepremiumunit1Valid &&
        isvalidatepremiumunit2Valid &&
        isvalidategroundRent1Valid &&
        isvalidategroundRent2Valid &&
        isvalidatestartdateGRValid &&
        isvalidateRGRdurationValid &&
        isvalidatefrevisiondateGRValid &&
        isvalidateoldPropertyTypeValid &&
        isvalidateSubTypeLeaseValid
      );
    }
  }

  function validateForm21() {
    var isvalidatePropertyTypeValid = validatePropertyType();
    var isvalidatePropertySubTypeValid = validatePropertySubType();

    return isvalidatePropertyTypeValid && isvalidatePropertySubTypeValid;
  }

  function validateForm7() {
    var isaddressValid = validateaddress();
    // var isphonenoValid = validatephoneno();
    // var isEmailValid = validateEmail();
    var isasondateValid = validateasondate();

    return isaddressValid && isasondateValid;
  }

  form1.addEventListener("button", function (event) {
    event.preventDefault();
    if (validateForm1()) {
      alert("Form submitted successfully");
      // You can submit the form here using AJAX or other methods
    }
  });

  form2.addEventListener("button", function (event) {
    event.preventDefault();

    if (validateForm2()) {
      alert("Form submitted successfully");
      // You can submit the form here using AJAX or other methods
    }
  });

  // form3.addEventListener('button', function(event) {
  //   event.preventDefault();

  //   if (validateForm3()) {
  //     alert('Form submitted successfully');
  //     // You can submit the form here using AJAX or other methods
  //   }
  // });

  form4.addEventListener("button", function (event) {
    event.preventDefault();

    if (validateForm4()) {
      alert("Form submitted successfully");
      // You can submit the form here using AJAX or other methods
    }
  });

  form5.addEventListener("button", function (event) {
    event.preventDefault();

    if (validateForm5()) {
      alert("Form submitted successfully");
      // You can submit the form here using AJAX or other methods
    }
  });

  var submitButton1 = document.getElementById("submitButton1");
  submitButton1.addEventListener("click", function () {
    if (validateForm1()) {
      stepper3.next();
    }
  });

  // Diwakar Sinha -> 05-07-2024
  function IsInFavourValid() {
    var submitAllowed = true;
    var YesCount1 = 0;

    $('input[id^="test_"][id$="_name"]').removeClass("form-required");
    $('input[id^="test_"][id$="_name"]').parent().find(".text-danger").html("");

    var TextControlID1 = 'input[id^="test_"][id$="_name"]';
    $(TextControlID1).each(function () {
      if ($(this).val().trim() === "") {
        $(this).addClass("form-required");
        $(this).parent().find(".text-danger").html("This field is required");
        submitAllowed = false;
      } else {
        YesCount1++;
      }
    });

    // if (submitAllowed) {
    //   stepper3.next();
    // }
    return submitAllowed;
  }
  // End

  // Joint Property
  function IsJointFormValid() {
    debugger;
    let isValid = true;
    var YesCount = 0;
    var YesCount1 = 0;
    var YesCount2 = 0;
    var YesCount3 = 0;
    var YesCount4 = 0;
    var txtRowCount1 = $(
      'input[id^="jointproperty_"][id$="_jointplotno"]'
    ).length;
    var txtRowCount2 = $(
      'input[id^="jointproperty_"][id$="_jointpropertyarea"]'
    ).length;
    var txtRowCount3 = $(
      'select[id^="jointproperty_"][id$="_jointpropertyuit"]'
    ).length;
    var txtRowCount4 = $(
      'input[id^="jointproperty_"][id$="_jointpropertyid"]'
    ).length;
    var NoCount = 0;
    var rdoCount = $('input[id="jointproperty"]').length;

    $('input[id^="jointproperty"][id$="_jointplotno"]').removeClass("form-required");
    const errorDiv1 = $('input[id^="jointproperty"][id$="_jointplotno"]').parent().find(".text-danger");
    errorDiv1.html("");

    $('input[id^="jointproperty"][id$="_jointpropertyarea"]').removeClass("form-required");
    const errorDiv2 = $('input[id^="jointproperty"][id$="_jointpropertyarea"]').parent().find(".text-danger");
    errorDiv2.html("");

    $('select[id^="jointproperty_"][id$="_jointpropertyunit"]').removeClass("form-required");
    const errorDiv3 = $('select[id^="jointproperty_"][id$="_jointpropertyunit"]').parent().find(".text-danger");
    errorDiv3.html("");

    $('input[id^="jointproperty"][id$="_jointpropertyid"]').removeClass("form-required");
    const errorDiv4 = $('input[id^="jointproperty"][id$="_jointpropertyid"]').parent().find(".text-danger");
    errorDiv4.html("");

    $('input[id="jointproperty"]').each(function (index) {
      var TextControlID1 =
        index == 0
          ? 'input[id^="jointproperty"][id$="_jointplotno"]'
          : 'input[id^="jointproperty_' + index + '"][id$="_jointplotno"]';
      var TextControlID2 =
        index == 0
          ? 'input[id^="jointproperty"][id$="_jointpropertyarea"]'
          : 'input[id^="jointproperty_' + index + '"][id$="_jointpropertyarea"]';
      // var TextControlID3 =
      //   index == 0
      //     ? 'select[id^="jointproperty"][id$="_jointpropertyunit"]'
      //     : 'select[id^="jointproperty_' + index + '"][id$="_jointpropertyunit"]';
          var TextControlID3 = $('select[id^="jointproperty_"][id$="_jointpropertyuit"]');
var isUnitRequired = false;

// Check each dropdown to ensure a valid selection is made
TextControlID3.each(function() {
    if ($(this).val() === '' || $(this).val() === null) { // or any default placeholder value
        isUnitRequired = true;
    }
});
      var TextControlID4 =
        index == 0
          ? 'input[id^="jointproperty"][id$="_jointpropertyid"]'
          : 'input[id^="jointproperty_' + index + '"][id$="_jointpropertyid"]';
      var IsChecked = $(this).is(":checked");
      if (IsChecked) {
        console.log("Checked Yes");
        txtRowCount1 = $(TextControlID1).length;
        txtRowCount2 = $(TextControlID2).length;
        txtRowCount3 = $(TextControlID3).length;
        txtRowCount4 = $(TextControlID4).length;
        $(TextControlID1).each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("form-required");
            const errorDiv1 = $(this).parent().find(".text-danger");
            errorDiv1.html("This field is required");
            isValid=false;
          } else {
            $(this).removeClass("form-required");
            const errorDiv1 = $(this).parent().find(".text-danger");
            errorDiv1.html("");
            YesCount1++;
          }
        });
        $(TextControlID2).each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("form-required");
            const errorDiv2 = $(this).parent().find(".text-danger");
            errorDiv2.html("This field is required");
            isValid=false;
          } else {
            $(this).removeClass("form-required");
            const errorDiv2 = $(this).parent().find(".text-danger");
            errorDiv2.html("");
            YesCount2++;
          }
        });
        $(TextControlID3).each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("form-required");
            const errorDiv3 = $(this).parent().find(".text-danger");
            errorDiv3.html("This field is required");
            isValid=false;
          } else {
            $(this).removeClass("form-required");
            const errorDiv3 = $(this).parent().find(".text-danger");
            errorDiv3.html("");
            YesCount3++;
          }
        });
        $(TextControlID4).each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("form-required");
            const errorDiv4 = $(this).parent().find(".text-danger");
            errorDiv4.html("This field is required");
            isValid=false;
          } else {
            $(this).removeClass("form-required");
            const errorDiv4 = $(this).parent().find(".text-danger");
            errorDiv4.html("");
            YesCount4++;
          }
        });
      } else {
        $(TextControlID1).removeClass("form-required");
        const errorDiv1 = $(TextControlID1).parent().find(".text-danger");
        errorDiv1.html("");

        $(TextControlID2).removeClass("form-required");
        const errorDiv2 = $(TextControlID2).parent().find(".text-danger");
        errorDiv2.html("");

        $(TextControlID3).removeClass("form-required");
        const errorDiv3 = $(TextControlID3).parent().find(".text-danger");
        errorDiv3.html("");

        $(TextControlID4).removeClass("form-required");
        const errorDiv4 = $(TextControlID4).parent().find(".text-danger");
        errorDiv4.html("");

        NoCount++;
      }
      if ( YesCount1 == txtRowCount1 && YesCount2 == txtRowCount2 && YesCount3 == txtRowCount3 && YesCount4 == txtRowCount4) {
        stepper3.next();
      } else {
        rdoCount == YesCount;
      }
    });
    return isValid;
  }
  // End Joint Property

  // code Written By - Diwakar Sinha
  var submitButton2 = document.getElementById("submitButton2");
  submitButton2.addEventListener("click", function () {
    var landusechange = document.getElementById("landusechange");
    var jointproperty = document.getElementById("jointproperty");
    var typeLeaseValue = $("#TypeLease").val();
    var isInFavourRequired = typeLeaseValue != 1352;
    if (jointproperty.checked) {

      // if (validateForm2()) {
      //   IsJointFormValid()
      // }

      var plotCount = $("#repeaterjointproperty div[data-index]").length;
      var htmlContent = "";
      var htmlContent2 = "";
      // Property Status
      var dvPropertyStatusHtml = "";
      // Inspection & Demand Details
      var dvInspectionDet = "";
      // Miscellaneous
      var miscellDetailsHtml = "";
      // Contact Details
      var plotcontactDetails = "";

      for (var i = 0; i < plotCount; i++) {
        htmlContent =
          htmlContent +
          '<button type="button" onclick="openCity(event, `Plot' +
          (i + 1) +
          '`)" class="tablinks">Plot ' +
          (i + 1) +
          "</button>";
        htmlContent2 += `
        <div class="tabcontent" id="Plot${i + 1}">
            <div class="repeaterTabsPlot">
                <h3>Plot ${i + 1}</h3>
                <div data-repeater-list="outerList[${i}]">
                    <div class="parentContainer_div" data-repeater-item>
                        <div class="text-end">
                            <input class="btn btn-danger" type="button" value="Delete" data-repeater-delete>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-lg-4 col-12 my-4">
                                <label class="form-label" for="ProcessTransfer">Process of transfer</label>
                                <select aria-label="Type of Lease" class="form-required form-select processtransfer" data-name="processtransfer" id="ProcessTransfer" name="land_transfer_type">
                                    <option value="" selected>Select</option>
                                    <option value="Substitution">Substitution</option>
                                    <option value="Mutation">Mutation</option>
                                    <option value="Substitution cum Mutation">Substitution cum Mutation</option>
                                    <option value="Mutation cum Substitution">Mutation cum Substitution</option>
                                    <option value="Successor in interest">Successor in interest</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-12 my-4">
                                <label class="form-label" for="transferredDate">Date</label>
                                <input class="form-control form-required" id="transferredDate" name="transferDate" type="date">
                            </div>
                        </div>
                        <div class="inner-repeater">
                            <div data-repeater-list="innerList">
                                <div class="lesseeContainer_div" data-repeater-item>
                                    <div class="row item-content">
                                        <div class="col-lg-4 mb-3">
                                            <label class="form-label" for="name">Name</label>
                                            <input class="form-control form-required alpha-only" id="name" name="name1[]" data-name="name" placeholder="Name">
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <label class="form-label" for="age">Age</label>
                                            <input class="form-control numericOnly" id="age" name="age1[]" data-name="age" placeholder="Age" maxlength="3" type="text">
                                            <div class="text-danger" id="ageError"></div>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <label class="form-label" for="share">Share</label>
                                            <input class="form-control form-required" id="share" name="share1[]" data-name="share" placeholder="Share">
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <label class="form-label" for="pannumber">PAN Number</label>
                                            <input class="form-control text-uppercase pan_number_format" id="pannumber" name="panNumber1[]" data-name="pannumber" placeholder="PAN Number" maxlength="10">
                                            <div class="text-danger" id="pannumberError"></div>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <label class="form-label" for="aadharnumber">Aadhar Number</label>
                                            <input class="form-control text-uppercase numericOnly" id="aadharnumber" name="aadharNumber1[]" data-name="aadharnumber" placeholder="Aadhar Number" maxlength="12">
                                            <div class="text-danger" id="aadharnumberError"></div>
                                        </div>
                                    </div>
                                    <input class="btn btn-danger" type="button" value="Delete Lessee Details" data-repeater-delete>
                                </div>
                            </div>
                            <input class="btn btn-dark" type="button" value="Add Lessee Details" data-repeater-create>
                        </div>
                    </div>
                    </div>
                    <input class="btn btn-primary" type="button" value="Add Transfer Details" data-repeater-create>
            </div>
        </div>
    `;
        // End

        // Property Status
        //9/May/2024 - Sourav Chauhan
        // Code written by Diwakar Sinha
        dvPropertyStatusHtml =
          dvPropertyStatusHtml +
          '<div id="property_status_free_hold' +
          (i + 1) +
          '"><h4 class="inspection_details">Property Status ' +
          (i + 1) +
          '</h4><div class="col-12 col-lg-12"><div class="align-items-center d-flex"><h6 class="mb-0 mr-2">Free Hold (F/H)</h6><div class="form-check mr-2"><input class="form-check-input" id="freeHoldFormYes' +
          (i + 1) +
          '" name="freeHold[' +
          (i + 1) +
          ']" type="radio" value="yes"> <label class="form-check-label" for="freeHoldFormYes' +
          (i + 1) +
          '"><h6 class="mb-0">Yes</h6></label></div><div class=form-check><input class="form-check-input" id="freeHoldFormNo' +
          (i + 1) +
          '" name="freeHold[' +
          (i + 1) +
          ']" type="radio" value="no" checked> <label class="form-check-label" for="freeHoldFormNo' +
          (i + 1) +
          '"><h6 class="mb-0">No</h6></label></div></div></div><div class=col-lg-12><div class=freehold-container id="freeHoldContainer' +
          (i + 1) +
          '" style="display: none"><div class="col-12 col-lg-4"><label class="form-label" for="ConveyanceDate' +
          (i + 1) +
          '">Date of Conveyance Deed</label> <input class="form-control" id="ConveyanceDate' +
          (i + 1) +
          '" name="conveyanc_date[' +
          (i + 1) +
          ']" type="date"><span class="text-danger"></span></div><div class="col-12 col-lg-12 mt-4"><div class="repeater-super-container" id="repeater4' +
          (i + 1) +
          '"><div class="col-12 col-lg-12"><label class="form-label add-label-title"for="plotno' +
          (i + 1) +
          '">In favour of</label> <button class="btn btn-outline-primary repeater-add-btn"data-placement="bottom" data-toggle="tooltip" title="Click on Add More to add more options below"type="button"><i class="bx bx-plus me-0"></i></button></div><div class="duplicate-field-tab"><div class="items" data-group="stepFour' +
          (i + 1) +
          '"><div class="row item-content"><div class="col-12 col-lg-12 mb-3"><label class="form-label" for="inputName1">Name</label> <input class="form-control alpha-only" id="inputName1" name="free_hold_in_favour_name[' +
          (i + 1) +
          ']" placeholder="Name" data-name="name"><span class="text-danger"></span></div></div><div class="repeater-remove-btn"><button type="button" class="btn btn-danger px-4 remove-btn" data-placement="bottom" data-toggle="tooltip" title="Click on delete this form"><i class="bx animated bx-trash fadeIn"></i></button></div></div></div></div></div></div></div></div></div><script>$("#repeater4' +
          (i + 1) +
          '").createRepeater({showFirstItemToDefault: true,});</script>';

        //with all options freehold, Vacant, others
        //9/May/2024 - Sourav Chauhan
        // Code written by Diwakar Sinha
        /* dvPropertyStatusHtml = dvPropertyStatusHtml + '<div id="property_status_free_hold'+ (i+1) +'"><h4 class="inspection_details">Property Status '+ (i+1) +'</h4><div class="col-12 col-lg-12"><div class="align-items-center d-flex"><h6 class="mb-0 mr-2">Free Hold (F/H)</h6><div class="form-check mr-2"><input class="form-check-input" id="freeHoldFormYes'+ (i+1) +'" name="freeHold['+ (i+1) +']" type="radio" value="yes"> <label class="form-check-label" for="freeHoldFormYes'+ (i+1) +'"><h6 class="mb-0">Yes</h6></label></div><div class=form-check><input class="form-check-input" id="freeHoldFormNo'+ (i+1) +'" name="freeHold['+ (i+1) +']" type="radio" value="no" checked> <label class="form-check-label" for="freeHoldFormNo'+ (i+1) +'"><h6 class="mb-0">No</h6></label></div></div></div><div class=col-lg-12><div class=freehold-container id="freeHoldContainer'+ (i+1) +'" style="display: none"><div class="col-12 col-lg-4"><label class="form-label" for="ConveyanceDate'+ (i+1) +'">Date of Conveyance Deed</label> <input class="form-control" id="ConveyanceDate'+ (i+1) +'" name="conveyanc_date['+ (i+1) +']" type="date"></div><div class="col-12 col-lg-12 mt-4"><div class="repeater-super-container" id="repeater4'+ (i+1) +'"><div class="col-12 col-lg-12"><label class="form-label add-label-title"for="plotno'+ (i+1) +'">In favour of</label> <button class="btn btn-outline-primary repeater-add-btn"data-placement="bottom" data-toggle="tooltip" title="Click on Add More to add more options below"type="button"><i class="bx bx-plus me-0"></i></button></div><div class="duplicate-field-tab"><div class="items" data-group="stepFour'+ (i+1) +'"><div class="row item-content"><div class="col-12 col-lg-4 mb-3"><label class="form-label" for="inputName1">Name</label> <input class="form-control" id="inputName1" name="free_hold_in_favour_name['+ (i+1) +']" placeholder="Name" data-name="name"></div><div class="col-12 col-lg-4 mb-3"><label class="form-label" for="InputProperty_known_as">Property Known as (Present)</label> <input class="form-control" id="InputProperty_known_as" name="free_hold_in_property_known_as_present['+ (i+1) +']" placeholder="Property Known as (Present)"data-name="pkap"></div><div class="col-12 col-lg-4 mb-3"><label class="form-label" for="inputArea">Area</label> <input class="form-control" id="inputArea'+ (i+1) +'" name="free_hold_in_favour_name['+ (i+1) +']" placeholder="Area" data-name="area"></div></div><div class="repeater-remove-btn"><button type="button" class="btn btn-danger px-4 remove-btn" data-placement="bottom" data-toggle="tooltip" title="Click on delete this form"><i class="bx animated bx-trash fadeIn"></i></button></div></div></div></div></div></div></div></div><div id="property_status_vacant'+ (i+1) +'"><div class="col-12 col-lg-12"><div class="align-items-center d-flex"><h6 class="mb-0 mr-2">Land Type: Vacant</h6><div class="form-check mr-2"><input class="form-check-input" id="landTypeFormYes'+ (i+1) +'" name="landType['+ (i+1) +']" type="radio" value="yes"> <label class="form-check-label" for="landTypeFormYes'+ (i+1) +'"><h6 class="mb-0">Yes</h6></label></div><div class="form-check"><input class="form-check-input" id="landTypeFormNo'+ (i+1) +'" name="landType['+ (i+1) +']" type="radio" value="no" checked> <label class="form-check-label" for="landTypeFormNo'+ (i+1) +'"><h6 class="mb-0">No</h6></label></div></div></div><div class="col-lg-12"><div class="row landType-container"id="landTypeContainer'+ (i+1) +'" style="display: none"><div class="row"><div class="col-12 col-lg-6"><label class="form-label" for="ConveyanceDate'+ (i+1) +'">In possession of</label> <select aria-label="Type of Lease"class=form-select id="TypeLease'+ (i+1) +'" name="in_possession_of['+ (i+1) +']"><option value=""selected>Select<option value="1">DDA<option value="2">NDMC<option value="3">MCD</select></div><div class="col-12 col-lg-6"><label class="form-label" for="dateTransfer'+ (i+1) +'">Date of Transfer</label> <input class="form-control" id="dateTransfer'+ (i+1) +'" name="date_of_transfer['+ (i+1) +']" type="date"></div></div></div></div></div><div id="property_status_others'+ (i+1) +'"><div class="col-12 col-lg-12"><div class="align-items-center d-flex"><h6 class="mb-0 mr-2">Land Type : Others</h6><div class="form-check mr-2"><input class="form-check-input" id="landTypeFormOthersYes'+ (i+1) +'" name="landTypeOthers['+ (i+1) +']" type="radio" value="yes"> <label class="form-check-label" for="landTypeFormOthersYes'+ (i+1) +'"><h6 class="mb-0">Yes</h6></label></div><div class="form-check"><input class="form-check-input" id="landTypeFormOthersNo'+ (i+1) +'" name="landTypeOthers['+ (i+1) +']" type="radio" value="no" checked> <label class="form-check-label" for="landTypeFormOthersNo'+ (i+1) +'"><h6 class="mb-0">No</h6></label></div></div></div><div class="col-lg-12"><div class="row landType-container"id="landTypeOthersContainer'+ (i+1) +'" style="display:none"><div class="col-12 col-lg-4"><label class="form-label" for="remarks'+ (i+1) +'">Remarks</label> <input class="form-control" id="remarks'+ (i+1) +'" name="remark['+ (i+1) +']"></div></div></div></div>' */
        // End

        // ============================================= Inspection & Demand Details ======================================================
        dvInspectionDet =
          dvInspectionDet +
          '<div class="row g-3" id="inspectionDet' +
          (i + 1) +
          '"><h4 class="inspection_details">Detail ' +
          (i + 1) +
          '</h4><div class="col-12 col-lg-12"><label for="lastInsReport" class="form-label">Date of Last Inspection Report</label><input type="date" class="form-control" id="lastInsReport" name="date_of_last_inspection_report[' +
          (i + 1) +
          ']"><div id="lastInsReportError" class="text-danger"></div></div><div class="col-12 col-lg-6"><label for="LastDemandLetter" class="form-label">Date of Last Demand Letter</label><input type="date" class="form-control" name="date_of_last_demand_letter[' +
          (i + 1) +
          ']" id="LastDemandLetter"><div id="LastDemandLetterError" class="text-danger"></div></div><div class="col-12 col-lg-6"><label for="DemandID" class="form-label">Demand ID</label><input type="text" class="form-control numericOnly" name="demand_id[' +
          (i + 1) +
          ']" id="DemandID" placeholder="Demand ID"><div id="DemandIDError" class="text-danger"></div></div><div class="col-12 col-lg-12"><label for="amountDemandLetter" class="form-label">Amount of Last Demand Letter</label><input type="text" name="amount_of_last_demand[' +
          (i + 1) +
          ']" class="form-control numericDecimal" id="amountDemandLetter"><div id="amountDemandLetterError" class="text-danger"></div></div><div class="col-12 col-lg-6"><label for="LastAmount" class="form-label">Last Amount Received</label><input type="text" class="form-control numericDecimal" id="LastAmount" name="last_amount_reveived[' +
          (i + 1) +
          ']" placeholder="Last Amount Received"><div id="LastAmountError" class="text-danger"></div></div><div class="col-12 col-lg-6"><label for="lastamountdate" class="form-label">Date</label><input type="date" class="form-control" name="last_amount_date[' +
          (i + 1) +
          ']" id="lastamountdate"><div id="lastamountdateError" class="text-danger"></div></div></div>';
        // =================================================== End ================================================================
        miscellDetailsHtml =
          miscellDetailsHtml +
          '<div class="col-12 col-lg-12"><h4 class="inspection_details">Detail ' +
          (i + 1) +
          '</h4><div class="align-items-center d-flex"><h6 class="mb-0 mr-2">GR Revised Ever</h6><div class="form-check mr-2"><input class="form-check-input" id="GRFormYes' +
          (i + 1) +
          '" name="GR['+ (i + 1) +']" type="radio" value="1"><label class="form-check-label" for="GRFormYes' +
          (i + 1) +
          '"><h6 class="mb-0">Yes</h6></label></div><div class="form-check"><input class="form-check-input" id="GRFormNo' +
          (i + 1) +
          '" name="GR[' +
          (i + 1) +
          ']" type="radio" value="0" checked><label class="form-check-label" for="GRFormNo' +
          (i + 1) +
          '"><h6 class="mb-0">No</h6></label></div></div></div><div class="col-lg-12"><div class="GR-container" id="GRContainer' +
          (i + 1) +
          '" style="display:none"><div class="col-12 col-lg-4"><label class="form-label" for="GRrevisedDate' +
          (i + 1) +
          '">Date</label><input class="form-control form-required" id="GRrevisedDate' +
          (i + 1) +
          '" name="gr_revised_date[' +
          (i + 1) +
          ']" type="date"><div class="text-danger"></div></div></div></div><hr><div class="col-12 col-lg-12"><div class="d-flex align-items-center"><h6 class="mr-2 mb-0">Supplementary Lease Deed Executed</h6><div class="form-check mr-2"><input class="form-check-input" type="radio" name="Supplementary[' +
          (i + 1) +
          ']" value="1" id="SupplementaryFormYes' +
          (i + 1) +
          '"><label class="form-check-label" for="SupplementaryFormYes' +
          (i + 1) +
          '"><h6 class="mb-0">Yes</h6></label></div><div class="form-check"><input class="form-check-input" type="radio" name="Supplementary[' +
          (i + 1) +
          ']" value="0" id="SupplementaryFormNo' +
          (i + 1) +
          '" checked><label class="form-check-label" for="SupplementaryFormNo' +
          (i + 1) +
          '"><h6 class="mb-0">No</h6></label></div></div></div><div class="col-lg-12"><div class="Supplementary-container row" id="SupplementaryContainer' +
          (i + 1) +
          '" style="display: none;"><div class="row"><div class="col-12 col-lg-6"><label for="SupplementaryDate' +
          (i + 1) +
          '" class="form-label">Date</label><input type="date" min="1600-01-01" max="2050-12-31" class="form-control form-required" name="supplementary_date[' +
          (i + 1) +
          ']" id="SupplementaryDate' +
          (i + 1) +
          '"><div class="text-danger"></div></div><div class="col-12 col-lg-6"><label for="areaunitname' +
          (i + 1) +
          '" class="form-label">Area</label><div class="unit-field"><input type="text" class="form-control numericDecimal" id="" name="supplementary_area[' +
          (i + 1) +
          ']"><select class="form-select unit-dropdown" id="" aria-label="Select Unit" name="supplementary_area_unit[' +
          (i + 1) +
          ']"><option value="" selected="">Select Unit</option><option value="27">Acre</option><option value="28">Sq Feet</option><option value="29">Sq Meter</option><option value="30">Sq Yard</option><option value="589">Hectare</option></select></div><div id="selectareaunitError' +
          (i + 1) +
          '" class="text-danger"></div></div><div class="col-12 col-lg-6 mt-3"><label for="premiumunit1" class="form-label">Premium (Re/ Rs)</label><div class="unit-field"><input type="text" class="form-control mr-2 numericOnly" id="" name="supplementary_premium1[' +
          (i + 1) +
          ']"><input type="text" class="form-control numericOnly" id="" name="supplementary_premium2[' +
          (i + 1) +
          ']"><select class="form-select unit-dropdown" name="supplementary_premium_unit[' +
          (i + 1) +
          ']" id="" aria-label="Select Unit"><option value="">Unit</option><option selected="" value="1">Paise</option><option value="2">Ana</option></select></div><div id="premiumunit2Error" class="text-danger"></div></div><div class="col-12 col-lg-6 mt-3"><label for="groundRent' +
          (i + 1) +
          '" class="form-label">Ground Rent (Re/ Rs)</label><div class="unit-field"><input type="text" class="form-control mr-2 numericOnly" id="" name="supplementary_ground_rent1[' +
          (i + 1) +
          ']"><input type="text" class="form-control numericOnly" id="" name="supplementary_ground_rent2[' +
          (i + 1) +
          ']"><select class="form-select unit-dropdown" id="" aria-label="Select Unit" name="supplementary_ground_rent_unit[' +
          (i + 1) +
          ']"><option value="">Unit</option><option selected="" value="1">Paise</option><option value="2">Ana</option></select></div><div id="" class="text-danger"></div></div></div><div class="row mt-4 mb-3"><div class="col-12 col-lg-12"><label for="SupplementaryRemark' +
          (i + 1) +
          '" class="form-label">Remark</label><textarea id="SupplementaryRemark' +
          (i + 1) +
          '" name="supplementary_remark[' +
          (i + 1) +
          ']" rows="4" style="width: 100%;"></textarea></div></div></div></div><hr><div class="col-12 col-lg-12"><div class="align-items-center d-flex"><h6 class="mb-0 mr-2">Re-entered</h6><div class="form-check mr-2"><input class="form-check-input" id="ReenteredFormYes' +
          (i + 1) +
          '" name="Reentered[' + (i + 1) + ']" type="radio" value="1"><label class="form-check-label" for="ReenteredFormYes' +
          (i + 1) +
          '"><h6 class="mb-0">Yes</h6></label></div><div class="form-check"><input class="form-check-input" id="ReenteredFormNo' +
          (i + 1) +
          '" name="Reentered[' + (i + 1) + ']" type="radio" value="0" checked><label class="form-check-label" for="ReenteredFormNo' +
          (i + 1) + '"><h6 class="mb-0">No</h6></label></div></div></div><div class="col-lg-12"><div class="row Reentered-container" id="ReenteredContainer' +
          (i + 1) + '" style="display:none"><div class="col-12 col-lg-4"><label class="form-label" for="reentryDate' +
          (i + 1) + '">Date of re-entry</label><input class="form-control form-required" id="reentryDate' + (i + 1) + '" name="date_of_reentry[' + (i + 1) + ']" type="date"><div class="text-danger"></div></div></div></div>';

        plotcontactDetails =
          plotcontactDetails +
          '<h4 class="inspection_details">Contact Detail ' +
          (i + 1) +
          '</h4><div class="col-12 col-lg-4"><label for="address" class="form-label">Address</label><input type="text" name="address[' +
          (i + 1) +
          ']" class="form-control" placeholder="Address"><div class="text-danger"></div></div><div class="col-12 col-lg-4"><label for="phoneno" class="form-label">Phone No.</label><input type="text" name="phone[' +
          (i + 1) +
          ']" class="form-control" id="phoneno" placeholder="Phone No." maxlength="10"><div id="phonenoError" class="text-danger"></div></div><div class="col-12 col-lg-4"><label for="Email" class="form-label">Email</label><input type="email" name="email[' +
          (i + 1) +
          ']" class="form-control" id="Email" placeholder="Email"><div id="EmailError" class="text-danger"></div></div><div class="col-12 col-lg-4"><label for="asondate" class="form-label">As on Date</label><input type="date" name="date[' +
          (i + 1) +
          ']" class="form-control"><div class="text-danger"></div></div>';
      }

      document.getElementById("dvTabHtm2").innerHTML = htmlContent2;

      var script = document.createElement("script");
      script.innerHTML =
        '$(document).ready(function() { $(".repeaterTabsPlot").repeater({ repeaters: [{ selector: ".inner-repeater" }] }); });';
      document.body.appendChild(script);

      $("#dvTabHtm2").html(htmlContent2);

      // Event delegation for dynamically added elements
      $("#dvTabHtm2").on("input", ".alpha-only", function () {
        this.value = this.value.replace(/[^a-zA-Z ]/g, "");
      });

      $("#dvTabHtm2").on("input", ".numericOnly", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
      });

      $("#dvTabHtm2").on("keypress", ".pan_number_format", function (event) {
        var charCode = event.which;

        if (
          charCode === 0 ||
          charCode === 8 ||
          charCode === 9 ||
          charCode === 13
        ) {
          return;
        }

        var charStr = String.fromCharCode(charCode).toUpperCase();

        var currentLength = $(this).val().length;

        if (currentLength < 5 && !/[A-Z]/.test(charStr)) {
          event.preventDefault();
        } else if (
          currentLength >= 5 &&
          currentLength < 9 &&
          !/[0-9]/.test(charStr)
        ) {
          event.preventDefault();
        } else if (currentLength === 9 && !/[A-Z]/.test(charStr)) {
          event.preventDefault();
        }
      });

      // You can add more event listeners for validation as needed

      $("#dvTabHtml").html("");
      $("#dvTabHtml").append(htmlContent);
      $("#dvTabHtm2").html("");
      $("#dvTabHtm2").append(htmlContent2);
      $("#dvPropertyStatusHtml").html("");
      $("#dvPropertyStatusHtml").append(dvPropertyStatusHtml);
      $("#dvInspectionDet").html("");
      $("#dvInspectionDet").append(dvInspectionDet);
      $("#miscellDetailsHtml").html("");
      $("#miscellDetailsHtml").append(miscellDetailsHtml);
      $("#plotcontactDetails").html("");
      $("#plotcontactDetails").append(plotcontactDetails);
      $("#ifAllSelect").html("");
      $("#dvPropertyStatusHtml").removeClass("d-none");
      console.log("Joint Property Checked");
      $("#jointPropertyPlot_title").show();
      // ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| Begin Validation Remove For Step 3 |||||||||||||||||||||||||||||||||||||||||||||||||||
      // Class Name Removed
      $("select.processtransfer").removeClass("form-required");
      $("input.transferredDate").removeClass("form-required");
      $("input.lesseeName").removeClass("form-required");
      $("input.lesseeShare").removeClass("form-required");
      // Error Msg Element Removed
      $("#ProcessTransferError").html("");
      $("#transferredDateError").html("");
      $("#addLesseeBtnError").html("");
      $("#nameError").html("");
      $("#shareError").html("");
      // ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| End Validation Remove For Step 3 |||||||||||||||||||||||||||||||||||||||||||||||||||
      // stepper3.next();
    } else {
      console.log("Joint Property Not Checked");
      // ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| Begin Validation Revert For Step 3 |||||||||||||||||||||||||||||||||||||||||||||||||||
      // Class Name Removed
      $("select.processtransfer").addClass("form-required");
      $("input.transferredDate").addClass("form-required");
      $("input.lesseeName").addClass("form-required");
      $("input.lesseeShare").addClass("form-required");
      // Error Msg Element Removed
      $("#ProcessTransferError").html("This field is required");
      $("#transferredDateError").html("This field is required");
      $("#addLesseeBtnError").html("This field is required");
      $("#nameError").html("This field is required");
      $("#shareError").html("This field is required");
      // ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| End Validation Revert For Step 3 |||||||||||||||||||||||||||||||||||||||||||||||||||
      $("#dvPropertyStatusHtml").addClass("d-none");
      $("#dvTabHtml").html("");
      $("#dvTabHtm2").html("");
      $("#dvPropertyStatusHtml").html("");
      $("#dvInspectionDet").html("");
      $("#miscellDetailsHtml").html("");
      $("#plotcontactDetails").html("");
      // stepper3.next();
    }

    if (validateForm2() && IsInFavourValid()) {
      // Case 1: Both landusechange and jointproperty are checked
      if (landusechange.checked && jointproperty.checked) {
          if (validateForm21() && IsJointFormValid()) {
              stepper3.next();
          }
      } 
      // Case 2: Only landusechange is checked
      else if (landusechange.checked) {
          if (validateForm21()) {
              stepper3.next();
          }
      } 
      // Case 3: Only jointproperty is checked
      else if (jointproperty.checked) {
          if (IsJointFormValid()) {
              stepper3.next();
          }
      } 
      // Case 4: Neither landusechange nor jointproperty is checked
      else {
          stepper3.next();
      }
  } else {
      console.log("Form validation failed. Please fill out all required fields.");
  }

  });

  function IsFormValid() {
    var submitAllowed = true;
    
    $('input[id^="freeHoldFormYes"]').each(function (index) {
      var TextControlID1 = index == 0 ? 'input[id^="stepfour_"][id$="_name"]' : 'input[id^="stepfour' + index + '_"][id$="_name"]';
      var TextControlID2 = index == 0 ? "#ConveyanceDate" : "#ConveyanceDate" + index;
      var IsChecked = $(this).is(":checked");
      if (IsChecked) {
        var txtRowCount1 = $(TextControlID1).length;
        var txtRowCount2 = $(TextControlID2).length;
        var YesCount = 0;
        $(TextControlID1).each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("form-required");
            const errorDiv = $(this).parent().find(".text-danger").html("This field is required");
            errorDiv.html("This field is required");
            submitAllowed = false;
          } else {
            $(this).removeClass("form-required");
            const errorDiv = $(this).parent().find(".text-danger");
            errorDiv.html("");
            YesCount++;
          }
        });
        $(TextControlID2).each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("form-required");
            const errorDiv = $(this).parent().find(".text-danger").html("This field is required");
            errorDiv.html("This field is required");
            submitAllowed = false;
          } else {
            $(this).removeClass("form-required");
            const errorDiv = $(this).parent().find(".text-danger");
            errorDiv.html("");
            YesCount++;
          }
        });
        if (YesCount < txtRowCount1 && YesCount < txtRowCount2) {
          submitAllowed = false;
        }
      }
    });

    if (submitAllowed) {
      stepper3.next();
    }
  }


  var submitButton4 = document.getElementById("submitButton4");
  submitButton4.addEventListener("click", function () {
    IsFormValid();
  });

  var submitButton5 = document.getElementById("submitButton5");
  submitButton5.addEventListener("click", function (event) {
    stepper3.next();
  });

  //Diwakar Sinha 30-05-2024
  //Miscellaneous Details
  function IsMisceFormValid() {
    var submitAllowed = true;

    // GR Date
    $('input[id^="GRFormYes"]').each(function (index) {
      var TextControlID =
        index == 0 ? "#GRrevisedDate" : "#GRrevisedDate" + index;
      var IsChecked = $(this).is(":checked");
      if (IsChecked) {
        var txtRowCount = $(TextControlID).length;
        var YesCount = 0;

        $(TextControlID).each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("form-required");
            const errorDiv = $(this).parent().find(".text-danger");
            errorDiv.html("This field is required");
            submitAllowed = false;
          } else {
            $(this).removeClass("form-required");
            const errorDiv = $(this).parent().find(".text-danger");
            errorDiv.html("");
            YesCount++;
          }
        });

        if (YesCount < txtRowCount) {
          submitAllowed = false;
        }
      }
    });

    // Supplementary Date
    $('input[id^="SupplementaryFormYes"]').each(function (index) {
      var TextControlID =
        index == 0 ? "#SupplementaryDate" : "#SupplementaryDate" + index;
      var IsChecked = $(this).is(":checked");
      if (IsChecked) {
        var txtRowCount = $(TextControlID).length;
        var YesCount = 0;

        $(TextControlID).each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("form-required");
            const errorDiv = $(this).parent().find(".text-danger");
            errorDiv.html("This field is required");
            submitAllowed = false;
          } else {
            $(this).removeClass("form-required");
            const errorDiv = $(this).parent().find(".text-danger");
            errorDiv.html("");
            YesCount++;
          }
        });

        if (YesCount < txtRowCount) {
          submitAllowed = false;
        }
      }
    });

    // Reentered Date
    $('input[id^="ReenteredFormYes"]').each(function (index) {
      var TextControlID = index == 0 ? "#reentryDate" : "#reentryDate" + index;
      var IsChecked = $(this).is(":checked");
      if (IsChecked) {
        var txtRowCount = $(TextControlID).length;
        var YesCount = 0;

        $(TextControlID).each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("form-required");
            const errorDiv = $(this).parent().find(".text-danger");
            errorDiv.html("This field is required");
            submitAllowed = false;
          } else {
            $(this).removeClass("form-required");
            const errorDiv = $(this).parent().find(".text-danger");
            errorDiv.html("");
            YesCount++;
          }
        });

        if (YesCount < txtRowCount) {
          submitAllowed = false;
        }
      }
    });

    // If all validations passed, proceed
    if (submitAllowed) {
      stepper3.next();
    }
  }

  var submitButton6 = document.getElementById("submitButton6");
  submitButton6.addEventListener("click", function () {
    IsMisceFormValid();
  });

  var btnfinalsubmit = document.getElementById("btnfinalsubmit");
  btnfinalsubmit.addEventListener("click", function (event) {
    // ========================================================== Validation Required =====================================
    console.log("Validation Checking...");
    var inputs = document.querySelectorAll(".required");
    var isValid = true;

    inputs.forEach(function (input) {
      if (!input.value.trim()) {
        isValid = false;
        input.classList.add("form-required");
        const errorDiv = input.parentElement.querySelector(".text-danger");
        errorDiv.innerHTML = "This field is required";
      } else {
        input.classList.remove("form-required");
        const errorDiv = input.parentElement.querySelector(".text-danger");
        errorDiv.innerHTML = ""; // Clear previous error message if any
      }
    });

    if (!isValid) {
      event.preventDefault();
    }
    // =================================================================== End ============================================
    if (validateForm7()) {
      this.removeAttribute("type", "submit");
    } else {
      this.setAttribute("type", "button");
    }
  });
});
