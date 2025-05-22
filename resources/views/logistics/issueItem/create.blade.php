@extends('layouts.app')

@section('title', 'Issue Items')

@section('content')

    <style>
        .alert-danger {
            display: none !important;
        }

        .warning_icon {
            width: 80px;
            margin-bottom: 10px;
        }

        .required::after {
            content: " *";
            color: red;
        }
    </style>

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Logistic Management</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Issue New Items</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end py-3">
                <a href="{{ route('requested_item.index') }}">
                    <button type="button" class="btn btn-danger px-2 mx-2">← Back</button>
                </a>
            </div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('issued_item.store') }}" method="POST" id="issueItemsForm">
                @csrf
                <div id="repeater-container">
                    <div class="repeater-item">
                        <div class="row m-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="logistic_items_id" class="required">Select Item</label>
                                    <select name="items[0][logistic_items_id]" id="logistic_items_id"
                                        class="form-select item-select" required>
                                        <option value="">Select</option>
                                        @foreach ($logisticItems as $item)
                                            <option value="{{ $item->id }}" data-category-id="{{ $item->category_id }}"
                                                data-available-units="{{ $availableUnits[$item->id] ?? 0 }}">
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="error-message" style="color: red; display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id" class="required">Category</label>
                                    <select name="items[0][category_id]" id="category_id"
                                        class="form-select category-select" required>
                                        <option value="">Select</option>
                                        @foreach ($logisticCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="error-message" style="color: red; display: none;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="available_units">Available Units</label>
                                    <input type="text" name="items[0][available_units]" id="available_units"
                                        class="form-control available-units" value="0" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="issued_units" class="required">Issued Units</label>
                                    <input type="number" name="items[0][issued_units]" id="issued_units"
                                        class="form-control issued-units" required>
                                    <div class="error-message" style="color: red; display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user_id" class="required">User</label>
                                    <select name="items[0][user_id]" id="user_id" class="form-select" required>
                                        <option value="">Select</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="error-message" style="color: red; display: none;"></div>
                                </div>
                            </div>
                            <div class="col-md-1 mt-3 text-end">
                                <button type="button" class="btn btn-danger remove-btn px-4 py-2" data-toggle="tooltip"
                                    title="Click to delete this form" data-bs-target="#ModalDelete" disabled>
                                    <i class="fadeIn animated bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="d-flex justify-content-end p-3">
                    <button type="button" id="duplicate-form" class="btn btn-outline-primary repeater-add-btn"
                        data-toggle="tooltip" title="Add more items" data-placement="bottom">
                        <i class="bx bx-plus me-0"></i>
                    </button>
                </div>
                <button type="button" class="btn btn-primary mx-3 mb-4" id="openSubmitModal">Submit</button>
            </form>
        </div>
    </div>

    @include('include.alerts.delete-confirmation')
    @include('include.alerts.submit-confirmation')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            var repeaterIndex = 1;
            var repeaterToDelete;

            function initializeSelect2() {
                $('.item-select').select2({
                    placeholder: "Select an item",
                    allowClear: true
                });
            }

            function updateDropdowns() {
                // Keeping all items available in each repeater
            }

            function updateCategorySelect(itemSelect) {
                var categoryId = itemSelect.find('option:selected').data('category-id');
                var categorySelect = itemSelect.closest('.repeater-item').find('.category-select');
                categorySelect.val(categoryId);
            }

            function updateAvailableUnits(itemSelect) {
                var availableUnits = itemSelect.find('option:selected').data('available-units');
                var availableUnitsInput = itemSelect.closest('.repeater-item').find('.available-units');
                availableUnitsInput.val(availableUnits);
            }

            function validateIssuedUnits() {
                var isValid = true;
                $('.repeater-item').each(function() {
                    var availableUnits = parseInt($(this).find('.available-units').val(), 10);
                    var issuedUnitsInput = $(this).find('[name$="[issued_units]"]');
                    var issuedUnits = issuedUnitsInput.val();
                    var errorMessage = $(this).find('.issued-units').next('.error-message');

                    if (issuedUnits === "") {
                        errorMessage.text('Issued units cannot be blank.');
                        errorMessage.show();
                        isValid = false;
                    } else if (issuedUnits < 1) {
                        errorMessage.text('Issued units cannot be less than 1.');
                        errorMessage.show();
                        isValid = false;
                    } else if (issuedUnits > availableUnits) {
                        errorMessage.text('Issued units cannot exceed available units.');
                        errorMessage.show();
                        isValid = false;
                    } else {
                        errorMessage.hide();
                    }
                });
                return isValid;
            }

            function validateSelections() {
                var isValid = true;
                $('.repeater-item').each(function() {
                    var itemSelect = $(this).find('.item-select');
                    var categorySelect = $(this).find('.category-select');
                    var userSelect = $(this).find('[name$="[user_id]"]');
                    var itemErrorMessage = itemSelect.next('.error-message');
                    var categoryErrorMessage = categorySelect.next('.error-message');
                    var userErrorMessage = userSelect.next('.error-message');

                    if (itemSelect.val() === "") {
                        itemErrorMessage.text('Item selection is mandatory.');
                        itemErrorMessage.show();
                        isValid = false;
                    } else {
                        itemErrorMessage.hide();
                    }

                    if (categorySelect.val() === "") {
                        categoryErrorMessage.text('Category selection is mandatory.');
                        categoryErrorMessage.show();
                        isValid = false;
                    } else {
                        categoryErrorMessage.hide();
                    }

                    if (userSelect.val() === "") {
                        userErrorMessage.text('User selection is mandatory.');
                        userErrorMessage.show();
                        isValid = false;
                    } else {
                        userErrorMessage.hide();
                    }
                });
                return isValid;
            }

            $('#duplicate-form').click(function() {
                var newRepeaterItem = $('.repeater-item:first').clone();
                newRepeaterItem.find('select, input').each(function() {
                    var name = $(this).attr('name');
                    var newName = name.replace(/\d+/, repeaterIndex);
                    $(this).attr('name', newName).val('');
                });
                newRepeaterItem.find('.available-units').val('0');

                newRepeaterItem.find('.remove-btn').removeAttr('disabled');

                newRepeaterItem.find('.error-message').hide();

                newRepeaterItem.appendTo('#repeater-container');
                $('<hr>').appendTo('#repeater-container');
                repeaterIndex++;

                // Ensure all items are available in each repeater
                newRepeaterItem.find('.item-select').html($('.item-select:first').html());

                newRepeaterItem.find('.remove-btn').click(function() {
                    repeaterToDelete = $(this).closest('.repeater-item');
                    $('#ModalDelete').modal('show');
                });

                newRepeaterItem.find('.item-select').change(function() {
                    updateCategorySelect($(this));
                    updateAvailableUnits($(this));
                });

                newRepeaterItem.find('.issued-units').on('input', function() {
                    validateIssuedUnits();
                });

                initializeSelect2();
                updateHR();
            });

            $(document).on('change', 'select[name^="items"][name$="[logistic_items_id]"]', function() {
                updateCategorySelect($(this));
                updateAvailableUnits($(this));
            });

            $(document).on('input', '[name$="[issued_units]"]', function() {
                validateIssuedUnits();
            });

            $(document).on('click', '.remove-btn', function() {
                repeaterToDelete = $(this).closest('.repeater-item');
                $('#ModalDelete').modal('show');
            });

            $('#confirmDelete').click(function() {
                repeaterToDelete.next('hr').remove();
                repeaterToDelete.remove();
                repeaterIndex--;
                $('#ModalDelete').modal('hide');
                updateHR();

                $('.repeater-item:first').find('.remove-btn').attr('disabled', 'disabled');
            });

            $('#openSubmitModal').click(function() {
                var isValid = validateIssuedUnits() && validateSelections();
                if (isValid) {
                    $('#submitModal').modal('show');
                }
            });

            $('#confirmSubmit').click(function() {
                var isValid = validateIssuedUnits() && validateSelections();
                if (isValid) {
                    $('#issueItemsForm').submit();
                }
            });

            $('.repeater-item:first').find('.remove-btn').attr('disabled', 'disabled');

            function updateHR() {
                $('#repeater-container hr').remove();
                $('#repeater-container .repeater-item').each(function(index) {
                    if (index < $('#repeater-container .repeater-item').length - 1) {
                        $(this).after('<hr>');
                    }
                });
            }

            initializeSelect2();
            updateHR();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#issueItemsForm').on('submit', function(event) {
                $('#openSubmitModal').text('Submitting...');
                $('#openSubmitModal').attr('disabled', true);
            });
        });
    </script>
@endsection
