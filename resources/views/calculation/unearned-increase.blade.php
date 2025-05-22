@extends('layouts.app')

@section('title', 'calculation for Unearned Increase')

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
    <div class="breadcrumb-title pe-3">Calculation for Unearned Increase</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="javascript:;">Utilities</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Calculator</li>
                <li class="breadcrumb-item active" aria-current="page">Unearned Increase</li>
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
                @include('include.parts.property-selector',['leaseHoldOnly'=>true])
            </div>
        </div>

        <div class="col col-lg-2 pt-1 mb-2"><button type="button" class="btn btn-primary px-4 mt-4" id="submitButton">Continue<i class="bx bx-right-arrow-alt ms-2"></i></button></div>

        <div class="mt-2 d-none" id="properyDetails">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>PropertyId</th>
                    <td> <span id="old_property_id"></span></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td> <span id="address"></span></td>
                </tr>
                <tr>
                    <th>Area (Sqm.)</th>
                    <td> <span id="area"></span></td>
                </tr>
                <tr>
                    <th>Land Rate (per Sqm.) </th>
                    <td> <span id="land_rate"></span></td>
                </tr>
                <tr>
                    <th>Land Value </th>
                    <td> <span id="land_value"></span></td>
                </tr>
                <tr>
                    <th>Unearned increase</th>
                    <td class="charges"> <span id="unearned_increase" class="final-amount"></span></td>
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
            getPropertyDetails(propertyId);
        }
    })


    function getPropertyDetails(propertyId) {
        $.ajax({
            type: 'get',
            url: "{{ route('calculateUnearnedIncreaseForProperty', ':propertyId') }}".replace(':propertyId', propertyId),

            success: response => {
                if (response.status == 'error') {
                    showError(response.details)
                }
                if (response.status == 'success') {
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
</script>
@endsection