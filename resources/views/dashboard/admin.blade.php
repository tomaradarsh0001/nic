@php
$currentUrl = url()->current();
$isPublic = strpos($currentUrl, 'public-dashboard') !== false;
$layout = $isPublic ? 'layouts.public.app' : 'layouts.app';
@endphp


@extends($layout)

@section('title', 'Dashboard')
@section('content')
@if($isPublic ||( Auth::check() && Auth::user()->hasPermissionTo('view dashboard')))

@if($isPublic)
<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
@endif

<?php
$labels = [];
$barData = [];
$seriesLabels = [];
foreach ($barChartData as $key => $row) {
    $labels[] = $row->land;
    $data = [];
    $series = [];
    $counter = 0;
    foreach ($row as $index => $val) {
        if ($counter > 0) {
            $data[] = $val;
            if (count($seriesLabels) == 0) {
                $series[] = "'" . $index . "'"; // must wrap in quotes as javascript throws error on < and >
            }
        }
        $counter++;
    }
    if (count($seriesLabels) == 0 && count($series) > 0) {
        $seriesLabels = $series;
    }

    $barData[] = $data;
}

//Get the number of colonies --Amita [15-01-2025]
$number_of_colonies = getMisDoneColoniesCount();
?>
<style>
    .colony-dropdown {
        width: 48.5% !important;
    }

    .dropdown.bootstrap-select {
        min-width: 100% !important;
    }

    .btn.dropdown-toggle {
        min-width: 100% !important;
    }

    a.active .text {
        color: #fff !important;
    }

    .view-list {
        cursor: pointer;
    }
