// Field Validation
$(document).ready(function () {
  $(".alpha-only").keypress(function (event) {
    var charCode = event.which;
    if (
      (charCode < 65 || (charCode > 90 && charCode < 97) || charCode > 122) &&
      charCode !== 32 &&
      charCode !== 46 &&
      charCode !== 47
    ) {
      event.preventDefault();
    }
  });

  $(".numericDecimal").on("input", function () {
    var value = $(this).val();
    if (!/^\d*\.?\d*$/.test(value)) {
      $(this).val(value.slice(0, -1));
    }
  });

  $(".numericOnly").on("input", function (e) {
    $(this).val(
      $(this)
        .val()
        .replace(/[^0-9]/g, "")
    );
  });
  $(".numericDecimalHyphen").on("input", function () {
    var value = $(this).val();
    if (!/^[\d-]*\.?\d*$/.test(value)) {
      $(this).val(value.slice(0, -1));
    }
  });
  $(".alphaNum-hiphenForwardSlash").on("input", function () {
    var value = $(this).val();
    // Allow only alphanumeric, hyphen, and forward slash
    var filteredValue = value.replace(/[^a-zA-Z0-9\-\/]/g, "");
    $(this).val(filteredValue);
  });

  //   Date Format
  $(".date_format").on("input", function (e) {
    var input = $(this).val().replace(/\D/g, "");
    if (input.length > 8) {
      input = input.substring(0, 8);
    }

    var formattedDate = "";
    if (input.length > 0) {
      formattedDate = input.substring(0, 2);
    }
    if (input.length >= 3) {
      formattedDate += "-" + input.substring(2, 4);
    }
    if (input.length >= 5) {
      formattedDate += "-" + input.substring(4, 8);
    }

    $(this).val(formattedDate);
  });

  // Plot No.
  $(".plotNoAlpaMix").on("input", function () {
    var pattern = /[^a-zA-Z0-9+\-/]/g;
    var sanitizedValue = $(this).val().replace(pattern, "");
    $(this).val(sanitizedValue);
  });
  // PAN Number
  // PAN
  $(".pan_number_format").on("input", function (event) {
    var value = $(this).val().toUpperCase();
    var newValue = "";
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
      } else if (i >= 5 && i < 9) {
        if (/[0-9]/.test(char)) {
          newValue += char;
        } else {
          valid = false;
          break;
        }
      } else if (i === 9) {
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
  // Share
  $(".alphaNum_slash_modulus").on("input", function () {
    var value = $(this).val();
    var sanitizedValue = value.replace(/[^a-zA-Z0-9\/%]/g, "");
    if (value !== sanitizedValue) {
      $(this).val(sanitizedValue);
    }
  });
});
// Repeater for Add Co-Applicant Lessee Details
// Repeater for Add Co-Applicant Lessee Details
$("#MUTrepeater").createRepeater({
  showFirstItemToDefault: true,
});
// End
// Repeater for Add Co-Applicant Lessee Details
$("#CONrepeater").createRepeater({
  showFirstItemToDefault: true,
});

$("#repeater").createRepeater({
  showFirstItemToDefault: true,
});
// End
// Repeater for Add Applicant Lessee Details
// End
// Repeater for Add Applicant Lessee Details
$("#repeaterLessee").createRepeater({
  showFirstItemToDefault: true,
});

$("#affidavits_repeater").createRepeater({
  showFirstItemToDefault: true,
});
$("#indemnityBond_repeater").createRepeater({
  showFirstItemToDefault: true,
});
// End
// AffidavitRepeater
$("#repeaterAffidavit").createRepeater({
  showFirstItemToDefault: true,
});
// End
// IndemnityRepeater
$("#repeaterIndemnity").createRepeater({
  showFirstItemToDefault: true,
});
// End
// IndemnityRepeaterConversion
$("#repeaterIndemnityCon").createRepeater({
  showFirstItemToDefault: true,
});
// End
// repeaterUndertakingCon
$("#repeaterUndertakingCon").createRepeater({
  showFirstItemToDefault: true,
});
// End
// repeaterUndertakingCon
$("#repeaterAffidavitsCon").createRepeater({
  showFirstItemToDefault: true,
});
// End
/**Conversion Repeaters */
// IndemnityBond
$("#convDocIndemnityBond_repeater").createRepeater({
  showFirstItemToDefault: true,
});
// End
// repeaterUndertakingCon
$("#convDocUndertaking_repeater").createRepeater({
  showFirstItemToDefault: true,
});
// End
// property photo
$("#convDocPropertyPhoto_repeater").createRepeater({
  showFirstItemToDefault: true,
});
// End
function getBaseURL() {
  const { protocol, hostname, port } = window.location;
  return `${protocol}//${hostname}${port ? ":" + port : ""}`;
}

$(document).ready(function () {
  // Self Attested Doc for Other
  // Self Attested Doc for Other
  $("#selectdocselfattesteddocname").change(function () {
    if ($(this).val() === "Other") {
      $("#docName").show();
      $("#docName").show();
    } else {
      $("#docName").hide();
      $("#docName").hide();
    }
  });

  // Application Form Show/Hide Based on Selection
  $("#applicationType").change(function () {
    const selectedValue = $(this).val();

    if (selectedValue === "NOC") {
      $(".nocDiv").show();
      $(".FHSubstitutionMutationdiv").hide();
      $(".propertycertificateDiv").hide();
      $(".salepermissionDiv").hide();
      $(".LHConversiondiv").hide();
      $(".deedofappartmentDiv").hide();
      $(".landusechangeDiv").hide();
    } else if (selectedValue === "") {
      $(".nocDiv").hide();
      $(".FHSubstitutionMutationdiv").hide();
      $(".propertycertificateDiv").hide();
      $(".salepermissionDiv").hide();
      $(".LHConversiondiv").hide();
      $(".deedofappartmentDiv").hide();
      $(".landusechangeDiv").hide();
    } else if (selectedValue === "SUB_MUT") {
      $(".nocDiv").hide();
      $(".FHSubstitutionMutationdiv").show();
      $(".propertycertificateDiv").hide();
      $(".salepermissionDiv").hide();
      $(".LHConversiondiv").hide();
      $(".deedofappartmentDiv").hide();
      $(".landusechangeDiv").hide();

      getUserDetails()
        .then(function (response) {
          if (response.status) {
            $("#mutNameApp").val(response.data.user.name);
            $("#mutGenderApp").val(response.data.details.gender);
            $("#mutDateOfBirth").val(response.data.details.dob);
            $("#mutAge").val(response.data.details.age);
            $("#mutprefixApp").html(response.data.details.so_do_spouse);
            $("#mutFathernameApp").val(response.data.details.second_name);
            $("#mutAadharApp").val(response.data.details.aadhar_card);
            $("#mutPanApp").val(response.data.details.pan_card);
            $("#mutMobilenumberApp").val(response.data.user.mobile_no);
          }
        })
        .catch(function (error) {
          console.error("Error during AJAX call:", error);
        }); //code changed by Nitin to reuse fetch-user details function
    } else if (selectedValue === "PRP_CERT") {
      $(".nocDiv").hide();
      $(".FHSubstitutionMutationdiv").hide();
      $(".propertycertificateDiv").show();
      $(".salepermissionDiv").hide();
      $(".LHConversiondiv").hide();
      $(".deedofappartmentDiv").hide();
      $(".landusechangeDiv").hide();
    } else if (selectedValue === "SEL_PERM") {
      $(".nocDiv").hide();
      $(".FHSubstitutionMutationdiv").hide();
      $(".propertycertificateDiv").hide();
      $(".salepermissionDiv").show();
      $(".LHConversiondiv").hide();
      $(".deedofappartmentDiv").hide();
      $(".landusechangeDiv").hide();
    } else if (selectedValue === "CONVERSION") {
      $(".nocDiv").hide();
      $(".FHSubstitutionMutationdiv").hide();
      $(".propertycertificateDiv").hide();
      $(".salepermissionDiv").hide();
      $(".LHConversiondiv").show();
      $(".deedofappartmentDiv").hide();
      $(".landusechangeDiv").hide();

      getUserDetails()
        .then(function (response) {
          if (response.status) {
            $("#convname").val(response.data.user.name);
            $("#convgender").val(response.data.details.gender);
            $("#conDateOfBirth").val(response.data.details.dob);
            $("#conAge").val(response.data.details.age);
            $("#convprefixApp").html(response.data.details.so_do_spouse);
            $("#convfathername").val(response.data.details.second_name);
            $("#convaadhar").val(response.data.details.aadhar_card);
            $("#convpan").val(response.data.details.pan_card);
            $("#convmobilenumber").val(response.data.user.mobile_no);
          }
        })
        .catch(function (error) {
          console.error("Error during AJAX call:", error);
        }); //code changed by Nitin to reuse fetch-user details function
    } else if (selectedValue === "DOA") {
      $(".nocDiv").hide();
      $(".FHSubstitutionMutationdiv").hide();
      $(".propertycertificateDiv").hide();
      $(".salepermissionDiv").hide();
      $(".LHConversiondiv").hide();
      $(".deedofappartmentDiv").show();
      $(".landusechangeDiv").hide();
    } else if (selectedValue === "LUC") {
      var propertyId = $("#propertyid").val();
      var updateId = $('input[name="updateId"]').val();
      if (propertyid) {
        getLandUseChangeData(propertyId, updateId, function (success, message) {
          if (success) {
            $(".nocDiv").hide();
            $(".FHSubstitutionMutationdiv").hide();
            $(".propertycertificateDiv").hide();
            $(".salepermissionDiv").hide();
            $(".LHConversiondiv").hide();
            $(".deedofappartmentDiv").hide();
            $(".landusechangeDiv").show();
          } else {
            showError(message);
          }
        });
      }
    } else {
      $("#freeleasetitle").text("");
      $(".nocDiv").hide();
      $(".FHSubstitutionMutationdiv").hide();
      $(".propertycertificateDiv").hide();
      $(".salepermissionDiv").hide();
      $(".propertycertificateDiv").hide();
      $(".salepermissionDiv").hide();
      $(".LHConversiondiv").hide();
      $(".deedofappartmentDiv").hide();
      $(".deedofappartmentDiv").hide();
      $(".landusechangeDiv").hide();
    }
  });

  // -------------------- if Yes Mortgaged --------------------
  $("#YesMortgaged").change(function () {
    $("#yesRemarksDiv").show();
  });
  $("#NoMortgaged").change(function () {
    $("#yesRemarksDiv").hide();
  });

  // -------------------- if Yes Court Order --------------------
  $("#YesCourtOrder").change(function () {
    $("#yescourtorderDiv").show();
  });
  $("#NoCourtOrder").change(function () {
    $("#yescourtorderDiv").hide();
  });

  // -------------------- if Yes Court Order in Conversion --------------------
  /* $("#YesCourtOrderConversion").change(function () {
    $("#yescourtorderConversionDiv").show();
  });
  $("#NoCourtOrderConversion").change(function () {
    $("#yescourtorderConversionDiv").hide();
  }); */
  $('input[name="courtorderConversion"]').change(function () {
    $("#yescourtorderConversionDiv").css(
      "display",
      $(this).val() == 1 ? "block" : "none"
    );
  });

  // -------------------- if Yes Mortgaged in Conversion --------------------
  /* $("#YesMortgagedConversion").change(function () {
    $("#yesRemarksDivConversion").show();
  });
  $("#NoMortgagedConversion").change(function () {
    $("#yesRemarksDivConversion").hide();
  }); */

  $('input[name="propertymortgagedConversion"]').change(function () {
    $("#yesRemarksDivConversion").css(
      "display",
      $(this).val() == 1 ? "block" : "none"
    );
  });

  // -------------------- if Yes Deed Lost in Conversion --------------------
  /* $("#YesDeedLostConversion").change(function () {
    $("#yesDeedLostDivConversion").show();
  });
  $("#NoMortgagedConversion").change(function () {
    $("#NoDeedLostConversion").hide();
  }); */
  /** function  chnaged by nitin to show /hide lease deed loast inputs*/

  $('input[name="isLeaseDeedLost"]').change(function () {
    $("#optionalInputs").css("display", $(this).val() == 1 ? "block" : "none");
  });
});


// Court Order Mutation commented by anil for no need this input and validation on 31-01-2025
// $("#YesCourtOrderMutation").change(function () {
//   $("#yescourtorderMutationDiv").show();
// });
// $("#NoCourtOrderMutation").change(function () {
//   $("#yescourtorderMutationDiv").hide();
// });
// End

// Checkbox Group Only One Selection
$("input:checkbox").on("click", function () {
  var $box = $(this);
  if ($box.is(":checked")) {
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});

document.addEventListener("DOMContentLoaded", function () {
  var form1 = document.getElementById("newstep-vl-1");
  var form2 = document.getElementById("newstep-vl-2");
  var form3 = document.getElementById("newstep-vl-3");


  // Form 1 Fields
  var propertyid = document.getElementById("propertyid");
  var propertyStatus = document.getElementById("propertyStatus");
  var applicationType = document.getElementById("applicationType");
  var statusofapplicant = document.getElementById("statusofapplicant");

  var lucpropertytypeto = document.getElementById("lucpropertytypeto");
  var lucpropertysubtypeto = document.getElementById("lucpropertysubtypeto");

  // Form 1 Errors
  var propertyIdError = document.getElementById("propertyIdError");
  var propertyStatusError = document.getElementById("propertyStatusError");
  var applicationTypeError = document.getElementById("applicationTypeError");
  var statusofapplicantError = document.getElementById(
    "statusofapplicantError"
  );

  var lucpropertytypetoError = document.getElementById(
    "lucpropertytypetoError"
  );
  var lucpropertysubtypetoError = document.getElementById(
    "lucpropertysubtypetoError"
  );

  //Field & Validation Error id for DOA - Lalit tiwari on 11/nov/2024
  var flatid = document.getElementById("flatid");
  var buildingName = document.getElementById("buildingName");
  var originalBuyerName = document.getElementById("originalBuyerName");
  var presentOccupantName = document.getElementById("presentOccupantName");
  var purchasedFrom = document.getElementById("purchasedFrom");
  var purchaseDate = document.getElementById("purchaseDate");
  var apartmentArea = document.getElementById("apartmentArea");
  var plotArea = document.getElementById("plotArea");

  var flatidError = document.getElementById("flatidError");
  var buildingNameError = document.getElementById("buildingNameError");
  var originalBuyerNameError = document.getElementById(
    "originalBuyerNameError"
  );
  var presentOccupantNameError = document.getElementById(
    "presentOccupantNameError"
  );
  var purchasedFromError = document.getElementById("purchasedFromError");
  var purchaseDateError = document.getElementById("purchaseDateError");
  var apartmentArea = document.getElementById("apartmentArea");
  var plotAreaError = document.getElementById("plotAreaError");

  function validatePropertyId() {
    var propertyidValue = propertyid.value.trim();
    if (propertyidValue === "") {
      propertyIdError.textContent = "Property ID is required";
      propertyIdError.style.display = "block";
      return false;
    } else {
      propertyIdError.style.display = "none";
      return true;
    }
  }

  function validatePropertyStatus() {
    var propertyStatusValue = propertyStatus.value.trim();
    if (propertyStatusValue === "") {
      propertyStatusError.textContent = "Property Status is required";
      propertyStatusError.style.display = "block";
      return false;
    } else {
      propertyStatusError.style.display = "none";
      propertyStatusError.style.display = "none";
      return true;
    }
  }

  function validateApplicationType() {
    var applicationTypeValue = applicationType.value.trim();
    if (applicationTypeValue === "") {
      applicationTypeError.textContent = "Application Type is required";
      applicationTypeError.style.display = "block";
      return false;
    } else {
      applicationTypeError.style.display = "none";
      applicationTypeError.style.display = "none";
      return true;
    }
  }

  function validateStatusOfApplicant() {
    var statusofapplicantValue = statusofapplicant.value.trim();
    if (statusofapplicantValue === "") {
      statusofapplicantError.textContent = "Status of Applicant is required";
      statusofapplicantError.style.display = "block";
      return false;
    } else {
      statusofapplicantError.style.display = "none";
      statusofapplicantError.style.display = "none";
      return true;
    }
  }

  function validateFlat() {
    var flatidValue = flatid.value.trim();
    if (flatidValue === "") {
      flatidError.textContent = "Flat is required";
      flatidError.style.display = "block";
      return false;
    } else {
      flatidError.style.display = "none";
      flatidError.style.display = "none";
      return true;
    }
  }

  /*function validateBuildingName() {
    var buildingNameValue = buildingName.value.trim();
    if (buildingNameValue === "") {
      buildingNameError.textContent = "Building Name is required";
      buildingNameError.style.display = "block";
      return false;
    } else {
      buildingNameError.style.display = "none";
      buildingNameError.style.display = "none";
      return true;
    }
  }

  function validateoriginalBuyerName() {
    var originalBuyerNameValue = originalBuyerName.value.trim();
    if (originalBuyerNameValue === "") {
      originalBuyerNameError.textContent = "Original Buyer Name is required";
      originalBuyerNameError.style.display = "block";
      return false;
    } else {
      originalBuyerNameError.style.display = "none";
      originalBuyerNameError.style.display = "none";
      return true;
    }
  }

  function validatePresentOccupantName() {
    var presentOccupantNameValue = presentOccupantName.value.trim();
    if (presentOccupantNameValue === "") {
      presentOccupantNameError.textContent =
        "Present Occupant Name is required";
      presentOccupantNameError.style.display = "block";
      return false;
    } else {
      presentOccupantNameError.style.display = "none";
      return true;
    }
  }

  function validatePurchasedFrom() {
    var purchasedFromValue = purchasedFrom.value.trim();
    if (purchasedFromValue === "") {
      purchasedFromError.textContent = "Purchased From Name is required";
      purchasedFromError.style.display = "block";
      return false;
    } else {
      purchasedFromError.style.display = "none";
      return true;
    }
  }*/

  function validateBuildingName() {
    var buildingNameValue = buildingName.value.trim();
    var regex = /^[A-Za-z0-9\s]+$/; // Allows only alphabets and spaces

    if (buildingNameValue === "") {
      buildingNameError.textContent = "Building Name is required";
      buildingNameError.style.display = "block";
      return false;
    } else if (!regex.test(buildingNameValue)) {
      buildingNameError.textContent = "Only alphabets, number and spaces are allowed";
      buildingNameError.style.display = "block";
      return false;
    } else {
      buildingNameError.style.display = "none";
      return true;
    }
  }

  function validateoriginalBuyerName() {
    var originalBuyerNameValue = originalBuyerName.value.trim();
    var regex = /^[A-Za-z0-9\s]+$/; // Allows only alphabets and spaces

    if (originalBuyerNameValue === "") {
      originalBuyerNameError.textContent = "Original Buyer Name is required";
      originalBuyerNameError.style.display = "block";
      return false;
    } else if (!regex.test(originalBuyerNameValue)) {
      originalBuyerNameError.textContent = "Only alphabets, number and spaces are allowed";
      originalBuyerNameError.style.display = "block";
      return false;
    } else {
      originalBuyerNameError.style.display = "none";
      return true;
    }
  }

  function validatePresentOccupantName() {
    var presentOccupantNameValue = presentOccupantName.value.trim();
    var regex = /^[A-Za-z\s]+$/; // Allows only alphabets and spaces

    if (presentOccupantNameValue === "") {
      presentOccupantNameError.textContent = "Present Occupant Name is required";
      presentOccupantNameError.style.display = "block";
      return false;
    } else if (!regex.test(presentOccupantNameValue)) {
      presentOccupantNameError.textContent = "Only alphabets and spaces are allowed";
      presentOccupantNameError.style.display = "block";
      return false;
    } else {
      presentOccupantNameError.style.display = "none";
      return true;
    }
  }

  function validatePurchasedFrom() {
    var purchasedFromValue = purchasedFrom.value.trim();
    var regex = /^[A-Za-z\s]+$/; // Allows only alphabets and spaces

    if (purchasedFromValue === "") {
      purchasedFromError.textContent = "Purchased From Name is required";
      purchasedFromError.style.display = "block";
      return false;
    } else if (!regex.test(purchasedFromValue)) {
      purchasedFromError.textContent = "Only alphabets and spaces are allowed";
      purchasedFromError.style.display = "block";
      return false;
    } else {
      purchasedFromError.style.display = "none";
      return true;
    }
  }


  function validatePurchaseDate() {
    var purchaseDateValue = purchaseDate.value.trim();

    if (purchaseDateValue === "") {
      purchaseDateError.textContent = "Purchase Date is required";
      purchaseDateError.style.display = "block";
      return false;
    }

    // Parse the purchase date and today's date
    var selectedDate = new Date(purchaseDateValue);
    var today = new Date();

    // Check if the selected date is in the future
    if (selectedDate > today) {
      purchaseDateError.textContent = "Purchase Date cannot be in the future";
      purchaseDateError.style.display = "block";
      return false;
    }

    purchaseDateError.style.display = "none";
    return true;
  }

  /*function validateApartmentArea() {
    var apartmentAreaValue = apartmentArea.value.trim();
    if (apartmentAreaValue === "") {
      apartmentAreaError.textContent = "Flat Area is required";
      apartmentAreaError.style.display = "block";
      return false;
    } else {
      apartmentAreaError.style.display = "none";
      return true;
    }
  }

  function validatePlotArea() {
    var plotAreaValue = plotArea.value.trim();
    if (plotAreaValue === "") {
      plotAreaError.textContent = "Plot Area is required";
      plotAreaError.style.display = "block";
      return false;
    } else {
      plotAreaError.style.display = "none";
      return true;
    }
  }*/

  function validateApartmentArea() {
    var apartmentAreaValue = apartmentArea.value.trim();
    var regex = /^[0-9]+(\.[0-9]+)?$/; // Allows only numbers and decimals

    if (apartmentAreaValue === "") {
      apartmentAreaError.textContent = "Flat Area is required";
      apartmentAreaError.style.display = "block";
      return false;
    } else if (!regex.test(apartmentAreaValue)) {
      apartmentAreaError.textContent = "Flat Area must be a valid number";
      apartmentAreaError.style.display = "block";
      return false;
    } else {
      apartmentAreaError.style.display = "none";
      return true;
    }
  }

  function validatePlotArea() {
    var plotAreaValue = plotArea.value.trim();
    var regex = /^[0-9]+(\.[0-9]+)?$/; // Allows only numbers and decimals

    if (plotAreaValue === "") {
      plotAreaError.textContent = "Plot Area is required";
      plotAreaError.style.display = "block";
      return false;
    } else if (!regex.test(plotAreaValue)) {
      plotAreaError.textContent = "Plot Area must be a valid number";
      plotAreaError.style.display = "block";
      return false;
    } else {
      plotAreaError.style.display = "none";
      return true;
    }
  }



  function validateStatusOfChangeProperty() {
    var lucpropertytypetoValue = lucpropertytypeto.value.trim();
    if (lucpropertytypetoValue === "") {
      lucpropertytypetoError.textContent =
        "Change to Property Type is required";
      lucpropertytypetoError.style.display = "block";
      return false;
    } else {
      lucpropertytypetoError.style.display = "none";
      lucpropertytypetoError.style.display = "none";
      return true;
    }
  }

  function validateStatusOfChangeSubProperty() {
    var lucpropertysubtypetoValue = lucpropertysubtypeto.value.trim();
    if (lucpropertysubtypetoValue === "") {
      lucpropertysubtypetoError.textContent =
        "Change to Property Sub Type is required";
      lucpropertysubtypetoError.style.display = "block";
      return false;
    } else {
      lucpropertysubtypetoError.style.display = "none";
      lucpropertysubtypetoError.style.display = "none";
      return true;
    }
  }

  //Validate Form 1 DOA - Lalit tiwari on 11/Nov/2024
  function validateForm1DOA() {
    var isPropertyIdValid = validatePropertyId();
    var isPropertyStatusValid = validatePropertyStatus();
    var isApplicationTypeValid = validateApplicationType();
    var isStatusOfApplicantValid = validateStatusOfApplicant();
    // DOA
    var isFlatValid = validateFlat();
    var isBuildingNameValid = validateBuildingName();
    var isOriginalBuyerNameValid = validateoriginalBuyerName();
    var isPresentOccupantNameValid = validatePresentOccupantName();
    var isPurchasedFromValid = validatePurchasedFrom();
    var isPurchaseDateValid = validatePurchaseDate();
    var isApartmentAreaValid = validateApartmentArea();
    var isPlotAreaValid = validatePlotArea();

    return (
      isPropertyIdValid &&
      isPropertyStatusValid &&
      isApplicationTypeValid &&
      isStatusOfApplicantValid &&
      isFlatValid &&
      isBuildingNameValid &&
      isOriginalBuyerNameValid &&
      isPresentOccupantNameValid &&
      isPurchasedFromValid &&
      isPurchaseDateValid &&
      isApartmentAreaValid &&
      isPlotAreaValid
    );
  }

  // Validate Form 1
  function validateForm1LUC() {
    var isPropertyIdValid = validatePropertyId();
    var isPropertyStatusValid = validatePropertyStatus();
    var isApplicationTypeValid = validateApplicationType();
    var isStatusOfApplicantValid = validateStatusOfApplicant();
    // LUC
    var isStatusOfChangePropertyValid = validateStatusOfChangeProperty();
    var isStatusOfChangeSubPropertyValid = validateStatusOfChangeSubProperty();

    return (
      isPropertyIdValid &&
      isPropertyStatusValid &&
      isApplicationTypeValid &&
      isStatusOfApplicantValid &&
      isStatusOfChangePropertyValid &&
      isStatusOfChangeSubPropertyValid
    );
  }

  // Form 2 Fields
  var lucpropertyTaxpayreceipt = document.getElementById(
    "lucpropertyTaxpayreceipt"
  );
  var PropertyTaxAssessmentReceipt = document.getElementById(
    "PropertyTaxAssessmentReceipt"
  );
  var lucphoto1 = document.getElementById("lucphoto1");
  var lucmpdzonalpermitting = document.getElementById("lucmpdzonalpermitting");
  var lucagreeconsent = document.getElementById("lucagreeconsent");

  // Form 2 Errors
  var lucpropertyTaxpayreceiptError = document.getElementById(
    "lucpropertyTaxpayreceiptError"
  );
  var PropertyTaxAssessmentReceiptError = document.getElementById(
    "PropertyTaxAssessmentReceiptError"
  );
  var lucphoto1Error = document.getElementById("lucphoto1Error");
  var lucmpdzonalpermittingError = document.getElementById(
    "lucmpdzonalpermittingError"
  );
  var lucagreeconsentError = document.getElementById("lucagreeconsentError");

  function validatelucpropertyTaxpayreceipt() {
    if (lucpropertyTaxpayreceipt.files.length > 0) {
      var file = lucpropertyTaxpayreceipt.files[0];
      if (file.size > 5 * 1024 * 1024) {
        lucpropertyTaxpayreceiptError.textContent =
          "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        lucpropertyTaxpayreceiptError.textContent =
          "Only PDF files are allowed";
        return false;
      } else {
        lucpropertyTaxpayreceiptError.textContent = "";
        return true;
      }
    } else {
      // lucpropertyTaxpayreceiptError.textContent =
      //   "Property Tax Payment Receipt is required";
      // return false;

      if (lucpropertyTaxpayreceipt.getAttribute("data-should-validate") == 1) {
        return true;
      }
      lucpropertyTaxpayreceiptError.textContent =
        "Property Tax Payment Receipt is required";
      return false;
    }
  }

  function validatePropertyTaxAssessmentReceipt() {
    if (PropertyTaxAssessmentReceipt.files.length > 0) {
      var file = PropertyTaxAssessmentReceipt.files[0];
      if (file.size > 5 * 1024 * 1024) {
        PropertyTaxAssessmentReceiptError.textContent =
          "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        PropertyTaxAssessmentReceiptError.textContent =
          "Only PDF files are allowed";
        return false;
      } else {
        PropertyTaxAssessmentReceiptError.textContent = "";
        return true;
      }
    } else {
      // PropertyTaxAssessmentReceiptError.textContent =
      //   "Property Tax Assessment is required";
      // return false;
      if (
        PropertyTaxAssessmentReceipt.getAttribute("data-should-validate") == 1
      ) {
        return true;
      }
      PropertyTaxAssessmentReceiptError.textContent =
        "Property Tax Assessment is required";
      return false;
    }
  }

  function validateLUCPhoto1() {
    if (lucphoto1.files.length > 0) {
      var file = lucphoto1.files[0];
      if (file.size > 5 * 1024 * 1024) {
        lucphoto1Error.textContent = "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        lucphoto1Error.textContent = "Only PDF file is allowed";
        return false;
      } else {
        lucphoto1Error.textContent = "";
        return true;
      }
    } else {
      // lucphoto1Error.textContent = "Property Photo is required";
      // return false;
      if (lucphoto1.getAttribute("data-should-validate") == 1) {
        return true;
      }
      lucphoto1Error.textContent = "Property Photo is required";
      return false;
    }
  }

  function validateLUCMPDPermit() {
    if (lucmpdzonalpermitting.files.length > 0) {
      var file = lucmpdzonalpermitting.files[0];
      if (file.size > 5 * 1024 * 1024) {
        lucmpdzonalpermittingError.textContent =
          "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        lucmpdzonalpermittingError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        lucmpdzonalpermittingError.textContent = "";
        return true;
      }
    } else {
      // lucmpdzonalpermittingError.textContent =
      //   "MPD/Zonal Plan Permitting LUC is required";
      // return false;
      if (lucmpdzonalpermitting.getAttribute("data-should-validate") == 1) {
        return true;
      }
      lucmpdzonalpermittingError.textContent =
        "MPD/Zonal Plan Permitting LUC is required";
      return false;
    }
  }

  function validateStatusOfChangeProperty() {
    var lucpropertytypetoValue = lucpropertytypeto.value.trim();
    if (lucpropertytypetoValue === "") {
      lucpropertytypetoError.textContent =
        "Change to Property Type is required";
      lucpropertytypetoError.style.display = "block";
      return false;
    } else {
      lucpropertytypetoError.style.display = "none";
      lucpropertytypetoError.style.display = "none";
      return true;
    }
  }

  function validateAgreeConsentLUC() {
    if (!lucagreeconsent.checked) {
      lucagreeconsentError.textContent = "Please accept Terms & Conditions";
      lucagreeconsentError.style.display = "block";
      return false;
    } else {
      lucagreeconsentError.style.display = "none";
      return true;
    }
  }

  // Validate Form 2
  function validateForm2LUC() {
    var islucpropertyTaxpayreceiptValid = validatelucpropertyTaxpayreceipt();
    var isPropertyTaxAssessmentReceiptValid =
      validatePropertyTaxAssessmentReceipt();
    var isLUCPhoto1Valid = validateLUCPhoto1();
    var isLUCMPDPermitValid = validateLUCMPDPermit();
    var isAgreeConsentLUCValid = validateAgreeConsentLUC();

    return (
      islucpropertyTaxpayreceiptValid &&
      isPropertyTaxAssessmentReceiptValid &&
      isLUCPhoto1Valid &&
      isLUCMPDPermitValid &&
      isAgreeConsentLUCValid
    );
  }

  // Validate DOA Form 2
  function validateForm2DOA() {
    var isBuilderBuyerAgreementValid = validateBuilderBuyerAgreement();
    var isSaleDeedValid = validateSaleDeed();
    var isBuildingPlanValid = validateBuildingPlan();
    var isOtherDocumentValid = validateOtherDocument();
    return (isBuilderBuyerAgreementValid && isSaleDeedValid && isBuildingPlanValid && isOtherDocumentValid);
  }

  function validateBuilderBuyerAgreement() {
    if (BuilderBuyerAgreement.files.length > 0) {
      var file = BuilderBuyerAgreement.files[0];
      if (file.size > 5 * 1024 * 1024) {
        BuilderBuyerAgreementError.textContent =
          "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        BuilderBuyerAgreementError.textContent =
          "Only PDF files are allowed";
        return false;
      } else {
        BuilderBuyerAgreementError.textContent = "";
        return true;
      }
    } else {
      if (BuilderBuyerAgreement.getAttribute("data-should-validate") == 1) {
        return true;
      }
      BuilderBuyerAgreementError.textContent =
        "Builder buyer agreement is required";
      return false;
    }
  }
  function validateSaleDeed() {
    if (SaleDeed.files.length > 0) {
      var file = SaleDeed.files[0];
      if (file.size > 5 * 1024 * 1024) {
        SaleDeedError.textContent =
          "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        SaleDeedError.textContent =
          "Only PDF files are allowed";
        return false;
      } else {
        SaleDeedError.textContent = "";
        return true;
      }
    } else {
      if (SaleDeed.getAttribute("data-should-validate") == 1) {
        return true;
      }
      SaleDeedError.textContent =
        "Sale deed is required";
      return false;
    }
  }
  function validateBuildingPlan() {
    if (BuildingPlan.files.length > 0) {
      var file = BuildingPlan.files[0];
      if (file.size > 5 * 1024 * 1024) {
        BuildingPlanError.textContent =
          "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        BuildingPlanError.textContent =
          "Only PDF files are allowed";
        return false;
      } else {
        BuildingPlanError.textContent = "";
        return true;
      }
    } else {
      if (BuildingPlan.getAttribute("data-should-validate") == 1) {
        return true;
      }
      BuildingPlanError.textContent =
        "Building plan is required";
      return false;
    }
  }
  function validateOtherDocument() {
    if (OtherDocument.files.length > 0) {
      var file = OtherDocument.files[0];
      if (file.size > 5 * 1024 * 1024) {
        OtherDocumentError.textContent =
          "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        OtherDocumentError.textContent =
          "Only PDF files are allowed";
        return false;
      } else {
        OtherDocumentError.textContent = "";
        return true;
      }
    } else {
      if (OtherDocument.getAttribute("data-should-validate") == 1) {
        return true;
      }
      OtherDocumentError.textContent =
        "Other document agreement is required";
      return false;
    }
  }

  // Form 1 Fields
  var namergapp = document.getElementById("namergapp");
  var mutExecutedOnAsConLease = document.getElementById(
    "mutExecutedOnAsConLease"
  );
  var regno = document.getElementById("regno");
  var bookno = document.getElementById("bookno");
  var volumeno = document.getElementById("volumeno");
  var pagenoFrom = document.getElementById("pagenoFrom");
  var pagenoTo = document.getElementById("pagenoTo");
  var regdate = document.getElementById("regdate");
  var soughtByApplicant = document.getElementById("soughtByApplicant");
  var YesMortgaged = document.getElementById("YesMortgaged");
  var remarks = document.getElementById("remarks");
  var mutcase = document.getElementById("mutCaseNo");

  // Form 1 Errors
  var namergappError = document.getElementById("namergappError");
  var mutExecutedOnAsConLeaseError = document.getElementById(
    "mutExecutedOnAsConLeaseError"
  );
  var regnoError = document.getElementById("regnoError");
  var booknoError = document.getElementById("booknoError");
  var volumenoError = document.getElementById("volumenoError");
  var pagenoFromError = document.getElementById("pagenoFromError");
  var pagenoToError = document.getElementById("pagenoToError");
  var regdateError = document.getElementById("regdateError");
  var soughtByApplicantError = document.getElementById(
    "soughtByApplicantError"
  );
  var YesMortgagedError = document.getElementById("YesMortgagedError");

  function validateNamerGapp() {
    var namergappValue = namergapp.value.trim();
    if (namergappValue === "") {
      namergappError.textContent = "Executed in favour of is required";
      namergappError.style.display = "block";
      return false;
    } else {
      namergappError.style.display = "none";
      return true;
    }
  }

  function validateExecutedOn() {
    var mutExecutedOnAsConLeaseValue = mutExecutedOnAsConLease.value.trim();
    if (mutExecutedOnAsConLeaseValue === "") {
      mutExecutedOnAsConLeaseError.textContent =
        "Executed On field is required";
      mutExecutedOnAsConLeaseError.style.display = "block";
      return false;
    } else {
      mutExecutedOnAsConLeaseError.style.display = "none";
      return true;
    }
  }

  function validateRegOn() {
    var regnoValue = regno.value.trim();
    if (regnoValue === "") {
      regnoError.textContent = "Executed On field is required";
      regnoError.style.display = "block";
      return false;
    } else {
      regnoError.style.display = "none";
      return true;
    }
  }

  function validateBookNo() {
    var booknoValue = bookno.value.trim();
    if (booknoValue === "") {
      booknoError.textContent = "Book No. is required";
      booknoError.style.display = "block";
      return false;
    } else {
      booknoError.style.display = "none";
      return true;
    }
  }

  function validateVolumeNo() {
    var volumenoValue = volumeno.value.trim();
    if (volumenoValue === "") {
      volumenoError.textContent = "Volume No. is required";
      volumenoError.style.display = "block";
      return false;
    } else {
      volumenoError.style.display = "none";
      return true;
    }
  }


  // commented by anil modifciton code for validation page number "To" is never be less then "From" input. 27-01-2025
  // function validatePageNoFrom() {
  //   var pagenoValue = pagenoFrom.value.trim();
  //   if (pagenoValue === "") {
  //     pagenoFromError.textContent = "Page No. From is required";
  //     pagenoFromError.style.display = "block";
  //     return false;
  //   } else {
  //     pagenoFromError.style.display = "none";
  //     return true;
  //   }
  // }

  // function validatePageNoTo() {
  //   var pagenoValue = pagenoTo.value.trim();
  //   var pagenoValueFrom = pagenoFrom.value.trim();
  //   if (pagenoValue === "") {
  //     pagenoToError.textContent = "Page No. To is required";
  //     pagenoToError.style.display = "block";
  //     return false;
  //   } else {
  //     pagenoToError.style.display = "none";
  //     return true;
  //   }
  // }



  // commented by anil on 11-02-2025 for Trigger validation when the user types, changes, or loses focus in the input fields
  // $(document).on('input blur change', '#pagenoTo, #pagenoFrom', function () {
  //   validatePageNo();
  // });

  // function validatePageNo() {
  //   var pagenoValueTo = $('#pagenoTo').val().trim();
  //   var pagenoValueFrom = $('#pagenoFrom').val().trim();

  //   // Validate 'Page No. To'
  //   if (pagenoValueTo === "") {
  //     $('#pagenoToError').text("Page No. To is required").show();
  //   } else if (parseInt(pagenoValueTo) < parseInt(pagenoValueFrom)) {
  //     $('#pagenoToError').text("Page No. To cannot be less than Page No. From").show();
  //   } else {
  //     $('#pagenoToError').hide();
  //   }

  //   // Validate 'Page No. From'
  //   if (pagenoValueFrom === "") {
  //     $('#pagenoFromError').text("Page No. From is required").show();
  //   } else if (parseInt(pagenoValueFrom) > parseInt(pagenoValueTo) && pagenoValueTo !== "") {
  //     $('#pagenoFromError').text("Page No. From cannot be greater than Page No. To").show();
  //   } else {
  //     $('#pagenoFromError').hide();
  //   }
  // }

  $(document).on("input blur change", "#pagenoTo", function () {
    validatePageNoTo();
  });

  function validatePageNoTo() {
    var pagenoValue = pagenoTo.value.trim();
    var pagenoValueFrom = pagenoFrom.value.trim();

    // Check if 'Page No. To' is empty
    if (pagenoValue === "") {
      pagenoToError.textContent = "Page No. To is required";
      pagenoToError.style.display = "block";
      return false;
    }

    // Check if 'Page No. To' is a positive integer
    if (!/^\d+$/.test(pagenoValue) || parseInt(pagenoValue) <= 0) {
      pagenoToError.textContent = "Page No. To must be a positive number";
      pagenoToError.style.display = "block";
      return false;
    }

    // Check if 'Page No. To' is less than 'Page No. From'
    if (parseInt(pagenoValue) < parseInt(pagenoValueFrom)) {
      pagenoToError.textContent =
        "Page No. To cannot be less than Page No. From";
      pagenoToError.style.display = "block";
      return false;
    }

    // If no issues, hide the error message
    pagenoToError.style.display = "none";
    return true;
  }

  $(document).on("input blur change", "#pagenoFrom", function () {
    validatePageNoFrom();
  });

  function validatePageNoFrom() {
    var pagenoValueFrom = pagenoFrom.value.trim();
    var pagenoValueTo = pagenoTo.value.trim();

    // Check if 'Page No. From' is empty
    if (pagenoValueFrom === "") {
      pagenoFromError.textContent = "Page No. From is required";
      pagenoFromError.style.display = "block";
      return false;
    }

    // Check if 'Page No. From' is a positive integer
    if (!/^\d+$/.test(pagenoValueFrom) || parseInt(pagenoValueFrom) <= 0) {
      pagenoFromError.textContent = "Page No. From must be a positive number";
      pagenoFromError.style.display = "block";
      return false;
    }

    // Check if 'Page No. From' is greater than 'Page No. To'
    if (parseInt(pagenoValueFrom) > parseInt(pagenoValueTo)) {
      pagenoFromError.textContent =
        "Page No. From cannot be greater than Page No. To";
      pagenoFromError.style.display = "block";
      return false;
    }

    // If no issues, hide the error message
    pagenoFromError.style.display = "none";
    return true;
  }

  function validateRegDate() {
    var regdateValue = regdate.value.trim();
    var mutExecutedOnAsConValueLease = mutExecutedOnAsConLease.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    var regdateObj = new Date(regdateValue);
    var mutExecutedOnAsConLeaseObj = new Date(mutExecutedOnAsConValueLease);

    if (regdateValue === "") {
      regdateError.textContent = "Reg. Date is required";
      regdateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (regdateValue > today) {
      regdateError.textContent = "Reg. Date cannot be in the future";
      regdateError.style.display = "block";
      regdate.value = ""; // Clear the invalid date
      return false;
    }

    // Ensure regdate is not earlier than mutExecutedOnAsConLease
    if (regdateObj < mutExecutedOnAsConLeaseObj) {
      regdateError.textContent =
        "Reg. Date cannot be earlier than the Executed On date";
      regdateError.style.display = "block";
      regdate.value = ""; // Clear the invalid date
      return false;
    }

    regdateError.style.display = "none";
    return true;
  }

  // Apply max date (today) to prevent selecting a future date from the date picker
  document.addEventListener("DOMContentLoaded", function () {
    var today = new Date().toISOString().split("T")[0];

    regdate.setAttribute("max", today);

    regdate.addEventListener("blur", validateRegDate);
    regdate.addEventListener("change", validateRegDate);
  });
  // commneted end herer

  function validateSoughtApplicant() {
    var soughtByApplicantValue = document.querySelectorAll(
      ".documentType:checked"
    );
    console.log(soughtByApplicantValue);
    if (soughtByApplicantValue.length === 0) {
      soughtByApplicantError.style.display = "block";
      soughtByApplicantError.textContent =
        "Please select at least one document";
      return false;
    } else {
      soughtByApplicantError.style.display = "none";
      return true;
    }

    // if (soughtByApplicantValue === "") {
    //   soughtByApplicantError.textContent = "Mutation/Substitution sought by applicant is required";
    //   soughtByApplicantError.style.display = "block";
    //   return false;
    // } else {
    //   soughtByApplicantError.style.display = "none";
    //   return true;
    // }
  }

  function validateYesMortgages() {
    if (YesMortgaged.checked) {
      var remarksValue = remarks.value.trim();
      if (remarksValue === "") {
        YesMortgagedError.textContent = "Remarks is required.";
        YesMortgagedError.style.display = "block";
        return false;
      } else {
        YesMortgagedError.style.display = "none";
      }
    }
    return true;
  }

  // commented by anil for no need this input and validation on 31-01-2025
  // function validYesCourtOrder() {
  //   if (YesCourtOrderMutation.checked) {
  //     var mutcaseValue = mutcase.value.trim();
  //     if (mutcaseValue === "") {
  //       YesCourtOrderMutationError.textContent = "Case No. is required.";
  //       YesCourtOrderMutationError.style.display = "block";
  //       return false;
  //     } else {
  //       YesCourtOrderMutationError.style.display = "none";
  //     }
  //   }
  //   return true;
  // }

  // Validate Form 1 MUT
  function validateForm1MUT() {
    var isFarm1MUTValid = validateNamerGapp();
    var isExecutedOnValid = validateExecutedOn();
    var isRegOnValid = validateRegOn();
    var isBookNoValid = validateBookNo();
    var isVolumeNoValid = validateVolumeNo();
    var isPageNoFromValid = validatePageNoFrom();
    var isPageNoToValid = validatePageNoTo();
    var isRegDateValid = validateRegDate();
    var isSoughtApplicantValid = validateSoughtApplicant();
    var isYesMortgagesValid = validateYesMortgages();
    // var isYesCourtOrderValid = validYesCourtOrder();

    return (
      isFarm1MUTValid &&
      isExecutedOnValid &&
      isRegOnValid &&
      isBookNoValid &&
      isVolumeNoValid &&
      isPageNoFromValid &&
      isPageNoToValid &&
      isRegDateValid &&
      isSoughtApplicantValid &&
      isYesMortgagesValid
      // isYesCourtOrderValid
    );
  }

  // Conversion Form 1 Fields
  var convExecutedFavour = document.getElementById("convNameAsOnLease");
  var convExecutedOnAsOnLease = document.getElementById("convExecutedOnAsOnLease");
  var convRegNo = document.getElementById("convregno");
  var convBookno = document.getElementById("convbookno");
  var convVolumeno = document.getElementById("convvolumeno");
  var convPagenoFrom = document.getElementById("convPagenoFrom");
  var convPagenoTo = document.getElementById("convPagenoTo");
  var convRegDate = document.getElementById("convregno");
  var convYesCourtOrder = document.getElementById("YesCourtOrderConversion");
  var convCaseNo = document.getElementById("convCaseNo");
  var convCaseDetail = document.getElementById("convCaseDetail");
  var convCourtOrderFile = document.getElementById("convCourtOrderFile");
  var convCourtOrderDate = document.getElementById("convCourtOrderDate");
  var convCourtIssuingAuthority = document.getElementById("courtorderattestedbyConversion");
  var convYesMortgaged = document.getElementById("YesMortgagedConversion");
  var convMortgageeNOC = document.getElementById("convMortgageeBankNOC");
  var convDateOfNOC = document.getElementById("NOCAttestationDateConversion");
  var convMortgageeIssuingAuthority = document.getElementById("NOCIssuedByConversion");

  // Form 1 Errors
  var convExecutedFavourError = document.getElementById("convNameAsOnLeaseError");
  var convExecutedOnAsOnLeaseError = document.getElementById("convExecutedOnAsOnLeaseError");
  var convRegNoError = document.getElementById("convregnoError");
  var convBooknoError = document.getElementById("convbooknoError");
  var convVolumenoError = document.getElementById("convvolumenoError");
  var convPagenoFromError = document.getElementById("convPagenoFromError");
  var convPagenoToError = document.getElementById("convPagenoToError");
  var convRegDateError = document.getElementById("convregdateError");
  var convYesCourtOrderError = document.getElementById("YesMortgagedError");

  function validateConvExecutedfavour() {
    var convExecutedFavourValue = convExecutedFavour.value.trim();
    if (convExecutedFavourValue === "") {
      convExecutedFavourError.textContent = "Executed in favour of is required";
      convExecutedFavourError.style.display = "block";
      return false;
    } else {
      convExecutedFavourError.style.display = "none";
      return true;
    }
  }

  function validateConvExecutedOnAsOnLeaseDate() {
    var convExecutedOnAsOnLeaseValue = convExecutedOnAsOnLease.value.trim();
    if (convExecutedOnAsOnLeaseValue === "") {
      convExecutedOnAsOnLeaseError.textContent = "Executed date is required";
      convExecutedOnAsOnLeaseError.style.display = "block";
      return false;
    } else {
      convExecutedOnAsOnLeaseError.style.display = "block";
      return true;
    }
  }

  function validateForm1Conv() {
    var isConvExecutedNameValid = validateConvExecutedfavour();
    var isConvExecutedOnAsOnLeaseDate = validateConvExecutedOnAsOnLeaseDate();

    return (
      isConvExecutedNameValid &&
      isConvExecutedOnAsOnLeaseDate
    );
  }


  // Form 2 Fields
  var affidavits = document.getElementById("affidavits");
  var affidavitsDateAttestation = document.getElementById("dateattestation");
  var affidavitsAttestedby = document.getElementById("attestedby");

  var indemnityBond = document.getElementById("indemnityBond");
  var indemnityBonddateattestation = document.getElementById(
    "indemnityBondDateOfAttestation"
  );
  var indemnityBondattestedby = document.getElementById(
    "indemnityBondAttestedBy"
  );

  var leaseconyedeed = document.getElementById("leaseconyedeed");
  var dateofexecution = document.getElementById("leaseConvDeedDateOfExecution");
  var lesseename = document.getElementById("leaseConvDeedLesseename");

  var pannumber = document.getElementById("panNumber");
  // var pancertificateno = document.getElementById("panCertificateNo");
  // var pandateissue = document.getElementById("pandateissue");

  var aadharnumber = document.getElementById("aadharnumber");
  // var aadharcertificateno = document.getElementById("aadharCertificateNo");
  // var aadhardateissue = document.getElementById("aadhardateissue");

  var publicNoticeEnglish = document.getElementById("publicNoticeEnglish");
  var newspaperNameEnglish = document.getElementById("newspaperNameEnglish");
  var publicNoticeDateEnglish = document.getElementById(
    "publicNoticeDateEnglish"
  );

  var publicNoticeHindi = document.getElementById("publicNoticeHindi");
  var newspaperNameHindi = document.getElementById("newspaperNameHindi");
  var publicNoticeDateHindi = document.getElementById("publicNoticeDateHindi");

  var propertyPhoto = document.getElementById("propertyPhoto");

  // Form 2 Errors
  var affidavitsError = document.getElementById("affidavitsError");
  var dateattestationError = document.getElementById(
    "affidavitsDateOfAttestationError"
  );
  var attestedbyError = document.getElementById("affidavitAttestedByError");

  var indemnityBondError = document.getElementById("indemnityBondError");
  var indemnityBonddateattestationError = document.getElementById(
    "indemnityBondDateOfAttestationError"
  );
  var indemnityBondattestedbyError = document.getElementById(
    "indemnityBondAttestedByError"
  );

  var leaseconyedeedError = document.getElementById("leaseconyedeedError");
  var dateofexecutionError = document.getElementById(
    "leaseConvDeedDateOfExecutionError"
  );
  var lesseenameError = document.getElementById("leaseConvDeedLesseenameError");

  var pannumberError = document.getElementById("panNumberError");
  // var pancertificatenoError = document.getElementById("panCertificateNoError");
  // var pandateissueError = document.getElementById("pandateissueError");

  var aadharnumberError = document.getElementById("aadharnumberError");
  // var aadharcertificatenoError = document.getElementById("aadharCertificateNoError");
  // var aadhardateissueError = document.getElementById("aadhardateissueError");

  var publicNoticeEnglishError = document.getElementById(
    "publicNoticeEnglishError"
  );
  var newspaperNameEnglishError = document.getElementById(
    "newspaperNameEnglishError"
  );
  var publicNoticeDateEnglishError = document.getElementById(
    "publicNoticeDateEnglishError"
  );

  var publicNoticeHindiError = document.getElementById(
    "publicNoticeHindiError"
  );
  var newspaperNameHindiError = document.getElementById(
    "newspaperNameHindiError"
  );
  var publicNoticeDateHindiError = document.getElementById(
    "publicNoticeDateHindiError"
  );

  var propertyPhotoError = document.getElementById("propertyPhotoError");

  function validateAffidavits() {
    if (affidavits.files.length > 0) {
      var file = affidavits.files[0];
      if (file.size > 5 * 1024 * 1024) {
        affidavitsError.textContent = "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        affidavitsError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        affidavitsError.textContent = "";
        return true;
      }
    } else {
      if (affidavits.getAttribute("data-should-validate") == 1) {
        return true;
      }
      affidavitsError.textContent = "Affidavits is required";
      return false;
    }
  }
  function validateDateofAffidavits() {
    var affidavitsDateAttestationValue = affidavitsDateAttestation.value.trim();
    if (affidavitsDateAttestationValue === "") {
      dateattestationError.textContent = "Date of attestation is required";
      dateattestationError.style.display = "block";
      return false;
    } else {
      dateattestationError.style.display = "none";
      return true;
    }
  }
  function validateAttestedByAffidavits() {
    var affidavitsAttestedbyValue = affidavitsAttestedby.value.trim();
    if (affidavitsAttestedbyValue === "") {
      attestedbyError.textContent = "Attested by is required";
      attestedbyError.style.display = "block";
      return false;
    } else {
      attestedbyError.style.display = "none";
      return true;
    }
  }

  function validateIndemnityBond() {
    if (indemnityBond.files.length > 0) {
      var file = indemnityBond.files[0];
      if (file.size > 5 * 1024 * 1024) {
        indemnityBondError.textContent = "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        indemnityBondError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        indemnityBondError.textContent = "";
        return true;
      }
    } else {
      if (indemnityBond.getAttribute("data-should-validate") == 1) {
        return true;
      }
      indemnityBondError.textContent = "Indemnity Bond is required";
      return false;
    }
  }
  function validateIndemnityDateofAttestation() {
    var indemnityBonddateattestationValue = indemnityBonddateattestation.value.trim();
    if (indemnityBonddateattestationValue === "") {
      indemnityBonddateattestationError.textContent =
        "Date of attestation is required";
      indemnityBonddateattestationError.style.display = "block";
      return false;
    } else {
      indemnityBonddateattestationError.style.display = "none";
      return true;
    }
  }
  function validateIndemnityAttestedBy() {
    var indemnityBondattestedbyValue = indemnityBondattestedby.value.trim();
    if (indemnityBondattestedbyValue === "") {
      indemnityBondattestedbyError.textContent = "Attested by is required";
      indemnityBondattestedbyError.style.display = "block";
      return false;
    } else {
      indemnityBondattestedbyError.style.display = "none";
      return true;
    }
  }

  function validateLeaseConyence() {
    if (leaseconyedeed.files.length > 0) {
      var file = leaseconyedeed.files[0];
      if (file.size > 5 * 1024 * 1024) {
        leaseconyedeedError.textContent = "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        leaseconyedeedError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        leaseconyedeedError.textContent = "";
        return true;
      }
    } else {
      if (leaseconyedeed.getAttribute("data-should-validate") == 1) {
        return true;
      }
      leaseconyedeedError.textContent =
        "Lease Deed/Conveyance Deed is required";
      return false;
    }
  }
  function validateDateofExecution() {
    var dateofexecutionValue = dateofexecution.value.trim();
    if (dateofexecutionValue === "") {
      dateofexecutionError.textContent = "Date of execution is required";
      dateofexecutionError.style.display = "block";
      return false;
    } else {
      dateofexecutionError.style.display = "none";
      return true;
    }
  }
  function validateLesseeName() {
    var lesseenameValue = lesseename.value.trim();
    if (lesseenameValue === "") {
      lesseenameError.textContent = "Lessee Name is required";
      lesseenameError.style.display = "block";
      return false;
    } else {
      lesseenameError.style.display = "none";
      return true;
    }
  }

  function validatePAN() {
    if (pannumber.files.length > 0) {
      var file = pannumber.files[0];
      if (file.size > 5 * 1024 * 1024) {
        pannumberError.textContent = "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        pannumberError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        pannumberError.textContent = "";
        return true;
      }
    } else {
      if (pannumber.getAttribute("data-should-validate") == 1) {
        return true;
      }
      pannumberError.textContent = "PAN is required";
      return false;
    }
  }
  function validatePANCertification() {
    var pancertificatenoValue = pancertificateno.value.trim();
    if (pancertificatenoValue === "") {
      pancertificatenoError.textContent = "Certificate No. is required";
      pancertificatenoError.style.display = "block";
      return false;
    } else {
      pancertificatenoError.style.display = "none";
      return true;
    }
  }
  function validatePANDate() {
    var pandateissueValue = pandateissue.value.trim();
    if (pandateissueValue === "") {
      pandateissueError.textContent = "Date of Issue is required";
      pandateissueError.style.display = "block";
      return false;
    } else {
      pandateissueError.style.display = "none";
      return true;
    }
  }

  function validateAadhar() {
    if (aadharnumber.files.length > 0) {
      var file = aadharnumber.files[0];
      if (file.size > 5 * 1024 * 1024) {
        aadharnumberError.textContent = "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        aadharnumberError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        aadharnumberError.textContent = "";
        return true;
      }
    } else {
      if (aadharnumber.getAttribute("data-should-validate") == 1) {
        return true;
      }
      aadharnumberError.textContent = "Aadhar is required";
      return false;
    }
  }
  function validateAadharCertification() {
    var aadharcertificatenoValue = aadharcertificateno.value.trim();
    if (aadharcertificatenoValue === "") {
      aadharcertificatenoError.textContent = "Certificate No. is required";
      aadharcertificatenoError.style.display = "block";
      return false;
    } else {
      aadharcertificatenoError.style.display = "none";
      return true;
    }
  }
  function validateAadharDate() {
    var aadhardateissueValue = aadhardateissue.value.trim();
    if (aadhardateissueValue === "") {
      aadhardateissueError.textContent = "Date of Issue is required";
      aadhardateissueError.style.display = "block";
      return false;
    } else {
      aadhardateissueError.style.display = "none";
      return true;
    }
  }

  function validatePublicNoticeEnglish() {
    if (publicNoticeEnglish.files.length > 0) {
      var file = publicNoticeEnglish.files[0];
      if (file.size > 5 * 1024 * 1024) {
        publicNoticeEnglishError.textContent =
          "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        publicNoticeEnglishError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        publicNoticeEnglishError.textContent = "";
        return true;
      }
    } else {
      if (publicNoticeEnglish.getAttribute("data-should-validate") == 1) {
        return true;
      }
      publicNoticeEnglishError.textContent =
        "Public Notice in National Daily (English) is required";
      return false;
    }
  }

  function validateNewsPaperNameEnglish() {
    var newspapernameenglighValue = newspaperNameEnglish.value.trim();
    if (newspapernameenglighValue === "") {
      newspaperNameEnglishError.textContent =
        "Name of Newspaper(English) is required";
      newspaperNameEnglishError.style.display = "block";
      return false;
    }
    var newsEnglishAlpha = /^[A-Za-z\s]+$/;
    if (!newsEnglishAlpha.test(newspapernameenglighValue)) {
      newspaperNameEnglishError.textContent =
        "Newspaper Name must only contain alphabets";
      newspaperNameEnglishError.style.display = "block";
      return false;
    } else {
      newspaperNameEnglishError.style.display = "none";
      return true;
    }
  }

  // changed by anil on 17-02-2025 for future date input type show future date error validtion
  function validatePublicNoteDateEnglish() {
    var publicnoticedateValue = publicNoticeDateEnglish.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (publicnoticedateValue === "") {
      publicNoticeDateEnglishError.textContent =
        "Date of Public Notice is required";
      publicNoticeDateEnglishError.style.display = "block";
      return false;
    }

    // Future date validation
    if (publicnoticedateValue > today) {
      publicNoticeDateEnglishError.textContent =
        "Date of Public Notice cannot be in the future";
      publicNoticeDateEnglishError.style.display = "block";
      publicNoticeDateEnglish.value = ""; // Clear invalid input
      return false;
    }

    publicNoticeDateEnglishError.style.display = "none";
    return true;
  }

  function validatePublicNoticeHindi() {
    if (publicNoticeHindi.files.length > 0) {
      var file = publicNoticeHindi.files[0];
      if (file.size > 5 * 1024 * 1024) {
        publicNoticeHindiError.textContent = "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        publicNoticeHindiError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        publicNoticeHindiError.textContent = "";
        return true;
      }
    } else {
      if (publicNoticeHindi.getAttribute("data-should-validate") == 1) {
        return true;
      }
      publicNoticeHindiError.textContent =
        "Public Notice in National Daily (Hindi) is required";
      return false;
    }
  }

  function validateNewsPaperNameHindi() {
    var newspaperNameHindiValue = newspaperNameHindi.value.trim();
    if (newspaperNameHindiValue === "") {
      newspaperNameHindiError.textContent =
        "Name of Newspaper(Hindi) is required";
      newspaperNameHindiError.style.display = "block";
      return false;
    }
    var newsEnglishAlpha = /^[A-Za-z\s]+$/;
    if (!newsEnglishAlpha.test(newspaperNameHindiValue)) {
      newspaperNameHindiError.textContent =
        "Newspaper Name must only contain alphabets";
      newspaperNameHindiError.style.display = "block";
      return false;
    } else {
      newspaperNameHindiError.style.display = "none";
      return true;
    }
  }
  // changed by anil on 17-02-2025 for future date input type show future date error validtion
  function validatePublicNoteDateHindi() {
    var publicnoticedateValue = publicNoticeDateHindi.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (publicnoticedateValue === "") {
      publicNoticeDateHindiError.textContent =
        "Date of Public Notice is required";
      publicNoticeDateHindiError.style.display = "block";
      return false;
    }

    // Future date validation
    if (publicnoticedateValue > today) {
      publicNoticeDateHindiError.textContent =
        "Date of Public Notice cannot be in the future";
      publicNoticeDateHindiError.style.display = "block";
      publicNoticeDateHindi.value = ""; // Clear invalid input
      return false;
    }

    publicNoticeDateHindiError.style.display = "none";
    return true;
  }

  function validatePropertyPhoto() {
    if (propertyPhoto.files.length > 0) {
      var file = propertyPhoto.files[0];
      if (file.size > 5 * 1024 * 1024) {
        propertyPhotoError.textContent = "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        propertyPhotoError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        propertyPhotoError.textContent = "";
        return true;
      }
    } else {
      if (propertyPhoto.getAttribute("data-should-validate") == 1) {
        return true;
      }
      propertyPhotoError.textContent = "Property Photo is required";
      return false;
    }
  }

  // Apply max date restriction to prevent future dates in public notice date fields
  document.addEventListener("DOMContentLoaded", function () {
    var today = new Date().toISOString().split("T")[0];

    // Set max date for public notice date inputs
    publicNoticeDateEnglish.setAttribute("max", today);
    publicNoticeDateHindi.setAttribute("max", today);

    // Validate on blur and change to prevent manual future date entry
    publicNoticeDateEnglish.addEventListener(
      "blur",
      validatePublicNoteDateEnglish
    );
    publicNoticeDateEnglish.addEventListener(
      "change",
      validatePublicNoteDateEnglish
    );

    publicNoticeDateHindi.addEventListener("blur", validatePublicNoteDateHindi);
    publicNoticeDateHindi.addEventListener(
      "change",
      validatePublicNoteDateHindi
    );
  });

  // Validate Form 2 MUT
  function validateForm2MUT() {
    // var isAffidavitsValid = validateAffidavits();
    // var isDateofAffidavitsValid = validateDateofAffidavits();
    // var isAttestedByAffidavitsValid = validateAttestedByAffidavits();

    // var isIndemnityBondValid = validateIndemnityBond();
    // var isIndemnityDateofAttestationValid = validateIndemnityDateofAttestation();
    // var isIndemnityAttestedByValid = validateIndemnityAttestedBy();

    var isLeaseConyenceValid = validateLeaseConyence();
    // var isDateofExecutionValid = validateDateofExecution();
    // var isLesseeNameValid = validateLesseeName();

    var isPANValid = validatePAN();
    // var isPANCertificationValid = validatePANCertification();
    // var isPANDateValid = validatePANDate();

    var isAadharValid = validateAadhar();
    // var isAadharCertificationValid = validateAadharCertification();
    // var isAadharDateValid = validateAadharDate();

    var isPublicNoticeEnglishValid = validatePublicNoticeEnglish();
    var isNewsPaperNameEnglishValid = validateNewsPaperNameEnglish();
    var isPublicNoteDateEnglishValid = validatePublicNoteDateEnglish();

    var isPublicNoticeHindiValid = validatePublicNoticeHindi();
    var isNewsPaperNameHindiValid = validateNewsPaperNameHindi();
    var isPublicNoteDateHindiValid = validatePublicNoteDateHindi();

    var isPropertyPhotoValid = validatePropertyPhoto();

    return (
      // isAffidavitsValid &&
      // isDateofAffidavitsValid &&
      // isAttestedByAffidavitsValid &&

      // isIndemnityBondValid &&
      // isIndemnityDateofAttestationValid &&
      // isIndemnityAttestedByValid &&

      isLeaseConyenceValid &&
      // isDateofExecutionValid &&
      // isLesseeNameValid &&
      isPANValid &&
      // isPANCertificationValid &&
      // isPANDateValid &&

      isAadharValid &&
      // isAadharCertificationValid &&
      // isAadharDateValid &&

      isPublicNoticeEnglishValid &&
      isNewsPaperNameEnglishValid &&
      isPublicNoteDateEnglishValid &&
      isPublicNoticeHindiValid &&
      isNewsPaperNameHindiValid &&
      isPublicNoteDateHindiValid &&
      isPropertyPhotoValid
    );
  }

  // Form 3 Fields
  // validation var and fucntion added by anil for mutation third step select documents on 17-02-2025
  // Death Certificate Mutaition form step 3  add by anil on 17-02-2025 for validation
  var muteDethCertificate = document.getElementById("deathCertificate");
  var muteDethDeceaseName = document.getElementById(
    "deathCertificateDeceasedName"
  );
  var muteDethDate = document.getElementById("deathCertificateDeathdate");
  var muteDethCertificateIssueDate = document.getElementById(
    "deathCertificateIssuedate"
  );
  var muteDethCertificateNumber = document.getElementById(
    "deathCertificateDocumentCertificate"
  );
  var MutAgreeConsent = document.getElementById("agreeconsent");
  // Death Certificate Mutaition form step 3  add by anil on 17-02-2025 for validation

  // Sale Deed Mutaition form step 3 add by anil on 17-02-2025 for validation
  var muteSaleDeed = document.getElementById("saleDeed");
  var muteSaleDeedRegno = document.getElementById("saleDeedRegno");
  var muteSaleDeedVolume = document.getElementById("saleDeedVolume");
  var muteSaleDeedBookNo = document.getElementById("saleDeedBookNo");
  var muteSaleDeedFrom = document.getElementById("saleDeedFrom");
  var muteSaleDeedTo = document.getElementById("saleDeedTo");
  var muteSaleDeedRegDate = document.getElementById("saleDeedRegDate");
  var muteSaleDeedRegOfficeName = document.getElementById(
    "saleDeedRegOfficeName"
  );
  // Sale Deed Mutaition form step 3 add by anil on 17-02-2025 for validation

  // Regd. Will Deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  var muteWillRegdFile = document.getElementById("regdWillDeed");
  var muteWillTestatorName = document.getElementById("regWillDeedTestatorName");
  var muteWillRegno = document.getElementById("regWillDeedRegNo");
  var muteWillVolume = document.getElementById("regWillDeedVolume");
  var muteWillBookNo = document.getElementById("regWillDeedBookNo");
  var muteWillFrom = document.getElementById("regWillDeedFrom");
  var muteWillTo = document.getElementById("regWillDeedTo");
  var muteWillRegDate = document.getElementById("regWillDeedRegDate");
  var muteWillRegOfficeName = document.getElementById(
    "regWillDeedRegOfficeName"
  );
  // Regd. Will Deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Unregd. Will Deed Mutaition form step 3 add by anil on 20-02-2025 for validation
  var muteUnregdWillFile = document.getElementById("unregdWillCodocil");
  var muteUnregdWillTestatorName = document.getElementById(
    "unregWillCodicilTestatorName"
  );
  var muteUnregdWillDate = document.getElementById(
    "unregWillCodicilDateOfWillCodicil"
  );
  // Unregd. Will Deed Mutaition form step 3 add by anil on 20-02-2025 for validation

  // Registered Relinquishment Deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  var muteRelinquishDeedFile = document.getElementById("relinquishmentDeed");
  var muteRelinquishDeedReleaserName = document.getElementById(
    "relinquishDeedReleaserName"
  );
  var muteRelinquishDeedRegNo = document.getElementById("relinquishDeedRegNo");
  var muteRelinquishDeedVolume = document.getElementById(
    "relinquishDeedVolume"
  );
  var muteRelinquishDeedBookno = document.getElementById(
    "relinquishDeedBookno"
  );
  var muteRelinquishDeedFrom = document.getElementById("relinquishDeedFrom");
  var muteRelinquishDeedTo = document.getElementById("relinquishDeedTo");
  var muteRelinquishDeedRegdate = document.getElementById(
    "relinquishDeedRegdate"
  );
  var muteRelinquishDeedRegname = document.getElementById(
    "relinquishDeedRegname"
  );
  // Registered Relinquishment Deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Gift Deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  var muteGiftDeedFile = document.getElementById("giftDeed");
  var muteGiftDeedRegno = document.getElementById("giftdeedRegno");
  var muteGiftDeedVolume = document.getElementById("giftdeedVolume");
  var muteGiftDeedBookno = document.getElementById("giftdeedBookno");
  var muteGiftDeedFrom = document.getElementById("giftdeedFrom");
  var muteGiftDeedTo = document.getElementById("giftdeedTo");
  var muteGiftDeedRegdate = document.getElementById("giftdeedRegdate");
  var muteGiftDeedRegOfficeName = document.getElementById(
    "giftdeedRegOfficeName"
  );
  // Gift Deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Surviving Member Certificate Mutaition form step 3 add by anil on 18-02-2025 for validation
  var muteSmcFile = document.getElementById("survivingMemberCertificate");
  var muteSmcCertificateNo = document.getElementById("smcCertificateNo");
  var muteSmcDateOfIssue = document.getElementById("smcDateOfIssue");
  // Surviving Member Certificate Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation
  var muteSbpFile = document.getElementById("sanctionBuildingPlan");
  var muteSbpDateOfIssue = document.getElementById("sbpDateOfIssue");
  // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Any Other Document Mutaition form step 3 add by anil on 18-02-2025 for validation
  var muteAodFile = document.getElementById("anyOtherDocument");
  var muteAodRemark = document.getElementById("otherDocumentRemark");
  // Any Other Document Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Form 3 Errors
  // Death Certificate Mutaition form step 3  add by anil on 17-02-2025 for validation
  var muteDethCertificateError = document.getElementById(
    "deathCertificateError"
  );
  var muteDethDeceaseNameError = document.getElementById(
    "deathCertificateDeceasedNameError"
  );
  var muteDethDateError = document.getElementById(
    "deathCertificateDeathdateError"
  );
  var muteDethCertificateIssueDateError = document.getElementById(
    "deathCertificateIssuedateError"
  );
  var muteDethCertificateNumberError = document.getElementById(
    "deathCertificateDocumentCertificateError"
  );
  var MutAgreeconsentError = document.getElementById("MutAgreeconsentError");
  // Death Certificate Mutaition form step 3  add by anil on 17-02-2025 for validation

  // Sale Deed Mutaition form step 3 add by anil on 17-02-2025 for validation
  var muteSaleDeedError = document.getElementById("saleDeedError");
  var muteSaleDeedRegnoError = document.getElementById("saleDeedRegnoError");
  var muteSaleDeedVolumeError = document.getElementById("saleDeedVolumeError");
  var muteSaleDeedBookNoError = document.getElementById("saleDeedBookNoError");
  var muteSaleDeedFromError = document.getElementById("saleDeedFromError");
  var muteSaleDeedToError = document.getElementById("saleDeedToError");
  var muteSaleDeedRegDateError = document.getElementById(
    "saleDeedRegDateError"
  );
  var muteSaleDeedRegOfficeNameError = document.getElementById(
    "saleDeedRegOfficeNameError"
  );
  // Sale Deed Mutaition form step 3 add by anil on 17-02-2025 for validation

  // Regd. Will Deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  var muteWillRegdFileError = document.getElementById("regdWillDeedError");
  var muteWillTestatorNameError = document.getElementById(
    "regWillDeedTestatorNameError"
  );
  var muteWillRegnoError = document.getElementById("regWillDeedRegNoError");
  var muteWillVolumeError = document.getElementById("regWillDeedVolumeError");
  var muteWillBookNoError = document.getElementById("regWillDeedBookNoError");
  var muteWillFromError = document.getElementById("regWillDeedFromError");
  var muteWillToError = document.getElementById("regWillDeedToError");
  var muteWillRegDateError = document.getElementById("regWillDeedRegDateError");
  var muteWillRegOfficeNameError = document.getElementById(
    "regWillDeedRegOfficeNameError"
  );
  // Regd. Will Deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Unregd. Will Deed Mutaition form step 3 add by anil on 20-02-2025 for validation
  var muteUnregdWillFileError = document.getElementById(
    "unregdWillCodocilError"
  );
  var muteUnregdWillTestatorNameError = document.getElementById(
    "unregWillCodicilTestatorNameError"
  );
  var muteUnregdWillDateError = document.getElementById(
    "unregWillCodicilDateOfWillCodicilError"
  );
  // Unregd. Will Deed Mutaition form step 3 add by anil on 20-02-2025 for validation

  // Registered Relinquishment Deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  var muteRelinquishDeedFileError = document.getElementById(
    "relinquishmentDeedError"
  );
  var muteRelinquishDeedReleaserNameError = document.getElementById(
    "relinquishDeedReleaserNameError"
  );
  var muteRelinquishDeedRegNoError = document.getElementById(
    "relinquishDeedRegNoError"
  );
  var muteRelinquishDeedVolumeError = document.getElementById(
    "relinquishDeedVolumeError"
  );
  var muteRelinquishDeedBooknoError = document.getElementById(
    "relinquishDeedBooknoError"
  );
  var muteRelinquishDeedFromError = document.getElementById(
    "relinquishDeedFromError"
  );
  var muteRelinquishDeedToError = document.getElementById(
    "relinquishDeedToError"
  );
  var muteRelinquishDeedRegdateError = document.getElementById(
    "relinquishDeedRegdateError"
  );
  var muteRelinquishDeedRegnameError = document.getElementById(
    "relinquishDeedRegnameError"
  );
  // Registered Relinquishment Deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Gift Deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  var muteGiftDeedFileError = document.getElementById("giftDeedError");
  var muteGiftDeedRegnoError = document.getElementById("giftdeedRegnoError");
  var muteGiftDeedVolumeError = document.getElementById("giftdeedVolumeError");
  var muteGiftDeedBooknoError = document.getElementById("giftdeedBooknoError");
  var muteGiftDeedFromError = document.getElementById("giftdeedFromError");
  var muteGiftDeedToError = document.getElementById("giftdeedToError");
  var muteGiftDeedRegdateError = document.getElementById(
    "giftdeedRegdateError"
  );
  var muteGiftDeedRegOfficeNameError = document.getElementById(
    "giftdeedRegOfficeNameError"
  );
  // Gift Deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Surviving Member Certificate Mutaition form step 3 add by anil on 18-02-2025 for validation
  var muteSmcFileError = document.getElementById(
    "survivingMemberCertificateError"
  );
  var muteSmcCertificateNoError = document.getElementById(
    "smcCertificateNoError"
  );
  var muteSmcDateOfIssueError = document.getElementById("smcDateOfIssueError");
  // Surviving Member Certificate Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation
  var muteSbpFileError = document.getElementById("sanctionBuildingPlanError");
  var muteSbpDateOfIssueError = document.getElementById("sbpDateOfIssueError");
  // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Any Other Document Mutaition form step 3 add by anil on 18-02-2025 for validation
  var muteAodFileError = document.getElementById("anyOtherDocumentError");
  var muteAodRemarkError = document.getElementById("otherDocumentRemarkError");
  // Any Other Document Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Death Certificate Mutaition form step 3  add by anil on 17-02-2025 for validation
  function isElementVisible(element) {
    console.log(element);
    if (!element) return false; // Ensure element exists

    // Get computed styles of the element
    var style = window.getComputedStyle(element);

    // Check if element is visible based on display, visibility, opacity, and dimensions
    var isVisible = style.display !== "none";

    return isVisible;
  }
  function validateMuteDethCertificate() {
    if (muteDethCertificate.files.length > 0) {
      var file = muteDethCertificate.files[0];
      if (file.size > 5 * 1024 * 1024) {
        muteDethCertificateError.textContent =
          "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteDethCertificateError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        muteDethCertificateError.textContent = "";
        return true;
      }
    } else {
      if (muteDethCertificate.getAttribute("data-should-validate") == 1) {
        return true;
      }
      muteDethCertificateError.textContent =
        "Death Certificate PDF file is required";
      return false;
    }
  }

  function validateMuteDethDeceaseName() {
    var muteDethDeceaseNameValue = muteDethDeceaseName.value.trim();

    // Check if the input is empty
    if (muteDethDeceaseNameValue === "") {
      muteDethDeceaseNameError.textContent = "Name of Deceased is required";
      muteDethDeceaseNameError.style.display = "block";
      return false;
    }

    // Check if the input contains only alphabets
    var alphaPattern = /^[A-Za-z]+$/;
    if (!alphaPattern.test(muteDethDeceaseNameValue)) {
      muteDethDeceaseNameError.textContent = "Name must only contain alphabets";
      muteDethDeceaseNameError.style.display = "block";
      return false;
    }

    // If all validations pass
    muteDethDeceaseNameError.style.display = "none";
    return true;
  }

  function validateMuteDethDate() {
    var muteDethDateValue = muteDethDate.value.trim();
    var muteDethCertificateIssueDateValue = muteDethCertificateIssueDate.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (muteDethDateValue === "") {
      muteDethDateError.textContent = "Date of Death is required";
      muteDethDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteDethDateValue > today) {
      muteDethDateError.textContent = "Date of Death cannot be in the future";
      muteDethDateError.style.display = "block";
      muteDethDate.value = ""; // Clear invalid input
      return false;
    }

    // Check if muteDethDate is greater than muteDethCertificateIssueDate
    if (
      muteDethCertificateIssueDateValue &&
      muteDethDateValue > muteDethCertificateIssueDateValue
    ) {
      muteDethDateError.textContent =
        "Date of Death cannot be greater than the Date of Certificate Issue";
      muteDethDateError.style.display = "block";
      muteDethDate.value = ""; // Clear invalid input
      return false;
    }

    muteDethDateError.style.display = "none";
    return true;
  }

  function validateMuteDethCertificateIssueDate() {
    var muteDethCertificateIssueDateValue = muteDethCertificateIssueDate.value.trim();
    var muteDethDateValue = muteDethDate.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (muteDethCertificateIssueDateValue === "") {
      muteDethCertificateIssueDateError.textContent =
        "Certificate Issue Date is required";
      muteDethCertificateIssueDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteDethCertificateIssueDateValue > today) {
      muteDethCertificateIssueDateError.textContent =
        "Certificate Issue Date cannot be in the future";
      muteDethCertificateIssueDateError.style.display = "block";
      muteDethCertificateIssueDate.value = ""; // Clear invalid input
      return false;
    }

    // Check if muteDethCertificateIssueDate is less than muteDethDate
    if (
      muteDethDateValue &&
      muteDethCertificateIssueDateValue < muteDethDateValue
    ) {
      muteDethCertificateIssueDateError.textContent =
        "Certificate Issue Date cannot be earlier than Date of Death";
      muteDethCertificateIssueDateError.style.display = "block";
      muteDethCertificateIssueDate.value = ""; // Clear invalid input
      return false;
    }

    muteDethCertificateIssueDateError.style.display = "none";
    return true;
  }

  function validateMuteDethCertificateNumber() {
    var muteDethCertificateNumberValue = muteDethCertificateNumber.value.trim();
    if (muteDethCertificateNumberValue === "") {
      muteDethCertificateNumberError.textContent =
        "Death Certificate No. is required";
      muteDethCertificateNumberError.style.display = "block";
      return false;
    } else {
      muteDethCertificateNumberError.style.display = "none";
    }
    return true;
  }
  // Death Certificate Mutaition form step 3  add by anil on 17-02-2025 for validation

  // Sale Deed Mutaition form step 3 add by anil on 17-02-2025 for validation
  function validateMuteSaleDeed() {
    if (muteSaleDeed.files.length > 0) {
      var file = muteSaleDeed.files[0];
      if (file.size > 5 * 1024 * 1024) {
        muteSaleDeedError.textContent = "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteSaleDeedError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        muteSaleDeedError.textContent = "";
        return true;
      }
    } else {
      if (muteSaleDeed.getAttribute("data-should-validate") == 1) {
        return true;
      }
      muteSaleDeedError.textContent = "Sale Deed PDF File is required";
      return false;
    }
  }

  function validateMuteSaleDeedRegno() {
    var muteSaleDeedRegnoValue = muteSaleDeedRegno.value.trim();
    if (muteSaleDeedRegnoValue === "") {
      muteSaleDeedRegnoError.textContent = "Deed Registration No. is required";
      muteSaleDeedRegnoError.style.display = "block";
      return false;
    } else {
      muteSaleDeedRegnoError.style.display = "none";
    }
    return true;
  }
  function validateMuteSaleDeedVolume() {
    var muteSaleDeedVolumeValue = muteSaleDeedVolume.value.trim();

    // Check if the field is empty
    if (muteSaleDeedVolumeValue === "") {
      muteSaleDeedVolumeError.textContent = "Volume is required";
      muteSaleDeedVolumeError.style.display = "block";
      return false;
    }

    // Check if the value is numeric
    if (isNaN(muteSaleDeedVolumeValue)) {
      muteSaleDeedVolumeError.textContent = "Volume must be a numeric value";
      muteSaleDeedVolumeError.style.display = "block";
      return false;
    }

    // Check if the value is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteSaleDeedVolumeValue) <= 0) {
      muteSaleDeedVolumeError.textContent = "Volume must be a positive number";
      muteSaleDeedVolumeError.style.display = "block";
      return false;
    }

    muteSaleDeedVolumeError.style.display = "none";
    return true;
  }
  function validateMuteSaleDeedBookNo() {
    var muteSaleDeedBookNoValue = muteSaleDeedBookNo.value.trim();

    // Check if the field is empty
    if (muteSaleDeedBookNoValue === "") {
      muteSaleDeedBookNoError.textContent = "Book No. is required";
      muteSaleDeedBookNoError.style.display = "block";
      return false;
    }

    // Check if the Book No. is numeric
    if (isNaN(muteSaleDeedBookNoValue)) {
      muteSaleDeedBookNoError.textContent = "Book No. must be a numeric value";
      muteSaleDeedBookNoError.style.display = "block";
      return false;
    }

    // Check if the Book No. is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteSaleDeedBookNoValue) <= 0) {
      muteSaleDeedBookNoError.textContent =
        "Book No. must be a positive number";
      muteSaleDeedBookNoError.style.display = "block";
      return false;
    }

    muteSaleDeedBookNoError.style.display = "none";
    return true;
  }

  $(document).on("input blur change", "#saleDeedFrom", function () {
    validateMuteSaleDeedFrom();
  });

  function validateMuteSaleDeedFrom() {
    var muteSaleDeedFromValue = muteSaleDeedFrom.value.trim();
    var muteSaleDeedValueTo = muteSaleDeedTo.value.trim();

    // Check if the field is empty
    if (muteSaleDeedFromValue === "") {
      muteSaleDeedFromError.textContent = "Page No From is required";
      muteSaleDeedFromError.style.display = "block";
      return false;
    }

    // Check if the value is numeric
    if (isNaN(muteSaleDeedFromValue)) {
      muteSaleDeedFromError.textContent =
        "Page No From must be a numeric value";
      muteSaleDeedFromError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteSaleDeedFromValue) <= 0) {
      muteSaleDeedFromError.textContent =
        "Page No From must be a positive number";
      muteSaleDeedFromError.style.display = "block";
      return false;
    }
    // Check if 'Page No. From' is greater than 'Page No. To'
    if (parseInt(muteSaleDeedFromValue) > parseInt(muteSaleDeedValueTo)) {
      muteSaleDeedFromError.textContent =
        "From cannot be greater than Page No. To";
      muteSaleDeedFromError.style.display = "block";
      return false;
    } else {
      muteSaleDeedFromError.style.display = "none";
      return true;
    }
  }

  $(document).on("input blur change", "#saleDeedTo", function () {
    validateMuteSaleDeedTo();
  });

  function validateMuteSaleDeedTo() {
    var muteSaleDeedToValue = muteSaleDeedTo.value.trim();
    var muteSaleDeedValueFrom = muteSaleDeedFrom.value.trim();
    // Check if the field is empty
    if (muteSaleDeedToValue === "") {
      muteSaleDeedToError.textContent = "Page No To is required";
      muteSaleDeedToError.style.display = "block";
      // Check the value
      return false;
    }

    // Check if the value is numeric
    if (isNaN(muteSaleDeedToValue)) {
      muteSaleDeedToError.textContent = "Page No To must be a numeric value";
      muteSaleDeedToError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteSaleDeedToValue) <= 0) {
      muteSaleDeedToError.textContent = "Page No To must be a positive number";
      muteSaleDeedToError.style.display = "block";
      return false;
    }

    // Check if 'Page No. To' is less than 'Page No. From'
    if (parseInt(muteSaleDeedToValue) < parseInt(muteSaleDeedValueFrom)) {
      muteSaleDeedToError.textContent =
        "Page No. To cannot be less than Page No. From";
      muteSaleDeedToError.style.display = "block";
      return false;
    } else {
      muteSaleDeedToError.style.display = "none";
      return true;
    }
  }

  function validateMuteSaleDeedRegDate() {
    var muteSaleDeedRegDateValue = muteSaleDeedRegDate.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (muteSaleDeedRegDateValue === "") {
      muteSaleDeedRegDateError.textContent = "Registration Date is required";
      muteSaleDeedRegDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteSaleDeedRegDateValue > today) {
      muteSaleDeedRegDateError.textContent =
        "Registration Date cannot be in the future";
      muteSaleDeedRegDateError.style.display = "block";
      muteSaleDeedRegDate.value = ""; // Clear invalid input
      return false;
    }

    muteSaleDeedRegDateError.style.display = "none";
    return true;
  }
  function validateMuteSaleDeedRegOfficeName() {
    var muteSaleDeedRegOfficeNameValue = muteSaleDeedRegOfficeName.value.trim();
    if (muteSaleDeedRegOfficeNameValue === "") {
      muteSaleDeedRegOfficeNameError.textContent =
        "Registration Office Name is required";
      muteSaleDeedRegOfficeNameError.style.display = "block";
      return false;
    }

    // Check if the value contains only alphabetic characters and spaces
    var regex = /^[A-Za-z\s]+$/;
    if (!regex.test(muteSaleDeedRegOfficeNameValue)) {
      muteSaleDeedRegOfficeNameError.textContent =
        "Registration Office Name must only contain alphabets";
      muteSaleDeedRegOfficeNameError.style.display = "block";
      return false;
    } else {
      muteSaleDeedRegOfficeNameError.style.display = "none";
    }
    return true;
  }
  // Sale Deed Mutaition form step 3 add by anil on 17-02-2025 for validation

  // Regd. Will Deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  function validateMuteWillRegdFile() {
    if (muteWillRegdFile.files.length > 0) {
      var file = muteWillRegdFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        muteWillRegdFileError.textContent = "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteWillRegdFileError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        muteWillRegdFileError.textContent = "";
        return true;
      }
    } else {
      if (muteWillRegdFile.getAttribute("data-should-validate") == 1) {
        return true;
      }
      muteWillRegdFileError.textContent =
        "Will/Codicil Deed PDF File is required";
      return false;
    }
  }

  function validateMuteWillTestatorName() {
    var muteWillTestatorNameValue = muteWillTestatorName.value.trim();
    if (muteWillTestatorNameValue === "") {
      muteWillTestatorNameError.textContent = "Testator Name is required";
      muteWillTestatorNameError.style.display = "Block";
      return false;
    }

    // Check if the value contains only alphabetic characters and spaces
    var testNameAlpha = /^[A-Za-z\s]+$/;
    if (!testNameAlpha.test(muteWillTestatorNameValue)) {
      muteWillTestatorNameError.textContent =
        "Testator Name must only contain alphabets";
      muteWillTestatorNameError.style.display = "block";
      return false;
    } else {
      muteWillTestatorNameError.style.display = "none";
    }
    return true;
  }

  function validateMuteWillRegno() {
    var muteWillRegnoValue = muteWillRegno.value.trim();
    if (muteWillRegnoValue === "") {
      muteWillRegnoError.textContent =
        "Will/Codicil Registration No. is required";
      muteWillRegnoError.style.display = "block";
      return false;
    } else {
      muteWillRegnoError.style.display = "none";
    }
    return true;
  }
  function validateMuteWillVolume() {
    var muteWillVolumeValue = muteWillVolume.value.trim();

    // Check if the field is empty
    if (muteWillVolumeValue === "") {
      muteWillVolumeError.textContent = "Volume is required";
      muteWillVolumeError.style.display = "block";
      return false;
    }

    // Check if the value is numeric
    if (isNaN(muteWillVolumeValue)) {
      muteWillVolumeError.textContent = "Volume must be a numeric value";
      muteWillVolumeError.style.display = "block";
      return false;
    }

    // Check if the value is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteWillVolumeValue) <= 0) {
      muteWillVolumeError.textContent = "Volume must be a positive number";
      muteWillVolumeError.style.display = "block";
      return false;
    }

    muteWillVolumeError.style.display = "none";
    return true;
  }
  function validateMuteWillBookNo() {
    var muteWillBookNoValue = muteWillBookNo.value.trim();

    // Check if the field is empty
    if (muteWillBookNoValue === "") {
      muteWillBookNoError.textContent = "Book No. is required";
      muteWillBookNoError.style.display = "block";
      return false;
    }

    // Check if the Book No. is numeric
    if (isNaN(muteWillBookNoValue)) {
      muteWillBookNoError.textContent = "Book No. must be a numeric value";
      muteWillBookNoError.style.display = "block";
      return false;
    }

    // Check if the Book No. is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteWillBookNoValue) <= 0) {
      muteWillBookNoError.textContent = "Book No. must be a positive number";
      muteWillBookNoError.style.display = "block";
      return false;
    }

    muteWillBookNoError.style.display = "none";
    return true;
  }

  $(document).on("input blur change", "#regWillDeedFrom", function () {
    validateMuteWillFrom();
  });

  function validateMuteWillFrom() {
    var muteWillFromValue = muteWillFrom.value.trim();
    var muteWillValueTo = muteWillTo.value.trim();

    // Check if the field is empty
    if (muteWillFromValue === "") {
      muteWillFromError.textContent = "Page No From is required";
      muteWillFromError.style.display = "block";
      return false;
    }

    // Check if the value is numeric
    if (isNaN(muteWillFromValue)) {
      muteWillFromError.textContent = "Page No From must be a numeric value";
      muteWillFromError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteWillFromValue) <= 0) {
      muteWillFromError.textContent = "Page No From must be a positive number";
      muteWillFromError.style.display = "block";
      return false;
    }
    // Check if 'Page No. From' is greater than 'Page No. To'
    if (parseInt(muteWillFromValue) > parseInt(muteWillValueTo)) {
      muteWillFromError.textContent = "From cannot be greater than Page No. To";
      muteWillFromError.style.display = "block";
      return false;
    } else {
      muteWillFromError.style.display = "none";
      return true;
    }
  }

  $(document).on("input blur change", "#regWillDeedTo", function () {
    validateMuteWillTo();
  });

  function validateMuteWillTo() {
    var muteWillToValue = muteWillTo.value.trim();
    var muteWillValueFrom = muteWillFrom.value.trim();
    // Check if the field is empty
    if (muteWillToValue === "") {
      muteWillToError.textContent = "Page No To is required";
      muteWillToError.style.display = "block";
      console.log("Mute Sale Deed To Value: ", muteWillToValue); // Check the value
      return false;
    }

    // Check if the value is numeric
    if (isNaN(muteWillToValue)) {
      muteWillToError.textContent = "Page No To must be a numeric value";
      muteWillToError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteWillToValue) <= 0) {
      muteWillToError.textContent = "Page No To must be a positive number";
      muteWillToError.style.display = "block";
      return false;
    }

    // Check if 'Page No. To' is less than 'Page No. From'
    if (parseInt(muteWillToValue) < parseInt(muteWillValueFrom)) {
      muteWillToError.textContent =
        "Page No. To cannot be less than Page No. From";
      muteWillToError.style.display = "block";
      return false;
    } else {
      muteWillToError.style.display = "none";
      return true;
    }
  }

  function validateMuteWillRegDate() {
    var muteWillRegDateValue = muteWillRegDate.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (muteWillRegDateValue === "") {
      muteWillRegDateError.textContent = "Date of Registration is required";
      muteWillRegDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteWillRegDateValue > today) {
      muteWillRegDateError.textContent =
        "Date of Registration cannot be in the future";
      muteWillRegDateError.style.display = "block";
      muteWillRegDate.value = ""; // Clear invalid input
      return false;
    }

    muteWillRegDateError.style.display = "none";
    return true;
  }
  function validateMuteWillRegOfficeName() {
    var muteWillRegOfficeNameValue = muteWillRegOfficeName.value.trim();
    if (muteWillRegOfficeNameValue === "") {
      muteWillRegOfficeNameError.textContent =
        "Registration Office Name is required";
      muteWillRegOfficeNameError.style.display = "block";
      return false;
    }

    // Check if the value contains only alphabetic characters and spaces
    var willNameAlpha = /^[A-Za-z\s]+$/;
    if (!willNameAlpha.test(muteWillRegOfficeNameValue)) {
      muteWillRegOfficeNameError.textContent =
        "Registration Office Name must only contain alphabets";
      muteWillRegOfficeNameError.style.display = "block";
      return false;
    } else {
      muteWillRegOfficeNameError.style.display = "none";
    }
    return true;
  }
  // Regd. Will Deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Unregd. Will Deed Mutaition form step 3 add by anil on 20-02-2025 for validation
  function validateMuteUnregdWillFile() {
    if (muteUnregdWillFile.files.length > 0) {
      var file = muteUnregdWillFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        muteUnregdWillFileError.textContent =
          "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteUnregdWillFileError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        muteUnregdWillFileError.textContent = "";
        return true;
      }
    } else {
      if (muteUnregdWillFile.getAttribute("data-should-validate") == 1) {
        return true;
      }
      muteUnregdWillFileError.textContent =
        "Unregd. Will/Codicil Deed PDF File is required";
      return false;
    }
  }

  function validateMuteUnregdWillTestatorName() {
    var muteUnregdWillTestatorNameValue = muteUnregdWillTestatorName.value.trim();
    if (muteUnregdWillTestatorNameValue === "") {
      muteUnregdWillTestatorNameError.textContent = "Testator Name is required";
      muteUnregdWillTestatorNameError.style.display = "Block";
      return false;
    }

    // Check if the value contains only alphabetic characters and spaces
    var testNameAlpha = /^[A-Za-z\s]+$/;
    if (!testNameAlpha.test(muteUnregdWillTestatorNameValue)) {
      muteUnregdWillTestatorNameError.textContent =
        "Testator Name must only contain alphabets";
      muteUnregdWillTestatorNameError.style.display = "block";
      return false;
    } else {
      muteUnregdWillTestatorNameError.style.display = "none";
    }
    return true;
  }
  function validateMuteUnregdWillDate() {
    var muteUnregdWillDateValue = muteUnregdWillDate.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (muteUnregdWillDateValue === "") {
      muteUnregdWillDateError.textContent = "Date of Registration is required";
      muteUnregdWillDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteUnregdWillDateValue > today) {
      muteUnregdWillDateError.textContent =
        "Date of Registration cannot be in the future";
      muteUnregdWillDateError.style.display = "block";
      muteUnregdWillDate.value = ""; // Clear invalid input
      return false;
    }

    muteUnregdWillDateError.style.display = "none";
    return true;
  }
  // Unregd. Will Deed Mutaition form step 3 add by anil on 20-02-2025 for validation

  // Registered Relinquishment Deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  function validateMuteRelinquishDeedFile() {
    if (muteRelinquishDeedFile.files.length > 0) {
      var file = muteRelinquishDeedFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        muteRelinquishDeedFileError.textContent =
          "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteRelinquishDeedFileError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        muteRelinquishDeedFileError.textContent = "";
        return true;
      }
    } else {
      if (muteRelinquishDeedFile.getAttribute("data-should-validate") == 1) {
        return true;
      }
      muteRelinquishDeedFileError.textContent =
        "Relinquishment Deed PDF file is required";
      return false;
    }
  }

  function validateMuteRelinquishDeedReleaserName() {
    var muteRelinquishDeedReleaserNameValue = muteRelinquishDeedReleaserName.value.trim();
    if (muteRelinquishDeedReleaserNameValue === "") {
      muteRelinquishDeedReleaserNameError.textContent =
        "Releaser Name is required";
      muteRelinquishDeedReleaserNameError.style.display = "Block";
      return false;
    }

    // Check if the value contains only alphabetic characters and spaces
    var releaserNameAlpha = /^[A-Za-z\s]+$/;
    if (!releaserNameAlpha.test(muteRelinquishDeedReleaserNameValue)) {
      muteRelinquishDeedReleaserNameError.textContent =
        "Releaser Name must only contain alphabets";
      muteRelinquishDeedReleaserNameError.style.display = "block";
      return false;
    } else {
      muteRelinquishDeedReleaserNameError.style.display = "none";
    }
    return true;
  }

  function validateMuteRelinquishDeedRegNo() {
    var muteRelinquishDeedRegNoValue = muteRelinquishDeedRegNo.value.trim();
    if (muteRelinquishDeedRegNoValue === "") {
      muteRelinquishDeedRegNoError.textContent =
        "Will/Codicil Registration No. is required";
      muteRelinquishDeedRegNoError.style.display = "block";
      return false;
    } else {
      muteRelinquishDeedRegNoError.style.display = "none";
    }
    return true;
  }

  function validateMuteRelinquishDeedVolume() {
    var muteRelinquishDeedVolumeValue = muteRelinquishDeedVolume.value.trim();

    // Check if the field is empty
    if (muteRelinquishDeedVolumeValue === "") {
      muteRelinquishDeedVolumeError.textContent = "Volume is required";
      muteRelinquishDeedVolumeError.style.display = "block";
      return false;
    }

    // Check if the value is numeric
    if (isNaN(muteRelinquishDeedVolumeValue)) {
      muteRelinquishDeedVolumeError.textContent =
        "Volume must be a numeric value";
      muteRelinquishDeedVolumeError.style.display = "block";
      return false;
    }

    // Check if the value is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteRelinquishDeedVolumeValue) <= 0) {
      muteRelinquishDeedVolumeError.textContent =
        "Volume must be a positive number";
      muteRelinquishDeedVolumeError.style.display = "block";
      return false;
    }

    muteRelinquishDeedVolumeError.style.display = "none";
    return true;
  }

  function validateMuteRelinquishDeedBookno() {
    var muteRelinquishDeedBooknoValue = muteRelinquishDeedBookno.value.trim();

    // Check if the field is empty
    if (muteRelinquishDeedBooknoValue === "") {
      muteRelinquishDeedBooknoError.textContent = "Book No. is required";
      muteRelinquishDeedBooknoError.style.display = "block";
      return false;
    }

    // Check if the Book No. is numeric
    if (isNaN(muteRelinquishDeedBooknoValue)) {
      muteRelinquishDeedBooknoError.textContent =
        "Book No. must be a numeric value";
      muteRelinquishDeedBooknoError.style.display = "block";
      return false;
    }

    // Check if the Book No. is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteRelinquishDeedBooknoValue) <= 0) {
      muteRelinquishDeedBooknoError.textContent =
        "Book No. must be a positive number";
      muteRelinquishDeedBooknoError.style.display = "block";
      return false;
    }

    muteRelinquishDeedBooknoError.style.display = "none";
    return true;
  }

  $(document).on("input blur change", "#relinquishDeedFrom", function () {
    validateMuteRelinquishDeedFrom();
  });

  function validateMuteRelinquishDeedFrom() {
    var muteRelinquishDeedFromValue = muteRelinquishDeedFrom.value.trim();
    var muteRelinquishDeedValueTo = muteRelinquishDeedTo.value.trim();

    // Check if the field is empty
    if (muteRelinquishDeedFromValue === "") {
      muteRelinquishDeedFromError.textContent = "Page No From is required";
      muteRelinquishDeedFromError.style.display = "block";
      return false;
    }

    // Check if the value is numeric
    if (isNaN(muteRelinquishDeedFromValue)) {
      muteRelinquishDeedFromError.textContent =
        "Page No From must be a numeric value";
      muteRelinquishDeedFromError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteRelinquishDeedFromValue) <= 0) {
      muteRelinquishDeedFromError.textContent =
        "Page No From must be a positive number";
      muteRelinquishDeedFromError.style.display = "block";
      return false;
    }
    // Check if 'Page No. From' is greater than 'Page No. To'
    if (
      parseInt(muteRelinquishDeedFromValue) >
      parseInt(muteRelinquishDeedValueTo)
    ) {
      muteRelinquishDeedFromError.textContent =
        "From cannot be greater than Page No. To";
      muteRelinquishDeedFromError.style.display = "block";
      return false;
    } else {
      muteRelinquishDeedFromError.style.display = "none";
      return true;
    }
  }

  $(document).on("input blur change", "#relinquishDeedTo", function () {
    validateMuteRelinquishDeedTo();
  });

  function validateMuteRelinquishDeedTo() {
    var muteRelinquishDeedToValue = muteRelinquishDeedTo.value.trim();
    var muteRelinquishDeedValueFrom = muteRelinquishDeedFrom.value.trim();
    // Check if the field is empty
    if (muteRelinquishDeedToValue === "") {
      muteRelinquishDeedToError.textContent = "Page No To is required";
      muteRelinquishDeedToError.style.display = "block";
      console.log("Mute Sale Deed To Value: ", muteRelinquishDeedToValue); // Check the value
      return false;
    }

    // Check if the value is numeric
    if (isNaN(muteRelinquishDeedToValue)) {
      muteRelinquishDeedToError.textContent =
        "Page No To must be a numeric value";
      muteRelinquishDeedToError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteRelinquishDeedToValue) <= 0) {
      muteRelinquishDeedToError.textContent =
        "Page No To must be a positive number";
      muteRelinquishDeedToError.style.display = "block";
      return false;
    }

    // Check if 'Page No. To' is less than 'Page No. From'
    if (
      parseInt(muteRelinquishDeedToValue) <
      parseInt(muteRelinquishDeedValueFrom)
    ) {
      muteRelinquishDeedToError.textContent =
        "Page No. To cannot be less than Page No. From";
      muteRelinquishDeedToError.style.display = "block";
      return false;
    } else {
      muteRelinquishDeedToError.style.display = "none";
      return true;
    }
  }

  function validateMuteRelinquishDeedRegdate() {
    var muteRelinquishDeedRegdateValue = muteRelinquishDeedRegdate.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (muteRelinquishDeedRegdateValue === "") {
      muteRelinquishDeedRegdateError.textContent =
        "Date of Registration is required";
      muteRelinquishDeedRegdateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteRelinquishDeedRegdateValue > today) {
      muteRelinquishDeedRegdateError.textContent =
        "Date of Registration cannot be in the future";
      muteRelinquishDeedRegdateError.style.display = "block";
      muteRelinquishDeedRegdate.value = ""; // Clear invalid input
      return false;
    }

    muteRelinquishDeedRegdateError.style.display = "none";
    return true;
  }

  function validateMuteRelinquishDeedRegname() {
    var muteRelinquishDeedRegnameValue = muteRelinquishDeedRegname.value.trim();
    if (muteRelinquishDeedRegnameValue === "") {
      muteRelinquishDeedRegnameError.textContent =
        "Registration Office Name is required";
      muteRelinquishDeedRegnameError.style.display = "block";
      return false;
    }

    // Check if the value contains only alphabetic characters and spaces
    var willNameAlpha = /^[A-Za-z\s]+$/;
    if (!willNameAlpha.test(muteRelinquishDeedRegnameValue)) {
      muteRelinquishDeedRegnameError.textContent =
        "Registration Office Name must only contain alphabets";
      muteRelinquishDeedRegnameError.style.display = "block";
      return false;
    } else {
      muteRelinquishDeedRegnameError.style.display = "none";
    }
    return true;
  }
  // Registered Relinquishment Deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Gift Deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  function validateMuteGiftDeedFile() {
    if (muteGiftDeedFile.files.length > 0) {
      var file = muteGiftDeedFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        muteGiftDeedFileError.textContent = "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteGiftDeedFileError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        muteGiftDeedFileError.textContent = "";
        return true;
      }
    } else {
      if (muteGiftDeedFile.getAttribute("data-should-validate") == 1) {
        return true;
      }
      muteGiftDeedFileError.textContent = "Gift Deed PDF file is required";
      return false;
    }
  }

  function validateMuteGiftDeedRegno() {
    var muteGiftDeedRegnoValue = muteGiftDeedRegno.value.trim();
    if (muteGiftDeedRegnoValue === "") {
      muteGiftDeedRegnoError.textContent =
        "Gift Deed Registration No. is required";
      muteGiftDeedRegnoError.style.display = "block";
      return false;
    } else {
      muteGiftDeedRegnoError.style.display = "none";
    }
    return true;
  }

  function validateMuteGiftDeedVolume() {
    var muteGiftDeedVolumeValue = muteGiftDeedVolume.value.trim();

    // Check if the field is empty
    if (muteGiftDeedVolumeValue === "") {
      muteGiftDeedVolumeError.textContent = "Volume is required";
      muteGiftDeedVolumeError.style.display = "block";
      return false;
    }

    // Check if the value is numeric
    if (isNaN(muteGiftDeedVolumeValue)) {
      muteGiftDeedVolumeError.textContent = "Volume must be a numeric value";
      muteGiftDeedVolumeError.style.display = "block";
      return false;
    }

    // Check if the value is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteGiftDeedVolumeValue) <= 0) {
      muteGiftDeedVolumeError.textContent = "Volume must be a positive number";
      muteGiftDeedVolumeError.style.display = "block";
      return false;
    }

    muteGiftDeedVolumeError.style.display = "none";
    return true;
  }

  function validateMuteGiftDeedBookno() {
    var muteGiftDeedBooknoValue = muteGiftDeedBookno.value.trim();

    // Check if the field is empty
    if (muteGiftDeedBooknoValue === "") {
      muteGiftDeedBooknoError.textContent = "Book No. is required";
      muteGiftDeedBooknoError.style.display = "block";
      return false;
    }

    // Check if the Book No. is numeric
    if (isNaN(muteGiftDeedBooknoValue)) {
      muteGiftDeedBooknoError.textContent = "Book No. must be a numeric value";
      muteGiftDeedBooknoError.style.display = "block";
      return false;
    }

    // Check if the Book No. is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteGiftDeedBooknoValue) <= 0) {
      muteGiftDeedBooknoError.textContent =
        "Book No. must be a positive number";
      muteGiftDeedBooknoError.style.display = "block";
      return false;
    }

    muteGiftDeedBooknoError.style.display = "none";
    return true;
  }

  $(document).on("input blur change", "#giftdeedFrom", function () {
    validateMuteGiftDeedFrom();
  });

  function validateMuteGiftDeedFrom() {
    var muteGiftDeedFromValue = muteGiftDeedFrom.value.trim();
    var muteGiftDeedValueTo = muteGiftDeedTo.value.trim();

    // Check if the field is empty
    if (muteGiftDeedFromValue === "") {
      muteGiftDeedFromError.textContent = "Page No From is required";
      muteGiftDeedFromError.style.display = "block";
      return false;
    }

    // Check if the value is numeric
    if (isNaN(muteGiftDeedFromValue)) {
      muteGiftDeedFromError.textContent =
        "Page No From must be a numeric value";
      muteGiftDeedFromError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteGiftDeedFromValue) <= 0) {
      muteGiftDeedFromError.textContent =
        "Page No From must be a positive number";
      muteGiftDeedFromError.style.display = "block";
      return false;
    }
    // Check if 'Page No. From' is greater than 'Page No. To'
    if (parseInt(muteGiftDeedFromValue) > parseInt(muteGiftDeedValueTo)) {
      muteGiftDeedFromError.textContent =
        "From cannot be greater than Page No. To";
      muteGiftDeedFromError.style.display = "block";
      return false;
    } else {
      muteGiftDeedFromError.style.display = "none";
      return true;
    }
  }

  $(document).on("input blur change", "#giftdeedTo", function () {
    validateMuteGiftDeedTo();
  });

  function validateMuteGiftDeedTo() {
    var muteGiftDeedToValue = muteGiftDeedTo.value.trim();
    var muteGiftDeedValueFrom = muteGiftDeedFrom.value.trim();
    // Check if the field is empty
    if (muteGiftDeedToValue === "") {
      muteGiftDeedToError.textContent = "Page No To is required";
      muteGiftDeedToError.style.display = "block";
      console.log("Mute Sale Deed To Value: ", muteGiftDeedToValue); // Check the value
      return false;
    }

    // Check if the value is numeric
    if (isNaN(muteGiftDeedToValue)) {
      muteGiftDeedToError.textContent = "Page No To must be a numeric value";
      muteGiftDeedToError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteGiftDeedToValue) <= 0) {
      muteGiftDeedToError.textContent = "Page No To must be a positive number";
      muteGiftDeedToError.style.display = "block";
      return false;
    }

    // Check if 'Page No. To' is less than 'Page No. From'
    if (parseInt(muteGiftDeedToValue) < parseInt(muteGiftDeedValueFrom)) {
      muteGiftDeedToError.textContent =
        "Page No. To cannot be less than Page No. From";
      muteGiftDeedToError.style.display = "block";
      return false;
    } else {
      muteGiftDeedToError.style.display = "none";
      return true;
    }
  }

  function validateMuteGiftDeedRegdate() {
    var muteGiftDeedRegdateValue = muteGiftDeedRegdate.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (muteGiftDeedRegdateValue === "") {
      muteGiftDeedRegdateError.textContent = "Date of Registration is required";
      muteGiftDeedRegdateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteGiftDeedRegdateValue > today) {
      muteGiftDeedRegdateError.textContent =
        "Date of Registration cannot be in the future";
      muteGiftDeedRegdateError.style.display = "block";
      muteGiftDeedRegdate.value = ""; // Clear invalid input
      return false;
    }

    muteGiftDeedRegdateError.style.display = "none";
    return true;
  }

  function validateMuteGiftDeedRegOfficeName() {
    var muteGiftDeedRegOfficeNameValue = muteGiftDeedRegOfficeName.value.trim();
    if (muteGiftDeedRegOfficeNameValue === "") {
      muteGiftDeedRegOfficeNameError.textContent =
        "Registration Office Name is required";
      muteGiftDeedRegOfficeNameError.style.display = "block";
      return false;
    }

    // Check if the value contains only alphabetic characters and spaces
    var giftNameAlpha = /^[A-Za-z\s]+$/;
    if (!giftNameAlpha.test(muteGiftDeedRegOfficeNameValue)) {
      muteGiftDeedRegOfficeNameError.textContent =
        "Registration Office Name must only contain alphabets";
      muteGiftDeedRegOfficeNameError.style.display = "block";
      return false;
    } else {
      muteGiftDeedRegOfficeNameError.style.display = "none";
    }
    return true;
  }
  // Gift Deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Surviving Member Certificate Mutaition form step 3 add by anil on 18-02-2025 for validation
  function validateMuteSmcFile() {
    if (muteSmcFile.files.length > 0) {
      var file = muteSmcFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        muteSmcFileError.textContent = "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteSmcFileError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        muteSmcFileError.textContent = "";
        return true;
      }
    } else {
      if (muteSmcFile.getAttribute("data-should-validate") == 1) {
        return true;
      }
      muteSmcFileError.textContent = "SMC PDF file is required";
      return false;
    }
  }

  function validateMuteSmcCertificateNo() {
    var muteSmcCertificateNoValue = muteSmcCertificateNo.value.trim();
    if (muteSmcCertificateNoValue === "") {
      muteSmcCertificateNoError.textContent = "SMC Certificate No. is required";
      muteSmcCertificateNoError.style.display = "block";
      return false;
    } else {
      muteSmcCertificateNoError.style.display = "none";
    }
    return true;
  }

  function validateMuteSmcDateOfIssue() {
    var muteSmcDateOfIssueValue = muteSmcDateOfIssue.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (muteSmcDateOfIssueValue === "") {
      muteSmcDateOfIssueError.textContent = "Date of Issue is required";
      muteSmcDateOfIssueError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteSmcDateOfIssueValue > today) {
      muteSmcDateOfIssueError.textContent =
        "Date of Issue cannot be in the future";
      muteSmcDateOfIssueError.style.display = "block";
      muteSmcDateOfIssue.value = ""; // Clear invalid input
      return false;
    }

    muteSmcDateOfIssueError.style.display = "none";
    return true;
  }
  // Surviving Member Certificate Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation
  function validateMuteSbpFile() {
    if (muteSbpFile.files.length > 0) {
      var file = muteSbpFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        muteSbpFileError.textContent = "File size must be less than 5 MB";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteSbpFileError.textContent = "Only PDF files are allowed";
        return false;
      } else {
        muteSbpFileError.textContent = "";
        return true;
      }
    } else {
      if (muteSbpFile.getAttribute("data-should-validate") == 1) {
        return true;
      }
      muteSbpFileError.textContent = "SBP PDF file is required";
      return false;
    }
  }

  function validateMuteSbpDateOfIssue() {
    var muteSbpDateOfIssueValue = muteSbpDateOfIssue.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (muteSbpDateOfIssueValue === "") {
      muteSbpDateOfIssueError.textContent = "Date of Issue is required";
      muteSbpDateOfIssueError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteSbpDateOfIssueValue > today) {
      muteSbpDateOfIssueError.textContent =
        "Date of Issue cannot be in the future";
      muteSbpDateOfIssueError.style.display = "block";
      muteSbpDateOfIssue.value = ""; // Clear invalid input
      return false;
    }

    muteSbpDateOfIssueError.style.display = "none";
    return true;
  }
  // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Any Other Document Mutaition form step 3 add by anil on 20-02-2025 for validation
  function validateMuteAod() {
    var fileInputAod = muteAodFile.files.length > 0; // Check if a file is selected
    var textInputAod = muteAodRemark.value.trim() !== ""; // Check if text input is filled

    // Check file size if a file is uploaded
    if (fileInputAod) {
      var file = muteAodFile.files[0]; // Get the uploaded file
      var maxSize = 5 * 1024 * 1024; // 5 MB in bytes

      if (file.size > maxSize) {
        // muteAodFile.classList.add("is-invalid");
        muteAodFileError.textContent = "File size must be less than 5 MB";
        muteAodFileError.style.display = "block";
        return false;
      } else {
        // muteAodFile.classList.remove("is-invalid");
        muteAodFileError.style.display = "none";
      }
    }

    // Case 1: File is uploaded, but no remark
    if (fileInputAod && !textInputAod) {
      // muteAodRemark.classList.add("is-invalid");
      muteAodRemarkError.textContent =
        "Please enter a remark if you upload a document";
      muteAodRemarkError.style.display = "block";
      return false;
    } else {
      // muteAodRemark.classList.remove("is-invalid");
      muteAodRemarkError.style.display = "none";
    }

    // Case 2: Remark is filled, but no file
    if (!fileInputAod && textInputAod) {
      // muteAodFile.classList.add("is-invalid");
      muteAodFileError.textContent =
        "Please upload a document if you enter a remark";
      muteAodFileError.style.display = "block";
      return false;
    } else {
      // muteAodFile.classList.remove("is-invalid");
      muteAodFileError.style.display = "none";
    }

    // Case 3: Either both are empty or both are filled — valid
    return true;
  }
  // Any Other Document Mutaition form step 3 add by anil on 20-02-2025 for validation

  // Function to validate the Terms & Conditions checkbox
  function validateAgreeConsentMut() {
    if (!MutAgreeConsent.checked) {
      MutAgreeconsentError.textContent = "Please accept Terms & Conditions";
      MutAgreeconsentError.style.display = "block";
      return false;
    } else {
      MutAgreeconsentError.style.display = "none";
      return true;
    }
  }

  // added by anil on 17-02-2025 for Apply max date restriction to prevent future dates in selected docuemnts for all date inputs
  document.addEventListener("DOMContentLoaded", function () {
    var today = new Date().toISOString().split("T")[0];

    // Set max date for Date of Death and Certificate Issue Date input
    muteDethDate.setAttribute("max", today);
    muteDethCertificateIssueDate.setAttribute("max", today);
    muteSaleDeedRegDate.setAttribute("max", today);
    muteWillRegDate.setAttribute("max", today);
    muteUnregdWillDate.setAttribute("max", today);
    muteRelinquishDeedRegdate.setAttribute("max", today);
    muteGiftDeedRegdate.setAttribute("max", today);
    muteSmcDateOfIssue.setAttribute("max", today);
    muteSbpDateOfIssue.setAttribute("max", today);

    // Validate on blur and change to prevent manual future date entry

    // Death Certificate Mutaition form step 3  add by anil on 17-02-2025 for validation
    muteDethDate.addEventListener("blur", validateMuteDethDate);
    muteDethDate.addEventListener("change", validateMuteDethDate);
    muteDethCertificateIssueDate.addEventListener(
      "blur",
      validateMuteDethCertificateIssueDate
    );
    muteDethCertificateIssueDate.addEventListener(
      "change",
      validateMuteDethCertificateIssueDate
    );
    // Death Certificate Mutaition form step 3  add by anil on 17-02-2025 for validation

    // Sale Deed Mutaition form step 3 add by anil on 17-02-2025 for validation
    muteSaleDeedRegDate.addEventListener("blur", validateMuteSaleDeedRegDate);
    muteSaleDeedRegDate.addEventListener("change", validateMuteSaleDeedRegDate);
    // Sale Deed Mutaition form step 3 add by anil on 17-02-2025 for validation

    // Regd. Will Deed Mutaition form step 3 add by anil on 18-02-2025 for validation
    muteWillRegDate.addEventListener("blur", validateMuteWillRegDate);
    muteWillRegDate.addEventListener("change", validateMuteWillRegDate);
    // Regd. Will Deed Mutaition form step 3 add by anil on 18-02-2025 for validation

    // Unregd. Will Deed Mutaition form step 3 add by anil on 20-02-2025 for validation
    muteUnregdWillDate.addEventListener("blur", validateMuteUnregdWillDate);
    muteUnregdWillDate.addEventListener("change", validateMuteUnregdWillDate);
    // Unregd. Will Deed Mutaition form step 3 add by anil on 20-02-2025 for validation

    // Registered Relinquishment Deed Mutaition form step 3 add by anil on 18-02-2025 for validation
    muteRelinquishDeedRegdate.addEventListener(
      "blur",
      validateMuteRelinquishDeedRegdate
    );
    muteRelinquishDeedRegdate.addEventListener(
      "change",
      validateMuteRelinquishDeedRegdate
    );
    // Registered Relinquishment Deed Mutaition form step 3 add by anil on 18-02-2025 for validation

    // Gift Deed Mutaition form step 3 add by anil on 18-02-2025 for validation
    muteGiftDeedRegdate.addEventListener("blur", validateMuteGiftDeedRegdate);
    muteGiftDeedRegdate.addEventListener("change", validateMuteGiftDeedRegdate);
    // Gift Deed Mutaition form step 3 add by anil on 18-02-2025 for validation

    // Surviving Member Certificate Mutaition form step 3 add by anil on 18-02-2025 for validation
    muteSmcDateOfIssue.addEventListener("blur", validateMuteSmcDateOfIssue);
    muteSmcDateOfIssue.addEventListener("change", validateMuteSmcDateOfIssue);
    // Surviving Member Certificate Mutaition form step 3 add by anil on 18-02-2025 for validation

    // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation
    muteSbpDateOfIssue.addEventListener("blur", validateMuteSbpDateOfIssue);
    muteSbpDateOfIssue.addEventListener("change", validateMuteSbpDateOfIssue);
    // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation
  });

  function validateForm3MUT() {
    var isAgreeConsentMutValid = validateAgreeConsentMut();
    return isAgreeConsentMutValid && isDethCertificateMuteValid;
  }


  // function validateForm3MUT() { commented by anil on 18-02-2025 for because of this fucntion already working on upside
  //   var isAgreeConsentMutValid = validateAgreeConsentMut();
  //   var isDethCertificateMuteValid = validateMuteDethCertificate();
  //   return isAgreeConsentMutValid &&
  //   isDethCertificateMuteValid
  // }

  form1.addEventListener("button", function (event) {
    event.preventDefault();
    if (validateForm1LUC() || validateForm1MUT()) {
      alert("Form submitted successfully");
    }
  });

  form2.addEventListener("button", function (event) {
    event.preventDefault();
    if (validateForm2LUC()) {
      alert("Form submitted successfully");
    }
  });

  form3.addEventListener("button", function (event) {
    event.preventDefault();
    if (validateForm3()) {
      alert("Form submitted successfully");
    }
  });


  var submitButton1 = document.getElementsByClassName("submitbtn1");
  // var $submitButtonOne = $(submitButton1);
  submitButton1.forEach((btn) => {
    btn.addEventListener("click", function () {
      // btn.textContent = "Submitting...";
      // btn.disabled = true;
      var propertyid = $("#propertyid").val();
      var propertyStatus = $("input[name='applicationStatus']").val();
      var applicationType = $("select[name='applicationType']").val();


      if (applicationType === "SUB_MUT" && validateForm1MUT()) {
        // Validate coapplicant form
        var isCoapplicantValid = coapplicantMutRepeaterForm();
        if (!isCoapplicantValid) {
          showError("Please fill out the co-applicant form correctly.");
          return;
        }
        // for submitting the first step of application  - Sourav Chauhan (17/sep/2024)
        btn.textContent = "Submitting...";
        btn.disabled = true;
        var propertyid = $("#propertyid").val();
        var propertyStatus = $("input[name='applicationStatus']").val();
        var applicationType = $("select[name='applicationType']").val();
        //for mutation - Sourav Chauhan (17/sep/2024)
        if (applicationType == "SUB_MUT") {
          mutation(propertyid, propertyStatus, function (success, result) {
            if (result.status) {
              btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              showSuccess(result.message);
              steppers["stepper3"].next();
            } else {
              btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              showError(result.message);
            }
          });
        }
      } else if (applicationType === "LUC" && validateForm1LUC() ) {
        if (propertyStatus == "Lease Hold" && applicationType == "LUC") {
          landUseChange(function (success, message) {
            if (success) {
              btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              steppers["stepper5"].next();
              showSuccess(message);
            } else {
              btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              showError(message);
            }
          });
        }
      } else if (applicationType === "DOA" && validateForm1DOA()) {
        if (propertyStatus == "Lease Hold" && applicationType == "DOA") {
          deedOfApartment(
            propertyid,
            propertyStatus,
            function (success, result) {
              if (result.status) {
                btn.innerHTML =
                  'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
                btn.disabled = false;
                showSuccess(result.message);
                steppers["stepper6"].next();
              } else {
                btn.innerHTML =
                  'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
                ('Next <i class="bx bx-right-arrow-alt ms-2"></i>');
                btn.disabled = false;
                showError(result.message);
              }
            }
          );
        }
      }

      if (propertyStatus == "Lease Hold" && applicationType == "CONVERSION") {
        btn.textContent = "Submitting...";
        btn.disabled = true;
        conversionStep1(propertyid, propertyStatus, function (success, result) {
          if (success) {
            btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
            btn.disabled = false;
            showSuccess(result.message);
            steppers["stepper4"].next();
          } else {
            btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
            btn.disabled = false;
            showError(result.message);
          }
        });
      }

           
      // if (propertyStatus == "Lease Hold" && applicationType == "CONVERSION") {
      //   // Validate coapplicant form
      //   var isCoapplicantConversionValid = coapplicantConRepeaterForm();
      //   if (!isCoapplicantConversionValid) {
      //     showError("Please fill out the co-applicant form correctly.");
      //     return;
      //   }
      //   btn.textContent = "Submitting...";
      //   btn.disabled = true;
      //   conversionStep1(propertyid, propertyStatus, function (success, result) {
      //     if (success) {
      //       btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
      //       btn.disabled = false;
      //       showSuccess(result.message);
      //       steppers["stepper4"].next();
      //     } else {
      //       btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
      //       btn.disabled = false;
      //       showError(result.message);
      //     }
      //   });
      // }
    });
  });

  function deedOfApartment(propertyid, propertyStatus, callback) {
    // var localityDropDown = document.getElementsByName("locality")[0];
    // var blockDropDown = document.getElementsByName("block")[0];
    // var plotDropDown = document.getElementsByName("plot")[0];
    // var knownAsDropDown = document.getElementsByName("knownas")[0];
    var flatDropDown = document.getElementsByName("flatid")[0];

    var updateId = $("input[name='updateId']").val();
    var statusofapplicant = $("#statusofapplicant").val();
    var applicantName = $("input[name='applicantName']").val();
    var applicantAddress = $("input[name='applicantAddress']").val();
    var buildingName = $("input[name='buildingName']").val();
    // var locality = localityDropDown.value;
    // var block = blockDropDown.value;
    // var plot = plotDropDown.value;
    // var knownas = knownAsDropDown.value;
    var flatId = flatDropDown.value;
    // var isFlatNotListed = $("input[name='isFlatNotInList']:checked").val();
    // var flatNumber = $("input[name='flatNumber']").val();
    var builderName = $("input[name='builderName']").val();
    var originalBuyerName = $("input[name='originalBuyerName']").val();
    var presentOccupantName = $("input[name='presentOccupantName']").val();
    var purchasedFrom = $("input[name='purchasedFrom']").val();
    var purchaseDate = $("input[name='purchaseDate']").val();
    var apartmentArea = $("input[name='apartmentArea']").val();
    var plotArea = $("input[name='plotArea']").val();
    var oldPropertyId = $("input[name='old_property_id']").val();
    var propertyMasterId = $("input[name='property_master_id']").val();
    var newPropertyId = $("input[name='new_property_id']").val();
    var splittedPropertyId = $(
      "input[name='splited_property_detail_id']"
    ).val();

    var baseUrl = getBaseURL();
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
      url: baseUrl + "/doa-step-first",
      type: "POST",
      dataType: "JSON",
      data: {
        _token: csrfToken,
        updateId: updateId,
        propertyid: propertyid,
        oldPropertyId: oldPropertyId,
        propertyMasterId: propertyMasterId,
        newPropertyId: newPropertyId,
        splittedPropertyId: splittedPropertyId,
        propertyStatus: propertyStatus,
        statusofapplicant: statusofapplicant,
        applicantName: applicantName,
        applicantAddress: applicantAddress,
        buildingName: buildingName,
        // locality: locality,
        // block: block,
        // plot: plot,
        // knownas: knownas,
        flatId: flatId,
        // isFlatNotListed: isFlatNotListed,
        // flatNumber: flatNumber,
        builderName: builderName,
        originalBuyerName: originalBuyerName,
        presentOccupantName: presentOccupantName,
        purchasedFrom: purchasedFrom,
        purchaseDate: purchaseDate,
        apartmentArea: apartmentArea,
        plotArea: plotArea,
      },
      success: function (result) {
        if (result.status) {
          $("#submitbtn1").html(
            'Next <i class="bx bx-right-arrow-alt ms-2"></i>'
          );
          $("#submitbtn1").prop("disabled", false);
          $("input[name='updateId']").val(result.data.id);
          $("input[name='lastPropertyId']").val(result.data.old_property_id);
          if (callback) callback(true, result); // Call the callback with success
        } else {
          // Handle failure scenario
          $("#submitbtn1").html(
            'Next <i class="bx bx-right-arrow-alt ms-2"></i>'
          );
          $("#submitbtn1").prop("disabled", false);
          if (callback) callback(false, result); // Call the callback with failure
        }
      },
      error: function (xhr, status, error) {
        // Handle error scenario
        $("#submitbtn1").html(
          'Next <i class="bx bx-right-arrow-alt ms-2"></i>'
        );
        $("#submitbtn1").prop("disabled", false);
        // if (callback) callback(false, { xhr, status, error }); // Call the callback with error
        if (err.responseJSON && err.responseJSON.message) {
          if (callback) callback(false, err.responseJSON.message);
        } else {
          if (callback) callback(false, "Unknown error!!");
        }
      },
    });
  }

  // for storing first step of mutation- Sourav Chauhan (17/sep/2024)
  function mutation(propertyid, propertyStatus, callback) {
    var updateId = $("input[name='updateId']").val();
    var statusofapplicant = $("#statusofapplicant").val();
    var mutNameApp = $("input[name='mutNameApp']").val();
    var mutGenderApp = $("input[name='mutGenderApp']").val();
    var mutAgeApp = $("input[name='mutAgeApp']").val();
    // var mutFathernameApp = $("input[name='mutFathernameApp']").val();
    var mutExecutedOnAsConLease = $(
      "input[name='mutExecutedOnAsConLease']"
    ).val();
    var mutAadharApp = $("input[name='mutAadharApp']").val();
    var mutPanApp = $("input[name='mutPanApp']").val();
    var mutMobilenumberApp = $("input[name='mutMobilenumberApp']").val();

    var mutNameAsConLease = $("input[name='mutNameAsConLease']").val();
    var mutFathernameAsConLease = $("input[name='mutFathernameAsConLease']").val();
    var mutRegnoAsConLease = $("input[name='mutRegnoAsConLease']").val();
    var mutBooknoAsConLease = $("input[name='mutBooknoAsConLease']").val();
    var mutVolumenoAsConLease = $("input[name='mutVolumenoAsConLease']").val();
    var mutPagenoFrom = $("input[name='mutPagenoFrom']").val();
    var mutPagenoTo = $("input[name='mutPagenoTo']").val();
    var mutRegdateAsConLease = $("input[name='mutRegdateAsConLease']").val();
    // var soughtByApplicant = $("#soughtByApplicant").val();
    const soughtByApplicantDocuments = [];
    const checkboxes = document.querySelectorAll(".documentType:checked");
    checkboxes.forEach(function (checkbox) {
      soughtByApplicantDocuments.push(checkbox.value);
    });
    var mutPropertyMortgaged = $("input[name='mutPropertyMortgaged']:checked").val();
    var mutMortgagedRemarks = $("textarea[name='mutMortgagedRemarks']").val();
    var mutCourtorder = $("input[name='courtorderMutation']:checked").val();
    var mutCaseNo = $("input[name='mutCaseNo']").val();
    var mutCaseDetail = $("textarea[name='mutCaseDetail']").val();

    var formData = new FormData();
    formData.append("_token", $('meta[name="csrf-token"]').attr("content")); // CSRF token
    formData.append("updateId", updateId);
    formData.append("propertyid", propertyid);
    formData.append("propertyStatus", propertyStatus);
    formData.append("statusofapplicant", statusofapplicant);
    formData.append("mutNameApp", mutNameApp);
    formData.append("mutGenderApp", mutGenderApp);
    formData.append("mutAgeApp", mutAgeApp);
    formData.append("mutExecutedOnAsConLease", mutExecutedOnAsConLease);
    formData.append("mutAadharApp", mutAadharApp);
    formData.append("mutPanApp", mutPanApp);
    formData.append("mutMobilenumberApp", mutMobilenumberApp);
    formData.append("mutNameAsConLease", mutNameAsConLease);
    formData.append("mutFathernameAsConLease", mutFathernameAsConLease);
    formData.append("mutRegnoAsConLease", mutRegnoAsConLease);
    formData.append("mutBooknoAsConLease", mutBooknoAsConLease);
    formData.append("mutVolumenoAsConLease", mutVolumenoAsConLease);
    formData.append("mutPagenoFrom", mutPagenoFrom);
    formData.append("mutPagenoTo", mutPagenoTo);
    formData.append("mutRegdateAsConLease", mutRegdateAsConLease);
    // formData.append('soughtByApplicant', soughtByApplicant);
    formData.append("soughtByApplicantDocuments", soughtByApplicantDocuments);
    formData.append("mutPropertyMortgaged", mutPropertyMortgaged);
    formData.append("mutMortgagedRemarks", mutMortgagedRemarks);
    formData.append("mutCourtorder", mutCourtorder);
    formData.append("mutCaseNo", mutCaseNo);
    formData.append("mutCaseDetail", mutCaseDetail);

    // Iterate over all input elements with names starting with 'coapplicant'
    $("input[name^='coapplicant'], select[name^='coapplicant']").each(
      function () {
        var nameAttr = $(this).attr("name");
        var value;
        if ($(this).attr("type") === "file") {
          if ($(this)[0].files.length > 0) {
            value = $(this)[0].files[0]; // Get the file object
            formData.append(nameAttr, value); // Append the file to FormData
          }
        } else {
          value = $(this).val(); // Get the string value for other inputs
          formData.append(nameAttr, value); // Append to FormData
        }
      }
    );

    var baseUrl = getBaseURL();
    // var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
      url: baseUrl + "/mutation-step-first",
      type: "POST",
      dataType: "JSON",
      data: formData,
      processData: false,
      contentType: false,
      // data: {
      //   _token: csrfToken,
      //   updateId: updateId,
      //   propertyid: propertyid,
      //   propertyStatus: propertyStatus,
      //   statusofapplicant: statusofapplicant,
      //   mutNameApp: mutNameApp,
      //   mutGenderApp: mutGenderApp,
      //   mutAgeApp: mutAgeApp,
      //   mutExecutedOnAsConLease: mutExecutedOnAsConLease,
      //   // mutFathernameApp: mutFathernameApp,
      //   mutAadharApp: mutAadharApp,
      //   mutPanApp: mutPanApp,
      //   mutMobilenumberApp: mutMobilenumberApp,
      //   coapplicants: coapplicants,
      //   mutNameAsConLease: mutNameAsConLease,
      //   // mutFathernameAsConLease: mutFathernameAsConLease,
      //   mutRegnoAsConLease: mutRegnoAsConLease,
      //   mutBooknoAsConLease: mutBooknoAsConLease,
      //   mutVolumenoAsConLease: mutVolumenoAsConLease,
      //   mutPagenoAsConLease: mutPagenoAsConLease,
      //   mutRegdateAsConLease: mutRegdateAsConLease,
      //   soughtByApplicantDocuments: soughtByApplicantDocuments,
      //   mutPropertyMortgaged: mutPropertyMortgaged,
      //   mutMortgagedRemarks: mutMortgagedRemarks,
      //   mutCourtorder: mutCourtorder,
      // },
      success: function (result) {
        // console.log(result.data.ids);
        // return false;
        if (result.status) {

          // Populate co-applicant IDs
          if (result.data.ids && result.data.ids.length > 0) {
            result.data.ids.forEach((id, index) => {
              let coApplicantInput = $(`input[name='coapplicant[${index}][undefined]']`);
              if (coApplicantInput.length > 0) {
                coApplicantInput.val(id); // Update the value with the response ID
                coApplicantInput.attr("id", `coapplicant_${index}_id`); // Update ID dynamically
              }
            });
          }
          $("#submitbtn1").html(
            'Next <i class="bx bx-right-arrow-alt ms-2"></i>'
          );
          $("#submitbtn1").prop("disabled", false);
          $("input[name='updateId']").val(result.data.tempSubstitutionMutation.id);
          $("input[name='lastPropertyId']").val(result.data.tempSubstitutionMutation.old_property_id);
          if (callback) callback(true, result); // Call the callback with success
        } else {
          // Handle failure scenario
          $("#submitbtn1").html(
            'Next <i class="bx bx-right-arrow-alt ms-2"></i>'
          );
          $("#submitbtn1").prop("disabled", false);
          // $("input[name='updateId']").val(result.data.id);
          // $("input[name='lastPropertyId']").val(result.data.old_property_id);
          if (callback) callback(false, result); // Call the callback with failure
        }
      },
      error: function (err) {
        $("#submitbtn1").html(
          'Next <i class="bx bx-right-arrow-alt ms-2"></i>'
        );
        $("#submitbtn1").prop("disabled", false);
        if (err.responseJSON && err.responseJSON.message) {
          if (callback) callback(false, err.responseJSON.message);
        } else {
          if (callback) callback(false, "Unknown error!!");
        }
      },
    });
  }

  $(document).on(
    "blur change",
    "#repeater input, #repeater select",
    function () {
      coapplicantMutRepeaterForm();
    }
  );

  function coapplicantMutRepeaterForm() {
    var isCoapplicantMutValid = true;

    $("#repeater .coapplicant-block").each(function (index, element) {
      var coName = $(element)
        .find("#coapplicant_" + index + "_name")
        .val();
      var coGender = $(element)
        .find("#coapplicant_" + index + "_gender")
        .val();
      var coDob = $(element)
        .find("#coapplicant_" + index + "_dateofbirth")
        .val();
      var ageField = $(element).find("#coapplicant_" + index + "_age");
      var coRelation = $(element)
        .find("#coapplicant_" + index + "_secondnameinv")
        .val();
      var coAdhaarNumber = $(element)
        .find("#coapplicant_" + index + "_aadharnumber")
        .val();
      var coAdhaarFile = $(element).find(
        "#coapplicant_" + index + "_aadhaarfile"
      )[0].files[0];
      var coPanNumber = $(element)
        .find("#coapplicant_" + index + "_pannumber")
        .val();
      var coPanFile = $(element).find("#coapplicant_" + index + "_panfile")[0]
        .files[0];
      var coMobileNumber = $(element)
        .find("#coapplicant_" + index + "_mobilenumber")
        .val();
      var coPhotoFile = $(element).find("#coapplicant_" + index + "_photo")[0]
        .files[0]; // Get the actual file

      // Remove previous error messages
      $(this)
        .find(".error-message")
        .text("");

      // Future Date Validation for DOB
      if (coDob) {
        var dob = new Date(coDob);
        var today = new Date();
        today.setHours(0, 0, 0, 0);

        if (dob > today) {
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "Date of birth cannot be in the future.",
            "#coapplicant_" + index + "_dateofbirth"
          );
          $(element)
            .find("#coapplicant_" + index + "_dateofbirth")
            .val(""); // Clear invalid input
        } else {
          var age = coCalculateAge(dob);
          ageField.val(age);
        }
      }

      // Check if any field is filled
      var isAnyFieldFilled =
        coName ||
        coGender ||
        coDob ||
        coRelation ||
        coAdhaarNumber ||
        coAdhaarFile ||
        coPanNumber ||
        coPanFile ||
        coMobileNumber ||
        coPhotoFile;

      if (isAnyFieldFilled) {
        // Make all fields mandatory if at least one field is filled
        if (!coName) {
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "Name is required.",
            "#coapplicant_" + index + "_name"
          );
        }
        if (!coGender) {
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "Please select your gender.",
            "#coapplicant_" + index + "_gender"
          );
        }
        if (!coDob) {
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "Please select your date of birth.",
            "#coapplicant_" + index + "_dateofbirth"
          );
        }
        if (!coRelation) {
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "Please enter your relation.",
            "#coapplicant_" + index + "_secondnameinv"
          );
        }
        // Validate Aadhaar number (example: 12-digit number)
        if (!coAdhaarNumber) {
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "Aadhaar number is required.",
            "#coapplicant_" + index + "_aadharnumber"
          );
        } else if (!/^\d{12}$/.test(coAdhaarNumber)) {
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "Aadhaar number must be 12 digits.",
            "#coapplicant_" + index + "_aadharnumber"
          );
        }
        // Check if file exists and its size for Aadhaar file
        if (!coAdhaarFile) {
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "Please upload Aadhaar PDF.",
            "#coapplicant_" + index + "_aadhaarfile"
          );
        } else if (coAdhaarFile && coAdhaarFile.size > 5 * 1024 * 1024) {
          // 5MB limit for Aadhaar file
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "Aadhaar file size must be less than 5MB.",
            "#coapplicant_" + index + "_aadhaarfile"
          );
        }
        // Validate PAN number (example: format ABCDE1234F)
        if (!coPanNumber) {
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "PAN number is required.",
            "#coapplicant_" + index + "_pannumber"
          );
        }
        // Check if file exists and its size for PAN file
        if (!coPanFile) {
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "Please upload PAN Card PDF",
            "#coapplicant_" + index + "_panfile"
          );
        } else if (coPanFile && coPanFile.size > 5 * 1024 * 1024) {
          // 5MB limit for PAN file
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "PAN file size must be less than 5MB.",
            "#coapplicant_" + index + "_panfile"
          );
        }
        // Validate mobile number (example: 10-digit number)
        if (!coMobileNumber) {
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "Mobile number is required",
            "#coapplicant_" + index + "_mobilenumber"
          );
        } else if (!/^\d{10}$/.test(coMobileNumber)) {
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "Mobile number must be 10 digits.",
            "#coapplicant_" + index + "_mobilenumber"
          );
        }
        // Validate photo file size (e.g., max 1MB)
        if (!coPhotoFile) {
          isCoapplicantMutValid = false;
          showErrorMessage(
            this,
            "Please upload Co-Applicant Passport Size Photo",
            "#coapplicant_" + index + "_photo"
          );
          var fileInput = $(this).find("#coapplicant_" + index + "_photo")[0];

          // Check if file is selected
          if (fileInput && fileInput.files && fileInput.files.length > 0) {
            var fileSize = fileInput.files[0].size;

            // Check if file size exceeds 100KB
            if (fileSize > 102400) {
              isCoapplicantMutValid = false;
              showErrorMessage(
                this,
                "Passport photo size must be less than 100KB.",
                "#coapplicant_" + index + "_photo"
              );
            }
          }
        } else {
          var fileInput = $(this).find("#coapplicant_" + index + "_photo")[0];

          if (fileInput && fileInput.files && fileInput.files.length > 0) {
            var fileSize = fileInput.files[0].size;

            // Check if file size is larger than 100KB
            if (fileSize > 102400) {
              isCoapplicantMutValid = false;
              showErrorMessage(
                this,
                "Passport photo size must be less than 100KB.",
                "#coapplicant_" + index + "_photo"
              );
            }
          }
        }
      }
    });
    return isCoapplicantMutValid;
  }

  function coCalculateAge(dob) {
    const today = new Date();
    let age = today.getFullYear() - dob.getFullYear();
    const month = today.getMonth();
    const day = today.getDate();

    if (
      month < dob.getMonth() ||
      (month === dob.getMonth() && day < dob.getDate())
    ) {
      age--;
    }

    return age;
  }

  function showErrorMessage(form, message, selector) {
    var inputField = $(form).find(selector);
    var errorMessageSpan = inputField.next(".error-message");
    errorMessageSpan.text(message).show();
  }

  // Function to validate mandatory mutation documents
  function mandatoryMutDocumentsForm() {
    var isMandatoryMutDocumentsForm = true;

    // Clear previous error messages before starting new validation
    $(".text-danger").text(""); // Clear the text inside all error message spans

    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    // Loop through all .items inside #affidavits_repeater
    $("#affidavits_repeater .items").each(function (index, element) {
      var mutAttestedBy = $(element)
        .find("#affidavits_" + index + "_affidavitattestedby")
        .val();
      var muteAffidavitsFile = $(element).find(
        "#affidavits_" + index + "_affidavits"
      )[0]?.files[0]; // File input
      var muteAttestationDate = $(element)
        .find("#affidavits_" + index + "_affidavitsdateofattestation")
        .val();

      var isMutAttesteValid = true; // Track validity for this specific form

      // Validate "attested by" field
      if (!mutAttestedBy) {
        isMutAttesteValid = false;
        $(element)
          .find("#affidavits_" + index + "_affidavitattestedby")
          .siblings(".text-danger")
          .text("Attested By is required");
      } else if (!/^[A-Za-z\s]+$/.test(mutAttestedBy)) {
        // Check if it contains only alphabets and spaces
        isMutAttesteValid = false;
        $(element)
          .find("#affidavits_" + index + "_affidavitattestedby")
          .siblings(".text-danger")
          .text(
            "Attested By can only contain alphabetic characters and spaces"
          );
      }

      // Validate file input
      if (!muteAffidavitsFile) {
        isMutAttesteValid = false;
        $(element)
          .find("#affidavits_" + index + "_affidavits")
          .siblings(".text-danger")
          .text("Affidavit file is required");
      } else {
        // Validate file size (5MB limit)
        if (muteAffidavitsFile.size > 5 * 1024 * 1024) {
          isMutAttesteValid = false;
          $(element)
            .find("#affidavits_" + index + "_affidavits")
            .siblings(".text-danger")
            .text("File size must be less than 5MB");
        }
      }

      // Validate attestation date (No future dates)
      if (!muteAttestationDate) {
        isMutAttesteValid = false;
        $(element)
          .find("#affidavits_" + index + "_affidavitsdateofattestation")
          .siblings(".text-danger")
          .text("Date of attestation is required");
      } else if (muteAttestationDate > today) {
        isMutAttesteValid = false;
        $(element)
          .find("#affidavits_" + index + "_affidavitsdateofattestation")
          .siblings(".text-danger")
          .text("Attestation date cannot be in the future");
        $(element)
          .find("#affidavits_" + index + "_affidavitsdateofattestation")
          .val(""); // Clear invalid input
      }

      if (!isMutAttesteValid) {
        isMandatoryMutDocumentsForm = false;
      }
    });

    // Loop through all .items inside #indemnityBond_repeater
    $("#indemnityBond_repeater .items").each(function (index, element) {
      var mutIndeBond = $(element).find(
        "#indemnitybond_" + index + "_indemnitybond"
      )[0]?.files[0]; // File input
      var mutIndeAttestationDate = $(element)
        .find("#indemnitybond_" + index + "_indemnitybonddateofattestation")
        .val();
      var muteIndeAttestedBy = $(element)
        .find("#indemnitybond_" + index + "_indemnitybondattestedby")
        .val();

      var isMutIndeValid = true;

      // Validate "Indemnity Bond" input field
      if (!mutIndeBond) {
        isMutIndeValid = false;
        $(element)
          .find("#indemnitybond_" + index + "_indemnitybond")
          .siblings(".text-danger")
          .text("Indemnity bond file required");
      } else {
        // Validate file size (5MB limit)
        if (mutIndeBond.size > 5 * 1024 * 1024) {
          isMutIndeValid = false;
          $(element)
            .find("#indemnitybond_" + index + "_indemnitybond")
            .siblings(".text-danger")
            .text("File size must be less than 5MB");
        }
      }

      // Validate attestation date (No future dates)
      if (!mutIndeAttestationDate) {
        isMutIndeValid = false;
        $(element)
          .find("#indemnitybond_" + index + "_indemnitybonddateofattestation")
          .siblings(".text-danger")
          .text("Date of attestation is required");
      } else if (mutIndeAttestationDate > today) {
        isMutIndeValid = false;
        $(element)
          .find("#indemnitybond_" + index + "_indemnitybonddateofattestation")
          .siblings(".text-danger")
          .text("Attestation date cannot be in the future");
        $(element)
          .find("#indemnitybond_" + index + "_indemnitybonddateofattestation")
          .val(""); // Clear invalid input
      }

      // Validate "Attested By" field
      if (!muteIndeAttestedBy) {
        isMutIndeValid = false;
        $(element)
          .find("#indemnitybond_" + index + "_indemnitybondattestedby")
          .siblings(".text-danger")
          .text("Attested By is required");
      } else if (!/^[A-Za-z\s]+$/.test(muteIndeAttestedBy)) {
        // Check if it contains only alphabets and spaces
        isMutIndeValid = false;
        $(element)
          .find("#indemnitybond_" + index + "_indemnitybondattestedby")
          .siblings(".text-danger")
          .text(
            "Attested By can only contain alphabetic characters and spaces"
          );
      }

      if (!isMutIndeValid) {
        isMandatoryMutDocumentsForm = false;
      }
    });

    return isMandatoryMutDocumentsForm;
  }

  // Apply max date restriction to prevent future dates in attestation date fields
  $(document).ready(function () {
    var today = new Date().toISOString().split("T")[0];

    // Set max date for affidavit attestation date inputs
    $("#affidavits_repeater").on(
      "input change",
      ".affidavitsdateofattestation",
      function () {
        if ($(this).val() > today) {
          $(this).val(""); // Clear future date
          $(this)
            .siblings(".text-danger")
            .text("Attestation date cannot be in the future");
        } else {
          $(this)
            .siblings(".text-danger")
            .text("");
        }
      }
    );

    // Set max date for indemnity bond attestation date inputs
    $("#indemnityBond_repeater").on(
      "input change",
      ".indemnitybonddateofattestation",
      function () {
        if ($(this).val() > today) {
          $(this).val(""); // Clear future date
          $(this)
            .siblings(".text-danger")
            .text("Attestation date cannot be in the future");
        } else {
          $(this)
            .siblings(".text-danger")
            .text("");
        }
      }
    );

    // Ensure the max date is set for newly added fields dynamically
    $("#affidavits_repeater, #indemnityBond_repeater").on(
      "DOMNodeInserted",
      function () {
        $(".affidavitsdateofattestation, .indemnitybonddateofattestation").attr(
          "max",
          today
        );
      }
    );

    // Apply max date on document load for existing fields
    $(".affidavitsdateofattestation, .indemnitybonddateofattestation").attr(
      "max",
      today
    );
  });


  //for step second***********************************
  var submitButton2 = document.getElementsByClassName("submitbtn2");
  submitButton2.forEach((btn) => {
    btn.addEventListener("click", function () {
      var propertyStatus = $("input[name='applicationStatus']").val();
      var applicationType = $("select[name='applicationType']").val();

      var isMandatoryMutDocValid = mandatoryMutDocumentsForm();
      if (!isMandatoryMutDocValid) {
        // If the coapplicant form is invalid, show an error and stop
        showError("Please fill out the Mandatory Documents form correctly.");
        return;  // Stop further execution
      }


      if (validateForm2MUT()) {
        btn.textContent = "Submitting...";
        btn.disabled = true;

        if (applicationType == "SUB_MUT") {
          mutationStepSecond(function (success, result) {
            if (result.status) {
              // console.log(result.data);
              // var resDocumentType = result.data;
              // $.each(resDocumentType, function(key, values) {
              //   $.each(values, function(index, value) {
              //       console.log("Key: " + key + ", Value: " + value);
              //       $(`[data-group="${key}"]`).each(function(i, element) {
              //         console.log(i,element);
              //         var hiddenInput = $(element).find(`input[data-name="indexValue"]`);
              //         if (hiddenInput.length > 0 && !hiddenInput.val()) {
              //           hiddenInput.val(value);
              //       }
              //       })
              //   })
              // })

              var resDocumentType = result.data; // Ensure result.data is an object

              // Check if resDocumentType is not empty
              if (resDocumentType) {
                $.each(resDocumentType, function (key, values) {
                  $.each(values, function (index, value) {
                    console.log("Key: " + key + ", Value: " + value);

                    // Select elements with data-group that matches the current key (e.g., 'affidavits', 'indemnityBond')
                    $(`[data-group="${key}"]`).each(function (i, element) {
                      // console.log(i, element);

                      // Find the hidden input field inside the element with data-name="indexValue"
                      var closestInput = $(element).find(`input[type="file"]`);
                      var hiddenInput = closestInput
                        .parent()
                        .find(`input[type="hidden"]`);
                      if (!hiddenInput.val()) {
                        hiddenInput.val(value);
                      }
                    });
                  });
                });
              } else {
                console.log("result.data is not available.");
              }

              btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              showSuccess(result.message);
              steppers["stepper3"].next();
            } else {
              btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              showError(result.message);
            }
          });
        }
      } else if (propertyStatus == "Lease Hold" && applicationType == "LUC") {
        //not used after lastest design update
        /* landUseChangeStep2(function (success, message) {
          if (success) {
            $("#submitbtn2").html(
              'Submitted <i class="bx bx-right-arrow-alt ms-2"></i>'
            );
            $("#submitbtn2").prop("disabled", false);
            stepper3.next();
          } else {
            $("#submitbtn2").html(
              'Failed <i class="bx bx-right-arrow-alt ms-2"></i>'
            );
            $("#submitbtn2").prop("disabled", false);
            showError(message); 
          }
        });*/
      } else if (
        propertyStatus == "Lease Hold" &&
        applicationType == "CONVERSION"
      ) {
        btn.textContent = "Submitting...";
        btn.disabled = true;
        conversionStep2(function (success, message) {
          if (success) {
            btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
            btn.disabled = false;
            steppers["stepper4"].next();
          } else {
            btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
            btn.disabled = false;
            showError(message);
          }
        });
      }
    });
  });

  // for storing second step of mutation- Sourav Chauhan (19/sep/2024)
  function mutationStepSecond(callback) {
    var updateId = $("input[name='updateId']").val();

    // var affidavitsDateAttestation = $("input[name='affidavits_mutation']").val();
    // var affidavitsAttestedby = $("input[name='affidavitsAttestedby']").val();
    // var indemnityBondDateAttestation = $("input[name='indemnityBondDateAttestation']").val();
    // var indemnityBondattestedby = $("input[name='indemnityBondattestedby']").val();

    // var leaseConvDeedDateOfExecution = $(
    //   "input[name='leaseConvDeedDateOfExecution']"
    // ).val();
    // var leaseConvDeedLesseename = $(
    //   "input[name='leaseConvDeedLesseename']"
    // ).val();
    // var panCertificateNo = $("input[name='panCertificateNo']").val();
    // var panDateIssue = $("input[name='panDateIssue']").val();
    // var aadharCertificateNo = $("input[name='aadharCertificateNo']").val();
    // var aadharDateIssue = $("input[name='aadharDateIssue']").val();
    var newspaperNameEnglish = $("input[name='newspaperNameEnglish']").val();
    var publicNoticeDateEnglish = $(
      "input[name='publicNoticeDateEnglish']"
    ).val();
    var newspaperNameHindi = $("input[name='newspaperNameHindi']").val();
    var publicNoticeDateHindi = $("input[name='publicNoticeDateHindi']").val();

    var formData = new FormData();
    formData.append("_token", $('meta[name="csrf-token"]').attr("content")); // CSRF token
    formData.append("updateId", updateId);
    // formData.append('affidavitsDateAttestation', affidavitsDateAttestation);
    // formData.append('affidavitsAttestedby', affidavitsAttestedby);
    // formData.append('indemnityBondDateAttestation', indemnityBondDateAttestation);
    // formData.append('indemnityBondattestedby', indemnityBondattestedby);
    // formData.append(
    //   "leaseConvDeedDateOfExecution",
    //   leaseConvDeedDateOfExecution
    // );
    // formData.append("leaseConvDeedLesseename", leaseConvDeedLesseename);
    // formData.append('panCertificateNo', panCertificateNo);
    // formData.append('aadharCertificateNo', aadharCertificateNo);
    formData.append("newspaperNameEnglish", newspaperNameEnglish);
    formData.append("publicNoticeDateEnglish", publicNoticeDateEnglish);
    formData.append("newspaperNameHindi", newspaperNameHindi);
    formData.append("publicNoticeDateHindi", publicNoticeDateHindi);

    $("input[name^='affidavits']").each(function (item, value) {
      // console.log(item,value);

      var nameAttr = $(this).attr("name");
      var value;
      if ($(this).attr("type") === "file") {
        if ($(this)[0].files.length > 0) {
          value = $(this)[0].files[0]; // Get the file object
          formData.append(nameAttr, value); // Append the file to FormData
        }
      } else {
        value = $(this).val(); // Get the string value for other inputs
        formData.append(nameAttr, value); // Append to FormData
      }
    });

    $("input[name^='indemnityBond']").each(function () {
      var nameAttr = $(this).attr("name");
      var value;
      if ($(this).attr("type") === "file") {
        if ($(this)[0].files.length > 0) {
          value = $(this)[0].files[0]; // Get the file object
          formData.append(nameAttr, value); // Append the file to FormData
        }
      } else {
        value = $(this).val(); // Get the string value for other inputs
        formData.append(nameAttr, value); // Append to FormData
      }
    });

    var baseUrl = getBaseURL();
    // var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
      url: baseUrl + "/mutation-step-second",
      type: "POST",
      dataType: "JSON",
      data: formData,
      processData: false,
      contentType: false,
      // data: {
      //   _token: csrfToken,
      //   updateId: updateId,
      //   affidavitsDateAttestation: affidavitsDateAttestation,
      //   affidavitsAttestedby: affidavitsAttestedby,
      //   indemnityBondDateAttestation: indemnityBondDateAttestation,
      //   indemnityBondattestedby: indemnityBondattestedby,
      //   leaseConvDeedDateOfExecution: leaseConvDeedDateOfExecution,
      //   leaseConvDeedLesseename: leaseConvDeedLesseename,
      //   panCertificateNo: panCertificateNo,
      //   panDateIssue: panDateIssue,
      //   aadharCertificateNo: aadharCertificateNo,
      //   aadharDateIssue: aadharDateIssue,
      //   newspaperName: newspaperName,
      //   publicNoticeDate: publicNoticeDate,
      // },
      success: function (result) {
        if (result.status) {
          $("#submitbtn2").html(
            'Next <i class="bx bx-right-arrow-alt ms-2"></i>'
          );
          $("#submitbtn2").prop("disabled", false);
          if (callback) callback(true, result); // Call the callback with success
        } else {
          // Handle failure scenario
          $("#submitbtn2").html(
            'Next <i class="bx bx-right-arrow-alt ms-2"></i>'
          );
          $("#submitbtn2").prop("disabled", false);
          if (callback) callback(false, result); // Call the callback with failure
        }
      },
      error: function (err) {
        $("#submitbtn1").html(
          'Next <i class="bx bx-right-arrow-alt ms-2"></i>'
        );
        $("#submitbtn1").prop("disabled", false);
        if (err.responseJSON && err.responseJSON.message) {
          if (callback) callback(false, err.responseJSON.message);
        } else {
          if (callback) callback(false, "Unknown error!!");
        }
      },
    });
  }

  //step three forms validation

  function validateForm3MUT() {
    console.log("Running validateForm3MUT()..."); // Debugging log
    var isMutValidateForm3Valid = true; // Start assuming the form is valid

    // Select only visible divs inside #stepThreeDiv
    $("#stepThreeDiv > div:visible").each(function () {
      var divId = $(this).attr("id");

      switch (divId) {
        case "deathCertificate_check":
          isMutValidateForm3Valid =
            validateMuteDethCertificate() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteDethDeceaseName() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteDethDate() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteDethCertificateIssueDate() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteDethCertificateNumber() && isMutValidateForm3Valid;
          break;

        case "saleDeed_check":
          isMutValidateForm3Valid =
            validateMuteSaleDeed() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteSaleDeedRegno() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteSaleDeedVolume() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteSaleDeedBookNo() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteSaleDeedFrom() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteSaleDeedTo() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteSaleDeedRegDate() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteSaleDeedRegOfficeName() && isMutValidateForm3Valid;
          break;

        case "regdWillDeed_check":
          isMutValidateForm3Valid =
            validateMuteWillRegdFile() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteWillTestatorName() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteWillRegno() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteWillVolume() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteWillBookNo() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteWillFrom() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteWillTo() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteWillRegDate() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteWillRegOfficeName() && isMutValidateForm3Valid;
          break;
        case "unregdWillCodocil_check":
          isMutValidateForm3Valid =
            validateMuteUnregdWillFile() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteUnregdWillTestatorName() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteUnregdWillDate() && isMutValidateForm3Valid;
          break;

        case "relinquishmentDeed_check":
          isMutValidateForm3Valid =
            validateMuteRelinquishDeedFile() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteRelinquishDeedReleaserName() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteRelinquishDeedRegNo() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteRelinquishDeedVolume() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteRelinquishDeedBookno() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteRelinquishDeedFrom() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteRelinquishDeedTo() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteRelinquishDeedRegdate() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteRelinquishDeedRegname() && isMutValidateForm3Valid;
          console.log(
            validateMuteRelinquishDeedFile(),
            validateMuteRelinquishDeedReleaserName(),
            validateMuteRelinquishDeedRegNo(),
            validateMuteRelinquishDeedVolume(),
            validateMuteRelinquishDeedBookno(),
            validateMuteRelinquishDeedFrom(),
            validateMuteRelinquishDeedTo(),
            validateMuteRelinquishDeedRegdate(),
            validateMuteRelinquishDeedRegname()
          );
          break;

        case "giftDeed_check":
          isMutValidateForm3Valid =
            validateMuteGiftDeedFile() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteGiftDeedRegno() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteGiftDeedVolume() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteGiftDeedBookno() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteGiftDeedFrom() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteGiftDeedTo() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteGiftDeedRegdate() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteGiftDeedRegOfficeName() && isMutValidateForm3Valid;
          break;

        case "survivingMemberCertificate_check":
          isMutValidateForm3Valid =
            validateMuteSmcFile() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteSmcCertificateNo() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteSmcDateOfIssue() && isMutValidateForm3Valid;
          break;

        case "sanctionBuildingPlan_check":
          isMutValidateForm3Valid =
            validateMuteSbpFile() && isMutValidateForm3Valid;
          isMutValidateForm3Valid =
            validateMuteSbpDateOfIssue() && isMutValidateForm3Valid;
          break;
      }
    });

    // Validate Additional Document fields
    isMutValidateForm3Valid &= validateMuteAod();

    // Validate Terms & Conditions
    let isAgreeConsentMutValid = validateAgreeConsentMut(); // Check if Terms & Conditions is accepted

    if (!isAgreeConsentMutValid) {
      isMutValidateForm3Valid = false; // If the consent is not checked, mark the form as invalid
    }
    console.log("Validation result:", isMutValidateForm3Valid); // Debugging log

    return isMutValidateForm3Valid;
  }

  var btnfinalsubmit = document.getElementsByClassName("btnfinalsubmit");
  btnfinalsubmit.forEach((btn) => {
    btn.addEventListener("click", function () {
      var propertyStatus = $("input[name='applicationStatus']").val();
      var applicationType = $("select[name='applicationType']").val();
      if (validateForm3MUT()) {
        btn.textContent = "Submitting...";
        btn.disabled = true;

        if (applicationType == "SUB_MUT") {
          mutationStepThird(function (success, result) {
            if (result.status) {
              btn.innerHTML =
                'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              showSuccess(
                result.message,
                getBaseURL() + "/applications/history/details"
              );
            } else {
              btn.innerHTML =
                'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              showError(result.message);
            }
          });
        }
      }

      if (validateForm2LUC() && applicationType === "LUC") {
        //   btn.textContent = "Submitting...";
        // btn.disabled = true;

        // var propertyStatus = $("input[name='applicationStatus']").val();
        // var applicationType = $("select[name='applicationType']").val();

        if (propertyStatus == "Lease Hold" && applicationType == "LUC") {
          landUseChangeStep2(function (success, result) {
            if (success) {
              btn.innerHTML =
                'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              showSuccess(
                result,
                getBaseURL() + "/applications/history/details"
              );
            } else {
              btn.innerHTML =
                'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              showError(result);
            }
          });
        }
      }

      if (validateForm2DOA() && applicationType == "DOA") {
        if (propertyStatus == "Lease Hold" && applicationType == "DOA") {
          deedOfApartmentStepFinal(function (success, result) {
            if (result.status) {
              btn.innerHTML =
                'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              showSuccess(
                result.message,
                getBaseURL() + "/applications/history/details"
              );
            } else {
              btn.innerHTML =
                'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              showError(result.message);
            }
          });
        }
      }
      if (applicationType == "CONVERSION") {
        btn.textContent = "Submitting...";
        btn.disabled = true;
        conversionStep3(function (success, result) {
          if (success) {
            btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
            btn.disabled = false;
            showSuccess(result, getBaseURL() + "/applications/history/details");
          } else {
            btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
            btn.disabled = false;
            showError(result);
          }
        });
      }
    });
  });
});

