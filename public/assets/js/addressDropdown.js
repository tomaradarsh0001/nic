/** address dropdowns */

$(document).on("change", "#country_select", function () {
  var selectedVal = $(this).val();
  var stateSelect = $(document).find("#state_select");
  stateSelect.empty();
  if (selectedVal != "") {
    $.ajax({
      type: "get",
      url: getBaseURL() + "/country-state-list" + "/" + selectedVal,
      success: function (response) {
        if (response.data) {
          var data = response.data;
          stateSelect.append('<option value="">Select</option>');
          data.forEach((row) => {
            stateSelect.append(
              `<option value="${row.id}">${row.name}</option>`
            );
          });
        } else {
          showError(response.details ?? "Something went wrong !!");
        }
      },
    });
  }
});

$(document).on("change", "#state_select", function () {
  var selectedVal = $(this).val();
  var citySelect = $(document).find("#city_select");
  citySelect.empty();
  if (selectedVal != "") {
    $.ajax({
      type: "get",
      url: getBaseURL() + "/state-city-list" + "/" + selectedVal,
      success: function (response) {
        if (response.data) {
          var data = response.data;
          citySelect.append('<option value="">Select</option>');
          data.forEach((row) => {
            citySelect.append(`<option value="${row.id}">${row.name}</option>`);
          });
        } else {
          showError(response.details ?? "Something went wrong !!");
        }
      },
    });
  }
});
