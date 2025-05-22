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
            return string
                .replace(/\[/g, '_')
                .replace(/\]/g, '')
                .toLowerCase();
        };

        var addItem = function (items, key, fresh = true) {
            var itemContent = items;
            var group = itemContent.data("group");
            var item = itemContent;
            var input = item.find('input,select,textarea');

            input.each(function (index, el) {
                var attrName = $(el).data('name');
                var skipName = $(el).data('skip-name');
                if (skipName != true) {
                    $(el).attr("name", group + "[" + key + "]" + "[" + attrName + "]");
                } else {
                    if (attrName != 'undefined') {
                        $(el).attr("name", attrName);
                    }
                }
                if (fresh == true) {
                    $(el).attr('value', '');
                }

                $(el).attr('id', generateId($(el).attr('name')));
                $(el).parent().find('label').attr('for', generateId($(el).attr('name')));
            })

            var itemClone = items;

            /* Handling remove btn */
            var removeButton = itemClone.find('.remove-btn');

            if (key == 0) {
                removeButton.attr('disabled', true);
            } else {
                removeButton.attr('disabled', false);
            }

            removeButton.attr('onclick', '$(this).parents(\'.items\').remove()');

            var newItem = $("<div class='items'>" + itemClone.html() + "<div/>");
            newItem.attr('data-index', key)

            newItem.appendTo(repeater);
        };

        /* find elements */
        var repeater = this;
        var items = repeater.find(".items");
        var key = 0;
        var addButton = repeater.find('.repeater-add-btn');

        items.each(function (index, item) {
            items.remove();
            if (hasOption('showFirstItemToDefault') && option('showFirstItemToDefault') == true) {
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
            $(function () {
                $('.alpha-only').keypress(function (event) {
                    var charCode = event.which;
                    // Allow only alphabetic characters (a-z, A-Z), space (32), and dot (46)
                    if (
                        (charCode < 65 || (charCode > 90 && charCode < 97) || charCode > 122) &&
                        charCode !== 32 && charCode !== 46
                    ) {
                        event.preventDefault();
                    }
                });
                $('.numericDecimal').on('input', function () {
                    var value = $(this).val();
                    if (!/^\d*\.?\d*$/.test(value)) {
                        $(this).val(value.slice(0, -1));
                    }
                });

                $(".numericOnly").on('input', function (e) {
                    $(this).val($(this).val().replace(/[^0-9]/g, ''));
                });

                $('.alphaNum-hiphenForwardSlash').on('input', function () {
                    var value = $(this).val();
                    // Allow only alphanumeric, hyphen, and forward slash
                    var filteredValue = value.replace(/[^a-zA-Z0-9\-\/]/g, '');
                    $(this).val(filteredValue);
                });

                //   Date Format
                $('.date_format').on('input', function (e) {
                    var input = $(this).val().replace(/\D/g, '');
                    if (input.length > 8) {
                        input = input.substring(0, 8);
                    }

                    var formattedDate = '';
                    if (input.length > 0) {
                        formattedDate = input.substring(0, 2);
                    }
                    if (input.length >= 3) {
                        formattedDate += '-' + input.substring(2, 4);
                    }
                    if (input.length >= 5) {
                        formattedDate += '-' + input.substring(4, 8);
                    }

                    $(this).val(formattedDate);
                });

                // Plot No.
                $('.plotNoAlpaMix').on('input', function () {
                    var pattern = /[^a-zA-Z0-9+\-/]/g;
                    var sanitizedValue = $(this).val().replace(pattern, '');
                    $(this).val(sanitizedValue);
                });
            });
        });
    }
});