// for storing second step of mutation- Sourav Chauhan (19/sep/2024)
function mutationStepThird(callback) {
  var updateId = $("input[name='updateId']").val();
  var deathCertificateDeceasedName = $(
    "input[name='deathCertificateDeceasedName']"
  ).val();
  var deathCertificateDeathdate = $(
    "input[name='deathCertificateDeathdate']"
  ).val();
  var deathCertificateIssuedate = $(
    "input[name='deathCertificateIssuedate']"
  ).val();
  var deathCertificateDocumentCertificate = $(
    "input[name='deathCertificateDocumentCertificate']"
  ).val();
  var SaleDeedRegno = $("input[name='SaleDeedRegno']").val();
  var SaleDeedVolume = $("input[name='SaleDeedVolume']").val();
  var saleDeedBookNo = $("input[name='saleDeedBookNo']").val();
  var saleDeedPageNo = $("input[name='saleDeedPageNo']").val();
  var saleDeedFrom = $("input[name='saleDeedFrom']").val();
  var saleDeedTo = $("input[name='saleDeedTo']").val();
  var saleDeedRegDate = $("input[name='saleDeedRegDate']").val();
  var saleDeedRegOfficeName = $("input[name='saleDeedRegOfficeName']").val();
  var regWillDeedTestatorName = $(
    "input[name='regWillDeedTestatorName']"
  ).val();
  var regWillDeedRegNo = $("input[name='regWillDeedRegNo']").val();
  var regWillDeedVolume = $("input[name='regWillDeedVolume']").val();
  var regWillDeedBookNo = $("input[name='regWillDeedBookNo']").val();
  var regWillDeedPageNo = $("input[name='regWillDeedPageNo']").val();
  var regWillDeedFrom = $("input[name='regWillDeedFrom']").val();
  var regWillDeedTo = $("input[name='regWillDeedTo']").val();
  var regWillDeedRegDate = $("input[name='regWillDeedRegDate']").val();
  var regWillDeedRegOfficeName = $(
    "input[name='regWillDeedRegOfficeName']"
  ).val();
  var unregWillCodicilTestatorName = $(
    "input[name='unregWillCodicilTestatorName']"
  ).val();
  var unregWillCodicilDateOfWillCodicil = $(
    "input[name='unregWillCodicilDateOfWillCodicil']"
  ).val();
  var relinquishDeedRegNo = $("input[name='relinquishDeedRegNo']").val();
  var relinquishDeedVolume = $("input[name='relinquishDeedVolume']").val();
  var relinquishDeedBookno = $("input[name='relinquishDeedBookno']").val();
  var relinquishDeedPageno = $("input[name='relinquishDeedPageno']").val();
  var relinquishDeedFrom = $("input[name='relinquishDeedFrom']").val();
  var relinquishDeedTo = $("input[name='relinquishDeedTo']").val();
  var relinquishDeedRegdate = $("input[name='relinquishDeedRegdate']").val();
  var relinquishDeedRegname = $("input[name='relinquishDeedRegname']").val();
  var giftdeedRegno = $("input[name='giftdeedRegno']").val();
  var giftdeedVolume = $("input[name='giftdeedVolume']").val();
  var giftdeedBookno = $("input[name='giftdeedBookno']").val();
  var giftdeedPageno = $("input[name='giftdeedPageno']").val();
  var giftdeedFrom = $("input[name='giftdeedFrom']").val();
  var giftdeedTo = $("input[name='giftdeedTo']").val();
  var giftdeedRegdate = $("input[name='giftdeedRegdate']").val();
  var giftdeedRegOfficeName = $("input[name='giftdeedRegOfficeName']").val();
  var smcCertificateNo = $("input[name='smcCertificateNo']").val();
  var smcDateOfIssue = $("input[name='smcDateOfIssue']").val();
  var sbpDateOfIssue = $("input[name='sbpDateOfIssue']").val();
  var otherDocumentRemark = $("textarea[name='otherDocumentRemark']").val();
  var agreeConsent = $("#agreeconsent").is(":checked") ? 1 : 0;
  console.log(agreeConsent);

  var baseUrl = getBaseURL();
  var csrfToken = $('meta[name="csrf-token"]').attr("content");
  $.ajax({
    url: baseUrl + "/mutation-step-third",
    type: "POST",
    dataType: "JSON",
    data: {
      _token: csrfToken,
      updateId: updateId,
      deathCertificateDeceasedName: deathCertificateDeceasedName,
      deathCertificateDeathdate: deathCertificateDeathdate,
      deathCertificateIssuedate: deathCertificateIssuedate,
      deathCertificateDocumentCertificate: deathCertificateDocumentCertificate,
      SaleDeedRegno: SaleDeedRegno,
      SaleDeedVolume: SaleDeedVolume,
      saleDeedBookNo: saleDeedBookNo,
      saleDeedPageNo: saleDeedPageNo,
      saleDeedFrom: saleDeedFrom,
      saleDeedTo: saleDeedTo,
      saleDeedRegDate: saleDeedRegDate,
      saleDeedRegOfficeName: saleDeedRegOfficeName,
      regWillDeedTestatorName: regWillDeedTestatorName,
      regWillDeedRegNo: regWillDeedRegNo,
      regWillDeedVolume: regWillDeedVolume,
      regWillDeedBookNo: regWillDeedBookNo,
      regWillDeedPageNo: regWillDeedPageNo,
      regWillDeedFrom: regWillDeedFrom,
      regWillDeedTo: regWillDeedTo,
      regWillDeedRegDate: regWillDeedRegDate,
      regWillDeedRegOfficeName: regWillDeedRegOfficeName,
      unregWillCodicilTestatorName: unregWillCodicilTestatorName,
      unregWillCodicilDateOfWillCodicil: unregWillCodicilDateOfWillCodicil,
      relinquishDeedRegNo: relinquishDeedRegNo,
      relinquishDeedVolume: relinquishDeedVolume,
      relinquishDeedBookno: relinquishDeedBookno,
      relinquishDeedPageno: relinquishDeedPageno,
      relinquishDeedFrom: relinquishDeedFrom,
      relinquishDeedTo: relinquishDeedTo,
      relinquishDeedRegdate: relinquishDeedRegdate,
      relinquishDeedRegname: relinquishDeedRegname,
      giftdeedRegno: giftdeedRegno,
      giftdeedVolume: giftdeedVolume,
      giftdeedBookno: giftdeedBookno,
      giftdeedPageno: giftdeedPageno,
      giftdeedFrom: giftdeedFrom,
      giftdeedTo: giftdeedTo,
      giftdeedRegdate: giftdeedRegdate,
      giftdeedRegOfficeName: giftdeedRegOfficeName,
      smcCertificateNo: smcCertificateNo,
      smcDateOfIssue: smcDateOfIssue,
      sbpDateOfIssue: sbpDateOfIssue,
      otherDocumentRemark: otherDocumentRemark,
      agreeConsent: agreeConsent,
    },
    success: function (result) {
      if (result.status) {
        $("#btnfinalsubmit").html(
          'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>'
        );
        $("#btnfinalsubmit").prop("disabled", false);
        if (callback) callback(true, result); // Call the callback with success
      } else {
        // Handle failure scenario
        $("#btnfinalsubmit").html(
          'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>'
        );
        $("#btnfinalsubmit").prop("disabled", false);
        if (callback) callback(false, result); // Call the callback with failure
      }
    },
    error: function (err) {
      $("#submitbtn1").html(
        'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>'
      );
      $("#submitbtn1").prop("disabled", false);
      if (err.responseJSON && err.responseJSON.message) {
        if (callback) callback(false, err.responseJSON.message);
      } else {
        if (callback) callback(false, "Unknown error!!");
      }
    },
  });
}



