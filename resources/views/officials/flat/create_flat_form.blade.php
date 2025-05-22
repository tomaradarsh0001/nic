@extends('layouts.app')
@section('title', 'Add Flat')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <style>
        table {
            width: 100%;
            table-layout: fixed;
            /* border-collapse: collapse; */
            border-color: none !important;
            border-collapse: separate;
            border-spacing: 8px;
            margin-bottom: 0px !important;
        }

        th,
        td {
            text-align: left;
            padding: 10px;
            overflow: hidden;
        }

        td:nth-child(odd) {
            background-color: #f1f1f166;
            vertical-align: middle;
        }

        td:nth-child(even) {
            background-color: #f1f1f166;
            vertical-align: middle;
        }
    </style>
      <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">MIS</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">Flat Form</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--breadcrumb-->
    <div class="card shadow-sm mb-4">
        <form action="{{ route('store.flat.details') }}" method="POST" enctype="multipart/form-data" id="flatForm">
            @csrf
            <input type="hidden" id="applicationMovementId" name="applicationMovementId"
                value="{{ $applicationMovementId ?? null }}">
            <div class="card-body">
                <div class="part-title">
                    <h5>Plot Details</h5>
                </div>
                <div class="part-details">
                    <div class="container-fluid">
                        <div class="col-lg-12 col-12" id="propertyDetailsDiv">
                            <div class="row mb-3">
                                <div class="col-lg-2">
                                    <label for="locality" class="form-label">Locality</label>
                                    <select name="locality" id="locality" class="form-select">
                                        <option value="">Select</option>
                                        @foreach ($colonyList as $colony)
                                            <option value="{{ $colony->id }}">{{ $colony->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('locality')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="text-danger" id="localityError"></div>
                                </div>
                                <div class="col-lg-2">
                                    <label for="block" class="form-label">Block</label>
                                    <select name="block" id="block" class="form-select">
                                        <option value="">Select</option>
                                    </select>
                                    @error('block')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="text-danger" id="blockError"></div>
                                </div>
                                <div class="col-lg-2">
                                    <label for="plot" class="form-label">Plot No.</label>
                                    <select name="plot" id="plot" class="form-select">
                                        <option value="">Select</option>
                                    </select>
                                    @error('plot')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="text-danger" id="plotError"></div>
                                </div>
                                <div class="col-lg-2">
                                    <label for="knownas" class="form-label">Presently Known As</label>
                                    <select name="knownas" id="knownas" class="form-select">
                                        <option value="">Select</option>
                                    </select>
                                    @error('knownas')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="text-danger" id="knownasError"></div>
                                </div>
                                <div class="col-lg-1" style="padding-top: 27px; padding-left: 36px; font-size: 24px;">
                                    <label for="knownas" class="form-label">OR</label>
                                </div>
                                <div class="col-lg-3">
                                    <label for="searchPropertyId" class="form-label">Search Property Id</label>
                                    <input type="text" id="searchPropertyId" name="searchPropertyId" class="form-control numericOnly five-digit"
                                        placeholder="Enter Property ID">
                                    <div id="suggestions" class="list-group" style="display: none;"></div>
                                </div>
                                <!-- Display Selected Property Details -->
                                <div class="text-danger" id="searchPropertyIdError"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="part-title">
                    <h5>Flat Details</h5>
                </div>
                <div class="part-details">
                    <div class="container-fluid">
                        <div class="col-lg-12 col-12">
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="flatNumber" class="form-label">Flat No.</label>
                                    <input type="text" class="form-control" name="flatNumber" id="flatNumber"
                                        placeholder="Enter Flat Number" value="{{ old('flatNumber') }}" maxlength="15">
                                    @error('flatNumber')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="text-danger" id="flatNumberError"></div>
                                </div>
                                 {{-- Add New Field Floor - Lalit Tiwari (19/March/2025) --}}
                                 <div class="col-lg-3">
                                    <label for="floor" class="form-label">Floor</label>
                                    <input type="text" class="form-control" name="floor" id="floor"
                                        placeholder="Enter Flat Number" value="{{ old('floor') }}" maxlength="10">
                                    @error('floor')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="text-danger" id="floorError"></div>
                                </div>
                                {{-- Add New Field Floor - Lalit Tiwari (19/March/2025) --}}
                                <div class="col-lg-3">
                                    <label for="area" class="form-label">Area <small
                                            class="form-text text-muted">(Including proportionate common
                                            area.)</small></label>
                                    <div class="unit-field">
                                        <input type="text" class="form-control unit-input numericDecimal"
                                            id="area" name="area">
                                        <select class="form-select unit-dropdown" id="unit" aria-label="Select Unit"
                                            name="unit">
                                            <option value="" selected>Select Unit</option>
                                            @foreach ($areaUnit[0]->items as $unit)
                                                <option value="{{ $unit->id }}"
                                                    {{ in_array($unit->item_name, ['Acre', 'Hectare']) ? 'disabled' : '' }}>
                                                    {{ $unit->item_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('area')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @error('unit')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div id="areaError" class="text-danger"></div>
                                    <div id="unitError" class="text-danger"></div>

                                </div>
                                <div class="col-lg-3">
                                    <label for="propertyFlatStatus" class="form-label">Status of Flat</label>
                                    <select class="form-select" id="propertyFlatStatus" name="propertyFlatStatus"
                                        aria-label="Default select example">
                                        <option value="">Select</option>
                                        @foreach ($propertyStatus[0]->items as $status)
                                            <option value="{{ $status->id }}">{{ $status->item_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('propertyFlatStatus')
                                        <span class="errorMsg">{{ $message }}</span>
                                    @enderror
                                    <div id="propertyFlatStatusError" class="text-danger"></div>
                                </div>


                            </div>

                            <div class="row mb-3">

                                <div class="col-lg-3">
                                    <label for="nameofBuilder" class="form-label">Name of Builder / Developer</label>
                                    {{-- Removing class name-field - Lalit on 10/03/2025 --}}
                                    <input type="text" class="form-control" name="nameofBuilder" id="nameofBuilder"
                                        placeholder="Enter Name" value="{{ old('nameofBuilder') }}" maxlength="200">
                                    @error('nameofBuilder')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="text-danger" id="nameofBuilderError"></div>
                                </div>
                                <div class="col-lg-3">
                                    <label for="originalBuyerName" class="form-label">Name of Original Buyer</label>
                                    {{-- Removing class name-field - Lalit on 10/03/2025 --}}
                                    <input type="text" class="form-control" name="originalBuyerName"
                                        id="originalBuyerName" placeholder="Enter Name of Original Buyer"
                                        value="{{ old('originalBuyerName') }}" maxlength="200">
                                    @error('originalBuyerName')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="text-danger" id="originalBuyerNameError"></div>
                                </div>
                                <div class="col-lg-3">
                                    <label for="purchaseDate" class="form-label">Date of Purchase</label>
                                    <input type="date" name="purchaseDate" class="form-control" id="purchaseDate" max="{{ date('Y-m-d') }}"
                                        pattern="\d{2} \d{2} \d{4}" value="{{ old('purchase_date') }}">
                                    @error('purchaseDate')
                                        <span class="errorMsg">{{ $message }}</span>
                                    @enderror
                                    <div id="purchaseDateError" class="text-danger"></div>
                                </div>
                                <div class="col-lg-3">
                                    <label for="presentOccupantName" class="form-label">Name of Present Occupant</label>
                                    {{-- removing class prasent-occupant - Lalit on 10/03/2025 --}}
                                    <input type="text" class="form-control" name="presentOccupantName"
                                        id="presentOccupantName" placeholder="Enter Name of Present Occupant"
                                        value="{{ old('presentOccupantName') }}" maxlength="200">
                                    @error('presentOccupantName')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="text-danger" id="presentOccupantNameError"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="part-details">
                    <div class="container-fluid">
                        <div class="col-lg-12 col-12">
                            <div class="row mb-3">
                                <div class="d-flex justify-content-end">
                                    <button type="button" id="submitflatFormBtn"
                                        class="btn btn-primary btn-theme">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
    </div>
    </div>
    {{-- Dynamic Element --}}
@endsection
@section('footerScript')
    <script>
        //get all blocks of selected locality
        $('#locality').on('change', function() {
            var locality = this.value;
            $("#block").html('');
            $.ajax({
                url: "{{ route('localityBlocks') }}",
                type: "POST",
                data: {
                    locality: locality,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#block').html('<option value="">Select</option>');
                    $.each(result, function(key, value) {
                        $("#block").append('<option value="' + value.block_no + '">' + value
                            .block_no + '</option>');
                    });
                }
            });
        });
        //get all plots of selected block
        $('#block').on('change', function() {
            var locality = $('#locality').val();
            var block = this.value;
            $("#plot").html('');
            $.ajax({
                url: "{{ route('blockPlots') }}",
                type: "POST",
                data: {
                    locality: locality,
                    block: block,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    // console.log(result);
                    $('#plot').html('<option value="">Select</option>');
                    $.each(result, function(key, value) {
                        $("#plot").append('<option value="' + value + '">' +
                            value + '</option>');
                    });
                }
            });
        });
        //get known as of selected plot
        $('#plot').on('change', function() {
            var locality = $('#locality').val();
            var block = $('#block').val();
            var plot = this.value;
            $("#knownas").html('');
            $.ajax({
                url: "{{ route('plotKnownas') }}",
                type: "POST",
                data: {
                    locality: locality,
                    block: block,
                    plot: plot,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    // console.log(result);
                    $('#knownas').html('<option value="">Select</option>');
                    $.each(result, function(key, value) {
                        $("#knownas").append('<option value="' + value + '">' + value +
                            '</option>');
                    });
                }
            });
        });
        //get known as of selected plot
        $('#knownas').on('change', function() {
            var locality = $('#locality').val();
            var block = $('#block').val();
            var plot = $('#plot').val();
            var knownas = this.value;
            // $("#knownas").html('');
            $.ajax({
                url: "{{ route('getPropertyDetails') }}",
                type: "POST",
                data: {
                    locality: locality,
                    block: block,
                    plot: plot,
                    knownas: knownas,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    console.log(result);
                    // Remove the previously appended content, if it exists
                    const previousContent = document.getElementById('appendedContent');
                    if (previousContent) {
                        previousContent.remove();
                    }
                    // Append new content inside a wrapper div
                    document.getElementById('propertyDetailsDiv').insertAdjacentHTML('beforeend',
                        `<div id="appendedContent" style="margin-bottom:19px;">${result.data}</div>`
                    );
                }
            });
        });
        
        $(document).ready(function() {
            $('#submitflatFormBtn').click(function(e) {
                e.preventDefault(); // Prevent default form submission

                // Clear previous error messages
                $('.text-danger').text('');
                let isValid = true;

                // Validate presentOccupantName
                //Commented on Dated - Lalit (06/March/2025)
                /*if (!$('#presentOccupantName').val().trim()) {
                    $('#presentOccupantNameError').text('Please enter the present occupant\'s name.');
                    isValid = false;
                    $('#presentOccupantName').focus();
                }*/

                //Validation Commented on (07/Jan/25) By Lalit Tiwari After Discussion With Amrita Mam
                // Validate purchaseDate
                /*if (!$('#purchaseDate').val().trim()) {
                    $('#purchaseDate').next('.text-danger').text('Please select purchase date.');
                    isValid = false;
                    $('#purchaseDate').focus();
                } else {
                    const selectedDate = new Date($('#purchaseDate').val());
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    selectedDate.setHours(0, 0, 0, 0);

                    if (selectedDate > today) {
                        $('#purchaseDate').next('.text-danger').text('Purchase date should not be greater than today\'s date.');
                        isValid = false;
                        $('#purchaseDate').focus();
                    }
                }*/

                //Validation Commented on (07/Jan/25) By Lalit Tiwari After Discussion With Amrita Mam
                // Validate originalBuyerName
                /*if (!$('#originalBuyerName').val().trim()) {
                    $('#originalBuyerName').next('.text-danger').text('Please enter the original buyer\'s name.');
                    isValid = false;
                    $('#originalBuyerName').focus();
                }*/

                // Validate nameofBuilder
                //Commented on Dated - Lalit (06/March/2025)
                /*if (!$('#nameofBuilder').val().trim()) {
                    $('#nameofBuilder').next('.text-danger').text('Please enter the name of builder.');
                    isValid = false;
                    $('#nameofBuilder').focus();
                }*/

                // Validate propertyFlatStatus
                if (!$('#propertyFlatStatus').val()) {
                    $('#propertyFlatStatus').next('.text-danger').text('Please select property flat status.');
                    isValid = false;
                    $('#propertyFlatStatus').focus();
                }

                //Validation Commented on (07/Jan/25) By Lalit Tiwari After Discussion With Amrita Mam
                // Validate area and unit fields
                /*if (!$('#area').val().trim() && !$('#unit').val()) {
                    $('#areaError').text('Please enter the area & select unit.');
                    isValid = false;
                    $('#area').focus();
                } else if (!$('#area').val().trim()) {
                    $('#areaError').text('Please enter the area.');
                    isValid = false;
                    $('#area').focus();
                } else if (!$('#unit').val()) {
                    $('#unitError').text('Please select unit.');
                    isValid = false;
                    $('#unit').focus();
                }*/

                if($('#area').val().trim() && !$('#unit').val()){
                    $('#unitError').text('Please select unit.');
                    isValid = false;
                    $('#unit').focus();
                }

                // Validate flatNumber
                if (!$('#flatNumber').val().trim()) {
                    $('#flatNumber').next('.text-danger').text('Please enter the flat number.');
                    isValid = false;
                    $('#flatNumber').focus();
                }

                // Validate primary form fields only if searchPropertyId is empty
                if (!$('#searchPropertyId').val()) {
                    if (!$('#knownas').val()) {
                        $('#knownas').next('.text-danger').text('Please select a known as.');
                        isValid = false;
                    }

                    if (!$('#plot').val()) {
                        $('#plot').next('.text-danger').text('Please select a plot.');
                        isValid = false;
                    }

                    if (!$('#block').val()) {
                        $('#block').next('.text-danger').text('Please select a block.');
                        isValid = false;
                    }

                    if (!$('#locality').val()) {
                        $('#locality').next('.text-danger').text('Please select a locality.');
                        isValid = false;
                    }
                }

                // Prevent form submission if any validation fails
                if (!isValid) {
                    return;
                }

                // Submit the form if valid
                $('#submitflatFormBtn').prop('disabled', true);
                $('#submitflatFormBtn').html('Submitting...');
                $('#flatForm').submit();
            });

        });

        $(document).ready(function() {
            let timeout = null;

            $('#searchPropertyId').on('input', function() {
                clearTimeout(timeout); // Clear previous timeout
                const query = $(this).val();

                if (query.length > 2) { // Start searching after 2 characters
                    timeout = setTimeout(function() {
                        $.ajax({
                            url: '{{ route('search.property') }}', // Keep this route as POST
                            method: 'POST', // Change method to POST
                            data: {
                                _token: '{{ csrf_token() }}', // Include CSRF token for POST requests
                                query: query
                            },
                            success: function(data) {
                                // Clear previous suggestions
                                $('#suggestions').empty();

                                // Check if there are results
                                if (data.length > 0) {
                                    $.each(data, function(index, property) {
                                        $('#suggestions').append(
                                            `<a href="#" class="list-group-item list-group-item-action suggestion-item" data-id="${property.old_propert_id}">${property.old_propert_id}</a>`
                                        );
                                    });
                                    $('#suggestions').show();
                                } else {
                                    $('#suggestions').hide();
                                }
                            }
                        });
                    }, 300); // Debounce for 300ms
                } else {
                    $('#suggestions').hide();
                }
            });

            // Handle suggestion click
            $(document).on('click', '.suggestion-item', function(e) {
                e.preventDefault();
                const propertyId = $(this).data('id');
                $('#searchPropertyId').val(propertyId);
                $('#suggestions').hide();
                fetchPropertyDetails(propertyId);
            });

            // Function to fetch property details based on selected ID
            function fetchPropertyDetails(propertyId) {
                $.ajax({
                    url: '/get-property-data/' + propertyId, // Create this route
                    method: 'GET',
                    dataType: 'json',
                    success: function(result) {
                        // Remove the previously appended content, if it exists
                        const previousContent = document.getElementById('appendedContent');
                        if (previousContent) {
                            previousContent.remove();
                        }
                        // Append new content inside a wrapper div
                        document.getElementById('propertyDetailsDiv').insertAdjacentHTML('beforeend',
                            `<div id="appendedContent" style="margin-bottom:19px;">${result.data}</div>`
                        );
                    }
                });
            }


            $(".numericDecimal").on("input", function () {
                var value = $(this).val();
                if (!/^\d*\.?\d*$/.test(value)) {
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

            //maximum 5 digits allowed for property ID
            document.querySelectorAll('.five-digit').forEach(input => {
                input.addEventListener('input', function () {
                    // Remove non-numeric characters
                    this.value = this.value.replace(/\D/g, '');

                    // Limit input to 5 digits
                    if (this.value.length > 5) {
                        this.value = this.value.slice(0, 5);
                    }
                });
            });

            document.querySelectorAll('.name-field').forEach(input => {
                input.addEventListener('input', function () {
                    // Remove any characters that are not letters, spaces, or hyphens
                    // this.value = this.value.replace(/[^a-zA-Z0-9./_-\s]/g, '');
                    this.value = this.value.replace(/[^a-zA-Z0-9.,/_-\s]/g, '');
                    // Check the length of the input (optional)
                    if (this.value.length < 2 || this.value.length > 50) {
                        this.setCustomValidity('Name should be between 2 and 50 characters.');
                    } else {
                        this.setCustomValidity('');
                    }
                });
            });

            document.querySelectorAll('.prasent-occupant').forEach(input => {
                input.addEventListener('input', function () {
                    // Remove any characters that are not letters, spaces, or hyphens
                    this.value =  this.value.replace(/[^a-zA-Z0-9.,/_-\s]/g, '');
                    // Check the length of the input (optional)
                    if (this.value.length < 2 || this.value.length > 50) {
                        this.setCustomValidity('Name should be between 2 and 50 characters.');
                    } else {
                        this.setCustomValidity('');
                    }
                });
            });

            // VAlidation for Flat Number
            document.querySelector('#flatNumber').addEventListener('input', function() {
                // Regular expression to allow only alphanumeric characters and . / _ -
                const validCharacters = /^[a-zA-Z0-9./_-\s]*$/;
                
                if (!validCharacters.test(this.value)) {
                    // Remove invalid characters
                    this.value = this.value.replace(/[^a-zA-Z0-9./_-]/g, '');
                    if (!$('#flatNumber').val().trim()) {
                        $('#flatNumber').next('.text-danger').text('Only alphanumeric characters and . / _ - are allowed!');
                        isValid = false;
                        $('#flatNumber').focus();
                    }
                } else {
                    // Clear the validation message if the input is valid
                    $('#flatNumber').next('.text-danger').text('');
                    isValid = true;
                }
            });

        });
    </script>

@endsection
