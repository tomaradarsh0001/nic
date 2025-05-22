document.addEventListener("DOMContentLoaded", function() {
    var numericInput = document.getElementById('blockno');
  
    // Add event listener for input
    numericInput.addEventListener('input', function(event) {
      var inputValue = event.target.value;
  
      // Remove non-numeric characters using regular expression
      var numericValue = inputValue.replace(/\D/g, '');
  
      // Update input value
      event.target.value = numericValue;
    });
  });
  document.addEventListener("DOMContentLoaded", function() {
    var numericInput = document.getElementById('plotno');
  
    // Add event listener for input
    numericInput.addEventListener('input', function(event) {
      var inputValue = event.target.value;
  
      // Remove non-numeric characters using regular expression
      var numericValue = inputValue.replace(/\D/g, '');
  
      // Update input value
      event.target.value = numericValue;
    });
  });

  document.addEventListener("DOMContentLoaded", function() {
    var numericInput = document.getElementById('aadharnumber');
  
    // Add event listener for input
    numericInput.addEventListener('input', function(event) {
      var inputValue = event.target.value;
  
      // Remove non-numeric characters using regular expression
      var numericValue = inputValue.replace(/\D/g, '');
  
      // Update input value
      event.target.value = numericValue;
    });
  });



  const transferredCheckboxYes = document.getElementById('transferredFormYes');
  const transferredCheckboxNo = document.getElementById('transferredFormNo');

  const transferredContainer = document.getElementById('transferredContainer');

  transferredCheckboxYes.addEventListener('change', function () {
    if (this.checked) {
      transferredContainer.style.display = 'block'; // Show the div if checkbox is checked
    } else {
      transferredContainer.style.display = 'none'; // Hide the div if checkbox is not checked
    }
  });

  transferredCheckboxNo.addEventListener('change', function () {
    if (this.checked) {
      transferredContainer.style.display = 'none'; // Show the div if checkbox is checked
    } else {
      transferredContainer.style.display = 'block'; // Hide the div if checkbox is not checked
    }
  });


  // Free Hold

  const freeHoldCheckboxYes = document.getElementById('freeHoldFormYes');
  const freeHoldCheckboxNo = document.getElementById('freeHoldFormNo');

  const freeHoldContainer = document.getElementById('freeHoldContainer');

  freeHoldCheckboxYes.addEventListener('change', function () {
    if (this.checked) {
      freeHoldContainer.style.display = 'block'; // Show the div if checkbox is checked
    } else {
      freeHoldContainer.style.display = 'none'; // Hide the div if checkbox is not checked
    }
  });

  freeHoldCheckboxNo.addEventListener('change', function () {
    if (this.checked) {
      freeHoldContainer.style.display = 'none'; // Show the div if checkbox is checked
    } else {
      freeHoldContainer.style.display = 'block'; // Hide the div if checkbox is not checked
    }
  });


    // Land Type

    const landTypeCheckboxYes = document.getElementById('landTypeFormYes');
    const landTypeCheckboxNo = document.getElementById('landTypeFormNo');
  
    const landTypeContainer = document.getElementById('landTypeContainer');
  
    landTypeCheckboxYes.addEventListener('change', function () {
      if (this.checked) {
        landTypeContainer.style.display = 'block'; // Show the div if checkbox is checked
      } else {
        landTypeContainer.style.display = 'none'; // Hide the div if checkbox is not checked
      }
    });
  
    landTypeCheckboxNo.addEventListener('change', function () {
      if (this.checked) {
        landTypeContainer.style.display = 'none'; // Show the div if checkbox is checked
      } else {
        landTypeContainer.style.display = 'block'; // Hide the div if checkbox is not checked
      }
    });

        // Land Type : Others

        const landTypeOthersCheckboxYes = document.getElementById('landTypeFormOthersYes');
        const landTypeOthersCheckboxNo = document.getElementById('landTypeFormOthersNo');
      
        const landTypeOthersContainer = document.getElementById('landTypeOthersContainer');
      
        landTypeOthersCheckboxYes.addEventListener('change', function () {
          if (this.checked) {
            landTypeOthersContainer.style.display = 'block'; // Show the div if checkbox is checked
          } else {
            landTypeOthersContainer.style.display = 'none'; // Hide the div if checkbox is not checked
          }
        });
      
        landTypeOthersCheckboxNo.addEventListener('change', function () {
          if (this.checked) {
            landTypeOthersContainer.style.display = 'none'; // Show the div if checkbox is checked
          } else {
            landTypeOthersContainer.style.display = 'block'; // Hide the div if checkbox is not checked
          }
        });


        // GR

        const GRCheckboxYes = document.getElementById('GRFormYes');
        const GRCheckboxNo = document.getElementById('GRFormNo');
      
        const GRContainer = document.getElementById('GRContainer');
      
        GRCheckboxYes.addEventListener('change', function () {
          if (this.checked) {
            GRContainer.style.display = 'block'; // Show the div if checkbox is checked
          } else {
            GRContainer.style.display = 'none'; // Hide the div if checkbox is not checked
          }
        });
      
        GRCheckboxNo.addEventListener('change', function () {
          if (this.checked) {
            GRContainer.style.display = 'none'; // Show the div if checkbox is checked
          } else {
            GRContainer.style.display = 'block'; // Hide the div if checkbox is not checked
          }
        });

                // Supplementary

                const SupplementaryCheckboxYes = document.getElementById('SupplementaryFormYes');
                const SupplementaryCheckboxNo = document.getElementById('SupplementaryFormNo');
              
                const SupplementaryContainer = document.getElementById('SupplementaryContainer');
              
                SupplementaryCheckboxYes.addEventListener('change', function () {
                  if (this.checked) {
                    SupplementaryContainer.style.display = 'block'; // Show the div if checkbox is checked
                  } else {
                    SupplementaryContainer.style.display = 'none'; // Hide the div if checkbox is not checked
                  }
                });
              
                SupplementaryCheckboxNo.addEventListener('change', function () {
                  if (this.checked) {
                    SupplementaryContainer.style.display = 'none'; // Show the div if checkbox is checked
                  } else {
                    SupplementaryContainer.style.display = 'block'; // Hide the div if checkbox is not checked
                  }
                });
        
        // Re-Entered

        const ReenteredCheckboxYes = document.getElementById('ReenteredFormYes');
        const ReenteredCheckboxNo = document.getElementById('ReenteredFormNo');
      
        const ReenteredContainer = document.getElementById('ReenteredContainer');
      
        ReenteredCheckboxYes.addEventListener('change', function () {
          if (this.checked) {
            ReenteredContainer.style.display = 'block'; // Show the div if checkbox is checked
          } else {
            ReenteredContainer.style.display = 'none'; // Hide the div if checkbox is not checked
          }
        });
      
        ReenteredCheckboxNo.addEventListener('change', function () {
          if (this.checked) {
            ReenteredContainer.style.display = 'none'; // Show the div if checkbox is checked
          } else {
            ReenteredContainer.style.display = 'block'; // Hide the div if checkbox is not checked
          }
        });