/**Land use change Added by Nitin */
let propertyTypes; // to capture allowed property types for land use
function getLandUseChangeData(propertyId, updateId, callback) {
  var baseUrl = getBaseURL();

  var csrfToken = $('meta[name="csrf-token"]').attr("content");
  $.ajax({
    url: baseUrl + "/application/fetch-luc-details",
    type: "POST",
    dataType: "JSON",
    data: {
      _token: csrfToken,
      propertyId: propertyId,
      updateId: updateId,
    },
    success: function (response) {
      if (response.status && response.status == "error") {
        if (callback) callback(false, response.details);
      } else {
        if (response.colony_id) {
          $("#luclocality").append(
            `<option value=${response.colony_id}>${response.colony_name}</option>`
          );
        }
        $("#lucblockno").val(response.block_no ?? "");
        $("#lucplotno").val(response.plot_no ?? "");
        $("#lucknownas").val(response.known_as ?? "");
        $("#lucarea").val(response.area ?? "");
        $("#leasetype").val(response.lease_type ?? "");
        let allowdChnage = response.allowdChnage;
        let firstRow = allowdChnage[0];
        $("#lucpropertytype").append(
          `<option value="${firstRow.property_type_from}"> ${firstRow.fromTypeName}</option>`
        );
        $("#lucpropertysubtype").append(
          `<option value="${firstRow.property_sub_type_from}"> ${firstRow.fromSubtypeName}</option>`
        );
        let keys = Object.keys(allowdChnage);
        propertyTypes = [];
        $("#lucpropertytypeto").html('<option value="">Select</option>');
        let propertyTypeMap = new Map();

        $.each(allowdChnage, function (index, row) {
          if (!propertyTypeMap.has(row.property_type_to)) {
            propertyTypeMap.set(row.property_type_to, {
              id: row.property_type_to,
              name: row.toTypeName,
              subtypes: [
                {
                  id: row.property_sub_type_to,
                  name: row.toSubtypeName,
                  rate: row.rate,
                },
              ],
            });
            var appendOption = `<option value="${row.property_type_to}" ${isEditing == 1 &&
              application.property_type_change_to == row.property_type_to
              ? "selected"
              : ""
              }>${row.toTypeName}</option>`;
            $("#lucpropertytypeto").append(appendOption);
          } else {
            let propertyType = propertyTypeMap.get(row.property_type_to);
            propertyType.subtypes.push({
              id: row.property_sub_type_to,
              name: row.toSubtypeName,
              rate: row.rate,
            });
          }
        });
        propertyTypes = Array.from(propertyTypeMap.values());

        if (isEditing) {
          $("#lucpropertytypeto").change();
          $("#lucpropertysubtypeto").change();
        }
        if (callback) {
          callback(true, "");
        }
      }
    },
    error: (err) => {
      if (err.responseJSON && err.responseJSON.message) {
        if (callback) callback(false, err.responseJSON.message);
      } else {
        if (callback) callback(false, "Unknown error!!");
      }
    },
  });
}

