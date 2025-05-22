jQuery.fn.extend({
  createRepeater: function (options = {}) {
    console.log("createRepeater");
    var hasOption = function (optionKey) {
      return options.hasOwnProperty(optionKey);
    };
    var option = function (optionKey) {
      return options[optionKey];
    };
    var generateId = function (string) {
      return string.replace(/\[/g, "_").replace(/\]/g, "").toLowerCase();
    };
    var addItem = function (items, key, fresh = true) {
      var itemContent = items;
      var group = itemContent.data("group");
      var item = itemContent;
      var input = item.find("input,select,textarea");
      input.each(function (index, el) {
        var attrName = $(el).data("name");
        var skipName = $(el).data("skip-name");
        if (skipName != true) {
          $(el).attr("name", group + "[" + key + "]" + "[" + attrName + "]");
        } else {
          if (attrName != "undefined") {
            $(el).attr("name", attrName);
          }
        }
        // if (fresh == true) {
        //     $(el).attr('value', '');
        // }
        $(el).attr("id", generateId($(el).attr("name")));
        $(el)
          .parent()
          .find("label")
          .attr("for", generateId($(el).attr("name")));
      });
      var itemClone = items;
      /* Handling remove btn */
      var removeButton = itemClone.find(".remove-btn");
      if (key == 0) {
        removeButton.attr("disabled", true);
      } else {
        removeButton.attr("disabled", false);
      }
      removeButton.attr("onclick", "$(this).parents('.items').remove()");
      var newItem = $("<div class='items'>" + itemClone.html() + "<div/>");
      newItem.attr("data-index", key);
      newItem.appendTo(repeater);
    };
    /* find elements */
    var repeater = this;
    var items = repeater.find(".items");
    var key = 0;
    var addButton = repeater.find(".repeater-add-btn");
    items.each(function (index, item) {
      items.remove();
      if (
        hasOption("showFirstItemToDefault") &&
        option("showFirstItemToDefault") == true
      ) {
        addItem($(item), key);
        key++;
      } else {
        if (items.length > 1) {
          addItem($(item), key);
          key++;
        }
      }
    });
    /* handle click and add items */
    addButton.on("click", function () {
      addItem($(items[0]), key);
      key++;
    });
  },
});
$(document).ready(function () {
  $(document).on("click", ".newly-added-remove-btn", function () {
    $(this).closest(".items").remove();
  });
  $(document).on("click", ".newly-added-remove-btn-conversion", function () {
    $(this).closest(".items").remove();
  });
  $(".repeater-add-btn-in-favor").click(function () {
    var newItem = `
              <div class="items" data-group="test">
                  <div class="item-content">
                      <div class="mb-3">
                          <label for="inFavorNew" class="form-label">Name</label>
                          <input type="text" class="form-control form-required alpha-only" name="in_favor_new[]" id="in_favor_new" placeholder="Name" data-name="name">
                          <div class="text-danger"></div>
                      </div>
                  </div>
                  <div class="repeater-remove-btn">
                      <button type="button" class="btn btn-danger remove-btn newly-added-remove-btn px-4" data-toggle="tooltip" data-placement="bottom" title="Click on to delete this form">
                          <i class="fadeIn animated bx bx-trash"></i>
                      </button>
                  </div>
              </div>
          `;
    $(".duplicate-field-tab-in-favor").append(newItem);
  });
  var index = 0;
  $(".repeater-add-btn-in-favor-conversion").click(function () {
    var newItem = `
          <div class="items" data-group="test">
              <div class="item-content row">
                  <div class="mb-3 col-lg-12 col-12">
                      <label for="newInFavourConversion" class="form-label">Name</label>
                      <input type="text" name="newInFavourConversion[]" id="newInFavourConversion${index}" class="form-control form-required alpha-only" placeholder="Name" data-name="name">
                      <div class="text-danger"></div>
                  </div>
              </div>
              <div class="repeater-remove-btn">
                  <button type="button" class="btn btn-danger remove-btn-conversion newly-added-remove-btn-conversion px-4" data-toggle="tooltip" data-placement="bottom" title="Click on delete this form" onclick="$(this).parents('.items').remove()">
                      <i class="fadeIn animated bx bx-trash"></i>
                  </button>
              </div>
              <div></div>
          </div>
      `;
    index++;
    $(".duplicate-field-tab-conversion").append(newItem);

  });
  // Function to allow only alphabetic characters and spaces
  function allowOnlyAlphabets(input) {
    $(input).on("input", function () {
      this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
    });
  }
  // Attach the function to dynamically added input fields
  $(document).on("input", ".alpha-only", function () {
    allowOnlyAlphabets(this);
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
});
