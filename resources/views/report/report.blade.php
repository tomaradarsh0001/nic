@extends('layouts.app')

@section('title', 'Report')

@section('content')

<style>
    .page-item.active a {
        color: #fff !important;
    }

    .dropdown-item.active span.text {
        color: #fff !important;
    }

    .summary {
        display: flex;
        justify-content: space-between;
    }

    /**REPORT LIST  */
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

    .landtypeFreeH {
        background-color: #116d6e17;
        color: #116d6e !important;
        padding: 2px 6px;
        margin: 2px;
    }

    .landtypeRehab {
        background-color: #d7ae1a21;
        color: #9b7c0f !important;
        padding: 2px 6px;
        margin: 2px;
    }

    .landuseResid {
        background-color: #321e1e17;
        color: #321e1e !important;
        padding: 2px 6px;
        margin: 2px;
    }

    .statusRGRNo {
        background-color: rgb(223, 83, 97, 0.129);
        color: #df5361 !important;
        padding: 2px 6px;
    }

    .view_more_link {
        font-weight: 500 !important;
    }

    /* .card {
        border: 0px !important;
    } */

    .parent_table_container {
        border-bottom: 1px solid #dcdcdc;
        margin-bottom: 10px;
        padding-bottom: 10px;
    }
    .show-demand-modal{
        font-weight: 500 !important;
    }
    .export-btn {
        font-size: 14px;
    }

    button.export-btn:nth-child(1) svg {
        width: 30px;
        height: 30px;
    }

    button.export-btn:nth-child(1) {
        border-left: 1px solid #ddd;
        padding: 0px 20px;
    }

    button.export-btn svg {
        width: 35px;
        height: 35px;
    }

    button.export-btn {
        border: 0px;
        background: transparent;
    }
    #spinnerOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            /* Ensure it covers other content */
        }

        .spinner {
            border: 8px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 8px solid #ffffff;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
</style>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Reports</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Filter & Search Reports</li>
            </ol>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card group_filters_container sticky-div">
            <div class="card-body">
                <form action="#">
                    <div class="group-row-filters">
                        <div class="d-flex align-items-start w-btn-full">

                            <div class="relative-input mb-3">
                                <select class="selectpicker" aria-label="Land" aria-placeholder="Land" data-live-search="true" title="Land" id="land-type">
                                    <option value="">All</option>
                                    @foreach ($landTypes[0]->items as $landType)
                                    <option value="{{$landType->id}}">{{ $landType->item_name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="input-reset-icon" data-filter="land_type" data-targets="#land-type"><i class="lni lni-cross-circle"></i></button>
                            </div>

                            <div class="relative-input mb-3 mx-2">
                                <select class="selectpicker propType multipleSelect" multiple aria-label="Land Use Type" data-live-search="true" title="Land Use Type" id="property-Type" name="property_type[]">
                                    <option value="">All</option>
                                    @foreach ($propertyTypes[0]->items as $propertyType)
                                    <option value="{{$propertyType->id}}">{{ $propertyType->item_name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="input-reset-icon" data-filter="property_type" data-targets='#property-Type'><i class="lni lni-cross-circle"></i></button>
                            </div>
                            <div class="relative-input mb-3 mx-2">
                                <select class="selectpicker propSubType multipleSelect" multiple aria-label="Land Use Sub-Type" data-live-search="true" title="Land Use Sub-Type" id="prop-sub-type" name="property_sub_type[]">
                                    <option value="">All</option>
                                </select>
                                <button type="button" class="input-reset-icon" data-filter="property_sub_type" data-targets='#prop-sub-type'><i class="lni lni-cross-circle"></i></button>
                            </div>

                            <div class="relative-input mb-3 mx-2">
                                <select class="selectpicker multipleSelect" multiple aria-label="Land Status" data-live-search="true" title="Land Status" id="land-status" name="property_status[]">
                                    <option value="">All</option>
                                    @foreach ($propertyStatus[0]->items as $status)
                                    <option value="{{$status->id}}">{{ $status->item_name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="input-reset-icon" data-filter="land_status" data-targets='#land-status'><i class="lni lni-cross-circle"></i></button>
                            </div>
                            <div class="relative-input mb-3 mx-2">
                                <select class="selectpicker colony" multiple aria-label="Search by Colony" data-live-search="true" title="Colony ({{getMisDoneColoniesCount();}})" id="colony_filter" name="colony[]">
                                    <option value="">All</option>
                                    @foreach ($colonyList as $colony)
                                    <option value="{{$colony->id}}">{{ $colony->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="input-reset-icon" data-filter="colony" data-targets="#colony_filter"><i class="lni lni-cross-circle"></i></button>
                            </div>

                        </div>
                        <div class="d-flex align-items-start">
                            <div class="dual-input-label mr-2">
                                <label for="landsize">Land Size(Sqm.)</label>
                                <div class="group-min-max">
                                    <div class="input-relative">
                                        <input class="form-control landSizeRange minValue" id="minLandSizeRange" type="number" placeholder="Min" min="0">
                                    </div>
                                    <div class="dash-icon"><i class="lni lni-minus"></i></div>
                                    <div class="input-relative ml-1">
                                        <input class="form-control landSizeRange maxValue" id="maxLandSizeRange" type="number" placeholder="Max" min="0">
                                    </div>
                                    <button type="button" class="input-reset-icon" data-filter="land_size" data-targets='.landSizeRange'><i class="lni lni-cross-circle"></i></button>
                                </div>
                            </div>
                            <div class="dual-input-label">
                                <label for="landvalue">Land Value</label>
                                <div class="group-min-max">
                                    <div class="input-relative">
                                        <input class="form-control minValue landValueRange" type="number" placeholder="Min" min="0" id="minLandValueRange">
                                    </div>
                                    <div class="dash-icon"><i class="lni lni-minus"></i></div>
                                    <div class="input-relative ml-1">
                                        <input class="form-control maxValue landValueRange" type="number" placeholder="Max" min="0" id="maxLandValueRange">
                                    </div>
                                    <button type="button" class="input-reset-icon" data-targets='.landValueRange' data-filter="land_value"><i class="lni lni-cross-circle"></i></button>
                                </div>
                            </div>

                            <div class="select-menu form-select mx-2">
                                <div class="select-btn">
                                    <span class="sBtn-text">More Filters</span>
                                    <i class="bx bx-chevron-down"></i>
                                </div>
                                <div class="options">
                                    <div class="d-flex align-items-start">
                                        <div class="list-parent">
                                            <ul class="nav nav-tabs nav-primary custom-dropdown" role="tablist">
                                                <li class="nav-item option" role="presentation">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#groundrent" role="tab" aria-selected="true">
                                                        <div class="d-flex align-items-center">
                                                            <div class="tab-title">Ground Rent</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="nav-item option" role="presentation">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#GRRevision" role="tab" aria-selected="false">
                                                        <div class="d-flex align-items-center">
                                                            <div class="tab-title">GR Revision</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="nav-item option" role="presentation">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#ReEnteredSince" role="tab" aria-selected="false">
                                                        <div class="d-flex align-items-center">
                                                            <div class="tab-title">Re-Entered Since</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="nav-item option" role="presentation">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#Revenue" role="tab" aria-selected="false">
                                                        <div class="d-flex align-items-center">
                                                            <div class="tab-title">Revenue</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="nav-item option" role="presentation">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#OutstandingDues" role="tab" aria-selected="false">
                                                        <div class="d-flex align-items-center">
                                                            <div class="tab-title">Outstanding Dues</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="nav-item option" role="presentation">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#LeaseDeed" role="tab" aria-selected="false">
                                                        <div class="d-flex align-items-center">
                                                            <div class="tab-title">Lease Deed</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="nav-item option" role="presentation">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#LeaseTenure" role="tab" aria-selected="false">
                                                        <div class="d-flex align-items-center">
                                                            <div class="tab-title">Lease Tenure</div>
                                                        </div>
                                                    </a>
                                                </li>
                                                  <li class="nav-item option" role="presentation">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#doerange" role="tab" aria-selected="false">
                                                        <div class="d-flex align-items-center">
                                                            <div class="tab-title">Date of Execution</div>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content list-right-size">
                                            <div class="tab-pane fade show active" id="groundrent" role="tabpanel">
                                                <div class="mt-5">
                                                    <div class="dual-input-label mt-5">
                                                        <div class="group-min-max">
                                                            <div class="input-relative">
                                                                <input class="form-control groundRentRange minValue" id="groundRentMin" type="number" placeholder="Min" min="0">
                                                            </div>
                                                            <div class="dash-icon"><i class="lni lni-minus"></i></div>
                                                            <div class="input-relative ml-1">
                                                                <input class="form-control groundRentRange maxValue" id="groundRentMax" type="number" placeholder="Max" min="0">
                                                            </div>
                                                            <button type="button" class="input-reset-icon" data-filter="groundRent" data-targets='.groundRentRange'><i class="lni lni-cross-circle"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="GRRevision" role="tabpanel">
                                                <ul class="sub-list-checkbox-items">
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="Overdue">
                                                            <label class="form-check-label" for="Overdue">Overdue</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="months3">
                                                            <label class="form-check-label" for="months3">In 3 months</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="months36">
                                                            <label class="form-check-label" for="months36">In 3-6 Months</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="months12">
                                                            <label class="form-check-label" for="months12">In 6-12 months</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="months12more">
                                                            <label class="form-check-label" for="months12more">More than 12
                                                                Months</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane fade" id="ReEnteredSince" role="tabpanel">
                                                <ul class="sub-list-checkbox-items">
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="all">
                                                            <label class="form-check-label" for="all">All</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="y5+" id="5years">
                                                            <label class="form-check-label" for="5years">> 5
                                                                Years</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="1y - 5y" id="1_5years">
                                                            <label class="form-check-label" for="1_5years">1
                                                                - 5 Years</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="6m - 1y" id="months06">
                                                            <label class="form-check-label" for="months06">6
                                                                months - 1 Year</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="1m - 6m" id="months16">
                                                            <label class="form-check-label" for="months16">1
                                                                month - 6 months</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="m1-" id="lessthanmonth">
                                                            <label class="form-check-label" for="lessthanmonth">Less than a
                                                                month</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane fade" id="Revenue" role="tabpanel">
                                                <ul class="sub-list-checkbox-items">
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="all">
                                                            <label class="form-check-label" for="all">All</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="GR">
                                                            <label class="form-check-label" for="GR">GR</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="Conversion">
                                                            <label class="form-check-label" for="Conversion">Conversion</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="Breaches">
                                                            <label class="form-check-label" for="Breaches">Breaches</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="InterestPenalty">
                                                            <label class="form-check-label" for="InterestPenalty">Interest/ Penalty</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="Others">
                                                            <label class="form-check-label" for="Others">Others</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane fade" id="OutstandingDues" role="tabpanel">
                                                <div class="dual-input-label mt-5">
                                                    <div class="group-min-max">
                                                        <div class="input-relative">
                                                            <input class="form-control outstandingDuesRange minValue" id="outstandingDuesMin" type="number" placeholder="Min" min="0">
                                                        </div>
                                                        <div class="dash-icon"><i class="lni lni-minus"></i></div>
                                                        <div class="input-relative ml-1">
                                                            <input class="form-control outstandingDuesRange maxValue" id="outstandingDuesMax" type="number" placeholder="Max" min="0">
                                                        </div>
                                                        <button type="button" class="input-reset-icon" data-filter="outstandingDues" data-targets=".outstandingDuesRange"><i class="lni lni-cross-circle"></i></button>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="tab-pane fade" id="LeaseDeed" role="tabpanel">
                                                <ul class="sub-list-checkbox-items">
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="all">
                                                            <label class="form-check-label" for="all">All</label>
                                                        </div>
                                                    </li>

                                                    @foreach ($leaseTypes[0]->items as $leaseType)

                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="{{$leaseType->id}}">
                                                            <label class="form-check-label">{{ $leaseType->item_name }}</label>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="tab-pane fade" id="LeaseTenure" role="tabpanel">
                                                <ul class="sub-list-checkbox-items">
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="all">
                                                            <label class="form-check-label" for="all">All</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="Perpetual" id="Perpetual">
                                                            <label class="form-check-label" for="Perpetual">Perpetual</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="75+" id="75years">
                                                            <label class="form-check-label" for="75years">> 75 years</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="50 - 75" id="50 - 75 Years">
                                                            <label class="form-check-label" for="50 - 75 Years">50 - 75 Years</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="25 - 50" id="2550Years">
                                                            <label class="form-check-label" for="2550Years">25 - 50 Years</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="5 - 25" id="525Years">
                                                            <label class="form-check-label" for="525Years">5 - 25 Years</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="0 - 5" id="5Years">
                                                            <label class="form-check-label" for="5Years">
                                                                < 5 Years</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
<div class="tab-pane fade" id="doerange" role="tabpanel">
                                                <div class="mt-5">
                                                    <div class="dual-input-label mt-5">
                                                        <div class="group-min-max">
                                                            <div class="input-relative">
                                                                <input class="form-control doeRange minValue" id="doeMin" type="date" placeholder="Lease Execution Date from">
                                                            </div>
                                                            <div class="dash-icon"><i class="lni lni-minus"></i></div>
                                                            <div class="input-relative ml-1 pe-5">
                                                                <input class="form-control doeRange maxValue" id="doeMax" type="date" placeholder="Lease Execution Date to">
                                                            </div>
                                                            <button type="button" class="input-reset-icon" data-filter="date_of_execution" data-targets='.doeRange'><i class="lni lni-cross-circle"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-group-filter">
                                <button type="button" class="btn btn-secondary px-5 filter-btn" onclick="resetFilters()">Reset</button>
                                <button type="button" class="btn btn-primary px-5 filter-btn" onclick="handleFilterChange()">Apply</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card group_filters_containers">
            <div class="card-body">
                <div class="search-container d-flex align-items-start">
                    <div class="input-relative mr-2">
                        <i class="lni lni-search-alt"></i>
                        <input class="form-control" type="text" placeholder="Search By Name" id="name_filter">
                        <button type="button" class="input-reset-icon" data-filter="name" data-targets="#name_filter"><i class="lni lni-cross-circle"></i></button>
                    </div>
                    <div class="input-relative mx-2">
                        <i class="lni lni-search-alt"></i>
                        <input class="form-control" type="text" placeholder="Search by Contact No." id="contact_filter">
                        <button type="button" class="input-reset-icon" data-filter="contact" data-targets="#contact_filter"><i class="lni lni-cross-circle"></i></button>
                    </div>
                    <div class="input-relative mx-2">
                        <i class="lni lni-search-alt"></i>
                        <input class="form-control" type="text" placeholder="Search by Property Id" id="propertyIdSearch">
                        <button type="button" class="input-reset-icon" data-filter="propertyId" data-targets="#propertyIdSearch"><i class="lni lni-cross-circle"></i></button>
                    </div>
                    <div class="input-relative ml-2">
                        <i class="lni lni-search-alt"></i>
                        <input class="form-control" type="text" placeholder="Search by Address" id="propertyAddressSearch">
                        <button type="button" class="input-reset-icon" data-filter="propertyAddress" data-targets="#propertyAddressSearch"><i class="lni lni-cross-circle"></i></button>
                    </div>
                    <div class="input-relative ml-2">
                        <div class="buttons d-flex gap-x-2 justify-content-end">
                            <button type="button" class="filter-btn export-btn mx-1" data-toggle="tooltip" title="Download Excel" data-export-format="xls">
                                <svg width="25px" height="25px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M28.781,4.405H18.651V2.018L2,4.588V27.115l16.651,2.868V26.445H28.781A1.162,1.162,0,0,0,30,25.349V5.5A1.162,1.162,0,0,0,28.781,4.405Zm.16,21.126H18.617L18.6,23.642h2.487v-2.2H18.581l-.012-1.3h2.518v-2.2H18.55l-.012-1.3h2.549v-2.2H18.53v-1.3h2.557v-2.2H18.53v-1.3h2.557v-2.2H18.53v-2H28.941Z" style="fill:#20744a;fill-rule:evenodd" />
                                    <rect x="22.487" y="7.439" width="4.323" height="2.2" style="fill:#20744a" />
                                    <rect x="22.487" y="10.94" width="4.323" height="2.2" style="fill:#20744a" />
                                    <rect x="22.487" y="14.441" width="4.323" height="2.2" style="fill:#20744a" />
                                    <rect x="22.487" y="17.942" width="4.323" height="2.2" style="fill:#20744a" />
                                    <rect x="22.487" y="21.443" width="4.323" height="2.2" style="fill:#20744a" />
                                    <polygon points="6.347 10.673 8.493 10.55 9.842 14.259 11.436 10.397 13.582 10.274 10.976 15.54 13.582 20.819 11.313 20.666 9.781 16.642 8.248 20.513 6.163 20.329 8.585 15.666 6.347 10.673" style="fill:#ffffff;fill-rule:evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end row-->
@include('include.alerts.ajax-alert')
<div class="row align-data-height results d-none">
    <div class="col-xl-12 col-12">
        <div class="card list-data-height">
            <div class="card-body">
                <div class="summary">

                    <div class="resultInfo">

                    </div>

                    <nav aria-label="...">
                        <ul class="pagination" style="justify-content: center;">
                            <li class="page-item disabled" id="page-previous"><a class="page-link" href="javascript:;" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item" id="page-next"><a class="page-link" href="javascript:;">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="property-data"></div>
                <div class="summary">
                    <div class="resultInfo">
                    </div>
                    <!-- <div class="buttons">
                        <button type="button" class="btn btn-primary px-5 filter-btn export-btn" data-export-format="csv">CSV</button>
                        <button type="button" class="btn btn-primary px-5 filter-btn export-btn" data-export-format="xls">XLSX</button>
                        <button type="button" class="btn btn-primary filter-btn export-btn btn-md">Map View</button>
                    </div> -->
                    <nav aria-label="...">
                        <ul class="pagination" style="justify-content: center;">
                            <li class="page-item disabled" id="page-previous"><a class="page-link" href="javascript:;" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item" id="page-next"><a class="page-link" href="javascript:;">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="viewMapModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Property ID: <span class="propId">32525</span></h5>
                <button class="btn btn-danger d-none" id="notFoundAlert">Property not found</button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('modals.map')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{route('map')}}" class="btn btn-primary" target="_blank">View All Properties</a>
            </div>
        </div>
    </div>
</div>

<div id="spinnerOverlay" style="display:none;">

    <!-- <div class="spinner"></div> -->

    <img src="{{ asset('assets/images/chatbot_icongif.gif') }}">

</div>

@include('report.due-demand')
@endsection

@section('footerScript')
<script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/js/property-type-subtype-dropdown.js') }}"></script>
<script src="{{ asset('assets/js/knobs.min.js') }}"></script>
<script src="{{ asset('assets/js/map.js') }}"></script>

<script>
        var streetViewUrl = "{{ route('streetview', ['id' => '__ID__']) }}";

    let filters = {};
    let pageNumber = 1;
    let totalPages;
    const optionMenu = document.querySelector(".select-menu"),
        selectBtn = optionMenu.querySelector(".select-btn"),
        options = optionMenu.querySelectorAll(".option"),
        sBtn_text = optionMenu.querySelector(".sBtn-text");

    selectBtn.addEventListener("mouseenter", () =>
        optionMenu.classList.toggle("active")
    );

    optionMenu.addEventListener("mouseleave", () => {
        optionMenu.classList.remove("active");
    });

    options.forEach((option) => {
        option.addEventListener("mouseleave", () => {
            let selectedOption = option.querySelector(".option-text").innerText;
            sBtn_text.innerText = selectedOption;

            optionMenu.classList.remove("active");
        });
    });
    $(document).ready(function() {
        $(".range-filter-btn").click(function() {
            $(".range-controller").fadeToggle();;
        });
        $(".range-filter-btn2").click(function() {
            $(".range-controller2").fadeToggle();
        });
        getFilterData();
    });


    /** for property type subtype dropdowns added By Nitin */
    $(document).ready(() => {

        $('.multipleSelect').change(function() {
            var valueArr = $(this).val();
            if (valueArr.indexOf('') > -1) {
                $(this).val([]);
            }
        })

        $('#property-Type').on('change', function() {
            var idPropertyType = $("#property-Type").val();
            if (idPropertyType) {
                if (idPropertyType.length > 0) { //add selected options in filters
                    if (filters.property_type != idPropertyType) {
                        filters.property_type = idPropertyType;
                    }
                } else {
                    // delet propery_type filter
                    delete filters.property_type;

                }
            }


        });

        $("#land-type").change(() => {
            const val = $("#land-type").val();
            if (val != '') {
                if (val != filters.land_type)
                    filters.land_type = val;


            } else {
                delete filters.land_type;

            }
        })
        $("#land-status").change((e) => {
            const val = $("#land-status").val();
            if (val != '') {
                if (val != filters.land_status)
                    filters.land_status = val;


            } else {
                delete filters.land_status;

            }
        })
        $("#prop-sub-type").change((e) => {
            const val = $("#prop-sub-type").val();
            if (val != '') {
                if (val != filters.property_sub_type)
                    filters.property_sub_type = val;
            } else {
                delete filters.property_sub_type;
            }

        })
    });

    $('.landSizeRange').change(() => {
        const minVal = $('#minLandSizeRange').val();
        const maxVal = $('#maxLandSizeRange').val();

        filters.land_size = {
            min: minVal,
            max: maxVal
        }
    });
    $('.landValueRange').change(() => {
        const minVal = $('#minLandValueRange').val();
        const maxVal = $('#maxLandValueRange').val();

        filters.land_value = {
            min: minVal,
            max: maxVal
        }
    });
     //date of execution filter added on 28-04-2025
    $('.doeRange').change(() => {
        const minVal = $('#doeMin').val();
        const maxVal = $('#doeMax').val();

        filters.date_of_execution = {
            min: minVal,
            max: maxVal
        }
    });
    function debounce(func, delay) {
        let timeoutId;
        return function(...args) {
            const context = this;
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                func.apply(context, args);
            }, delay);
        };
    }

    $('#name_filter').keyup(debounce(function() {
        var name = $(this).val().trim();
        if (name.length > 0) {
            filters.name = name;
        } else {
            delete filters.name;
        }

    }, 400));

    $('#contact_filter').keyup(function() {
        var number = $(this).val().trim();
        if (!isNaN(number)) {
            filters.contact = number;
        } else {
            delete filters.contact
        }

    });



    /**Detect change in more filters */
    //1. leaseDeed Filter
    $('#LeaseDeed .form-check-input').change(function() {
        if (filters.leaseDeed == undefined) {
            filters.leaseDeed = [];
        }

        var inputVal = $(this).val();
        if ($(this).is(':checked')) {
            if (inputVal == '') { //if All is selected -  then remove leasefilter
                $('#LeaseDeed .form-check-input').prop('checked', false)
                delete filters.leaseDeed;
            } else {
                filters.leaseDeed.push(inputVal)
            }
        } else {
            filters.leaseDeed = filters.leaseDeed.filter(filterVal => filterVal != inputVal);
            if (filters.leaseDeed.length == 0) {
                delete filters.leaseDeed
            }
        }

    })

    //2. lease tenure filter

    $('#LeaseTenure .form-check-input').change(function() {
        if (filters.leaseTenure == undefined) {
            filters.leaseTenure = [];
        }

        var inputVal = $(this).val();
        if ($(this).is(':checked')) {
            if (inputVal == '') { //if All is selected -  then remove leasefilter
                $('#LeaseTenure .form-check-input').prop('checked', false)
                delete filters.leaseTenure;
            } else {
                filters.leaseTenure.push(inputVal)
            }
        } else {
            filters.leaseTenure = filters.leaseTenure.filter(filterVal => filterVal != inputVal);
            if (filters.leaseTenure.length == 0) {
                delete filters.leaseTenure
            }
        }

    })

    // locality filter
    $("#colony_filter").change((e) => {
        const val = $("#colony_filter").val();
        if (val != '') {
            if (val != filters.colony)
                filters.colony = val;
        } else {
            delete filters.colony;
        }

    })


    //property Id Search

    $('#propertyIdSearch').blur(function() {
        var val = $(this).val().trim();
        if (val.length > 2 && !isNaN(val)) {
            filters.propertyId = val;
        } else {
            if (filters.propertyId)
                delete filters.propertyId
        }

    })

    //property Address Search

    $('#propertyAddressSearch').blur(function() {
        var val = $(this).val().trim();
        if (val.length > 2) {
            filters.propertyAddress = val;
        } else {
            if (filters.propertyAddress)
                delete filters.propertyAddress
        }

    })

    //ground rent

    $('.groundRentRange').change(() => {
        const minVal = $('#groundRentMin').val();
        const maxVal = $('#groundRentMax').val();
        filters.groundRent = {
            min: minVal,
            max: maxVal
        }


    })


    //outstanding dues

    $('.outstandingDuesRange').change(() => {
        const minVal = $('#outstandingDuesMin').val();
        const maxVal = $('#outstandingDuesMax').val();
        filters.outstandingDues = {
            min: minVal,
            max: maxVal

        }
    })

    //re entered

    $('#ReEnteredSince .form-check-input').change(function() {
        if (filters.reEnteredSince == undefined) {
            filters.reEnteredSince = [];
        }

        var inputVal = $(this).val();
        if ($(this).is(':checked')) {
            if (inputVal == '') { //if All is selected -  then remove leasefilter
                $('#ReEnteredSince .form-check-input').prop('checked', false)
                delete filters.reEnteredSince;
            } else {
                filters.reEnteredSince.push(inputVal)
            }
        } else {
            filters.reEnteredSince = filters.reEnteredSince.filter(filterVal => filterVal != inputVal);
            if (filters.reEnteredSince.length == 0) {
                delete filters.reEnteredSince
            }
        }

    })


    $('.input-reset-icon').click(function() {
        var filterName = $(this).data('filter');
        var targetElement = $($(this).data('targets'));
        if (filters[filterName]) {
            if (targetElement.length == 1 && targetElement.prop("tagName") && (targetElement.prop("tagName").toLowerCase() == 'select')) {
                if (Array.isArray(filters[filterName])) {
                    targetElement.selectpicker('deselectAll');
                } else {
                    targetElement.val('')
                    targetElement.selectpicker('render');
                }
            } else {
                targetElement.val('');
            }
            if (filterName == 'property_type') { //if filter is property type then also remove property sub type filter and clear dropdown
                $('#prop-sub-type').selectpicker('deselectAll');
                $('#prop-sub-type') /** remove options from property sub type */
                    .find('option')
                    .remove()
                    .end();
                delete filters.property_sub_type
            }
            delete filters[filterName];

        }
    })



    const handleFilterChange = () => {
        pageNumber = 1;
        filters.page = pageNumber;
        getFilterData();
    }


    //click on pagination page
    $(document).on('click', '.page-item', function() {
        let id = $(this).attr('id');
        if (id == 'page-previous') {
            if (pageNumber > 1) {
                pageNumber--;
                handlePageChnage();
            }
        }
        if (id == 'page-next') {
            if (pageNumber < +totalPages) {
                pageNumber++;
                handlePageChnage();
            }
        }
        if (id == 'page-number') {
            pageNumber = parseInt($(this).data('page-number'));
            handlePageChnage();
        }
    })
    const handlePageChnage = () => {
        filters.page = pageNumber;
        getFilterData();
    }

    const propertyDetailsRoute = "{{ route('viewPropertyDetails', ['property' => '__ID__']) }}";
    const streetviewRoute = "{{ route('streetview', ['id' => '__ID__']) }}"; 

    const getFilterData = () => {
        $('.results').addClass('d-none');
        if ($('.loader_container').hasClass('d-none'))
            $('.loader_container').removeClass('d-none');

        $.ajax({
            type: 'post',
            url: '{{route("getPropertyResults")}}',
            data: {
                _token: '{{csrf_token()}}',
                filters: filters
            },
            success: (results) => {
                $('.loader_container').addClass('d-none');
                if ($('.results').hasClass('d-none'))
                    $('.results').removeClass('d-none');
                    const spinnerOverlay = document.getElementById('spinnerOverlay');
                spinnerOverlay.style.display = 'none';
                $('.property-data').html('');
                let updatedListHTML = '';
                let rowNum = 50 * (pageNumber - 1) + 1;
                if (results.counter > 0) {

                    results.rows.forEach((row, index) => {
                        const mapMarkerHtml = `<span class="location_icon" data-bs-toggle="modal" data-bs-target="#viewMapModal" onclick="locate(${row.old_propert_id})">
                            <i class="lni lni-map-marker text-danger" data-toggle="tooltip" title="View Mapview"></i>
                        </span>`;
                        const dynamicViewMoreRoute = propertyDetailsRoute.replace('__ID__', row.id);
                        const viewMoreHtml = `<a href="${dynamicViewMoreRoute}" class="text-primary view_more_link">View More</a>`;
                        const dynamicStreetviewRoute = streetviewRoute.replace('__ID__', row.old_propert_id);
                        const streetViewHtml = `<a href="${dynamicStreetviewRoute}" target="_blank" data-toggle="tooltip" title="View Streetview">
                            <span class="location_icon">
                                <img src="{{ asset('assets/images/street-view.svg') }}" class="map-marker-icon" />
                            </span>
                        </a>`;
                        const duesHtml = `<a href="javascript:;" class="text-danger show-demand-modal" data-property-id="${row.old_propert_id}">Dues</a>`;
                        
                        /** append row in result list */
                        updatedListHTML += `<div class="parent_table_container"><table class="table report-item">
                               <tr>
                                    <td colspan="4" class="address_data">(${rowNum}) Presently known as: <span class="highlight_value address_address">${row.address ?? 'N A'}</span></td>
                               </tr>
                                <tr>     
                                    <td>Property ID: <span class="highlight_value">${row.unique_propert_id}( ${row.old_propert_id} )</span></td>
                                    <td>Land Size: <span class="highlight_value">${row.area_in_sqm} Sq. Mtr.</span></td>
                                    <td>Land Value: <span class="highlight_value">₹${row.land_value ??'-'}</span></td>
                                    <td>Present Lessee: <span class="highlight_value lessee_address">${row.lesse_name ? row.lesse_name: 'N/A'}</span></td>
                                </tr>
                                <tr>
                                    <td>Lease Tenure: <span class="highlight_value">${row.lease_tenure ? row.lease_tenure +' years' : 'N/A'}</span></td>
                                    <td>RGR: <span class="highlight_value">${row.gr}</span></td>
                                    <td><span class="highlight_value landtypeRehab">${row.land_type}</span> <span class="highlight_value landtypeFreeH mx-2">${row.status}</span> <span class="highlight_value landuseResid">${row.land_use}</span></td>
                                       <td><span class="d-flex align-items-center border-l-w-0 map_view_location"> ${mapMarkerHtml} ${streetViewHtml}  ${viewMoreHtml} 
                                    &nbsp;|&nbsp; 
                                    ${duesHtml} <span></td>
                                </tr>
                        </table></div>`;
                        rowNum++;
                    })
                } else {
                    updatedListHTML += `<div>
					<h3>No matching record found</h3>
					</div>`;
                }
                $('.property-data').html(updatedListHTML);

                /**update pagination links */
                if (results.counter <= 50) {
                    $('.pagination').hide();
                    if (results.counter == 0) {
                        $('.summary').hide();
                    } else {
                        $('.summary').show();
                        $('.resultInfo').html(`showing 1 - ${results.counter} of ${results.counter} records`)
                    }

                } else {
                    $('.summary').show();
                    totalPages = parseInt(results.counter / 50 + (results.counter % 50 > 0 ? 1 : 0));


                    let paginationStartPage = Math.max(1, pageNumber - 3)
                    let paginationEndPage = Math.min(totalPages, pageNumber + 3);
                    let paginationHTML = `<li class="page-item ${pageNumber == 1 ? 'disabled':''}" id="page-previous"><a class="page-link" href="javascript:;" tabindex="-1" aria-disabled="true">Previous</a>
						</li>`;
                    for (let page = paginationStartPage; page <= paginationEndPage; page++) {
                        paginationHTML += `<li class="page-item ${ page == pageNumber ? 'active' : ''}" aria-current="page" id="page-number" data-page-number="${page}"><a class="page-link" href="javascript:;">${page}</a>
							</li>`
                    }

                    paginationHTML += `<li class="page-item ${pageNumber == totalPages ? 'disabled':''}" id="page-next"><a class="page-link" href="javascript:;">Next</a>
						</li>`;
                    $('.pagination').html(paginationHTML).show();
                    $('.resultInfo').show();
                    $('.resultInfo').html(`showing ${50*(pageNumber -1) + 1} - ${50*(pageNumber -1) + results.rows.length} of ${results.counter} records`)
                }

            },
            error: response => {
                $('.loader_container').addClass('d-none');
                if ($('.results').hasClass('d-none'))
                    $('.results').removeClass('d-none');
                if (response.responseJSON && response.responseJSON.message) {
                    showError(response.responseJSON.message)
                }
            }
        });
    }

    function resetFilters() {
        $('.input-reset-icon').each(function() {
            $(this).click();
        })
        handleFilterChange();
    }
    $('.export-btn').click(function() {
        let exportFormat = $(this).data('export-format');
        $('.results').addClass('d-none');
        if ($('.loader_container').hasClass('d-none'))
            $('.loader_container').removeClass('d-none');
        $.ajax({
            type: "post",
            url: '{{route("reportExport")}}',
            data: {
                _token: "{{csrf_token()}}",
                format: exportFormat,
                filters: filters
            },
            /* xhrFields: {
                responseType: 'blob' // Important
            }, */
            success: response => {
                console.log(response);
                $('.loader_container').addClass('d-none');
                if ($('.results').hasClass('d-none'))
                    $('.results').removeClass('d-none');
                if (response.status) {
                    showSuccess(response.status)
                }

                $('.loader_container').addClass('d-none');
                if ($('.results').hasClass('d-none'))
                    $('.results').removeClass('d-none');
                // Create a blob object from the response

                //not downloding file. Download Link will be sent to Email
                /* var blob = new Blob([response], {
                    type: (exportFormat == 'xls' || exportFormat == 'csv') ? "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" : "application/pdf",
                });
                var url = window.URL.createObjectURL(blob);

                // Create a temporary anchor element
                var downloadLink = document.createElement('a');
                downloadLink.href = url;
                downloadLink.download = 'report.' + exportFormat; // Provide a filename here
                document.body.appendChild(downloadLink);
                downloadLink.click();

                // Cleanup
                window.URL.revokeObjectURL(url);
                document.body.removeChild(downloadLink); */
            },
            error: response => {
                console.log(response);
                
                $('.loader_container').addClass('d-none');
                if ($('.results').hasClass('d-none'))
                    $('.results').removeClass('d-none');
                if (response.responseJSON && response.responseJSON.message) {
                    showError(response.responseJSON.message)
                }
            }
        })
    });

    // Onscroll Sticky Filter
    // script.js
    $(document).ready(function() {
        var stickyDiv = $('.sticky-div');
        var stickyOffset = stickyDiv.offset().top;

        $(window).scroll(function() {
            if ($(window).scrollTop() >= stickyOffset) {
                stickyDiv.addClass('sticky');
            } else {
                stickyDiv.removeClass('sticky');
            }
        });
    });

     //added by swati mishra for displaying dues in filter report by Swati Mishra 11-04-2025

     $(document).on('click', '.show-demand-modal', function () {

const propId = $(this).data('property-id');

const modalBody = $('#demandModalBody');

modalBody.html('<p>Loading...</p>'); // reset



const spinnerOverlay = document.getElementById('spinnerOverlay');

spinnerOverlay.style.display = 'flex';



$.ajax({

    url: '{{ route("getDemandDetails") }}',

    method: 'POST',

    data: {

        _token: '{{ csrf_token() }}',

        property_id: propId

    },

    success: (response) => {

        spinnerOverlay.style.display = 'none';

        if (response.status) {

            const d = response.data;

            const html = `

                <table class="table table-bordered table-striped">

                    <tr><th>Demand ID</th><td>${d.demand_id}</td></tr>

                    <tr><th>Demand Date</th><td>${d.demand_date}</td></tr>

                    <tr><th>Amount</th><td>₹${d.amount}</td></tr>

                    <tr><th>Paid Amount</th><td>₹${d.paid}</td></tr>

                    <tr><th>Outstanding Dues</th><td>₹${d.outstanding}</td></tr>

                </table>

            `;

            modalBody.html(html);

        } else {

            modalBody.html('<p>No demand records found.</p>');

        }



        $('#demandModal').modal('show');

    },

    error: () => {

        modalBody.html('<p class="text-danger">Error fetching demand details.</p>');

        $('#demandModal').modal('show');

    }

});

});
</script>
@endsection