$("#lucpropertytypeto").change(function () {
  let propertyTypeTo = $(this).val();
  if (propertyTypeTo != "") {
    $("#lucpropertysubtypeto").html('<option value="">Select</option>');
    let selectedPropertyType = propertyTypes.find(
      (type) => type.id == propertyTypeTo
    );
    if (selectedPropertyType) {
      let subtypes = selectedPropertyType.subtypes;
      $.each(subtypes, (i, val) => {
        $("#lucpropertysubtypeto").append(
          `<option value="${val.id}" data-rate="${val.rate}" ${isEditing == true &&
            application.property_subtype_change_to == val.id
            ? "selected"
            : ""
          }>${val.name}</option>`
        );
      });
    }
  }
});

function landUseChange(callback) {
  var baseUrl = getBaseURL();
  var csrfToken = $('meta[name="csrf-token"]').attr("content");
  var id = $("input[name='updateId']").val();
  var oldPropertyId = $("#propertyid").val();
  var propertyTypeFrom = $("#lucpropertytype").val();
  var propertySubtypeFrom = $("#lucpropertysubtype").val();
  var propertyTypeTo = $("#lucpropertytypeto").val();
  var propertySubtypeTo = $("#lucpropertysubtypeto").val();
  var statusofapplicant = $("#statusofapplicant").val();
  $.ajax({
    type: "POST",
    url: `${baseUrl}/application/luc-step-1`,
    data: {
      _token: csrfToken,
      id: id,
      oldPropertyId: oldPropertyId,
      propertyTypeFrom: propertyTypeFrom,
      propertySubtypeFrom: propertySubtypeFrom,
      propertyTypeTo: propertyTypeTo,
      propertySubtypeTo: propertySubtypeTo,
      applicantStatus: statusofapplicant,
    },
    success: function (response) {
      if (response.status == "success") {
        $("input[name='updateId']").val(response.id);
        if (callback) callback(true, response.message); // Call the callback with success
      } else {
        if (callback) callback(false, response.details);
      }
    },
    error: function (response) {
      if (callback) callback(false, response.responseJSON.error);
    },
  });
}

