@extends('layouts.app') @section('title', 'Create Demand') @section('content')
<link rel="stylesheet" href="{{ asset('assets/css/rgr.css') }}" />
<style>
  .subhead-input {
    margin: 10px 0 !important;
    padding: 10px 0 !important;
    border-radius: 10px;
  }

  .parent_table_container {
    border-bottom: 1px solid #dcdcdc;
    margin-bottom: 10px;
    padding-bottom: 10px;
  }

  table {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
    border-color: none !important;
    border-spacing: 8px;
    margin-bottom: 0px !important;
  }

  th,
  td {
    text-align: left;
    padding: 10px;
    overflow: hidden;
  }

  /*  td:nth-child(odd) {
    background-color: #f1f1f166;
    vertical-align: middle;
  }

  td:nth-child(even) {
    background-color: #f1f1f166;
    vertical-align: middle;
  } */

  .demand-item-container {
    /* background: #e1eaf2; */
    background-color: #f2f2f2;
    border-radius: 5px;
    margin: 7px 0;
    padding: 10px;
    position: relative;
  }

  .calculation_details {
    font-size: 18px;
    font-weight: 600;
    padding: 6px 12px;
    box-shadow: 0 0 8px inset rgba(153, 153, 153, 0.8);
    border-radius: 5px;
    margin-top: 20px;
  }

  .user-inputs {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }

  .input-block {
    flex: 1 1 30%;
    min-width: 30%;
    max-width: 33%;
  }

  .custom-check .form-check-label {
    margin: 0;
  }

  .hint-text {
    font-size: 12px;
    position: absolute;
    right: 10px;
    top: 10px;
    color: #6c757d;
  }

  .demand-item-container .hint-text::before {
    content: "*";
    color: #fd3550;
    font-size: 14px;
    margin-right: 2px;
  }

  .error {
    display: block
  }

  .error:empty {
    display: none !important
  }

  .calculation-info {
    color: #333;
    line-height: 25px;
  }

  input[type="checkbox"][data-readonly],
  input[type="radio"][data-readonly] {
    pointer-events: none;
    opacity: 0.5;
  }
</style>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
  <div class="breadcrumb-title pe-3">Demand</div>
  <div class="ps-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 p-0">
        <li class="breadcrumb-item">
          <a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Demand</li>
        <li class="breadcrumb-item active" aria-current="page">
          @if (Route::is('createDemandView'))
          Create demand
          @elseif (Route::is('EditDemand'))
          Edit demand
          @endif
        </li>
      </ol>
    </nav>
  </div>
  <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>
