document.addEventListener("DOMContentLoaded", function () {
  var numericInput = document.getElementById("aadharnumber");
  if (numericInput) {
    // Add event listener for input
    numericInput.addEventListener("input", function (event) {
      var inputValue = event.target.value;

      // Remove non-numeric characters using regular expression
      var numericValue = inputValue.replace(/\D/g, "");

      // Update input value
      event.target.value = numericValue;
    });
  }
});

const transferredCheckboxYes = document.getElementById("transferredFormYes");
// const transferredCheckboxNo = document.getElementById('transferredFormNo');

const transferredContainer = document.getElementById("transferredContainer");

transferredCheckboxYes.addEventListener("change", function () {
  if (this.checked) {
    transferredContainer.style.display = "block"; // Show the div if checkbox is checked
  } else {
    transferredContainer.style.display = "none"; // Hide the div if checkbox is not checked
  }
});

// transferredCheckboxNo.addEventListener('change', function () {
//   if (this.checked) {
//     transferredContainer.style.display = 'none'; // Show the div if checkbox is checked
//   } else {
//     transferredContainer.style.display = 'block'; // Hide the div if checkbox is not checked
//   }
// });

// Free Hold
var freeHoldCheckboxYes = document.getElementById("freeHoldFormYes");
var freeHoldCheckboxNo = document.getElementById("freeHoldFormNo");
$(document).on("change", 'input[id^="freeHoldFormYes"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("freeHoldFormYes", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  var freeHoldContainer =
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
  var freeHoldContainer =
    index == 0 ? $("#freeHoldContainer") : $("#freeHoldContainer" + index);
  var isChecked = $(this).is(":checked");
  if (isChecked) {
    freeHoldContainer.hide();
  } else {
    freeHoldContainer.show();
  }
});
// Land Type: Vacant

var landTypeCheckboxYes = document.getElementById("landTypeFormYes");
var landTypeCheckboxNo = document.getElementById("landTypeFormNo");

$(document).on("change", 'input[id^="landTypeFormYes"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("landTypeFormYes", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  var landTypeContainer =
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
  var landTypeContainer =
    index == 0 ? $("#landTypeContainer") : $("#landTypeContainer" + index);
  var isChecked = $(this).is(":checked");
  if (isChecked) {
    landTypeContainer.hide();
  } else {
    landTypeContainer.show();
  }
});

// Land Type : Others

var landTypeOthersCheckboxYes = document.getElementById(
  "landTypeFormOthersYes"
);
var landTypeOthersCheckboxNo = document.getElementById("landTypeFormOthersNo");