function landUseChangeStep2(callback) {
  var id = $("input[name='updateId']").val();
  var baseUrl = getBaseURL();
  var csrfToken = $('meta[name="csrf-token"]').attr("content");
  var consent = $("#lucagreeconsent").is(":checked");
  $.ajax({
    type: "POST",
    url: baseUrl + "/application/luc-step-2",
    data: { id: id, _token: csrfToken, consent: consent ? 1 : 0 },
    success: function (response) {
      console.log(response);
      // return false;
      if (response.url) {
        window.location.href = response.url;
      } else {
        if (response.status == "success") {
          if (callback) callback(true, response.message);
        } else {
          if (response.missing) {
            let errorArr = [];
            response.missing.forEach((element, index) => {
              $("#" + element.id + "Error").html("This document is required");
              errorArr.push(`${element.label} is required`);
            });
            if (callback) callback(false, errorArr);
          }
          if (response.message) {
            if (callback) callback(false, response.message);
          }
        }
      }
    },
    error: function (err) {
      if (err.responseJSON && err.responseJSON.message) {
        if (callback) callback(false, err.responseJSON.message);
      } else {
      }
    },
  });
}

function deedOfApartmentStepFinal(callback) {
  var updateId = $("input[name='updateId']").val();
  var baseUrl = getBaseURL();
  var csrfToken = $('meta[name="csrf-token"]').attr("content");
  var agreeConsent = $("#agreeDOAConsent").is(":checked") ? 1 : 0;
  $.ajax({
    type: "POST",
    url: baseUrl + "/doa-step-final",
    dataType: "JSON",
    data: { updateId: updateId, _token: csrfToken, agreeConsent: agreeConsent },
    success: function (result) {
      if (result.status) {
        if (result.url) {
          window.location.href = result.url;
        }
        $("#btnfinalsubmit").html(
          'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>'
        );
        $("#btnfinalsubmit").prop("disabled", false);
        if (callback) callback(true, result); // Call the callback with success
      } else {
        // Handle failure scenario
        $("#btnfinalsubmit").html(
          'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>'
        );
        $("#btnfinalsubmit").prop("disabled", false);
        if (callback) callback(false, result); // Call the callback with failure
      }
    },
    error: function (err) {
      $("#submitbtn1").html(
        'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>'
      );
      $("#submitbtn1").prop("disabled", false);
      if (err.responseJSON && err.responseJSON.message) {
        if (callback) callback(false, err.responseJSON.message);
      } else {
        if (callback) callback(false, "Unknown error!!");
      }
    },
  });
}

