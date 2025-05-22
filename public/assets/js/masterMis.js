//hide date of expiration
var typeLeaseSelect = document.getElementById("TypeLease");
var dateOfExpirationInput = document.getElementById("dateOfExpiration");
var dateAllotment = document.getElementById("dateallotment");
var dateExecution = document.getElementById("dateexecution");
//dateAllotment.disabled = true;
typeLeaseSelect.addEventListener("change", function () {
  var selectedValue = typeLeaseSelect.value;

  // Check if the selected value is 857
  if (selectedValue === "857") {
    dateOfExpirationInput.value = "";
    dateOfExpirationInput.disabled = true;
    dateAllotment.disabled = false;
  } else {
    dateOfExpirationInput.disabled = false;
  }

  // if (selectedValue === '1351') {
  //     dateAllotment.disabled = false;
  //     dateOfExpirationInput.disabled = true;
  //     dateExecution.disabled = true;
  //     dateOfExpirationInput.value = '';
  //     dateExecution.value = '';

  // } else {
  //     dateExecution.disabled = false;
  // }

  if (selectedValue === "1352") {
    dateOfExpirationInput.disabled = true;
    dateOfExpirationInput.value = "";
  }
});

//to calculate GR revision due date
var startDateInput = document.getElementById("startdateGR");
var numberOfYearsInput = document.getElementById("RGRduration");
var newDateInput = document.getElementById("frevisiondateGR");

if (startDateInput) {
  startDateInput.addEventListener("change", function () {
    calculateNewDate();
  });
}

if (numberOfYearsInput) {
  numberOfYearsInput.addEventListener("input", function () {
    calculateNewDate();
  });
}

function calculateNewDate() {
  var startDateValue = startDateInput.value;
  var numberOfYearsValue = numberOfYearsInput.value;

  if (numberOfYearsValue === "") {
    newDateInput.value = "";
    return;
  }

  // Parse the start date into a Date object
  var startDate = new Date(startDateValue);

  // Get the current year
  var currentYear = startDate.getFullYear();

  // Calculate the new year by adding the number of years
  var newYear = currentYear + parseInt(numberOfYearsValue);

  // Set the new year to the start date
  startDate.setFullYear(newYear);

  // Format the new date as YYYY-MM-DD
  var newDate = startDate.toISOString().substr(0, 10);

  // Set the value of the new date input field
  newDateInput.value = newDate;
}

//New duration aded after date of execution
var startDateInputNew = document.getElementById("dateexecution");
var numberOfYearsInputNew = document.getElementById("lease_exp_duration");
var newDateInputNew = document.getElementById("dateOfExpiration");

if (startDateInputNew) {
  startDateInputNew.addEventListener("change", function () {
    calculateNewDateNew();
  });
}

if (numberOfYearsInputNew) {
  numberOfYearsInputNew.addEventListener("input", function () {
    calculateNewDateNew();
  });
}

function calculateNewDateNew() {
  var startDateValueNew = startDateInputNew.value;
  var numberOfYearsValueNew = numberOfYearsInputNew.value;

  if (numberOfYearsValueNew === "") {
    newDateInputNew.value = "";
    return;
  }

  // Parse the start date into a Date object
  var startDate = new Date(startDateValueNew);

  // Get the current year
  var currentYear = startDate.getFullYear();

  // Calculate the new year by adding the number of years
  var newYear = currentYear + parseInt(numberOfYearsValueNew);

  // Set the new year to the start date
  startDate.setFullYear(newYear);

  // Format the new date as YYYY-MM-DD
  var newDate = startDate.toISOString().substr(0, 10);

  // Set the value of the new date input field
  newDateInputNew.value = newDate;
}

//calculate expiration date
var dateOfExecution = document.getElementById("dateexecution");
if (dateOfExecution) {
  dateOfExecution.addEventListener("change", function () {
    var typeLeaseSelect = document.getElementById("TypeLease");
    var selectedValue = typeLeaseSelect.value;
    if (
      selectedValue === "1347" ||
      selectedValue === "1348" ||
      selectedValue === "1369" ||
      selectedValue === "1343" ||
      selectedValue === "1344" ||
      selectedValue === "1345" ||
      selectedValue === "1346"
    ) {
      var dateOfExpiration = document.getElementById("dateOfExpiration");
      if (dateOfExecution.value === "") {
        dateOfExpiration.value = "";
        return;
      }
      var startDateNew = new Date(dateOfExecution.value);

      // Get the current year
      var currentYearNew = startDateNew.getFullYear();

      // Calculate the new year by adding the number of years
      var newYearNew = currentYearNew + parseInt(99);

      // Set the new year to the start date
      startDateNew.setFullYear(newYearNew);

      // Format the new date as YYYY-MM-DD
      var newDateNew = startDateNew.toISOString().substr(0, 10);

      // Set the value of the new date input field
      dateOfExpiration.value = newDateNew;
    }
  });
}

