jQuery.fn.extend({
  createRepeater: function (options = {}) {
    var hasOption = function (optionKey) {
      return options.hasOwnProperty(optionKey);
    };

    var option = function (optionKey) {
      return options[optionKey];
    };

    var generateId = function (string) {
      return string.replace(/\[/g, "_").replace(/\]/g, "").toLowerCase();
    };

    var addItem = function (items, key, fresh = false, indexValue = null) {
      var itemContent = items;
      var group = itemContent.data("group");
      var item = itemContent;
      var input = item.find("input,select,textarea");
      var uniqimg = item.find("img");
      var uniqanchor = item.find("a");

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
        if (fresh == true) {
          $(el).attr("value", "");
        }

        $(el).attr("id", generateId($(el).attr("name")));
        $(el)
          .parent()
          .find("label")
          .attr("for", generateId($(el).attr("name")));
      });

      uniqimg.each(function (index, el) {
        var attrName = $(el).data("src");
        var skipName = $(el).data("skip-name");
        if (skipName != true) {
          $(el).attr("src");
        } else {
          if (attrName != "undefined") {
            $(el).attr("src", attrName);
          }
        }
        if (fresh == true) {
          $(el).attr("src", "");
          $(el).attr("style", "display: none");
        }

        // $(el).attr('id', generateId($(el).attr('src')));
        // $(el).parent().find('label').attr('for', generateId($(el).attr('name')));
      });

      uniqanchor.each(function (index, el) {
        var attrName = $(el).data("href");
        var skipName = $(el).data("skip-name");
        if (skipName != true) {
          $(el).attr("href");
        } else {
          if (attrName != "undefined") {
            $(el).attr("href", attrName);
          }
        }
        if (fresh == true) {
          $(el).attr("href", "");
          $(el).attr("style", "display: none");
        }

        // $(el).attr('id', generateId($(el).attr('href')));
        // $(el).parent().find('label').attr('for', generateId($(el).attr('name')));
      });

      //var itemClone = items;   code modified by Nitin
      var itemClone = items.clone();

      /* Handling remove btn */
      var removeButton = itemClone.find(".remove-btn");

      if (key == 0) {
        removeButton.attr("disabled", true);
      } else {
        removeButton.attr("disabled", false);
      }

      var indexInput = itemClone.find('input[data-name="indexNo"]'); //find index input

      if (indexValue) {
        // if new index then assign new index value in input
        indexInput.attr("value", indexValue);
      }
      var removeIndex = indexInput.length > 0 ? indexInput.attr("value") : null; //pass index in rmove function
      removeButton.attr(
        "onclick",
        `removeRepeater($(this).parents('.items'),${
          removeIndex != null ? removeIndex : key + 1
        })`
      );

      // var newItem = $("<div class='items'>" + itemClone.html() + "<div/>");
      var newItem = itemClone; // added by Nitin
      newItem.attr("data-index", key);
      /* newItem.attr("data-type", itemClone.data("type"));
      if (itemClone.data("documentType"))
        newItem.attr("data-document-type", itemClone.data("documentType"));
      */
      newItem.appendTo(repeater);
    };

    /* find elements */
    var repeater = this;
    var items = repeater.find(".items");
    var key = 0;
    var addButton = repeater.find(".repeater-add-btn");
    var maxIndex = getMaxIndex(items);

    items.each(function (index, item) {
      items.remove();
      if (
        hasOption("showFirstItemToDefault") &&
        option("showFirstItemToDefault") == true
      ) {
        addItem($(item), key, false);
        key++;
      } else {
        if (items.length > 1) {
          addItem($(item), key, false);
          key++;
        }
      }
    });

    /* handle click and add items */
    addButton.on("click", function () {
      addItem($(items[0]), key, true, maxIndex);
      key++;
      maxIndex++;
      $(function () {
        $(".alpha-only").keypress(function (event) {
          var charCode = event.which;
          // Allow only alphabetic characters (a-z, A-Z), space (32), and dot (46)
          if (
            (charCode < 65 ||
              (charCode > 90 && charCode < 97) ||
              charCode > 122) &&
            charCode !== 32 &&
            charCode !== 46
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
        $(".numericDecimalHyphen").on("input", function () {
          var value = $(this).val();
          if (!/^[\d-]*\.?\d*$/.test(value)) {
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
        $(".pan_number_format").on("keypress", function (event) {
          var charCode = event.which;

          if (
            charCode === 0 ||
            charCode === 8 ||
            charCode === 9 ||
            charCode === 13
          ) {
            return;
          }

          var charStr = String.fromCharCode(charCode).toUpperCase();

          var currentLength = $(this).val().length;

          if (currentLength < 5 && !/[A-Z]/.test(charStr)) {
            event.preventDefault();
          } else if (
            currentLength >= 5 &&
            currentLength < 9 &&
            !/[0-9]/.test(charStr)
          ) {
            event.preventDefault();
          } else if (currentLength === 9 && !/[A-Z]/.test(charStr)) {
            event.preventDefault();
          }
        });
        // End PAN Number
      });
    });
  },
});

function getMaxIndex(items) {
  var maxIndexArray = [];
  Array.from(items).forEach((item) => {
    indexItem = $(item).find('input[data-name="indexNo"]');
    if (indexItem) {
      maxIndexArray.push(indexItem.val());
    }
  });
  return maxIndexArray.length > 0
    ? Math.max(...maxIndexArray) + 1
    : items.length + 1;
}