//not required after design update - 04-10-2024
/* function landUseChangeStep3(callback) {
  var id = $("input[name='updateId']").val();
  var baseUrl = getBaseURL();
  var csrfToken = $('meta[name="csrf-token"]').attr("content");
  var consent = $("#lucagreeconsent").is(":checked");
  $.ajax({
    type: "POST",
    url: baseUrl + "/application/luc-step-3",
    data: { id: id, _token: csrfToken, consent: consent ? 1 : 0 },
    success: function (response) {
      if (response.status == "success") {
        if (callback) callback(true);
      } else {
        if (callback) callback(false, response.message);
      }
    },
    error: function (err) {
      console.log(err);
      if (err.responseJSON && err.responseJSON.message) {
        if (callback) callback(false, err.responseJSON.message);
      } else {
      }
    },
  });
} */

$("#lucpropertysubtypeto").change(function () {
  displayEstimatedCharges();
});
function displayEstimatedCharges() {
  var baseUrl = getBaseURL();
  var propertyId = $("#propertyid").val();
  var applicantType = $("#applicantType").val();
  $.ajax({
    type: "GET",
    url: baseUrl + "/land-use-change/property-type-options/" + propertyId,
    success: function (response) {
      if (response.status == "success" && response.propertyDetails) {
        var propertyDetails = response.propertyDetails;
        var calculationRate = $("#lucpropertysubtypeto option:selected").data(
          "rate"
        );

        var landValue = propertyDetails.land_value;
        var basicEstimate = "0.00";
        if (calculationRate > 0) {
          basicEstimate = (
            (((calculationRate * landValue) / 100) * 100) /
            100
          ).toFixed(2); //round to 2 decimal places
        }
        $("#estimatedCharges").html("₹ " + customNumFormat(basicEstimate));
        $("#chargesCalculationInfo").html(
          Math.round(calculationRate) +
          `% of Land value (${customNumFormat(landValue)})`
        );
        $("#checkDetailsMessage").html(
          "You can check the detailed calculation under <b>Know Your Charges</b> &gt; Land Use Change"
        );
        if ($(".estimate").hasClass("d-none")) {
          $(".estimate").removeClass("d-none");
        }
      }
    },
    error: function (response) {
      console.log(response);
    },
  });
}

