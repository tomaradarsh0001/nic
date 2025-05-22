$(document).ready(function(){
    $('.marquee ul').on('mouseover', function() {
      $(this).css('animation-play-state', 'paused');
    });
  
    $('.marquee ul').on('mouseout', function() {
      $(this).css('animation-play-state', 'running');
    });
  });
  

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
  // Alpha And Numeric Only
  $(".alphanumericonly").keypress(function (event) {
    var charCode = event.which;
    if (
      !(charCode >= 65 && charCode <= 90) &&  // uppercase letters
      !(charCode >= 97 && charCode <= 122) && // lowercase letters
      !(charCode >= 48 && charCode <= 57) &&  // numbers (0-9)
      charCode !== 32 &&                      // space
      charCode !== 46 &&                      // period (.)
      charCode !== 47                         // forward slash (/)
    ) {
      event.preventDefault();
    }
  });
    // End
});
// End