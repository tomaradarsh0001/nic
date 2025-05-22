document.addEventListener('DOMContentLoaded', function () {
    // Define the steppers object to hold all stepper instances
    var steppers = {};
  
    // Get all elements with the class 'stepper'
    var stepperElements = document.querySelectorAll('.stepper');
  
    // Loop through each stepper element and initialize it
    stepperElements.forEach(function (stepperElement) {
      var linear = stepperElement.getAttribute('data-linear') === 'true';
      var animation = stepperElement.getAttribute('data-animation') === 'true';
  
      // Initialize each stepper and store it in the steppers object
      var stepperId = stepperElement.getAttribute('id'); // Use the element's ID as a key
      steppers[stepperId] = new Stepper(stepperElement, {
        linear: linear,
        animation: animation
      });
    });
  
    // Attach the steppers object to the global scope so it can be accessed in the onclick handler
    window.steppers = steppers;
  });
  