function getUserDetails() {
  var baseUrl = getBaseURL();
  var csrfToken = $('meta[name="csrf-token"]').attr("content");
  return $.ajax({
    url: baseUrl + "/fetch-user-details",
    type: "GET",
    dataType: "JSON",
    data: {
      _token: csrfToken,
    },
  });
}

function conversionStep1(propertyid, propertyStatus, callback) {
  var updateId = $("input[name='updateId']").val();
  var statusofapplicant = $("#statusofapplicant").val();
  var convname = $("input[name='convname']").val();
  var convgender = $("input[name='convgender']").val();
  var convage = $("input[name='convage']").val();
  var convRelationPrefix = $("#convprefixApp").html();
  var convRelationName = $("#convfathername").html();
  var convExecutedOnAsOnLease = $(
    "input[name='convExecutedOnAsOnLease']"
  ).val();
  var convaadhar = $("input[name='convaadhar']").val();
  var convpan = $("input[name='convpan']").val();
  var convmobilenumber = $("input[name='convmobilenumber']").val();
  var convNameAsOnLease = $("input[name='convNameAsOnLease']").val();
  var convRegnoAsOnLease = $("input[name='convRegnoAsOnLease']").val();
  var convBooknoAsOnLease = $("input[name='convBooknoAsOnLease']").val();
  var convVolumenoAsOnLease = $("input[name='convVolumenoAsOnLease']").val();
  var convPagenoFrom = $("input[name='convPagenoFrom']").val();
  var convPagenoTo = $("input[name='convPagenoTo']").val();
  var convRegdateAsOnLease = $("input[name='convRegdateAsOnLease']").val();
  var convCaseNo = $("input[name='convCaseNo']").val();
  var convCaseDetail = $("textarea[name='convCaseDetail']").val();
  var courtorderConversion = $(
    "input[name='courtorderConversion']:checked"
  ).val();
  var propertymortgagedConversion = $(
    "input[name='propertymortgagedConversion']:checked"
  ).val();
  var courtorderConversion = $(
    "input[name='courtorderConversion']:checked"
  ).val();

  var coapplicants = {};
  var formData = new FormData(); // Initialize FormData to handle both text and file data

  // Collect other fields (property details)
  formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
  formData.append("updateId", updateId);
  formData.append("propertyid", propertyid);
  formData.append("propertyStatus", propertyStatus);
  formData.append("statusofapplicant", statusofapplicant);
  formData.append("convname", convname);
  formData.append("convgender", convgender);
  formData.append("convage", convage);
  formData.append("convRelationPrefix", convRelationPrefix);
  formData.append("convRelationName", convRelationName);
  formData.append("convExecutedOnAsOnLease", convExecutedOnAsOnLease);
  formData.append("convaadhar", convaadhar);
  formData.append("convpan", convpan);
  formData.append("convmobilenumber", convmobilenumber);
  formData.append("convNameAsOnLease", convNameAsOnLease);
  formData.append("convRegnoAsOnLease", convRegnoAsOnLease);
  formData.append("convBooknoAsOnLease", convBooknoAsOnLease);
  formData.append("convVolumenoAsOnLease", convVolumenoAsOnLease);
  formData.append("convPagenoFrom", convPagenoFrom);
  formData.append("convPagenoTo", convPagenoTo);
  formData.append("convRegdateAsOnLease", convRegdateAsOnLease);
  formData.append("courtorderConversion", courtorderConversion);
  if (courtorderConversion == "1") {
    formData.append("convCaseNo", convCaseNo);
    formData.append("convCaseDetail", convCaseDetail);

    var convCourtOrderFileInput = $('input[name="convCourtOrderFile"]');
    var convCourtOrderFile = convCourtOrderFileInput[0].files[0];
    formData.append("convCourtOrderFile", convCourtOrderFile);
    var convCourtOrderDate = $('input[name="convCourtOrderDate"]').val();
    formData.append("convCourtOrderDate", convCourtOrderDate);
    var courtorderattestedbyConversion = $(
      'input[name="courtorderattestedbyConversion"]'
    ).val();
    formData.append(
      "courtorderattestedbyConversion",
      courtorderattestedbyConversion
    );
  }

  formData.append("propertymortgagedConversion", propertymortgagedConversion);
  if (propertymortgagedConversion == "1") {
    var mortgageNoCFileInput = $('input[name="convMortgageeBankNOC"]');
    var mortgageNoCFile = mortgageNoCFileInput[0].files[0];
    formData.append("mortgageNoCFile", mortgageNoCFile);
    var NOCAttestationDateConversion = $(
      'input[name="NOCAttestationDateConversion"]'
    ).val();
    formData.append(
      "NOCAttestationDateConversion",
      NOCAttestationDateConversion
    );
    var NOCIssuedByConversion = $('input[name="NOCIssuedByConversion"]').val();
    formData.append("NOCIssuedByConversion", NOCIssuedByConversion);
  }

  // Iterate over co-applicant inputs and add text fields to formData
  $("input[name^='convcoapplicant'], select[name^='convcoapplicant']").each(
    function () {
      var nameAttr = $(this).attr("name");
      var value = $(this).val();
      var matches = nameAttr.match(/coapplicant\[(\d+)]\[(\w+)\]/);
      if (matches) {
        var index = matches[1];
        var field = matches[2];
        if (!coapplicants[index]) coapplicants[index] = {};
        coapplicants[index][field] = value;

        // Append the text field to FormData
        formData.append(`coapplicants[${index}][${field}]`, value);
        if ($(this).attr("type") == "file") {
          console.log($(this));
          var fileInput = $(this)[0].files[0]; // Get the first file (since each input has one file)
          if (fileInput) {
            formData.append(`coapplicants[${index}][${field}]`, fileInput); // Append the file to FormData
          }
        }
      }
    }
  );

  // Iterate over co-applicant image inputs and add file fields to formData
  /*  $("input[type='file'][name^='convcoapplicantphoto']").each(function () {
    var nameAttr = $(this).attr("name");

    var fileInput = $(this)[0].files[0]; // Get the first file (since each input has one file)
    if (fileInput) {
      formData.append(nameAttr, fileInput); // Append the file to FormData
    }
  }); */

  var baseUrl = getBaseURL();

  $.ajax({
    url: baseUrl + "/conversion/step-1",
    type: "POST",
    data: formData, // Use FormData for sending files
    contentType: false, // Prevent jQuery from overriding content type
    processData: false, // Tell jQuery not to process data

    success: function (result) {
      if (result.status == "success") {
        $("#submitbtn1").html('Next <i class="bx bx-right-arrow-alt ms-2"></i>');
        $("#submitbtn1").prop("disabled", false);
        $("input[name='updateId']").val(result.data.id);
        $("input[name='lastPropertyId']").val(result.data.old_property_id);
        if (callback) callback(true, result); // Success
      } else {
        // Handle failure scenario
        $("#submitbtn1").html(
          'Next <i class="bx bx-right-arrow-alt ms-2"></i>'
        );
        $("#submitbtn1").prop("disabled", false);
        // $("input[name='updateId']").val(result.data.id);
        // $("input[name='lastPropertyId']").val(result.data.old_property_id);
        if (callback) callback(false, result); // Call the callback with failure
      }
    },
    error: function (err) {
      $("#submitbtn1").html('Next <i class="bx bx-right-arrow-alt ms-2"></i>');
      $("#submitbtn1").prop("disabled", false);
      if (err.responseJSON && err.responseJSON.message) {
        if (callback) callback(false, err.responseJSON.message);
      } else {
        if (callback) callback(false, "Unknown error!!");
      }
    },
  });
}

