@extends('layouts.app')

@section('title', 'Detailed Report')

@section('content')

{{-- <link rel="stylesheet" href="{{asset('assets/css/rgr.css')}}"> --}}
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Reports</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}""><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Detailed Report of Properties</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>
<!--breadcrumb-->
<!--end breadcrumb-->
<hr>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <form id="filter-form" method="get" action="{{route('detailedReport')}}">
                    <input type="hidden" name="export" value="0">
                    <div class="group-row-filters">
                        <div class="d-flex align-items-start w-btn-full">
                            <div class="relative-input mb-3">
                                <select class="selectpicker" aria-label="Land" aria-placeholder="Land" data-live-search="true" title="Land" id="land-type" name="landType">
                                    <option value="">All</option>
                                    @foreach ($landTypes[0]->items as $landType)
                                    <option value="{{$landType->id}}" {{(isset($filters['landType'] ) && $landType->id==$filters['landType'] ) ? 'selected':''}}>{{ $landType->item_name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="input-reset-icon" data-filter="land_type" data-targets="#land-type"><i class="lni lni-cross-circle"></i></button>
                            </div>

                            <div class="relative-input mb-3 mx-2">
                                <select class="selectpicker propType multipleSelect" multiple aria-label="Land Use Type" data-live-search="true" title="Land Use Type" id="property-Type" name="property_type[]">
                                    <option value="">All</option>
                                    @foreach ($propertyTypes[0]->items as $propertyType)
                                    <option value="{{$propertyType->id}}" {{(isset($filters['property_type'] ) && in_array($propertyType->id,$filters['property_type'] )) ? 'selected':''}}>{{ $propertyType->item_name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="input-reset-icon" data-filter="property_type" data-targets='#property-Type'><i class="lni lni-cross-circle"></i></button>
                            </div>
                            <div class="relative-input mb-3 mx-2">
                                <select class="selectpicker propSubType multipleSelect" multiple aria-label="Land Use Sub-Type" data-live-search="true" title="Land Use Sub-Type" id="prop-sub-type" name="property_sub_type[]">
                                    <option value="">All</option>
                                    @foreach($propertySubtypes as $st)
                                    <option value="{{$st->id}}" {{(isset($filters['property_sub_type'] ) && in_array($st->id,$filters['property_sub_type'] )) ? 'selected':''}}>{{ $st->item_name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="input-reset-icon" data-filter="property_sub_type" data-targets='#prop-sub-type'><i class="lni lni-cross-circle"></i></button>
                            </div>

                            <div class="relative-input mb-3 mx-2">
                                <select class="selectpicker multipleSelect" multiple aria-label="Land Status" data-live-search="true" title="Land Status" id="land-status" name="property_status[]">
                                    <option value="">All</option>
                                    @foreach ($propertyStatus[0]->items as $status)
                                    <option value="{{$status->id}}" {{(isset($filters['property_status'] ) && in_array($status->id,$filters['property_status'] )) ? 'selected':''}}>{{ $status->item_name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="input-reset-icon" data-filter="land_status" data-targets='#land-status'><i class="lni lni-cross-circle"></i></button>
                            </div>
                            <div class="relative-input mb-3 mx-2">
                                <select class="selectpicker colony" multiple aria-label="Search by Colony" data-live-search="true" title="Colony" id="colony_filter" name="colony[]">
                                    <option value="">All</option>
                                    @foreach ($colonyList as $colony)
                                    <option value="{{$colony->id}}" {{(isset($filters['colony'] ) && in_array($colony->id,$filters['colony'] )) ? 'selected':''}}>{{ $colony->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="input-reset-icon" data-filter="colony" data-targets="#colony_filter"><i class="lni lni-cross-circle"></i></button>
                            </div>
                            <div class="relative-input mb-3 mx-2">
                                <select class="selectpicker" multiple aria-label="Search by Lease Deed" data-live-search="true" title="Lease Deed" id="leaseDeed_filter" name="leaseDeed[]">
                                    <option value="">All</option>
                                    @foreach ($leaseTypes[0]->items as $leaseType)
                                    <option value="{{$leaseType->id}}" {{(isset($filters['leaseDeed'] ) && in_array($leaseType->id, $filters['leaseDeed'] )) ? 'selected':''}}>{{ $leaseType->item_name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="input-reset-icon" data-targets="#leaseDeed_filter"><i class="lni lni-cross-circle"></i></button>
                            </div>

                        </div>
                        <div class="d-flex justify-content-end w-btn-full">
                            <div class="btn-group-filter">
                                <button type="button" class="btn btn-secondary px-5 filter-btn" onclick="resetFilters()">Reset</button>
                                <button type="submit" class="btn btn-primary px-5 filter-btn">Apply</button>
                                <button type="button" class="btn btn-info px-5 filter-btn" id="export-btn">Export</button>
                            </div>
                        </div>
                </form>

                <div class="table-responsive mt-2">
                    <table id="example" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>S. No.</th>
                                <th>Property Id</th>
                                <th>Known as</th>
                                <!-- <th>File Number</th> -->
                                <!-- <th>File Number</th> -->
                                <th>Land Type</th>
                                <th>Status</th>
                                <th>Property Type</th>
                                <th style="width:2%;">Property SubType</th>
                                <!-- <th>Section</th> -->
                                <!-- <th>Premium (₹)</th>
                                <th>Ground Rent (₹)</th> -->
                                <th>Area(Sqm)</th>
                                <th style="width:20% !important;">Current Lessee</th>
								<th>Date Of Execution</th>
                                <th>Joint Property</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $startNum = $properties->currentPage() ? ($properties->currentPage()-1)* $properties->perPage():0;
                            @endphp
                            @forelse($properties as $prop)
                            <tr>
                                <td>{{$loop->iteration + $startNum}}</td>
                                <td>{{$prop->unique_propert_id}} <br> {{' ('.$prop->old_propert_id.')'}}</td>
                                <td>{{$prop->address}}</td>
                                {{-- <td>$prop->file_no</td> --}}
                                <td>{{$prop->landType}}</td>
                                <td>{{$prop->propertyStatus}}</td>
                                <td>{{$prop-> latestPropertyType ?? $prop->propertyType}}</td>
                                <td>{{$prop->latestPropertySubType ?? $prop->propertySubtype}}</td>
                                {{--<td>$prop->section</td>--}}
                                <td>{{round($prop->area_in_sqm,2)}}</td>
                                {{--<td>$prop->premium.'.'.$prop->premium_in_paisa</td>--}}
                                {{--<td>$prop->ground_rent</td>--}}
								<td style="width:20% !important;">{{(!is_null($prop->current_lesse_name)&& $prop->current_lesse_name !="")? $prop->current_lesse_name:  'N/A'}}</td>
                                <td>{{date('d-m-Y', strtotime($prop->doe))}}</td>
                                <td>{{$prop->child_prop_id ?? 'No'}}</td>
                                <td><a href="{{route('viewPropertyDetails',$prop->id)}}" class="btn btn-primary" target="_blank">View More</a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="13">No Data to Display</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="row mt-2">
                    @php
                    $total = $properties->total();
                    @endphp
                    <div class="col-lg-6">Total {{$total}} {{$total != 1 ? 'proeperties': 'proeperty'}} found</div>
                    <div class="col-lg-6">

                        <div style="float: right;">{{$properties->appends(request()->input())->links()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

@endsection

@section('footerScript')
<script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/js/property-type-subtype-dropdown.js') }}"></script>
<script>
    $('#export-btn').click(function() {
        $('input[name="export"]').val(1);
        $('button[type="submit"]').click();
        setTimeout(function() {
            $('input[name="export"]').val(0);
        }, 500)
    })

    $('.input-reset-icon').click(function() {
        // debugger;
        var targetElement = $($(this).data('targets'));
        if (targetElement.attr('name').indexOf('[') > -1) {
            targetElement.selectpicker('deselectAll').selectpicker('render');
        } else {
            targetElement.val('')
            targetElement.selectpicker('render');
        }

        if (targetElement == 'property_type') { //if filter is property type then also remove property sub type filter and clear dropdown
            $('#prop-sub-type').selectpicker('deselectAll');
            $('#prop-sub-type') /** remove options from property sub type */
                .find('option')
                .remove()
                .end();
        }

    })

    function resetFilters() {
        $('.input-reset-icon').each(function() {
            $(this).click();
        })
    }

    $(document).ready(function() {
        var table = $('#example').DataTable({
            responsive: false,
            searching: false,
            paging: false,
            info: false
        });
    });
</script>
@endsection