</style>
<!--breadcrumb-->
<div class="container-fluid">
    <div class="row justify-content-between mb-3">
        <div class="col-lg-6">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Dashboard</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboards</li>
                            <li class="breadcrumb-item active" aria-current="page">My Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="colony-dropdown ms-auto">
                <select id="colony-filter" class="selectpicker" data-live-search="true">
                    <option value="">Filter by Colony ({{$number_of_colonies}})</option>
                    @foreach($colonies as $colony)
                    <option value="{{$colony->id}}">{{$colony->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>


    </div>
   
</div>


<div class="container-fluid">
    <div class="row row-cols-2 row-cols-md-2 row-cols-xl-4 custom_card_container">
        <div class="col">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"><img
                                src="{{asset('assets/images/properties-icon-hand-Total.svg')}}" alt="properties">
                        </div>
                        <div>
                            <h4 class="my-1 grid-icons-size text-dark view-list" id="tile_total_count"
                                data-original="{{customNumFormat($totalCount)}}">{{customNumFormat($totalCount)}}</h4>
                            <p class="mb-0 text-secondary">Total No. of Properties</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
                            style="background-color: #FFF3E0;"><img src="{{asset('assets/images/pageless-Total.svg')}}"
                                alt="Pageless">
                        </div>
                        <div>
                            <h4 class="my-1 grid-icons-size text-dark" id="tile_total_area_formatted"
                                data-original="{{customNumFormat(round($totalArea))}}">
                                {{customNumFormat(round($totalArea))}}
                            </h4>
                            <p class="mb-0 text-secondary">Total Area (Sqm)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col hoverable" title="₹{{customNumFormat($totalLdoValue)}}" id="tile_total_land_value_ldo"
            data-original="₹{{customNumFormat($totalLdoValue)}}">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
                            style="background-color: #F3E5F5;"><img src="{{asset('assets/images/sell-Total.svg')}}"
                                alt="Land Value">
                        </div>
                        <div>
                            <h4 class="my-1 grid-icons-size text-dark" id="tile_total_land_value_ldo_formatted"
                                data-original="₹{{customNumFormat(round($totalLdoValue/10000000))}} Cr.">
                                ₹{{customNumFormat(round($totalLdoValue/10000000))}} Cr.</h4>
                            <p class="mb-0 text-secondary">Total Land Value (L&DO)
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col hoverable" title="₹{{customNumFormat($totalCircleValue)}}" id="tile_total_land_value_circle"
            data-original="₹{{customNumFormat($totalCircleValue)}}">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
                            style="background-color: #E0F2F1;"><img src="{{asset('assets/images/payments-Total.svg')}}"
                                alt="properties">
                        </div>
                        <div>
                            <h4 class="my-1 text-dark grid-icons-size" id="tile_total_land_value_circle_formatted"
                                data-original="₹{{customNumFormat(round($totalCircleValue/10000000))}} Cr.">
                                ₹{{customNumFormat(round($totalCircleValue/10000000))}} Cr.</h4>
                            <p class="mb-0 text-secondary">Total Land Value (Circle rate)

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-cols-2 row-cols-md-2 row-cols-xl-4 custom_card_container">
        <div class="col">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"><img
                                src="{{asset('assets/images/properties-icon-hand-LH.svg')}}" alt="properties">
                        </div>
                        <div>
                            <h4 class="my-1 grid-icons-size text-dark view-list" id="tile_lease_hold_count"
                                data-original="{{customNumFormat($statusCount['lease_hold'])}}"
                                data-filter-name="property_status" data-filter-value="951">
                                {{customNumFormat($statusCount['lease_hold'])}}
                            </h4>
                            <p class="mb-0 text-secondary">Total No. of LH Properties</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
                            style="background-color: #FFF3E0;"><img src="{{asset('assets/images/pageless-LH.svg')}}"
                                alt="Pageless">
                        </div>
                        <div>
                            <h4 class="my-1 grid-icons-size text-dark" id="tile_lease_hold_area"
                                data-original="{{customNumFormat(round($statusArea['lease_hold']))}}">
                                {{customNumFormat(round($statusArea['lease_hold']))}}
                            </h4>
                            <p class="mb-0 text-secondary">Total Area of LH Properties (Sqm)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col hoverable" title="₹{{customNumFormat($statusLdoValue['lease_hold'])}}"
            id="tile_lease_hold_land_value_ldo" data-original="₹{{customNumFormat($statusLdoValue['lease_hold'])}}">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
                            style="background-color: #F3E5F5;"><img src="{{asset('assets/images/sell-LH.svg')}}"
                                alt="Land Value">
                        </div>
                        <div>
                            <h4 class="my-1 grid-icons-size text-dark" id="tile_lease_hold_land_value_ldo_formatted"
                                data-original="₹{{customNumFormat(round($statusLdoValue['lease_hold']/10000000))}} Cr.">
                                ₹{{customNumFormat(round($statusLdoValue['lease_hold']/10000000))}} Cr.</h4>
                            <p class="mb-0 text-secondary">Total LH Land Value (L&DO)
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col hoverable" title="₹{{customNumFormat($statusCircleValue['lease_hold'])}}"
            id="tile_lease_hold_land_value_circle"
            data-original="₹{{customNumFormat($statusCircleValue['lease_hold'])}}">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
                            style="background-color: #E0F2F1;"><img src="{{asset('assets/images/payments-LH.svg')}}"
                                alt="properties">
                        </div>
                        <div>
                            <h4 class="my-1 text-dark grid-icons-size" id="tile_lease_hold_land_value_circle_formatted"
                                data-original="₹{{customNumFormat(round($statusCircleValue['lease_hold']/10000000))}} Cr.">
                                ₹{{customNumFormat(round($statusCircleValue['lease_hold']/10000000))}} Cr.</h4>
                            <p class="mb-0 text-secondary">Total LH Land Value (Circle rate)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-2 row-cols-md-2 row-cols-xl-4 custom_card_container">
        <div class="col">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"><img
                                src="{{asset('assets/images/properties-icon-hand-FH.svg')}}" alt="properties">
                        </div>
                        <div>
                            <h4 class="my-1 grid-icons-size text-dark view-list" id="tile_free_hold_count"
                                data-original="{{customNumFormat($statusCount['free_hold'])}}"
                                data-filter-name="property_status" data-filter-value="952">
                                {{customNumFormat($statusCount['free_hold'])}}
                            </h4>
                            <p class="mb-0 text-secondary">Total No. of FH Properties</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
                            style="background-color: #FFF3E0;"><img src="{{asset('assets/images/pageless-FH.svg')}}"
                                alt="Pageless">
                        </div>
                        <div>
                            <h4 class="my-1 grid-icons-size text-dark" id="tile_free_hold_area"
                                data-original="{{customNumFormat(round($statusArea['free_hold']))}}">
                                {{customNumFormat(round($statusArea['free_hold']))}}
                            </h4>
                            <p class="mb-0 text-secondary">Total Area of FH Properties (Sqm)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col hoverable" title="₹{{customNumFormat($statusLdoValue['free_hold'])}}"
            id="tile_free_hold_land_value_ldo" data-original="₹{{customNumFormat($statusLdoValue['free_hold'])}}">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
                            style="background-color: #F3E5F5;"><img src="{{asset('assets/images/sell-FH.svg')}}"
                                alt="Land Value">
                        </div>
                        <div>
                            <h4 class="my-1 grid-icons-size text-dark" id="tile_free_hold_land_value_ldo_formatted"
                                data-original="₹{{customNumFormat(round($statusLdoValue['free_hold']/10000000))}} Cr.">
                                ₹{{customNumFormat(round($statusLdoValue['free_hold']/10000000))}} Cr.</h4>
                            <p class="mb-0 text-secondary">Total FH Land Value (L&DO)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col hoverable" title="₹{{customNumFormat($statusCircleValue['free_hold'])}}"
            id="tile_free_hold_land_value_circle" data-original="₹{{customNumFormat($statusCircleValue['free_hold'])}}">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
                            style="background-color: #E0F2F1;"><img src="{{asset('assets/images/payments-FH.svg')}}"
                                alt="properties">
                        </div>
                        <div>
                            <h4 class="my-1 text-dark grid-icons-size" id="tile_free_hold_land_value_circle_formatted"
                                data-original="₹{{customNumFormat(round($statusCircleValue['free_hold']/10000000))}} Cr.">
                                ₹{{customNumFormat(round($statusCircleValue['free_hold']/10000000))}} Cr.</h4>
                            <p class="mb-0 text-secondary">Total FH Land Value (Circle rate)

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- unalloted properties -->

    <div class="row row-cols-2 row-cols-md-2 row-cols-xl-4 custom_card_container">
        <div class="col">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"><img
                                src="{{asset('assets/images/properties-icon-hand.svg')}}" alt="properties">
                        </div>
                        <div>
                            <h4 class="my-1 grid-icons-size text-dark view-list" id="tile_unallotted_count"
                                data-original="{{customNumFormat($statusCount['unallotted'])}}" data-filter-name="property_status"
                                data-filter-value="unalloted">{{customNumFormat($statusCount['unallotted'])}}</h4>
                            <p class="mb-0 text-secondary">Total No. of Unallotted Properties</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"><img src="{{asset('assets/images/pageless.svg')}}"
                                alt="Pageless">
                        </div>

                        <div>
                            <h4 class="my-1 grid-icons-size text-dark" id="tile_unallotted_area"
                                data-original=" {{customNumFormat(round($statusArea['unallotted']))}}">
                                {{customNumFormat(round($statusArea['unallotted']))}}
                            </h4>
                            <p class="mb-0 text-secondary">Total Area of Unallotted Properties (Sqm)</p>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div class="col hoverable" title="₹{{customNumFormat($statusLdoValue['unallotted'])}}" id="tile_unallotted_land_value_ldo"
            data-original="₹{{customNumFormat($statusLdoValue['unallotted'])}}">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"><img src="{{asset('assets/images/sell.svg')}}"
                                alt="Land Value">
                        </div>
                        <div>
                            <h4 class="my-1 grid-icons-size text-dark" id="tile_unallotted_land_value_ldo_formatted"
                                data-original="₹{{customNumFormat(round($statusLdoValue['unallotted']/10000000))}} Cr.">
                                ₹{{customNumFormat(round($statusLdoValue['unallotted']/10000000))}} Cr.</h4>
                            <p class="mb-0 text-secondary">Total Unallotted Land Value (L&DO)</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="col hoverable" title="₹{{customNumFormat($statusCircleValue['unallotted'])}}" id="tile_unallotted_land_value_circle"
            data-original="₹{{customNumFormat($statusCircleValue['unallotted'])}}">
            <div class="card radius-10 border-start border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center dashboard-cards">
                        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"><img src="{{asset('assets/images/payments.svg')}}"
                                alt="properties">
                        </div>
                        <div>
                            <h4 class="my-1 text-dark grid-icons-size" id="tile_unallotted_land_value_circle_formatted"
                                data-original="₹{{customNumFormat(round($statusCircleValue['unallotted']/10000000))}} Cr.">
                                ₹{{customNumFormat(round($statusCircleValue['unallotted']/10000000))}} Cr.</h4>
                            <p class="mb-0 text-secondary">Total Unallotted Land Value (Circle rate)

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ---------------------------------------------------------------------------- -->
    {{-- <div class="row row-cols-1 row-cols-xl-2 custom_card_container">
        <div class="col">
            <div class="card green-gradient">
                <div class="container-fluid">
                    <div class="row row-cols-xl-2 row-cols-1">
                        <div class="card-body">
                            <div class="d-flex align-items-center dashboard-cards">
                                <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
                                    style="background-color: #fff;"><img
                                        src="{{asset('assets/images/properties-icon-hand.svg')}}" alt="properties">
</div>
<div>
    <h4 class="my-1 grid-icons-size text-dark" id="tile_free_hold_count"
        data-original="">7,864</h4>
    <p class="mb-0 text-secondary">Total No. of Transferred Land Parcels</p>
</div>
</div>
</div>

<div class="card-body">
    <div class="d-flex align-items-center dashboard-cards">
        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
            style="background-color: #fff;"><img
                src="{{asset('assets/images/properties-icon-hand.svg')}}" alt="properties">
        </div>
        <div>
            <h4 class="my-1 grid-icons-size text-dark" id="tile_free_hold_count"
                data-original="">7,864</h4>
            <p class="mb-0 text-secondary">No. of Transferred land to DDA</p>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="d-flex align-items-center dashboard-cards">
        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
            style="background-color: #fff;"><img src="{{asset('assets/images/payments.svg')}}"
                alt="properties">
        </div>
        <div>
            <h4 class="my-1 grid-icons-size text-dark" id="tile_free_hold_count"
                data-original="">₹8,234 Cr.</h4>
            <p class="mb-0 text-secondary">No. of Transferred Land to MCD/NDMC</p>
        </div>
    </div>
</div>

<div class="card-body">
    <div class="d-flex align-items-center dashboard-cards">
        <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
            style="background-color: #fff;"><img src="{{asset('assets/images/payments.svg')}}"
                alt="properties">
        </div>
        <div>
            <h4 class="my-1 grid-icons-size text-dark" id="tile_free_hold_count"
                data-original="">7,864</h4>
            <p class="mb-0 text-secondary">No. of Land Transferred from NAC</p>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<div class="col">
    <div class="container-fluid govt_land_col">
        <div class="row row-cols-xl-2 row-cols-1">
            <div class="col" style="padding-left: 0px">
                <div class="card blue-gradient mb-1">
                    <div class="card-body">
                        <div class="d-flex align-items-center dashboard-cards">
                            <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
                                style="background-color: #fff;"><img
                                    src="{{asset('assets/images/properties-icon-hand.svg')}}" alt="properties">
                            </div>
                            <div>
                                <h4 class="my-1 grid-icons-size text-dark" id="tile_free_hold_count"
                                    data-original="">7,864</h4>
                                <p class="mb-0 text-secondary">Total No. of Govt. Land Parcels</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col" style="padding-right: 0px">
                <div class="card blue-gradient mb-1">
                    <div class="card-body">
                        <div class="d-flex align-items-center dashboard-cards">
                            <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
                                style="background-color: #fff;"><img
                                    src="{{asset('assets/images/properties-icon-hand.svg')}}" alt="properties">
                            </div>
                            <div>
                                <h4 class="my-1 grid-icons-size text-dark" id="tile_free_hold_count"
                                    data-original="">7,864</h4>
                                <p class="mb-0 text-secondary">Total No. of Alloted Land</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col" style="padding-left: 0px">
                <div class="card blue-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center dashboard-cards">
                            <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
                                style="background-color: #fff;"><img
                                    src="{{asset('assets/images/properties-icon-hand.svg')}}" alt="properties">
                            </div>
                            <div>
                                <h4 class="my-1 grid-icons-size text-dark" id="tile_free_hold_count"
                                    data-original="">7,864</h4>
                                <p class="mb-0 text-secondary">Total Available Land in Delhi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col" style="padding-right: 0px">
                <div class="card blue-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center dashboard-cards">
                            <div class="widgets-icons-2 rounded-circle text-white mr-icons-margin"
                                style="background-color: #fff;"><img
                                    src="{{asset('assets/images/properties-icon-hand.svg')}}" alt="properties">
                            </div>
                            <div>
                                <h4 class="my-1 grid-icons-size text-dark" id="tile_free_hold_count"
                                    data-original="">7,864</h4>
                                <p class="mb-0 text-secondary">Total Available Land Outside Delhi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------------------------------------------------------------------------------------------------------->
</div> --}}
<div class="row row-cols-2 row-cols-md-2 row-cols-xl-6 custom_card_container">

    <div class="col">
        <div class="card radius-10 border-start border-0">
            <div class="card-body">
                <div class="text-center">
                    <div class="widgets-icons-2 rounded-circle text-white m-auto"
                        style="background-color: #E0F2F1;"><img src="{{asset('assets/images/residential.svg')}}"
                            alt="properties">
                    </div>
                    <div>
                        <h4 class="my-1 text-dark view-list" id="residential_count"
                            data-original="{{customNumFormat($propertyTypeCount['Residential'])}}"
                            data-filter-name="property_type" data-filter-value="47">
                            {{customNumFormat($propertyTypeCount['Residential'])}}
                        </h4>
                        <p class="mb-0 text-secondary">Residential</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-start border-0">
            <div class="card-body">
                <div class="text-center">
                    <div class="widgets-icons-2 rounded-circle text-white m-auto"
                        style="background-color: #FFF3E0;"><img src="{{asset('assets/images/commercial.svg')}}"
                            alt="properties">
                    </div>
                    <div>
                        <h4 class="my-1 text-dark view-list" id="commercial_count"
                            data-original="{{customNumFormat($propertyTypeCount['Commercial'])}}"
                            data-filter-name="property_type" data-filter-value="48">
                            {{customNumFormat($propertyTypeCount['Commercial'])}}
                        </h4>
                        <p class="mb-0 text-secondary">Commercial</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-start border-0">
            <div class="card-body">
                <div class="text-center">
                    <div class="widgets-icons-2 rounded-circle text-white m-auto" style="background-color: #fde7e6;"><img src="{{asset('assets/images/factory.svg')}}"
                            alt="Industrial">
                    </div>
                    <div>
                        <h4 class="my-1 text-dark view-list" id="industrial_count"
                            data-original="{{customNumFormat($propertyTypeCount['Industrial'])}}"
                            data-filter-name="property_type" data-filter-value="469">
                            {{customNumFormat($propertyTypeCount['Industrial'])}}
                        </h4>
                        <p class="mb-0 text-secondary">Industrial</p>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-start border-0">
            <div class="card-body">
                <div class="text-center">
                    <div class="widgets-icons-2 rounded-circle text-white m-auto" style="background-color: #e2eff5;"><img
                            src="{{asset('assets/images/institute-Inst.svg')}}" alt="properties">
                    </div>
                    <div>
                        <h4 class="my-1 text-dark view-list" id="institutional_count"
                            data-original="{{customNumFormat($propertyTypeCount['Institutional'])}}"
                            data-filter-name="property_type" data-filter-value="49">
                            {{customNumFormat($propertyTypeCount['Institutional'])}}
                        </h4>
                        <p class="mb-0 text-secondary">Institutional</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-start border-0">
            <div class="card-body">
                <div class="text-center">
                    <div class="widgets-icons-2 rounded-circle text-white m-auto" style="background-color: #d6eff1;"><img
                            src="{{asset('assets/images/institute-Mix.svg')}}" alt="properties">
                    </div>
                    <div>
                        <h4 class="my-1 text-dark view-list" id="mixed_count"
                            data-original="{{customNumFormat($propertyTypeCount['Mixed'])}}"
                            data-filter-name="property_type" data-filter-value="72">
                            {{customNumFormat($propertyTypeCount['Mixed'])}}
                        </h4>
                        <p class="mb-0 text-secondary">Mixed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-start border-0">
            <div class="card-body">
                <div class="text-center">
                    <div class="widgets-icons-2 rounded-circle text-white m-auto" style="background-color: #f5e2d5;"><img
                            src="{{asset('assets/images/institute-Other.svg')}}" alt="properties">
                    </div>
                    <div>
                        <h4 class="my-1 text-dark view-list" id="others_count"
                            data-original="{{customNumFormat($propertyTypeCount['Others'])}}"
                            data-filter-name="property_type" data-filter-value="1353">
                            {{customNumFormat($propertyTypeCount['Others'])}}
                        </h4>
                        <p class="mb-0 text-secondary">Others</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!--end row-->
<div id="no-filter-applied">
    <div class="row">
        <div class="col-12 col-lg-5">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">No. of Properties Land Type Wise</h6>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                    class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Export PDF</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Export CSV</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="chart-container-1" style="height: 390px;">
                        <canvas id="chartProperties1"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-7">
            <div class="card radius-10">
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Area (Sqm)</th>
                                <th>No. of Properties</th>
                                <th>No. of Lease Hold Properties</th>
                                <th>No. of Free Hold Properties</th>
                                <th>Area of Properties</th>
                            </tr>
                        </thead>
                        @php
                        /*$labels = $propertyAreaDetails['labels'];*/
                        $totalCount = array_sum(array_column($propertyAreaDetails, 'count'));
                        $totalAreaInSqm = array_sum(array_column($propertyAreaDetails, 'area'));
                        $totalAreaInAcre = $totalAreaInSqm * 0.0002471053815;
                        @endphp
                        <tbody>
                            @foreach($propertyAreaDetails as $key=>$row)
                            <tr>
                                <td>{{$key}}</td>
                                <td>{{$row['count'].' ('. round(($row['count']/$totalCount)*100, 2).'%)'}}</td>
                                <td>{{$row['leaseHold'].' ('. round(($row['leaseHold']/$totalCount)*100, 2).'%)'}}</td>
                                <td>{{$row['freeHold'].' ('. round(($row['freeHold']/$totalCount)*100, 2).'%)'}}</td>
                                <td>{{$row['area'].' ('. round(($row['area']/$totalAreaInSqm)*100, 2). '%)'}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <th>Grand Total</th>
                                <th colspan="1">{{$totalCount}}</th>
                                <th colspan="3">{{round($totalAreaInSqm,3)}} ({{round($totalAreaInAcre)}} Acres)</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->

    {{-- <div class="row height-row-align">
            <div class="col-12 col-lg-8 height-col">
                <div class="card radius-10 same-height-card ">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Land Value</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                        class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Export PDF</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Export CSV</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="chart-container-1" style="height: 490px;">
                            <canvas id="landvalueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 height-col">
                <div class="card radius-10 same-height-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Value of Properties (INR)</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                        class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Export PDF</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Export CSV</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="chart-container-1 mt-5">
                            <div class="row align-items-center mb-5">
                                <div class="col-lg-6">
                                    <canvas id="chart2"></canvas>
                                </div>
                                <div class="col-lg-6">
                                    <h5 class="doudhnut-title">Year 2014</h5>
                                    <ul class="doughnut-data-1">
                                        <li><span class="nazula-circle"></span> ₹0 - Nazul</li>
                                        <li><span class="rehabilitation-circle"></span> ₹0 - Rehabilitation</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <canvas id="chartDoughnut2"></canvas>
                                </div>
                                <div class="col-lg-6">
                                    <h5 class="doudhnut-title">Year 2007</h5>
                                    <ul class="doughnut-data-1">
                                        <li><span class="nazula-circle"></span> ₹0 - Nazul</li>
                                        <li><span class="rehabilitation-circle"></span> ₹0 - Rehabilitation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    <!-- end row -->

    <div class="row">
        <div class="col-12 col-lg-7">
            <div class="card radius-10">
                <div class="card-body no-padding">
                    <div class="d-flex tabs-progress-container">
                        <div class="nav-tabs-left-aside">
                            <ul class="nav nav-tabs nav-primary" role="tablist" style="display: block !important;">

                                @if(count($tabHeader) > 0)
                                @foreach($tabHeader as $i=>$th)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{$i == 0 ? 'active': ''}}" data-bs-toggle="tab" href="#"
                                        role="tab" aria-selected="true" onclick="getTabData('{{$th->id}}')">
                                        <div class="text-center">
                                            <div class="tab-title">{{$th->property_type_name}}</div>
                                            <span class="tab-total-no">{{$th->counter}}</span>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="nav-tabs-right-aside">
                            <div class="tab-content py-3">
                                <div class="tab-pane fade show active" id="" role="tabpanel">
                                    <ul class="progress-report">
                                        <!-- new code -->
                                        <?php
                                        $max = 0;
                                        foreach ($tab1Details as $row) {
                                            $max = $row->counter > $max ? $row->counter : $max;
                                        }
                                        ?>

                                        @foreach($tab1Details as $detail)
                                        <li>
                                            <?php
                                            $width = $max > 0 ? ($detail->counter / $max) * 100 : 0;
                                            ?>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="progress-title">{{$detail->PropSubType}}</span>
                                                <span class="progress-result">{{$detail->counter}}</span>
                                            </div>
                                            <div class="progress mb-4" style="height:7px;">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: <?= $width ?>%"
                                                    aria-valuenow="{{$detail->counter}}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </li>
                                        @endforeach

                                    </ul>

                                    <!--- new code -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-5">
            <div class="card radius-10">
                <div class="card-body">
                <h6 class="">Outstanding Dues</h6>
                    <div class="table-demand">
                        <div class="table-responsive">
                            <table class="table align-middle m-0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="background-color:#116d6e17;">
                                            <h6 class="pt-2">Total Outstanding Dues </h6>
                                            <h5 class="pb-1">&#8377; {{customNumFormat(round(($oldDemandData['total']->outstanding_amount)/10000000,2))}} Cr. ({{customNumFormat($oldDemandData['total']->property_count)}} Properties)</h5>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                        <table class="table align-middle table-striped m-0">
                                            <thead>
                                                <tr>
                                                    <th>Property Status</th>
                                                    <th>Outstanding Dues</th>
                                                    <th>No. of Properties</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>Lease Hold</td>
                                                <td>&#8377; {{customNumFormat(round(($oldDemandData['leaseHold']->outstanding_amount)/10000000,2))}} Cr. </td>
                                                <td>{{customNumFormat($oldDemandData['leaseHold']->property_count)}}</td>
                                            </tr>
                                            <tr>
                                                <td>Free Hold</td>
                                                <td>&#8377; {{customNumFormat(round(($oldDemandData['freeHold']->outstanding_amount)/10000000,2))}} Cr. </td>
                                                <td>{{customNumFormat($oldDemandData['freeHold']->property_count)}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        </td>                                        
                                    </tr>
                                </tbody>
                            </table>
                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-12 col-lg-4">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Revenue (INR in CR)</h6>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                    class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Export PDF</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Export CSV</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="chart-container-2" style="height: 564px;">
                        <canvas id="revenueINR"></canvas>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <!-- end row -->
    {{-- <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Number of Properties</h6>
                            </div>
                            <ul class="graph-color-code ms-auto">
                                <li><span class="ap1"></span> Nazul</li>
                                <li><span class="ap2" style="background-color: #FFB74D;"></span> Rehabilitation</li>
                            </ul>
                            <div class="dropdown">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                        class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Export PDF</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Export CSV</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="chart-container-1" style="height: 480px;">
                            <canvas id="noofproperties"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 ">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Area-wise No. of Properties (Sqm)</h6>
                            </div>
                            <ul class="graph-color-code ms-auto">
                                <li><span class="ap1"></span> Nazul</li>
                                <li><span class="ap2"></span> Rehabilitation</li>
                            </ul>
                            <div class="dropdown">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                        class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Export PDF</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Export CSV</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="chart-container-2 mt-4" style="height: 365px;">
                            <canvas id="chart-area"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </div> --}}
</div>
</div>
<div id="filter-applied" class="d-none">
    @include('include.parts.dashboard-filtered')
</div>
</div>

@endif
@endsection
<!-- end row -->

@section('footerScript')
{{-- @haspermission('view dashboard') --}}
@if($isPublic ||( Auth::check() && Auth::user()->hasPermissionTo('view dashboard')))
<script src="{{ asset('assets/js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script> <!-- added By Nitin to for colony filter -->
<script src="{{ asset('assets/js/chartjs-plugin-datalabels.min.js') }}"></script>
<script src="{{ asset('assets/js/index.js') }}"></script>
<script>
    /** variabe added to imlemend colony filter */
    let colony_id = null;
    /**---------------------------------- */
    const datalabelOptions = {
        color: '#444',
        anchor: 'end',
        align: 'top',
        font: {
            size: 14
        }
    }
    $(document).ready(() => {

        //chart no. (nazul rehabilitation)
        var ctx2 = document.getElementById("chartProperties1").getContext('2d');

        var gradientStroke1 = ctx2.createLinearGradient(0, 0, 0, 300);
        gradientStroke1.addColorStop(0, '#64B5F6');
        // gradientStroke1.addColorStop(1, '#17c5ea');

        var gradientStroke2 = ctx2.createLinearGradient(0, 0, 0, 300);
        gradientStroke2.addColorStop(0, '#81C784');
        // gradientStroke2.addColorStop(1, '#ffdf40');

        var myChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['No. of Properties'],
                datasets: [{
                        label: 'Nazul',
                        data: ["{{$landTypeCount['Nazul']}}"],
                        borderColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        hoverBackgroundColor: gradientStroke1,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 0
                    },
                    {
                        label: 'Rehabilitation',
                        data: ["{{$landTypeCount['Rehabilitation']}}"],
                        borderColor: gradientStroke2,
                        backgroundColor: gradientStroke2,
                        hoverBackgroundColor: gradientStroke2,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 0
                    }
                ]
            },

            options: {
                plugins: {
                    datalabels: datalabelOptions
                },
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    display: true,
                    labels: {
                        boxWidth: 8
                    }
                },
                tooltips: {
                    displayColors: true,
                    display: true
                },
                scales: {
                    xAxes: [{
                        barPercentage: .5
                    }]
                }
            }
        });

        /*var ctx3 = document.getElementById("chart-area").getContext('2d');

        var gradientStroke1 = ctx3.createLinearGradient(0, 0, 0, 300);
        gradientStroke1.addColorStop(0, '#64B5F6');
        // gradientStroke1.addColorStop(1, '#17c5ea'); 

        var gradientStroke2 = ctx3.createLinearGradient(0, 0, 0, 300);
        gradientStroke2.addColorStop(0, '#E57373');
        // gradientStroke2.addColorStop(1, '#ffdf40');

        var myChart = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: [<?= implode(", ", $seriesLabels) ?>],
                datasets: [{
                        label: '{{$labels[0]}}',
                        data: [<?= implode(", ", $barData[0]) ?>],
                        borderColor: gradientStroke1,
                        backgroundColor: gradientStroke1,
                        hoverBackgroundColor: gradientStroke1,
                        pointRadius: 0,
                        fill: false,
                        borderWidth: 0
                    },
                    {
                        label: '{{$labels[1]}}',
                        data: [<?= implode(", ", $barData[1]) ?>],
                        borderColor: gradientStroke2,
                        backgroundColor: gradientStroke2,
                        hoverBackgroundColor: gradientStroke2,
                        pointRadius: 1,
                        fill: false,
                        borderWidth: 1
                    }
                ]
            },

            options: {
                plugins: {
                    datalabels: datalabelOptions
                },
                maintainAspectRatio: false,
                legend: {
                    position: 'top',
                    display: false,
                    labels: {
                        boxWidth: 0
                    }
                },
                tooltips: {
                    displayColors: false,
                },
                scales: {
                    XAxes: [{
                        barPercentage: .5
                    }]
                }
            }
        });*/
    });


    /** Land Value chart -------------*/

    /*var ctx4 = document.getElementById("landvalueChart").getContext("2d");

    var gradientStroke1 = ctx4.createLinearGradient(0, 0, 0, 300);
    gradientStroke1.addColorStop(0, "#81C784");
    // gradientStroke1.addColorStop(1, '#17c5ea');

    var gradientStroke2 = ctx4.createLinearGradient(0, 0, 0, 300);
    gradientStroke2.addColorStop(0, "#81C784");
    // gradientStroke2.addColorStop(1, '#ffdf40');

    var myChart = new Chart(ctx4, {
        type: "bar",
        data: {
            labels: [<?= implode(", ", $landValueData['labels']) ?>],
            datasets: [{
                label: "Land Value",
                data: [<?= implode(", ", $landValueData['values']) ?>],
                borderColor: gradientStroke1,
                backgroundColor: gradientStroke1,
                hoverBackgroundColor: gradientStroke1,
                pointRadius: 0,
                fill: false,
                borderWidth: 0,
            }, ],
        },

        options: {
            plugins: {
                datalabels: datalabelOptions,
            },
            maintainAspectRatio: false,
            legend: {
                position: "bottom",
                display: false,
                labels: {
                    boxWidth: 2,
                },
            },
            tooltips: {
                displayColors: false,
            },
            scales: {
                xAxes: [{
                    barPercentage: 0.5,
                }, ],
            },
        },
    });*/




    /** Land Value chart -------------*/

    /*** new code by Nitin ---  */
    const getTabData = (tabId) => {
        var ajaxUrl = "{{ route('propertyTypeDetails', [':typeId', ':colonyId']) }}"
    .replace(':typeId', tabId)
    .replace(':colonyId', colony_id ? colony_id : '');
        $.ajax({
            type: 'get',
            url: ajaxUrl,
            success: response => {
                let updatedHTML = '';
                //get max counter 
                let max = 0;
                response.map(row => {
                    max = row.counter > max ? row.counter : max;
                });
                //get progressbar html for each row
                response.map(row => {
                    let width = (max > 0) ? (row.counter / max) * 100 : 0;
                    updatedHTML += `<li>
						<div class = "d-flex justify-content-between align-items-center mb-2">
							<span class = "progress-title">${row.PropSubType}</span>
							<span class="progress-result">${row.counter}</span>
						</div>
						<div class = "progress mb-4" style = "height:7px;">
						<div class="progress-bar" role="progressbar" style="width: ${width}%" aria-valuenow="${row.counter}" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</li>`

                })
                $('ul.progress-report').html(updatedHTML);
            },
            error: errorResponse => {
                console.log(errorResponse);
            }
        })
    }

    /** on selecting  a colony froom colony dropdown*/

    $('#colony-filter').change(() => {
        colony_id = $('#colony-filter').val();
        if (colony_id != "") {
            $('#colony-filter').find('option:first').text('Remove Colony Filter');
            $('#colony-filter').selectpicker('refresh');
            $.ajax({
                type: 'POST',
                url: "{{route('dashbordColonyFilter')}}",
                data: {
                    _token: '{{csrf_token()}}',
                    colony_id: colony_id
                },
                success: (response) => {
                    if (Object.keys(response).length > 0) {
                        $('#no-filter-applied').addClass('d-none'); // hide main dashboaed
                        $('#filter-applied').removeClass('d-none'); // show filtered table and tabs

                        for (const key in response) {
                            // update the tiles
                            if (response.hasOwnProperty(key)) {
                                const value = response[key];
                                let targetElement = $('#tile_' + key);
                                if (targetElement.length) {
                                    if (targetElement.hasClass('hoverable')) {
                                        targetElement.attr('title', value);
                                    } else {
                                        targetElement.html(value);
                                    }
                                }

                            }
                        }
                    }

                    //update property types

                    if (response.property_types && Object.keys(response.property_types).length > 0) {
                        $('.tab-total-no').html(0);
                        let ptypes = response.property_types
                        for (const ind in ptypes) {
                            // debugger;
                            if (ptypes.hasOwnProperty(ind)) {
                                const value = ptypes[ind];
                                let targetElement = $('#' + ind + '_count');
                                if (targetElement.length) {
                                    targetElement.html(value);
                                }

                                //update the tab data
                                let tabElement = $('#tab_total_' + ind);
                                if (tabElement.length) {
                                    tabElement.html(value);
                                }
                            }
                        }
                    }

                    //update table
                    if (response.areaRangeData.length > 0) {
                        const tbody = $('#area-wise-details tbody');
                        $('#area-wise-details tbody').empty();
                        response.areaRangeData.forEach(item => {
                            tbody.append(`<tr>
								<td>${item.label}</td>
								<td>${item.count} (${item.percent_count}%)</td>
								<td>${item.leaseHoldCount} (${item.percent_leaseHold}%)</td>
								<td>${item.freeHoldCount} (${item.percent_freeHold}%)</td>
								<td>${item.area.toFixed(2)} (${item.percent_area}%)</td>
							</tr>`);
                        });
                        let totalAreaInSqm = response.total_area;
                        let totalAreaInAcre = Math.round(totalAreaInSqm * 0.0002471053815);
                        tbody.append(`<tr>
								<th>Grand Total</th>
								<th>${response.total_count}</th>
								<th colspan="3">${totalAreaInSqm.toFixed(3)} (${totalAreaInAcre} Acres)</th>
							</tr>`);
                    }

                    //click the first tab

                    var elemFound = $('[id^=tab_total_]');
                    if (elemFound.length > 0) {
                        elemFound[0].closest('a').click();
                    }


                },
                error: (err) => {
                    console.log(err);
                }
            })
        } else {
            //reset the filter
            $('.text-dark').each((i, elm) => { // reset text content
                if ($(elm).attr('data-original') !== undefined) {
                    $(elm).html($(elm).attr('data-original'));
                }
            })
            $('.hoverable').each((i, elm) => { // reset text content
                if ($(elm).attr('data-original') !== undefined) {
                    $(elm).attr('title', $(elm).attr('data-original'));
                }
            })
            $('#no-filter-applied').removeClass('d-none'); // show main dashboaed
            $('#filter-applied').addClass('d-none'); // hide filtered table and tabs

            //Chnage the dropdown first option

            $('#colony-filter').find('option:first').text('Filter by Colony ({{$number_of_colonies}})');
            $('#colony-filter').selectpicker('refresh');

            // reset colony id
            colony_id = null;
        }
    })


    $('.view-list').click(function() {
        let linkEnabled = '<?= $isPublic == true ? 0 : 1 ?>';
        if (linkEnabled == '1') {
            let filterName = $(this).data('filterName');
            let filterValue = $(this).data('filterValue');
            let filterData = (filterName && filterValue) ? {
                [`${filterName}[]`]: filterValue
            } : {};

            if (colony_id) {
                filterData = {
                    ...filterData,
                    "colony[]": colony_id
                }
            }

            // Create a query string from the filterData
            let queryString = $.param(filterData);

            // Construct the URL with the query string
            let url = '';
            if (filterValue == 'unalloted') {
                url = `{{ route("unallotedReport") }}`;
            } else {
                url = `{{ route("detailedReport") }}?${queryString}`;
            }

            // Open the URL in a new tab
            window.open(url, '_blank');
        }

    });
</script>
{{-- @endhaspermission --}}
@endif
@endsection