// added by anil kuamr on 11-02-2025 for conversion repeater form validtaion
$(document).on(
  "blur change",
  "#CONrepeater input, #CONrepeater select",
  function () {
    coapplicantConRepeaterForm();
  }
);

function coapplicantConRepeaterForm() {
  var isCoapplicantConValid = true;

  $("#CONrepeater .coapplicant-block").each(function (index, element) {
    var conCoName = $(element)
      .find("#convcoapplicant_" + index + "_name")
      .val();
    var conCoGender = $(element)
      .find("#convcoapplicant_" + index + "_gender")
      .val();
    var conCoDob = $(element)
      .find("#convcoapplicant_" + index + "_dateofbirth")
      .val();
    var ageConField = $(element).find("#coapplicant_" + index + "_age");
    var conCoRelation = $(element)
      .find("#convcoapplicant_" + index + "_fathername")
      .val();
    var conCoAdhaarNumber = $(element)
      .find("#convcoapplicant_" + index + "_aadharnumber")
      .val();
    var conCoAdhaarFile = $(element).find(
      "#convcoapplicant_" + index + "_aadhaarfile"
    )[0].files[0];
    var conCoPanNumber = $(element)
      .find("#convcoapplicant_" + index + "_pannumber")
      .val();
    var conCoPanFile = $(element).find(
      "#convcoapplicant_" + index + "_panfile"
    )[0].files[0];
    var conCoMobileNumber = $(element)
      .find("#convcoapplicant_" + index + "_mobilenumber")
      .val();
    var conCoPhotoFile = $(element).find(
      "#convcoapplicant_" + index + "_photo"
    )[0].files[0]; // Get the actual file

    // Remove previous error messages
    $(this)
      .find(".error-message")
      .text("");

    // Future Date Validation for DOB
    if (conCoDob) {
      var dob = new Date(conCoDob);
      var today = new Date();
      today.setHours(0, 0, 0, 0);

      if (dob > today) {
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "Date of birth cannot be in the future.",
          "#convcoapplicant_" + index + "_dateofbirth"
        );
        $(element)
          .find("#convcoapplicant_" + index + "_dateofbirth")
          .val(""); // Clear invalid input
      } else {
        var age = coCalculateAge(dob);
        ageConField.val(age);
      }
    }

    // Remove previous error messages
    $(this)
      .find(".error-message")
      .text("");

    // Check if any field is filled
    var isAnyConFieldFilled =
      conCoName ||
      conCoGender ||
      conCoDob ||
      conCoRelation ||
      conCoAdhaarNumber ||
      conCoAdhaarFile ||
      conCoPanNumber ||
      conCoPanFile ||
      conCoMobileNumber ||
      conCoPhotoFile;

    if (isAnyConFieldFilled) {
      // If at least one field is filled, make all fields mandatory
      if (!conCoName) {
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "Name is required.",
          "#convcoapplicant_" + index + "_name"
        );
      }
      if (!conCoGender) {
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "Please select your gender.",
          "#convcoapplicant_" + index + "_gender"
        );
      }
      if (!conCoDob) {
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "Please select your date of birth.",
          "#convcoapplicant_" + index + "_dateofbirth"
        );
      }
      if (!conCoRelation) {
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "Please enter your relation.",
          "#convcoapplicant_" + index + "_fathername"
        );
      }
      // Validate Aadhaar number (example: 12-digit number)
      if (!conCoAdhaarNumber) {
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "Aadhaar number is required.",
          "#convcoapplicant_" + index + "_aadharnumber"
        );
      } else if (!/^\d{12}$/.test(conCoAdhaarNumber)) {
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "Aadhaar number must be 12 digits.",
          "#convcoapplicant_" + index + "_aadharnumber"
        );
      }
      // Check if file exists and its size for Aadhaar file
      if (!conCoAdhaarFile) {
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "Please upload Aadhaar PDF.",
          "#convcoapplicant_" + index + "_aadhaarfile"
        );
      } else if (conCoAdhaarFile && conCoAdhaarFile.size > 5 * 1024 * 1024) {
        // 5MB limit for Aadhaar file
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "Aadhaar file size must be less than 5MB.",
          "#convcoapplicant_" + index + "_aadhaarfile"
        );
      }
      // Validate PAN number (example: format ABCDE1234F)
      if (!conCoPanNumber) {
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "PAN number is required.",
          "#convcoapplicant_" + index + "_pannumber"
        );
      }
      // Check if file exists and its size for PAN file
      if (!conCoPanFile) {
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "Please upload PAN Card PDF",
          "#convcoapplicant_" + index + "_panfile"
        );
      } else if (conCoPanFile && conCoPanFile.size > 5 * 1024 * 1024) {
        // 5MB limit for PAN file
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "PAN file size must be less than 5MB.",
          "#convcoapplicant_" + index + "_panfile"
        );
      }
      // Validate mobile number (example: 10-digit number)
      if (!conCoMobileNumber) {
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "Mobile number is required",
          "#convcoapplicant_" + index + "_mobilenumber"
        );
      } else if (!/^\d{10}$/.test(conCoMobileNumber)) {
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "Mobile number must be 10 digits.",
          "#convcoapplicant_" + index + "_mobilenumber"
        );
      }
      // Validate photo file size (e.g., max 1MB)
      if (!conCoPhotoFile) {
        isCoapplicantConValid = false;
        showErrorMessage(
          this,
          "Please upload Co-Applicant Passport Size Photo",
          "#convcoapplicant_" + index + "_photo"
        );

        var fileInput = $(this).find("#convcoapplicant_" + index + "_photo")[0];

        // Check if file is selected
        if (fileInput && fileInput.files && fileInput.files.length > 0) {
          var fileSize = fileInput.files[0].size;

          // Check if file size exceeds 100KB (100KB = 102400 bytes)
          if (fileSize > 102400) {
            isCoapplicantConValid = false;
            showErrorMessage(
              this,
              "Passport photo size must be less than 100KB.",
              "#convcoapplicant_" + index + "_photo"
            );
          }
        }
      } else {
        // If no file is uploaded (coPhotoFile is undefined), show an error message
        var fileInput = $(this).find("#convcoapplicant_" + index + "_photo")[0];

        if (fileInput && fileInput.files && fileInput.files.length > 0) {
          var fileSize = fileInput.files[0].size;

          // Check if file size is larger than 100KB
          if (fileSize > 102400) {
            isCoapplicantConValid = false;
            showErrorMessage(
              this,
              "Passport photo size must be less than 100KB.",
              "#convcoapplicant_" + index + "_photo"
            );
          }
        }
      }
    }
  });

  return isCoapplicantConValid;
}

// function to calculate age
function calculateAge(dob) {
  var today = new Date();
  var age = today.getFullYear() - dob.getFullYear();
  var m = today.getMonth() - dob.getMonth();

  if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
    age--;
  }

  return age;
}

function showErrorMessage(form, message, selector) {
  var inputField = $(form).find(selector);
  var errorMessageSpan = inputField.next(".error-message");
  errorMessageSpan.text(message).show();
}
//end for conversion repeater form validtaion


//for show and hide the mutation third step documents according to th check and uncheck of documents at step first
//SOURAV CHAUHAN - 18/Oct/2024
// document.querySelectorAll(".documentType").forEach((checkbox) => {
//   checkbox.addEventListener("change", function () {
//     const { value, checked, id } = this; // Destructuring for clarity
//     handleCheckboxChange(value, checked, id);
//   });
// });

// function handleCheckboxChange(value, checked, id) {
//   const element = $(`#stepThreeDiv #${id}`);

//   if (checked) {
//     element.show();
//   } else {
//     element.hide();
//   }
// }

// Add event listeners to checkboxes
document.querySelectorAll(".documentType").forEach((checkbox) => {
  checkbox.addEventListener("change", function () {
    const { value, checked, id } = this; // Destructuring for clarity
    handleCheckboxChange(value, checked, id);
  });

  // Check if the checkbox is already checked (on page load)
  const { checked, id } = checkbox;
  handleCheckboxChange(checkbox.value, checked, id);
});

// Function to handle showing/hiding elements based on checkbox state
function handleCheckboxChange(value, checked, id) {
  const element = $(`#stepThreeDiv #${id}`);

  if (checked) {
    element.show();
  } else {
    element.hide();
  }
}

function conversionStep2(callback) {
  var updateId = $("input[name='updateId']").val();
  var formData = new FormData();
  var baseUrl = getBaseURL();
  formData.append("_token", $('meta[name="csrf-token"]').attr("content")); // CSRF token
  formData.append("updateId", updateId);

  $("input[name^='convDoc'], select[name^='convDoc']").each(function () {
    var nameAttr = $(this).attr("name");
    var value = $(this).val();
    // Append the text field to FormData
    formData.append(nameAttr, value);
    if ($(this).attr("type") == "file") {
      var fileInput = $(this)[0].files[0]; // Get the first file (since each input has one file)
      if (fileInput) {
        formData.append(nameAttr, fileInput); // Append the file to FormData
      }
    }
    // }
  });

  $.ajax({
    type: "POST",
    url: `${baseUrl}/conversion/step-2`,
    contentType: false,
    processData: false,
    data: formData,
    success: (response) => {
      if (response.status == "error") {
        console.log("success response");
        console.log(response);
        if (callback) callback(false, response.id + "-" + response.message);
      }
      if (callback) callback(true, response.message);
    },
    error: (response) => {
      if (response.status == 422) {
        let er = response.responseJSON;
        if (callback) callback(false, er.id + "-" + er.message); // Call the callback with failure
      } else {
        if (callback) callback(response.responseText);
      }
    },
  });
}
function conversionStep3(callback) {
  var updateId = $("input[name='updateId']").val();
  var formData = new FormData();
  var baseUrl = getBaseURL();
  formData.append("_token", $('meta[name="csrf-token"]').attr("content")); // CSRF token
  formData.append("updateId", updateId);

  $("input[name^='convOpt']").each(function () {
    var nameAttr = $(this).attr("name");
    var value = $(this).val();
    // Append the text field to FormData
    formData.append(nameAttr, value);
  });

  formData.append("isLeaseDeedLost", $('input[name="isLeaseDeedLost"]').val());
  formData.append(
    "applicantConsent",
    $("#agreeConsentConversion").is(":checked")
  );

  $.ajax({
    type: "POST",
    url: `${baseUrl}/conversion/step-3`,
    contentType: false,
    processData: false,
    data: formData,
    success: (response) => {
      if (response.url) {
        window.location.href = response.url;
      } else {
        if (response.status == "error") {
          if (callback) callback(false, response.message);
        }
        if (callback) callback(true, response.message);
      }
    },
    error: (response) => {
      if (response.status == 422) {
        // validation error
        let er = response.responseJSON;
        if (callback) callback(false, er.id + "-" + er.message); // Call the callback with failure
      } else {
        if (callback) callback(response.responseText);
      }
    },
  });
}
