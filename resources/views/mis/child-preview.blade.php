@extends('layouts.app')

@section('title', 'MIS Form Details')

@section('content')
<style>
    .pagination .active a {
        color: #ffffff !important;

    }
</style>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">MIS</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">MIS Form Preview</li>
            </ol>
        </nav>
    </div>
</div>
<!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->

<hr>

<div class="card">
    <div class="card-body">

        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-4 pt-3 text-decoration-underline text-uppercase">Property Details</h5>
                @haspermission('edit.child')
                <a href="{{ route('editChildDetails', ['property' => $childData->id]) }}">
                    <button type="button" class="btn btn-primary px-5">Edit</button>
                </a>                
                @endhaspermission
            </div>
            <div class="container pb-3">
                <div class="border border-primary p-3 mt-3">
                    <h5 class="mb-4 pt-3text-uppercase">Master Property Details</h5>
                    <div class="container pb-3">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td><b>New Property Id: </b> 
                                        <a href="{{ route('viewDetails', ['property' => $viewDetails->id]) }}">
                                            {{ $viewDetails->unique_propert_id }}
                                        </a>
                                    </td>                                    
                                    <td><b>Old Property Id: </b> {{$viewDetails->old_propert_id}}</td>
                                </tr>
                                <tr>
                                    <td><b>More than 1 Property IDs: </b>
                                        {{($viewDetails->is_multiple_ids) ? 'Yes' : 'No'}}
                                    </td>
                                    <td><b>File No.: </b> {{$viewDetails->file_no}}</td>
                                </tr>
                                <tr>
                                    <td><b>Computer generated file no: </b> {{$viewDetails->unique_file_no}} </td>
                                    <td><b>Colony Name(Old): </b> {{$viewDetails->oldColony->name}} </td>
                                </tr>
                                <tr>
                                    <td><b>Colony Name(Present):</b> {{$viewDetails->newColony->name}} </td>
                                    <td><b>Property Status: </b> {{$item->itemNameById($viewDetails->status)}} </td>

                                </tr>
                                <tr>
                                    <td><b>Land Type:</b> {{$item->itemNameById($viewDetails->land_type)}}</td>
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="border border-primary p-3 mt-3">
                    <h5 class="mb-4 pt-3text-uppercase">Plot/Flat Details</h5>
                    <div class="container pb-3">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td><b>New Splited Property Id: </b> {{$childData->child_prop_id ?? 'NA'}}</td>
                                    <td><b>Old Property Id: </b> {{$childData->old_property_id ?? 'NA'}}</td>
                                </tr>
                                <tr>
                                    <td><b>Plot /Flat no: </b> {{$childData->plot_flat_no ?? 'NA'}} </td>
                                    <td><b>Area: </b> {{$childData->original_area ?? '0'}}
                                        {{$item->itemNameById($childData->unit)}} <span
                                            class="text-secondary">({{$childData->area_in_sqm ?? '0'}} Sq Meter)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Presently Known As:</b> {{$childData->presently_known_as ?? 'NA'}}</td>
                                    <td><b>Property Status:</b>
                                        {{$item->itemNameById($childData->property_status ?? 'NA')}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr>

            <h5 class="mb-4 pt-3 text-decoration-underline">LEASE DETAILS</h5>
            <div class="container pb-3">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><b>Type of Lease: </b>
                                {{$item->itemNameById($viewDetails->propertyLeaseDetail->type_of_lease ?? 'NA')}}</td>
                            <td><b>Date of Execution: </b> {{$viewDetails->propertyLeaseDetail->doe ?? 'NA'}}</td>
                        </tr>
                        <tr>
                            <td><b>Lease/Allotment No.: </b> {{$viewDetails->lease_no ?? 'NA'}}</td>
                            <td><b>Date of Expiration:
                                </b>{{$viewDetails->propertyLeaseDetail->date_of_expiration ?? 'NA'}}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Date of Allotment: </b>{{$viewDetails->propertyLeaseDetail->doa ?? 'NA'}} </td>
                            <td><b>Block No.: </b> {{$viewDetails->block_no ?? 'NA'}}</td>
                        </tr>
                        <tr>
                            <td><b>Plot No.: </b> {{$viewDetails->plot_or_property_no ?? 'NA'}} </td>
                            <?php
$names = [];
foreach ($viewDetails->propertyTransferredLesseeDetails as $transferDetail) {
    $name = $transferDetail->process_of_transfer;
    if ($name == 'Original') {
        $names[] = $transferDetail->lessee_name;
    }
}
                                            ?>
                            <td><b>In Favour Of: </b>{{ $names ? implode(", ", $names) : 'NA' }} </td>
                        </tr>
                        <tr>
                            <td><b>Presently Known As:
                                </b>{{$viewDetails->propertyLeaseDetail->presently_known_as ?? 'NA'}}
                            </td>
                            <td><b>Area: </b> {{$viewDetails->propertyLeaseDetail->plot_area}}
                                {{$item->itemNameById($viewDetails->propertyLeaseDetail->unit)}} <span
                                    class="text-secondary">({{$viewDetails->propertyLeaseDetail->plot_area_in_sqm}} Sq
                                    Meter)</span>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Premium (Re/ Rs): </b>₹
                                {{$viewDetails->propertyLeaseDetail->premium ?? '0'}}.{{$viewDetails->propertyLeaseDetail->premium_in_paisa}}{{$viewDetails->propertyLeaseDetail->premium_in_aana}}
                            </td>
                            <td><b>Ground Rent (Re/ Rs):
                                </b>₹
                                {{$viewDetails->propertyLeaseDetail->gr_in_re_rs ?? '0'}}.{{$viewDetails->propertyLeaseDetail->gr_in_paisa}}{{$viewDetails->propertyLeaseDetail->gr_in_aana}}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Start Date of Ground Rent:
                                </b>{{$viewDetails->propertyLeaseDetail->start_date_of_gr ?? 'NA'}} </td>
                            <td><b>RGR Duration (Yrs): </b> {{$viewDetails->propertyLeaseDetail->rgr_duration ?? 'NA'}}
                            </td>
                        </tr>
                        <tr>
                            <td><b>First Revision of GR due on:
                                </b>{{$viewDetails->propertyLeaseDetail->first_rgr_due_on ?? 'NA'}} </td>
                            <td><b>Purpose for which leased/<br> allotted (As per lease):
                                </b>{{$item->itemNameById($viewDetails->propertyLeaseDetail->property_type_as_per_lease) ?? 'NA'}}
                            </td>
                        </tr>

                        <tr>
                            <td><b>Sub-Type (Purpose , at present):
                                </b>{{$item->itemNameById($viewDetails->propertyLeaseDetail->property_sub_type_as_per_lease) ?? 'NA'}}
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan=2><b>Land Use Change:
                                </b>{{($viewDetails->propertyLeaseDetail->is_land_use_changed) ? 'Yes' : 'No'}} </td>

                        </tr>
                        <tr>
                            <td><b>If yes,<br>Purpose for which leased/<br> allotted (As per lease):
                                </b>{{$item->itemNameById($viewDetails->propertyLeaseDetail->property_type_at_present) ?? 'NA'}}
                            </td>
                            <td><b>Sub-Type (Purpose , at present):
                                </b>{{$item->itemNameById($viewDetails->propertyLeaseDetail->property_sub_type_at_present) ?? 'NA'}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr>

            <h5 class="mb-4 pt-3 text-decoration-underline">LAND TRANSFER DETAILS</h5>
            <div class="container pb-3">
                @if($separatedData)
                    @foreach($separatedData as $date => $dayTransferDetail)
                        <!-- Added by Sourav to group land transfer by date ---->
                        @foreach($dayTransferDetail as $key => $transferDetail)


                            <div class="border border-primary p-3 mt-3">
                                <p><b>Process Of Transfer: </b>{{$key}}</p>
                                @if($key == 'Conversion')
                                    <p><b>Date: </b>{{$viewDetails->propertyLeaseDetail->date_of_conveyance_deed}}</p>
                                @else
                                    <p><b>Date: </b>{{$date}}</p>
                                @endif

                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Lessee Name</th>
                                        <th>Lessee Age (in Years)</th>
                                        <th>Lessee Share</th>
                                        <th>Lessee PAN Number</th>
                                        <th>Lessee Aadhar Number</th>
                                    </tr>
                                    @foreach($transferDetail as $details)
                                        <tr>
                                            <td>{{$details->lessee_name}}</td>
                                            <td>{{$details->lessee_age}}</td>
                                            <td>{{$details->property_share}}</td>
                                            <td>{{$details->lessee_pan_no}}</td>
                                            <td>{{$details->lessee_aadhar_no}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endforeach
                    @endforeach
                @else
                    <p class="font-weight-bold">No Records Available</p>
                @endif
            </div>
            <hr>

            <h5 class="mb-4 pt-3 text-decoration-underline">PROPERTY STATUS DETAILS</h5>
           
            <div class="container pb-3">
                <table class="table table-bordered">
                    <tbody>
                        @if($viewDetails->propertyLeaseDetail)
                                                <?php
                            $namesConversion = [];
                            $transferDate = 'NA';
                            foreach ($childData->propertyTransferredLesseeDetails as $transferDetail) {
                                $name = $transferDetail->process_of_transfer;
                                if ($name == 'Conversion') {
                                    $namesConversion[] = $transferDetail->lessee_name;
                                    $transferDate = $transferDetail->transferDate;
                                }
                            }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ?>
                                                <tr>
                                                    <td><b>Free Hold (F/H): </b>{{($childData->property_status == 952) ? 'Yes' : 'No'}}</td>
                                                    <td><b>Date of Conveyance Deed:
                                                        </b>{{($childData->status == 952) ? $viewDetails->propertyLeaseDetail->date_of_conveyance_deed : $transferDate}}
                                                    </td>
                                                    <td>
                                                        <b>In Favour of, Name:
                                                        </b>{{ $namesConversion ? implode(", ", $namesConversion) : 'NA' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Vaccant: </b>NA</td>
                                                    <td><b>In Possession Of: </b>NA</td>
                                                    <td><b>Date Of Transfer: </b>NA</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Others: </b>NA</td>
                                                    <td><b>Remark: </b>NA</td>
                                                </tr>
                        @else
                            <p class="font-weight-bold">No Records Available</p>
                        @endif
                    </tbody>
                </table>
            </div>
            <hr>

            <h5 class="mb-4 pt-3 text-decoration-underline">INSPECTION & DEMAND DETAILS</h5>
            <div class="container pb-3">
                <table class="table table-bordered">
                    <tbody>
                        @if($childData->propertyInspectionDemandDetail)
                            <tr>
                                <td colspan=2><b>Date of Last Inspection Report:
                                    </b>{{$childData->propertyInspectionDemandDetail->last_inspection_ir_date ?? 'NA'}}
                                </td>
                            </tr>
                            <tr>
                                <td><b>Date of Last Demand Letter:
                                    </b>{{$childData->propertyInspectionDemandDetail->last_demand_letter_date ?? 'NA'}}</td>
                                <td><b>Demand ID: </b>{{$childData->propertyInspectionDemandDetail->last_demand_id ?? 'NA'}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2><b>Amount of Last Demand Letter:
                                    </b>₹ {{$childData->propertyInspectionDemandDetail->last_demand_amount ?? '0'}} </td>
                            </tr>
                            <tr>
                                <td><b>Last Amount Received:
                                    </b>₹ {{$childData->propertyInspectionDemandDetail->last_amount_received ?? '0'}} </td>
                                <td><b>Date of Last Amount Received:
                                    </b>{{$childData->propertyInspectionDemandDetail->last_amount_received_date ?? 'NA'}}
                                </td>
                            </tr>
                        @else
                            <p class="font-weight-bold">No Records Available</p>
                        @endif
                    </tbody>
                </table>
            </div>
            <hr>

            <h5 class="mb-4 pt-3 text-decoration-underline">MISCELLANEOUS DETAILS</h5>
            <div class="container pb-3">
                <table class="table table-bordered">
                    <tbody>
                        @if($childData->propertyMiscDetail)
                            <tr>
                                <td><b>GR Revised Ever:
                                    </B>{{($childData->propertyMiscDetail->is_gr_revised_ever) ? 'Yes' : 'No'}}</td>
                                <td><b>Date of GR Revised: </b>{{$childData->propertyMiscDetail->gr_revised_date ?? 'NA'}}
                                </td>
                            </tr>
                            <tr>
                                <td><b>Supplementary Lease Deed Executed:
                                    </b>{{($childData->propertyMiscDetail->is_supplimentry_lease_deed_executed) ? 'Yes' : 'No'}}
                                </td>
                                <td><b>Date of Supplementary Lease Deed Executed:
                                    </b>{{$childData->propertyMiscDetail->supplimentry_lease_deed_executed_date ?? 'NA'}}
                                </td>
                            </tr>
                            <tr>

                                <td><b>Supplementary Area: </b> {{$childData->propertyMiscDetail->supplementary_area}}
                                    {{$item->itemNameById($childData->propertyMiscDetail->supplementary_area_unit)}} <span
                                        class="text-secondary">({{$childData->propertyMiscDetail->supplementary_area_in_sqm}}
                                        Sq
                                        Meter)</span>
                                </td>
                                <td><b>Supplementary Total Premium (in Rs):
                                    </b>₹ {{$childData->propertyMiscDetail->supplementary_total_premium ?? '0'}}
                                </td>
                            </tr>
                            <tr>
                                <td><b>Supplementary Total GR (in Rs):
                                    </b>₹ {{($childData->propertyMiscDetail->supplementary_total_gr) ?? '0'}}
                                </td>
                                <td><b>Supplementary Remark:
                                    </b>{{$childData->propertyMiscDetail->supplementary_remark ?? 'NA'}}
                                </td>
                            </tr>
                            <tr>
                                <td><b>Re-entered: </b>{{($childData->propertyMiscDetail->is_re_rented) ? 'Yes' : 'No'}}
                                </td>
                                <td><b>Date of Re-entry: </b>{{$childData->propertyMiscDetail->re_rented_date ?? 'NA'}}</td>
                            </tr>
                        @else
                            <p class="font-weight-bold">No Records Available</p>
                        @endif
                    </tbody>
                </table>
            </div>
            <hr>

            <h5 class="mb-4 pt-3 text-decoration-underline">Latest Contact Details</h5>
            <div class="container">
                <table class="table table-bordered">
                    <tbody>
                        @if($childData->propertyContactDetail)
                            <tr>
                                <td><b>Address: </b>{{$childData->propertyContactDetail->address ?? 'NA'}}</td>
                                <td><b>Phone No.: </b>{{$childData->propertyContactDetail->phone_no ?? 'NA'}}</td>
                            </tr>
                            <tr>
                                <td><b>Email: </b>{{$childData->propertyContactDetail->email ?? 'NA'}}</td>
                                <td><b>As on Date: </b>
                                    {{$childData->propertyContactDetail->as_on_date ?? 'NA'}}
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td><b>Address:
                                    </b>{{isset($viewDetails->propertyContactDetail->address) ? $viewDetails->propertyContactDetail->address : 'NA'}}
                                </td>
                                <td><b>Phone No.:
                                    </b>{{isset($viewDetails->propertyContactDetail->phone_no) ? $viewDetails->propertyContactDetail->phone_no : 'NA'}}
                                </td>
                            </tr>
                            <tr>
                                <td><b>Email:
                                    </b>{{isset($viewDetails->propertyContactDetail->email) ? $viewDetails->propertyContactDetail->email : 'NA'}}
                                </td>
                                <td><b>As on Date: </b>
                                    @if(isset($viewDetails->propertyContactDetail->as_on_date))
                                        {{$viewDetails->propertyContactDetail->as_on_date}}
                                    @else
                                        {{$viewDetails->propertyLeaseDetail->date_of_conveyance_deed}}
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection


@section('footerScript')
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
@endsection