//property status changed
$(document).ready(function () {
  $("#submitButton1").click(function () {
    var selectedValue = $("#PropertyStatus").val();
    if (selectedValue === "951") {
      $("#property_status_free_hold").hide();
      $("#property_status_vacant").hide();
      $("#property_status_others").hide();
    }
    if (selectedValue === "952") {
      $("#property_status_free_hold").show();
      $("#property_status_vacant").hide();
      $("#property_status_others").hide();
    }
    if (selectedValue === "1124") {
      $("#property_status_free_hold").hide();
      $("#property_status_vacant").show();
      $("#property_status_others").hide();
    }
    if (selectedValue === "1342") {
      $("#property_status_free_hold").hide();
      $("#property_status_vacant").hide();
      $("#property_status_others").show();
    }
  });
});

//property status changed
// var propertyStatus = document.getElementById('PropertyStatus');
// propertyStatus.addEventListener('change', function () {
//     console.log("property status called");
//     var propertyStatusFreeHold = document.getElementById('property_status_free_hold');
//     var propertyStatusVacant = document.getElementById('property_status_vacant');
//     var propertyStatusOthers = document.getElementById('property_status_others');

//     //Radio Buttons
//     var freeHoldFormYes = document.getElementById('freeHoldFormYes');
//     var landTypeFormYes = document.getElementById('landTypeFormYes');
//     var landTypeFormOthersYes = document.getElementById('landTypeFormOthersYes');

//     //for inputs
//     var freeHoldContainer = document.getElementById('freeHoldContainer');
//     var landTypeContainer = document.getElementById('landTypeContainer');
//     var landTypeOthersContainer = document.getElementById('landTypeOthersContainer');

//     if (this.value == 951) {
//         propertyStatusFreeHold.style.display = 'none';
//         propertyStatusVacant.style.display = 'none';
//         propertyStatusOthers.style.display = 'none';

//     } else if (this.value == 952) {
//         freeHoldFormYes.checked = true;
//         freeHoldContainer.style.display = 'block';

//         propertyStatusVacant.style.display = 'none';
//         propertyStatusOthers.style.display = 'none';
//     } else if (this.value == 1124) {
//         landTypeFormYes.checked = true;
//         landTypeContainer.style.display = 'block';

//         propertyStatusFreeHold.style.display = 'none';
//         propertyStatusOthers.style.display = 'none';
//     } else if (this.value == 1342) {
//         landTypeFormOthersYes.checked = true;
//         landTypeOthersContainer.style.display = 'block';

//         propertyStatusFreeHold.style.display = 'none';
//         propertyStatusVacant.style.display = 'none';
//     }

// });

//Validation lease allotment no.
const inputField = document.getElementById("LeaseAllotmentNo");

// Add an event listener for the keypress event
inputField.addEventListener("keypress", function (event) {
  // Get the key that was pressed
  const key = event.key;

  // Define a regular expression pattern
  const pattern = /^[a-zA-Z0-9-]$/;

  // Test if the key matches the pattern
  if (!pattern.test(key)) {
    // If the key doesn't match the pattern, prevent the default behavior
    event.preventDefault();
  }
});

//maximum 5 digits allowed for property ID
function validateInputLength(input) {
  if (input.value.length > 5) {
    input.value = input.value.slice(0, 5);
  }
}

//validate only number and decimal
const inputField2 = document.getElementById("areaunitname");

// Add an event listener for the keypress event
inputField2.addEventListener("input", function (event) {
  // Get the key that was pressed
  const key = event.key;

  // Define a regular expression pattern
  const pattern = /^[0-9]+(\.[0-9]*)?$/;

  // Test if the key matches the pattern
  if (!pattern.test(key)) {
    // If the key doesn't match the pattern, prevent the default behavior
    event.preventDefault();
  }
});

document.addEventListener("DOMContentLoaded", function () {
  var numericInput = document.getElementById("plotno");

  // Add event listener for input
  numericInput.addEventListener("input", function (event) {
    var inputValue = event.target.value;

    // Remove non-numeric characters using regular expression
    //var numericValue = inputValue.replace(/[^\w\s]/g, '');
    var numericValue = inputValue.replace(/[^a-zA-Z0-9\+/-]/g, "");

    // Update input value
    event.target.value = numericValue;
  });
});

//Script from Mis Blade
//***************************************************************************************************
$(document).ready(function () {
  //landUseChange
  $("#landusechange").on("change", function () {
    if ($(this).is(":checked")) {
      $("#hideFields").show(); // Show the div if the checkbox is checked
    } else {
      $("#hideFields").hide(); // Hide the div if the checkbox is not checked
      $("#propertySubType").val("");
      $("#propertyType").val("");
    }
  });
});

$(document).ready(function () {
  // Call the function if checkbox is checked
  if ($("#landusechange").is(":checked")) {
    $("#hideFields").show();
  }
});

$(document).ready(function () {
  // Call the function if checkbox is checked
  if ($("#transferredFormYes").is(":checked")) {
    const transferredContainer = document.getElementById(
      "transferredContainer"
    );
    if (transferredContainer) {
      transferredContainer.style.display = "block";
    }
  }
});

