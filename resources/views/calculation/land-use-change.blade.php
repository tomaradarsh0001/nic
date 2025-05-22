@extends('layouts.app')

@section('title', 'calculation for Land Use Change')

@section('content')
<link rel="stylesheet" href="{{asset('assets/css/rgr.css')}}">
<style>
    #formula {
        float: right;
        font-weight: 550;
        font-size: smaller;
    }

    #formula::before {
        content: '[';
        display: inline;
    }

    #formula::after {
        content: ']';
        display: inline;
    }
</style>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Calculation for Land Use Change Charges</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="javascript:;">Utilities</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Calculator</li>
                <li class="breadcrumb-item active" aria-current="page">Land Use Change Charges</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>
<!--end breadcrumb-->
<hr>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mb-2">
                @include('include.parts.property-selector')
            </div>
        </div>

        <div class="col col-lg-2 pt-1 mb-2"><button type="button" class="btn btn-primary px-4 mt-4" id="submitButton">Continue<i class="bx bx-right-arrow-alt ms-2"></i></button></div>

        <div class="mt-2 d-none" id="properyDetails">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Property Id</th>
                    <td> <span id="old_property_id"></span></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td> <span id="address"></span></td>
                </tr>
                <tr>
                    <th>Area (Sqm.)</th>
                    <td> <span id="area_numeric"></span></td>
                </tr>
                <tr>
                    <th>Land Rate (per Sqm.)</th>
                    <td class="money"> <span id="land_rate_numeric"></span></td>
                </tr>
                <tr>
                    <th>Land Value </th>
                    <td class="money"> <span id="land_value_numeric"></span></td>
                </tr>
                <tr>
                    <th>Property Type</th>
                    <td> <span id="property_type"></span></td>
                </tr>
                <tr>
                    <th>Property Subtype</th>
                    <td> <span id="property_subtype"></span></td>
                </tr>
            </table>
        </div>
        <div class="d-none mt-2" id="change-to-select">
            <div class="row">
                <div class="col-lg-12">
                    <hr>
                    <h6>Change to</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label for="">Property Type</label>
                    <select name="" id="propertyTypeTo" class="form-select"></select>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label for="">Property Subtype</label>
                    <select name="" id="propertySubtypeTo" class="form-select"></select>
                </div>
            </div>
            <div class="col col-lg-2 pt-1 mb-2"><button type="button" class="btn btn-primary px-4 mt-4 d-none" id="submitButton2">Calculate<i class="bx bx-right-arrow-alt ms-2"></i></button></div>
        </div>

        <div class="d-none mt-2" id="calculation">
            <table class=" table table-bordered table-striped">
                <tr>
                    <th>Land Use Change Charges</th>
                    <td> <span class="final-amount money" id="charges"></span> <span id="formula"></span></td>
                </tr>
            </table>
        </div>

    </div>
</div>
@include('include.alerts.ajax-alert')
@endsection
@section('footerScript')
<script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
<script>
    let propertyId;
    let propertyTypes;
    let propertyDetails;

    $('#submitButton').click(function() {
        propertyId = !isNaN($('#oldPropertyId').val()) && $('#oldPropertyId').val().length == 5 ? $('#oldPropertyId').val() :
            $('#property').length > 0 && $('#property').val() != "" ? $('#property').val() :
            $('#plot').length > 0 && $('#plot').val() != "" ? $('#plot').val() : "";
        if (propertyId != "") {
            if (!$('#propertyDetails').hasClass('d-none')) {
                $('#propertyDetails').addClass('d-none');
            }
            if (!$('#change-to-select').hasClass('d-none')) {
                $('#change-to-select').addClass('d-none');
            }
            if (!$('#calculation').hasClass('d-none')) {
                $('#calculation').addClass('d-none');
            }
            getPropertyLandUseChangeOptions(propertyId);
        }
    })


    function getPropertyLandUseChangeOptions(propertyId) {
        $.ajax({
            type: 'get',
            url: "{{ route('propertyTypeOptions', ':propertyId') }}".replace(':propertyId', propertyId),

            success: response => {
                $('#change-to-select').toggleClass('d-none', response.status !== 'success');
                if (response.status == 'error') {
                    showError(response.details)
                }
                if (response.status == 'success') {
                    let rows = response.landUseChangeData;
                    propertyDetails = response.propertyDetails;
                    if (propertyDetails && $('#properyDetails').hasClass('d-none')) {
                        $('#properyDetails').removeClass('d-none');
                    }
                    let keys = Object.keys(propertyDetails);
                    keys.forEach((key, index) => {
                        target = $('#' + key);
                       
                        if (target.length > 0) {
                            target.html(propertyDetails[key]);
                        }
                        else{
                            target = $('#' + key+ '_numeric');
                            if (target.length > 0) {
                                target.html(customNumFormat(propertyDetails[key]));
                            }
                        }
                    })
                    propertyTypes = [];
                    $('#propertyTypeTo').html('<option value="">Select</option>');
                    let propertyTypeMap = new Map();

                    $.each(rows, function(index, row) {
                        if (!propertyTypeMap.has(row.property_type_to)) {
                            propertyTypeMap.set(row.property_type_to, {
                                "id": row.property_type_to,
                                "name": row.toTypeName,
                                "subtypes": [{
                                    "id": row.property_sub_type_to,
                                    "name": row.toSubtypeName,
                                    "rate": row.rate
                                }]
                            });
                            $('#propertyTypeTo').append(`<option value="${row.property_type_to}">${row.toTypeName}</option>`);
                        } else {
                            let propertyType = propertyTypeMap.get(row.property_type_to);
                            propertyType.subtypes.push({
                                "id": row.property_sub_type_to,
                                "name": row.toSubtypeName,
                                "rate": row.rate,
                            });
                        }
                    });
                    propertyTypes = Array.from(propertyTypeMap.values());

                }
            },
            error: err => {
                if (err.responseJSON && err.responseJSON.message) {
                    showError(err.responseJSON.message)
                } else {
                    showError('Unknown Error Occoured');
                }
            }
        });
    }

    $('#propertyTypeTo').change(function() {
        let propertyTypeTo = $(this).val();
        if (propertyTypeTo != "") {
            $('#propertySubtypeTo').html('<option value="">Select</option>');
            let selectedPropertyType = propertyTypes.find(type => type.id == propertyTypeTo);
            if (selectedPropertyType) {
                let subtypes = selectedPropertyType.subtypes;
                $.each(subtypes, (i, val) => {
                    $('#propertySubtypeTo').append(`<option value="${val.id}" data-rate="${val.rate}">${val.name}</option>`);
                })
            }
        } else {
            $('#propertySubtypeTo').val('');
            $('#propertySubtypeTo').empty();
        }
    });
    $('#propertySubtypeTo').change(function() {
        $('#submitButton2').removeClass('d-none');
    });

    $('#submitButton2').click(function() {
        let selectedOption = $('#propertySubtypeTo option:selected');
        let selectedRate = parseInt(selectedOption.data('rate')).toPrecision(2);
        let landValue = propertyDetails.land_value;
        let charges;
        if (landValue) {
            console.log(landValue)
            charges = Math.round((+landValue * (+selectedRate) / 100) * 100) / 100;
            $('#charges').html(customNumFormat(charges));
            $('#formula').html(`${selectedRate} % of ${customNumFormat(landValue)}`);
        } else {
            charges = 'not available at the moment';
            $('#charges').html(charges);
            $('#formula').html('');
        }
        $('#calculation').removeClass('d-none')
    })
</script>
@endsection