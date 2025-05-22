@extends('layouts.app')

@section('title', 'Purchasing')

@section('content')

    <style>
        .alert-danger {
            display: none !important;
        }

        .repeater-item-template {
            display: none;
        }

        .warning_icon {
            width: 80px;
            margin-bottom: 10px;
        }

        .btn-width {
            width: 40%;
        }

        .remove-btn {
            margin-top: 28px;
        }

        .add-btn {
            background-color: #ffffff;
            color: gray;
            font-size: 10px;
            text-align: center;
            justify-content: center;
            border: 1px solid;
            border-color: gray;
            border-radius: 5px;
            cursor: pointer;
            transition: ease 1s;
            padding: 5px;
        }

        .error-message {
            color: red;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
    </style>

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Logistic</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Purchase</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form id="purchaseForm" method="POST" action="{{ route('logistic_purchase.store') }}">
                @csrf

                <div class="common-form m-3"
                    style="border: 1px solid #ddd; padding: 5px; margin-bottom: 10px; border-radius: 5px;">
                    <div class="form-row m-3">
                        <div class="form-group col-md-6">
                            <label class="form-label" for="vendor_supplier_id">Vendor Supplier Name: <span
                                    class="text-danger">*</span></label>
                            <a href="{{ route('supplier.index') }}" class="add-btn">&plus;&nbsp;Add Vendors</a>
                            <select id="vendor_supplier_id" name="vendor_supplier_id" class="form-select mb-3"
                                aria-label="Default select example">
                                <option value="">Select</option>
                                @foreach ($purchaseVendor as $data)
                                    @if ($data->status != 'inactive')
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('vendor_supplier_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label class="form-label" for="purchased_date">Purchased Date: <span
                                    class="text-danger">*</span></label>
                            <input type="date" id="purchased_date" name="purchased_date" class="form-control">
                            @error('purchased_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row m-3">
                        @include('logistics.purchase.repeater-create', [
                            'prefix' => '',
                            'purchaseCategory' => $purchaseCategory,
                            'purchaseItem' => $purchaseItem,
                        ])
                    </div>
                    <hr> <!-- Add hr here after initial repeater -->

                    <!-- Repeater Section -->
                    <div id="repeater-container">
                        <div class="repeater-box repeater-item-template">
                            <div class="row m-1 mb-3 align-items-center">
                                @include('logistics.purchase.repeater-create', [
                                    'prefix' => 'repeater[0][',
                                    'purchaseCategory' => $purchaseCategory,
                                    'purchaseItem' => $purchaseItem,
                                ])
                                <div class="col-md-1">
                                    <div class="text-end">
                                        <button type="button" class="btn btn-danger remove-btn px-4" data-toggle="tooltip"
                                            title="Click to delete this form" data-bs-target="#ModalDelete">
                                            <i class="fadeIn animated bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end p-3">
                        <button type="button" id="duplicate-form" class="btn btn-outline-primary repeater-add-btn"
                            class="btn btn-outline-primary repeater-add-btn" data-toggle="tooltip" title="Add more items"
                            data-placement="bottom">
                            <i class="bx bx-plus me-0"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-primary mx-3 mb-4" id="openSubmitModal">Submit</button>

                </div>

            </form>
        </div>
    </div>

    @include('include.alerts.delete-confirmation')
    @include('include.alerts.submit-confirmation') <!-- Include the submit confirmation modal -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var repeaterIndex = 1;
            var repeaterToDelete;

            function disableSelectedItems() {
                var selectedItems = [];

                $('select[name="logistic_items_id"], select[name^="repeater"][name$="[logistic_items_id]"]').each(
                    function() {
                        if ($(this).val() !== "") {
                            selectedItems.push($(this).val());
                        }
                    });

                $('select[name="logistic_items_id"], select[name^="repeater"][name$="[logistic_items_id]"]').each(
                    function() {
                        var currentVal = $(this).val();
                        $(this).find('option').each(function() {
                            if (selectedItems.includes($(this).val()) && $(this).val() !== currentVal) {
                                $(this).remove();
                            }
                        });
                    });
            }

            function updateCategory(selectElement) {
                var logisticItems = @json($purchaseItem->keyBy('id'));
                var selectedItemId = selectElement.val();
                var categorySelect = selectElement.closest('.form-row, .row').find(
                    'select[name$="[category_id]"], select[name="category_id"]');

                if (selectedItemId && logisticItems[selectedItemId]) {
                    categorySelect.val(logisticItems[selectedItemId].category_id).change();
                } else {
                    categorySelect.val('').change();
                }
            }

            $('select[name="logistic_items_id"]').change(function() {
                updateCategory($(this));
            });

            $(document).on('change', 'select[name^="repeater"][name$="[logistic_items_id]"]', function() {
                updateCategory($(this));
            });

            $('#duplicate-form').click(function() {
                var newRepeaterItem = $('.repeater-item-template:first').clone();
                newRepeaterItem.removeClass('repeater-item-template').removeAttr('style');
                newRepeaterItem.find('select, input').each(function() {
                    var name = $(this).data('name');
                    $(this).attr('name', 'repeater[' + repeaterIndex + '][' + name + ']');
                    $(this).next('.error-message').remove();
                });
                $('#repeater-container').append(newRepeaterItem);
                $('#repeater-container').append('<hr>'); // Append an <hr> after the new repeater item
                repeaterIndex++;

                disableSelectedItems();

                newRepeaterItem.find('.remove-btn').click(function() {
                    repeaterToDelete = $(this).closest('.repeater-box');
                    $('#ModalDelete').modal('show');
                });
            });

            $(document).on('change', 'select[name="logistic_items_id"], select[name^="repeater"]', function() {
                disableSelectedItems();
            });

            $(document).on('click', '.remove-btn', function() {
                repeaterToDelete = $(this).closest('.repeater-box');
                $('#ModalDelete').modal('show');
            });

            $('#confirmDelete').click(function() {
                repeaterToDelete.remove();
                repeaterIndex--;
                $('#ModalDelete').modal('hide');
                disableSelectedItems();
            });

            $('form').on('submit', function() {
                $('.repeater-item-template').remove();
            });

            disableSelectedItems();

            function validateForm() {
                var isValid = true;
                var errorMessages = [];

                // Validate main form fields
                $('input[name="purchased_unit"]').each(function() {
                    var $input = $(this);
                    var value = parseFloat($input.val());
                    if (isNaN(value) || value < 1) {
                        isValid = false;
                        $input.next('.error-message').remove();
                        $input.after('<div class="error-message">Value must be 1 or more.</div>');
                        errorMessages.push($input.attr('name') + ' is invalid.');
                    } else {
                        $input.next('.error-message').remove();
                    }
                });

                $('input[name="per_unit_cost"]').each(function() {
                    var $input = $(this);
                    var value = parseFloat($input.val());
                    if ($input.val() && (isNaN(value) || value < 1)) {
                        isValid = false;
                        $input.next('.error-message').remove();
                        $input.after('<div class="error-message">Value must be 1 or more.</div>');
                        errorMessages.push($input.attr('name') + ' is invalid.');
                    } else {
                        $input.next('.error-message').remove();
                    }
                });

                $('select[name="vendor_supplier_id"], select[name="logistic_items_id"]').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).next('.error-message').remove();
                        $(this).after('<div class="error-message">This field is required.</div>');
                        errorMessages.push($(this).attr('name') + ' is required.');
                    } else {
                        $(this).next('.error-message').remove();
                    }
                });

                $('input[name="purchased_date"]').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).next('.error-message').remove();
                        $(this).after('<div class="error-message">This field is required.</div>');
                        errorMessages.push($(this).attr('name') + ' is required.');
                    } else {
                        $(this).next('.error-message').remove();
                    }
                });

                // Validate repeater fields
                $('div.repeater-box').not('.repeater-item-template').each(function() {
                    var logisticItemsId = $(this).find(
                        'select[name^="repeater"][name$="[logistic_items_id]"]');
                    var purchasedUnit = $(this).find('input[name^="repeater"][name$="[purchased_unit]"]');
                    var perUnitCost = $(this).find('input[name^="repeater"][name$="[per_unit_cost]"]');

                    if (!logisticItemsId.val()) {
                        isValid = false;
                        logisticItemsId.next('.error-message').remove();
                        logisticItemsId.after('<div class="error-message">This field is required.</div>');
                        errorMessages.push(logisticItemsId.attr('name') + ' is required.');
                    } else {
                        logisticItemsId.next('.error-message').remove();
                    }

                    if (purchasedUnit.length > 0) {
                        var purchasedUnitValue = parseFloat(purchasedUnit.val());
                        if (isNaN(purchasedUnitValue) || purchasedUnitValue < 1) {
                            isValid = false;
                            purchasedUnit.next('.error-message').remove();
                            purchasedUnit.after(
                                '<div class="error-message">Value must be 1 or more.</div>');
                            errorMessages.push(purchasedUnit.attr('name') + ' is invalid.');
                        } else {
                            purchasedUnit.next('.error-message').remove();
                        }
                    }

                    if (perUnitCost.length > 0) {
                        var perUnitCostValue = parseFloat(perUnitCost.val());
                        if (perUnitCost.val() && (isNaN(perUnitCostValue) || perUnitCostValue < 1)) {
                            isValid = false;
                            perUnitCost.next('.error-message').remove();
                            perUnitCost.after('<div class="error-message">Value must be 1 or more.</div>');
                            errorMessages.push(perUnitCost.attr('name') + ' is invalid.');
                        } else {
                            perUnitCost.next('.error-message').remove();
                        }
                    }
                });

                if (!isValid) {
                    console.log('Validation errors:', errorMessages);
                }

                return isValid;
            }

            // Open submit confirmation modal
            $('#openSubmitModal').click(function() {
                if (validateForm()) {
                    $('#submitModal').modal('show');
                }
            });

            // Confirm submit
            $('#confirmSubmit').click(function() {
                $('#purchaseForm').submit();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#purchaseForm').on('submit', function(event) {
                $('#openSubmitModal').text('Submitting...');
                $('#openSubmitModal').attr('disabled', true);
            });
        });
    </script>
@endsection