/* Create Repeater */
$("#repeater").createRepeater({
  showFirstItemToDefault: true,
});

$("#repeater2").createRepeater({
  showFirstItemToDefault: true,
});

$("#repeater4").createRepeaterSecond({
  showFirstItemToDefault: true,
});
// Property ID PropertyID
document.addEventListener("DOMContentLoaded", function () {
  var numericInput = document.getElementById("PropertyID");
  numericInput.addEventListener("input", function (event) {
    var inputValue = event.target.value;
    var numericValue = inputValue.replace(/\D/g, "");
    event.target.value = numericValue;
  });
});
// Premium Unit 1 - Re/Rs
document.addEventListener("DOMContentLoaded", function () {
  var numericInput = document.getElementById("premiumunit1");
  numericInput.addEventListener("input", function (event) {
    var inputValue = event.target.value;
    var numericValue = inputValue.replace(/\D/g, "");
    event.target.value = numericValue;
  });
});

// Premium Unit 1 - Paise/Ana
document.addEventListener("DOMContentLoaded", function () {
  var numericInput = document.getElementById("premiumunit2");
  numericInput.addEventListener("input", function (event) {
    var inputValue = event.target.value;
    var numericValue = inputValue.replace(/\D/g, "");
    event.target.value = numericValue;
  });
});

// Ground Rent 1 - Re/Rs
document.addEventListener("DOMContentLoaded", function () {
  var numericInput = document.getElementById("groundRent1");
  numericInput.addEventListener("input", function (event) {
    var inputValue = event.target.value;
    var numericValue = inputValue.replace(/\D/g, "");
    event.target.value = numericValue;
  });
});

// Ground Rent 2 - Paise/Ana
document.addEventListener("DOMContentLoaded", function () {
  var numericInput = document.getElementById("groundRent2");
  numericInput.addEventListener("input", function (event) {
    var inputValue = event.target.value;
    var numericValue = inputValue.replace(/\D/g, "");
    event.target.value = numericValue;
  });
});

// Last Amount Received
document.addEventListener("DOMContentLoaded", function () {
  var numericInput = document.getElementById("LastAmount");
  numericInput.addEventListener("input", function (event) {
    var inputValue = event.target.value;
    var numericValue = inputValue.replace(/[^0-9.]/g, "");
    event.target.value = numericValue;
  });
});
// Area
document.addEventListener("DOMContentLoaded", function () {
  var numericInput = document.getElementById("areaunitname");
  numericInput.addEventListener("input", function (event) {
    var inputValue = event.target.value;
    var numericValue = inputValue.replace(/[^0-9.]/g, "");
    event.target.value = numericValue;
  });
});

// Last Amount Demand Letter
document.addEventListener("DOMContentLoaded", function () {
  var numericInput = document.getElementById("amountDemandLetter");
  numericInput.addEventListener("input", function (event) {
    var inputValue = event.target.value;
    var numericValue = inputValue.replace(/[^0-9.]/g, "");
    event.target.value = numericValue;
  });
});

// LRGR Duration
document.addEventListener("DOMContentLoaded", function () {
  var numericInput = document.getElementById("RGRduration");
  numericInput.addEventListener("input", function (event) {
    var inputValue = event.target.value;
    var numericValue = inputValue.replace(/\D/g, "");
    event.target.value = numericValue;
  });
});

// Phone number validation
document.addEventListener("DOMContentLoaded", function () {
  var numericInput = document.getElementById("phoneno");
  numericInput.addEventListener("input", function (event) {
    var inputValue = event.target.value;
    var numericValue = inputValue.replace(/\D/g, "");
    event.target.value = numericValue;
  });
});

// Favour Name
// $(document).ready(function () {
//     $('.alpha-only').keypress(function (event) {
//         var charCode = event.which;
//         // Allow only alphabetic characters (a-z, A-Z), space (32), and dot (46)
//         if (
//             (charCode < 65 || (charCode > 90 && charCode < 97) || charCode > 122) &&
//             charCode !== 32 && charCode !== 46
//         ) {
//             event.preventDefault();
//         }
//     });
//     $(".numericDecimal").on('input', function (e) {
//         $(this).val($(this).val().replace(/[^0-9.]/g, ''));
//     });

//     $(".numericOnly").on('input', function (e) {
//         $(this).val($(this).val().replace(/[^0-9]/g, ''));
//     });
// });

// Diwakar Sinha -> Single/Multiple Input Validation 11-06-2024
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
    $(this).val($(this).val().replace(/[^0-9]/g, ""));
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
  // Share
  $(".alphaNum_slash_modulus").on("input", function () {
    var value = $(this).val();
    var sanitizedValue = value.replace(/[^a-zA-Z0-9\/%]/g, "");
    if (value !== sanitizedValue) {
      $(this).val(sanitizedValue);
    }
  });
});
// End

// id="addTransferBtn"