<!--end breadcrumb-->
<hr />
@php
$propertyAllreadySelected = isset($demand) || isset($applicationData);
$creatingNewDemand = !isset($demand);
$propertSelectorPath = $propertyAllreadySelected ? null: 'include.parts.property-selector';
@endphp
<div class="card">
  <div class="card-body">
    @if($propertyAllreadySelected)
    <div class="row">
      <div class="col-lg-12">
        <div class="part-title">
          <h5>Property
            @if(isset($demand) || isset($applicationData)) and @endif
            @isset($demand) Demand @endisset @isset($applicationData) Application @endisset Details</h5>
        </div>
        <div class="part-details">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12 col-12">
                <table class="table table-bordered property-table-info">
                  <tbody>
                    <th>Old Property ID:</th>
                    <td>{{ $demand->splited_property_detail->old_property_id ?? $demand->property_master->old_propert_id ?? $applicationData->old_property_id }}</td>

                    <th>New Property ID:</th>
                    <td>{{ $demand->splited_property_detail->child_property_id ?? $demand->property_master->unique_propert_id ?? $applicationData->new_property_id }}</td>

                    <tr>
                      <th>Property Status:</th>
                      <td colspan="3">{{ getServiceNameById($demand->splited_property_detail->property_status ?? $demand->property_master->status ?? $applicationData->property_status ?? $applicationData->propertyMaster->status) }}</td>
                    </tr>

                    <tr>
                      <th>Property Type:</th>
                      <td>{{ getServiceNameById($demand->property_master->property_type ?? $applicationData->propertyMaster->property_type) }}</td>

                      <th>Presently Known As:</th>
                      <td>{{ $demand->property_known_as ?? $applicationData->propertyMaster->plot_or_property_no.'/'. $applicationData->propertyMaster->block_no.'/'. $applicationData->propertyMaster->newColony->name}}</td>
                    </tr>

                    <tr>
                      <th>Lesse's Name:</th>
                      <td colspan="3"> @if(isset($demand))
                        {{ $demand->current_lessee ?? '-' }}
                        @elseif(isset($applicationData))
                            {{ $applicationData->name_as_per_lease_conv_deed ?? $applicationData->propertyMaster->current_lesse_name ?? '-' }}
                        @else
                            -
                        @endif
                      </td>
                    </tr>
                    @isset($demand)
                    <tr>
                      <th>Demand Id:</th>
                      <td>{{ $demand->unique_id ?? 'N/A' }}</td>

                      <th>Amount:</th>
                      <td>₹ {{ customNumFormat($demand->net_total ?? 0) }}</td>
                    </tr>

                    <tr>
                      <th>Balance:</th>
                      <td>₹ {{ customNumFormat($demand->balance_amount ?? 0) }}</td>

                      <th>Financial Year:</th>
                      <td>{{ $demand->current_fy ?? 'N/A' }}</td>
                    </tr>
                    @endif
                    @if(isset($applicationData))
                    <tr>
                      <th>Application No.</th>
                      <td>{{$applicationData->application_no}}</td>
                      <th>Application Type</th>
                      <td>{{$applicationData->service_type->item_name}}</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif
      <div class="row">
        <div class="col-lg-12 mb-2  {{$propertyAllreadySelected ? 'd-none':''}}">
          @if($propertSelectorPath)
          @include($propertSelectorPath)
          @endif
        </div>
      </div>
      <div class="col col-lg-2 pt-1 mb-2 {{$propertyAllreadySelected ? 'd-none':''}}">
        <button type="button" class="btn btn-primary px-4 mt-4" id="submitButton">Search<i class="bx bx-right-arrow-alt ms-2"></i></button>
      </div>

      <div class="d-none" id="detail-card">
        <div class="pb-3">

          <div class=""> <!-- this div add by anil on 21-01-2025-->
            <!-- <table class="table table-bordered table-striped">
                <thead> -->
            <!-- </thead> -->
            <div id="detail-container"></div>
            <!-- </table> -->
          </div>
        </div>
        <button type="button" class="btn btn-primary mb-2" id="btn-demand" data-action="show">Continue</button>

      </div>
      <div class="d-none" id="app-detail-card">
        <div class="pb-3">

          <div class=""> <!-- this div add by anil on 21-01-2025-->
            <!-- <table class="table table-bordered table-striped">
                <thead> -->
            <!-- </thead> -->
            <div id="app-detail-container"></div>
            <!-- </table> -->
          </div>
        </div>
      </div>
      <div class="{{ $propertyAllreadySelected ? '':'d-none' }}" id="input-form-container">
        <form id="demand-input-form" method="post" action="">
          <div id="formOldDemandDetails">
            @if(isset($oldDemands))
            @include('include.parts.old-demand-details')
            @endif
          </div>
          <input type="hidden" id="selectedOldPropertyId" name="oldPropertyId" value="{{$demand->old_property_id ?? $applicationData->old_property_id ?? ''}}" />
          <input type="hidden" name="id" value="{{isset($demand) ? $demand->id : ''}}" />
          <input type="hidden" name="application_no" value="{{$demand->app_no ?? $applicationData->application_no ?? ''}}" />
          @csrf
          <div class="">
            <div class="row">
              <div class="col-lg-12">
                <div class="part-title">
                  <h5>New Demand</h5>
                </div>
                <div class="part-details">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-lg-3"><label>Is new allotment?</label></div>
                      <div class="col-lg-9">
                        <div class="new-allotment-option">
                          <div class="form-check form-check-inline mr-5">
                            <input type="radio" name="new_allotment_radio" class="form-check-input" value="1" {{(isset($newAllotment) && $newAllotment == 1) ? 'checked': ''}} {{(isset($newAllotment))?'disabled':''}}>
                            <label class="form-check-label">Yes</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input type="radio" name="new_allotment_radio" class="form-check-input" value="0" {{(isset($newAllotment) && $newAllotment == 0) ? 'checked':''}} {{(isset($newAllotment))?'disabled':''}}>
                            <label class="form-check-label">No</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col mt-2 mb-2" id="demand-subheads-container">
                      @isset($demand)
                      @php
                      $selectedSubheadCodes = array_keys($slectedSubheads);
                      @endphp
                      @foreach($subheads as $head)

                      <div class="demand-item-container">
                        <div class="col-lg-12 my-1">
                          <div class=" form-check">
                            <input type="checkbox" name="{{$head->item_code}}" class="select-head-check form-check-input" @checked(in_array($head->item_code, $selectedSubheadCodes))>
                            <h6>{{$head->item_name}}</h6>
                            <input type="hidden" name="demand_amount[{{$head->item_code}}]" id="include-demand-amount" value="{{isset($slectedSubheads[$head->item_code]) && isset($slectedSubheads[$head->item_code]['amount']) ? $slectedSubheads[$head->item_code]['amount']:0}}">
                          </div>
                        </div>
                        <div class="col-lg-12 user-inputs" id="user-inputs">

                          @if(in_array($head->item_code,$selectedSubheadCodes))
                          <input type="hidden" name="detail_id[{{$head->item_code}}]" value="{{$slectedSubheads[$head->item_code] ['id'] ?? ''}}">
                          @switch($head->item_code)
                          @case('DEM_AF_P')
                          <div class="input-block">
                            <label class="form-label">Start date</label>
                            <input type="date" class="form-control" name="allotment_fee_date_from" value="{{isset($selectedValues['allotment_fee_date_from']) ? $selectedValues['allotment_fee_date_from']:''}}">
                            <div class="error" id="allotment_fee_date_from_error"></div>
                          </div>
                          <div class="input-block">
                            <label class="form-label">End date</label>
                            <input type="date" class="form-control" name="allotment_fee_date_to" value="{{isset($selectedValues['allotment_fee_date_to']) ? $selectedValues['allotment_fee_date_to']:''}}">
                            <div class="error" id="allotment_fee_date_to_error"></div>
                          </div>
                          <div class="hint-text mb-2">Minimum 15 days of allotment will be charged. Maximum allowed duration will be 50 years.</div>

                          @break

                          @case('DEM_UEI')
                          {{-- @dd($selectedValues) --}}
                          <div class="col-lg-12 mt-2">
                            <div class="form-check form-check-inline custom-check">
                              <input class="form-check-input" type="radio" name="is_transfer_done" value="1" onchange="appendUnearnedIncreaseInput(this,3,true)" @if(isset($selectedValues['is_transfer_done']) && $selectedValues['is_transfer_done']==1) checked data-readonly @endif>
                              <label class="form-check-label">Transfer completed</label>
                            </div>
                            <div class="form-check form-check-inline custom-check">
                              <input class="form-check-input" type="radio" name="is_transfer_done" value="0" onchange="appendUnearnedIncreaseInput(this,2,true)" @if(isset($selectedValues['is_transfer_done']) && $selectedValues['is_transfer_done']==0) checked data-readonly @endif>
                              <label class="form-check-label">Transfer yet to be completed</label>
                            </div>
                          </div>
                          @if(isset($selectedValues['is_transfer_done']) && $selectedValues['is_transfer_done'] == 1)
                          <div class="input-block">
                            <label class="form-label">Consideration value</label>
                            <input type="number" min="0" class="form-control" id="unearned_increase_consideration_value" name="unearned_increase_consideration_value" value="{{$selectedValues['unearned_increase_consideration_value'] ?? ''}}">
                            <div class="error" id="unearned_increase_consideration_value_error"></div>
                          </div>
                          <div class="input-block">
                            <label class="form-label">Transfer Date</label>
                            <input type="date" class="form-control" onblur="getLandValueAtDate('{{ $demand->old_property_id }}', this.value)" name="unearned_increase_transfer_date" value="{{date('Y-m-d',strtotime($selectedValues['unearned_increase_transfer_date'])) ?? ''}}">
                            <div class="error" id="unearned_increase_transfer_date_error"></div>
                          </div>
                          @endif
                          <div class="input-block" id="land_value_block">
                            <label>Land value {{isset($selectedValues['unearned_increase_transfer_date'])?'on '. date('d-m-Y',strtotime($selectedValues['unearned_increase_transfer_date'])) : '' }}</label>
                            <div id="land_value_UEI">
                              <input type="number" min="0" class="form-control" value="{{$selectedValues['unearned_increase_land_value']}}" readOnly id="unearned_increase_land_value" name="unearned_increase_land_value">
                              <div class="error" id="unearned_increase_land_value_error"></div>
                            </div>
                          </div>
                          @break

                          @case('DEM_CONV_CHG')
                          <div class="input-block">
                            <label class="form-label">Land value</label>
                            <input type="number" min="0" class="form-control" value="{{$selectedValues['conversion_land_value'] ?? ''}}" readOnly id="conversion_land_value" name="conversion_land_value">
                            <div class="error" id="conversion_land_value_error"></div>
                          </div>
                          <div class="col-lg-12">
                            <div class="calculation-info"> &diams; <b>Total coversion charges &rarr;</b> ₹{{customNumFormat(round(0.2*((float)$selectedValues['conversion_land_value'])),2)}} [20% of land value]<br>
                              &diams; <b>Applicable remission &rarr;</b> ₹{{customNumFormat(round(0.2*0.4*((float)$selectedValues['conversion_land_value'])),2)}} [40% of converison charges]</div>
                          </div>
                          <div class="col-lg-12">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="conversion_remission" id="conversion_remission" checked="{{isset($selectedValues['conversion_remission']) && $selectedValues['conversion_remission'] == 1}}">
                              <label class="form-check-label">Allow Remission</label>
                            </div>
                          </div>
                          @break

                          @case('DEM_LUC_RC')
                          <div class="col-lg-12 mt-2">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="partial_change" id="partial_change" onchange="toggleBuiltUpAreaInputs(this)" checked="{{isset($selectedValues['partial_change']) && $selectedValues['partial_change'] == 1}}">
                              <label class="form-check-label">Land use change sought under mixed use policy</label>
                            </div>
                          </div>
                          <div class="col-lg-12 mb-2">
                            <div class="calculation-info">Land value @ commercial land rate &rarr; &#8377;{{customNumFormat(
                                round($selectedValues['luc_land_value'] ?? 0))}}</div>
                          </div>
                          <div class="input-block">
                            <label class="form-label">Commecial Land value</label>
                            <input type="number" min="0" class="form-control" value="{{$selectedValues['luc_land_value']??''}}" readOnly id="luc_land_value" name="luc_land_value">
                            <div class="error" id="luc_land_value_error"></div>
                          </div>
                          {{-- @dd(($selectedValues['partial_change']) && $selectedValues['partial_change'] == 1) --}}
                          @if(isset($selectedValues['partial_change']) && $selectedValues['partial_change'] == 1)
                          <div class="input-block builtUpAreaInputs">
                            <label class="form-label">Total built up area</label>
                            <input type="number" min="0" class="form-control" id="luc_TBUA" name="luc_TBUA" value="{{$selectedValues['luc_TBUA'] ?? ''}}">
                            <div class="error" id="luc_TBUA_error"></div>
                          </div>
                          <div class="input-block builtUpAreaInputs">
                            <label class="form-label">Area to be used as commercial</label>
                            <input type="number" min="0" class="form-control" id="luc_BUAC" name="luc_BUAC" value="{{$selectedValues['luc_BUAC'] ?? ''}}">
                            <div class="error" id="luc_BUAC_error"></div>
                          </div>
                          @endif
                          @break

                          @case('DEM_SLET_CHG')
                          <div class="col-lg-12 mt-2">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="penal_subletting" id="penal_subletting" onchange="togglePenalSublettingInputs(this)" checked="{{isset($selectedValues['penal_subletting']) && $selectedValues['penal_subletting'] == 1}}">
                              <label class="form-check-label">Add Penalty</label>
                            </div>
                          </div>
                          <div class="input-block">
                            <label class="form-label">Annual income from subletting</label>
                            <input type="number" min="0" class="form-control" id="annual_subletting_income" name="annual_subletting_income" value="{{$selectedValues['annual_subletting_income'] ?? ''}}">
                            <div class="error" id="annual_subletting_income_error"></div>
                          </div>
                          @if (isset($selectedValues['penal_subletting']) && $selectedValues['penal_subletting'] == 1)
                          <div class="input-block panalSublettingInputs">
                            <label class="form-label">Date of Start of Subletting</label>
                            <input type="date" class="form-control" id="subletting_start_date" name="subletting_start_date" value="{{$selectedValues['subletting_start_date'] ?? '' }}">
                            <div class="error" id="subletting_start_date_error"></div>
                          </div>
                          <div class="input-block panalSublettingInputs">
                            <label class="form-label">Date of Confirmation of Subletting</label>
                            <input type="date" class="form-control" id="subletting_confirmation_date" name="subletting_confirmation_date" value="{{$selectedValues['subletting_confirmation_date'] ?? '' }}">
                            <div class="error" id="subletting_confirmation_date_error"></div>
                          </div>
                          @endif
                          @break

                          @case('DEM_PENAL_STANDARD')
                          <div class="input-block">
                            <label class="form-label">Land value</label>
                            <input type="number" min="0" class="form-control" value="{{$selectedValues['standard_penalty_land_value']}}" readOnly id="standard_penalty_land_value" name="standard_penalty_land_value">
                            <div class="error" id="standard_penalty_land_value_error"></div>
                          </div>
                          <div class="col-lg-12">
                            <div class="calculation-info">Standard penalty is 1% of land value (&#8377;{{customNumFormat(round($selectedValues['standard_penalty_land_value'],2 ))}}) &approx; &#8377;{{customNumFormat(round(0.01*$selectedValues['standard_penalty_land_value'],2))}}</div>
                          </div>
                          <div class="col-lg-12">
                            <div class="input-block">
                              <label class="form-label">Description</label>
                              <textarea class="form-control" name="standard_penalty_description" id="standard_penalty_description" rows="5" placeholder="Add description of penalty (min. 50 characters)">{{$selectedValues['standard_penalty_description'] ?? '' }}</textarea>
                              <div class="error" id="standard_penalty_description_error"></div>
                            </div>
                          </div>
                          @break

                          @case("DEM_MANUAL")
                          <div class="input-block">
                            <label for="" class="form-label">Title</label>
                            <input type="text" name="manual_title" id="manual_title" class="form-control" value="{{isset($selectedValues['manual_title']) ? $selectedValues['manual_title']:''}}">
                            <div class="error" id="manual_title_error"></div>
                          </div>
                          <div class="input-block">
                            <label class="form-label">Amount</label>
                            <input type="number" min="0" name="manual_amount" id="manual_amount" class="form-control" step="0.01" value="{{isset($selectedValues['manual_amount']) ? $selectedValues['manual_amount']:''}}">
                            <div class="error" id="manual_amount_error"></div>
                          </div>
                          <div class="input-block">
                            <label for="" class="form-label">Date From</label>
                            <input type="date" name="manual_date_from" id="manual_date_from" class="form-control" value="{{isset($selectedValues['manual_date_from']) ? $selectedValues['manual_date_from']:''}}">
                            <div class="error" id="manual_date_from_error"></div>
                          </div>
                          <div class="input-block">
                            <label for="" class="form-label">Date To</label>
                            <input type="date" name="manual_date_to" id="manual_date_to" class="form-control" value="{{isset($selectedValues['manual_date_to']) ? $selectedValues['manual_date_to']:''}}">
                            <div class="error" id="manual_date_to_error"></div>
                          </div>
                          <div class="col-lg-12 mt-2">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="manual_description" id="manual_description" rows="5" placeholder="Add description of demand (min. 50 characters)">{{isset($selectedValues['manual_description']) ? $selectedValues['manual_description']:''}}</textarea>
                            <div class="error" id="manual_description_error"></div>
                          </div>
                          @break

                          @case('DEM_OTHER')
                          <div class="input-block">
                            <label class="form-label">Demand Amount</label>
                            <input type="number" min="0" class="form-control" id="others_deamnd_amount" step="0.01" value="{{$slectedSubheads['DEM_OTHER']['amount']}}">
                            <div class="error" id="others_deamnd_amount_error"></div>
                          </div>
                          <div class="input-block">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="others_description" id="others_description" rows="5" placeholder="Add description of penalty (min. 50 characters)">{{$selectedValues['others_description'] ??''}}</textarea>
                            <div class="error" id="others_description_error"></div>
                          </div>
                          @break
                          @default

                          @endswitch

                          @endif
                        </div>
                        @if(in_array($head->item_code,$selectedSubheadCodes))
                        <div class="col-lg-12 my-3" id="calculation-div">
                          <button type="button" class="btn btn-sm btn-primary btn-calculate" style="display: none">{{($head->item_code == "DEM_PENAL_STANDARD" || $head->item_code == "DEM_OTHER")?'Add':'Calculate'}}</button>
                        </div>
                        @endif
                      </div>
                      @endforeach
                      @endisset
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row my-3">
            <div class="col-lg-12">
              <div class="bill-raise">
                <h6 class="demand-total">Demand Total Amount:</h6>
                <h6 class="demand-amount">₹<span id="demandTotalAmount" unformatted-amount="{{isset($demand) ? $demand->net_total : 0}}">{{isset($demand) ? customNumFormat($demand->net_total) : 0}}</span></h6>
              </div>
            </div>
          </div>
          <div class="row mb-2">

            <div class="col-lg-4">
              @if(!isset($openInReadOnlyMode))
              <button type="button" class="btn btn-primary float-right" id="btn-submit">Submit</button>
              @endif
            </div>
            <div class="col-lg-8 d-flex justify-content-end">
              @if(isset($canApprove) && $canApprove)
              <a href="{{$demand->status == getServiceType('DEM_PENDING') ? '': route('ApproveDemand',$demand->id)}}"><button type="button" class="btn btn-success mr-2" {{$demand->status == getServiceType('DEM_PENDING') ? 'disabled': ''}}>{{$demand->status == getServiceType('DEM_PENDING') ? 'Approved': 'Approve'}}</button></a>
              @endif
              @if(isset($canEdit) && $canEdit)
              <a href="{{route('EditDemand',$demand->id)}}"><button type="button" class="btn btn-warning">Edit</button></a>
              @endif
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  @include('include.alerts.ajax-alert')
  <div class="modal fade" id="confirmNewDemandModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="submitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"> <!-- modal-dialog-centered class added by anil on 21-01-2025 -->
      <div class="modal-content text-center">
        <div class="modal-header border-0 h-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- <img
              src="{{ asset('assets/images/update.svg') }}"
          alt="success"
          class="success_icon" /> --}}
          <!-- <h5 class="modal-title mb-2" id="ModalSuccessLabel">Are you sure?</h5> -->
          <p id="confirmationMessage">
            Unpaid demand found against the selected property. Do you want to
            continue?
          </p>
          <div class="row mt-2">
            <div class="col-lg-12" id="oldDemandDetails"></div>
          </div>
        </div>
        <div class="modal-footer border-0 justify-content-center">
          <button type="button" class="btn btn-secondary btn-width" data-bs-dismiss="modal" id="confirmation-no">No</button>
          <button type="button" name="status" value="submit" class="btn btn-primary btn-width" id="confirmation-yes">Yes</button> <!-- change the button color yellow to theme green by anil on 21-01-2025 -->
        </div>
      </div>
    </div>
  </div>
  @endsection
  @section('footerScript')
  <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
  <script>
    let propertyId;
    let propertyTypes;
    let propertyDetails;
    let demandDetailsHtml;
    let isPropertyTypeCommercial = false; //to skip appending land use change demand for commercial properties - added bu Ntiin on 24 March 2025
    let prevPendingAmount = 0;
    let redirectToEdit = false;
    let oldDemandId = [];
    let editDemandId = null;
    let landValue = null;
    let landArea = null;

    const standardConversionRemission = (40 / 100);


    $(document).ready(function() {
      let openInReadOnlyMode = <?= isset($openInReadOnlyMode) ? 'true' : 'false' ?>;
      let creatingNewDemand = <?= $creatingNewDemand ? 'true' : 'false' ?>;
      if (!creatingNewDemand) {
        landValue = parseFloat("<?= $landValue ?? 0 ?>");
        landArea = parseFloat("<?= $landArea ?? 0 ?>");
      }
      let calculateTotal = <?= isset($demand) ? 'true' : 'false' ?>;
      if (openInReadOnlyMode) {
        $('#demand-input-form').find('input, textarea').attr('readonly', true);
        $('#demand-input-form').find('select').attr('disabled', true);
        $('#demand-input-form').find('input[type="checkbox"]').prop('disabled', true);
      }
      if (creatingNewDemand) {
        getSelctedPropertyOldDemand();
      }
      toggleRemoveButton();

      //code added by nitin to automaticlly show result
      $('.btn-calculate').each(function() {
        $(this).click();
      })
    });

    $("#submitButton").click(function() {
      propertyId = !isNaN($("#oldPropertyId").val()) && $("#oldPropertyId").val().length == 5 ?
        $("#oldPropertyId").val() :
        $("#property").length > 0 && $("#property").val() != "" ?
        $("#property").val() :
        $("#plot").length > 0 && $("#plot").val() != "" ? $("#plot").val() : "";
      $('#detail-container').empty();
      $('#demand-subheads-container').empty();
      $('#input-form-container').addClass('d-none');
      $('input[name="new_allotment_radio"]').prop('checked', false);
      getPropertyBasicDetail(propertyId);
    });

    /** get detail of property when property is selected */
    function getPropertyBasicDetail(propId) {
      landValue = null;
      landArea = null;
      $.ajax({
        type: "post",
        url: "{{route('propertyCommonBasicdetail')}}",
        data: {
          _token: "{{csrf_token()}}",
          property_id: propId,
        },
        success: function(response) {
          if (response.status == "success") {
            if (!Array.isArray(response.data)) {
              landValue = response.data.plot_value ?? response.data.property_lease_detail.plot_value ?? null;
            }
            landArea = response.data.landSize;

            displayPropertyDetails(response.data);
          } else {
            showError(response.message);
          }
        },
      });
    }
    /** display details of property */
    function displayPropertyDetails(data) {
      $("#detail-container").empty();
      if (Array.isArray(data)) {
        $("#detail-container").html(`<tr>
                      <td colspan="5"><h6>Given property has ${data.length} propert${
              data.length > 1 ? "ies" : "y"
            }</h6></td>
                  </tr>`);
        data.forEach(function(row, i) {
          appendPropertyDetail(row, true, i + 1);
        });
        $("#detail-container").append(`<tr>
                <td colspan="5"><h5>Pease enter property id of splited property to continue</h5></td>
            </tr>`);
        $("#btn-rgr").prop("disabled", true);
      } else {
        appendPropertyDetail(data);
        $("#property_id").val(data.id);
        $("#splited").val(data.is_joint_property === undefined ? 1 : 0);
      }
      $("#selectedOldPropertyId").val(
        data.old_property_id ?? data.old_propert_id
      );
      $("#detail-card").removeClass("d-none");
    }

    function appendPropertyDetail(row, isMultiple = false, rowNum = null) {
      if (isMultiple && rowNum) {
        $("#detail-container").append(`<tr>
                <td>${rowNum}</td><td colspan="4"></td>
            </tr>`);
      }
      // removed <td><b>Land Value : </b> &nbsp;-</td>
      let transferHTML = "";
      if (row.trasferDetails && row.trasferDetails.length > 0) {
        transferHTML = `<div class= "transfer-details" style="display: inline; position:absolute">
            <span class="qmark">&#8505;</span>
            <ul class="transfer-list container">
                <li class="transfer-list-item row row-lg-4">
                    <div class="transfer-list-cell col">#</div>
                    <div class="transfer-list-cell col">Transfer Date</div>
                    <div class="transfer-list-cell col">Process </div>
                    <div class="transfer-list-cell col">Lessee Name</div>
                    </li>
            `;
        row.trasferDetails.forEach((data, i) => {
          transferHTML += `<li class="transfer-list-item row row-lg-4">
                    <div class="transfer-list-cell col">${i + 1}</div>
                    <div class="transfer-list-cell col">${data.transferDate ? data.transferDate.split('-').reverse().join('-'):'N/A'}</div>
                    <div class="transfer-list-cell col">${data.process_of_transfer}</div>
                    <div class="transfer-list-cell col">${data.lesse_name}</div>
                    </li>`;
        });
        transferHTML +
          `</ul>
            </div>`;
      }

      landValue = row.plot_value ?? row.property_lease_detail.plot_value ?? 'N/A';
      isPropertyTypeCommercial = row.property_type == 48;
      let detailHTML = `
        <div class="part-title">
                        <h5>Property Basic Details</h5>
                      </div>
        <div class="part-details">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-lg-12 col-12">
                    <table class="table table-bordered property-table-info">
                      <tbody>
                        <tr>
                          <th>Old Property ID:</th>
                          <td colspan="">${row.old_propert_id}</td>
                          <th>New Property ID:</th>
                          <td colspan="">${row.unique_propert_id}</td>
                          <th>Colony: </th>
                          <td>${row.colony}</td>
                        </tr>
                        <tr>
                          <th>Land Size:</th>
                          <td colspan="2">${ customNumFormat(Math.round(row.landSize * 100) / 100)}Sq. Mtr.</td>
                          <th>Land Value:</th>
                          <td colspan="2">₹${customNumFormat(Math.round(landValue*100)/100)}</td>
                        </tr>

                        <tr>
                          <th>Property Type:</th>
                          <td>${row.proprtyTypeName}</td>
                          <th>Property Sub-type:</th>
                          <td>${row.proprtySubtypeName}</td>
                          <th>Land Type:</th>
                          <td>${row.landTypeName}</td>
                        </tr>
                        <tr>
                          <th>Present Lessee:</th>
                          <td colspan="2">${row.lesseName ? row.lesseName.replaceAll(',', ', ') : "N/A"} ${transferHTML}</td>
                            <th>Property Status:</th>
                            <td colspan="2">${row.statusName}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>`
      let knownAs = row.presently_known_as ?? row.property_lease_detail.presently_known_as ?? ''
      if (knownAs != "") {
        $('#known-as').html(knownAs);
        $('#knownAsDiv').show();
      }
      /* let detailHTML = `<div class="parent_table_container">
      <table class="table report-item">         
                                  <tr>     
                                      <td>Property ID: <span class="highlight_value">${row.unique_propert_id}( ${row.old_propert_id} )</span></td>
                                      <td>Land Size: <span class="highlight_value">${ customNumFormat(Math.round(row.landSize * 100) / 100)} Sq. Mtr.</span></td>
                                      <td>Land Value: <span class="highlight_value">₹${customNumFormat(Math.round(landValue*100)/100)}</span></td>
                                  </tr>
                                  <tr>
                                      <td>Property Type: <span class="highlight_value">${row.proprtyTypeName}</span></td>
                                      <td>Property Subtype: <span class="highlight_value">${row.proprtySubtypeName}</span></td>
                                      <td>Land Type: <span class="highlight_value">${row.landTypeName}</span></td>
                                  </tr>
                                  <tr>
                                    <td colspan="">Present Lessee: <span class="highlight_value lessee_address mr-2">${row.lesseName ? row.lesseName.replaceAll(',', ', ') : "N/A"}</span> ${transferHTML}</td>
                                      <td>Property Status: <span class="highlight_value">${row.statusName}</span></td>
                                  </tr>
                          </table>
                        </div>`; */
      $("#detail-container").append(detailHTML);

      /*  $("#detail-container").append(`
             <tr>
               <td><b>Property ID : </b> &nbsp;${data.unique_propert_id} (${data.old_propert_id})</td>
               <td><b>Land Type : </b> &nbsp;${data.landTypeName}</td>
               <td><b>Land Use Type : </b> &nbsp;${data.proprtyTypeName}</td>
               <td><b>Land Use Subtype : </b> &nbsp;${data.proprtySubtypeName}</td>
               <td><b>Land Size : </b> &nbsp;${ Math.round(data.landSize * 100) / 100} Sq. Mtr.</td>
             </tr>
             <tr>
                 <td><b>Status of RGR : </b> &nbsp;<span class="rgrStatus">${data.rgr == 1 ? "Yes" : "No"}</span></td>
                 <td><b>Lessee/Owner Name : </b> &nbsp;${data.lesseName ? data.lesseName.replaceAll(',', ', ') : "N/A"} ${ data.trasferDetails && data.trasferDetails.length > 0 ? transferHTML : ""}</td>
                 <td><b>Lease Type : </b> &nbsp;${data.leaseTypeName ? data.leaseTypeName : "N/A"}</td>
                 <td><b>Owner&apos;s E-mail : </b> &nbsp;${data.email ? data.email : "N/A"}</td>
                 <td><b>Owner&apos;s Phone Number: </b> &nbsp;${data.phone_no ? data.phone_no : "N/A"}</td>
             </tr>
             <tr>
               <td><b>Date of Allotment : </b> &nbsp;${data.leaseDate? data.leaseDate.split("-").reverse().join("-"):"N/A"}</td>
               <td><b>Lease Tenure : </b> &nbsp;${data.leaseTenure? data.leaseTenure + " years": "N/A"}</td>
               <td colspan="4"><b>Address : </b> &nbsp;${data.address ?? "N A"} </td>
             </tr>
           `); */
    }

    /** function checks and return unpaid demand for property */
    $("#btn-demand").click(getSelctedPropertyOldDemand);

    // $(document).ready(getSelctedPropertyoldDemand);

    function getSelctedPropertyOldDemand() {
      oldDemandId = [];
      var selectedOldPropertyId = $("#selectedOldPropertyId").val();
      if (selectedOldPropertyId && selectedOldPropertyId != "") {
        $.ajax({
          type: "get",
          url: "{{url('/demand/getExistingPropertyDemand')}}" + "/" + selectedOldPropertyId,
          success: function(response) {
            if (response.status) {
              /** Active application details */
              if (response.data.applicationData && response.data.applicationData.length > 0) {
                let applicationHtml = `
                <div class="part-title">
                  <h5>Property active application Details</h5>
                </div>
                <div class="part-details">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-lg-12 col-12">
                        <table class="table table-bordered property-table-info">
                          <thead>
                            <tr>
                              <th>Application No.</th>
                              <th>Applied for </th>
                              <th>Status</th>
                            </tr>
                          </thead>
                        <tbody>`;
                response.data.applicationData.forEach(row => {
                  applicationHtml += `<tr>
                    <td>${row.application_no}</td>
                    <td>${row.appliedFor}</td>
                    <td>${row.statusName}</td>
                  </tr>`
                })
                applicationHtml += `
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                `
                $("#app-detail-container").append(applicationHtml);
                $('#app-detail-card').removeClass('d-none')
              }

              /** pending demand details */
              if (response.data && (response.data.demand || (response.data.dues && response.data.dues > 0))) {
                if (response.data.demand) {
                  var oldDemand = response.data.demand;
                  var confirmationMessage = oldDemand.status_code == 'DEM_DRAFT' ? "There is already a demand with status DRAFT against the selected property. If you continue then new data will be added to the previously saved demand." : "There is already a unpaid demand against this property. Do you want to create a new demand? All unpaid subheads will be carrieed forward to new demand."
                  $('#confirmationMessage').html(confirmationMessage);
                  prevPendingAmount += oldDemand.balance_amount;
                  redirectToEdit = (oldDemand.status_code && oldDemand.status_code == 'DEM_DRAFT')
                  editDemandId = oldDemand.id;
                  $("#demandTotalAmount").text(customNumFormat(prevPendingAmount));
                  var demandDetails = response.data.demandDetails;
                  demandDetailsHtml = `<div class="row mt-2"><div class="col-lg-12">
                            <h5>Previous Demand</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Unique Demand Id</th>
                                    <th>Financial Year</th>
                                    <th>Net Total</th>
                                    <th>Balance</th>
                                </tr>
                                <tr>
                                    <th>${oldDemand.unique_id}</th>
                                    <th>${oldDemand.current_fy}</th>
                                    <th>₹ ${customNumFormat(oldDemand.net_total)}</th>
                                    <th>₹ ${customNumFormat(oldDemand.balance_amount)}</th>
                                </tr>
                            </table>`;

                  var pendingSubheads = demandDetails.filter(
                    (row) => parseFloat(row.balance_amount) > 0
                  );
                  if (pendingSubheads && pendingSubheads.length > 0) {
                    demandDetailsHtml += ` <br>
                                <table class="table table-bordered mt-2">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Subhead Name</th>
                                        <th>Duration</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                    </tr>`;
                    pendingSubheads.forEach((row, index) => {
                      demandDetailsHtml += `<tr>
                                                            <td>${index + 1}</td>
                                                            <td>${row.subhead_name}</td>
                                                            <td>${row.duration_from ?? ''} - ${row.duration_to ?? ''}</td>
                                                            <td>₹ ${customNumFormat(row.net_total)}</td>
                                                            <td>₹ ${customNumFormat(row.balance_amount)}</td>
                                                        </tr>`;
                    });
                    demandDetailsHtml += `</table> </div></div>`;
                  }
                } else if (response.data.dues && response.data.dues > 0) {

                  // prevPendingAmount += response.data.dues; //not required after last update on 03Mar2025
                  demandDetailsHtml = `<div class="row mt-2"><div class="col-lg-12">
                            <h5>Previous Dues</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Property Id</th>
                                    <th>Demand Id</th>
                                    <th>Demand Date</th>
                                    <th>Demand amount</th>
                                    <th>Paid amount</th>
                                    <th>Outstanding</th>
                                </tr>`;
                  response.data.previousDemands.forEach(demand => {
                    oldDemandId.push(demand.demand_id)
                    let demandDate = demand.demand_date.substring(0, demand.demand_date.indexOf("T")).split('-').reverse().join('-')
                    demandDetailsHtml += `<tr>
                                    <th>${demand.property_id}</th>
                                    <th>${demand.demand_id}</th>
                                    <th>${demandDate}</th>
                                    <th>₹ ${customNumFormat(demand.amount)}</th>
                                    <th>₹ ${customNumFormat(demand.paid_amount)}</th>
                                    <th>₹ ${customNumFormat(demand.outstanding)}</th>
                                </tr>`;
                  });

                  demandDetailsHtml += `</table></div></div>`;
                }

                $("#oldDemandDetails").html(demandDetailsHtml);
                $("#confirmNewDemandModal").modal("show");

              } else {
                $("#input-form-container").removeClass("d-none");
              }
            } else {
              showError(response.details);
            }
          }
        });
      }
    }

    //when confirm yes
    $("#confirmation-yes").click(function() {
      if (redirectToEdit) {
        let redirectMessage = `<h6>Redirecting to edit page</h6>`;
        $('#oldDemandDetails').after(redirectMessage);
        setTimeout(() => {
          window.location.href = "{{url('/demand/edit')}}" + '/' + editDemandId;
        }, 1000);
      } else if (oldDemandId.length > 0) {
        let ids = oldDemandId.join(',');
        $("#formOldDemandDetails").load("{{url('/demand/old-demand-data')}}" + '/' + ids, function() {
          calculateTotalAmount();
        });

        $("#confirmNewDemandModal").modal("hide");
        $("#input-form-container").removeClass("d-none");
      } else {
        $("#confirmNewDemandModal").modal("hide");
        $("#input-form-container").removeClass("d-none");
        $("#formOldDemandDetails").html(demandDetailsHtml);
      }
    });
    //when confirm No
    $("#confirmation-no").click(function() {
      $("#confirmNewDemandModal").modal("hide");
      $("#input-form-container").addClass("d-none");
      $("#formOldDemandDetails").html('');
    });

    /** Function to enable/disable remove buttons */
    function toggleRemoveButton() {
      if ($(".subhead-input").length === 1) {
        $(".btn-remove-subhead").prop("disabled", true);
      } else {
        $(".btn-remove-subhead").prop("disabled", false);
      }
    }

    /** calculate total demand amount */
    /* 
        $("body").on("change", 'input[name="amount[]"]', function() {
          // Use event delegation to handle dynamic elements
          calculateTotalAmount();
        }); */

    function calculateTotalAmount() {

      var sum = prevPendingAmount;

      // 1. Add all input values
      $('input[id^="include-demand-amount"]').each(function(i, input) {
        const value = parseFloat(input.value) || 0;
        console.log('input', i, value);
        sum += value;
      });

      // 2. Add all checked checkbox data-subhead-amount
      $('.check-include-in-demand:checked').each(function(i, checkbox) {
        const dataAmount = parseFloat($(checkbox).data('subheadAmount')) || 0;
        console.log('checkbox', i, dataAmount);
        sum += dataAmount;
      });

      // 3. Update total
      $("#demandTotalAmount").text(customNumFormat((Math.round(sum * 100) / 100).toFixed(2)))
      // prevPendingAmount = sum;
      $("#demandTotalAmount").text(customNumFormat((Math.round(sum * 100) / 100).toFixed(2)));
    }

    /* Submit the form */

    $("#btn-submit").click(function() {
      var formData = $("#demand-input-form").serialize();
      var isValid = true;
      var errorMessage = '';
      var today = new Date().toISOString().split("T")[0];
      /*  $('#demand-input-form span.text-danger').not('label span.text-danger').remove();
      $("#demand-input-form").find("[required]").each(function() {
        if ($(this).val() === "" || $(this).val() === null) {
          isValid = false;
          var fieldName = $(this).attr('name');

          var validateLabel = fieldName.substring(0, fieldName.indexOf('[') != -1 ? fieldName.indexOf('[') : fieldName.length).split('_').map(word => word.charAt(0).toUpperCase() + word.substring(1)).join(' ');
          errorMessage = validateLabel + " is required.\n";
          $(this).parent().append('<span class="text-danger">' + errorMessage + '</span>');
        }
      });

      $("input[name^='duration_from']").each(function() {
        var fromField = $(this);
        var toField = fromField.closest('.subhead-input').find("input[name='" + fromField.attr("name").replace("from", "to") + "']");
        var durationFrom = fromField.val();
        var durationTo = toField.val();
        if (durationFrom) {
          if (durationFrom > today) {
            isValid = false;
            fromField.parent().append('<span class="text-danger">From date cannot be a future date.</span>');
          }
        }

        if (durationFrom && durationTo) {
          if (durationFrom > durationTo) {
            isValid = false;
            toField.parent().append('<span class="text-danger">To date should be greater than From date.</span>');
          }
        }
      });
 */
      // If validation fails
      if (!isValid) {
        return false; // Prevent form submission
      }
      $.ajax({
        type: "post",
        url: "{{route('storeDemand')}}",
        data: formData,
        success: function(response) {
          if (response.status) {
            showSuccess(response.message, "{{route('demandList')}}");
          } else {
            showError(response.details);
          }
        },
      });
    });

    /* function includeAllOldDemandHeads() {
      $(document).find('.check-include-in-demand').prop('checked', true).trigger('change');
    } */
    /** include previous demand subheds in new demand */
    /* $(document).on('change', '.check-include-in-demand', function() {
      debugger;
      // console.log($(this).data('demandId'), $(this).data('subheadKey'), $(this).data('subheadAmount'))
      let subheadAmount = $(this).data('subheadAmount')
      if ($(this).is(':checked')) {
        prevPendingAmount += subheadAmount;
      } else {
        prevPendingAmount -= subheadAmount;
      }
      console.log(prevPendingAmount)
      // calculateTotalAmount();// commented because in case  new demand head data is added twice if done after adding new demand  heads
      $('#demandTotalAmount').text(customeNumFormat(prevPendingAmount)); // only updating demand amount // not calculating the new demand head amount here

    }) */



    /* load demand subheads */
    $('input[name="new_allotment_radio"]').change(function() {
      let selectedVal = $(this).val();
      if (selectedVal != '')

        $.ajax({
          type: "get",
          url: "{{url('/demand/get-demand-heads')}}" + "/" + selectedVal,
          success: function(response) {
            $('#demand-subheads-container').empty();
            response.forEach(function(item) {

              if (!(isPropertyTypeCommercial && item.item_code == "DEM_LUC_RC")) { //for commercial properites skip ;and use change residential to commercial // Nitin -24 March 2023
                let demandHeadHTML = `<div class="demand-item-container">
                <div class="col-lg-12 my-1">
                  <div class=" form-check">
                    <input type="checkbox" name="${item.item_code}" class="select-head-check form-check-input"> <h6>${item.item_name}</h6>
                    <input type="hidden" name="demand_amount[${item.item_code}]" id="include-demand-amount">
                  </div>
                </div>
                <div class="col-lg-12 user-inputs" id="user-inputs"></div>
              </div>`
                $('#demand-subheads-container').append(demandHeadHTML);
              }

            })
          }
        })
    })

    /** when user select a subhead to be included in demand */
    $(document).on('change', '.select-head-check', function() {
      if ($(this).is(":checked")) {
        let container = $(this).closest('.demand-item-container');
        appendUserInputs($(this))
        let demandCode = $(this).attr('name');
        if (container.find('.btn-calculate').length == 0) {
          container.append(`<div class="col-lg-12 my-3" id="calculation-div"><button type="button" class="btn btn-sm btn-primary btn-calculate">${(demandCode == "DEM_PENAL_STANDARD" || demandCode == "DEM_OTHER" || demandCode == "DEM_MANUAL")?'Add':'Calculate'}</button></div>`)
        }
      } else {
        $(this).closest('.demand-item-container').find('#user-inputs').empty();
        $(this).closest('.demand-item-container').find('#calculation-div').remove();
        $(this).closest('.demand-item-container').find('.calculation_details').remove();
        // clear subhead amount from input
        $(this).closest('.demand-item-container').find('#include-demand-amount').val('');
        calculateTotalAmount();
      }
    })

    function appendUserInputs(checkbox) {
      let selectedSubhead = checkbox.attr('name')
      let targetElement = checkbox.closest('.demand-item-container').find('#user-inputs')
      switch (selectedSubhead) {
        case "DEM_AF_P":
          appendAllotmentFeeInputs(targetElement);
          break;
        case "DEM_LF_GR":
          appendGroundRentInput(targetElement);
          break;
        case "DEM_UEI":
          appendUnearnedIncreaseInput(targetElement, 1);
          break;
        case "DEM_CONV_CHG":
          appendConversionInput(targetElement);
          break;
        case "DEM_LUC_RC":
          appendLUCInput(targetElement);
          break;
        case "DEM_SLET_CHG":
          appendSublettingInput(targetElement);
          break;
        case "DEM_PENAL_STANDARD":
          appendStandatdPenaltyInput(targetElement);
          break;
        case "DEM_MANUAL":
          appendManualInput(targetElement);
          break;
        default:
          appendOthersInput(targetElement);
          break;
      }
    }

    $(document).on('focusout', '.demand-item-container #user-inputs :input', function() {
      const container = $(this).closest('.demand-item-container');
      container.find('.btn-calculate').show();
      container.find('.calculation_details').empty().hide();
    });




    function appendAllotmentFeeInputs(targetElement) {
      let html = `
        <div class="input-block">
            <label class="form-label">Start date</label>
            <input type="date" class="form-control" name="allotment_fee_date_from">
            <div class="error" id="allotment_fee_date_from_error"></div>
        </div>
        <div class="input-block">
            <label class="form-label">End date</label>
            <input type="date" class="form-control" name="allotment_fee_date_to">
            <div class="error" id="allotment_fee_date_to_error"></div>
        </div>
        <div class="hint-text mb-2">Minimum 15 days of allotment will be charged. Maximum allowed duration will be 50 years.</div>
        `;
      targetElement.append(html);
    }

    function appendGroundRentInput(targetElement) {
      //yet to come
    }

    function appendUnearnedIncreaseInput(targetElement, inputType) {
      targetElement = $(targetElement); //ensure targetElement is jquery object
      if (targetElement.attr('type') == 'radio') {
        targetElement = targetElement.closest('#user-inputs')
      }
      if (inputType == 1) // input for transfer is already done
      {
        let html = `<div class="col-lg-12 mt-2">
        <div class="form-check form-check-inline custom-check">
            <input class="form-check-input" type="radio" name="is_transfer_done" value="1" onchange="appendUnearnedIncreaseInput(this,3,true)">
            <label class="form-check-label">Transfer completed</label>
        </div>
        <div class="form-check form-check-inline custom-check">
            <input class="form-check-input" type="radio" name="is_transfer_done" value="0" onchange="appendUnearnedIncreaseInput(this,2,true)">
            <label class="form-check-label">Transfer yet to be completed</label>
        </div>
    </div>`;
        targetElement.append(html);
      }
      if (inputType == 2) {
        targetElement.find('.input-block').each(function() {
          $(this).remove();
        });
        let html = `
        <div class="input-block">
            <label class="form-label">Land value</label>
            <input type="number" min="0" class="form-control" value="${landValue}" readOnly id="unearned_increase_land_value" name="unearned_increase_land_value">
            <div class="error" id="unearned_increase_land_value_error"></div>
        </div>
        `;
        targetElement.append(html);
      }
      if (inputType == 3) {
        targetElement.find('.input-block').each(function() {
          $(this).remove();
        });
        let html = `
        <div class="input-block">
            <label class="form-label">Consideration value</label>
            <input type="number" min="0" class="form-control" id="unearned_increase_consideration_value" name="unearned_increase_consideration_value">
            <div class="error" id="unearned_increase_consideration_value_error"></div>
        </div>
        <div class="input-block">
            <label class="form-label">Transfer Date</label>
            <input type="date" class="form-control" onblur="getLandValueAtDate(${propertyId}, this.value)" name="unearned_increase_transfer_date">
            <div class="error" id="unearned_increase_transfer_date_error"></div>
        </div>
        `;
        targetElement.append(html);
      }
      /* if (inputType == 4) {
        let html = `
          
          `;
        targetElement.append(html);
      } */
    }

    function appendConversionInput(targetElement) {
      let html = `<div class="input-block">
            <label class="form-label">Land value</label>
            <input type="number" min="0" class="form-control" value="${landValue}" readOnly id="conversion_land_value" name="conversion_land_value">
            <div class="error" id="conversion_land_value_error"></div>
        </div>
        <div class="col-lg-12">
        <div class="calculation-info"> &diams; <b>Total coversion charges &rarr;</b> ₹${customNumFormat((Math.round(0.2*landValue*100)/100).toFixed(2))} [20% of land value]<br>
        &diams; <b>Applicable remission &rarr;</b> ₹${customNumFormat((Math.round(0.2*0.4*landValue*100)/100).toFixed(2))} [40% of converison charges]</div>
        </div>
        <div class="col-lg-12">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="conversion_remission" id="conversion_remission">
            <label class="form-check-label">Allow Remission</label>
        </div>
    </div>
        `;
      targetElement.append(html);
    }

    function appendLUCInput(targetElement) {
      let commercialLandValue = 0
      // get commercial land rate of property
      let propertyId = $("#selectedOldPropertyId").val()
      $.ajax({
        type: "GET",
        url: "{{url('/land-use-change/commercial-land-value')}}" + '/' + propertyId,
        success: function(response) {
          if (response.status == 'error') {
            return showError(response.details);
          }
          let landRate = parseFloat(response.land_rate);
          commercialLandValue = landRate * landArea;
          let colony = response.colonyName;

          let html = `<div class="col-lg-12 mt-2">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="partial_change" id="partial_change" onchange="toggleBuiltUpAreaInputs(this)">
            <label class="form-check-label">Land use change sought under mixed use policy</label>
        </div>
      </div>
      <div class="col-lg-12 mb-2">
        <div class="calculation-info">Land value @ commercial land rate &rarr; &#8377;${customNumFormat((Math.round(commercialLandValue * 100)/100).toFixed(2))}[&#8377; ${customNumFormat((Math.round(landRate *100)/100).toFixed(2))}/Sqm. (land rate for ${colony}) X ${customNumFormat((Math.round(landArea *100)/100).toFixed(2))} sqm (land area of the property)]</div>
        
      </div>
      <div class="input-block">
            <label class="form-label">Commecial Land value</label>
            <input type="number" min="0" class="form-control" value="${commercialLandValue}" readOnly id="luc_land_value" name="luc_land_value">
            <div class="error" id="luc_land_value_error"></div>
        </div>`
          targetElement.append(html);
        }
      })
    }

    function appendSublettingInput(targetElement) {
      let html = `<div class="col-lg-12 mt-2">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="penal_subletting" id="penal_subletting" onchange="togglePenalSublettingInputs(this)">
            <label class="form-check-label">Add Penalty</label>
        </div>
      </div>
      <div class="input-block">
          <label class="form-label">Annual income from subletting</label>
          <input type="number" min="0" class="form-control" id="annual_subletting_income" name="annual_subletting_income">
          <div class="error" id="annual_subletting_income_error"></div>
      </div>`
      targetElement.append(html);
    }

    function appendStandatdPenaltyInput(targetElement) {
      let html = `<div class="input-block">
            <label class="form-label">Land value</label>
            <input type="number" min="0" class="form-control" value="${landValue}" readOnly id="standard_penalty_land_value" name="standard_penalty_land_value">
            <div class="error" id="standard_penalty_land_value_error"></div>
        </div>
        <div class="col-lg-12">
        <div class="calculation-info">Standard penalty is 1% of land value (&#8377;${customNumFormat((Math.round(landValue *100)/100).toFixed(2))}) &approx; &#8377;${customNumFormat((Math.round(0.01*landValue *100)/100).toFixed(2))}</div>
        </div>
        <div class="col-lg-12">
        <div class="input-block">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="standard_penalty_description" id="standard_penalty_description" rows="5" placeholder="Add description of penalty (min. 50 characters)"></textarea>
            <div class="error" id="standard_penalty_description_error"></div>
        </div>
    </div>
        `;
      targetElement.append(html);
    }

    function appendManualInput(targetElement) {
      let html = `<div class="input-block">
                              <label for="" class="form-label">Title</label>
                              <input type="text" name="manual_title" id="manual_title" class="form-control">
                              <div class="error" id="manual_title_error"></div>
                            </div>
                            <div class="input-block">
                              <label class="form-label">Amount</label>
                              <input type="number" min="0" name="manual_amount" id="manual_amount" class="form-control" step="0.01">
                              <div class="error" id="manual_amount_error"></div>
                            </div>
                            <div class="input-block">
                              <label for="" class="form-label">Date From</label>
                              <input type="date" name="manual_date_from" id="manual_date_from" class="form-control">
                              <div class="error" id="manual_date_from_error"></div>
                            </div>
                            <div class="input-block">
                              <label for="" class="form-label">Date To</label>
                              <input type="date" name="manual_date_to" id="manual_date_to" class="form-control">
                              <div class="error" id="manual_date_to_error"></div>
                            </div>
                            <div class="col-lg-12 mt-2">
                              <label class="form-label">Description</label>
                              <textarea class="form-control" name="manual_description" id="manual_description" rows="5" placeholder="Add description of penalty (min. 50 characters)" ></textarea>
                              <div class="error" id="manual_description_error"></div>
                          </div>`;
      targetElement.append(html);
    }

    function appendOthersInput(targetElement) {
      let html = `<div class="input-block">
            <label class="form-label">Demand Amount</label>
            <input type="number" min="0" class="form-control" id="others_deamnd_amount" step="0.01">
            <div class="error" id="others_deamnd_amount_error"></div>
        </div>
        <div class="input-block">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="others_description" id="others_description" rows="5" placeholder="Add description of penalty (min. 50 characters)"></textarea>
            <div class="error" id="others_description_error"></div>
        </div>
        `;
      targetElement.append(html);
    }

    function toggleBuiltUpAreaInputs(checkbox) {

      let element = $(checkbox);
      let target = element.closest('.demand-item-container').find('#user-inputs');
      if (element.is(':checked')) {
        let html = `<div class="input-block builtUpAreaInputs">
            <label class="form-label">Total built up area</label>
            <input type="number" min="0" class="form-control" id="luc_TBUA" name="luc_TBUA">
            <div class="error" id="luc_TBUA_error"></div>
        </div>
        <div class="input-block builtUpAreaInputs">
            <label class="form-label">Area to be used as commercial</label>
            <input type="number" min="0" class="form-control" id="luc_BUAC" name="luc_BUAC">
            <div class="error" id="luc_BUAC_error"></div>
        </div>`;
        target.append(html);
      } else {
        target.find('.builtUpAreaInputs').remove();
      }
    }

    function togglePenalSublettingInputs(checkbox) {

      let element = $(checkbox);
      let target = element.closest('.demand-item-container').find('#user-inputs');
      if (element.is(':checked')) {
        let html = `<div class="input-block panalSublettingInputs">
            <label class="form-label">Date of Start of Subletting</label>
            <input type="date" class="form-control" id="subletting_start_date" name="subletting_start_date">
            <div class="error" id="subletting_start_date_error"></div>
        </div>
        <div class="input-block panalSublettingInputs">
            <label class="form-label">Date of Confirmation of Subletting</label>
            <input type="date" class="form-control" id="subletting_confirmation_date" name="subletting_confirmation_date">
            <div class="error" id="subletting_confirmation_date_error"></div>
        </div>`;
        target.append(html);
      } else {
        target.find('.panalSublettingInputs').remove();
      }
    }

    /** calculate demand amount */

    $(document).on('click', '.btn-calculate', function() {
      let container = $(this).closest('.demand-item-container');
      let checkbox = container.find('.select-head-check');
      let calculatingFor = checkbox.attr('name');
      let inputElements = container.find('#user-inputs');
      switch (calculatingFor) {
        case "DEM_AF_P":
          calculateAllotmentFee(inputElements);
          break;
        case "DEM_UEI":
          calculateUnearnedIncrease(inputElements);
          break;
        case "DEM_CONV_CHG":
          calculateConversionCharges(inputElements);
          break;
        case "DEM_LUC_RC":
          calculateLUCCharges(inputElements);
          break;
        case "DEM_SLET_CHG":
          calculateSublettingCharges(inputElements);
          break;
        case "DEM_PENAL_STANDARD":
          calculateStandardPenalty(inputElements);
          break;
          /* case "DEM_MANUAL":
            calculateManualDemand(inputElements);
            break; */
        case "DEM_MANUAL":
          calculateManualDemand(inputElements);
          break;
        case "DEM_OTHER":
          calculateOtherDemand(inputElements);
          break;
        default:
          break;
      }
    })

    function calculateAllotmentFee(inputElements) {
      inputElements.find('.error').empty();
      let startDateString = inputElements.find('input[name="allotment_fee_date_from"]').val();
      let endDateString = inputElements.find('input[name="allotment_fee_date_to"]').val();
      let startDate = new Date(startDateString);
      let endDate = new Date(endDateString);
      let inputError = false;
      if (isNaN(startDate)) {
        inputError = true;
        inputElements.find("#allotment_fee_date_from_error").html('Valid start date is required')
      }
      if (isNaN(endDate)) {
        inputError = true;
        inputElements.find("#allotment_fee_date_to_error").html('Valid end date is required')
      }
      if (endDate < startDate) {
        inputError = true;
        inputElements.find("#allotment_fee_date_to_error").html('End date should greater than or equal to start date')
      }
      if (!inputError) {
        let maxAllowedDate = new Date(startDate.getFullYear() + 50, startDate.getMonth(), startDate.getDate());
        if (endDate > maxAllowedDate) {
          inputError = true;
          inputElements.find("#allotment_fee_date_to_error").html("End date is more than 50 years past the start date")
        }
      }
      if (!inputError) {

        let diffDays = (endDate - startDate) / (86400 * 1000); //calculateDaysBetweenDates(startDate, endDate)
        let {
          years,
          days
        } = getYearDayDifference(startDate, endDate);
        let noOfYears = years + (days < 15 ? 15 / 365 : days / 365);
        let noOfYearsRoundOff = (Math.round(noOfYears * 100) / 100); //round off upto 2 decimal places
        let demandAmount = Math.round(landValue * noOfYears) / 100;
        console.log(demandAmount)
        let result = `${noOfYearsRoundOff}% of ₹ ${customNumFormat(landValue)} &approx;  ₹ ${customNumFormat(demandAmount)} [N x 1% of land value, where N = Number of years (calculated for ${years} years ${days > 0 ? ' and '+ days+ ' days':''})]`;
        displayDemandCalculationResult(inputElements, result);
        fillDemandAmount(inputElements, demandAmount);
      }
    }

    function calculateUnearnedIncrease(inputElements) {
      inputElements.find('.error').empty();
      let landValue = 0;
      let considerationValue = 0;
      let isTransferComplete = $('input[name="is_transfer_done"]:checked').val() == 1
      let landValueInput = inputElements.find('#unearned_increase_land_value');
      let considerationValueInput = inputElements.find('#unearned_increase_consideration_value');
      if (landValueInput.length > 0) {
        landValue = parseFloat(landValueInput.val()) || 0;
      }
      if (considerationValueInput.length > 0) {
        considerationValue = parseFloat(considerationValueInput.val()) || 0;
      }
      if (isTransferComplete) {
        if (considerationValue == 0) {
          $('#unearned_increase_consideration_value_error').html('Consideration value is required');
        }
        let TransferDateInput = inputElements.find('input[type="date"]');
        if (TransferDateInput) {
          let transferDate = new Date(TransferDateInput.val());
          if (isNaN(transferDate)) {
            $('#unearned_increase_transfer_date_error').html("Transfer date is required.")
          }
        }
      }
      if (landValue == 0) {
        $('#unearned_increase_land_value_error').html("Land value is not available can not proceed.")
      }
      let isError = landValue == 0 || (isTransferComplete && considerationValue == 0)
      if (!isError) {
        let unerarnedIncrease = Math.round((Math.max(landValue, considerationValue) * 10 / 100) * 100) / 100; //callculate and round off to 2 decimal points
        let result = `Unearned Increase (10 % of ${landValue >= considerationValue ? 'land value':'consideration value'})  = ₹ ${customNumFormat(unerarnedIncrease)} [10% of land value ${considerationValue > 0? 'or consideration value whichever is greater.':''} ]`;
        displayDemandCalculationResult(inputElements, result)
        fillDemandAmount(inputElements, unerarnedIncrease);
      }
    }

    function calculateConversionCharges(inputElements) {
      let landValue = 0;
      let considerationValue = 0;
      let landValueInput = inputElements.find('#conversion_land_value');
      let allowRemssionCheck = inputElements.find('#conversion_remission');


      if (landValueInput.length > 0) {
        landValue = landValueInput.val();
      }
      let allowRemission = allowRemssionCheck && allowRemssionCheck.is(':checked');
      let conversionCharges = landValue * (20 / 100); //callculate and round off to 2 decimal points
      let netConversion = allowRemission ? conversionCharges - standardConversionRemission * conversionCharges : conversionCharges;
      netConversion = Math.round(netConversion * 100) / 100;
      let result = `Payable conversion charges ${allowRemission ? 'after remission' : ''} = ₹ ${customNumFormat(netConversion)}`
      displayDemandCalculationResult(inputElements, result)
      fillDemandAmount(inputElements, netConversion);
    }

    function calculateLUCCharges(inputElements) {
      inputElements.find('.error').empty();
      let landValue = inputElements.find('#luc_land_value').val();
      let chargesApplicabe = true;
      let mixedUse = inputElements.find('#partial_change').is(':checked');
      let inputError = false;
      let tbuac;
      let buac;
      if (mixedUse) {
        tbuac = parseFloat($('#luc_TBUA').val()) || 0;
        buac = parseFloat($('#luc_BUAC').val()) || 0;
        if (tbuac > landArea) {
          $('#luc_TBUA_error').html(`Total build up area can not be more than land size ${landArea} Sq.m.`);
          inputError = true;
        }
        if (tbuac != "" && tbuac > 0) {
          //let buac = parseFloat($('#luc_BUAC').val()) || 0;
        } else {
          $('#luc_TBUA_error').html('Total built up area is required');
          inputError = true;
        }

        if (buac && buac > 0) {
          if (buac > tbuac) {
            $('#luc_BUAC_error').html('Commercial area can not be more than total built up area');
            inputError = true;
          }

        } else {
          $('#luc_BUAC_error').html('Area to be used as commercial is required');
          inputError = true;
        }

      }
      if (!inputError) {
        if (mixedUse) {
          let chargableLimit = 20;
          let chargableArea = 20 * tbuac / 100;
          if (buac <= chargableArea) {
            chargesApplicabe = false;
          }
        }
        let lucc = chargesApplicabe ? landValue * 10 / 100 : 0;
        let roundLucc = (Math.round(lucc * 100) / 100).toFixed(2);
        let result = `Land Use Change Charges  = ₹ ${customNumFormat(lucc)} [${lucc > 0 ? '10% of land value( &#8377; '+ customNumFormat((Math.round(landValue *100)/100).toFixed(2))+')':'0 as commercial area is less than 20% of total built up area'} ${chargesApplicabe && mixedUse ? ', commercial area is more than 20% of total built up area':''}]`;
        displayDemandCalculationResult(inputElements, result)
        fillDemandAmount(inputElements, lucc);
      }

    }

    function calculateSublettingCharges(inputElements) {
      inputElements.find('.error').empty();
      let annualIncome = parseFloat($('#annual_subletting_income').val()) || 0;
      let penalty = 0;
      let addPenalty = $('#penal_subletting').is(":checked");
      let inputError = false;
      let penaltyYears = 0;
      if (!(annualIncome > 0)) {
        inputError = true
        $('#annual_subletting_income_error').html('Annual income from subletting is required')
      }
      let sublettingCharges = 0.1 * annualIncome; //10% of annual income
      if (addPenalty) {
        sublettingStartDate = new Date($('#subletting_start_date').val());
        sublettingConfirmationDate = new Date($('#subletting_confirmation_date').val());
        if (isNaN(sublettingStartDate)) {
          inputError = true;
          inputElements.find("#subletting_start_date_error").html('Valid start date is required')
        }
        if (isNaN(sublettingConfirmationDate)) {
          inputError = true;
          inputElements.find("#subletting_confirmation_date_error").html('Valid confirmation date is required')
        }
        if (sublettingStartDate > sublettingConfirmationDate) {
          inputError = true;
          inputElements.find("#subletting_confirmation_date_error").html('Confirmation date can not be less than start date')
        }
        if (inputError) {
          return false;
        }
        let {
          years,
        } = getYearDayDifference(sublettingStartDate, sublettingConfirmationDate);
        penaltyYears = years;
        penalty = 0.25 * years * annualIncome; //25% of annual income * years
      } else if (inputError) {
        return false;
      }
      let totalSublettingCharges = sublettingCharges + penalty;
      totalSublettingCharges = (Math.round(totalSublettingCharges * 100) / 100).toFixed(2);
      let result = `Total Subletting Charges  = ₹ ${customNumFormat(totalSublettingCharges)} (10% of annual income ${penalty> 0 ? '+ penalty for '+penaltyYears+' years at 25% of annual income per year':''})`;
      displayDemandCalculationResult(inputElements, result)
      fillDemandAmount(inputElements, totalSublettingCharges);
    }

    function calculateStandardPenalty(inputElements) {
      inputElements.find('.error').empty();
      let landValue = 0;
      let inputError = false;
      let landInput = inputElements.find('#standard_penalty_land_value');
      if (landInput.length > 0) {
        landValue = parseFloat(landInput.val()) || 0;
        if (landValue <= 0) {
          $('#standard_penalty_land_value_error').html('Valid land value is required')
          inputError = true;
        }
      } else {
        inputError = true;
      }
      let descriptionInput = inputElements.find('#standard_penalty_description');
      let descriptionText = descriptionInput.val() || '';
      if (descriptionText.length < 50) {
        $('#standard_penalty_description_error').html("Add description of penalty in min. 50 characters");
        inputError = true;
      }
      if (!inputError) {
        let standardPenalty = (Math.round(landValue) / 100).toFixed(2);
        let result = `Calculated standatd penalty = &#8377;${customNumFormat(standardPenalty)}[1% of land value (&#8377;${customNumFormat((Math.round(landValue*100)/100).toFixed(2))})]`;
        displayDemandCalculationResult(inputElements, result)
        fillDemandAmount(inputElements, standardPenalty);
      }
    }

    function calculateOtherDemand(inputElements) {
      inputElements.find('.error').empty();
      let inputError = false;
      let amountInput = inputElements.find('#others_deamnd_amount');
      let amount = 0;
      if (amountInput.length > 0) {
        amount = parseFloat(amountInput.val()) || 0;
        if (amount <= 0) {
          $('#others_deamnd_amount_error').html('Amount is required')
          inputError = true;
        }
      } else {
        inputError = true;
      }
      let descriptionInput = inputElements.find('#others_description');
      let descriptionText = descriptionInput.val() || '';
      if (descriptionText.length < 50) {
        $('#others_description_error').html("Add description of penalty in min. 50 characters");
        inputError = true;
      }
      if (!inputError) {
        let result = `Demand head for amount &#8377;${customNumFormat((Math.round(amount*100)/100).toFixed(2))} added successfully`;
        displayDemandCalculationResult(inputElements, result)
        fillDemandAmount(inputElements, amount);
      }
    }

    function calculateManualDemand(inputElements) {
      inputElements.find('.error').empty();
      let inputError = false;
      let amountInput = inputElements.find('#manual_amount');
      let amount = 0;
      if (amountInput.length > 0) {
        amount = parseFloat(amountInput.val()) || 0;
        if (amount <= 0) {
          $('#manual_amount_error').html('Amount is required')
          inputError = true;
        }
      } else {
        inputError = true;
      }

      let titleInput = inputElements.find('#manual_title');
      if (titleInput.length > 0) {
        if (titleInput.val() == "") {
          $('#manual_title_error').html('Title is required')
          inputError = true;
        }
      } else {
        inputError = true;
      }
      let descriptionInput = inputElements.find('#manual_description');
      let descriptionText = descriptionInput.val() || '';
      if (descriptionText.length < 50) {
        $('#manual_description_error').html("Add description of demand in min. 50 characters");
        inputError = true;
      }
      let manualDateFromInput = inputElements.find('#manual_date_from');
      let manualDateToInput = inputElements.find('#manual_date_to');

      let manualDateFromVal = manualDateFromInput.val();
      let manualDateToVal = manualDateToInput.val();

      // Only validate if at least one date is filled
      if (manualDateFromVal || manualDateToVal) {
        let manualDateFrom = new Date(manualDateFromVal);
        let manualDateTo = new Date(manualDateToVal);

        // If "from" date is filled but invalid
        if (manualDateFromVal && isNaN(manualDateFrom.getTime())) {
          manualDateFromInput.siblings('.error').html('Valid date from is required');
          inputError = true;
        }

        // If "to" date is filled but invalid
        if (manualDateToVal && isNaN(manualDateTo.getTime())) {
          manualDateToInput.siblings('.error').html('Valid date to is required');
          inputError = true;
        }

        // If both are valid and "to" < "from"
        if (
          !isNaN(manualDateFrom.getTime()) &&
          !isNaN(manualDateTo.getTime()) &&
          manualDateTo < manualDateFrom
        ) {
          manualDateFromInput.siblings('.error').html('Date To cannot be earlier than Date From');
          inputError = true;
        }
      }

      if (!inputError) {
        let result = `Demand head for amount &#8377;${customNumFormat((Math.round(amount*100)/100).toFixed(2))} added successfully`;
        displayDemandCalculationResult(inputElements, result)
        fillDemandAmount(inputElements, amount);
      }
    }

    function displayDemandCalculationResult(target, result) {
      target.parent().find('.calculation_details').remove();
      target.parent().append(`<span class="calculation_details mt-2">${result}</span>`)
      target.parent().find('.btn-calculate').hide();
    }

    function fillDemandAmount(target, amount) {
      let inputElement = target.parent().find('#include-demand-amount');
      if (inputElement.length > 0)
        inputElement.val(amount);
      calculateTotalAmount();
    }

    function getLandValueAtDate(propertyId, date) {
      if (landValue != "" && date != "") {
        /** locate inputs div */
        let findCheckBox = $('input[type="checkbox"][name="DEM_UEI"]');
        let target;
        if (findCheckBox.length > 0) {
          target = findCheckBox.closest('.demand-item-container').find('#user-inputs');
          if (target.find('#land_value_block').length > 0) {
            target.find('#land_value_block').remove();
          }
          let html = `
        <div class="input-block" id="land_value_block">
            <label>Land value on ${date.split('-').reverse().join('-')}</label>
            <div id="land_value_UEI">
            Fetching land value please wait
            </div>
        </div>
        `;
          target.append(html);
        }
        $.ajax({
          type: 'get',
          url: "{{route('getLandValueAtDate')}}",
          data: {
            date: date,
            propertyId: propertyId
          },
          success: function(response) {
            if (response.status == 'error') {
              showError(response.details);
              target.find('#land_value_block').remove();
            }
            if (response.status == 'success') {
              let landRate = parseFloat(response.landRate);
              let landValueAtDate = landArea * landRate
              $(document).find('#land_value_UEI').html(`<input type="number" min="0" class="form-control" value="${landValueAtDate}" readOnly id="unearned_increase_land_value" name="unearned_increase_land_value">
            <div class="error" id="unearned_increase_land_value_error"></div>
            `);
              // appendUnearnedIncreaseInput(target, 4)
            }
          },
          error: function(response) {
            target.find('#land_value_block').remove();
          }
        })
      } else {
        //validation logic
      }
    }

    function getYearDayDifference(start, end) {
      let years = end.getFullYear() - start.getFullYear();
      let tempDate = new Date(start);
      tempDate.setFullYear(start.getFullYear() + years);

      if (tempDate > end) {
        years--;
        tempDate.setFullYear(start.getFullYear() + years);
      }

      let diffTime = Math.abs(end - tempDate);
      let days = Math.floor(diffTime / (1000 * 60 * 60 * 24));

      return {
        years,
        days
      };
    }
  </script>
  @endsection