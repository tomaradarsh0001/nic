@extends('layouts.app')

@section('title', 'calculation for Conversion')

@section('content')

<link rel="stylesheet" href="{{asset('assets/css/rgr.css')}}">
<style>
    .float-right {
        float: right !important;
    }
</style>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Calculation for Conversion Charges</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="javascript:;">Utilities</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Calculator</li>
                <li class="breadcrumb-item active" aria-current="page">Conversion Charges</li>
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
            <div class="col-lg-12">
                @include('include.parts.property-selector',['leaseHoldOnly'=>true])
            </div>
            <div class="col-lg-4 mt-2">
                <div class="form-group">
                    <label for="lessee_type">Lessee Type</label>
                    <select name="lessee_tyep" id="lessee_type" class="form-select">
                        <option value="">Select</option>
                        <option value="1">Recorded Lessee</option>
                        <option value="2">Others</option>
                    </select>
                </div>
            </div>
            <div class="col col-lg-12 pt-1 mb-2"><button type="button" class="btn btn-primary px-4 mt-4" id="submitButton">Calculate<i class="bx bx-right-arrow-alt ms-2"></i></button></div>
            <div class="col lg-12 d-none mt-2" id="calculation">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Colony Name</th>
                        <td id="colonyName"></td>
                    </tr>
                    <tr>
                        <th>Land Rate (per Sqm.)</th>
                        <td id="landRate_numeric" class="money"></td>
                    </tr>
                    <tr>
                        <th>Area (Sqm.)</th>
                        <td id="propertyArea_numeric"></td>
                    </tr>
                    <tr>
                        <th>Property Type</th>
                        <td id="propertyType"></td>
                    </tr>
                    <tr>
                        <th>Property Subtype</th>
                        <td id="propertySubtype"></td>
                    </tr>

                    <tr>
                        <th>Charges Calcutation</th>
                        <td> <span id="equation"></span> <b class="float-right"><small></small></b></td>
                    </tr>
                    <tr>
                        <th>Conversion Charges</th>
                        <td id="charges" class="money"></td>
                    </tr>
                    <tr>
                        <th><span id="additionalChargesLabel"></span> <small>[<span id="additionalFormula"></span>]</small></th>
                        <td class="money"><span id="additionalCharges"></span><b class="float-right"></b></td>
                    </tr>
                    <tr>
                        <th>Payable Charges</th>
                        <td id="total" class="money final-amount"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="float-right">
                                Calculation formula &rarr;[<span id="formula"></span>]
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@include('include.alerts.ajax-alert')
@endsection
@section('footerScript')
<script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>

<script>
    $('#submitButton').click(function() {
        propertyId = !isNaN($('#oldPropertyId').val()) && $('#oldPropertyId').val().length == 5 ?
            $('#oldPropertyId').val() :
            $('#property').length > 0 && $('#property').val() != "" ?
            $('#property').val() :
            $('#plot').length > 0 && $('#plot').val() != "" ?
            $('#plot').val() : "";
        if (propertyId != "") {

            getPropertyConversionCharges(propertyId);
        }
    })

    function getPropertyConversionCharges(propertyId) {
        let lesseType = $('#lessee_type').val();
        if (lesseType != "") {
            if (!$('#calculation').hasClass('d-none')) {
                $('#calculation').addClass('d-none')
            }
            $.ajax({
                type: 'get',
                url: "{{ route('chargesForProperty') }}",
                data: {
                    propertyId: propertyId,
                    lesseType: lesseType
                },
                success: response => {
                    if (response.status == 'error') {
                        showError(response.details)
                    }
                    if (response.status == 'success') {
                        if ($('#calculation').hasClass('d-none')) {
                            $('#calculation').removeClass('d-none')
                        }
                        keys = Object.keys(response);
                        $.each(keys, function(index, key) {
                            let target = $('#' + key);

                            if (target.length > 0) {
                                target.html(response[key]);
                            }
                            else{
                                target = $('#' + key+ '_numeric');
                                if (target.length > 0) {
                                    target.html(customNumFormat(response[key]));
                                }
                                else {
                                    console.warn('Target not found for ID:', key);
                                }
                            } 
                        })
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

    }
</script>
@endsection