$(document).on("change", 'input[id^="landTypeFormOthersYes"]', function () {
  var id = $(this).attr("id");
  var index = parseInt(id.replace("landTypeFormOthersYes", ""), 10);

  if (isNaN(index)) {
    index = 0;
  }
  var landTypeOthersContainer =
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
  var landTypeOthersContainer =
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

// Free Hold

// const freeHoldCheckboxYes = document.getElementById('freeHoldFormYes');
// const freeHoldCheckboxNo = document.getElementById('freeHoldFormNo');

// const freeHoldContainer = document.getElementById('freeHoldContainer');

// freeHoldCheckboxYes.addEventListener('change', function () {
//   if (this.checked) {
//     freeHoldContainer.style.display = 'block'; // Show the div if checkbox is checked
//   } else {
//     freeHoldContainer.style.display = 'none'; // Hide the div if checkbox is not checked
//   }
// });

// freeHoldCheckboxNo.addEventListener('change', function () {
//   if (this.checked) {
//     freeHoldContainer.style.display = 'none'; // Show the div if checkbox is checked
//   } else {
//     freeHoldContainer.style.display = 'block'; // Hide the div if checkbox is not checked
//   }
// });

// Land Type

// const landTypeCheckboxYes = document.getElementById('landTypeFormYes');
// const landTypeCheckboxNo = document.getElementById('landTypeFormNo');

// const landTypeContainer = document.getElementById('landTypeContainer');

// landTypeCheckboxYes.addEventListener('change', function () {
//   if (this.checked) {
//     landTypeContainer.style.display = 'block'; // Show the div if checkbox is checked
//   } else {
//     landTypeContainer.style.display = 'none'; // Hide the div if checkbox is not checked
//   }
// });

// landTypeCheckboxNo.addEventListener('change', function () {
//   if (this.checked) {
//     landTypeContainer.style.display = 'none'; // Show the div if checkbox is checked
//   } else {
//     landTypeContainer.style.display = 'block'; // Hide the div if checkbox is not checked
//   }
// });

// Land Type : Others

// const landTypeOthersCheckboxYes = document.getElementById('landTypeFormOthersYes');
// const landTypeOthersCheckboxNo = document.getElementById('landTypeFormOthersNo');

// const landTypeOthersContainer = document.getElementById('landTypeOthersContainer');

// landTypeOthersCheckboxYes.addEventListener('change', function () {
//   if (this.checked) {
//     landTypeOthersContainer.style.display = 'block'; // Show the div if checkbox is checked
//   } else {
//     landTypeOthersContainer.style.display = 'none'; // Hide the div if checkbox is not checked
//   }
// });

// landTypeOthersCheckboxNo.addEventListener('change', function () {
//   if (this.checked) {
//     landTypeOthersContainer.style.display = 'none'; // Show the div if checkbox is checked
//   } else {
//     landTypeOthersContainer.style.display = 'block'; // Hide the div if checkbox is not checked
//   }
// });

// GR

const GRCheckboxYes = document.getElementById("GRFormYes");
const GRCheckboxNo = document.getElementById("GRFormNo");

const GRContainer = document.getElementById("GRContainer");

GRCheckboxYes.addEventListener("change", function () {
  if (this.checked) {
    GRContainer.style.display = "block"; // Show the div if checkbox is checked
  } else {
    GRContainer.style.display = "none"; // Hide the div if checkbox is not checked
  }
});

GRCheckboxNo.addEventListener("change", function () {
  if (this.checked) {
    GRContainer.style.display = "none"; // Show the div if checkbox is checked
  } else {
    GRContainer.style.display = "block"; // Hide the div if checkbox is not checked
  }
});

// Supplementary

const SupplementaryCheckboxYes = document.getElementById(
  "SupplementaryFormYes"
);
const SupplementaryCheckboxNo = document.getElementById("SupplementaryFormNo");

const SupplementaryContainer = document.getElementById(
  "SupplementaryContainer"
);

SupplementaryCheckboxYes.addEventListener("change", function () {
  if (this.checked) {
    SupplementaryContainer.style.display = "block"; // Show the div if checkbox is checked
  } else {
    SupplementaryContainer.style.display = "none"; // Hide the div if checkbox is not checked
  }
});

SupplementaryCheckboxNo.addEventListener("change", function () {
  if (this.checked) {
    SupplementaryContainer.style.display = "none"; // Show the div if checkbox is checked
  } else {
    SupplementaryContainer.style.display = "block"; // Hide the div if checkbox is not checked
  }
});

// Re-Entered

const ReenteredCheckboxYes = document.getElementById("ReenteredFormYes");
const ReenteredCheckboxNo = document.getElementById("ReenteredFormNo");

const ReenteredContainer = document.getElementById("ReenteredContainer");

ReenteredCheckboxYes.addEventListener("change", function () {
  if (this.checked) {
    ReenteredContainer.style.display = "block"; // Show the div if checkbox is checked
  } else {
    ReenteredContainer.style.display = "none"; // Hide the div if checkbox is not checked
  }
});

ReenteredCheckboxNo.addEventListener("change", function () {
  if (this.checked) {
    ReenteredContainer.style.display = "none"; // Show the div if checkbox is checked
  } else {
    ReenteredContainer.style.display = "block"; // Hide the div if checkbox is not checked
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
  // var dateOfExpiration = document.getElementById('dateOfExpiration');
  var dateexecution = document.getElementById("dateexecution");
  var leaseExpDuration = document.getElementById("lease_exp_duration");
  // var dateexecution = document.getElementById('dateexecution');
  // var dateallotment = document.getElementById('dateallotment');
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
  // var dateOfExpirationError = document.getElementById('dateOfExpirationError');
  // var LeaseAllotmentNoError = document.getElementById('LeaseAllotmentNoError');
  var dateexecutionError = document.getElementById("dateexecutionError");
  var leaseExpDurationError = document.getElementById("leaseExpDurationError");
  var dateallotmentError = document.getElementById("dateallotmentError");
  var plotnoError = document.getElementById("plotnoError");
  var selectareaunitError = document.getElementById("selectareaunitError");
  var premiumunit2Error = document.getElementById("premiumunit2Error");
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

  // function validatedateOfExpiration() {
  //   var dateOfExpirationValue = dateOfExpiration.value.trim();
  //   if (dateOfExpirationValue === '') {
  //     dateOfExpirationError.textContent = 'Date of Expiration is required';
  //     dateOfExpirationError.style.display = 'block';
  //     return false;
  //   } else {
  //     dateOfExpirationError.style.display = 'none';
  //     return true;
  //   }
  // }

  // function validateLeaseAllotmentNo() {
  //   var LeaseAllotmentNoValue = LeaseAllotmentNo.value.trim();
  //   if (LeaseAllotmentNoValue === '') {
  //     LeaseAllotmentNoError.textContent = 'Lease Allotment is required';
  //     LeaseAllotmentNoError.style.display = 'block';
  //     return false;
  //   } else {
  //     LeaseAllotmentNoError.style.display = 'none';
  //     return true;
  //   }
  // }

  function validatedateexecutionNo() {
    if (dateexecution) {
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
    if (leaseExpDuration) {
      var leaseExpDurationValue = leaseExpDuration.value.trim();
      if (leaseExpDurationValue === "") {
        leaseExpDurationError.textContent = "Duration is required";
        leaseExpDurationError.style.display = "block";
        return false;
      } else {
        leaseExpDurationError.style.display = "none";
        return true;
      }
    } else {
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
      premiumunit2Error.textContent = "Premium is required";
      premiumunit2Error.style.display = "block";
      return false;
    } else {
      premiumunit2Error.style.display = "none";
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

  // function validateselectpremiumunit() {
  //   var selectpremiumunitValue = selectpremiumunit.value.trim();
  //   if (selectpremiumunitValue === '') {
  //     premiumunit2Error.textContent = 'Premium & Unit is required';
  //     premiumunit2Error.style.display = 'block';
  //     return false;
  //   } else {
  //     premiumunit2Error.style.display = 'none';
  //     return true;
  //   }
  // }

  function validategroundRent1() {
    var groundRent1Value = groundRent1.value.trim();
    if (groundRent1Value === "") {
      groundRent2Error.textContent = "Ground Rent is required";
      groundRent2Error.style.display = "block";
      return false;
    } else {
      groundRent2Error.style.display = "none";
      return true;
    }
  }

  function validategroundRent2() {
    var groundRent2Value = groundRent2.value.trim();
    if (groundRent2Value === "") {
      groundRent2Error.textContent = "Ground Rent is required";
      groundRent2Error.style.display = "block";
      return false;
    } else {
      groundRent2Error.style.display = "none";
      return true;
    }
  }

  // function validateselectGroundRentUnit() {
  //   var selectGroundRentUnitValue = selectGroundRentUnit.value.trim();
  //   if (selectGroundRentUnitValue === '') {
  //     groundRent2Error.textContent = 'Ground Rent & Unit is required';
  //     groundRent2Error.style.display = 'block';
  //     return false;
  //   } else {
  //     groundRent2Error.style.display = 'none';
  //     return true;
  //   }
  // }

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
  // var lastInsReport = document.getElementById('lastInsReport');
  var LastDemandLetter = document.getElementById("LastDemandLetter");
  // var DemandID = document.getElementById('DemandID');
  var amountDemandLetter = document.getElementById("amountDemandLetter");
  var LastAmount = document.getElementById("LastAmount");
  var lastamountdate = document.getElementById("lastamountdate");

  // Form 5 Errors
  // var lastInsReportError = document.getElementById('lastInsReportError');
  var LastDemandLetterError = document.getElementById("LastDemandLetterError");
  // var DemandIDError = document.getElementById('DemandIDError');
  var amountDemandLetterError = document.getElementById(
    "amountDemandLetterError"
  );
  var LastAmountError = document.getElementById("LastAmountError");
  var lastamountdateError = document.getElementById("lastamountdateError");

  // Form 7 Fields
  var address = document.getElementById("address");
  // var phoneno = document.getElementById('phoneno');
  // var Email = document.getElementById('Email');
  var asondate = document.getElementById("asondate");

  // Form 7 Errors
  var addressError = document.getElementById("addressError");
  // var phonenoError = document.getElementById('phonenoError');
  // var EmailError = document.getElementById('EmailError');
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

  // function validatephoneno() {
  //   var phonenoValue = phoneno.value.trim();
  //   if (phonenoValue === '') {
  //     phonenoError.textContent = 'Phone Number is required';
  //     phonenoError.style.display = 'block';
  //     return false;
  //   } else {
  //     phonenoError.style.display = 'none';
  //     return true;
  //   }
  // }

  // function validateEmail() {
  //   var EmailValue = Email.value.trim();
  //   if (EmailValue === '') {
  //     EmailError.textContent = 'Email is required';
  //     EmailError.style.display = 'block';
  //     return false;
  //   } else {
  //     EmailError.style.display = 'none';
  //     return true;
  //   }
  // }

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

  // Form 5
  // function validatelastInsReport() {
  //   var lastInsReportValue = lastInsReport.value.trim();
  //   if (lastInsReportValue === '') {
  //     lastInsReportError.textContent = 'Date of Last Inspection Report is required';
  //     lastInsReportError.style.display = 'block';
  //     return false;
  //   } else {
  //     lastInsReportError.style.display = 'none';
  //     return true;
  //   }
  // }

  function validateLastDemandLetter() {
    var LastDemandLetterValue = LastDemandLetter.value.trim();
    if (LastDemandLetterValue === "") {
      LastDemandLetterError.textContent =
        "Date of Last Demand Letter is required";
      LastDemandLetterError.style.display = "block";
      return false;
    } else {
      LastDemandLetterError.style.display = "none";
      return true;
    }
  }

  // function validateDemandID() {
  //   var DemandIDValue = DemandID.value.trim();
  //   if (DemandIDValue === '') {
  //     DemandIDError.textContent = 'Demand ID is required';
  //     DemandIDError.style.display = 'block';
  //     return false;
  //   } else {
  //     DemandIDError.style.display = 'none';
  //     return true;
  //   }
  // }

  function validateamountDemandLetter() {
    var amountDemandLetterValue = amountDemandLetter.value.trim();
    if (amountDemandLetterValue === "") {
      amountDemandLetterError.textContent =
        "Amount of Last Demand Letter is required";
      amountDemandLetterError.style.display = "block";
      return false;
    } else {
      amountDemandLetterError.style.display = "none";
      return true;
    }
  }

  function validateLastAmount() {
    var LastAmountValue = LastAmount.value.trim();
    if (LastAmountValue === "") {
      LastAmountError.textContent = "Last Amount Received is required";
      LastAmountError.style.display = "block";
      return false;
    } else {
      LastAmountError.style.display = "none";
      return true;
    }
  }

  function validatelastamountdate() {
    var lastamountdateValue = lastamountdate.value.trim();
    if (lastamountdateValue === "") {
      lastamountdateError.textContent = "Date is required";
      lastamountdateError.style.display = "block";
      return false;
    } else {
      lastamountdateError.style.display = "none";
      return true;
    }
  }

  // Form 3
  function validateProcessTransfer() {
    var ProcessTransferValue = ProcessTransfer.value.trim();
    if (ProcessTransferValue === "") {
      ProcessTransferError.textContent = "Process Transfer is required";
      ProcessTransferError.style.display = "block";
      return false;
    } else {
      ProcessTransferError.style.display = "none";
      return true;
    }
  }

  function validatetransferredDate() {
    var transferredDateValue = transferredDate.value.trim();
    if (transferredDateValue === "") {
      transferredDateError.textContent = "Process Transfer is required";
      transferredDateError.style.display = "block";
      return false;
    } else {
      transferredDateError.style.display = "none";
      return true;
    }
  }

  function validatename() {
    var nameValue = name.value.trim();
    if (nameValue === "") {
      nameError.textContent = "Process Transfer is required";
      nameError.style.display = "block";
      return false;
    } else {
      nameError.style.display = "none";
      return true;
    }
  }

  function validateage() {
    var ageValue = age.value.trim();
    if (ageValue === "") {
      ageError.textContent = "Process Transfer is required";
      ageError.style.display = "block";
      return false;
    } else {
      ageError.style.display = "none";
      return true;
    }
  }

  function validateshare() {
    var shareValue = share.value.trim();
    if (shareValue === "") {
      shareError.textContent = "Process Transfer is required";
      shareError.style.display = "block";
      return false;
    } else {
      shareError.style.display = "none";
      return true;
    }
  }

  function validatepannumber() {
    var pannumberValue = pannumber.value.trim();
    if (pannumberValue === "") {
      pannumberError.textContent = "Process Transfer is required";
      pannumberError.style.display = "block";
      return false;
    } else {
      pannumberError.style.display = "none";
      return true;
    }
  }

  function validateaadharnumber() {
    var aadharnumberValue = aadharnumber.value.trim();
    if (aadharnumberValue === "") {
      aadharnumberError.textContent = "Process Transfer is required";
      aadharnumberError.style.display = "block";
      return false;
    } else {
      aadharnumberError.style.display = "none";
      return true;
    }
  }
  // End

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
    console.log(
      isTypeLeaseValid,
      isvalidatedateexecutionNoValid,
      isvalidateLeaseExpDurationValid,
      isvalidatedateallotmentValid,
      isvalidateplotnoValid,
      isvalidateareaunitnameValid,
      isvalidateselectareaunitValid,
      isvalidatepremiumunit1Valid,
      isvalidatepremiumunit2Valid,
      isvalidategroundRent1Valid,
      isvalidategroundRent2Valid,
      isvalidatestartdateGRValid,
      isvalidateRGRdurationValid,
      isvalidatefrevisiondateGRValid,
      isvalidateoldPropertyTypeValid,
      isvalidateSubTypeLeaseValid
    );
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

  // Validate Form 3
  // function validateForm3() {
  //   var isProcessTransferValid = validateProcessTransfer()
  //   var istransferredDateValid = validatetransferredDate()
  //   var isnameValid = validatename()
  //   var isageValid = validateage()
  //   var isshareValid = validateshare()
  //   var ispannumberDateValid = validatepannumber()
  //   var isaadharnumberValid = validateaadharnumber()

  //   return isProcessTransferValid && istransferredDateValid && isnameValid && isageValid && isshareValid && ispannumberDateValid && isaadharnumberValid;
  // }
  // End

  // Validate Form 3
  // function validateForm3() {
  //   var isFileNumberValid = validateFileNumber();
  //   var isPresentColonyNameValid = validatePresentColonyName();
  //   var isOldColonyNameValid = validateOldColonyName();
  //   var isPropertyStatusValid = validatePropertyStatus();
  //   var isLandTypeValid = validateLandType();

  //   return isFileNumberValid && isPresentColonyNameValid && isOldColonyNameValid && isPropertyStatusValid && isLandTypeValid;
  // }

  // Validate Form 5
  function validateForm5() {
    // var islastInsReportValid = validatelastInsReport();
    //var isLastDemandLetterValid = validateLastDemandLetter();
    // var isDemandIDValid = validateDemandID();
    //var isamountDemandLetterValid = validateamountDemandLetter();
    //var isLastAmountValid = validateLastAmount();
    //var islastamountdateValid = validatelastamountdate();
    //return  isLastDemandLetterValid && isamountDemandLetterValid && isLastAmountValid && islastamountdateValid;
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

  //   form4.addEventListener('button', function(event) {
  //   event.preventDefault();

  //   if (validateForm4()) {
  //     alert('Form submitted successfully');
  //     // You can submit the form here using AJAX or other methods
  //   }
  // });

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

  // Diwakar Sinha -> 13-06-2024
  function IsInEditFavourValid() {
    var submitAllowed = true;
    var YesCount1 = 0;
    var index = 0;

    $('input[id^="original"]').removeClass("invalid");
    $('input[id^="original"]').parent().find(".text-danger").html("");
    var TextControlID1 =
      index == 0
        ? 'input[id^="original"]'
        : 'input[id^="original' + index + "]";

    $('input[id^="in_favor_new"]').removeClass("invalid");
    $('input[id^="in_favor_new"]').parent().find(".text-danger").html("");
    var TextControlID2 =
      index == 0
        ? 'input[id^="in_favor_new"]'
        : 'input[id^="in_favor_new' + index + "]";

    // var TextControlID1 = 'input[id^="test_"][id$="_name"]';
    $(TextControlID1).each(function () {
      if ($(this).val().trim() === "") {
        $(this).addClass("invalid");
        $(this).parent().find(".text-danger").html("This field is required");
        submitAllowed = false;
      } else {
        YesCount1++;
      }
    });

    $(TextControlID2).each(function () {
      if ($(this).val().trim() === "") {
        $(this).addClass("invalid");
        $(this).parent().find(".text-danger").html("This field is required");
        submitAllowed = false;
      } else {
        YesCount1++;
      }
    });

    if (submitAllowed) {
      stepper3.next();
    }
  }
  // End

  var submitButton2 = document.getElementById("submitButton2");
  submitButton2.addEventListener("click", function () {
    var landusechange = document.getElementById("landusechange");
    if (!landusechange.checked) {
      if (validateForm2() && IsInEditFavourValid()) {
        stepper3.next();
      }
    } else {
      if (validateForm21() && IsInEditFavourValid()) {
        stepper3.next();
      }
    }
  });

  // var submitButton3 = document.getElementById('submitButton3');
  // submitButton3.addEventListener('click', function() {
  //   if (validateForm3()) {
  // 	stepper3.next()
  //   }
  // });

  // var submitButton4 = document.getElementById('submitButton4');
  // submitButton4.addEventListener('click', function() {
  //   if (validateForm4()) {
  // 	stepper3.next()
  //   }
  // });

  function IsFormValid() {
    var submitAllowed = true;
    var YesCount1 = 0;
    var YesCount2 = 0;
    var txtRowCount1 = $('input[id^="stepfour"][id$="_name"]').length;
    var txtRowCount2 = $('input[id="ConveyanceDate"]').length;
    var txtRowCount3 = $('input[id="TypeLease"]').length;
    var txtRowCount4 = $('input[id="dateTransfer"]').length;
    var txtRowCount5 = $('input[id^="remarks"]').length;
    var NoCount = 0;
    var rdoCount =
      $('input[id^="freeHoldFormYes"]').length +
      $('input[id="landTypeFormYes"]').length +
      $('input[id="landTypeFormOthersYes"]').length;

    // Reset validation states and error messages for all relevant fields
    $(
      'input[id^="stepfour"][id$="_name"], input[id="ConveyanceDate"], input[id="TypeLease"], input[id="dateTransfer"], input[id^="remarks"]'
    ).removeClass("invalid");
    $(
      'input[id^="stepfour"][id$="_name"], input[id="ConveyanceDate"], input[id="TypeLease"], input[id="dateTransfer"], input[id^="remarks"]'
    )
      .parent()
      .find(".text-danger")
      .html("");

    // Validate freeHoldFormYes checkboxes
    $('input[id^="freeHoldFormYes"]').each(function (index) {
      var TextControlID1 =
        index == 0
          ? 'input[id^="stepfour_"][id$="_name"]'
          : 'input[id^="stepfour' + index + '_"][id$="_name"]';
      var TextControlID2 =
        index == 0
          ? 'input[id^="ConveyanceDate"]'
          : 'input[id^="ConveyanceDate' + index + '"]';
      var IsChecked = $(this).is(":checked");
      if (IsChecked) {
        $(TextControlID1).each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("invalid");
            $(this)
              .parent()
              .find(".text-danger")
              .html("This field is required");
            submitAllowed = false;
          } else {
            YesCount1++;
          }
        });

        $(TextControlID2).each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("invalid");
            $(this)
              .parent()
              .find(".text-danger")
              .html("This field is required");
            submitAllowed = false;
          } else {
            YesCount2++;
          }
        });
      } else {
        NoCount++;
      }
    });

    // Validate landTypeFormYes checkbox
    $('input[id="landTypeFormYes"]').each(function () {
      var IsChecked = $(this).is(":checked");
      if (IsChecked) {
        $('input[id="VacantPossession"]').each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("invalid");
            $(this)
              .parent()
              .find(".text-danger")
              .html("This field is required");
            submitAllowed = false;
          } else {
            YesCount1++;
          }
        });

        $('input[id="dateTransfer"]').each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("invalid");
            $(this)
              .parent()
              .find(".text-danger")
              .html("This field is required");
            submitAllowed = false;
          } else {
            YesCount2++;
          }
        });
      } else {
        NoCount++;
      }
    });

    // Validate landTypeFormOthersYes checkbox
    $('input[id="landTypeFormOthersYes"]').each(function () {
      var IsChecked = $(this).is(":checked");
      if (IsChecked) {
        $('input[id^="remarks"]').each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("invalid");
            $(this)
              .parent()
              .find(".text-danger")
              .html("This field is required");
            submitAllowed = false;
          } else {
            YesCount1++;
          }
        });
      } else {
        NoCount++;
      }
    });

    if (submitAllowed) {
      stepper3.next();
    }
  }

  // Edit InFavour Validation 27-06-2024

  function IsInEditConversionValid() {
    var submitAllowed = true;
    var YesCount1 = 0;
    var index = 0;

    $('input[id^="conversion"]').removeClass("invalid");
    $('input[id^="conversion"]').parent().find(".text-danger").html("");

    var TextControlID1 =
      index == 0
        ? 'input[id^="conversion"]'
        : 'input[id^="conversion' + index + "]";

    $('input[id^="newInFavourConversion"]').removeClass("invalid");
    $('input[id^="newInFavourConversion"]')

      .parent()
      .find(".text-danger")
      .html("");
    var TextControlID2 =
      index == 0
        ? 'input[id^="newInFavourConversion"]'
        : 'input[id^="newInFavourConversion' + index + "]";

    // var TextControlID1 = 'input[id^="test_"][id$="_name"]';
    $(TextControlID1).each(function () {
      if ($(this).val().trim() === "") {
        $(this).addClass("invalid");
        $(this).parent().find(".text-danger").html("This field is required");
        submitAllowed = false;
      } else {
        YesCount1++;
      }
    });

    $(TextControlID2).each(function () {
      if ($(this).val().trim() === "") {
        $(this).addClass("invalid");
        $(this).parent().find(".text-danger").html("This field is required");
        submitAllowed = false;
      } else {
        YesCount1++;
      }
    });

    if (submitAllowed) {
      stepper3.next();
    }
  }
  // End

  // var submitButton4 = document.getElementById("submitButton4");
  // submitButton4.addEventListener("click", function () {
  //   IsInEditConversionValid()
  // });


  function IsFormValid() {
    var submitAllowed = true;
    var YesCount1 = 0;
    var YesCount2 = 0;
    var NoCount = 0;

    // Reset validation states and error messages for all relevant fields
    $(
      'input[id^="newInFavourConversion"], input[id="ConveyanceDate"], input[id="TypeLease"], input[id="dateTransfer"], input[id^="remarks"]'
    ).removeClass("invalid");
    $(
      'input[id^="newInFavourConversion"], input[id="ConveyanceDate"], input[id="TypeLease"], input[id="dateTransfer"], input[id^="remarks"]'
    )
      .parent()
      .find(".text-danger")
      .html("");

    // Validate freeHoldFormYes checkboxes
    $('input[id^="freeHoldFormYes"]').each(function (index) {
      debugger
      var TextControlID1 =
        index == 0
          ? 'input[id^="newInFavourConversion"]'
          : 'input[id^="conversion' + index + '"]';
      var TextControlID2 =
        index == 0
          ? 'input[id^="ConveyanceDate"]'
          : 'input[id^="ConveyanceDate' + index + '"]';
      var IsChecked = $(this).is(":checked");
      if (IsChecked) {
        $(TextControlID1).each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("invalid");
            $(this)
              .parent()
              .find(".text-danger")
              .html("This field is required");
            submitAllowed = false;
          } else {
            YesCount1++;
          }
        });

        $(TextControlID2).each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("invalid");
            $(this)
              .parent()
              .find(".text-danger")
              .html("This field is required");
            submitAllowed = false;
          } else {
            YesCount2++;
          }
        });
      } else {
        NoCount++;
      }
    });

    // Validate landTypeFormYes checkbox
    $('input[id="landTypeFormYes"]').each(function () {
      var IsChecked = $(this).is(":checked");
      if (IsChecked) {
        $('input[id="VacantPossession"]').each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("invalid");
            $(this)
              .parent()
              .find(".text-danger")
              .html("This field is required");
            submitAllowed = false;
          } else {
            YesCount1++;
          }
        });

        $('input[id="dateTransfer"]').each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("invalid");
            $(this)
              .parent()
              .find(".text-danger")
              .html("This field is required");
            submitAllowed = false;
          } else {
            YesCount2++;
          }
        });
      } else {
        NoCount++;
      }
    });

    // Validate landTypeFormOthersYes checkbox
    $('input[id="landTypeFormOthersYes"]').each(function () {
      var IsChecked = $(this).is(":checked");
      if (IsChecked) {
        $('input[id^="remarks"]').each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("invalid");
            $(this)
              .parent()
              .find(".text-danger")
              .html("This field is required");
            submitAllowed = false;
          } else {
            YesCount1++;
          }
        });
      } else {
        NoCount++;
      }
    });

    if (submitAllowed) {
      stepper3.next();
    }
  }

  var submitButton4 = document.getElementById("submitButton4");
  if (submitButton4) {
    submitButton4.addEventListener("click", function () {
      IsFormValid();
    });
  }

  var submitButton5 = document.getElementById('submitButton5');
  submitButton5.addEventListener('click', function () {
    // if (validateForm5()) {
    stepper3.next()
    // }
  });

  // Diwakar Sinha
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
            $(this).addClass("invalid");
            const errorDiv = $(this).parent().find(".text-danger");
            errorDiv.html("This field is required");
            submitAllowed = false;
          } else {
            $(this).removeClass("invalid");
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
            $(this).addClass("invalid");
            const errorDiv = $(this).parent().find(".text-danger");
            errorDiv.html("This field is required");
            submitAllowed = false;
          } else {
            $(this).removeClass("invalid");
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
      var TextControlID =
        index == 0
          ? 'input[id^="reentryDate"]'
          : 'input[id^="reentryDate' + index + '"]';
      var IsChecked = $(this).is(":checked");
      if (IsChecked) {
        var txtRowCount = $(TextControlID).length;
        var YesCount = 0;

        $(TextControlID).each(function () {
          if ($(this).val().trim() === "") {
            $(this).addClass("invalid");
            const errorDiv = $(this).parent().find(".text-danger");
            errorDiv.html("This field is required");
            submitAllowed = false;
          } else {
            $(this).removeClass("invalid");
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

  // var submitButton6 = document.getElementById("submitButton6");
  // submitButton6.addEventListener("click", function () {
  //   IsMisceFormValid();
  // });

  var btnfinalsubmit = document.getElementById("btnfinalsubmit");
  btnfinalsubmit.addEventListener("click", function () {
    if (validateForm7()) {
      this.removeAttribute("type", "submit");
    } else {
      this.setAttribute("type", "button");
    }
  });
});
