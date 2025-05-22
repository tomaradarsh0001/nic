var baseUrl = getBaseURL();
var totalAmountToPay = 0;
function getBaseURL() {
  const { protocol, hostname, port } = window.location;
  return `${protocol}//${hostname}${port ? ":" + port : ""}/edharti`;
}
$(document).on("change", ".amountToPay", function () {
  var num = +$(this).val();
  var max = +$(this).attr("max");
  if (num <= 0 || (max > 0 && num > max)) {
    $(this).val("");
  }
  updateTotalAmount();
});
$(document).on("click", "#btnSubmitDemandPayment", function () {
  if (totalAmountToPay > 0)
    $(document).find("#form-part-2").removeClass("d-none");
});

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

function updateTotalAmount() {
  totalAmountToPay = 0;
  $(document)
    .find(".amountToPay")
    .each(function () {
      var num = parseFloat($(this).val());
      var max = parseFloat($(this).attr("max"));
      if (num != "" && num > 0 && num <= max) {
        totalAmountToPay += num;
      }
    });
  console.log(totalAmountToPay);
  $(document)
    .find("#totalAmountToPay")
    .text(`₹ ${customNumFormat(totalAmountToPay)}`);
}
