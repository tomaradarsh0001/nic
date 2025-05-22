// Field Validation
let spinner;
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

  // Plot number
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
  spinner = document.getElementById("spinnerOverlay");
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

$("#conveyanceRepeater").createRepeater({
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
  return `${protocol}//${hostname}${port ? ":" + port : ""}/edharti`;
}

$(document).ready(function () {
  // Self Attested Doc for Other
  // Self Attested Doc for Other comment by anil on 25-04-2025 not in use
  // $("#selectdocselfattesteddocname").change(function () {
  //   if ($(this).val() === "Other") {
  //     $("#docName").show();
  //     $("#docName").show();
  //   } else {
  //     $("#docName").hide();
  //     $("#docName").hide();
  //   }
  // });

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
      getUserDetails()
        .then(function (response) {
          if (response.status) {
            $("#nocNameApp").val(response.data.user.name);
            $("#nocGenderApp").val(response.data.details.gender);
            $("#nocDateOfBirthApp").val(response.data.details.dob);
            $("#nocAgeApp").val(response.data.details.age);
            $("#nocprefixApp").html(response.data.details.so_do_spouse);
            $("#nocFathernameApp").val(response.data.details.second_name);
            $("#nocAadharApp").val(response.data.details.aadhar_card);
            $("#nocPanApp").val(response.data.details.pan_card);
            $("#nocMobilenumberApp").val(response.data.user.mobile_no);
          }
        })
        .catch(function (error) {
          console.error("Error during AJAX call:", error);
        }); //code changed by Nitin to reuse fetch-user details function
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

  // -------------------- if Yes deed Lost in Conversion --------------------
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
  var agreeDOAConsent = document.getElementById("agreeDOAConsent");
  var agreeDOAConsentError = document.getElementById("agreeDOAConsentError");

  function validatePropertyId() {
    var propertyidValue = propertyid.value.trim();
    if (propertyidValue === "") {
      propertyIdError.textContent = "Property ID is required.";
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
      propertyStatusError.textContent = "Property status is required.";
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
      applicationTypeError.textContent = "Application type is required.";
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
      statusofapplicantError.textContent = "Status of applicant is required.";
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
      flatidError.textContent = "Flat is required.";
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
      buildingNameError.textContent = "Building name is required.";
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
      originalBuyerNameError.textContent = "Original buyer name is required.";
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
        "Present occupant name is required.";
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
      purchasedFromError.textContent = "Purchased from name is required.";
      purchasedFromError.style.display = "block";
      return false;
    } else {
      purchasedFromError.style.display = "none";
      return true;
    }
  }*/

  function validateBuildingName() {
    var buildingNameValue = buildingName.value.trim();
    var regex = /^[A-Za-z\s]+$/; // Allows only alphabets and spaces

    if (buildingNameValue === "") {
      buildingNameError.textContent = "Building name is required.";
      buildingNameError.style.display = "block";
      return false;
    } else if (!regex.test(buildingNameValue)) {
      buildingNameError.textContent =
        "Only letters and number are allowed.";
      buildingNameError.style.display = "block";
      return false;
    } else {
      buildingNameError.style.display = "none";
      return true;
    }
  }

  function validateoriginalBuyerName() {
    var originalBuyerNameValue = originalBuyerName.value.trim();
    var regex = /^[A-Za-z\s]+$/; // Allows only alphabets and spaces

    if (originalBuyerNameValue === "") {
      originalBuyerNameError.textContent = "Original buyer name is required.";
      originalBuyerNameError.style.display = "block";
      return false;
    } else if (!regex.test(originalBuyerNameValue)) {
      originalBuyerNameError.textContent =
        "Only letters and number are allowed.";
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
      presentOccupantNameError.textContent =
        "Present occupant name is required.";
      presentOccupantNameError.style.display = "block";
      return false;
    } else if (!regex.test(presentOccupantNameValue)) {
      presentOccupantNameError.textContent =
        "Only letters are allowed.";
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
      purchasedFromError.textContent = "Purchased from name is required.";
      purchasedFromError.style.display = "block";
      return false;
    } else if (!regex.test(purchasedFromValue)) {
      purchasedFromError.textContent = "Only letters are allowed.";
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
      purchaseDateError.textContent = "Purchase date is required.";
      purchaseDateError.style.display = "block";
      return false;
    }

    // Parse the purchase date and today's date
    var selectedDate = new Date(purchaseDateValue);
    var today = new Date();

    // Check if the selected date is in the future
    if (selectedDate > today) {
      purchaseDateError.textContent = "Purchase date cannot be in the future.";
      purchaseDateError.style.display = "block";
      return false;
    }

    purchaseDateError.style.display = "none";
    return true;
  }

  /*function validateApartmentArea() {
    var apartmentAreaValue = apartmentArea.value.trim();
    if (apartmentAreaValue === "") {
      apartmentAreaError.textContent = "Flat area is required.";
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
      plotAreaError.textContent = "Plot area is required.";
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
      apartmentAreaError.textContent = "Flat area is required.";
      apartmentAreaError.style.display = "block";
      return false;
    } else if (!regex.test(apartmentAreaValue)) {
      apartmentAreaError.textContent = "Flat area must be numeric.";
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
      plotAreaError.textContent = "Plot area is required.";
      plotAreaError.style.display = "block";
      return false;
    } else if (!regex.test(plotAreaValue)) {
      plotAreaError.textContent = "Plot area must numeric.";
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
        "Change to property type is required.";
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
        "Change to property sub type is required.";
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
          "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        lucpropertyTaxpayreceiptError.textContent =
          "Only PDF files are allowed.";
        return false;
      } else {
        lucpropertyTaxpayreceiptError.textContent = "";
        return true;
      }
    } else {
      // lucpropertyTaxpayreceiptError.textContent =
      //   "Property tax payment receipt is required.";
      // return false;

      if (lucpropertyTaxpayreceipt.getAttribute("data-should-validate") == 1) {
        return true;
      }
      lucpropertyTaxpayreceiptError.textContent =
        "Property tax payment receipt is required.";
      return false;
    }
  }

  function validatePropertyTaxAssessmentReceipt() {
    if (PropertyTaxAssessmentReceipt.files.length > 0) {
      var file = PropertyTaxAssessmentReceipt.files[0];
      if (file.size > 5 * 1024 * 1024) {
        PropertyTaxAssessmentReceiptError.textContent =
          "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        PropertyTaxAssessmentReceiptError.textContent =
          "Only PDF files are allowed.";
        return false;
      } else {
        PropertyTaxAssessmentReceiptError.textContent = "";
        return true;
      }
    } else {
      // PropertyTaxAssessmentReceiptError.textContent =
      //   "Property tax assessment is required.";
      // return false;
      if (
        PropertyTaxAssessmentReceipt.getAttribute("data-should-validate") == 1
      ) {
        return true;
      }
      PropertyTaxAssessmentReceiptError.textContent =
        "Property tax assessment is required.";
      return false;
    }
  }

  function validateLUCPhoto1() {
    if (lucphoto1.files.length > 0) {
      var file = lucphoto1.files[0];
      if (file.size > 5 * 1024 * 1024) {
        lucphoto1Error.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        lucphoto1Error.textContent = "Only PDF file is allowed.";
        return false;
      } else {
        lucphoto1Error.textContent = "";
        return true;
      }
    } else {
      // lucphoto1Error.textContent = "Property photo is required.";
      // return false;
      if (lucphoto1.getAttribute("data-should-validate") == 1) {
        return true;
      }
      lucphoto1Error.textContent = "Property photo is required.";
      return false;
    }
  }

  function validateLUCMPDPermit() {
    if (lucmpdzonalpermitting.files.length > 0) {
      var file = lucmpdzonalpermitting.files[0];
      if (file.size > 5 * 1024 * 1024) {
        lucmpdzonalpermittingError.textContent =
          "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        lucmpdzonalpermittingError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        lucmpdzonalpermittingError.textContent = "";
        return true;
      }
    } else {
      // lucmpdzonalpermittingError.textContent =
      //   "MPD/Zonal plan permitting LUC is required.";
      // return false;
      if (lucmpdzonalpermitting.getAttribute("data-should-validate") == 1) {
        return true;
      }
      lucmpdzonalpermittingError.textContent =
        "MPD/Zonal plan permitting LUC is required.";
      return false;
    }
  }

  function validateStatusOfChangeProperty() {
    var lucpropertytypetoValue = lucpropertytypeto.value.trim();
    if (lucpropertytypetoValue === "") {
      lucpropertytypetoError.textContent =
        "Change to property type is required.";
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
      lucagreeconsentError.textContent = "Please accept terms & conditions.";
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
    let isPoAValid = validatePOADoc("LUC-2");

    return (
      islucpropertyTaxpayreceiptValid &&
      isPropertyTaxAssessmentReceiptValid &&
      isLUCPhoto1Valid &&
      isLUCMPDPermitValid &&
      isAgreeConsentLUCValid &&
      isPoAValid
    );
  }

  // Validate DOA Form 2
  function validateForm2DOA() {
    var isBuilderBuyerAgreementValid = validateBuilderBuyerAgreement();
    var isSaleDeedValid = validateSaleDeed();
    var isBuildingPlanValid = validateBuildingPlan();
    // var isOtherDocumentValid = validateOtherDocument(); // Comment to make other document optional field - Lalit Tiwari on 06/May/2025
    let isPoAValid = validatePOADoc("DOA-2");
    var isValidateAgreeConsentDoa = validateAgreeConsentDoa();
    return (
      isBuilderBuyerAgreementValid &&
      isSaleDeedValid &&
      isBuildingPlanValid &&
      // isOtherDocumentValid && // Comment to make other document optional field - Lalit Tiwari on 06/May/2025
      isPoAValid &&
      isValidateAgreeConsentDoa
    );
  }

  function validateBuilderBuyerAgreement() {
    if (BuilderBuyerAgreement.files.length > 0) {
      var file = BuilderBuyerAgreement.files[0];
      if (file.size > 5 * 1024 * 1024) {
        BuilderBuyerAgreementError.textContent =
          "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        BuilderBuyerAgreementError.textContent = "Only PDF files are allowed.";
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
        "Builder buyer agreement is required.";
      return false;
    }
  }
  function validateSaleDeed() {
    if (SaleDeed.files.length > 0) {
      var file = SaleDeed.files[0];
      if (file.size > 5 * 1024 * 1024) {
        SaleDeedError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        SaleDeedError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        SaleDeedError.textContent = "";
        return true;
      }
    } else {
      if (SaleDeed.getAttribute("data-should-validate") == 1) {
        return true;
      }
      SaleDeedError.textContent = "Sale deed is required.";
      return false;
    }
  }
  function validateBuildingPlan() {
    if (BuildingPlan.files.length > 0) {
      var file = BuildingPlan.files[0];
      if (file.size > 5 * 1024 * 1024) {
        BuildingPlanError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        BuildingPlanError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        BuildingPlanError.textContent = "";
        return true;
      }
    } else {
      if (BuildingPlan.getAttribute("data-should-validate") == 1) {
        return true;
      }
      BuildingPlanError.textContent = "Building plan is required.";
      return false;
    }
  }

  function validateAgreeConsentDoa() {
    if (!agreeDOAConsent.checked) {
      agreeDOAConsentError.textContent = "Please accept terms & conditions.";
      agreeDOAConsentError.style.display = "block";
      return false;
    } else {
      agreeDOAConsentError.style.display = "none";
      return true;
    }
  }

  // Comment to make other document optional field - Lalit Tiwari on 06/May/2025
  /* function validateOtherDocument() {
    if (OtherDocument.files.length > 0) {
      var file = OtherDocument.files[0];
      if (file.size > 5 * 1024 * 1024) {
        OtherDocumentError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        OtherDocumentError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        OtherDocumentError.textContent = "";
        return true;
      }
    } else {
      if (OtherDocument.getAttribute("data-should-validate") == 1) {
        return true;
      }
      OtherDocumentError.textContent = "Other document agreement is required.";
      return false;
    }
  } */

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
      namergappError.textContent = "Executed in favour of is required.";
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
        "Executed on is required.";
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
      regnoError.textContent = "Registration number is required.";
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
      booknoError.textContent = "Book number is required.";
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
      volumenoError.textContent = "Volume number is required.";
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
  //     pagenoFromError.textContent = "Page number from is required.";
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
  //     pagenoToError.textContent = "Page number to is required.";
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

  //   // Validate 'Page number To'
  //   if (pagenoValueTo === "") {
  //     $('#pagenoToError').text("Page number to is required.").show();
  //   } else if (parseInt(pagenoValueTo) < parseInt(pagenoValueFrom)) {
  //     $('#pagenoToError').text("Page number to cannot be less than page number from.").show();
  //   } else {
  //     $('#pagenoToError').hide();
  //   }

  //   // Validate 'Page number From'
  //   if (pagenoValueFrom === "") {
  //     $('#pagenoFromError').text("Page number from is required.").show();
  //   } else if (parseInt(pagenoValueFrom) > parseInt(pagenoValueTo) && pagenoValueTo !== "") {
  //     $('#pagenoFromError').text("Page number from cannot be greater than page number to.").show();
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

    // Check if 'Page number To' is empty
    if (pagenoValue === "") {
      pagenoToError.textContent = "Page number to is required.";
      pagenoToError.style.display = "block";
      return false;
    }

    // Check if the value is numeric
    if (!/^\d+$/.test(pagenoValue)) {
      pagenoToError.textContent = "Page number to must be a numeric value.";
      pagenoToError.style.display = "block";
      return false;
    }

    // Check if 'Page number To' is a positive integer
    if (parseInt(pagenoValue) <= 0) {
      pagenoToError.textContent = "Page number to must be a positive number.";
      pagenoToError.style.display = "block";
      return false;
    }

    // Check if 'Page number To' is less than 'Page number From'
    if (parseInt(pagenoValue) < parseInt(pagenoValueFrom)) {
      pagenoToError.textContent =
        "Page number to cannot be less than page number from.";
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

    // Check if 'Page number From' is empty
    if (pagenoValueFrom === "") {
      pagenoFromError.textContent = "Page number from is required.";
      pagenoFromError.style.display = "block";
      return false;
    }

    // Check if the value is numeric
    if (!/^\d+$/.test(pagenoValueFrom)) {
      pagenoFromError.textContent = "Page number from must be a numeric value.";
      pagenoFromError.style.display = "block";
      return false;
    }

    // Check if 'Page number From' is a positive integer
    if (parseInt(pagenoValueFrom) <= 0) {
      pagenoFromError.textContent = "Page number from must be a positive number.";
      pagenoFromError.style.display = "block";
      return false;
    }

    // Check if 'Page number From' is greater than 'Page number To'
    if (parseInt(pagenoValueFrom) > parseInt(pagenoValueTo)) {
      pagenoFromError.textContent =
        "Page number from cannot be greater than page number to.";
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
      regdateError.textContent = "Registration date is required.";
      regdateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (regdateValue > today) {
      regdateError.textContent = "Registration date cannot be in the future.";
      regdateError.style.display = "block";
      regdate.value = ""; // Clear the invalid date
      return false;
    }

    // Ensure regdate is not earlier than mutExecutedOnAsConLease
    if (regdateObj < mutExecutedOnAsConLeaseObj) {
      regdateError.textContent = "Registration cannot occur prior to the execution date.";
      regdateError.style.display = "block";
      regdate.value = ""; // Clear the invalid date
      return false;
    }

    regdateError.style.display = "none";
    return true;
  }

  function validateSoughtApplicant() {
    var soughtByApplicantValue = document.querySelectorAll(
      ".documentType:checked"
    );
    if (soughtByApplicantValue.length === 0) {
      soughtByApplicantError.style.display = "block";
      soughtByApplicantError.textContent =
        "Select at least one document.";
      return false;
    } else {
      soughtByApplicantError.style.display = "none";
      return true;
    }

    // if (soughtByApplicantValue === "") {
    //   soughtByApplicantError.textContent = "Mutation/Substitution sought by applicant is required.";
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
        YesMortgagedError.textContent = "Remark is required.";
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
  //       YesCourtOrderMutationError.textContent = "Case number is required.";
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
    var isCoapplicantValid = coapplicantMutRepeaterForm();
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
    var isStatusOfApplicantValid = validateStatusOfApplicant();
    // var isYesCourtOrderValid = validYesCourtOrder();

    return (
      isCoapplicantValid &&
      isFarm1MUTValid &&
      isExecutedOnValid &&
      isRegOnValid &&
      isBookNoValid &&
      isVolumeNoValid &&
      isPageNoFromValid &&
      isPageNoToValid &&
      isRegDateValid &&
      isSoughtApplicantValid &&
      isYesMortgagesValid &&
      isStatusOfApplicantValid
      // isYesCourtOrderValid
    );
  }

  function validateEditMut1() {
    var isCoapplicantValid = coapplicantMutRepeaterForm();
    var isRegOnValid = validateRegOn();
    var isBookNoValid = validateBookNo();
    var isVolumeNoValid = validateVolumeNo();
    var isPageNoFromValid = validatePageNoFrom();
    var isPageNoToValid = validatePageNoTo();
    var isRegDateValid = validateRegDate();
    var isSoughtApplicantValid = validateSoughtApplicant();
    var isYesMortgagesValid = validateYesMortgages();

    return (
      isCoapplicantValid &&
      isRegOnValid &&
      isBookNoValid &&
      isVolumeNoValid &&
      isPageNoFromValid &&
      isPageNoToValid &&
      isRegDateValid &&
      isSoughtApplicantValid &&
      isYesMortgagesValid
    );
  }

  // Conversion Form 1 Fields
  var convExecutedFavour = document.getElementById("convNameAsOnLease");
  var convExecutedOnAsOnLease = document.getElementById(
    "convExecutedOnAsOnLease"
  );
  var convRegNo = $("#convLeaseDeed").find("#regno");
  var convBookno = document.getElementById("convbookno");
  var convVolumeno = document.getElementById("convvolumeno");
  var convPagenoFrom = document.getElementById("convPagenoFrom");
  var convPagenoTo = document.getElementById("convPagenoTo");
  var convRegDate = document.getElementById("convregdate");
  var convYesCourtOrder = document.getElementById("YesCourtOrderConversion");
  var convCaseNo = document.getElementById("convCaseNo");
  var convCaseDetail = document.getElementById("convCaseDetail");
  var convCourtOrderFile = document.getElementById("convCourtOrderFile");
  var convCourtOrderDate = document.getElementById("convCourtOrderDate");
  var convCourtIssuingAuthority = document.getElementById(
    "courtorderattestedbyConversion"
  );
  var convYesMortgaged = document.getElementById("YesMortgagedConversion");
  var convMortgageeNOC = document.getElementById("convMortgageeBankNOC");
  var convDateOfNOC = document.getElementById("NOCAttestationDateConversion");
  var convMortgageeIssuingAuthority = document.getElementById(
    "NOCIssuedByConversion"
  );

  // Form 1 Errors
  var convExecutedFavourError = document.getElementById(
    "convNameAsOnLeaseError"
  );
  var convExecutedOnAsOnLeaseError = document.getElementById(
    "convExecutedOnAsOnLeaseError"
  );
  var convRegNoError = $("#convLeaseDeed").find("#regnoError");
  var convBooknoError = document.getElementById("convbooknoError");
  var convVolumenoError = document.getElementById("convvolumenoError");
  var convPagenoFromError = document.getElementById("convPagenoFromError");
  var convPagenoToError = document.getElementById("convPagenoToError");
  var convRegDateError = document.getElementById("convregdateError");
  var convYesCourtOrderError = document.getElementById(
    "YesCourtOrderConversionError"
  );
  var convCaseNoError = document.getElementById("convCaseNoError");
  var convCaseDetailError = document.getElementById("convCaseDetailError");
  var convCourtOrderFileError = document.getElementById(
    "convCourtOrderFileError"
  );
  var convCourtOrderDateError = document.getElementById(
    "convCourtOrderDateError"
  );
  var convCourtIssuingAuthorityError = document.getElementById(
    "courtorderattestedbyConversionError"
  );
  var convYesMortgagedError = document.getElementById(
    "YesMortgagedConversionError"
  );
  var convMortgageeNOCError = document.getElementById(
    "convMortgageeBankNOCError"
  );
  var convDateOfNOCError = document.getElementById(
    "NOCAttestationDateConversionError"
  );
  var convMortgageeIssuingAuthorityError = document.getElementById(
    "NOCIssuedByConversionError"
  );

  function validateConvExecutedfavour() {
    var convExecutedFavourValue = convExecutedFavour.value.trim();
    if (convExecutedFavourValue === "") {
      convExecutedFavourError.textContent = "Executed in favour of is required.";
      convExecutedFavourError.style.display = "block";
      return false;
    } else {
      convExecutedFavourError.style.display = "none";
      return true;
    }
  }

  function validateConvExecutedOnAsOnLeaseDate() {
    var convExecutedOnAsOnLeaseValue = convExecutedOnAsOnLease.value.trim();
    var today = new Date().toISOString().split("T")[0];
    if (convExecutedOnAsOnLeaseValue === "") {
      convExecutedOnAsOnLeaseError.textContent = "Executed date is required.";
      convExecutedOnAsOnLeaseError.style.display = "block";
      return false;
    } else if (convExecutedOnAsOnLeaseValue > today) {
      convExecutedOnAsOnLeaseError.textContent =
        "Executed date cannot be in the future.";
      convExecutedOnAsOnLeaseError.style.display = "block";
      convExecutedOnAsOnLease.value = ""; // Clear invalid input
      return false;
    } else {
      convExecutedOnAsOnLeaseError.style.display = "none";
      return true;
    }
  }

  function validateConvRegOn() {
    var convRegNoValue = convRegNo.val().trim();
    if (convRegNoValue === "") {
      convRegNoError.text("Registration number is required.");
      convRegNoError.css("display", "block");
      return false;
    } else {
      convRegNoError.css("display", "none");
      return true;
    }
  }

  function validateConvBookno() {
    var convBooknoValue = convBookno.value.trim();

    // Check if the field is empty
    if (convBooknoValue === "") {
      convBooknoError.textContent = "Book number is required.";
      convBooknoError.style.display = "block";
      return false;
    }
    
    // Check if the Book number is numeric
    if (!/^\d+$/.test(convBooknoValue)) {
      convBooknoError.textContent = "Book number must be a numeric value.";
      convBooknoError.style.display = "block";
      return false;
    }

    // Check if the Book number is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(convBooknoValue) <= 0) {
      convBooknoError.textContent = "Book number must be a positive number.";
      convBooknoError.style.display = "block";
      return false;
    }

    convBooknoError.style.display = "none";
    return true;
  }

  function validateConvVolumeno() {
    var convVolumenoValue = convVolumeno.value.trim();

    // Check if the field is empty
    if (convVolumenoValue === "") {
      convVolumenoError.textContent = "Volume number is required.";
      convVolumenoError.style.display = "block";
      return false;
    }
    
    // Check if the value is numeric
    if (!/^\d+$/.test(convVolumenoValue)) {
      convVolumenoError.textContent = "Volume must be a numeric value.";
      convVolumenoError.style.display = "block";
      return false;
    }

    // Check if the value is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(convVolumenoValue) <= 0) {
      convVolumenoError.textContent = "Volume must be a positive number.";
      convVolumenoError.style.display = "block";
      return false;
    }

    convVolumenoError.style.display = "none";
    return true;
  }

  $(document).on("input blur change", "#convPagenoFrom", function () {
    validateConvPagenoFrom();
  });

  function validateConvPagenoFrom() {
    var convPagenoFromValue = convPagenoFrom.value.trim();
    var convPagenoValueTo = convPagenoTo.value.trim();

    // Check if the field is empty
    if (convPagenoFromValue === "") {
      convPagenoFromError.textContent = "Page number from is required.";
      convPagenoFromError.style.display = "block";
      return false;
    }
    
    // Check if the value is numeric
    if (!/^\d+$/.test(convPagenoFromValue)) {
      convPagenoFromError.textContent = "Page number from must be a numeric value.";
      convPagenoFromError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(convPagenoFromValue) <= 0) {
      convPagenoFromError.textContent =
        "Page number from must be a positive number.";
      convPagenoFromError.style.display = "block";
      return false;
    }
    // Check if 'Page number From' is greater than 'Page number To'
    if (parseInt(convPagenoFromValue) > parseInt(convPagenoValueTo)) {
      convPagenoFromError.textContent =
        "Page number from cannot be greater than page number to.";
      convPagenoFromError.style.display = "block";
      return false;
    } else {
      convPagenoFromError.style.display = "none";
      return true;
    }
  }

  $(document).on("input blur change", "#convPagenoTo", function () {
    validateConvPagenoTo();
  });

  function validateConvPagenoTo() {
    var convPagenoToValue = convPagenoTo.value.trim();
    var convPagenoValueFrom = convPagenoFrom.value.trim();
    // Check if the field is empty
    if (convPagenoToValue === "") {
      convPagenoToError.textContent = "Page number to is required.";
      convPagenoToError.style.display = "block";
      // Check the value
      return false;
    }
    
    // Check if the value is numeric
    if (!/^\d+$/.test(convPagenoToValue)) {
      convPagenoToError.textContent = "Page number to must be a numeric value.";
      convPagenoToError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(convPagenoToValue) <= 0) {
      convPagenoToError.textContent = "Page number to must be a positive number.";
      convPagenoToError.style.display = "block";
      return false;
    }

    // Check if 'Page number To' is less than 'Page number From'
    if (parseInt(convPagenoToValue) < parseInt(convPagenoValueFrom)) {
      convPagenoToError.textContent =
        "Page number to cannot be less than page number from.";
      convPagenoToError.style.display = "block";
      return false;
    } else {
      convPagenoToError.style.display = "none";
      return true;
    }
  }

  function validateConvRegDate() {
    var convRegDateValue = convRegDate.value.trim();
    var convExecutedOnAsOnValueLease = convExecutedOnAsOnLease.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    var convRegDateObj = new Date(convRegDateValue);
    var convExecutedOnAsOnLeaseObj = new Date(convExecutedOnAsOnValueLease);

    if (convRegDateValue === "") {
      convRegDateError.textContent = "Registration date is required.";
      convRegDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (convRegDateValue > today) {
      convRegDateError.textContent =
        "Registration date cannot be in the future.";
      convRegDateError.style.display = "block";
      convRegDate.value = ""; // Clear the invalid date
      return false;
    }

    // Ensure convRegDate is not earlier than mutExecutedOnAsConLease
    if (convRegDateObj < convExecutedOnAsOnLeaseObj) {
      convRegDateError.textContent =
        "Registration cannot occur prior to the execution date.";
      convRegDateError.style.display = "block";
      convRegDate.value = ""; // Clear the invalid date
      return false;
    }

    convRegDateError.style.display = "none";
    return true;
  }

  function validateConvCourtOrderFields() {
    const alphaRegex = /^[A-Za-z\s.-]+$/; // Allows only letters, spaces, commas, etc.
    const CourtMaxFileSize = 5 * 1024 * 1024; // 5MB
    const today = new Date().toISOString().split("T")[0];

    if (convYesCourtOrder && convYesCourtOrder.checked) {
      let isconvYesCourtOrderValid = true;

      // 1. Case number
      if (convCaseNo.value.trim() === "") {
        convCaseNoError.textContent = "Case number is required.";
        convCaseNoError.style.display = "block";
        isconvYesCourtOrderValid = false;
      } else {
        convCaseNoError.style.display = "none";
      }

      // 2. Case Detail
      if (convCaseDetail.value.trim() === "") {
        convCaseDetailError.textContent = "Case detail is required.";
        convCaseDetailError.style.display = "block";
        isconvYesCourtOrderValid = false;
      } else {
        convCaseDetailError.style.display = "none";
      }

      // 3. Court Order File (skip validation if data-should-validate == 1)
      if (convCourtOrderFile.getAttribute("data-should-validate") != "1") {
        if (
          convCourtOrderFile.files.length === 0 ||
          convCourtOrderFile.value.trim() === ""
        ) {
          convCourtOrderFileError.textContent =
            "Court order PDF file is required.";
          convCourtOrderFileError.style.display = "block";
          isconvYesCourtOrderValid = false;
        } else {
          const file = convCourtOrderFile.files[0];

          // Check if the file is a PDF
          if (file.type !== "application/pdf") {
            convCourtOrderFileError.textContent = "Only PDF files are allowed.";
            convCourtOrderFileError.style.display = "block";
            isconvYesCourtOrderValid = false;
          }
          // Check if the file size is within the allowed limit
          else if (file.size > CourtMaxFileSize) {
            convCourtOrderFileError.textContent =
              "PDF file size must be less than 5MB.";
            convCourtOrderFileError.style.display = "block";
            isconvYesCourtOrderValid = false;
          } else {
            convCourtOrderFileError.style.display = "none";
          }
        }
      } else {
        convCourtOrderFileError.style.display = "none";
      }

      // 4. Court Order Date
      if (convCourtOrderDate.value.trim() === "") {
        convCourtOrderDateError.textContent = "Court order date is required.";
        convCourtOrderDateError.style.display = "block";
        isconvYesCourtOrderValid = false;
      } else if (convCourtOrderDate.value.trim() > today) {
        convCourtOrderDateError.textContent = "Date of document cannot be in the future.";
        convCourtOrderDateError.style.display = "block";
        convCourtOrderDate.value = "";
        isconvYesCourtOrderValid = false;
      } else {
        convCourtOrderDateError.style.display = "none";
      }

      // 5. Issuing Authority
      if (convCourtIssuingAuthority.value.trim() === "") {
        convCourtIssuingAuthorityError.textContent =
          "Issuing authority is required.";
        convCourtIssuingAuthorityError.style.display = "block";
        isconvYesCourtOrderValid = false;
      } else if (!alphaRegex.test(convCourtIssuingAuthority.value.trim())) {
        convCourtIssuingAuthorityError.textContent =
          "Issuing authority must contain letters only.";
        convCourtIssuingAuthorityError.style.display = "block";
        isconvYesCourtOrderValid = false;
      } else {
        convCourtIssuingAuthorityError.style.display = "none";
      }

      return isconvYesCourtOrderValid;
    }

    return true; // Skip validation if "No" is selected
  }

  function validateConvYesMortgaged() {
    const alphaRegex = /^[A-Za-z\s.-]+$/;
    const CourtMaxFileSize = 5 * 1024 * 1024;
    const today = new Date().toISOString().split("T")[0];

    if (convYesMortgaged && convYesMortgaged.checked) {
      let isconvYesMortgagedValid = true;

      // 1. Mortgagee NOC File (skip if data-should-validate == 1)
      if (convMortgageeNOC.getAttribute("data-should-validate") != "1") {
        if (
          convMortgageeNOC.files.length === 0 ||
          convMortgageeNOC.value.trim() === ""
        ) {
          convMortgageeNOCError.textContent = "Mortgagee NOC PDF is required.";
          convMortgageeNOCError.style.display = "block";
          isconvYesMortgagedValid = false;
        } else {
          const file = convMortgageeNOC.files[0];

          // Check if the file is a PDF
          if (file.type !== "application/pdf") {
            convMortgageeNOCError.textContent = "Only PDF files are allowed.";
            convMortgageeNOCError.style.display = "block";
            isconvYesMortgagedValid = false;
          }
          // Check if the file size is within the allowed limit
          else if (file.size > CourtMaxFileSize) {
            convMortgageeNOCError.textContent =
              "PDF size must be less than 5MB.";
            convMortgageeNOCError.style.display = "block";
            isconvYesMortgagedValid = false;
          } else {
            convMortgageeNOCError.style.display = "none";
          }
        }
      } else {
        convMortgageeNOCError.style.display = "none";
      }

      // 2. Date of NOC
      if (convDateOfNOC.value.trim() === "") {
        convDateOfNOCError.textContent = "Date of NOC is required.";
        convDateOfNOCError.style.display = "block";
        isconvYesMortgagedValid = false;
      } else if (convDateOfNOC.value.trim() > today) {
        convDateOfNOCError.textContent = "Date of NOC cannot be in the future.";
        convDateOfNOCError.style.display = "block";
        convDateOfNOC.value = "";
        isconvYesMortgagedValid = false;
      } else {
        convDateOfNOCError.style.display = "none";
      }

      // 3. Issuing Authority
      if (convMortgageeIssuingAuthority.value.trim() === "") {
        convMortgageeIssuingAuthorityError.textContent =
          "Issuing authority is required.";
        convMortgageeIssuingAuthorityError.style.display = "block";
        isconvYesMortgagedValid = false;
      } else if (!alphaRegex.test(convMortgageeIssuingAuthority.value.trim())) {
        convMortgageeIssuingAuthorityError.textContent =
          "Issuing authority must contain letters only.";
        convMortgageeIssuingAuthorityError.style.display = "block";
        isconvYesMortgagedValid = false;
      } else {
        convMortgageeIssuingAuthorityError.style.display = "none";
      }

      return isconvYesMortgagedValid;
    }

    return true; // Skip validation if "No" is selected
  }

  // commented this function and created new common function for all input date for set max date today by anil on 27-03-2525
  // Apply max date (today) to prevent selecting a future date from the date picker
  // document.addEventListener("DOMContentLoaded", function () {
  //   var today = new Date().toISOString().split("T")[0];

  //   convRegDate.setAttribute("max", today);

  //   convRegDate.addEventListener("blur", validateConvRegDate);
  //   convRegDate.addEventListener("change", validateConvRegDate);
  // });

  function validateForm1Conv() {
    var isCoapplicantConversionValid = coapplicantConRepeaterForm();
    var isConvExecutedNameValid = validateConvExecutedfavour();
    var isConvExecutedOnAsOnLeaseDate = validateConvExecutedOnAsOnLeaseDate();
    var isConvRegno = validateConvRegOn();
    var isConvBookno = validateConvBookno();
    var isConvVolumeno = validateConvVolumeno();
    var isConvRegDate = validateConvRegDate();
    var isConvPagenoFrom = validateConvPagenoFrom();
    var isConvPagenoTo = validateConvPagenoTo();
    var isConvCourtOrderFields = validateConvCourtOrderFields();
    var isConvYesMortgaged = validateConvYesMortgaged();
    var isStatusOfApplicantValid = validateStatusOfApplicant();

    return (
      isCoapplicantConversionValid &&
      isConvExecutedNameValid &&
      isConvExecutedOnAsOnLeaseDate &&
      isConvRegno &&
      isConvBookno &&
      isConvVolumeno &&
      isConvRegDate &&
      isConvPagenoFrom &&
      isConvPagenoTo &&
      isConvCourtOrderFields &&
      isConvYesMortgaged &&
      isStatusOfApplicantValid
    );
  }

  function validateEditConv1() {
    var isCoapplicantConversionValid = coapplicantConRepeaterForm();
    var isConvRegno = validateConvRegOn();
    var isConvBookno = validateConvBookno();
    var isConvVolumeno = validateConvVolumeno();
    var isConvRegDate = validateConvRegDate();
    var isConvPagenoFrom = validateConvPagenoFrom();
    var isConvPagenoTo = validateConvPagenoTo();
    console.log(
      coapplicantConRepeaterForm(),
      validateConvRegOn(),
      validateConvBookno(),
      validateConvVolumeno(),
      validateConvRegDate(),
      validateConvPagenoFrom(),
      validateConvPagenoTo()
    );
    return (
      isCoapplicantConversionValid &&
      isConvRegno &&
      isConvBookno &&
      isConvVolumeno &&
      isConvRegDate &&
      isConvPagenoFrom &&
      isConvPagenoTo
    );
  }

  // function mandatoryMutDocumentsForm() {
  function validateMandatoryConvDocumentsForm() {
    var isMandatoryConvDocumentsFormValid = true;

    // Clear previous error messages before starting new validation
    // $(".text-danger").text(""); // Clear the text inside all error message spans

    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    // Loop through all .items inside #affidavits_repeater
    $("#convDocIndemnityBond_repeater .items").each(function (index, element) {
      let currentIndex = $(this).data("index");
      var convIndemnityBondFile = $(element).find(
        "#convdocindemnitybond_conversion_" +
          currentIndex +
          "_convdocindemnitybond"
      )[0]?.files[0]; // File input
      var convAttestationDate = $(element)
        .find(
          "#convdocindemnitybond_conversion_" +
            currentIndex +
            "_convdocindemnitybonddateofattestation"
        )
        .val();
      var convAttestedBy = $(element)
        .find(
          "#convdocindemnitybond_conversion_" +
            currentIndex +
            "_convdocindemnitybondattestedby"
        )
        .val();

      var isConvIndemnityValid = true;

      // Skip validation based on custom condition
      if (
        $(element)
          .find(
            "#convdocindemnitybond_conversion_" +
              currentIndex +
              "_convdocindemnitybond"
          )
          .attr("data-should-validate") !== "1"
      ) {
        // return true; // Skip validation and continue to the next item // commented by anil for not in use and keeping the file validation here
        // Validate file input (Always check file size and presence)
        if (!convIndemnityBondFile) {
          isConvIndemnityValid = false;
          $(element)
            .find(
              "#convdocindemnitybond_conversion_" +
                currentIndex +
                "_convdocindemnitybond"
            )
            .siblings(".text-danger")
            .text("Indemnity bond file is required.");
        } else {
          if (!convIndemnityBondFile.name.endsWith(".pdf")) {
            isConvIndemnityValid = false;
            $(element)
              .find(
                "#convdocindemnitybond_conversion_" +
                  currentIndex +
                  "_convdocindemnitybond"
              )
              .siblings(".text-danger")
              .text("Only PDF files are allowed.");
          }
          // Validate file size (5MB limit)
          else if (convIndemnityBondFile.size > 5 * 1024 * 1024) {
            isConvIndemnityValid = false;
            $(element)
              .find(
                "#convdocindemnitybond_conversion_" +
                  currentIndex +
                  "_convdocindemnitybond"
              )
              .siblings(".text-danger")
              .text("File size must be less than 5MB.");
          } else {
            // If the date is valid, clear the error message
            $(element)
              .find(
                "#convdocindemnitybond_conversion_" +
                  currentIndex +
                  "_convdocindemnitybond"
              )
              .siblings(".text-danger")
              .text(""); // Clear the error message
          }
        }
      }

      // Validate attestation date (No future dates)
      if (!convAttestationDate) {
        isConvIndemnityValid = false;
        $(element)
          .find(
            "#convdocindemnitybond_conversion_" +
              currentIndex +
              "_convdocindemnitybonddateofattestation"
          )
          .siblings(".text-danger")
          .text("Date of attestation is required.");
      } else if (convAttestationDate > today) {
        isConvIndemnityValid = false;
        $(element)
          .find(
            "#convdocindemnitybond_conversion_" +
              currentIndex +
              "_convdocindemnitybonddateofattestation"
          )
          .siblings(".text-danger")
          .text("Future date is not allowed.");
      } else {
        // If the date is valid, clear the error message
        $(element)
          .find(
            "#convdocindemnitybond_conversion_" +
              currentIndex +
              "_convdocindemnitybonddateofattestation"
          )
          .siblings(".text-danger")
          .text(""); // Clear the error message
      }

      // Validate "attested by" field (Check if it contains valid text)
      if (!convAttestedBy) {
        isConvIndemnityValid = false;
        $(element)
          .find(
            "#convdocindemnitybond_conversion_" +
              currentIndex +
              "_convdocindemnitybondattestedby"
          )
          .siblings(".text-danger")
          .text("Attested by is required.");
      } else if (!/^[A-Za-z\s.]+$/.test(convAttestedBy)) {
        // Check if it contains only alphabets and spaces
        isConvIndemnityValid = false;
        $(element)
          .find(
            "#convdocindemnitybond_conversion_" +
              currentIndex +
              "_convdocindemnitybondattestedby"
          )
          .siblings(".text-danger")
          .text("Attested by must contain letters only.");
      } else {
        // If Attested by is valid, clear the error message
        $(element)
          .find(
            "#convdocindemnitybond_conversion_" +
              currentIndex +
              "_convdocindemnitybondattestedby"
          )
          .siblings(".text-danger")
          .text("");
      }

      // Ensure the form validation status is updated correctly
      if (!isConvIndemnityValid) {
        isMandatoryConvDocumentsFormValid = false;
      }
    });

    // Loop through all .items inside #indemnityBond_repeater
    $("#convDocUndertaking_repeater .items").each(function (index, element) {
      let currentIndex = $(this).data("index");
      var convIndeBondFile = $(element).find(
        "#convdocundertaking_conversion_" + currentIndex + "_convdocundertaking"
      )[0]?.files[0]; // File input
      var conveIndeAttestationDate = $(element)
        .find(
          "#convdocundertaking_conversion_" +
            currentIndex +
            "_convdocdateofundertaking"
        )
        .val();

      var isConvUndertakingValid = true;

      // Skip validation based on custom condition
      if (
        $(element)
          .find(
            "#convdocundertaking_conversion_" +
              currentIndex +
              "_convdocundertaking"
          )
          .attr("data-should-validate") !== "1"
      ) {
        // return true; // Skip validation and continue to the next item // commented by anil for not in use and keeping the file validation here
        // Validate "Indemnity Bond" input field
        if (!convIndeBondFile) {
          isConvUndertakingValid = false;
          $(element)
            .find(
              "#convdocundertaking_conversion_" +
                currentIndex +
                "_convdocundertaking"
            )
            .siblings(".text-danger")
            .text("Undertaking file required."); // changed error text as per your note
        } else {
          if (!convIndeBondFile.name.endsWith(".pdf")) {
            isConvUndertakingValid = false;
            $(element)
              .find(
                "#convdocundertaking_conversion_" +
                  currentIndex +
                  "_convdocundertaking"
              )
              .siblings(".text-danger")
              .text("Only PDF files are allowed.");
          }
          // Validate file size (5MB limit)
          else if (convIndeBondFile.size > 5 * 1024 * 1024) {
            isConvUndertakingValid = false;
            $(element)
              .find(
                "#convdocundertaking_conversion_" +
                  currentIndex +
                  "_convdocundertaking"
              )
              .siblings(".text-danger")
              .text("File size must be less than 5MB.");
          } else {
            // If the file size is valid, clear the error message
            $(element)
              .find(
                "#convdocundertaking_conversion_" +
                  currentIndex +
                  "_convdocundertaking"
              )
              .siblings(".text-danger")
              .text("");
          }
        }
      }

      // Validate attestation date (No future dates)
      if (!conveIndeAttestationDate) {
        isConvUndertakingValid = false;
        $(element)
          .find(
            "#convdocundertaking_conversion_" +
              currentIndex +
              "_convdocdateofundertaking"
          )
          .siblings(".text-danger")
          .text("Date of attestation is required.");
      } else if (conveIndeAttestationDate > today) {
        isConvUndertakingValid = false;
        $(element)
          .find(
            "#convdocundertaking_conversion_" +
              currentIndex +
              "_convdocdateofundertaking"
          )
          .siblings(".text-danger")
          .text("Future date is not allowed.");
      } else {
        // If the attestation date is valid, clear the error message
        $(element)
          .find(
            "#convdocundertaking_conversion_" +
              currentIndex +
              "_convdocdateofundertaking"
          )
          .siblings(".text-danger")
          .text("");
      }

      // If validation fails, update the form validity status
      if (!isConvUndertakingValid) {
        isMandatoryConvDocumentsFormValid = false;
      }
    });

    // Loop through all .items inside #indemnityBond_repeater
    $("#convDocPropertyPhoto_repeater .items").each(function (index, element) {
      let currentIndex = $(this).data("index");
      var convPropertyBonaFide = $(element).find(
        "#convdocpropertyphoto_conversion_" +
          currentIndex +
          "_convdocpropertyphoto"
      )[0]?.files[0]; // File input

      var isConvPropertyBonaFideValid = true;

      // Skip validation based on custom condition
      if (
        $(element)
          .find(
            "#convdocpropertyphoto_conversion_" +
              currentIndex +
              "_convdocpropertyphoto"
          )
          .attr("data-should-validate") !== "1"
      ) {
        // If the file input should not be validated, skip further validation for this field
        // return true; // Skip validation and continue to the next item // commented by anil for not in use and keeping the file validation here
        // Validate "Indemnity Bond" input field
        if (!convPropertyBonaFide) {
          isConvPropertyBonaFideValid = false;
          $(element)
            .find(
              "#convdocpropertyphoto_conversion_" +
                currentIndex +
                "_convdocpropertyphoto"
            )
            .siblings(".text-danger")
            .text("Property photographs file required.");
        } else {
          if (!convPropertyBonaFide.name.endsWith(".pdf")) {
            isConvPropertyBonaFideValid = false;
            $(element)
              .find(
                "#convdocpropertyphoto_conversion_" +
                  currentIndex +
                  "_convdocpropertyphoto"
              )
              .siblings(".text-danger")
              .text("Only PDF files are allowed.");
          }
          // Validate file size (5MB limit)
          else if (convPropertyBonaFide.size > 5 * 1024 * 1024) {
            isConvPropertyBonaFideValid = false;
            $(element)
              .find(
                "#convdocpropertyphoto_conversion_" +
                  currentIndex +
                  "_convdocpropertyphoto"
              )
              .siblings(".text-danger")
              .text("File size must be less than 5MB.");
          } else {
            // If the file is valid, clear the error message
            $(element)
              .find(
                "#convdocpropertyphoto_conversion_" +
                  currentIndex +
                  "_convdocpropertyphoto"
              )
              .siblings(".text-danger")
              .text("");
          }
        }
      }

      // If validation fails, update the form validity status
      if (!isConvPropertyBonaFideValid) {
        isMandatoryConvDocumentsFormValid = false;
      }
    });

    return isMandatoryConvDocumentsFormValid;
  }

  // // Apply max date restriction to prevent future dates in attestation date fields
  // $(document).ready(function () {
  //   var today = new Date().toISOString().split("T")[0];
  //   let currentIndex = $(this).data("index");

  //   // Set max date for affidavit attestation date inputs
  //   $("#convDocIndemnityBond_repeater").on("input change", "#convdocindemnitybond_conversion_" + currentIndex + "_convdocindemnitybonddateofattestation",
  //     function () {
  //       if ($(this).val() > today) {
  //         $(this).val(""); // Clear future date
  //         $(this).siblings(".text-danger").text("Future date is not allowed.");
  //       } else {
  //         $(this).siblings(".text-danger").text("");
  //       }
  //     }
  //   );

  //   // Set max date for indemnity bond attestation date inputs
  //   $("#indemnityBond_repeater").on( "input change", "#convdocundertaking_conversion_" + currentIndex + "_convdocdateofundertaking",
  //     function () {
  //       if ($(this).val() > today) {
  //         $(this).val(""); // Clear future date
  //         $(this).siblings(".text-danger").text("Future date is not allowed.");
  //       } else {
  //         $(this).siblings(".text-danger").text("");
  //       }
  //     }
  //   );

  //   // Apply max date on document load for existing fields
  //   $("#convdocindemnitybond_conversion_" + currentIndex + "_convdocindemnitybonddateofattestation, #convdocundertaking_conversion_" + currentIndex + "_convdocdateofundertaking").attr("max", today);
  // });

  $(document).ready(function () {
    var today = new Date().toISOString().split("T")[0];

    // Iterate through all elements if they have a data-index
    $("[data-index]").each(function () {
      var currentIndex = $(this).data("index");

      // Set max date for affidavit attestation date inputs
      $("#convDocIndemnityBond_repeater").on(
        "input change",
        "#convdocindemnitybond_conversion_" +
          currentIndex +
          "_convdocindemnitybonddateofattestation",
        function () {
          if ($(this).val() > today) {
            // $(this).val(""); // Clear future date
            $(this)
              .siblings(".text-danger")
              .text("Date cannot be in the future.");
          } else {
            $(this).siblings(".text-danger").text("");
          }
        }
      );

      // Set max date for indemnity bond attestation date inputs
      $("#indemnityBond_repeater").on(
        "input change",
        "#convdocundertaking_conversion_" +
          currentIndex +
          "_convdocdateofundertaking",
        function () {
          if ($(this).val() > today) {
            // $(this).val(""); // Clear future date
            $(this)
              .siblings(".text-danger")
              .text("Date cannot be in the future.");
          } else {
            $(this).siblings(".text-danger").text("");
          }
        }
      );

      // Apply max date on document load for existing fields
      $(
        "#convdocindemnitybond_conversion_" +
          currentIndex +
          "_convdocindemnitybonddateofattestation, #convdocundertaking_conversion_" +
          currentIndex +
          "_convdocdateofundertaking"
      ).attr("max", today);
    });
  });

  // Conversion Form 2 Field
  var convAttestedLetterFile = document.getElementById(
    "convDOcLastSubstitutionLetter"
  );
  var convAttestedLetterDate = document.getElementById("convDocSubLetterDate");

  var convContructionProofType = document.getElementById(
    "convDocContructionProofType"
  );
  var convConstructionProofFile = document.getElementById(
    "convDocProofOfConstruction"
  );
  var convContructionProofDate = document.getElementById(
    "convDocContructionProofDate"
  );
  var convContructionProofIssuing = document.getElementById(
    "convDocContructionProofIssuingAuthority"
  );

  var convPossessionProofType = document.getElementById(
    "convDocPossessionProofType"
  );
  var convPossessionProofFile = document.getElementById(
    "convDocProofOfPossession"
  );
  var convPossessionProofDate = document.getElementById(
    "convDocPossessionProofDate"
  );
  var convPossessionProofIssuing = document.getElementById(
    "convDocPossessionProofIssuingAuthority"
  );

  var convDocLeaseDeedFile = document.getElementById("convDocLeaseDeed");
  var convDocLeaseDeedDoEDate = document.getElementById("convDocLeaseDeedDoE");

  var convMandDocAdhaar = document.getElementById("convDocApplicantAadhaar");
  var convMandDocPan = document.getElementById("convDocApplicantPan");

  var convMandDocAffidavits = document.getElementById("convDocAffidavit");
  var convMandDocADateAttestation = document.getElementById(
    "convDocAffidavitsDateOfAttestation"
  );
  var convMandDocAttestedby = document.getElementById(
    "convDocAffidavitAttestedBy"
  );

  // Conversion Form 2 Error
  var convAttestedLetterFileError = document.getElementById(
    "convDOcLastSubstitutionLetterError"
  );
  var convAttestedLetterDateError = document.getElementById(
    "convDocSubLetterDateError"
  );

  var convContructionProofTypeError = document.getElementById(
    "convDocContructionProofTypeError"
  );
  var convConstructionProofFileError = document.getElementById(
    "convDocProofOfConstructionError"
  );
  var convContructionProofDateError = document.getElementById(
    "convDocContructionProofDateError"
  );
  var convContructionProofIssuingError = document.getElementById(
    "convDocContructionProofIssuingAuthorityError"
  );

  var convPossessionProofTypeError = document.getElementById(
    "convDocPossessionProofTypeError"
  );
  var convPossessionProofFileError = document.getElementById(
    "convDocProofOfPossessionError"
  );
  var convPossessionProofDateError = document.getElementById(
    "convDocPossessionProofDateError"
  );
  var convPossessionProofIssuingError = document.getElementById(
    "convDocPossessionProofIssuingAuthorityError"
  );

  var convDocLeaseDeedFileError = document.getElementById(
    "convDocLeaseDeedError"
  );
  var convDocLeaseDeedDoEDateError = document.getElementById(
    "convDocLeaseDeedDoEError"
  );

  var convMandDocAdhaarError = document.getElementById(
    "convDocApplicantAadhaarError"
  );
  var convMandDocPanError = document.getElementById("convDocApplicantPanError");

  var convMandDocAffidavitsError = document.getElementById(
    "convDocAffidavitError"
  );
  var convMandDocADateAttestationError = document.getElementById(
    "convDocAffidavitsDateOfAttestationError"
  );
  var convMandDocAttestedbyError = document.getElementById(
    "convDocAffidavitAttestedByError"
  );

  function validateConvAttestedLetterFile() {
    if (convAttestedLetterFile.files.length > 0) {
      var file = convAttestedLetterFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        convAttestedLetterFileError.textContent =
          "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        convAttestedLetterFileError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        convAttestedLetterFileError.textContent = "";
        return true;
      }
    } else {
      if (convAttestedLetterFile.getAttribute("data-should-validate") == 1) {
        return true;
      }
      convAttestedLetterFileError.textContent =
        "Substitution/Mutation letter is required.";
      return false;
    }
  }

  function validateConvAttestedLetterDate() {
    var convAttestedLetterDateValue = convAttestedLetterDate.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (convAttestedLetterDateValue === "") {
      convAttestedLetterDateError.textContent =
        "Date of attested letter is required.";
      convAttestedLetterDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (convAttestedLetterDateValue > today) {
      convAttestedLetterDateError.textContent =
        "Date of attested letter cannot be in the future.";
      convAttestedLetterDateError.style.display = "block";
      convAttestedLetterDate.value = ""; // Clear invalid input
      return false;
    }

    convAttestedLetterDateError.style.display = "none";
    return true;
  }

  function validateConvContructionProofType() {
    var convContructionProofTypeValue = convContructionProofType.value.trim();

    if (convContructionProofTypeValue === "") {
      convContructionProofTypeError.textContent =
        "Proof of construction is required.";
      convContructionProofTypeError.style.display = "block";
      return false;
    } else {
      convContructionProofTypeError.style.display = "none";
      return true;
    }
  }

  function validateConvConstructionProofFile() {
    if (convConstructionProofFile.files.length > 0) {
      var file = convConstructionProofFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        convConstructionProofFileError.textContent =
          "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        convConstructionProofFileError.textContent =
          "Only PDF files are allowed.";
        return false;
      } else {
        convConstructionProofFileError.textContent = "";
        return true;
      }
    } else {
      if (convConstructionProofFile.getAttribute("data-should-validate") == 1) {
        return true;
      }
      convConstructionProofFileError.textContent =
        "Proof of construction PDF is required.";
      return false;
    }
  }

  function validateConvContructionProofDate() {
    var convContructionProofDateValue = convContructionProofDate.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (convContructionProofDateValue === "") {
      convContructionProofDateError.textContent =
        "Proof of construction date is required.";
      convContructionProofDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (convContructionProofDateValue > today) {
      convContructionProofDateError.textContent =
        "Proof of construction date cannot be in the future.";
      convContructionProofDateError.style.display = "block";
      convContructionProofDate.value = ""; // Clear invalid input
      return false;
    }

    convContructionProofDateError.style.display = "none";
    return true;
  }

  function validateConvContructionProofIssuing() {
    var convContructionProofIssuingValue =
      convContructionProofIssuing.value.trim();
    if (convContructionProofIssuingValue === "") {
      convContructionProofIssuingError.textContent =
        "Issuing authority is required.";
      convContructionProofIssuingError.style.display = "block";
      return false;
    }
    var convContructionAlpha = /^[A-Za-z\s.-]+$/;
    if (!convContructionAlpha.test(convContructionProofIssuingValue)) {
      convContructionProofIssuingError.textContent =
        "Issuing authority must contain letters only.";
      convContructionProofIssuingError.style.display = "block";
      return false;
    } else {
      convContructionProofIssuingError.style.display = "none";
      return true;
    }
  }

  function validateConvPossessionProofType() {
    var validateConvPossessionProofTypeValue =
      convPossessionProofType.value.trim();

    if (validateConvPossessionProofTypeValue === "") {
      convPossessionProofTypeError.textContent =
        "Proof of possession is required.";
      convPossessionProofTypeError.style.display = "block";
      return false;
    } else {
      convPossessionProofTypeError.style.display = "none";
      return true;
    }
  }

  function validateConvPossessionProofFile() {
    if (convPossessionProofFile.files.length > 0) {
      var file = convPossessionProofFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        convPossessionProofFileError.textContent =
          "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        convPossessionProofFileError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        convPossessionProofFileError.textContent = "";
        return true;
      }
    } else {
      if (convPossessionProofFile.getAttribute("data-should-validate") == 1) {
        return true;
      }
      convPossessionProofFileError.textContent =
        "Proof of possession PDF is required.";
      return false;
    }
  }

  function validateConvPossessionProofDate() {
    var convPossessionProofDateValue = convPossessionProofDate.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (convPossessionProofDateValue === "") {
      convPossessionProofDateError.textContent =
        "Proof of possession date is required.";
      convPossessionProofDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (convPossessionProofDateValue > today) {
      convPossessionProofDateError.textContent =
        "Proof of possession date cannot be in the future.";
      convPossessionProofDateError.style.display = "block";
      convPossessionProofDate.value = ""; // Clear invalid input
      return false;
    }

    convPossessionProofDateError.style.display = "none";
    return true;
  }

  function validateConvPossessionProofIssuing() {
    var convPossessionProofIssuingValue =
      convPossessionProofIssuing.value.trim();
    if (convPossessionProofIssuingValue === "") {
      convPossessionProofIssuingError.textContent =
        "Issuing authority is required.";
      convPossessionProofIssuingError.style.display = "block";
      return false;
    }
    var convContructionAlpha = /^[A-Za-z\s.-]+$/;
    if (!convContructionAlpha.test(convPossessionProofIssuingValue)) {
      convPossessionProofIssuingError.textContent =
        "Issuing authority must contain letters only.";
      convPossessionProofIssuingError.style.display = "block";
      return false;
    } else {
      convPossessionProofIssuingError.style.display = "none";
      return true;
    }
  }

  function validateConvDocLeaseDeedFile() {
    if (convDocLeaseDeedFile.files.length > 0) {
      var file = convDocLeaseDeedFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        convDocLeaseDeedFileError.textContent =
          "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        convDocLeaseDeedFileError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        convDocLeaseDeedFileError.textContent = "";
        return true;
      }
    } else {
      if (convDocLeaseDeedFile.getAttribute("data-should-validate") == 1) {
        return true;
      }
      convDocLeaseDeedFileError.textContent =
        "Registered lease deed is required.";
      return false;
    }
  }

  function validateConvDocLeaseDeedDoEDate() {
    var convDocLeaseDeedDoEDateValue = convDocLeaseDeedDoEDate.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (convDocLeaseDeedDoEDateValue === "") {
      convDocLeaseDeedDoEDateError.textContent =
        "Date of execution is required.";
      convDocLeaseDeedDoEDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (convDocLeaseDeedDoEDateValue > today) {
      convDocLeaseDeedDoEDateError.textContent =
        "Date of execution cannot be in the future.";
      convDocLeaseDeedDoEDateError.style.display = "block";
      convDocLeaseDeedDoEDate.value = ""; // Clear invalid input
      return false;
    }

    convDocLeaseDeedDoEDateError.style.display = "none";
    return true;
  }

  function validateConvMandDocAdhaar() {
    if (convMandDocAdhaar.files.length > 0) {
      var file = convMandDocAdhaar.files[0];
      if (file.size > 5 * 1024 * 1024) {
        convMandDocAdhaarError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        convMandDocAdhaarError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        convMandDocAdhaarError.textContent = "";
        return true;
      }
    } else {
      if (convMandDocAdhaar.getAttribute("data-should-validate") == 1) {
        return true;
      }
      convMandDocAdhaarError.textContent = "Aadhaar PDF is required.";
      return false;
    }
  }

  function validateConvMandDocPan() {
    if (convMandDocPan.files.length > 0) {
      var file = convMandDocPan.files[0];
      if (file.size > 5 * 1024 * 1024) {
        convMandDocPanError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        convMandDocPanError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        convMandDocPanError.textContent = "";
        return true;
      }
    } else {
      if (convMandDocPan.getAttribute("data-should-validate") == 1) {
        return true;
      }
      convMandDocPanError.textContent = "PAN PDF is required.";
      return false;
    }
  }

  function validateConvMandDocAffidavits() {
    if (convMandDocAffidavits.files.length > 0) {
      var file = convMandDocAffidavits.files[0];
      if (file.size > 5 * 1024 * 1024) {
        convMandDocAffidavitsError.textContent =
          "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        convMandDocAffidavitsError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        convMandDocAffidavitsError.textContent = "";
        return true;
      }
    } else {
      if (convMandDocAffidavits.getAttribute("data-should-validate") == 1) {
        return true;
      }
      convMandDocAffidavitsError.textContent =
        "Court affidavit PDF is required.";
      return false;
    }
  }

  function validateConvMandDocADateAttestation() {
    var convMandDocADateAttestationValue =
      convMandDocADateAttestation.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (convMandDocADateAttestationValue === "") {
      convMandDocADateAttestationError.textContent =
        "Date of attestation is required.";
      convMandDocADateAttestationError.style.display = "block";
      return false;
    }

    // Future date validation
    if (convMandDocADateAttestationValue > today) {
      convMandDocADateAttestationError.textContent =
        "Date of attestation cannot be in the future.";
      convMandDocADateAttestationError.style.display = "block";
      convMandDocADateAttestation.value = ""; // Clear invalid input
      return false;
    }

    convMandDocADateAttestationError.style.display = "none";
    return true;
  }

  function validateConvMandDocAttestedby() {
    var convMandDocAttestedbyValue = convMandDocAttestedby.value.trim();
    if (convMandDocAttestedbyValue === "") {
      convMandDocAttestedbyError.textContent = "Attested by is required.";
      convMandDocAttestedbyError.style.display = "block";
      return false;
    }
    var convAttestedbyAlpha = /^[A-Za-z\s.]+$/;
    if (!convAttestedbyAlpha.test(convMandDocAttestedbyValue)) {
      convMandDocAttestedbyError.textContent =
        "Attested by must contain letters only.";
      convMandDocAttestedbyError.style.display = "block";
      return false;
    } else {
      convMandDocAttestedbyError.style.display = "none";
      return true;
    }
  }

  // commented this function and created new common function for all input date for set max date today by anil on 27-03-2525
  // Apply max date restriction to prevent future dates in date fields
  // document.addEventListener("DOMContentLoaded", function () {
  //   var today = new Date().toISOString().split("T")[0];

  //   // Set max date for date inputs
  //   convAttestedLetterDate.setAttribute("max", today);
  //   convContructionProofDate.setAttribute("max", today);
  //   convPossessionProofDate.setAttribute("max", today);
  //   convDocLeaseDeedDoEDate.setAttribute("max", today);
  //   convMandDocADateAttestation.setAttribute("max", today);

  //   // Validate on blur and change to prevent manual future date entry
  //   convAttestedLetterDate.addEventListener(
  //     "blur",
  //     validateConvAttestedLetterDate
  //   );
  //   convAttestedLetterDate.addEventListener(
  //     "change",
  //     validateConvAttestedLetterDate
  //   );

  //   convContructionProofType.addEventListener(
  //     "change",
  //     validateConvContructionProofType
  //   );
  //   convContructionProofDate.addEventListener(
  //     "blur",
  //     validateConvContructionProofDate
  //   );
  //   convContructionProofDate.addEventListener(
  //     "change",
  //     validateConvContructionProofDate
  //   );

  //   convPossessionProofDate.addEventListener(
  //     "blur",
  //     validateConvPossessionProofDate
  //   );
  //   convPossessionProofDate.addEventListener(
  //     "change",
  //     validateConvPossessionProofDate
  //   );

  //   convDocLeaseDeedDoEDate.addEventListener(
  //     "blur",
  //     validateConvDocLeaseDeedDoEDate
  //   );
  //   convDocLeaseDeedDoEDate.addEventListener(
  //     "change",
  //     validateConvDocLeaseDeedDoEDate
  //   );

  //   convMandDocADateAttestation.addEventListener(
  //     "blur",
  //     validateConvMandDocADateAttestation
  //   );
  //   convMandDocADateAttestation.addEventListener(
  //     "change",
  //     validateConvMandDocADateAttestation
  //   );
  // });

  function validateForm2Conv() {
    var isMandatoryConvDocumentsFormValid =
      validateMandatoryConvDocumentsForm();
    var isConvAttestedLetterFileValid = validateConvAttestedLetterFile();
    var isConvAttestedLetterDateValid = validateConvAttestedLetterDate();
    var isConvContructionProofType = validateConvContructionProofType();
    var isConvConstructionProofFile = validateConvConstructionProofFile();
    var isConvContructionProofDate = validateConvContructionProofDate();
    var isConvContructionProofIssuing = validateConvContructionProofIssuing();
    var isConvPossessionProofType = validateConvPossessionProofType();
    var isConvPossessionProofFile = validateConvPossessionProofFile();
    var isConvPossessionProofDate = validateConvPossessionProofDate();
    var isConvPossessionProofIssuing = validateConvPossessionProofIssuing();
    var isConvDocLeaseDeedFile = validateConvDocLeaseDeedFile();
    var isConvDocLeaseDeedDoEDate = validateConvDocLeaseDeedDoEDate();
    var isConvMandDocAdhaar = validateConvMandDocAdhaar();
    var isConvMandDocPan = validateConvMandDocPan();
    var isConvMandDocAffidavits = validateConvMandDocAffidavits();
    var isConvMandDocADateAttestation = validateConvMandDocADateAttestation();
    var isConvMandDocAttestedby = validateConvMandDocAttestedby();

    return (
      isMandatoryConvDocumentsFormValid &&
      isConvAttestedLetterFileValid &&
      isConvAttestedLetterDateValid &&
      isConvContructionProofType &&
      isConvConstructionProofFile &&
      isConvContructionProofDate &&
      isConvContructionProofIssuing &&
      isConvPossessionProofType &&
      isConvPossessionProofFile &&
      isConvPossessionProofDate &&
      isConvPossessionProofIssuing &&
      isConvDocLeaseDeedFile &&
      isConvDocLeaseDeedDoEDate &&
      isConvMandDocAdhaar &&
      isConvMandDocPan &&
      isConvMandDocAffidavits &&
      isConvMandDocADateAttestation &&
      isConvMandDocAttestedby
    );
  }

  // conversion step 3 form validation

  var convLesseeAliveAffidevitFile = document.getElementById(
    "convOptLesseeAliveAffidevit"
  );
  var convLesseeAliveAffidevitDate = document.getElementById(
    "convOptLesseeAliveAffidevitDocumentDate"
  );
  var convLesseeAliveAttestedby = document.getElementById(
    "convOptLesseeAliveAffidevitAttestedby"
  );

  var convYesLeaseDeedLost = document.getElementById("isLeaseDeedLostYes");
  var convNoLeaseDeedLost = document.getElementById("isLeaseDeedLostNo");
  var convLeaseLostAffidevitFile = document.getElementById(
    "convOptLeaseLostAffidevit"
  );
  var convLeaseLostAffidevitDate = document.getElementById(
    "convLeaseLostAffidevitDocumentDate"
  );
  var convLeaseLostAttestedBy = document.getElementById(
    "convLeaseLostAffidevitAttestedBy"
  );
  var convLeaseLostNoticeFile = document.getElementById(
    "convOptLeaseLostPublicNotice"
  );
  var convLeaseLostNameOfNewspaper = document.getElementById(
    "convOptLeaseLostPublicNoticeNameOfNewspaper"
  );

  var convAgreeConsentCheck = document.getElementById("agreeConsentConversion");

  // Conv step 3 Erros
  var convLesseeAliveAffidevitFileError = document.getElementById(
    "convOptLesseeAliveAffidevitError"
  );
  var convLesseeAliveAffidevitDateError = document.getElementById(
    "convOptLesseeAliveAffidevitDocumentDateError"
  );
  var convLesseeAliveAttestedbyError = document.getElementById(
    "convOptLesseeAliveAffidevitAttestedbyError"
  );

  var convLeaseLostAffidevitFileError = document.getElementById(
    "convOptLeaseLostAffidevitError"
  );
  var convLeaseLostAffidevitDateError = document.getElementById(
    "convLeaseLostAffidevitDocumentDateError"
  );
  var convLeaseLostAttestedByError = document.getElementById(
    "convLeaseLostAffidevitAttestedByError"
  );
  var convLeaseLostNoticeFileError = document.getElementById(
    "convOptLeaseLostPublicNoticeError"
  );
  var convLeaseLostNameOfNewspaperError = document.getElementById(
    "convOptLeaseLostPublicNoticeNameOfNewspaperError"
  );

  var convAgreeConsentCheckError = document.getElementById(
    "agreeConsentConversionError"
  );

  function validateConvLesseeAliveAffidevitGroup() {
    const fileInput = convLesseeAliveAffidevitFile;
    const dateInput = convLesseeAliveAffidevitDate;
    const attestedInput = convLesseeAliveAttestedby;

    const fileSelected = fileInput.files.length > 0;
    const shouldValidateFile =
      fileInput.getAttribute("data-should-validate") == "1";

    // Determine if we should trigger full validation
    const shouldTriggerFullValidation =
      fileSelected ||
      shouldValidateFile ||
      dateInput.value.trim() !== "" ||
      attestedInput.value.trim() !== "";

    let isAliveLesseeValid = true;

    // --- FILE VALIDATION ---
    if (fileSelected) {
      const file = fileInput.files[0];
      if (file.size > 5 * 1024 * 1024) {
        convLesseeAliveAffidevitFileError.textContent =
          "File size must be less than 5 MB.";
        isAliveLesseeValid = false;
      } else if (!file.name.endsWith(".pdf")) {
        convLesseeAliveAffidevitFileError.textContent =
          "Only PDF files are allowed.";
        isAliveLesseeValid = false;
      } else {
        convLesseeAliveAffidevitFileError.textContent = "";
      }
    } else if (!shouldValidateFile && shouldTriggerFullValidation) {
      convLesseeAliveAffidevitFileError.textContent =
        "Affidavit PDF is required.";
      isAliveLesseeValid = false;
    } else {
      convLesseeAliveAffidevitFileError.textContent = "";
    }

    // --- DATE VALIDATION ---
    const dateVal = dateInput.value.trim();
    const today = new Date().toISOString().split("T")[0];
    if (shouldTriggerFullValidation) {
      if (dateVal === "") {
        convLesseeAliveAffidevitDateError.textContent =
          "Date of document is required.";
        convLesseeAliveAffidevitDateError.style.display = "block";
        isAliveLesseeValid = false;
      } else if (dateVal > today) {
        convLesseeAliveAffidevitDateError.textContent =
          "Date of document cannot be in the future.";
        convLesseeAliveAffidevitDateError.style.display = "block";
        dateInput.value = "";
        isAliveLesseeValid = false;
      } else {
        convLesseeAliveAffidevitDateError.style.display = "none";
      }
    } else {
      convLesseeAliveAffidevitDateError.textContent = "";
      convLesseeAliveAffidevitDateError.style.display = "none";
    }

    // --- ATTESTED BY VALIDATION ---
    const attestedVal = attestedInput.value.trim();
    if (shouldTriggerFullValidation) {
      if (attestedVal === "") {
        convLesseeAliveAttestedbyError.textContent = "Attested by is required.";
        convLesseeAliveAttestedbyError.style.display = "block";
        isAliveLesseeValid = false;
      } else if (!/^[A-Za-z\s.]+$/.test(attestedVal)) {
        convLesseeAliveAttestedbyError.textContent =
          "Attested by must contain letters only.";
        convLesseeAliveAttestedbyError.style.display = "block";
        isAliveLesseeValid = false;
      } else {
        convLesseeAliveAttestedbyError.style.display = "none";
      }
    } else {
      convLesseeAliveAttestedbyError.textContent = "";
      convLesseeAliveAttestedbyError.style.display = "none";
    }

    return isAliveLesseeValid;
  }

  function validateConvYesLeaseDeedLostFields() {
    const alphaRegex = /^[A-Za-z\s.]+$/;
    const CourtMaxFileSize = 5 * 1024 * 1024; // 5MB
    const today = new Date().toISOString().split("T")[0]; // YYYY-MM-DD

    if (convYesLeaseDeedLost.checked) {
      let isconvYesLeaseDeedLostValid = true;

      // 1. Validate Lease deed Affidevit File
      if (
        convLeaseLostAffidevitFile.getAttribute("data-should-validate") != "1"
      ) {
        if (
          convLeaseLostAffidevitFile.files.length === 0 ||
          convLeaseLostAffidevitFile.value.trim() === ""
        ) {
          convLeaseLostAffidevitFileError.textContent =
            "Lease deed affidavit PDF file is required.";
          convLeaseLostAffidevitFileError.style.display = "block";
          isconvYesLeaseDeedLostValid = false;
        } else {
          const file = convLeaseLostAffidevitFile.files[0];

          // Check if the file is a PDF
          if (file.type !== "application/pdf") {
            convLeaseLostAffidevitFileError.textContent =
              "Only PDF files are allowed.";
            convLeaseLostAffidevitFileError.style.display = "block";
            isconvYesLeaseDeedLostValid = false;
          }
          // Check if the file size is within the allowed limit
          else if (file.size > CourtMaxFileSize) {
            convLeaseLostAffidevitFileError.textContent =
              "PDF size must be less than 5MB.";
            convLeaseLostAffidevitFileError.style.display = "block";
            isconvYesLeaseDeedLostValid = false;
          } else {
            convLeaseLostAffidevitFileError.style.display = "none";
          }
        }
      } else {
        convLeaseLostAffidevitFileError.style.display = "none";
      }

      // 2. Validate Lease deed Affidevit Date
      if (convLeaseLostAffidevitDate.value.trim() === "") {
        convLeaseLostAffidevitDateError.textContent =
          "Lease deed affidavit date is required.";
        convLeaseLostAffidevitDateError.style.display = "block";
        isconvYesLeaseDeedLostValid = false;
      } else if (convLeaseLostAffidevitDate.value.trim() > today) {
        convLeaseLostAffidevitDateError.textContent =
          "Lease deed affidavit cannot be in the future.";
        convLeaseLostAffidevitDateError.style.display = "block";
        convLeaseLostAffidevitDate.value = ""; // Clear invalid input
        isconvYesLeaseDeedLostValid = false;
      } else {
        convLeaseLostAffidevitDateError.style.display = "none";
      }

      // 3. Validate Attested By
      if (convLeaseLostAttestedBy.value.trim() === "") {
        convLeaseLostAttestedByError.textContent = "Attested by is required.";
        convLeaseLostAttestedByError.style.display = "block";
        isconvYesLeaseDeedLostValid = false;
      } else if (!alphaRegex.test(convLeaseLostAttestedBy.value.trim())) {
        convLeaseLostAttestedByError.textContent =
          "Attested by must contain letters only.";
        convLeaseLostAttestedByError.style.display = "block";
        isconvYesLeaseDeedLostValid = false;
      } else {
        convLeaseLostAttestedByError.style.display = "none";
      }

      // 4. Validate Public Notice File
      if (convLeaseLostNoticeFile.getAttribute("data-should-validate") != "1") {
        if (
          convLeaseLostNoticeFile.files.length === 0 ||
          convLeaseLostNoticeFile.value.trim() === ""
        ) {
          convLeaseLostNoticeFileError.textContent =
            "Public notice PDF is required.";
          convLeaseLostNoticeFileError.style.display = "block";
          isconvYesLeaseDeedLostValid = false;
        } else {
          const file = convLeaseLostNoticeFile.files[0];

          // Check if the file is a PDF
          if (file.type !== "application/pdf") {
            convLeaseLostNoticeFileError.textContent =
              "Only PDF files are allowed.";
            convLeaseLostNoticeFileError.style.display = "block";
            isconvYesLeaseDeedLostValid = false;
          }
          // Check if the file size is within the allowed limit
          else if (file.size > CourtMaxFileSize) {
            convLeaseLostNoticeFileError.textContent =
              "PDF size must be less than 5MB.";
            convLeaseLostNoticeFileError.style.display = "block";
            isconvYesLeaseDeedLostValid = false;
          } else {
            convLeaseLostNoticeFileError.style.display = "none";
          }
        }
      } else {
        convLeaseLostNoticeFileError.style.display = "none";
      }

      // 5. Validate Name of Newspaper
      if (convLeaseLostNameOfNewspaper.value.trim() === "") {
        convLeaseLostNameOfNewspaperError.textContent =
          "Name of newspaper is required.";
        convLeaseLostNameOfNewspaperError.style.display = "block";
        isconvYesLeaseDeedLostValid = false;
      } else if (!alphaRegex.test(convLeaseLostNameOfNewspaper.value.trim())) {
        convLeaseLostNameOfNewspaperError.textContent =
          "Newspaper name must contain letters only.";
        convLeaseLostNameOfNewspaperError.style.display = "block";
        isconvYesLeaseDeedLostValid = false;
      } else {
        convLeaseLostNameOfNewspaperError.style.display = "none";
      }

      return isconvYesLeaseDeedLostValid;
    }

    return true; // If "No" is selected, skip validation
  }

  function validateConvAgreeConsent() {
    if (!convAgreeConsentCheck.checked) {
      convAgreeConsentCheckError.textContent =
        "Please accept terms & conditions.";
      convAgreeConsentCheckError.style.display = "block";
      return false;
    } else {
      convAgreeConsentCheckError.style.display = "none";
      return true;
    }
  }

  // commented this function and created new common function for all input date for set max date today by anil on 27-03-2525
  // Apply max date restriction to prevent future dates in date fields
  // document.addEventListener("DOMContentLoaded", function () {
  //   var today = new Date().toISOString().split("T")[0];

  //   // Set max date for date inputs
  //   convLesseeAliveAffidevitDate.setAttribute("max", today);

  //   // Validate on blur and change to prevent manual future date entry
  //   convLesseeAliveAffidevitDate.addEventListener(
  //     "blur",
  //     validateConvLesseeAliveAffidevitDate
  //   );
  //   convLesseeAliveAffidevitDate.addEventListener(
  //     "change",
  //     validateConvLesseeAliveAffidevitDate
  //   );
  // });

  function validateForm3Conv() {
    // var isConvLesseeAliveAffidevitFile = validateConvLesseeAliveAffidevitFile();
    // var isConvLesseeAliveAffidevitDate = validateConvLesseeAliveAffidevitDate();
    // var isConvLesseeAliveAttestedby = validateConvLesseeAliveAttestedby();
    var isConvLesseeAliveAffidevitGroup =
      validateConvLesseeAliveAffidevitGroup();
    var isConvYesLeaseDeedLostFields = validateConvYesLeaseDeedLostFields();
    var isConvAgreeConsent = validateConvAgreeConsent();
    var isAppOtherDoc = validateAppOtherDoc("CONVERSION-3");
    let isPoAValid = validatePOADoc("CONVERSION-3");

    return (
      // isConvLesseeAliveAffidevitFile &&
      // isConvLesseeAliveAffidevitDate &&
      // isConvLesseeAliveAttestedby &&
      isConvLesseeAliveAffidevitGroup &&
      isConvYesLeaseDeedLostFields &&
      isConvAgreeConsent &&
      isAppOtherDoc &&
      isPoAValid
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
        affidavitsError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        affidavitsError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        affidavitsError.textContent = "";
        return true;
      }
    } else {
      if (affidavits.getAttribute("data-should-validate") == 1) {
        return true;
      }
      affidavitsError.textContent = "Affidavit is required.";
      return false;
    }
  }
  function validateDateofAffidavits() {
    var affidavitsDateAttestationValue = affidavitsDateAttestation.value.trim();
    if (affidavitsDateAttestationValue === "") {
      dateattestationError.textContent = "Date of attestation is required.";
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
      attestedbyError.textContent = "Attested by is required.";
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
        indemnityBondError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        indemnityBondError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        indemnityBondError.textContent = "";
        return true;
      }
    } else {
      if (indemnityBond.getAttribute("data-should-validate") == 1) {
        return true;
      }
      indemnityBondError.textContent = "Indemnity bond is required.";
      return false;
    }
  }
  function validateIndemnityDateofAttestation() {
    var indemnityBonddateattestationValue =
      indemnityBonddateattestation.value.trim();
    if (indemnityBonddateattestationValue === "") {
      indemnityBonddateattestationError.textContent =
        "Date of attestation is required.";
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
      indemnityBondattestedbyError.textContent = "Attested by is required.";
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
        leaseconyedeedError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        leaseconyedeedError.textContent = "Only PDF files are allowed.";
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
        "Lease deed/Conveyance deed is required.";
      return false;
    }
  }
  function validateDateofExecution() {
    var dateofexecutionValue = dateofexecution.value.trim();
    if (dateofexecutionValue === "") {
      dateofexecutionError.textContent = "Date of execution is required.";
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
      lesseenameError.textContent = "Lessee name is required.";
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
        pannumberError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        pannumberError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        pannumberError.textContent = "";
        return true;
      }
    } else {
      if (pannumber.getAttribute("data-should-validate") == 1) {
        return true;
      }
      pannumberError.textContent = "PAN is required.";
      return false;
    }
  }
  function validatePANCertification() {
    var pancertificatenoValue = pancertificateno.value.trim();
    if (pancertificatenoValue === "") {
      pancertificatenoError.textContent = "Certificate number is required.";
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
      pandateissueError.textContent = "Date of issue is required.";
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
        aadharnumberError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        aadharnumberError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        aadharnumberError.textContent = "";
        return true;
      }
    } else {
      if (aadharnumber.getAttribute("data-should-validate") == 1) {
        return true;
      }
      aadharnumberError.textContent = "Aadhar is required.";
      return false;
    }
  }
  function validateAadharCertification() {
    var aadharcertificatenoValue = aadharcertificateno.value.trim();
    if (aadharcertificatenoValue === "") {
      aadharcertificatenoError.textContent = "Certificate number is required.";
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
      aadhardateissueError.textContent = "Date of issue is required.";
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
          "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        publicNoticeEnglishError.textContent = "Only PDF files are allowed.";
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
        "Public notice in national daily (English) is required.";
      return false;
    }
  }

  function validateNewsPaperNameEnglish() {
    var newspapernameenglighValue = newspaperNameEnglish.value.trim();
    if (newspapernameenglighValue === "") {
      newspaperNameEnglishError.textContent =
        "Name of newspaper(English) is required.";
      newspaperNameEnglishError.style.display = "block";
      return false;
    }
    var newsEnglishAlpha = /^[A-Za-z\s]+$/;
    if (!newsEnglishAlpha.test(newspapernameenglighValue)) {
      newspaperNameEnglishError.textContent =
        "Newspaper name must contain letters only.";
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
        "Date of public notice is required.";
      publicNoticeDateEnglishError.style.display = "block";
      return false;
    }

    // Future date validation
    if (publicnoticedateValue > today) {
      publicNoticeDateEnglishError.textContent =
        "Date cannot be in the future.";
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
        publicNoticeHindiError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        publicNoticeHindiError.textContent = "Only PDF files are allowed.";
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
        "Public notice in national daily (Hindi) is required.";
      return false;
    }
  }

  function validateNewsPaperNameHindi() {
    var newspaperNameHindiValue = newspaperNameHindi.value.trim();
    if (newspaperNameHindiValue === "") {
      newspaperNameHindiError.textContent =
        "Name of newspaper(Hindi) is required.";
      newspaperNameHindiError.style.display = "block";
      return false;
    }
    var newsEnglishAlpha = /^[A-Za-z\s]+$/;
    if (!newsEnglishAlpha.test(newspaperNameHindiValue)) {
      newspaperNameHindiError.textContent =
        "Newspaper name must contain letters only.";
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
        "Date of public notice is required.";
      publicNoticeDateHindiError.style.display = "block";
      return false;
    }

    // Future date validation
    if (publicnoticedateValue > today) {
      publicNoticeDateHindiError.textContent =
        "Date cannot be in the future.";
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
        propertyPhotoError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        propertyPhotoError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        propertyPhotoError.textContent = "";
        return true;
      }
    } else {
      if (propertyPhoto.getAttribute("data-should-validate") == 1) {
        return true;
      }
      propertyPhotoError.textContent = "Property photo is required.";
      return false;
    }
  }

  // commented this function and created new common function for all input date for set max date today by anil on 27-03-2525
  // Apply max date restriction to prevent future dates in public notice date fields
  // document.addEventListener("DOMContentLoaded", function () {
  //   var today = new Date().toISOString().split("T")[0];

  //   // Set max date for public notice date inputs
  //   publicNoticeDateEnglish.setAttribute("max", today);
  //   publicNoticeDateHindi.setAttribute("max", today);

  //   // Validate on blur and change to prevent manual future date entry
  //   publicNoticeDateEnglish.addEventListener(
  //     "blur",
  //     validatePublicNoteDateEnglish
  //   );
  //   publicNoticeDateEnglish.addEventListener(
  //     "change",
  //     validatePublicNoteDateEnglish
  //   );

  //   publicNoticeDateHindi.addEventListener("blur", validatePublicNoteDateHindi);
  //   publicNoticeDateHindi.addEventListener(
  //     "change",
  //     validatePublicNoteDateHindi
  //   );
  // });

  // Validate Form 2 MUT
  function validateForm2MUT() {
    // var isAffidavitsValid = validateAffidavits();
    // var isDateofAffidavitsValid = validateDateofAffidavits();
    // var isAttestedByAffidavitsValid = validateAttestedByAffidavits();

    // var isIndemnityBondValid = validateIndemnityBond();
    // var isIndemnityDateofAttestationValid = validateIndemnityDateofAttestation();
    // var isIndemnityAttestedByValid = validateIndemnityAttestedBy();

    var isMandatoryMutDocumentsForm = validateMandatoryMutDocumentsForm();

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

      isMandatoryMutDocumentsForm &&
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

  // Sale deed Mutaition form step 3 add by anil on 17-02-2025 for validation
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
  // Sale deed Mutaition form step 3 add by anil on 17-02-2025 for validation

  // Regd. Will deed Mutaition form step 3 add by anil on 18-02-2025 for validation
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
  // Regd. Will deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Unregd. Will deed Mutaition form step 3 add by anil on 20-02-2025 for validation
  var muteUnregdWillFile = document.getElementById("unregdWillCodocil");
  var muteUnregdWillTestatorName = document.getElementById(
    "unregWillCodicilTestatorName"
  );
  var muteUnregdWillDate = document.getElementById(
    "unregWillCodicilDateOfWillCodicil"
  );
  // Unregd. Will deed Mutaition form step 3 add by anil on 20-02-2025 for validation

  // Registered Relinquishment deed Mutaition form step 3 add by anil on 18-02-2025 for validation
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
  // Registered Relinquishment deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Gift deed Mutaition form step 3 add by anil on 18-02-2025 for validation
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
  // Gift deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Surviving Member Certificate Mutaition form step 3 add by anil on 18-02-2025 for validation
  var muteSmcFile = document.getElementById("survivingMemberCertificate");
  var muteSmcCertificateNo = document.getElementById("smcCertificateNo");
  var muteSmcDateOfIssue = document.getElementById("smcDateOfIssue");
  // Surviving Member Certificate Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation
  // var muteSbpFile = document.getElementById("sanctionBuildingPlan");
  // var muteSbpDateOfIssue = document.getElementById("sbpDateOfIssue");
  // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Propate/LOA/Court Decree/Order Mutaition form step 3 add by anil on 15-05-2025 for validation
  var mutePropateFile = document.getElementById("propateLoaCourtDecreeOrder");
  // Propate/LOA/Court Decree/Order Mutaition form step 3 add by anil on 15-05-2025 for validation

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

  // Sale deed Mutaition form step 3 add by anil on 17-02-2025 for validation
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
  // Sale deed Mutaition form step 3 add by anil on 17-02-2025 for validation

  // Regd. Will deed Mutaition form step 3 add by anil on 18-02-2025 for validation
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
  // Regd. Will deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Unregd. Will deed Mutaition form step 3 add by anil on 20-02-2025 for validation
  var muteUnregdWillFileError = document.getElementById(
    "unregdWillCodocilError"
  );
  var muteUnregdWillTestatorNameError = document.getElementById(
    "unregWillCodicilTestatorNameError"
  );
  var muteUnregdWillDateError = document.getElementById(
    "unregWillCodicilDateOfWillCodicilError"
  );
  // Unregd. Will deed Mutaition form step 3 add by anil on 20-02-2025 for validation

  // Registered Relinquishment deed Mutaition form step 3 add by anil on 18-02-2025 for validation
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
  // Registered Relinquishment deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Gift deed Mutaition form step 3 add by anil on 18-02-2025 for validation
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
  // Gift deed Mutaition form step 3 add by anil on 18-02-2025 for validation

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
  // var muteSbpFileError = document.getElementById("sanctionBuildingPlanError");
  // var muteSbpDateOfIssueError = document.getElementById("sbpDateOfIssueError");
  // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Propate/LOA/Court Decree/Order Mutaition form step 3 add by anil on 15-05-2025 for validation
  var mutePropateFileError = document.getElementById("propateLoaCourtDecreeOrderError");
  // Propate/LOA/Court Decree/Order Mutaition form step 3 add by anil on 15-05-2025 for validation

  // Any Other Document Mutaition form step 3 add by anil on 18-02-2025 for validation
  // var muteAodFileError = document.getElementById("anyOtherDocumentError");
  // var muteAodRemarkError = document.getElementById("otherDocumentRemarkError");
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
          "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteDethCertificateError.textContent = "Only PDF files are allowed.";
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
        "Death certificate PDF file is required.";
      return false;
    }
  }

  function validateMuteDethDeceaseName() {
    var muteDethDeceaseNameValue = muteDethDeceaseName.value.trim();

    // Check if the input is empty
    if (muteDethDeceaseNameValue === "") {
      muteDethDeceaseNameError.textContent = "Name of deceased is required.";
      muteDethDeceaseNameError.style.display = "block";
      return false;
    }

    // Check if the input contains only alphabets
    var alphaPattern = /^[A-Za-z\s]+$/;
    if (!alphaPattern.test(muteDethDeceaseNameValue)) {
      muteDethDeceaseNameError.textContent = "Name must contain letters only.";
      muteDethDeceaseNameError.style.display = "block";
      return false;
    }

    // If all validations pass
    muteDethDeceaseNameError.style.display = "none";
    return true;
  }

  function validateMuteDethDate() {
    var muteDethDateValue = muteDethDate.value.trim();
    var muteDethCertificateIssueDateValue =
      muteDethCertificateIssueDate.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (muteDethDateValue === "") {
      muteDethDateError.textContent = "Date of death is required.";
      muteDethDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteDethDateValue > today) {
      muteDethDateError.textContent = "Date of death cannot be in the future.";
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
        "Date of death cannot be after the certificate issue date.";
      muteDethDateError.style.display = "block";
      muteDethDate.value = ""; // Clear invalid input
      return false;
    }

    muteDethDateError.style.display = "none";
    return true;
  }

  function validateMuteDethCertificateIssueDate() {
    var muteDethCertificateIssueDateValue =
      muteDethCertificateIssueDate.value.trim();
    var muteDethDateValue = muteDethDate.value.trim();
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    if (muteDethCertificateIssueDateValue === "") {
      muteDethCertificateIssueDateError.textContent =
        "Certificate issue date is required.";
      muteDethCertificateIssueDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteDethCertificateIssueDateValue > today) {
      muteDethCertificateIssueDateError.textContent =
        "Certificate issue date cannot be in the future.";
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
        "Certificate date cannot be before the date of death.";
      muteDethCertificateIssueDateError.style.display = "block";
      muteDethCertificateIssueDate.value = ""; // Clear invalid input
      return false;
    }

    muteDethCertificateIssueDateError.style.display = "none";
    return true;
  }

  function validateMuteDethCertificateNumber() {
    var muteDethCertificateNumberValue = muteDethCertificateNumber.value.trim();
    var allowedPattern = /^[A-Za-z0-9:\/\-\s]+$/;
    if (muteDethCertificateNumberValue === "") {
      muteDethCertificateNumberError.textContent =
        "Death certificate number is required.";
      muteDethCertificateNumberError.style.display = "block";
      return false;
    } else if (!allowedPattern.test(muteDethCertificateNumberValue)) {
      muteDethCertificateNumberError.textContent =
        "Only letters, numbers, and : - / are allowed.";
      muteDethCertificateNumberError.style.display = "block";
      return false;
    } else {
      muteDethCertificateNumberError.style.display = "none";
    }
    return true;
  }
  // Death Certificate Mutaition form step 3  add by anil on 17-02-2025 for validation

  // Sale deed Mutaition form step 3 add by anil on 17-02-2025 for validation
  function validateMuteSaleDeed() {
    if (muteSaleDeed.files.length > 0) {
      var file = muteSaleDeed.files[0];
      if (file.size > 5 * 1024 * 1024) {
        muteSaleDeedError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteSaleDeedError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        muteSaleDeedError.textContent = "";
        return true;
      }
    } else {
      if (muteSaleDeed.getAttribute("data-should-validate") == 1) {
        return true;
      }
      muteSaleDeedError.textContent = "Sale deed PDF file is required.";
      return false;
    }
  }

  function validateMuteSaleDeedRegno() {
    var muteSaleDeedRegnoValue = muteSaleDeedRegno.value.trim();

    // Check if input is empty
    if (muteSaleDeedRegnoValue === "") {
      muteSaleDeedRegnoError.textContent = "Deed registration number is required.";
      muteSaleDeedRegnoError.style.display = "block";
      return false;
    }

    // Check if input exceeds 30 digits
    if (muteSaleDeedRegnoValue.length > 30) {
      muteSaleDeedRegnoError.textContent = "Registration number cannot exceed 30 digits.";
      muteSaleDeedRegnoError.style.display = "block";
      return false;
    }

    // Check if input is numeric only
    if (!/^\d+$/.test(muteSaleDeedRegnoValue)) {
      muteSaleDeedRegnoError.textContent = "Registration number must be a numeric value.";
      muteSaleDeedRegnoError.style.display = "block";
      return false;
    }

    // All validations passed
    muteSaleDeedRegnoError.style.display = "none";
    return true;
  }
  function validateMuteSaleDeedVolume() {
    var muteSaleDeedVolumeValue = muteSaleDeedVolume.value.trim();

    // Check if the field is empty
    if (muteSaleDeedVolumeValue === "") {
      muteSaleDeedVolumeError.textContent = "Volume number is required.";
      muteSaleDeedVolumeError.style.display = "block";
      return false;
    }

    
    // Check if the value is numeric
    if (!/^\d+$/.test(muteSaleDeedVolumeValue)) {
      muteSaleDeedVolumeError.textContent =
        "Volume number must be a numeric value.";
      muteSaleDeedVolumeError.style.display = "block";
      return false;
    }

    // Check if the value is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteSaleDeedVolumeValue) <= 0) {
      muteSaleDeedVolumeError.textContent = "Volume must be a positive number.";
      muteSaleDeedVolumeError.style.display = "block";
      return false;
    }

    // Check if the number exceeds 10 digits
    if (muteSaleDeedVolumeValue.length > 10) {
      muteSaleDeedVolumeError.textContent = "Volume number cannot exceed 10 digits.";
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
      muteSaleDeedBookNoError.textContent = "Book number is required.";
      muteSaleDeedBookNoError.style.display = "block";
      return false;
    }
    
    // Check if the Book number is numeric
    if (!/^\d+$/.test(muteSaleDeedBookNoValue)) {
      muteSaleDeedBookNoError.textContent = "Book number must be a numeric value.";
      muteSaleDeedBookNoError.style.display = "block";
      return false;
    }

    // Check if the Book number is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteSaleDeedBookNoValue) <= 0) {
      muteSaleDeedBookNoError.textContent =
        "Book number must be a positive number.";
      muteSaleDeedBookNoError.style.display = "block";
      return false;
    }

    // Check if the Book number exceeds 10 digits
    if (muteSaleDeedBookNoValue.length > 10) {
      muteSaleDeedBookNoError.textContent = "Book number cannot exceed 10 digits.";
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
      muteSaleDeedFromError.textContent = "Page number from is required.";
      muteSaleDeedFromError.style.display = "block";
      return false;
    }
    
    // Check if the value is numeric
    if (!/^\d+$/.test(muteSaleDeedFromValue)) {
      muteSaleDeedFromError.textContent =
        "Page number from must be a numeric value.";
      muteSaleDeedFromError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteSaleDeedFromValue) <= 0) {
      muteSaleDeedFromError.textContent =
        "Page number from must be a positive number.";
      muteSaleDeedFromError.style.display = "block";
      return false;
    }

    // Check if the Page number Max 4 digits
    if (muteSaleDeedFromValue.length > 4) {
      muteSaleDeedFromError.textContent = "Page number cannot exceed 4 digits.";
      muteSaleDeedFromError.style.display = "block";
      return false;
    }

    // Check if 'Page number From' is greater than 'Page number To'
    if (parseInt(muteSaleDeedFromValue) > parseInt(muteSaleDeedValueTo)) {
      muteSaleDeedFromError.textContent =
        "Page number from cannot be greater than page number to.";
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
      muteSaleDeedToError.textContent = "Page number to is required.";
      muteSaleDeedToError.style.display = "block";
      // Check the value
      return false;
    }
    
    // Check if the value is numeric
    if (!/^\d+$/.test(muteSaleDeedToValue)) {
      muteSaleDeedToError.textContent = "Page number to must be a numeric value.";
      muteSaleDeedToError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteSaleDeedToValue) <= 0) {
      muteSaleDeedToError.textContent = "Page number to must be a positive number.";
      muteSaleDeedToError.style.display = "block";
      return false;
    }

    // Check if the Page number Max 4 digits
    if (muteSaleDeedToValue.length > 4) {
      muteSaleDeedToError.textContent = "Page number cannot exceed 4 digits.";
      muteSaleDeedToError.style.display = "block";
      return false;
    }

    // Check if 'Page number To' is less than 'Page number From'
    if (parseInt(muteSaleDeedToValue) < parseInt(muteSaleDeedValueFrom)) {
      muteSaleDeedToError.textContent =
        "Page number to cannot be less than page number from.";
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
      muteSaleDeedRegDateError.textContent = "Registration date is required.";
      muteSaleDeedRegDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteSaleDeedRegDateValue > today) {
      muteSaleDeedRegDateError.textContent =
        "Registration date cannot be in the future.";
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
        "Registration office name is required.";
      muteSaleDeedRegOfficeNameError.style.display = "block";
      return false;
    } else {
      muteSaleDeedRegOfficeNameError.style.display = "none";
    }

    // Check if the value contains only alphabetic characters, dot and spaces
    var regex = /^[A-Za-z\s.]+$/;
    if (!regex.test(muteSaleDeedRegOfficeNameValue)) {
      muteSaleDeedRegOfficeNameError.textContent =
        "Registration office name must contain letters only.";
      muteSaleDeedRegOfficeNameError.style.display = "block";
      return false;
    } else {
      muteSaleDeedRegOfficeNameError.style.display = "none";
    }
    return true;
  }
  // Sale deed Mutaition form step 3 add by anil on 17-02-2025 for validation

  // Regd. Will deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  function validateMuteWillRegdFile() {
    if (muteWillRegdFile.files.length > 0) {
      var file = muteWillRegdFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        muteWillRegdFileError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteWillRegdFileError.textContent = "Only PDF files are allowed.";
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
        "Will/Codicil deed PDF file is required.";
      return false;
    }
  }

  function validateMuteWillTestatorName() {
    var muteWillTestatorNameValue = muteWillTestatorName.value.trim();
    if (muteWillTestatorNameValue === "") {
      muteWillTestatorNameError.textContent = "Testator name is required.";
      muteWillTestatorNameError.style.display = "Block";
      return false;
    }

    // Check if the value contains only alphabetic characters and spaces
    var testNameAlpha = /^[A-Za-z\s]+$/;
    if (!testNameAlpha.test(muteWillTestatorNameValue)) {
      muteWillTestatorNameError.textContent =
        "Testator name must contain letters only.";
      muteWillTestatorNameError.style.display = "block";
      return false;
    } else {
      muteWillTestatorNameError.style.display = "none";
    }
    return true;
  }

  function validateMuteWillRegno() {
  var muteWillRegnoValue = muteWillRegno.value.trim();

  // Check if the field is empty
  if (muteWillRegnoValue === "") {
    muteWillRegnoError.textContent = "Will/Codicil registration number is required.";
    muteWillRegnoError.style.display = "block";
    return false;
  }

  // Check if the value exceeds 30 digits
  if (muteWillRegnoValue.length > 30) {
    muteWillRegnoError.textContent = "Registration number cannot exceed 30 digits.";
    muteWillRegnoError.style.display = "block";
    return false;
  }

  // Check if the value contains only digits (no spaces, no letters)
  if (!/^\d+$/.test(muteWillRegnoValue)) {
    muteWillRegnoError.textContent = "Registration number must be a numeric value.";
    muteWillRegnoError.style.display = "block";
    return false;
  }

  // Passed all checks
  muteWillRegnoError.style.display = "none";
  return true;
}

  function validateMuteWillVolume() {
    var muteWillVolumeValue = muteWillVolume.value.trim();

    // Check if the field is empty
    if (muteWillVolumeValue === "") {
      muteWillVolumeError.textContent = "Volume number is required.";
      muteWillVolumeError.style.display = "block";
      return false;
    }
    
    // Check if the value is numeric
    if (!/^\d+$/.test(muteWillVolumeValue)) {
      muteWillVolumeError.textContent = "Volume number must be a numeric value.";
      muteWillVolumeError.style.display = "block";
      return false;
    }

    // Check if the value is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteWillVolumeValue) <= 0) {
      muteWillVolumeError.textContent = "Volume must be a positive number.";
      muteWillVolumeError.style.display = "block";
      return false;
    }

    // Check if the number exceeds 10 digits
    if (muteWillVolumeValue.length > 10) {
      muteWillVolumeError.textContent = "Volume number cannot exceed 10 digits.";
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
      muteWillBookNoError.textContent = "Book number is required.";
      muteWillBookNoError.style.display = "block";
      return false;
    }
    
    // Check if the Book number is numeric
    if (!/^\d+$/.test(muteWillBookNoValue)) {
      muteWillBookNoError.textContent = "Book number must be a numeric value.";
      muteWillBookNoError.style.display = "block";
      return false;
    }

    // Check if the Book number is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteWillBookNoValue) <= 0) {
      muteWillBookNoError.textContent = "Book number must be a positive number.";
      muteWillBookNoError.style.display = "block";
      return false;
    }

    // Check if the Book number exceeds 10 digits
    if (muteWillBookNoValue.length > 10) {
      muteWillBookNoError.textContent = "Book number cannot exceed 10 digits.";
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
      muteWillFromError.textContent = "Page number from is required.";
      muteWillFromError.style.display = "block";
      return false;
    }
    
    // Check if the value is numeric
    if (!/^\d+$/.test(muteWillFromValue)) {
      muteWillFromError.textContent = "Page number from must be a numeric value.";
      muteWillFromError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteWillFromValue) <= 0) {
      muteWillFromError.textContent = "Page number from must be a positive number.";
      muteWillFromError.style.display = "block";
      return false;
    }

    // Check if the Page number Max 4 digits
    if (muteWillFromValue.length > 4) {
      muteWillFromError.textContent = "Page number cannot exceed 4 digits.";
      muteWillFromError.style.display = "block";
      return false;
    }

    // Check if 'Page number From' is greater than 'Page number To'
    if (parseInt(muteWillFromValue) > parseInt(muteWillValueTo)) {
      muteWillFromError.textContent = "Page number from cannot be greater than page number to.";
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
      muteWillToError.textContent = "Page number to is required.";
      muteWillToError.style.display = "block";
      return false;
    }
    
    // Check if the value is numeric
    if (!/^\d+$/.test(muteWillToValue)) {
      muteWillToError.textContent = "Page number to must be a numeric value.";
      muteWillToError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteWillToValue) <= 0) {
      muteWillToError.textContent = "Page number to must be a positive number.";
      muteWillToError.style.display = "block";
      return false;
    }

    // Check if the Page number Max 4 digits
    if (muteWillToValue.length > 4) {
      muteWillToError.textContent = "Page number cannot exceed 4 digits.";
      muteWillToError.style.display = "block";
      return false;
    }

    // Check if 'Page number To' is less than 'Page number From'
    if (parseInt(muteWillToValue) < parseInt(muteWillValueFrom)) {
      muteWillToError.textContent =
        "Page number to cannot be less than page number from.";
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
      muteWillRegDateError.textContent = "Date of registration is required.";
      muteWillRegDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteWillRegDateValue > today) {
      muteWillRegDateError.textContent =
        "Date of registration cannot be in the future.";
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
        "Registration office name is required.";
      muteWillRegOfficeNameError.style.display = "block";
      return false;
    }
    var RegOfficeAlpha = /^[A-Za-z\s.]+$/;
    if (!RegOfficeAlpha.test(muteWillRegOfficeNameValue)) {
      muteWillRegOfficeNameError.textContent =
        "Attested by must contain letters only.";
      muteWillRegOfficeNameError.style.display = "block";
      return false;
    } else {
      muteWillRegOfficeNameError.style.display = "none";
    }

    // Check if the value contains only alphabetic characters and spaces
    // var willNameAlpha = /^[A-Za-z\s]+$/;
    // if (!willNameAlpha.test(muteWillRegOfficeNameValue)) {
    //   muteWillRegOfficeNameError.textContent =
    //     "Registration office name must contain letters only.";
    //   muteWillRegOfficeNameError.style.display = "block";
    //   return false;
    // } else {
    //   muteWillRegOfficeNameError.style.display = "none";
    // }
    return true;
  }
  // Regd. Will deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Unregd. Will deed Mutaition form step 3 add by anil on 20-02-2025 for validation
  function validateMuteUnregdWillFile() {
    if (muteUnregdWillFile.files.length > 0) {
      var file = muteUnregdWillFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        muteUnregdWillFileError.textContent =
          "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteUnregdWillFileError.textContent = "Only PDF files are allowed.";
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
        "Unregd. will/codicil deed PDF file is required.";
      return false;
    }
  }

  function validateMuteUnregdWillTestatorName() {
    var muteUnregdWillTestatorNameValue =
      muteUnregdWillTestatorName.value.trim();
    if (muteUnregdWillTestatorNameValue === "") {
      muteUnregdWillTestatorNameError.textContent = "Testator name is required.";
      muteUnregdWillTestatorNameError.style.display = "Block";
      return false;
    }

    // Check if the value contains only alphabetic characters and spaces
    var testNameAlpha = /^[A-Za-z\s]+$/;
    if (!testNameAlpha.test(muteUnregdWillTestatorNameValue)) {
      muteUnregdWillTestatorNameError.textContent =
        "Testator name must contain letters only.";
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
      muteUnregdWillDateError.textContent = "Date of registration is required.";
      muteUnregdWillDateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteUnregdWillDateValue > today) {
      muteUnregdWillDateError.textContent =
        "Date of registration cannot be in the future.";
      muteUnregdWillDateError.style.display = "block";
      muteUnregdWillDate.value = ""; // Clear invalid input
      return false;
    }

    muteUnregdWillDateError.style.display = "none";
    return true;
  }
  // Unregd. Will deed Mutaition form step 3 add by anil on 20-02-2025 for validation

  // Registered Relinquishment deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  function validateMuteRelinquishDeedFile() {
    if (muteRelinquishDeedFile.files.length > 0) {
      var file = muteRelinquishDeedFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        muteRelinquishDeedFileError.textContent =
          "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteRelinquishDeedFileError.textContent = "Only PDF files are allowed.";
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
        "Relinquishment deed PDF file is required.";
      return false;
    }
  }

  function validateMuteRelinquishDeedReleaserName() {
    var muteRelinquishDeedReleaserNameValue =
      muteRelinquishDeedReleaserName.value.trim();
    if (muteRelinquishDeedReleaserNameValue === "") {
      muteRelinquishDeedReleaserNameError.textContent =
        "Releaser name is required.";
      muteRelinquishDeedReleaserNameError.style.display = "Block";
      return false;
    }

    // Check if the value contains only alphabetic characters and spaces
    var releaserNameAlpha = /^[A-Za-z\s]+$/;
    if (!releaserNameAlpha.test(muteRelinquishDeedReleaserNameValue)) {
      muteRelinquishDeedReleaserNameError.textContent =
        "Releaser name must contain letters only.";
      muteRelinquishDeedReleaserNameError.style.display = "block";
      return false;
    } else {
      muteRelinquishDeedReleaserNameError.style.display = "none";
    }
    return true;
  }

  function validateMuteRelinquishDeedRegNo() {
    var muteRelinquishDeedRegNoValue = muteRelinquishDeedRegNo.value.trim();

    // Check if the field is empty
    if (muteRelinquishDeedRegNoValue === "") {
      muteRelinquishDeedRegNoError.textContent =
        "Relinquishment registration number is required.";
      muteRelinquishDeedRegNoError.style.display = "block";
      return false;
    }

    // Check if it exceeds 30 digits
    if (muteRelinquishDeedRegNoValue.length > 30) {
      muteRelinquishDeedRegNoError.textContent =
        "Registration number cannot exceed 30 digits.";
      muteRelinquishDeedRegNoError.style.display = "block";
      return false;
    }

    // Check if it is only numeric (no spaces or letters)
    if (!/^\d+$/.test(muteRelinquishDeedRegNoValue)) {
      muteRelinquishDeedRegNoError.textContent =
        "Registration number must be a numeric value.";
      muteRelinquishDeedRegNoError.style.display = "block";
      return false;
    }

    // All validations passed
    muteRelinquishDeedRegNoError.style.display = "none";
    return true;
  }


  function validateMuteRelinquishDeedVolume() {
    var muteRelinquishDeedVolumeValue = muteRelinquishDeedVolume.value.trim();

    // Check if the field is empty
    if (muteRelinquishDeedVolumeValue === "") {
      muteRelinquishDeedVolumeError.textContent = "Volume number is required.";
      muteRelinquishDeedVolumeError.style.display = "block";
      return false;
    }
    
    // Check if the value is numeric
    if (!/^\d+$/.test(muteRelinquishDeedVolumeValue)) {
      muteRelinquishDeedVolumeError.textContent =
        "Volume number must be a numeric value.";
      muteRelinquishDeedVolumeError.style.display = "block";
      return false;
    }

    // Check if the value is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteRelinquishDeedVolumeValue) <= 0) {
      muteRelinquishDeedVolumeError.textContent =
        "Volume must be a positive number.";
      muteRelinquishDeedVolumeError.style.display = "block";
      return false;
    }

    // Check if the number exceeds 10 digits
    if (muteRelinquishDeedVolumeValue.length > 10) {
      muteRelinquishDeedVolumeError.textContent = "Volume number cannot exceed 10 digits.";
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
      muteRelinquishDeedBooknoError.textContent = "Book number is required.";
      muteRelinquishDeedBooknoError.style.display = "block";
      return false;
    }
    
    // Check if the Book number is numeric
    if (!/^\d+$/.test(muteRelinquishDeedBooknoValue)) {
      muteRelinquishDeedBooknoError.textContent =
        "Book number must be a numeric value.";
      muteRelinquishDeedBooknoError.style.display = "block";
      return false;
    }

    // Check if the Book number is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteRelinquishDeedBooknoValue) <= 0) {
      muteRelinquishDeedBooknoError.textContent =
        "Book number must be a positive number.";
      muteRelinquishDeedBooknoError.style.display = "block";
      return false;
    }

    // Check if the Book number exceeds 10 digits
    if (muteRelinquishDeedBooknoValue.length > 10) {
      muteRelinquishDeedBooknoError.textContent = "Book number cannot exceed 10 digits.";
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
      muteRelinquishDeedFromError.textContent = "Page number from is required.";
      muteRelinquishDeedFromError.style.display = "block";
      return false;
    }
    
    // Check if the value is numeric
    if (!/^\d+$/.test(muteRelinquishDeedFromValue)) {
      muteRelinquishDeedFromError.textContent =
        "Page number from must be a numeric value.";
      muteRelinquishDeedFromError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteRelinquishDeedFromValue) <= 0) {
      muteRelinquishDeedFromError.textContent =
        "Page number from must be a positive number.";
      muteRelinquishDeedFromError.style.display = "block";
      return false;
    }

    // Check if the Page number Max 4 digits
    if (muteRelinquishDeedFromValue.length > 4) {
      muteRelinquishDeedFromError.textContent = "Page number cannot exceed 4 digits.";
      muteRelinquishDeedFromError.style.display = "block";
      return false;
    }

    // Check if 'Page number From' is greater than 'Page number To'
    if (
      parseInt(muteRelinquishDeedFromValue) >
      parseInt(muteRelinquishDeedValueTo)
    ) {
      muteRelinquishDeedFromError.textContent =
        "Page number from cannot be greater than page number to.";
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
      muteRelinquishDeedToError.textContent = "Page number to is required.";
      muteRelinquishDeedToError.style.display = "block";
      return false;
    }
    
    // Check if the value is numeric
    if (!/^\d+$/.test(muteRelinquishDeedToValue)) {
      muteRelinquishDeedToError.textContent =
        "Page number to must be a numeric value.";
      muteRelinquishDeedToError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteRelinquishDeedToValue) <= 0) {
      muteRelinquishDeedToError.textContent =
        "Page number to must be a positive number.";
      muteRelinquishDeedToError.style.display = "block";
      return false;
    }

    // Check if the Page number Max 4 digits
    if (muteRelinquishDeedToValue.length > 4) {
      muteRelinquishDeedToError.textContent = "Page number cannot exceed 4 digits.";
      muteRelinquishDeedToError.style.display = "block";
      return false;
    }

    // Check if 'Page number To' is less than 'Page number From'
    if (
      parseInt(muteRelinquishDeedToValue) <
      parseInt(muteRelinquishDeedValueFrom)
    ) {
      muteRelinquishDeedToError.textContent =
        "Page number to cannot be less than page number from.";
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
        "Date of registration is required.";
      muteRelinquishDeedRegdateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteRelinquishDeedRegdateValue > today) {
      muteRelinquishDeedRegdateError.textContent =
        "Date of registration cannot be in the future.";
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
        "Registration office name is required.";
      muteRelinquishDeedRegnameError.style.display = "block";
      return false;
    } else {
      muteRelinquishDeedRegnameError.style.display = "none";
    }

    // Check if the value contains only alphabetic characters and spaces
    var willNameAlpha = /^[A-Za-z\s.]+$/;
    if (!willNameAlpha.test(muteRelinquishDeedRegnameValue)) {
      muteRelinquishDeedRegnameError.textContent =
        "Registration office name must contain letters only.";
      muteRelinquishDeedRegnameError.style.display = "block";
      return false;
    } else {
      muteRelinquishDeedRegnameError.style.display = "none";
    }
    return true;
  }
  // Registered Relinquishment deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Gift deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  function validateMuteGiftDeedFile() {
    if (muteGiftDeedFile.files.length > 0) {
      var file = muteGiftDeedFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        muteGiftDeedFileError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteGiftDeedFileError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        muteGiftDeedFileError.textContent = "";
        return true;
      }
    } else {
      if (muteGiftDeedFile.getAttribute("data-should-validate") == 1) {
        return true;
      }
      muteGiftDeedFileError.textContent = "Gift deed PDF file is required.";
      return false;
    }
  }

  function validateMuteGiftDeedRegno() {
    var muteGiftDeedRegnoValue = muteGiftDeedRegno.value.trim();

    // Check if the field is empty
    if (muteGiftDeedRegnoValue === "") {
      muteGiftDeedRegnoError.textContent =
        "Gift deed registration number is required.";
      muteGiftDeedRegnoError.style.display = "block";
      return false;
    }

    // Check if it exceeds 30 digits
    if (muteGiftDeedRegnoValue.length > 30) {
      muteGiftDeedRegnoError.textContent =
        "Registration number cannot exceed 30 digits.";
      muteGiftDeedRegnoError.style.display = "block";
      return false;
    }

    // Check if it contains only digits (no spaces or letters)
    if (!/^\d+$/.test(muteGiftDeedRegnoValue)) {
      muteGiftDeedRegnoError.textContent =
        "Gift deed registration number must be numeric.";
      muteGiftDeedRegnoError.style.display = "block";
      return false;
    }

    // All validations passed
    muteGiftDeedRegnoError.style.display = "none";
    return true;
  }

  function validateMuteGiftDeedVolume() {
    var muteGiftDeedVolumeValue = muteGiftDeedVolume.value.trim();

    // Check if the field is empty
    if (muteGiftDeedVolumeValue === "") {
      muteGiftDeedVolumeError.textContent = "Volume number is required.";
      muteGiftDeedVolumeError.style.display = "block";
      return false;
    }
    
    // Check if the value is numeric
    if (!/^\d+$/.test(muteGiftDeedVolumeValue)) {
      muteGiftDeedVolumeError.textContent =
        "Volume number must be a numeric value.";
      muteGiftDeedVolumeError.style.display = "block";
      return false;
    }

    // Check if the value is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteGiftDeedVolumeValue) <= 0) {
      muteGiftDeedVolumeError.textContent = "Volume must be a positive number.";
      muteGiftDeedVolumeError.style.display = "block";
      return false;
    }

    // Check if the number exceeds 10 digits
    if (muteGiftDeedVolumeValue.length > 10) {
      muteGiftDeedVolumeError.textContent = "Volume number cannot exceed 10 digits.";
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
      muteGiftDeedBooknoError.textContent = "Book number is required.";
      muteGiftDeedBooknoError.style.display = "block";
      return false;
    }
    
    // Check if the Book number is numeric
    if (!/^\d+$/.test(muteGiftDeedBooknoValue)) {
      muteGiftDeedBooknoError.textContent = "Book number must be a numeric value.";
      muteGiftDeedBooknoError.style.display = "block";
      return false;
    }

    // Check if the Book number is a positive number (optional, if you want to restrict to positive values)
    if (parseFloat(muteGiftDeedBooknoValue) <= 0) {
      muteGiftDeedBooknoError.textContent =
        "Book number must be a positive number.";
      muteGiftDeedBooknoError.style.display = "block";
      return false;
    }

    // Check if the Book number exceeds 10 digits
    if (muteGiftDeedBooknoValue.length > 10) {
      muteGiftDeedBooknoError.textContent = "Book number cannot exceed 10 digits.";
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
      muteGiftDeedFromError.textContent = "Page number from is required.";
      muteGiftDeedFromError.style.display = "block";
      return false;
    }
    
    // Check if the value is numeric
    if (!/^\d+$/.test(muteGiftDeedFromValue)) {
      muteGiftDeedFromError.textContent =
        "Page number from must be a numeric value.";
      muteGiftDeedFromError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteGiftDeedFromValue) <= 0) {
      muteGiftDeedFromError.textContent =
        "Page number from must be a positive number.";
      muteGiftDeedFromError.style.display = "block";
      return false;
    }

    // Check if the Page number Max 4 digits
    if (muteGiftDeedFromValue.length > 4) {
      muteGiftDeedFromError.textContent = "Page number cannot exceed 4 digits.";
      muteGiftDeedFromError.style.display = "block";
      return false;
    }
    
    // Check if 'Page number From' is greater than 'Page number To'
    if (parseInt(muteGiftDeedFromValue) > parseInt(muteGiftDeedValueTo)) {
      muteGiftDeedFromError.textContent =
        "Page number from cannot be greater than page number to.";
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
      muteGiftDeedToError.textContent = "Page number to is required.";
      muteGiftDeedToError.style.display = "block";
      return false;
    }
    
    // Check if the value is numeric
    if (!/^\d+$/.test(muteGiftDeedToValue)) {
      muteGiftDeedToError.textContent = "Page number to must be a numeric value.";
      muteGiftDeedToError.style.display = "block";
      return false;
    }

    // Check if the value is positive
    if (parseFloat(muteGiftDeedToValue) <= 0) {
      muteGiftDeedToError.textContent = "Page number to must be a positive number.";
      muteGiftDeedToError.style.display = "block";
      return false;
    }

    // Check if the Page number Max 4 digits
    if (muteGiftDeedToValue.length > 4) {
      muteGiftDeedToError.textContent = "Page number cannot exceed 4 digits.";
      muteGiftDeedToError.style.display = "block";
      return false;
    }

    // Check if 'Page number To' is less than 'Page number From'
    if (parseInt(muteGiftDeedToValue) < parseInt(muteGiftDeedValueFrom)) {
      muteGiftDeedToError.textContent =
        "Page number to cannot be less than page number from.";
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
      muteGiftDeedRegdateError.textContent = "Date of registration is required.";
      muteGiftDeedRegdateError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteGiftDeedRegdateValue > today) {
      muteGiftDeedRegdateError.textContent =
        "Date of registration cannot be in the future.";
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
        "Registration office name is required.";
      muteGiftDeedRegOfficeNameError.style.display = "block";
      return false;
    } else {
      muteGiftDeedRegOfficeNameError.style.display = "none";
    }

    // Check if the value contains only alphabetic characters and spaces
    var giftNameAlpha = /^[A-Za-z\s.]+$/;
    if (!giftNameAlpha.test(muteGiftDeedRegOfficeNameValue)) {
      muteGiftDeedRegOfficeNameError.textContent =
        "Registration office name must contain letters only.";
      muteGiftDeedRegOfficeNameError.style.display = "block";
      return false;
    } else {
      muteGiftDeedRegOfficeNameError.style.display = "none";
    }
    return true;
  }
  // Gift deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Surviving Member Certificate Mutaition form step 3 add by anil on 18-02-2025 for validation
  function validateMuteSmcFile() {
    if (muteSmcFile.files.length > 0) {
      var file = muteSmcFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        muteSmcFileError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        muteSmcFileError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        muteSmcFileError.textContent = "";
        return true;
      }
    } else {
      if (muteSmcFile.getAttribute("data-should-validate") == 1) {
        return true;
      }
      muteSmcFileError.textContent = "SMC PDF file is required.";
      return false;
    }
  }

  function validateMuteSmcCertificateNo() {
    var muteSmcCertificateNoValue = muteSmcCertificateNo.value.trim();
    var allowedPattern = /^[A-Za-z0-9:\/\-\s]+$/; // Regex allows alphabets, numbers, spaces, and : - /
    if (muteSmcCertificateNoValue === "") {
      muteSmcCertificateNoError.textContent = "SMC certificate number is required.";
      muteSmcCertificateNoError.style.display = "block";
      return false;
    } else if (!allowedPattern.test(muteSmcCertificateNoValue)) {
      muteSmcCertificateNoError.textContent =
        "Only letters, numbers, and : - / are allowed.";
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
      muteSmcDateOfIssueError.textContent = "Date of issue is required.";
      muteSmcDateOfIssueError.style.display = "block";
      return false;
    }

    // Future date validation
    if (muteSmcDateOfIssueValue > today) {
      muteSmcDateOfIssueError.textContent =
        "Date of issue cannot be in the future.";
      muteSmcDateOfIssueError.style.display = "block";
      muteSmcDateOfIssue.value = ""; // Clear invalid input
      return false;
    }

    muteSmcDateOfIssueError.style.display = "none";
    return true;
  }
  // Surviving Member Certificate Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation
  // function validateMuteSbpFile() {
  //   if (muteSbpFile.files.length > 0) {
  //     var file = muteSbpFile.files[0];
  //     if (file.size > 5 * 1024 * 1024) {
  //       muteSbpFileError.textContent = "File size must be less than 5 MB.";
  //       return false;
  //     } else if (!file.name.endsWith(".pdf")) {
  //       muteSbpFileError.textContent = "Only PDF files are allowed.";
  //       return false;
  //     } else {
  //       muteSbpFileError.textContent = "";
  //       return true;
  //     }
  //   } else {
  //     if (muteSbpFile.getAttribute("data-should-validate") == 1) {
  //       return true;
  //     }
  //     muteSbpFileError.textContent = "SBP PDF file is required.";
  //     return false;
  //   }
  // }

  // function validateMuteSbpDateOfIssue() {
  //   var muteSbpDateOfIssueValue = muteSbpDateOfIssue.value.trim();
  //   var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

  //   if (muteSbpDateOfIssueValue === "") {
  //     muteSbpDateOfIssueError.textContent = "Date of issue is required.";
  //     muteSbpDateOfIssueError.style.display = "block";
  //     return false;
  //   }

  //   // Future date validation
  //   if (muteSbpDateOfIssueValue > today) {
  //     muteSbpDateOfIssueError.textContent =
  //       "Date of issue cannot be in the future.";
  //     muteSbpDateOfIssueError.style.display = "block";
  //     muteSbpDateOfIssue.value = ""; // Clear invalid input
  //     return false;
  //   }

  //   muteSbpDateOfIssueError.style.display = "none";
  //   return true;
  // }

  // Propate/LOA/Court Decree/Order Mutaition form step 3 add by anil on 15-05-2025 for validation
  function validateMutePropateFile() {
    if (mutePropateFile.files.length > 0) {
      var file = mutePropateFile.files[0];
      if (file.size > 5 * 1024 * 1024) {
        mutePropateFileError.textContent = "File size must be less than 5 MB.";
        return false;
      } else if (!file.name.endsWith(".pdf")) {
        mutePropateFileError.textContent = "Only PDF files are allowed.";
        return false;
      } else {
        mutePropateFileError.textContent = "";
        return true;
      }
    } else {
      if (mutePropateFile.getAttribute("data-should-validate") == 1) {
        return true;
      }
      mutePropateFileError.textContent = "Propate/LOA/Court Decree/Order PDF file is required.";
      return false;
    }
  }

  // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation

  // Any Other Document Mutaition form step 3 add by anil on 20-02-2025 for validation
  // function validateMuteAod() {
  //   var fileInputAod = muteAodFile.files.length > 0; // Check if a file is selected
  //   var textInputAod = muteAodRemark.value.trim() !== ""; // Check if text input is filled

  //   // Regular expression to allow only the specified characters
  //   var allowedPattern = /^[a-zA-Z0-9@\-_/\"., ]*$/;

  //   // Case 1: Check if the remark contains only allowed characters
  //   if (textInputAod && !allowedPattern.test(muteAodRemark.value)) {
  //     muteAodRemarkError.textContent =
  //       'Only letters, numbers, @, -, _, /, ", ., and space are allowed.';
  //     muteAodRemarkError.style.display = "block";
  //     return false;
  //   } else {
  //     muteAodRemarkError.style.display = "none"; // Hide error if remark is valid
  //   }

  //   // Check file size if a file is uploaded
  //   if (fileInputAod) {
  //     var file = muteAodFile.files[0]; // Get the uploaded file
  //     var maxSize = 5 * 1024 * 1024; // 5 MB in bytes

  //     if (file.size > maxSize) {
  //       // muteAodFile.classList.add("is-invalid");
  //       muteAodFileError.textContent = "File size must be less than 5 MB";
  //       muteAodFileError.style.display = "block";
  //       return false;
  //     } else if (!file.name.endsWith(".pdf")) {
  //       muteAodFileError.textContent = "Only PDF files are allowed.";
  //       muteAodFileError.style.display = "block";
  //       return false;
  //     } else {
  //       muteAodFileError.style.display = "none"; // Hide error if file is valid
  //     }
  //   }

  //   // Case 1: File is uploaded, but no remark
  //   if (muteAodFile.getAttribute("data-should-validate") == 1) {
  //     return true;
  //   } else if (fileInputAod && !textInputAod) {
  //     // muteAodRemark.classList.add("is-invalid");
  //     muteAodRemarkError.textContent =
  //       "Please enter a remark if you upload a document";
  //     muteAodRemarkError.style.display = "block";
  //     return false;
  //   } else {
  //     // muteAodRemark.classList.remove("is-invalid");
  //     muteAodRemarkError.style.display = "none";
  //   }

  //   // Case 2: Remark is filled, but no file
  //   if (!fileInputAod && textInputAod) {
  //     // muteAodFile.classList.add("is-invalid");
  //     muteAodFileError.textContent =
  //       "Please upload a document if you enter a remark";
  //     muteAodFileError.style.display = "block";
  //     return false;
  //   } else {
  //     // muteAodFile.classList.remove("is-invalid");
  //     muteAodFileError.style.display = "none";
  //   }

  //   // Case 3: Either both are empty or both are filled — valid
  //   return true;
  // }
  // Any Other Document Mutaition form step 3 add by anil on 20-02-2025 for validation

  // Function to validate the Terms & Conditions checkbox
  function validateAgreeConsentMut() {
    if (!MutAgreeConsent.checked) {
      MutAgreeconsentError.textContent = "Please accept terms & conditions.";
      MutAgreeconsentError.style.display = "block";
      return false;
    } else {
      MutAgreeconsentError.style.display = "none";
      return true;
    }
  }

  // commented this function and created new common function for all input date for set max date today by anil on 27-03-2525
  // added by anil on 17-02-2025 for Apply max date restriction to prevent future dates in selected docuemnts for all date inputs
  // document.addEventListener("DOMContentLoaded", function () {
  //   var today = new Date().toISOString().split("T")[0];

  //   // Set max date for Date of Death and Certificate issue Date input
  //   muteDethDate.setAttribute("max", today);
  //   muteDethCertificateIssueDate.setAttribute("max", today);
  //   muteSaleDeedRegDate.setAttribute("max", today);
  //   muteWillRegDate.setAttribute("max", today);
  //   muteUnregdWillDate.setAttribute("max", today);
  //   muteRelinquishDeedRegdate.setAttribute("max", today);
  //   muteGiftDeedRegdate.setAttribute("max", today);
  //   muteSmcDateOfIssue.setAttribute("max", today);
  //   muteSbpDateOfIssue.setAttribute("max", today);

  //   // Validate on blur and change to prevent manual future date entry

  //   // Death Certificate Mutaition form step 3  add by anil on 17-02-2025 for validation
  //   muteDethDate.addEventListener("blur", validateMuteDethDate);
  //   muteDethDate.addEventListener("change", validateMuteDethDate);
  //   muteDethCertificateIssueDate.addEventListener(
  //     "blur",
  //     validateMuteDethCertificateIssueDate
  //   );
  //   muteDethCertificateIssueDate.addEventListener(
  //     "change",
  //     validateMuteDethCertificateIssueDate
  //   );
  //   // Death Certificate Mutaition form step 3  add by anil on 17-02-2025 for validation

  //   // Sale deed Mutaition form step 3 add by anil on 17-02-2025 for validation
  //   muteSaleDeedRegDate.addEventListener("blur", validateMuteSaleDeedRegDate);
  //   muteSaleDeedRegDate.addEventListener("change", validateMuteSaleDeedRegDate);
  //   // Sale deed Mutaition form step 3 add by anil on 17-02-2025 for validation

  //   // Regd. Will deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  //   muteWillRegDate.addEventListener("blur", validateMuteWillRegDate);
  //   muteWillRegDate.addEventListener("change", validateMuteWillRegDate);
  //   // Regd. Will deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  //   // Unregd. Will deed Mutaition form step 3 add by anil on 20-02-2025 for validation
  //   muteUnregdWillDate.addEventListener("blur", validateMuteUnregdWillDate);
  //   muteUnregdWillDate.addEventListener("change", validateMuteUnregdWillDate);
  //   // Unregd. Will deed Mutaition form step 3 add by anil on 20-02-2025 for validation

  //   // Registered Relinquishment deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  //   muteRelinquishDeedRegdate.addEventListener(
  //     "blur",
  //     validateMuteRelinquishDeedRegdate
  //   );
  //   muteRelinquishDeedRegdate.addEventListener(
  //     "change",
  //     validateMuteRelinquishDeedRegdate
  //   );
  //   // Registered Relinquishment deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  //   // Gift deed Mutaition form step 3 add by anil on 18-02-2025 for validation
  //   muteGiftDeedRegdate.addEventListener("blur", validateMuteGiftDeedRegdate);
  //   muteGiftDeedRegdate.addEventListener("change", validateMuteGiftDeedRegdate);
  //   // Gift deed Mutaition form step 3 add by anil on 18-02-2025 for validation

  //   // Surviving Member Certificate Mutaition form step 3 add by anil on 18-02-2025 for validation
  //   muteSmcDateOfIssue.addEventListener("blur", validateMuteSmcDateOfIssue);
  //   muteSmcDateOfIssue.addEventListener("change", validateMuteSmcDateOfIssue);
  //   // Surviving Member Certificate Mutaition form step 3 add by anil on 18-02-2025 for validation

  //   // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation
  //   muteSbpDateOfIssue.addEventListener("blur", validateMuteSbpDateOfIssue);
  //   muteSbpDateOfIssue.addEventListener("change", validateMuteSbpDateOfIssue);
  //   // Sanction Building Plan Mutaition form step 3 add by anil on 18-02-2025 for validation
  // });

  function validateForm3MUT() {
    var isAgreeConsentMutValid = validateAgreeConsentMut();
    return isAgreeConsentMutValid && isDethCertificateMuteValid;
  }

  form1.addEventListener("button", function (event) {
    event.preventDefault();
    if (validateForm1LUC() || validateForm1MUT()) {
      alert("Form submitted successfully.");
    }
  });

  form2.addEventListener("button", function (event) {
    event.preventDefault();
    if (validateForm2LUC()) {
      alert("Form submitted successfully.");
    }
  });

  form3.addEventListener("button", function (event) {
    event.preventDefault();
    if (validateForm3()) {
      alert("Form submitted successfully.");
    }
  });

  var editStep1 = document.getElementsByClassName("edit-step1");
  editStep1.forEach((btn) => {
    btn.addEventListener("click", function () {
      var propertyStatus = $("input[name='applicationStatus']").val();
      var applicationType = $("select[name='applicationType']").val();

      if (applicationType === "SUB_MUT" && validateEditMut1()) {
        btn.textContent = "Submitting...";
        btn.disabled = true;

        steppers["stepper3"].next();
        btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
        btn.disabled = false;
      } else if (applicationType === "CONVERSION" && validateEditConv1()) {
        btn.textContent = "Submitting...";
        btn.disabled = true;

        steppers["stepper4"].next();
        btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
        btn.disabled = false;
      } else if (applicationType === "NOC" && validateEditNOC1()) {
        btn.textContent = "Submitting...";
        btn.disabled = true;

        steppers["stepper7"].next();
        btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
        btn.disabled = false;
      }
    });
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
        // for submitting the first step of application  - Sourav Chauhan (17/sep/2024)
        btn.textContent = "Submitting...";
        btn.disabled = true;
        // var spinner = document.getElementById('spinnerOverlay');
        spinner.style.display = "flex";
        var propertyid = $("#propertyid").val();
        var propertyStatus = $("input[name='applicationStatus']").val();
        var applicationType = $("select[name='applicationType']").val();

        //for mutation - Sourav Chauhan (17/sep/2024)
        if (applicationType == "SUB_MUT") {
          mutation(propertyid, propertyStatus, function (success, result) {
            if (result.status) {
              spinner.style.display = "none";
              btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              showSuccess(result.message);
              steppers["stepper3"].next();
            } else {
              spinner.style.display = "none";
              btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              showError(result.message);
            }
          });
        }
      } else if (applicationType === "LUC" && validateForm1LUC()) {
        // var spinner = document.getElementById('spinnerOverlay');
        spinner.style.display = "flex";
        if (propertyStatus == "Lease Hold" && applicationType == "LUC") {
          landUseChange(function (success, message) {
            if (success) {
              spinner.style.display = "none";
              btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              steppers["stepper5"].next();
              showSuccess(message);
            } else {
              spinner.style.display = "none";
              btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              showError(message);
            }
          });
        }
      } else if (applicationType === "DOA" && validateForm1DOA()) {
        // var spinner = document.getElementById('spinnerOverlay');
        spinner.style.display = "flex";
        if (propertyStatus == "Lease Hold" && applicationType == "DOA") {
          deedOfApartment(
            propertyid,
            propertyStatus,
            function (success, result) {
              if (result.status) {
                spinner.style.display = "none";
                btn.innerHTML =
                  'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
                btn.disabled = false;
                showSuccess(result.message);
                steppers["stepper6"].next();
              } else {
                spinner.style.display = "none";
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

      // if (propertyStatus == "Lease Hold" && applicationType == "CONVERSION") {
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
      if (applicationType === "CONVERSION" && validateForm1Conv()) {
        // var spinner = document.getElementById('spinnerOverlay');
        spinner.style.display = "flex";
        btn.textContent = "Submitting...";
        btn.disabled = true;
        // If form is valid, proceed with your existing logic
        var propertyid = $("#propertyid").val();
        var propertyStatus = $("input[name='applicationStatus']").val();
        var applicationType = $("select[name='applicationType']").val();

        // // Validate coapplicant form
        // var isCoapplicantConversionValid = coapplicantConRepeaterForm();
        // if (!isCoapplicantConversionValid) {
        //   showError("Please fill out the co-applicant form correctly.");
        //   return;
        // }

        if (propertyStatus == "Lease Hold" && applicationType == "CONVERSION") {
          // var spinner = document.getElementById('spinnerOverlay');
          spinner.style.display = "flex";
          btn.textContent = "Submitting...";
          btn.disabled = true;
          conversionStep1(
            propertyid,
            propertyStatus,
            function (success, result) {
              if (success) {
                spinner.style.display = "none";
                btn.innerHTML =
                  'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
                btn.disabled = false;
                showSuccess(result.message);
                steppers["stepper4"].next();
              } else {
                spinner.style.display = "none";
                btn.innerHTML =
                  'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
                btn.disabled = false;
                showError(result.message);
              }
            }
          );
        }
      }
      if (applicationType === "NOC" && validateForm1Noc()) {
        // var spinner = document.getElementById('spinnerOverlay');
        spinner.style.display = "flex";
        btn.textContent = "Submitting...";
        btn.disabled = true;
        var propertyid = $("#propertyid").val();
        var propertyStatus = $("input[name='applicationStatus']").val();
        var applicationType = $("select[name='applicationType']").val();
        noc(propertyid, propertyStatus, function (success, result) {
          if (success) {
            spinner.style.display = "none";
            btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
            btn.disabled = false;
            showSuccess(result.message);
            steppers["stepper7"].next();
          } else {
            spinner.style.display = "none";
            btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
            btn.disabled = false;
            showError(result);
          }
        });
      }
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
    var mutFathernameAsConLease = $(
      "input[name='mutFathernameAsConLease']"
    ).val();
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
    var mutPropertyMortgaged = $(
      "input[name='mutPropertyMortgaged']:checked"
    ).val();
    var mutMortgagedRemarks = $("textarea[name='mutMortgagedRemarks']").val();
    var mutCourtorder = $("input[name='courtorderMutation']:checked").val();
    var mutCaseNo = $("input[name='mutCaseNo']").val();
    var mutCaseDetail = $("textarea[name='mutCaseDetail']").val();
    var coapplicants = {};
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
   /* $("input[name^='coapplicant'], select[name^='coapplicant']").each(
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
    ); */
   
    $("input[name^='coapplicant'], select[name^='coapplicant']").each(
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
            var fileInput = $(this)[0].files[0]; // Get the first file (since each input has one file)
            if (fileInput) {
              formData.append(`coapplicants[${index}][${field}]`, fileInput); // Append the file to FormData
            }
          }
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
/*        if (result.status) {
          // Populate co-applicant IDs

          if (result.data.ids && result.data.ids.length > 0) {
            result.data.ids.forEach((id, index) => {
              let coApplicantInput = $(
                `input[name='coapplicant[${id.index - 1}][undefined]']`
              );
              if (coApplicantInput.length > 0) {
                coApplicantInput.val(id.id); // Update the value with the response ID
                coApplicantInput.attr("id", `coapplicant_${id.index - 1}_id`); // Update ID dynamically
              }
            });
          }
          $("#submitbtn1").html(
            'Next <i class="bx bx-right-arrow-alt ms-2"></i>'
          );
          $("#submitbtn1").prop("disabled", false);
          $("input[name='updateId']").val(
            result.data.tempSubstitutionMutation.id
          );
          $("input[name='lastPropertyId']").val(
            result.data.tempSubstitutionMutation.old_property_id
          );
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
        }  */

if (result.status == "success") {
          $("#submitbtn1").html(
            'Next <i class="bx bx-right-arrow-alt ms-2"></i>'
          );
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
  // add by anil on 03-02-2025 for co applicant validation
  // $(document).on(
  //   "blur change",
  //   "#repeater .coapplicant-block input, #repeater .coapplicant-block select, #repeater .repeater-add-btn",
  //   function () {
  //     coapplicantMutRepeaterForm();
  //   }
  // );

  // ✅ not apply 'blur change' on date inputs for final validation (after manual entry) by anil 26-03-2025
  $(document).on(
    "blur change",
    "#repeater .coapplicant-block input:not([type='date']), #repeater .coapplicant-block select, #repeater .repeater-add-btn",
    function () {
      coapplicantMutRepeaterForm();
    }
  );

  // ✅ Only apply 'blur' to date inputs for final validation (after manual entry) by anil 26-03-2025
  $(document).on(
    "blur",
    "#repeater .coapplicant-block input[type='date']",
    function () {
      coapplicantMutRepeaterForm();
    }
  );

  // Add a listener to the date of birth field to handle changes when it's cleared
  $(document).on(
    "change",
    "#repeater .coapplicant-block input[type='date']",
    function () {
      var coDobInput = $(this);
      var ageField = coDobInput
        .closest(".coapplicant-block")
        .find("input[id$='_age']");

      // If the date of birth is cleared, clear the age field as well
      if (!coDobInput.val()) {
        ageField.val(""); // Clear the age field
      }
    }
  );

  $("#repeater .coapplicant-block").each(function () {
    var coDobInput = $(this).find("input[id$='_dateofbirth']");
    var ageField = $(this).find("input[id$='_age']");
    var dobValue = coDobInput.val();

    if (dobValue) {
      var dob = new Date(dobValue);
      var age = coCalculateAge(dob);
      ageField.val(age);
    }
  });

  function coapplicantMutRepeaterForm() {
    var isCoapplicantMutValid = true;

    $("#repeater .coapplicant-block").each(function (index, element) {
      let currentIndex = $(this).data("index");
      var coName = $(element).find("#coapplicant_" + currentIndex + "_name").val();
      var coGender = $(element).find("#coapplicant_" + currentIndex + "_gender").val();
      // var coDob = $(element).find('#coapplicant_' + currentIndex + '_dateofbirth').val();
      var coDobInput = $(element).find("#coapplicant_" + currentIndex + "_dateofbirth");
      var ageField = $(element).find("#coapplicant_" + currentIndex + "_age");
      var coRelation = $(element).find("#coapplicant_" + currentIndex + "_secondnameinv").val();
      var coAdhaarNumber = $(element).find("#coapplicant_" + currentIndex + "_aadharnumber").val();
      var coPanNumber = $(element).find("#coapplicant_" + currentIndex + "_pannumber").val();
      var coMobileNumber = $(element).find("#coapplicant_" + currentIndex + "_mobilenumber").val();
      var coPhotoFile = $(element).find("#coapplicant_" + currentIndex + "_photo")[0].files[0]; // Get the actual file

      // var previewImgSrc = $(element).find(".preview").attr("src");
      // var isPreviewImageValid = previewImgSrc && previewImgSrc.trim() !== "" && !previewImgSrc.includes("placeholder") && !previewImgSrc.includes("default");

      var coAdhaarFileInput = $(element).find("#coapplicant_" + currentIndex + "_aadhaarfile");
      var coAdhaarFile = coAdhaarFileInput.length > 0 && coAdhaarFileInput[0].files.length > 0 ? coAdhaarFileInput[0].files[0] : null;

      var coPanFileInput = $(element).find("#coapplicant_" + currentIndex + "_panfile");
      var coPanFile = coPanFileInput.length > 0 && coPanFileInput[0].files.length > 0 ? coPanFileInput[0].files[0] : null;

      var coPhotoFileInput = $(element).find("#coapplicant_" + currentIndex + "_photo");
      var coPhotoFile = coPhotoFileInput.length > 0 && coPhotoFileInput[0].files.length > 0 ? coPhotoFileInput[0].files[0] : null;

      const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;

      var aadhaarShouldValidate = coAdhaarFileInput.attr("data-should-validate");
      var panShouldValidate = coPanFileInput.attr("data-should-validate");
      var photoShouldValidate = coPhotoFileInput.attr("data-should-validate");

      // var coPhotoFileInput = $(element).find('#coapplicant_' + currentIndex + '_photo');
      // var coPhotoFile = coPhotoFileInput.length > 0 && coPhotoFileInput[0].files.length > 0 ? coPhotoFileInput[0].files[0] : null;
      var today = new Date().toISOString().split("T")[0]; // Get today's date (YYYY-MM-DD format)
      coDobInput.attr("max", today); // Set max date to today

      var coDob = coDobInput.val();

      // Remove previous error messages
      $(element).find(".error-message").text("");

      // Future Date Validation for DOB
      if (coDob) {
        var dob = new Date(coDob);
        var todayDate = new Date();
        todayDate.setHours(0, 0, 0, 0);

        if (dob > todayDate) {
          isCoapplicantMutValid = false;
          showErrorMessage(element, "Date of birth cannot be in the future.","#coapplicant_" + currentIndex + "_dateofbirth");
          coDobInput.val(""); // Clear invalid date
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
          showErrorMessage(element,"Name is required.","#coapplicant_" + currentIndex + "_name");
        }
        if (!coGender) {
          isCoapplicantMutValid = false;
          showErrorMessage(element,"Gender is required.","#coapplicant_" + currentIndex + "_gender");
        }
        if (!coDob) {
          isCoapplicantMutValid = false;
          showErrorMessage(element,"Date of birth is required.","#coapplicant_" + currentIndex + "_dateofbirth");
        }
        if (!coRelation) {
          isCoapplicantMutValid = false;
          showErrorMessage(element,"Relation is required.","#coapplicant_" + currentIndex + "_secondnameinv");
        }
        if (!coAdhaarNumber) {
          isCoapplicantMutValid = false;
          showErrorMessage(element,"Aadhaar number is required.","#coapplicant_" + currentIndex + "_aadharnumber");
        } else if (!/^\d{12}$/.test(coAdhaarNumber)) {
          isCoapplicantMutValid = false;
          showErrorMessage(element,"Aadhaar number must be 12 digits.","#coapplicant_" + currentIndex + "_aadharnumber");
        }
        // if ($(element).find("#coapplicant_" + currentIndex + "_aadhaarfile").attr("data-should-validate") == "1") {
        //   // If the file input should not be validated, skip further validation for this field
        //   return true; // Skip validation and continue to the next item
        // }
        if (aadhaarShouldValidate !== "1") {
          if (!coAdhaarFile) {
            isCoapplicantMutValid = false;
            showErrorMessage(element, "Aadhaar PDF is required.", "#coapplicant_" + currentIndex + "_aadhaarfile");
          } else if (coAdhaarFile.size > 5 * 1024 * 1024) {
            isCoapplicantMutValid = false;
            showErrorMessage(element, "Aadhaar file size must be less than 5MB.", "#coapplicant_" + currentIndex + "_aadhaarfile");
          } else if (!coAdhaarFile.name.endsWith(".pdf")) {
            // Check if the file is not a PDF
            isCoapplicantMutValid = false;
            showErrorMessage(element, "Only PDF files are allowed.", "#coapplicant_" + currentIndex + "_aadhaarfile");
          }
        }
        if (!coPanNumber) {
          isCoapplicantMutValid = false;
          showErrorMessage(element, "PAN number is required.", "#coapplicant_" + currentIndex + "_pannumber");
        } else if (!panRegex.test(coPanNumber.toUpperCase())) {
          isCoapplicantMutValid = false;
          showErrorMessage(element, "Invalid PAN number format.", "#coapplicant_" + currentIndex + "_pannumber");
        }
        // if ($(element).find("#coapplicant_" + currentIndex + "_panfile").attr("data-should-validate") == "1") {
        //   // If the file input should not be validated, skip further validation for this field
        //   return true; // Skip validation and continue to the next item
        // }
        if (panShouldValidate !== "1") {
          if (!coPanFile) {
            isCoapplicantMutValid = false;
            showErrorMessage(element, "PAN PDF is required.", "#coapplicant_" + currentIndex + "_panfile");
          } else if (coPanFile.size > 5 * 1024 * 1024) {
            isCoapplicantMutValid = false;
            showErrorMessage(element, "PAN file size must be less than 5MB.", "#coapplicant_" + currentIndex + "_panfile");
          } else if (!coPanFile.name.endsWith(".pdf")) {
            // Check if the file is not a PDF
            isCoapplicantMutValid = false;
            showErrorMessage(element, "Only PDF files are allowed.", "#coapplicant_" + currentIndex + "_panfile");
          }
        }
        if (!coMobileNumber) {
          isCoapplicantMutValid = false;
          showErrorMessage(element, "Mobile number is required.", "#coapplicant_" + currentIndex + "_mobilenumber");
        } else if (!/^\d{10}$/.test(coMobileNumber)) {
          isCoapplicantMutValid = false;
          showErrorMessage(element, "Mobile number must be 10 digits.", "#coapplicant_" + currentIndex + "_mobilenumber");
        }

        // Photo validation
        // if (!coPhotoFile && !isPreviewImageValid) {
        //   isCoapplicantMutValid = false;
        //   showErrorMessage(element, "Co-applicant passport size photo is required.", "#coapplicant_" + currentIndex + "_photo");
        // } else if (coPhotoFile) {
        //     var coPhotoFileName = coPhotoFile.name;
        //     var coPhotoFileExtension = coPhotoFileName.split(".").pop().toLowerCase();
        //     var coPhotoValidExtensions = ["jpg", "jpeg", "png"];

        //     if (!coPhotoValidExtensions.includes(coPhotoFileExtension)) {
        //         isCoapplicantMutValid = false;
        //         showErrorMessage(element, "Only .jpg, .jpeg, and .png formats are allowed.", "#coapplicant_" + currentIndex + "_photo");
        //         $(element).find("#coapplicant_" + currentIndex + "_photo").val(""); // Reset file input
        //     } else if (coPhotoFile.size > 102400) { // 100KB limit
        //         isCoapplicantMutValid = false;
        //         showErrorMessage(element, "Passport photo size must be less than 100KB.", "#coapplicant_" + currentIndex + "_photo");
        //     }
        // }
        // added new function for preview validation for draft by anil on 03-04-2025
        // if (!coPhotoFile) {
        //   isCoapplicantMutValid = false;
        //   showErrorMessage(element, "Co-applicant passport size photo is required.", "#coapplicant_" + currentIndex + "_photo");
        // } else {
        //   var coPhotoFileName = coPhotoFile.name;
        //   var coPhotoFileExtension = coPhotoFileName.split(".").pop().toLowerCase();
        //   var coPhotoValidExtensions = ["jpg", "jpeg", "png"];

        //   if (!coPhotoValidExtensions.includes(coPhotoFileExtension)) {
        //     isCoapplicantMutValid = false;
        //     showErrorMessage(element, "Only .jpg, .jpeg, and .png formats are allowed.", "#coapplicant_" + currentIndex + "_photo");
        //     // Clear the invalid file input
        //     $(element).find("#coapplicant_" + currentIndex + "_photo").val(""); // Reset file input
        //   } else if (coPhotoFile.size > 102400) {
        //     isCoapplicantMutValid = false;
        //     showErrorMessage(element, "Passport photo size must be less than 100KB.", "#coapplicant_" + currentIndex + "_photo");
        //   }
        // }
        if (photoShouldValidate !== "1") {
          if (!coPhotoFile) {
            isCoapplicantMutValid = false;
            showErrorMessage(element, "Co-applicant passport size photo is required.", "#coapplicant_" + currentIndex + "_photo");
          } else {
            var coPhotoFileName = coPhotoFile.name;
            var coPhotoFileExtension = coPhotoFileName.split(".").pop().toLowerCase();
            var coPhotoValidExtensions = ["jpg", "jpeg", "png"];

            if (!coPhotoValidExtensions.includes(coPhotoFileExtension)) {
              isCoapplicantMutValid = false;
              showErrorMessage(element, "Only .jpg, .jpeg, and .png formats are allowed.", "#coapplicant_" + currentIndex + "_photo");
              coPhotoFileInput.val(""); // Reset file input
            } else if (coPhotoFile.size > 102400) {
              isCoapplicantMutValid = false;
              showErrorMessage(element, "Passport photo size must be less than 100KB.", "#coapplicant_" + currentIndex + "_photo");
            }
          }
        }
      }
    });

    return isCoapplicantMutValid;
  }

  // Function to calculate age
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

  // Function to validate mandatory mutation documents
  // function mandatoryMutDocumentsForm() {
  function validateMandatoryMutDocumentsForm() {
    var isMandatoryMutDocumentsForm = true;

    // Clear previous error messages before starting new validation
    // $(".text-danger").text(""); // Clear the text inside all error message spans

    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

    // Loop through all .items inside #affidavits_repeater
    $("#affidavits_repeater .items").each(function (index, element) {
      let currentIndex = $(this).data("index");
      var mutAttestedBy = $(element)
        .find("#affidavits_" + currentIndex + "_affidavitattestedby")
        .val();
      var muteAffidavitsFile = $(element).find(
        "#affidavits_" + currentIndex + "_affidavits"
      )[0]?.files[0]; // File input
      var muteAttestationDate = $(element)
        .find("#affidavits_" + currentIndex + "_affidavitsdateofattestation")
        .val();

      var isMutAttesteValid = true; // Track validity for this specific form

      // Check if the field should be validated
      if (
        $(element).find("#affidavits_" + currentIndex + "_affidavits").attr("data-should-validate") !== "1") {
        // If the file input should not be validated, skip further validation for this field
        // return true; // Skip validation and continue to the next item // commented by anil for not in use and keeping the file validation here
        // Validate file input
        if (!muteAffidavitsFile) {
          isMutAttesteValid = false;
          $(element).find("#affidavits_" + currentIndex + "_affidavits").siblings(".text-danger").text("Affidavit file is required.");
        } else {
          // Validate file size (5MB limit)
          if (muteAffidavitsFile.size > 5 * 1024 * 1024) {
            isMutAttesteValid = false;
            $(element).find("#affidavits_" + currentIndex + "_affidavits").siblings(".text-danger").text("File size must be less than 5MB.");
          } else if (!muteAffidavitsFile.name.toLowerCase().endsWith(".pdf")) {
            isMutAttesteValid = false;
            $(element).find("#affidavits_" + currentIndex + "_affidavits").siblings(".text-danger").text("Only PDF files are allowed.");
          } else {
            $(element).find("#affidavits_" + currentIndex + "_affidavits").siblings(".text-danger").text("");
          }
        }
      }

      // Validate "attested by" field
      if (!mutAttestedBy) {
        isMutAttesteValid = false;
        $(element).find("#affidavits_" + currentIndex + "_affidavitattestedby").siblings(".text-danger").text("Attested by is required.");
      } else if (!/^[A-Za-z\s.]+$/.test(mutAttestedBy)) {
        // Check if it contains only alphabets and spaces
        isMutAttesteValid = false;
        $(element).find("#affidavits_" + currentIndex + "_affidavitattestedby").siblings(".text-danger").text("Attested by must contain letters only.");
      } else {
        $(element)
          .find("#affidavits_" + currentIndex + "_affidavitattestedby")
          .siblings(".text-danger")
          .text("");
      }

      // Validate attestation date (No future dates)
      if (!muteAttestationDate) {
        isMutAttesteValid = false;
        $(element).find("#affidavits_" + currentIndex + "_affidavitsdateofattestation").siblings(".text-danger").text("Date of attestation is required.");
      } else if (muteAttestationDate > today) {
        isMutAttesteValid = false;
        $(element).find("#affidavits_" + currentIndex + "_affidavitsdateofattestation").siblings(".text-danger").text("Future date is not allowed.");
      } else {
        $(element).find("#affidavits_" + currentIndex + "_affidavitsdateofattestation").siblings(".text-danger").text(""); // Clear invalid input
      }

      if (!isMutAttesteValid) {
        isMandatoryMutDocumentsForm = false;
      }
    });

    // Loop through all .items inside #indemnityBond_repeater
    $("#indemnityBond_repeater .items").each(function (index, element) {
      let currentIndex = $(this).data("index");
      var mutIndeBond = $(element).find("#indemnitybond_" + currentIndex + "_indemnitybond")[0]?.files[0]; // File input
      var mutIndeAttestationDate = $(element).find("#indemnitybond_" + currentIndex + "_indemnitybonddateofattestation").val();
      var muteIndeAttestedBy = $(element).find("#indemnitybond_" + currentIndex + "_indemnitybondattestedby").val();

      var isMutIndeValid = true;

      // Check if the field should be validated
      if (
        $(element).find("#indemnitybond_" + currentIndex + "_indemnitybond").attr("data-should-validate") !== "1") {
        // If the file input should not be validated, skip further validation for this field
        // return true; // Skip validation and continue to the next item // commented by anil for not in use and keeping the file validation here
        // Validate "Indemnity Bond" input field
        if (!mutIndeBond) {
          isMutIndeValid = false;
          $(element).find("#indemnitybond_" + currentIndex + "_indemnitybond").siblings(".text-danger").text("Indemnity bond file required.");
        } else {
          // Validate file size (5MB limit)
          if (mutIndeBond.size > 5 * 1024 * 1024) {
            isMutIndeValid = false;
            $(element)
              .find("#indemnitybond_" + currentIndex + "_indemnitybond")
              .siblings(".text-danger")
              .text("File size must be less than 5MB.");
          } else if (!mutIndeBond.name.toLowerCase().endsWith(".pdf")) {
            isMutIndeValid = false;
            $(element)
              .find("#indemnitybond_" + currentIndex + "_indemnitybond")
              .siblings(".text-danger")
              .text("Only PDF files are allowed.");
          } else {
            $(element)
              .find("#indemnitybond_" + currentIndex + "_indemnitybond")
              .siblings(".text-danger")
              .text("");
          }
        }
      }

      // Validate attestation date (No future dates)
      if (!mutIndeAttestationDate) {
        isMutIndeValid = false;
        $(element)
          .find(
            "#indemnitybond_" + currentIndex + "_indemnitybonddateofattestation"
          )
          .siblings(".text-danger")
          .text("Date of attestation is required.");
      } else if (mutIndeAttestationDate > today) {
        isMutIndeValid = false;
        $(element)
          .find(
            "#indemnitybond_" + currentIndex + "_indemnitybonddateofattestation"
          )
          .siblings(".text-danger")
          .text("Future date is not allowed.");
      } else {
        $(element)
          .find(
            "#indemnitybond_" + currentIndex + "_indemnitybonddateofattestation"
          )
          .siblings(".text-danger")
          .text(""); // Clear invalid input
      }

      // Validate "Attested By" field
      if (!muteIndeAttestedBy) {
        isMutIndeValid = false;
        $(element)
          .find("#indemnitybond_" + currentIndex + "_indemnitybondattestedby")
          .siblings(".text-danger")
          .text("Attested by is required.");
      } else if (!/^[A-Za-z\s.]+$/.test(muteIndeAttestedBy)) {
        // Check if it contains only alphabets and spaces
        isMutIndeValid = false;
        $(element)
          .find("#indemnitybond_" + currentIndex + "_indemnitybondattestedby")
          .siblings(".text-danger")
          .text("Attested by must contain letters only.");
      } else {
        $(element)
          .find("#indemnitybond_" + currentIndex + "_indemnitybondattestedby")
          .siblings(".text-danger")
          .text("");
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
    let currentIndex = $(this).data("index");
    // Set max date for affidavit attestation date inputs
    $("#affidavits_repeater").on(
      "blur change",
      "#affidavits_repeater .items, #affidavits_repeater .repeater-add-btn",
      function () {
        var today = new Date().toISOString().split("T")[0];
        if (
          $(
            "#affidavits_" + currentIndex + "_affidavitsdateofattestation"
          ).val() > today
        ) {
          $("#affidavits_" + currentIndex + "_affidavitsdateofattestation").val(
            ""
          ); // Clear future date
          $("#affidavits_" + currentIndex + "_affidavitsdateofattestation")
            .siblings(".text-danger")
            .text("Future date is not allowed.");
        } else {
          $("#affidavits_" + currentIndex + "_affidavitsdateofattestation")
            .siblings(".text-danger")
            .text("");
        }
      }
    );

    // Set max date for indemnity bond attestation date inputs
    $("#indemnityBond_repeater").on(
      "blur change",
      "#indemnityBond_repeater .items, #indemnityBond_repeater .repeater-add-btn",
      function () {
        var today = new Date().toISOString().split("T")[0];
        let currentIndex = $(this).data("index");
        if (
          $(
            "#indemnitybond_" + currentIndex + "_indemnitybonddateofattestation"
          ).val() > today
        ) {
          $(
            "#indemnitybond_" + currentIndex + "_indemnitybonddateofattestation"
          ).val(""); // Clear future date
          $(
            "#indemnitybond_" + currentIndex + "_indemnitybonddateofattestation"
          )
            .siblings(".text-danger")
            .text("Future date is not allowed.");
        } else {
          $(
            "#indemnitybond_" + currentIndex + "_indemnitybonddateofattestation"
          )
            .siblings(".text-danger")
            .text("");
        }
      }
    );

    // // Ensure the max date is set for newly added fields dynamically
    // $("#affidavits_repeater, #indemnityBond_repeater").on("DOMNodeInserted", function () {
    //     $(".affidavitsdateofattestation, .indemnitybonddateofattestation").attr("max",today);
    //   }
    // );

    // Apply max date on document load for existing fields
    $(
      "#affidavits_" +
        currentIndex +
        "_affidavitsdateofattestation, #indemnitybond_" +
        currentIndex +
        "_indemnitybonddateofattestation"
    ).attr("max", today);
  });

  //for step second***********************************
  var submitButton2 = document.getElementsByClassName("submitbtn2");
  submitButton2.forEach((btn) => {
    btn.addEventListener("click", function () {
      var propertyStatus = $("input[name='applicationStatus']").val();
      var applicationType = $("select[name='applicationType']").val();

      if (applicationType === "SUB_MUT" && validateForm2MUT()) {
        // var spinner = document.getElementById('spinnerOverlay');
        spinner.style.display = "flex";
        btn.textContent = "Submitting...";
        btn.disabled = true;
        var propertyStatus = $("input[name='applicationStatus']").val();
        var applicationType = $("select[name='applicationType']").val();

        // var isMandatoryMutDocValid = mandatoryMutDocumentsForm();
        // if (!isMandatoryMutDocValid) {
        //   // If the coapplicant form is invalid, show an error and stop
        //   showError("Please fill out the Mandatory Documents form correctly.");
        //   return; // Stop further execution
        // }

        if (applicationType == "SUB_MUT") {
          mutationStepSecond(function (success, result) {
            if (result.status) {
              spinner.style.display = "none";
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
                        .parent().find(`input[type="hidden"]`);
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
              spinner.style.display = "none";
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
      } else if (applicationType == "CONVERSION" && validateForm2Conv()) {
        // var spinner = document.getElementById('spinnerOverlay');
        spinner.style.display = "flex";
        btn.textContent = "Submitting...";
        btn.disabled = true;
        conversionStep2(function (success, message) {
          if (success) {
            spinner.style.display = "none";
            btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
            btn.disabled = false;
            steppers["stepper4"].next();
          } else {
            spinner.style.display = "none";
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

        // case "sanctionBuildingPlan_check":
        //   isMutValidateForm3Valid =
        //     validateMuteSbpFile() && isMutValidateForm3Valid;
        //   isMutValidateForm3Valid =
        //     validateMuteSbpDateOfIssue() && isMutValidateForm3Valid;
        //   break;

        case "propateLoaCourtDecreeOrder_check":
          isMutValidateForm3Valid =
            validateMutePropateFile() && isMutValidateForm3Valid;
          break;
      }
    });

    // Validate Additional Document fields
    // isMutValidateForm3Valid &= validateMuteAod();

    // Validate Terms & Conditions
    let isAgreeConsentMutValid = validateAgreeConsentMut(); // Check if Terms & Conditions is accepted
    var isAppOtherDoc = validateAppOtherDoc("MUTATION-3");
    let isPoAValid = validatePOADoc("MUTATION-3");

    if (!isAgreeConsentMutValid) {
      isMutValidateForm3Valid = false; // If the consent is not checked, mark the form as invalid
    }

    return isMutValidateForm3Valid && isAppOtherDoc && isPoAValid;
  }

  var btnfinalsubmit = document.getElementsByClassName("btnfinalsubmit");
  btnfinalsubmit.forEach((btn) => {
    btn.addEventListener("click", function () {
      var propertyStatus = $("input[name='applicationStatus']").val();
      var applicationType = $("select[name='applicationType']").val();

      // if (applicantStatus == "1581") { // Power of Attorney selected
      //   debugger;
      //   if ($(appPowerAttorney).closest('.form-group').is(':visible')) {
      //     // Validate Power of Attorney document
      //     if (!validateFormPowerOfAttorney()) {
      //       spinner.style.display = "none";
      //       btn.textContent = "Submit";
      //       btn.disabled = false;
      //       return; // Prevent form submission if validation fails
      //     }
      //   }
      // }

      // if () {
        

        if (applicationType == "SUB_MUT" && validateForm3MUT()) {

        spinner.style.display = "flex";
        btn.textContent = "Submitting...";
        btn.disabled = true;
          mutationStepThird(function (success, result) {
            if (result.status) {
              btn.innerHTML =
                'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              spinner.style.display = "none";
              showSuccess(
                result.message,
                getBaseURL() + "/applications/history/details"
              );
            } else {
              console.log("condition getting false.");
              btn.innerHTML =
                'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              spinner.style.display = "none";
              showError(result.message);
            }
          });
        }
      // }

      if (applicationType === "LUC" && validateForm2LUC()) {
        //   btn.textContent = "Submitting...";
        // btn.disabled = true;

        // var propertyStatus = $("input[name='applicationStatus']").val();
        // var applicationType = $("select[name='applicationType']").val();

        if (propertyStatus == "Lease Hold" && applicationType == "LUC") {
          // var spinner = document.getElementById('spinnerOverlay');
          spinner.style.display = "flex";
          landUseChangeStep2(function (success, result) {
            if (success) {
              btn.innerHTML =
                'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              spinner.style.display = "none";
              showSuccess(
                result,
                getBaseURL() + "/applications/history/details"
              );
            } else {
              btn.innerHTML =
                'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              spinner.style.display = "none";
              showError(result);
            }
          });
        }
      }

      if (applicationType == "DOA" && validateForm2DOA()) {
        if (propertyStatus == "Lease Hold" && applicationType == "DOA") {
          // var spinner = document.getElementById('spinnerOverlay');
          spinner.style.display = "flex";
          deedOfApartmentStepFinal(function (success, result) {
            if (result.status) {
              btn.innerHTML =
                'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              spinner.style.display = "none";
              showSuccess(
                result.message,
                getBaseURL() + "/applications/history/details"
              );
            } else {
              btn.innerHTML =
                'Proceed to Pay <i class="bx bx-right-arrow-alt ms-2"></i>';
              btn.disabled = false;
              spinner.style.display = "none";
              showError(result.message);
            }
          });
        }
      }
      if (applicationType == "CONVERSION" && validateForm3Conv()) {
        // var spinner = document.getElementById('spinnerOverlay');
        btn.textContent = "Submitting...";
        btn.disabled = true;
        // var spinner = document.getElementById('spinnerOverlay');
        spinner.style.display = "flex";
        conversionStep3(function (success, result) {
          console.log("conversionStep3 callback triggered", result); // Debugging log
          if (success) {
            btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
            btn.disabled = false;
            spinner.style.display = "none";
            showSuccess(result, getBaseURL() + "/applications/history/details");
          } else {
            btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
            btn.disabled = false;
            spinner.style.display = "none";
            showError(result);
          }
        });
      }

      if (applicationType == "NOC" && validateForm2Noc()) {
        // if (applicationType == "NOC") {
        btn.textContent = "Submitting...";
        btn.disabled = true;
        // var spinner = document.getElementById('spinnerOverlay');
        spinner.style.display = "flex";
        nocFinalStep(function (success, result) {
          console.log("nocfinalStep callback triggered", result); // Debugging log
          if (success) {
            btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
            btn.disabled = false;
            spinner.style.display = "none";
            showSuccess(result, getBaseURL() + "/applications/history/details");
          } else {
            btn.innerHTML = 'Next <i class="bx bx-right-arrow-alt ms-2"></i>';
            btn.disabled = false;
            spinner.style.display = "none";
            showError(result);
          }
        });
      }
    });
  });

  // created commn function by anil for set max date on date input on 27-03-2025
  var today = new Date().toISOString().split("T")[0];
  // console.log(isEditing , "isEditing ");
  $(".coapplicant-block .item-content input[type='date']").attr("max", today);
  regdate.setAttribute("max", today);
  convRegDate.setAttribute("max", today);
  // add condition for check if input is available then set max date today by anil on 16-04-2025
  if (convCourtOrderDate) {
    convCourtOrderDate.setAttribute("max", today);
  }
  if (convDateOfNOC) {
    convDateOfNOC.setAttribute("max", today);
  }
  if (convAttestedLetterDate) {
    convAttestedLetterDate.setAttribute("max", today);
  }
  if (convContructionProofDate) {
    convContructionProofDate.setAttribute("max", today);
  }
  if (convPossessionProofDate) {
    convPossessionProofDate.setAttribute("max", today);
  }
  if (convDocLeaseDeedDoEDate) {
    convDocLeaseDeedDoEDate.setAttribute("max", today);
  }
  if (convMandDocADateAttestation) {
    convMandDocADateAttestation.setAttribute("max", today);
  }
  if (convLesseeAliveAffidevitDate) {
    convLesseeAliveAffidevitDate.setAttribute("max", today);
  }
  if (convLeaseLostAffidevitDate) {
    convLeaseLostAffidevitDate.setAttribute("max", today);
  }
  if (publicNoticeDateEnglish) {
    publicNoticeDateEnglish.setAttribute("max", today);
  }
  if (publicNoticeDateHindi) {
    publicNoticeDateHindi.setAttribute("max", today);
  }
  if (muteDethDate) {
    muteDethDate.setAttribute("max", today);
  }
  if (muteDethCertificateIssueDate) {
    muteDethCertificateIssueDate.setAttribute("max", today);
  }
  if (muteSaleDeedRegDate) {
    muteSaleDeedRegDate.setAttribute("max", today);
  }
  if (muteSaleDeedRegDate) {
    muteWillRegDate.setAttribute("max", today);
  }
  if (muteUnregdWillDate) {
    muteUnregdWillDate.setAttribute("max", today);
  }
  if (muteRelinquishDeedRegdate) {
    muteRelinquishDeedRegdate.setAttribute("max", today);
  }
  if (muteGiftDeedRegdate) {
    muteGiftDeedRegdate.setAttribute("max", today);
  }
  if (muteSmcDateOfIssue) {
    muteSmcDateOfIssue.setAttribute("max", today);
  }
  // if (muteSbpDateOfIssue) {
  //   muteSbpDateOfIssue.setAttribute("max", today);
  // }
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
            var appendOption = `<option value="${row.property_type_to}" ${
              isEditing == 1 &&
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
          `<option value="${val.id}" data-rate="${val.rate}" ${
            isEditing == true &&
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
  var mixedUse = $("#mixed_LUC").is(":checked");
  var totalBUiltUpArea = $("#luc_TBUA").val();
  var commercialArea = $("#luc_BUAC").val();
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
      mixedUse: mixedUse,
      totalBUiltUpArea: totalBUiltUpArea,
      commercialArea: commercialArea,
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
              $("#" + element.id + "Error").html("This document is required.");
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

/* $("#lucpropertysubtypeto").change(function () {
  'displayEstimatedCharges'();
}); */
function displayEstimatedCharges() {
  /* var baseUrl = getBaseURL();
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
  });*/

  // folowing function is copied from demand input form and modified by Nitin Raghuvanshi on 17 March 2025
  $(".builtUpAreaInputs .error").empty();

  let landValue = 0;
  let landArea = 0;
  let landSizeSpan = $("#land-size-span");

  if (landSizeSpan.length > 0) {
    landArea = parseFloat(landSizeSpan.text().replace("Sq. Mtr.", "")) || 0;
  }

  let chargesApplicabe = true;
  let mixedUse = $("#mixed_LUC").is(":checked");

  if (mixedUse) {
    let tbuac = parseFloat($("#luc_TBUA").val()) || 0;
    let buac = parseFloat($("#luc_BUAC").val()) || 0;

    if (tbuac > landArea) {
      $("#luc_TBUA_error").html(
        `Total built-up area cannot be more than land size ${landArea} Sq.m.`
      );
      return false;
    }

    if (tbuac > 0) {
      if (buac > 0) {
        if (buac > tbuac) {
          $("#luc_BUAC_error").html(
            "Commercial area cannot be more than total built-up area."
          );
          return false;
        }
        let chargableArea = (20 * tbuac) / 100;
        if (buac <= chargableArea) {
          chargesApplicabe = false;
        }
      } else {
        $("#luc_BUAC_error").html("Area to be used as commercial is required.");
        return false;
      }
    } else {
      $("#luc_TBUA_error").html("Total built-up area is required.");
      return false;
    }
  }

  if (chargesApplicabe) {
    let baseUrl = getBaseURL();
    let propertyId = $("#propertyid").val();

    $.ajax({
      type: "GET",
      url: `${baseUrl}/land-use-change/property-type-options/${propertyId}`,
      success: function (response) {
        if (response.status === "success" && response.propertyDetails) {
          landValue = response.propertyDetails.land_value;
        }

        // Move calculation & UI update inside the AJAX success callback
        let lucc = chargesApplicabe ? (landValue * 10) / 100 : 0;
        lucc = (Math.round(lucc * 100) / 100).toFixed(2);

        $("#estimatedCharges").html("₹ " + customNumFormat(lucc));
        $("#chargesCalculationInfo").html("10% of land value");

        $(".estimate").removeClass("d-none");
      },
    });
  } else {
    $("#estimatedCharges").html("₹ " + 0.0);
    $("#chargesCalculationInfo").html(
      "0 as land area to be used as commercial is less than 20% of total area."
    );

    $(".estimate").removeClass("d-none");
  }
}




function getUserDetails() {
  return $.ajax({
    url: fetchUserDetailsUrl,
    type: "GET",
    dataType: "JSON"
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
        $("#submitbtn1").html(
          'Next <i class="bx bx-right-arrow-alt ms-2"></i>'
        );
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

// // added by anil kuamr on 11-02-2025 for conversion repeater form validtaion
// $(document).on( "blur change", "#CONrepeater .coapplicant-block input, #CONrepeater .coapplicant-block select",
//   function () {
//     coapplicantConRepeaterForm();
//   }
// );

// not apply 'blur change' on date inputs for final validation (after manual entry) by anil 26-03-2025
$(document).on(
  "blur change",
  "#CONrepeater .coapplicant-block input:not([type='date']), #CONrepeater .coapplicant-block select, #CONrepeater .repeater-add-btn",
  function () {
    coapplicantConRepeaterForm();
  }
);
// Only apply 'blur' to date inputs for final validation (after manual entry) by anil 26-03-2025
$(document).on(
  "blur",
  "#CONrepeater .coapplicant-block input[type='date']",
  function () {
    coapplicantConRepeaterForm();
  }
);

// Add a listener to the date of birth field to handle changes when it's cleared
$(document).on(
  "change",
  "#CONrepeater .coapplicant-block input[type='date']",
  function () {
    var conCoDobInput = $(this);
    var ageConField = conCoDobInput
      .closest(".coapplicant-block")
      .find("input[id$='_age']");

    // If the date of birth is cleared, clear the age field as well
    if (!conCoDobInput.val()) {
      ageConField.val(""); // Clear the age field
    }
  }
);

// Calculate age for all date inputs on page load and set value in ageConField added by anil on 28-03-2025
$("#CONrepeater .coapplicant-block").each(function () {
  var conCoDobInput = $(this).find("input[id$='_dateofbirth']");
  var ageConField = $(this).find("input[id$='_age']");

  var dobValue = conCoDobInput.val();
  if (dobValue) {
    var dob = new Date(dobValue);
    var age = conCalculateAge(dob);
    ageConField.val(age);
  }
});

function coapplicantConRepeaterForm() {
  var isCoapplicantConValid = true;

  $("#CONrepeater .coapplicant-block").each(function (index, element) {
    let currentIndex = $(this).data("index");
    var conCoName = $(element)
      .find("#convcoapplicant_" + currentIndex + "_name")
      .val();
    var conCoGender = $(element)
      .find("#convcoapplicant_" + currentIndex + "_gender")
      .val();
    // var conCoDob = $(element).find("#convcoapplicant_" + currentIndex + "_dateofbirth").val();
    var conCoDobInput = $(element).find(
      "#convcoapplicant_" + currentIndex + "_dateofbirth"
    );
    // var ageConField = $(element).find("#convcoapplicant_" + currentIndex + "_age");
    var conCoRelation = $(element)
      .find("#convcoapplicant_" + currentIndex + "_fathername")
      .val();
    var conCoAdhaarNumber = $(element)
      .find("#convcoapplicant_" + currentIndex + "_aadharnumber")
      .val();
    var conCoPanNumber = $(element)
      .find("#convcoapplicant_" + currentIndex + "_pannumber")
      .val();
    var conCoMobileNumber = $(element)
      .find("#convcoapplicant_" + currentIndex + "_mobilenumber")
      .val();
    //var conCoPhotoFile = $(element).find("#convcoapplicant_" + currentIndex + "_photo")[0].files[0]; // Get the actual file

    var conCoAdhaarFileInput = $(element).find(
      "#convcoapplicant_" + currentIndex + "_aadhaarfile"
    );
    var conCoAdhaarFile =
      conCoAdhaarFileInput.length > 0 &&
      conCoAdhaarFileInput[0].files.length > 0
        ? conCoAdhaarFileInput[0].files[0]
        : null;
    var conCoPanFileInput = $(element).find(
      "#convcoapplicant_" + currentIndex + "_panfile"
    );
    var conCoPanFile =
      conCoPanFileInput.length > 0 && conCoPanFileInput[0].files.length > 0
        ? conCoPanFileInput[0].files[0]
        : null;
    var conCoPhotoFileInput = $(element).find(
      "#convcoapplicant_" + currentIndex + "_photo"
    );
    var conCoPhotoFile =
      conCoPhotoFileInput.length > 0 && conCoPhotoFileInput[0].files.length > 0
        ? conCoPhotoFileInput[0].files[0]
        : null;

    const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;

    // added by anil for draft and edit case on 09-04-2025
    // var shouldValidateAadhaar = conCoAdhaarFileInput.data("should-validate"); // returns 0, 1, true, false, etc.
    // var shouldValidatePan = conCoPanFileInput.data("should-validate"); // get value of data-should-validate
    // var shouldValidatePhoto = conCoPhotoFileInput.data("should-validate"); // get value of data-should-validate
    // added by anil on 24-04-2025 for correct validation due to draft issue
    var shouldValidateAadhaar = conCoAdhaarFileInput.attr(
      "data-should-validate"
    );
    var shouldValidatePan = conCoPanFileInput.attr("data-should-validate");
    var shouldValidatePhoto = conCoPhotoFileInput.attr("data-should-validate"); // get value of data-should-validate

    // ✅ Ensure max date is set dynamically
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format
    conCoDobInput.attr("max", today); // Set max date to today

    var conCoDob = conCoDobInput.val();
    var ageConField = $(element).find(
      "#convcoapplicant_" + currentIndex + "_age"
    );

    // Remove previous error messages
    $(this).find(".error-message").text("");

    // Future Date Validation for DOB
    if (conCoDob) {
      var dob = new Date(conCoDob);
      var todayDate = new Date();
      todayDate.setHours(0, 0, 0, 0);

      if (dob > todayDate) {
        isCoapplicantConValid = false;
        showErrorMessage(
          element,
          "Date of birth cannot be in the future.",
          "#convcoapplicant_" + currentIndex + "_dateofbirth"
        );
        conCoDobInput.val(""); // Clear invalid input
      } else {
        var age = conCalculateAge(dob);
        ageConField.val(age);
      }
    }

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
          element,
          "Name is required.",
          "#convcoapplicant_" + currentIndex + "_name"
        );
      }
      if (!conCoGender) {
        isCoapplicantConValid = false;
        showErrorMessage(
          element,
          "Gender is required.",
          "#convcoapplicant_" + currentIndex + "_gender"
        );
      }
      if (!conCoDob) {
        isCoapplicantConValid = false;
        showErrorMessage(
          element,
          "Date of birth is required.",
          "#convcoapplicant_" + currentIndex + "_dateofbirth"
        );
      }
      if (!conCoRelation) {
        isCoapplicantConValid = false;
        showErrorMessage(
          element,
          "Relation is required.",
          "#convcoapplicant_" + currentIndex + "_fathername"
        );
      }
      // Validate aadhaar number (example: 12-digit number)
      if (!conCoAdhaarNumber) {
        isCoapplicantConValid = false;
        showErrorMessage(
          element,
          "Aadhaar number is required.",
          "#convcoapplicant_" + currentIndex + "_aadharnumber"
        );
      } else if (!/^\d{12}$/.test(conCoAdhaarNumber)) {
        isCoapplicantConValid = false;
        showErrorMessage(
          element,
          "Aadhaar number must be 12 digits.",
          "#convcoapplicant_" + currentIndex + "_aadharnumber"
        );
      }

      // added by anil for draft and edit case on 09-04-2025
      // Check if file exists and its size for aadhaar file
      if (shouldValidateAadhaar !== "1") {
        // Perform aadhaar file validation only when shouldValidate is 0
        if (!conCoAdhaarFile) {
          isCoapplicantConValid = false;
          showErrorMessage(
            element,
            "Aadhaar PDF is required.",
            "#convcoapplicant_" + currentIndex + "_aadhaarfile"
          );
        } else if (conCoAdhaarFile.size > 5 * 1024 * 1024) {
          isCoapplicantConValid = false;
          showErrorMessage(
            element,
            "Aadhaar file size must be less than 5MB.",
            "#convcoapplicant_" + currentIndex + "_aadhaarfile"
          );
        } else if (!conCoAdhaarFile.name.endsWith(".pdf")) {
          // Check if the file is not a PDF
          isCoapplicantConValid = false;
          showErrorMessage(
            element,
            "Only PDF files are allowed.",
            "#convcoapplicant_" + currentIndex + "_aadhaarfile"
          );
        }
      }
      // if (adhaarShouldValidate) {
      //   if (!conCoAdhaarFile) {
      //     isCoapplicantConValid = false;
      //     showErrorMessage(element, "Aadhaar PDF is required.", "#convcoapplicant_" + currentIndex + "_aadhaarfile");
      //   } else if (conCoAdhaarFile.size > 5 * 1024 * 1024) {
      //     isCoapplicantConValid = false;
      //     showErrorMessage(element, "Aadhaar file size must be less than 5MB.", "#convcoapplicant_" + currentIndex + "_aadhaarfile");
      //   }
      // }
      // if (!conCoAdhaarFile) {
      //   isCoapplicantConValid = false;
      //   showErrorMessage(element, "Aadhaar PDF is required.", "#convcoapplicant_" + currentIndex + "_aadhaarfile");
      // } else if (conCoAdhaarFile && conCoAdhaarFile.size > 5 * 1024 * 1024) {
      //   // 5MB limit for aadhaar file
      //   isCoapplicantConValid = false;
      //   showErrorMessage(element, "Aadhaar file size must be less than 5MB.", "#convcoapplicant_" + currentIndex + "_aadhaarfile");
      // }

      // Validate PAN number (example: format ABCDE1234F)
      if (!conCoPanNumber) {
        isCoapplicantConValid = false;
        showErrorMessage(
          element,
          "PAN number is required.",
          "#convcoapplicant_" + currentIndex + "_pannumber"
        );
      } else if (!panRegex.test(conCoPanNumber.toUpperCase())) {
        isCoapplicantConValid = false;
        showErrorMessage(
          element,
          "Invalid PAN number format.",
          "#convcoapplicant_" + currentIndex + "_pannumber"
        );
      }
      // if (!conCoPanNumber) {
      //   isCoapplicantConValid = false;
      //   showErrorMessage(element, "PAN number is required.", "#convcoapplicant_" + currentIndex + "_pannumber");
      // } else if (!/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(conCoPanNumber)) {  // Correct PAN regex format
      //     isCoapplicantConValid = false;
      //     showErrorMessage(element, "PAN number must be in the format ABCDE1234F.", "#convcoapplicant_" + currentIndex + "_pannumber");
      // }

      // added by anil for draft and edit case on 09-04-2025
      // Check if file exists and its size for PAN file
      if (shouldValidatePan !== "1") {
        //  Perform PAN file validation only when shouldValidate is 0
        if (!conCoPanFile) {
          isCoapplicantConValid = false;
          showErrorMessage(
            element,
            "PAN PDF is required.",
            "#convcoapplicant_" + currentIndex + "_panfile"
          );
        } else if (conCoPanFile && conCoPanFile.size > 5 * 1024 * 1024) {
          isCoapplicantConValid = false;
          showErrorMessage(
            element,
            "PAN file size must be less than 5MB.",
            "#convcoapplicant_" + currentIndex + "_panfile"
          );
        } else if (!conCoPanFile.name.endsWith(".pdf")) {
          // Check if the file is not a PDF
          isCoapplicantConValid = false;
          showErrorMessage(
            element,
            "Only PDF files are allowed.",
            "#convcoapplicant_" + currentIndex + "_panfile"
          );
        }
      }
      // if (panShouldValidate) {
      //   if (!conCoPanFile) {
      //     isCoapplicantConValid = false;
      //     showErrorMessage(element, "PAN PDF is required.", "#convcoapplicant_" + currentIndex + "_panfile");
      //   } else if (conCoPanFile.size > 5 * 1024 * 1024) {
      //     isCoapplicantConValid = false;
      //     showErrorMessage(element, "PAN file size must be less than 5MB.", "#convcoapplicant_" + currentIndex + "_panfile");
      //   }
      // }
      // if (!conCoPanFile) {
      //   isCoapplicantConValid = false;
      //   showErrorMessage(element, "PAN PDF is required.", "#convcoapplicant_" + currentIndex + "_panfile");
      // } else if (conCoPanFile && conCoPanFile.size > 5 * 1024 * 1024) {
      //   // 5MB limit for PAN file
      //   isCoapplicantConValid = false;
      //   showErrorMessage(element, "PAN file size must be less than 5MB.", "#convcoapplicant_" + currentIndex + "_panfile");
      // }
      // Validate mobile number (example: 10-digit number)
      if (!conCoMobileNumber) {
        isCoapplicantConValid = false;
        showErrorMessage(
          element,
          "Mobile number is required.",
          "#convcoapplicant_" + currentIndex + "_mobilenumber"
        );
      } else if (!/^\d{10}$/.test(conCoMobileNumber)) {
        isCoapplicantConValid = false;
        showErrorMessage(
          element,
          "Mobile number must be 10 digits.",
          "#convcoapplicant_" + currentIndex + "_mobilenumber"
        );
      }
      // Photo validation
      // added by anil if image preivew availabel on 08-04-2025
      // var previewImgSrc = $(element).find(".preview").attr("src");
      // var isPreviewImageValid = previewImgSrc && previewImgSrc.trim() !== "" && !previewImgSrc.includes("placeholder") && !previewImgSrc.includes("default");

      // if (!conCoPhotoFile && !isPreviewImageValid) {
      //     isCoapplicantConValid = false;
      //     showErrorMessage(element, "Co-applicant passport size photo is required.", "#convcoapplicant_" + currentIndex + "_photo");
      // } else if (conCoPhotoFile) {
      //     var conCoPhotoFileName = conCoPhotoFile.name;
      //     var conCoPhotoFileExtension = conCoPhotoFileName.split(".").pop().toLowerCase();
      //     var conCoPhotoValidExtensions = ["jpg", "jpeg", "png"];

      //     if (!conCoPhotoValidExtensions.includes(conCoPhotoFileExtension)) {
      //         isCoapplicantConValid = false;
      //         showErrorMessage(element, "Only .jpg, .jpeg, and .png formats are allowed.", "#convcoapplicant_" + currentIndex + "_photo");
      //         $(element).find("#convcoapplicant_" + currentIndex + "_photo").val(""); // Reset file input
      //     } else if (conCoPhotoFile.size > 102400) { // 100KB limit
      //         isCoapplicantConValid = false;
      //         showErrorMessage(element, "Passport photo size must be less than 100KB.", "#convcoapplicant_" + currentIndex + "_photo");
      //     }
      // }
      // added by anil if image preivew availabel on 08-04-2025

      // commented by anil and add new same function which is work for also draft on 02-04-2025
      if (shouldValidatePhoto !== "1") {
        if (!conCoPhotoFile) {
          isCoapplicantConValid = false;
          showErrorMessage(
            element,
            "Co-applicant passport size photo is required.",
            "#convcoapplicant_" + currentIndex + "_photo"
          );
        } else {
          var conCoPhotoFileName = conCoPhotoFile.name;
          var conCoPhotoFileExtension = conCoPhotoFileName
            .split(".")
            .pop()
            .toLowerCase();
          var conCoPhotoValidExtensions = ["jpg", "jpeg", "png"];

          if (!conCoPhotoValidExtensions.includes(conCoPhotoFileExtension)) {
            isCoapplicantConValid = false;
            showErrorMessage(
              element,
              "Only .jpg, .jpeg, and .png formats are allowed.",
              "#convcoapplicant_" + currentIndex + "_photo"
            );
            // Clear the invalid file input
            // $(element).find("#convcoapplicant_" + currentIndex + "_photo").val(""); // Reset file input
          } else if (conCoPhotoFile.size > 102400) {
            isCoapplicantConValid = false;
            showErrorMessage(
              element,
              "Passport photo size must be less than 100KB.",
              "#convcoapplicant_" + currentIndex + "_photo"
            );
          }
        }
      }
      // Validate photo file size (e.g., max 1MB)
      // if (!conCoPhotoFile) {
      //   isCoapplicantConValid = false;
      //   showErrorMessage(element, "Co-applicant passport size photo is required.", "#convcoapplicant_" + currentIndex + "_photo");

      //   var fileInput = $(element).find("#convcoapplicant_" + currentIndex + "_photo")[0];

      //   // Check if file is selected
      //   if (fileInput && fileInput.files && fileInput.files.length > 0) {
      //     var fileSize = fileInput.files[0].size;

      //     // Check if file size exceeds 100KB (100KB = 102400 bytes)
      //     if (fileSize > 102400) {
      //       isCoapplicantConValid = false;
      //       showErrorMessage(element, "Passport photo size must be less than 100KB.", "#convcoapplicant_" + currentIndex + "_photo");
      //     }
      //   }
      // } else {
      //   // If no file is uploaded (coPhotoFile is undefined), show an error message
      //   var fileInput = $(element).find("#convcoapplicant_" + currentIndex + "_photo")[0];

      //   if (fileInput && fileInput.files && fileInput.files.length > 0) {
      //     var fileSize = fileInput.files[0].size;

      //     // Check if file size is larger than 100KB
      //     if (fileSize > 102400) {
      //       isCoapplicantConValid = false;
      //       showErrorMessage(element, "Passport photo size must be less than 100KB.", "#convcoapplicant_" + currentIndex + "_photo");
      //     }
      //   }
      // }
    }
  });

  return isCoapplicantConValid;
}

// function to calculate age
function conCalculateAge(dob) {
  var today = new Date();
  var age = today.getFullYear() - dob.getFullYear();
  var m = today.getMonth() - dob.getMonth();

  if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
    age--;
  }

  return age;
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

// for storing first step of noc details - Lalit Tiwari (17/march/2025)
function noc(propertyid, propertyStatus, callback) {
  var updateId = $("input[name='updateId']").val();
  var statusofapplicant = $("#statusofapplicant").val();
  var nocNameApp = $("input[name='nocNameApp']").val();
  var nocGenderApp = $("input[name='nocGenderApp']").val();
  var nocDateOfBirth = $("input[name='nocDateOfBirth']").val();
  var nocAgeApp = $("input[name='nocAgeApp']").val();
  var nocFathernameApp = $("input[name='nocFathernameApp']").val();

  var nocAadharApp = $("input[name='nocAadharApp']").val();
  var nocPanApp = $("input[name='nocPanApp']").val();
  var nocMobilenumberApp = $("input[name='nocMobilenumberApp']").val();

  var conveyanceDeedName = $("input[name='conveyanceDeedName']").val();
  var conveyanceExecutedOn = $("input[name='conveyanceExecutedOn']").val();

  var conveyanceRegnoDeed = $("input[name='conveyanceRegnoDeed']").val();
  var conveyanceBookNoDeed = $("input[name='conveyanceBookNoDeed']").val();
  var conveyanceVolumeNo = $("input[name='conveyanceVolumeNo']").val();
  var conveyancePagenoFrom = $("input[name='conveyancePagenoFrom']").val();
  var conveyancePagenoTo = $("input[name='conveyancePagenoTo']").val();
  var conveyanceRegDate = $("input[name='conveyanceRegDate']").val();
  var conveyanceConAppDate = $("input[name='conveyanceConAppDate']").val();
  var coapplicants = {};
  var formData = new FormData();
  formData.append("_token", $('meta[name="csrf-token"]').attr("content")); // CSRF token
  formData.append("updateId", updateId);
  formData.append("propertyid", propertyid);
  formData.append("propertyStatus", propertyStatus);
  formData.append("statusofapplicant", statusofapplicant);
  formData.append("nocNameApp", nocNameApp);
  formData.append("nocGenderApp", nocGenderApp);
  formData.append("nocDateOfBirth", nocDateOfBirth);
  formData.append("nocAgeApp", nocAgeApp);
  formData.append("nocFathernameApp", nocFathernameApp);
  formData.append("nocAadharApp", nocAadharApp);
  formData.append("nocPanApp", nocPanApp);
  formData.append("nocMobilenumberApp", nocMobilenumberApp);
  formData.append("conveyanceDeedName", conveyanceDeedName);
  formData.append("conveyanceExecutedOn", conveyanceExecutedOn);
  formData.append("conveyanceRegnoDeed", conveyanceRegnoDeed);
  formData.append("conveyanceBookNoDeed", conveyanceBookNoDeed);
  formData.append("conveyanceVolumeNo", conveyanceVolumeNo);
  formData.append("conveyancePagenoFrom", conveyancePagenoFrom);
  formData.append("conveyancePagenoTo", conveyancePagenoTo);
  formData.append("conveyanceRegDate", conveyanceRegDate);
  formData.append("conveyanceConAppDate", conveyanceConAppDate);

  // Iterate over co-applicant inputs and add text fields to formData
  $("input[name^='noccoapplicant'], select[name^='noccoapplicant']").each(
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
          var fileInput = $(this)[0].files[0]; // Get the first file (since each input has one file)
          if (fileInput) {
            formData.append(`coapplicants[${index}][${field}]`, fileInput); // Append the file to FormData
          }
        }
      }
    }
  );
  const nocStepFirstUrl = "{{ route('nocStepFirst') }}";

  var baseUrl = getBaseURL();
  $.ajax({
    url: baseUrl + "/noc-step-first",
    type: "POST",
    dataType: "JSON",
    data: formData,
    processData: false,
    contentType: false,
    success: function (result) {
      if (result.status == "success") {
        $("#submitbtn1").html(
          'Next <i class="bx bx-right-arrow-alt ms-2"></i>'
        );
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

// NOC form step 1
// NOC Co-applicant
// ✅ not apply 'blur change' on date inputs for final validation (after manual entry) by anil 27-03-2025
$(document).on(
  "blur change",
  "#conveyanceRepeater .coapplicant-block input:not([type='date']), #conveyanceRepeater .coapplicant-block select, #conveyanceRepeater .repeater-add-btn",
  function () {
    coapplicantNocRepeaterForm();
  }
);

// ✅ Only apply 'blur' to date inputs for final validation (after manual entry) by anil 27-03-2025
$(document).on(
  "blur",
  "#conveyanceRepeater .coapplicant-block input[type='date']",
  function () {
    coapplicantNocRepeaterForm();
  }
);

// Add a listener to the date of birth field to handle changes when it's cleared
$(document).on(
  "change",
  "#conveyanceRepeater .coapplicant-block input[type='date']",
  function () {
    var nocCoDobInput = $(this);
    var agenocField = nocCoDobInput
      .closest(".coapplicant-block")
      .find("input[id$='_age']");

    // If the date of birth is cleared, clear the age field as well
    if (!nocCoDobInput.val()) {
      agenocField.val(""); // Clear the age field
    }
  }
);

// ✅ Calculate age for all date inputs on page load and set value in ageConField added by anil on 28-03-2025
$("#conveyanceRepeater .coapplicant-block").each(function () {
  var nocCoDobInput = $(this).find("input[id$='_dateofbirth']");
  var agenocField = $(this).find("input[id$='_age']");

  var nocDobValue = nocCoDobInput.val();
  if (nocDobValue) {
    var dob = new Date(nocDobValue);
    var age = nocCalculateAge(dob);
    agenocField.val(age);
  }
});

function coapplicantNocRepeaterForm() {
  var isCoapplicantNocValid = true;

  $("#conveyanceRepeater .coapplicant-block").each(function (index, element) {
    let currentIndex = $(this).data("index");
    var nocCoName = $(element)
      .find("#noccoapplicant_" + currentIndex + "_name")
      .val();
    var nocCoGender = $(element)
      .find("#noccoapplicant_" + currentIndex + "_gender")
      .val();
    var nocCoDobInput = $(element).find(
      "#noccoapplicant_" + currentIndex + "_dateofbirth"
    );
    var nocCoRelation = $(element)
      .find("#noccoapplicant_" + currentIndex + "_fathername")
      .val();
    var nocCoAdhaarNumber = $(element)
      .find("#noccoapplicant_" + currentIndex + "_aadharnumber")
      .val();
    var nocCoPanNumber = $(element)
      .find("#noccoapplicant_" + currentIndex + "_pannumber")
      .val();
    var nocCoMobileNumber = $(element)
      .find("#noccoapplicant_" + currentIndex + "_mobilenumber")
      .val();
    var nocCoAdhaarFileInput = $(element).find(
      "#noccoapplicant_" + currentIndex + "_aadhaarfile"
    );
    var nocCoAdhaarFile =
      nocCoAdhaarFileInput.length > 0 &&
      nocCoAdhaarFileInput[0].files.length > 0
        ? nocCoAdhaarFileInput[0].files[0]
        : null;
    var nocCoPanFileInput = $(element).find(
      "#noccoapplicant_" + currentIndex + "_panfile"
    );
    var nocCoPanFile =
      nocCoPanFileInput.length > 0 && nocCoPanFileInput[0].files.length > 0
        ? nocCoPanFileInput[0].files[0]
        : null;
    var nocCoPhotoFileInput = $(element).find(
      "#noccoapplicant_" + currentIndex + "_photo"
    );
    var nocCoPhotoFile =
      nocCoPhotoFileInput.length > 0 && nocCoPhotoFileInput[0].files.length > 0
        ? nocCoPhotoFileInput[0].files[0]
        : null;

    var shouldValidateNocAadhaar = nocCoAdhaarFileInput.attr(
      "data-should-validate"
    );
    var shouldValidateNocPan = nocCoPanFileInput.attr("data-should-validate");
    var shouldValidatePhoto = nocCoPhotoFileInput.attr("data-should-validate"); // get value of data-should-validate

    // ✅ Ensure max date is set dynamically
    var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format
    nocCoDobInput.attr("max", today); // Set max date to today

    var nocCoDob = nocCoDobInput.val();
    var agenocField = $(element).find(
      "#noccoapplicant_" + currentIndex + "_age"
    );

    const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;

    // Remove previous error messages
    $(this).find(".error-message").text("");

    // Future Date Validation for DOB
    if (nocCoDob) {
      var dob = new Date(nocCoDob);
      var todayDate = new Date();
      todayDate.setHours(0, 0, 0, 0);

      if (dob > todayDate) {
        isCoapplicantNocValid = false;
        showErrorMessage(
          element,
          "Date of birth cannot be in the future.",
          "#noccoapplicant_" + currentIndex + "_dateofbirth"
        );
        nocCoDobInput.val(""); // Clear invalid input
      } else {
        var age = nocCalculateAge(dob);
        agenocField.val(age);
      }
    }

    // Check if any field is filled
    var isAnynocFieldFilled =
      nocCoName ||
      nocCoGender ||
      nocCoDob ||
      nocCoRelation ||
      nocCoAdhaarNumber ||
      nocCoAdhaarFile ||
      nocCoPanNumber ||
      nocCoPanFile ||
      nocCoMobileNumber ||
      nocCoPhotoFile;

    if (isAnynocFieldFilled) {
      // If at least one field is filled, make all fields mandatory
      if (!nocCoName) {
        isCoapplicantNocValid = false;
        showErrorMessage(
          element,
          "Name is required.",
          "#noccoapplicant_" + currentIndex + "_name"
        );
      }
      if (!nocCoGender) {
        isCoapplicantNocValid = false;
        showErrorMessage(
          element,
          "Gender is required.",
          "#noccoapplicant_" + currentIndex + "_gender"
        );
      }
      if (!nocCoDob) {
        isCoapplicantNocValid = false;
        showErrorMessage(
          element,
          "Date of birth is required.",
          "#noccoapplicant_" + currentIndex + "_dateofbirth"
        );
      }
      if (!nocCoRelation) {
        isCoapplicantNocValid = false;
        showErrorMessage(
          element,
          "Relation is required.",
          "#noccoapplicant_" + currentIndex + "_fathername"
        );
      }
      // Validate aadhaar number (example: 12-digit number)
      if (!nocCoAdhaarNumber) {
        isCoapplicantNocValid = false;
        showErrorMessage(
          element,
          "Aadhaar number is required.",
          "#noccoapplicant_" + currentIndex + "_aadharnumber"
        );
      } else if (!/^\d{12}$/.test(nocCoAdhaarNumber)) {
        isCoapplicantNocValid = false;
        showErrorMessage(
          element,
          "Aadhaar number must be 12 digits.",
          "#noccoapplicant_" + currentIndex + "_aadharnumber"
        );
      }
      // Check if file exists and its size for aadhaar file
      // aadhaar file validation if shouldValidateAadhaar !== "1" cahnged by anil on 22-04-2025 for draft and edit
      if (shouldValidateNocAadhaar !== "1") {
        if (!nocCoAdhaarFile) {
          isCoapplicantNocValid = false;
          showErrorMessage(
            element,
            "Aadhaar PDF is required.",
            "#noccoapplicant_" + currentIndex + "_aadhaarfile"
          );
        } else if (nocCoAdhaarFile.size > 5 * 1024 * 1024) {
          isCoapplicantNocValid = false;
          showErrorMessage(
            element,
            "Aadhaar file size must be less than 5MB.",
            "#noccoapplicant_" + currentIndex + "_aadhaarfile"
          );
        } else if (!nocCoAdhaarFile.name.endsWith(".pdf")) {
          // Check if the file is not a PDF
          isCoapplicantNocValid = false;
          showErrorMessage(
            element,
            "Only PDF files are allowed.",
            "#noccoapplicant_" + currentIndex + "_aadhaarfile"
          );
        }
      }
      // Validate PAN number (example: format ABCDE1234F)
      if (!nocCoPanNumber) {
        isCoapplicantNocValid = false;
        showErrorMessage(
          element,
          "PAN number is required.",
          "#noccoapplicant_" + currentIndex + "_pannumber"
        );
      } else if (!panRegex.test(nocCoPanNumber.toUpperCase())) {
        isCoapplicantNocValid = false;
        showErrorMessage(
          element,
          "Invalid PAN number format.",
          "#noccoapplicant_" + currentIndex + "_pannumber"
        );
      }
      // Check if file exists and its size for PAN file
      // PAN file validation if shouldValidatePan !== "1" cahnged by anil on 22-04-2025 for draft and edit
      if (shouldValidateNocPan !== "1") {
        if (!nocCoPanFile) {
          isCoapplicantNocValid = false;
          showErrorMessage(
            element,
            "PAN PDF is required.",
            "#noccoapplicant_" + currentIndex + "_panfile"
          );
        } else if (nocCoPanFile.size > 5 * 1024 * 1024) {
          isCoapplicantNocValid = false;
          showErrorMessage(
            element,
            "PAN file size must be less than 5MB.",
            "#noccoapplicant_" + currentIndex + "_panfile"
          );
        } else if (!nocCoPanFile.name.endsWith(".pdf")) {
          // Check if the file is not a PDF
          isCoapplicantNocValid = false;
          showErrorMessage(
            element,
            "Only PDF files are allowed.",
            "#noccoapplicant_" + currentIndex + "_panfile"
          );
        }
      }
      // if (!nocCoPanFile) {
      //   isCoapplicantNocValid = false;
      //   showErrorMessage(element, "PAN PDF is required.", "#noccoapplicant_" + currentIndex + "_panfile");
      // } else if (nocCoPanFile && nocCoPanFile.size > 5 * 1024 * 1024) {
      //   // 5MB limit for PAN file
      //   isCoapplicantNocValid = false;
      //   showErrorMessage(element, "PAN file size must be less than 5MB.", "#noccoapplicant_" + currentIndex + "_panfile");
      // }
      // Validate mobile number (example: 10-digit number)
      if (!nocCoMobileNumber) {
        isCoapplicantNocValid = false;
        showErrorMessage(
          element,
          "Mobile number is required.",
          "#noccoapplicant_" + currentIndex + "_mobilenumber"
        );
      } else if (!/^\d{10}$/.test(nocCoMobileNumber)) {
        isCoapplicantNocValid = false;
        showErrorMessage(
          element,
          "Mobile number must be 10 digits.",
          "#noccoapplicant_" + currentIndex + "_mobilenumber"
        );
      }
      // Photo validation
      if (shouldValidatePhoto !== "1") {
        if (!nocCoPhotoFile) {
          isCoapplicantNocValid = false;
          showErrorMessage(
            element,
            "Co-applicant passport size photo is required.",
            "#noccoapplicant_" + currentIndex + "_photo"
          );
        } else {
          var nocCoPhotoFileName = nocCoPhotoFile.name;
          var nocCoPhotoFileExtension = nocCoPhotoFileName
            .split(".")
            .pop()
            .toLowerCase();
          var nocCoPhotoValidExtensions = ["jpg", "jpeg", "png"];

          if (!nocCoPhotoValidExtensions.includes(nocCoPhotoFileExtension)) {
            isCoapplicantNocValid = false;
            showErrorMessage(
              element,
              "Only .jpg, .jpeg, and .png formats are allowed.",
              "#noccoapplicant_" + currentIndex + "_photo"
            );
            $(element)
              .find("#noccoapplicant_" + currentIndex + "_photo")
              .val(""); // Reset file input
          } else if (nocCoPhotoFile.size > 102400) {
            isCoapplicantNocValid = false;
            showErrorMessage(
              element,
              "Passport photo size must be less than 100KB.",
              "#noccoapplicant_" + currentIndex + "_photo"
            );
          }
        }
      }
    }
  });

  return isCoapplicantNocValid;
}

// function to calculate age
function nocCalculateAge(dob) {
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
  var errorMessageSpan = inputField.siblings(".error-message");
  errorMessageSpan.text(message).show();
}

var nocApplicantStatus = document.getElementById("statusofapplicant");
var nocExecutedName = document.getElementById("conveyanceDeedName");
var nocDateExecutedOn = document.getElementById("conveyanceExecutedOn");
var nocRegNo = document.getElementById("conveyanceRegnoDeed");
var nocBookno = document.getElementById("conveyanceBookNoDeed");
var nocVolumeno = document.getElementById("conveyanceVolumeNo");
var nocPagenoFrom = document.getElementById("conveyancePagenoFrom");
var nocPagenoTo = document.getElementById("conveyancePagenoTo");
var nocRegDate = document.getElementById("conveyanceRegDate");
var nocConvAppDate = document.getElementById("conveyanceConAppDate");

// Form 1 Errors
var nocApplicantStatusError = document.getElementById("statusofapplicantError");
var nocExecutedNameError = document.getElementById("conveyanceDeedNameError");
var nocDateExecutedOnError = document.getElementById(
  "conveyanceExecutedOnError"
);
var nocRegNoError = document.getElementById("conveyanceRegnoDeedError");
var nocBooknoError = document.getElementById("conveyanceBookNoDeedError");
var nocVolumenoError = document.getElementById("conveyanceVolumeNoError");
var nocPagenoFromError = document.getElementById("conveyancePagenoFromError");
var nocPagenoToError = document.getElementById("conveyancePagenoToError");
var nocRegDateError = document.getElementById("conveyanceRegDateError");
var nocConvAppDateError = document.getElementById("conveyanceConAppDateError");

function validateNocApplicationType() {
  var nocApplicantStatusValue = nocApplicantStatus.value.trim();
  if (nocApplicantStatusValue === "") {
    nocApplicantStatusError.textContent = "Applicant status is required.";
    nocApplicantStatusError.style.display = "block";
    return false;
  } else {
    nocApplicantStatusError.style.display = "none";
    nocApplicantStatusError.style.display = "none";
    return true;
  }
}

function validateNocExecutedName() {
  var nocExecutedNameValue = nocExecutedName.value.trim();
  if (nocExecutedNameValue === "") {
    nocExecutedNameError.textContent = "Executed in favour of is required.";
    nocExecutedNameError.style.display = "block";
    return false;
  } else {
    nocExecutedNameError.style.display = "none";
    return true;
  }
}

function validateNocExecutedOnDate() {
  var nocnocDateExecutedOnValue = nocDateExecutedOn.value.trim();
  var today = new Date().toISOString().split("T")[0];
  if (nocnocDateExecutedOnValue === "") {
    nocDateExecutedOnError.textContent = "Executed date is required.";
    nocDateExecutedOnError.style.display = "block";
    return false;
  } else if (nocnocDateExecutedOnValue > today) {
    nocDateExecutedOnError.textContent =
      "Executed date cannot be in the future.";
    nocDateExecutedOnError.style.display = "block";
    nocDateExecutedOn.value = ""; // Clear invalid input
    return false;
  } else {
    nocDateExecutedOnError.style.display = "none";
    return true;
  }
}

function validateNocRegNo() {
  var nocRegNoValue = nocRegNo.value.trim();
  if (nocRegNoValue === "") {
    nocRegNoError.textContent = "Registration number is required.";
    nocRegNoError.style.display = "block";
    return false;
  } else {
    nocRegNoError.style.display = "none";
    return true;
  }
}

function validateNocBookno() {
  var nocBooknoValue = nocBookno.value.trim();

  // Check if the field is empty
  if (nocBooknoValue === "") {
    nocBooknoError.textContent = "Book number is required.";
    nocBooknoError.style.display = "block";
    return false;
  }
  
  // Check if the Book number is numeric
  if (!/^\d+$/.test(nocBooknoValue)) {
    nocBooknoError.textContent = "Book number must be a numeric value.";
    nocBooknoError.style.display = "block";
    return false;
  }

  // Check if the Book number is a positive number (optional, if you want to restrict to positive values)
  if (parseFloat(nocBooknoValue) <= 0) {
    nocBooknoError.textContent = "Book number must be a positive number.";
    nocBooknoError.style.display = "block";
    return false;
  }

  nocBooknoError.style.display = "none";
  return true;
}

function validateNocVolumeno() {
  var nocVolumenoValue = nocVolumeno.value.trim();

  // Check if the field is empty
  if (nocVolumenoValue === "") {
    nocVolumenoError.textContent = "Volume number is required.";
    nocVolumenoError.style.display = "block";
    return false;
  }
  
  // Check if the value is numeric
  if (!/^\d+$/.test(nocVolumenoValue)) {
    nocVolumenoError.textContent = "Volume number must be a numeric value.";
    nocVolumenoError.style.display = "block";
    return false;
  }

  // Check if the value is a positive number (optional, if you want to restrict to positive values)
  if (parseFloat(nocVolumenoValue) <= 0) {
    nocVolumenoError.textContent = "Volume must be a positive number.";
    nocVolumenoError.style.display = "block";
    return false;
  }

  nocVolumenoError.style.display = "none";
  return true;
}

$(document).on("input blur change", "#conveyancePagenoFrom", function () {
  validateNocPagenoFrom();
});

function validateNocPagenoFrom() {
  var nocPagenoFromValue = nocPagenoFrom.value.trim();
  var nocPagenoValueTo = nocPagenoTo.value.trim();

  // Check if the field is empty
  if (nocPagenoFromValue === "") {
    nocPagenoFromError.textContent = "Page number from is required.";
    nocPagenoFromError.style.display = "block";
    return false;
  }
  
  // Check if the value is numeric
  if (!/^\d+$/.test(nocPagenoFromValue)) {
    nocPagenoFromError.textContent = "Page number from must be a numeric value.";
    nocPagenoFromError.style.display = "block";
    return false;
  }

  // Check if the value is positive
  if (parseFloat(nocPagenoFromValue) <= 0) {
    nocPagenoFromError.textContent = "Page number from must be a positive number.";
    nocPagenoFromError.style.display = "block";
    return false;
  }
  // Check if 'Page number From' is greater than 'Page number To'
  if (parseInt(nocPagenoFromValue) > parseInt(nocPagenoValueTo)) {
    nocPagenoFromError.textContent = "Page number from cannot be greater than page number to.";
    nocPagenoFromError.style.display = "block";
    return false;
  } else {
    nocPagenoFromError.style.display = "none";
    return true;
  }
}

$(document).on("input blur change", "#conveyancePagenoTo", function () {
  validateNocPagenoTo();
});

function validateNocPagenoTo() {
  var nocPagenoToValue = nocPagenoTo.value.trim();
  var nocPagenoValueFrom = nocPagenoFrom.value.trim();
  // Check if the field is empty
  if (nocPagenoToValue === "") {
    nocPagenoToError.textContent = "Page number to is required.";
    nocPagenoToError.style.display = "block";
    // Check the value
    return false;
  }
  
  // Check if the value is numeric
  if (!/^\d+$/.test(nocPagenoToValue)) {
    nocPagenoToError.textContent = "Page number to must be a numeric value.";
    nocPagenoToError.style.display = "block";
    return false;
  }

  // Check if the value is positive
  if (parseFloat(nocPagenoToValue) <= 0) {
    nocPagenoToError.textContent = "Page number to must be a positive number.";
    nocPagenoToError.style.display = "block";
    return false;
  }

  // Check if 'Page number To' is less than 'Page number From'
  if (parseInt(nocPagenoToValue) < parseInt(nocPagenoValueFrom)) {
    nocPagenoToError.textContent =
      "Page number to cannot be less than page number from.";
    nocPagenoToError.style.display = "block";
    return false;
  } else {
    nocPagenoToError.style.display = "none";
    return true;
  }
}

function validateNocRegDate() {
  var nocRegDateValue = nocRegDate.value.trim();
  var nocDateExecutedValueOn = nocDateExecutedOn.value.trim();
  var today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

  var nocRegDateObj = new Date(nocRegDateValue);
  var nocDateExecutedValueOnObj = new Date(nocDateExecutedValueOn);

  if (nocRegDateValue === "") {
    nocRegDateError.textContent = "Registration date is required.";
    nocRegDateError.style.display = "block";
    return false;
  }

  // Future date validation
  if (nocRegDateValue > today) {
    nocRegDateError.textContent = "Registration date cannot be in the future.";
    nocRegDateError.style.display = "block";
    nocRegDate.value = ""; // Clear the invalid date
    return false;
  }

  // Ensure nocRegDate is not earlier than mutExecutedOnAsConLease
  if (nocRegDateObj < nocDateExecutedValueOnObj) {
    nocRegDateError.textContent =
      "Registration cannot occur prior to the execution date.";
    nocRegDateError.style.display = "block";
    nocRegDate.value = ""; // Clear the invalid date
    return false;
  }

  nocRegDateError.style.display = "none";
  return true;
}
function validateNocConvAppDate() {
  var nocConvAppDateValue = nocConvAppDate.value.trim();
  var nocExecutedDateValueOn = nocDateExecutedOn.value.trim();

  // if (nocConvAppDateValue === "") {
  //   nocConvAppDateError.textContent = "Conversion application date is required.";
  //   nocConvAppDateError.style.display = "block";
  //   return false;
  // }

  // Check if executed on date is entered
  if (nocExecutedDateValueOn === "") {
    nocConvAppDateError.textContent = "Executed on need to be added first.";
    nocConvAppDateError.style.display = "block";
    return false;
  }

  // If conversion app date is not entered, skip further validation added on 01-05-2025 by anil
  if (nocConvAppDateValue === "") {
    nocConvAppDateError.style.display = "none";
    return true;
  }

  var convAppDateObj = new Date(nocConvAppDateValue);
  var executedOnDateObj = new Date(nocExecutedDateValueOn);

  // Check if Conversion App Date is greater than or equal to executed on Date
  if (convAppDateObj > executedOnDateObj) {
    nocConvAppDateError.textContent =
      "Registration cannot occur prior to the execution date.";
    nocConvAppDateError.style.display = "block";
    nocConvAppDate.value = ""; // Clear invalid input
    return false;
  }

  nocConvAppDateError.style.display = "none";
  return true;
}
document.addEventListener("DOMContentLoaded", function () {
  const executedOnInput = document.getElementById("conveyanceExecutedOn");
  const conAppDateInput = document.getElementById("conveyanceConAppDate");
  const checkApplicationType = document.getElementById("applicationType");

  // Function to apply max date based on executed on date
  function setMaxDate() {
    if (executedOnInput && conAppDateInput) {
      const executedDate = executedOnInput.value.trim();

      if (executedDate !== "") {
        conAppDateInput.setAttribute("max", executedDate);
        console.log("✅ Max date set to:", executedDate);

        // If current value exists and exceeds max, clear it
        if (
          conAppDateInput.value &&
          new Date(conAppDateInput.value) > new Date(executedDate)
        ) {
          console.warn("Existing value exceeds max, clearing.");
          conAppDateInput.value = "";
        }
      }
    } else {
      console.error("Required inputs not found.");
    }
  }

  // Apply max date on page load
  setMaxDate();

  // Apply max date when applicationType changes (if NOC)
  checkApplicationType.addEventListener("change", function () {
    if (this.value === "NOC") {
      setMaxDate();
    } else {
      conAppDateInput.removeAttribute("max");
    }
  });

  // Validate date on user change
  conAppDateInput.addEventListener("change", function () {
  nocConvAppDateError.textContent = "";
  nocConvAppDateError.style.display = "none";

  if (!this.value) return; // Skip if field is empty

  const selectedDate = new Date(this.value);
  const maxDate = new Date(this.max);

  if (selectedDate > maxDate) {
    // Format maxDate as MM/DD/YYYY
    const formattedMaxDate =
      ("0" + (maxDate.getMonth() + 1)).slice(-2) + "/" +
      ("0" + maxDate.getDate()).slice(-2) + "/" +
      maxDate.getFullYear();

    nocConvAppDateError.textContent =
      "Selected date cannot be after the executed on date (" +
      formattedMaxDate + ").";
    nocConvAppDateError.style.display = "block";
    this.value = "";
  }
});


  // Optional: Update max date when executed on is changed by the user
  executedOnInput.addEventListener("change", setMaxDate);
});

// this function and created new common function for all input date for set max date today by anil on 27-03-2525
document.addEventListener("DOMContentLoaded", function () {
  var today = new Date().toISOString().split("T")[0];

  $(".coapplicant-block .item-content input[type='date']").attr("max", today);

  // add condition for check if input is available then set max date today by anil on 24-04-2025
  if (nocRegDate) {
    nocRegDate.setAttribute("max", today);
  }
  // if (nocConvAppDate){nocConvAppDate.setAttribute("max", today);}
});

function validateForm1Noc() {
  var isCoapplicantNocValid = coapplicantNocRepeaterForm();
  var isNocExecutedNameValid = validateNocExecutedName();
  var isNocExecutedOnAsOnLeaseDate = validateNocExecutedOnDate();
  var isNocRegno = validateNocRegNo();
  var isNocBookno = validateNocBookno();
  var isNocVolumeno = validateNocVolumeno();
  var isNocPagenoFrom = validateNocPagenoFrom();
  var isNocPagenoTo = validateNocPagenoTo();
  var isNocRegDate = validateNocRegDate();
  var isNocConvAppDate = validateNocConvAppDate();
  var isNocApplicationType = validateNocApplicationType();

  return (
    isCoapplicantNocValid &&
    isNocExecutedNameValid &&
    isNocExecutedOnAsOnLeaseDate &&
    isNocRegno &&
    isNocBookno &&
    isNocVolumeno &&
    isNocPagenoFrom &&
    isNocPagenoTo &&
    isNocRegDate &&
    isNocConvAppDate &&
    isNocApplicationType
  );
}

// NOC Edit step 1 valdation
function validateEditNOC1() {
  var isCoapplicantNocValid = coapplicantNocRepeaterForm();
  var isNocRegno = validateNocRegNo();
  var isNocBookno = validateNocBookno();
  var isNocVolumeno = validateNocVolumeno();
  var isNocPagenoFrom = validateNocPagenoFrom();
  var isNocPagenoTo = validateNocPagenoTo();
  var isNocRegDate = validateNocRegDate();
  var isNocConvAppDate = validateNocConvAppDate();

  return (
    isCoapplicantNocValid &&
    isNocRegno &&
    isNocBookno &&
    isNocVolumeno &&
    isNocPagenoFrom &&
    isNocPagenoTo &&
    isNocRegDate &&
    isNocConvAppDate
  );
}
// End NOC Edit step 1 valdation

//  End NOC step 1 form validtaion

// NOC step 2 form validation anil 21-03-2025
var conveyancedeed = document.getElementById("conveyancedeed");
var conveyancedeedError = document.getElementById("conveyancedeedError");

var conveyanceOwnershipDoc = document.getElementById("conveyanceownershipdoc");
var conveyanceOwnershipDocError = document.getElementById(
  "conveyanceownershipdocError"
);

var conveyanceAadharDoc = document.getElementById("conveyanceaadhardoc");
var conveyanceAadharDocError = document.getElementById(
  "conveyanceaadhardocError"
);

var conveyancePanDoc = document.getElementById("conveyancepandoc");
var conveyancePanDocError = document.getElementById("conveyancepandocError");

var conveyanceConAppDoc = document.getElementById("conveyanceconappdoc");
var conveyanceConAppDocError = document.getElementById(
  "conveyanceconappdocError"
);

var agreeConsentNoc = document.getElementById("agreeConsentNoc");
var agreeConsentNocError = document.getElementById("agreeConsentNocError");

function validateForm2Noc() {
  var isValidateConveyanceDeedFile = validateConveyanceDeedFile();
  var isConveyanceOwnershipDoc = validateConveyanceOwnershipDoc();
  var isConveyanceAadharDoc = validateConveyanceAadharDoc();
  var isConveyancePanDoc = validateConveyancePanDoc();
  var isValidateAgreeConsentNoc = validateAgreeConsentNoc();
  var isValidateConAppDoc = validateConveyanceConAppDoc();
  var isAppOtherDoc = validateAppOtherDoc("NOC-2");
  let isPoAValid = validatePOADoc("NOC-2");

  return (
    isValidateConveyanceDeedFile &&
    isConveyanceOwnershipDoc &&
    isConveyanceAadharDoc &&
    isConveyancePanDoc &&
    isValidateConAppDoc &&
    isValidateAgreeConsentNoc &&
    isAppOtherDoc &&
    isPoAValid
  );
}

// function validateForm2NocPOA() {
//   var isValidateConveyancePowerAttorney = validateConveyancePowerAttorney();

//   return (
//     isValidateConveyancePowerAttorney
//   );
// }

// NOC Form Step 2

function validateConveyanceDeedFile() {
  if (conveyancedeed.files.length > 0) {
    var file = conveyancedeed.files[0];
    if (file.size > 5 * 1024 * 1024) {
      conveyancedeedError.textContent = "File size must be less than 5 MB.";
      return false;
    } else if (!file.name.endsWith(".pdf")) {
      conveyancedeedError.textContent = "Only PDF files are allowed.";
      return false;
    } else {
      conveyancedeedError.textContent = "";
      return true;
    }
  } else {
    if (conveyancedeed.getAttribute("data-should-validate") == 1) {
      return true;
    }
    conveyancedeedError.textContent = "Conveyance deed PDF is required.";
    return false;
  }
}

function validateConveyanceOwnershipDoc() {
  if (conveyanceOwnershipDoc.files.length > 0) {
    var file = conveyanceOwnershipDoc.files[0];
    if (file.size > 5 * 1024 * 1024) {
      conveyanceOwnershipDocError.textContent =
        "File size must be less than 5 MB.";
      return false;
    } else if (!file.name.endsWith(".pdf")) {
      conveyanceOwnershipDocError.textContent = "Only PDF files are allowed.";
      return false;
    } else {
      conveyanceOwnershipDocError.textContent = "";
      return true;
    }
  } else {
    if (conveyanceOwnershipDoc.getAttribute("data-should-validate") == 1) {
      return true;
    }
    conveyanceOwnershipDocError.textContent =
      "Ownership document PDF is required.";
    return false;
  }
}

function validateConveyanceAadharDoc() {
  if (conveyanceAadharDoc.files.length > 0) {
    var file = conveyanceAadharDoc.files[0];
    if (file.size > 5 * 1024 * 1024) {
      conveyanceAadharDocError.textContent = "File size must be less than 5 MB.";
      return false;
    } else if (!file.name.endsWith(".pdf")) {
      conveyanceAadharDocError.textContent = "Only PDF files are allowed.";
      return false;
    } else {
      conveyanceAadharDocError.textContent = "";
      return true;
    }
  } else {
    if (conveyanceAadharDoc.getAttribute("data-should-validate") == 1) {
      return true;
    }
    conveyanceAadharDocError.textContent = "Aadhaar PDF is required.";
    return false;
  }
}

function validateConveyancePanDoc() {
  if (conveyancePanDoc.files.length > 0) {
    var file = conveyancePanDoc.files[0];
    if (file.size > 5 * 1024 * 1024) {
      conveyancePanDocError.textContent = "File size must be less than 5 MB.";
      return false;
    } else if (!file.name.endsWith(".pdf")) {
      conveyancePanDocError.textContent = "Only PDF files are allowed.";
      return false;
    } else {
      conveyancePanDocError.textContent = "";
      return true;
    }
  } else {
    if (conveyancePanDoc.getAttribute("data-should-validate") == 1) {
      return true;
    }
    conveyancePanDocError.textContent = "PAN PDF is required.";
    return false;
  }
}

function validateConveyanceConAppDoc() {
  if (conveyanceConAppDoc.files.length > 0) {
    var file = conveyanceConAppDoc.files[0];
    // Check if file size is greater than 5 MB
    if (file.size > 5 * 1024 * 1024) {
      conveyanceConAppDocError.textContent = "File size must be less than 5 MB.";
      return false;
    }
    // Check if file type is PDF
    else if (!file.name.endsWith(".pdf")) {
      conveyanceConAppDocError.textContent = "Only PDF files are allowed.";
      return false;
    }
    // File is valid
    else {
      conveyanceConAppDocError.textContent = "";
      return true;
    }
  } else {
    // Skip validation if no file is selected and "data-should-validate" is not 1
    if (conveyanceConAppDoc.getAttribute("data-should-validate") == 1) {
      conveyanceConAppDocError.textContent = "";
      return true; // Skip the validation and return true as no file is required
    }
    // No file selected, and validation is not required
    conveyanceConAppDocError.textContent = "";
    return true;
  }
}

function validateAgreeConsentNoc() {
  if (!agreeConsentNoc.checked) {
    agreeConsentNocError.textContent = "Please accept terms & conditions.";
    agreeConsentNocError.style.display = "block";
    return false;
  } else {
    agreeConsentNocError.style.display = "none";
    return true;
  }
}

// Store noc 2 step form details - Lalit Tiwari (17/march/2025)
function nocFinalStep(callback) {
  var updateId = $("input[name='updateId']").val();

  var conveyancedeedDateOfAttestation = $(
    "input[name='conveyancedeedDateOfAttestation']"
  ).val();
  var conveyancedeedAttestedBy = $(
    "input[name='conveyancedeedAttestedBy']"
  ).val();
  var agreeConsent = $("#agreeConsentNoc").is(":checked") ? 1 : 0;

  var baseUrl = getBaseURL();
  var csrfToken = $('meta[name="csrf-token"]').attr("content");
  $.ajax({
    url: baseUrl + "/noc-final-step",
    type: "POST",
    dataType: "JSON",
    data: {
      _token: csrfToken,
      updateId: updateId,
      conveyancedeedDateOfAttestation: conveyancedeedDateOfAttestation,
      conveyancedeedAttestedBy: conveyancedeedAttestedBy,
      agreeConsent: agreeConsent,
    },
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
// End NOC step 2 form validation anil 21-03-2025

// add common function for all application power of attorney file input by anil on 22-04-2025
function validatePowerAttorney(stepAttr) {
  var container = document.querySelector(`[data-applicant="${stepAttr}"]`);

  if (!container) {
    console.warn(`Container with data-step="${stepAttr}" not found`);
    return false;
  }

  var appPowerAttorney = container.querySelector("#documentpowerofattorney");
  var appPowerAttorneyError = container.querySelector(
    "#documentpowerofattorneyError"
  );

  if (
    appPowerAttorney.files.length === 0 &&
    appPowerAttorney.getAttribute("data-should-validate") != 1
  ) {
    appPowerAttorneyError.textContent = "PDF file is required.";
    return false;
  }

  if (appPowerAttorney.files.length > 0) {
    const PowerAttorneyFile = appPowerAttorney.files[0];
    console.log(appPowerAttorney, PowerAttorneyFile);
    const fileName = PowerAttorneyFile.name.toLowerCase();

    if (!fileName.endsWith(".pdf")) {
      appPowerAttorneyError.textContent = "Only PDF files are allowed.";
      return false;
    }

    if (PowerAttorneyFile.size > 5 * 1024 * 1024) {
      appPowerAttorneyError.textContent = "File size must be less than 5 MB.";
      return false;
    }
  }
  appPowerAttorneyError.textContent = "";
  return true;
}

function validatePOADoc(container) {
  var applicantStatus = $("select[name='mutStatusOfApplicant']").val();
  let isPoAValid = true;
  if (applicantStatus === "1581") {
    isPoAValid = validatePowerAttorney(container); // direct validation
  }
  return isPoAValid;
}

// End common function for all application power of attorney file input by anil on 22-04-2025

// add common function for all application other document file input by anil on 22-04-2025
function validateAppOtherDoc(stepAttr) {
  var otherDocContainer = document.querySelector(
    `[data-applicant="${stepAttr}"]`
  );

  if (!otherDocContainer) {
    console.warn(`Container with data-step="${stepAttr}" not found`);
    return false;
  }

  var otherDocApp = otherDocContainer.querySelector(
    "#otherDocumentbyApplicant"
  );
  var otherDocAppError = otherDocContainer.querySelector(
    "#otherDocumentbyApplicantError"
  );

  if (!otherDocApp || !otherDocAppError) {
    console.warn("File input or error message element not found.");
    return false;
  }

  // If no file is selected, just return true (no error)
  if (otherDocApp.files.length === 0) {
    otherDocAppError.textContent = "";
    return true;
  }

  // If file is selected, perform file format and size validation
  var file = otherDocApp.files[0];

  // Check file size (less than 5MB)
  if (file.size > 5 * 1024 * 1024) {
    otherDocAppError.textContent = "File size must be less than 5 MB.";
    return false;
  }

  // Check if the file is a PDF
  if (!file.name.endsWith(".pdf")) {
    otherDocAppError.textContent = "Only PDF files are allowed.";
    return false;
  }

  // If everything is valid, clear the error message
  otherDocAppError.textContent = "";
  return true;
}
//End common function for all application other document file input by anil on 22-04-2025

// add common function for draft for remove "View saved document" link when a new file is uploaded, by anil on 22-04-2025
document.addEventListener("change", function (e) {
  if (e.target && e.target.matches('input[type="file"]')) {
    const fileInput = e.target;

    if (fileInput.files.length > 0) {
      const formGroup = fileInput.closest(".form-group");

      if (formGroup) {
        const links = formGroup.querySelectorAll("a");

        links.forEach((link) => {
          const linkText = link.textContent.trim().toLowerCase();
          if (
            linkText.startsWith("view uploaded") ||
            linkText.startsWith("view saved")
          ) {
            link.remove();
          }
        });

        // Remove the data-should-validate attribute after removing the link
        fileInput.removeAttribute("data-should-validate");
      }
    }
  }
});
// End common function for draft for remove "View saved document" link when a new file is uploaded, by anil on 22-04-2025

// add new function for edit additional documents and remark form validation by anil on 24-04-2025
function validateEditDoc() {
  let isEditDocFormValid = true;

  // Loop through each .items (document form group)
  $("#file-inputs-container .items").each(function () {
    const $editDocForm = $(this);

    const $docTitleInput = $editDocForm.find(
      "input[name='additional_document_titles[]']"
    );
    const $docFileInput = $editDocForm.find(
      "input[name='additional_documents[]']"
    );

    if ($docTitleInput.length === 0 && $docFileInput.length === 0) return;

    const editDocTitleVal = $docTitleInput.val()?.trim() || "";
    const editDocFileVal = $docFileInput[0]?.files[0];

    // ✅ Skip validation if both title and file are empty
    if (!editDocTitleVal && !editDocFileVal) {
      $docTitleInput.siblings(".text-danger").text("");
      $docFileInput.siblings(".text-danger").text("");
      return;
    }

    let editDocHasError = false;

    // Check if one is filled but the other is not
    if (
      (editDocTitleVal && !editDocFileVal) ||
      (!editDocTitleVal && editDocFileVal)
    ) {
      editDocHasError = true;

      if (!editDocTitleVal) {
        $docTitleInput
          .siblings(".text-danger")
          .text("Title is required when document is uploaded.");
      } else {
        $docTitleInput.siblings(".text-danger").text("");
      }

      if (!editDocFileVal) {
        $docFileInput
          .siblings(".text-danger")
          .text("Document is required when title is provided.");
      } else {
        $docFileInput.siblings(".text-danger").text("");
      }
    }

    // Validate title format
    if (editDocTitleVal) {
      if (!/^[A-Za-z\s]+$/.test(editDocTitleVal)) {
        editDocHasError = true;
        $docTitleInput
          .siblings(".text-danger")
          .text("Title must contain letters only.");
      } else {
        $docTitleInput.siblings(".text-danger").text("");
      }
    }

    // Validate file format and size
    if (editDocFileVal) {
      const fileName = editDocFileVal.name.toLowerCase();
      const fileSize = editDocFileVal.size;

      if (!fileName.endsWith(".pdf")) {
        editDocHasError = true;
        $docFileInput
          .siblings(".text-danger")
          .text("Only PDF files are allowed.");
      } else if (fileSize > 5 * 1024 * 1024) {
        editDocHasError = true;
        $docFileInput
          .siblings(".text-danger")
          .text("File size must be less than 5MB.");
      } else {
        $docFileInput.siblings(".text-danger").text("");
      }
    }

    if (editDocHasError) {
      isEditDocFormValid = false;
    }
  });

  // ✅ Validate mandatory textarea outside of file container
  const $additionalRemarkTextarea = $("textarea[name='additionalRemark']");
  const $additionalRemarkError = $("#additionalRemark");
  const additionalRemarkVal = $additionalRemarkTextarea.val()?.trim() || "";

  if (!additionalRemarkVal) {
    isEditDocFormValid = false;
    $additionalRemarkError.text("Remark is required.");
  } else if (additionalRemarkVal.length > 500) {
    isEditDocFormValid = false;
    $additionalRemarkError.text("Remark must be under 500 characters.");
  } else {
    $additionalRemarkError.text("");
  }

  return isEditDocFormValid;
}

function validateEditAdditionalDocuments() {
  var isEditDoc = validateEditDoc();
  return isEditDoc;
}

// Get all buttons with class 'edit-step3'
var editFinalSubmit = document.getElementsByClassName("edit-step3");

Array.from(editFinalSubmit).forEach((btn) => {
  btn.addEventListener("click", function (event) {
    // Get application type and status from the form
    var applicationType = $("select[name='applicationType']").val();

    // Check if application type is valid and if additional documents are valid
    const validTypesName = ["CONVERSION", "SUB_MUT", "NOC"];

    // If validation passes, set text and disable the button
    if (
      validTypesName.includes(applicationType) &&
      validateEditAdditionalDocuments()
    ) {
      btn.textContent = "Submitting..."; // Change button text
      btn.disabled = true; // Disable button to prevent double submission
      // Submit the parent form manually
      btn.closest("form").submit();
    } else {
      // Prevent form submission if validation fails
      event.preventDefault();
      btn.disabled = false; // Re-enable the button in case of validation failure
    }
  });
});

// End new function for edit additional documents and remark form validation by anil on 24-04-2025
