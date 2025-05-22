@extends('layouts.app')

@section('title', 'MIS Form Details')

@section('content')
<style>
    .pagination .active a {
        color: #ffffff !important;
    }
    .btn-group {
    display: flex;
    justify-content: center;
    gap: 0.75em;
    margin-top: 0 !important;
}
</style>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Reports</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item">Filter & Search Reports</li>
                <li class="breadcrumb-item active" aria-current="page">View Property Details</li>
            </ol>
        </nav>
    </div>
</div>
<!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->

<hr>

<div class="card">
    <div class="card-body">

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-12">
                    <!-- Begin Tabs and Tabs Container -->
                    <div class="tabs_container">
                        <div class="steps">
                            <div class="steps__step" data-step="0">
                                <div class="steps__step-number">1</div>
                                <div class="steps__step-name">BASIC DETAILS</div>
                            </div>
                            <div class="steps__connector"></div>
                            <div class="steps__step" data-step="1">
                                <div class="steps__step-number">2</div>
                                <div class="steps__step-name">LEASE DETAILS</div>
                            </div>
                            <div class="steps__connector"></div>
                            <div class="steps__step" data-step="2">
                                <div class="steps__step-number">3</div>
                                <div class="steps__step-name">LAND TRANSFER DETAILS</div>
                            </div>
                            <div class="steps__connector"></div>
                            <div class="steps__step" data-step="3">
                                <div class="steps__step-number">4</div>
                                <div class="steps__step-name">PROPERTY STATUS DETAILS</div>
                            </div>
                            <div class="steps__connector"></div>
                            <div class="steps__step" data-step="4">
                                <div class="steps__step-number">5</div>
                                <div class="steps__step-name">INSPECTION & DEMAND DETAILS</div>
                            </div>
                            <div class="steps__connector"></div>
                            <div class="steps__step" data-step="5">
                                <div class="steps__step-number">6</div>
                                <div class="steps__step-name">MISCELLANEOUS DETAILS</div>
                            </div>
                            <div class="steps__connector"></div>
                            <div class="steps__step" data-step="6">
                                <div class="steps__step-number">7</div>
                                <div class="steps__step-name">LATEST CONTACT DETAILS</div>
                            </div>
                        </div>
                    
                        <!-- Content for each step -->
                        <div class="step-content" data-step="0">
                            
                            <!-- Content for step 1 -->
                            
                            <div class="container-fluid pb-3">
                                <h5 class="mb-4 pt-3 text-decoration-underline">BASIC DETAILS</h5>
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td><b>New Property Id: </b> {{$viewDetails->unique_propert_id}}</td>
                                            <td><b>Old Property Id: </b> {{$viewDetails->old_propert_id}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>More than 1 Property IDs: </b> {{($viewDetails->is_multiple_ids) ? 'Yes' : 'No'}}
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
                        <div class="step-content" data-step="1" style="display: none;">
                           
                            <!-- Content for step 2 -->
                            <div class="container-fluid pb-3">
                                <h5 class="mb-4 pt-3 text-decoration-underline">LEASE DETAILS</h5>
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td><b>Type of Lease: </b>
                                                {{$item->itemNameById($viewDetails->propertyLeaseDetail->type_of_lease)}}
                                            </td>
                                            <td><b>Date of Execution: </b> {{$viewDetails->propertyLeaseDetail->doe}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Lease/Allotment No.: </b> {{$viewDetails->lease_no}}</td>
                                            <td><b>Date of Expiration: </b>{{$viewDetails->propertyLeaseDetail->date_of_expiration}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Date of Allotment: </b>{{$viewDetails->propertyLeaseDetail->doa}} </td>
                                            <td><b>Block No.: </b> {{$viewDetails->block_no}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Plot No.: </b> {{$viewDetails->plot_or_property_no}} </td>
                                            <?php
                                            $names = [];
                                            foreach ($viewDetails->propertyTransferredLesseeDetails as $transferDetail) {
                                                $name = $transferDetail->process_of_transfer;
                                                if ($name == 'Original') {
                                                    $names[] = $transferDetail->lessee_name;
                                                }
                                            }
                                            ?>
                                            <td><b>In Favour Of: </b>{{ implode(", ", $names) }} </td>
                                        </tr>
                                        <tr>
                                            <td><b>Presently Known As: </b>{{$viewDetails->propertyLeaseDetail->presently_known_as}}
                                            </td>
                                            <td><b>Area: </b> {{$viewDetails->propertyLeaseDetail->plot_area}}
                                                {{$item->itemNameById($viewDetails->propertyLeaseDetail->unit)}} <span class="text-secondary">({{$viewDetails->propertyLeaseDetail->plot_area_in_sqm}} Sq
                                                    Meter)</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Premium (Re/ Rs): </b>₹
                                                {{$viewDetails->propertyLeaseDetail->premium}}.{{$viewDetails->propertyLeaseDetail->premium_in_paisa}}{{$viewDetails->propertyLeaseDetail->premium_in_aana}}
                                            </td>
                                            <td><b>Ground Rent (Re/ Rs):
                                                </b>₹
                                                {{$viewDetails->propertyLeaseDetail->gr_in_re_rs}}.{{$viewDetails->propertyLeaseDetail->gr_in_paisa}}{{$viewDetails->propertyLeaseDetail->gr_in_aana}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Start Date of Ground Rent:
                                                </b>{{$viewDetails->propertyLeaseDetail->start_date_of_gr}} </td>
                                            <td><b>RGR Duration (Yrs): </b> {{$viewDetails->propertyLeaseDetail->rgr_duration}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>First Revision of GR due on:
                                                </b>{{$viewDetails->propertyLeaseDetail->first_rgr_due_on}} </td>
                                            <td><b>Purpose for which leased/<br> allotted (As per lease):
                                                </b>{{$item->itemNameById($viewDetails->propertyLeaseDetail->property_type_as_per_lease)}}
                                            </td>
                                        </tr>
                
                                        <tr>
                                            <td><b>Sub-Type (Purpose , at present):
                                                </b>{{$item->itemNameById($viewDetails->propertyLeaseDetail->property_sub_type_as_per_lease)}}
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan=2><b>Land Use Change:
                                                </b>{{($viewDetails->propertyLeaseDetail->is_land_use_changed) ? 'Yes' : 'No'}} </td>
                
                                        </tr>
                                        <tr>
                                            <td><b>If yes,<br>Purpose for which leased/<br> allotted (As per lease):
                                                </b>{{$item->itemNameById($viewDetails->propertyLeaseDetail->property_type_at_present)}}
                                            </td>
                                            <td><b>Sub-Type (Purpose , at present):
                                                </b>{{$item->itemNameById($viewDetails->propertyLeaseDetail->property_sub_type_at_present)}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="step-content" data-step="2" style="display: none;">
                            
                            <!-- Content for step 3 -->
                            <div class="container-fluid pb-3">
                                <h5 class="mb-4 pt-3 text-decoration-underline">LAND TRANSFER DETAILS</h5>
                                @if($separatedData)
                                @foreach($separatedData as $date => $dayTransferDetail) <!-- Added by Nitin to group land transfer by date ---->
                                @foreach($dayTransferDetail as $key => $transferDetail)<!-- Modified By Nitin--->
                                <div class="border border-primary p-3 mt-3">
                                    @if($key == 'Conversion')
                                    <p><b>Date: </b>{{$viewDetails->propertyLeaseDetail->date_of_conveyance_deed}}</p>
                                    @else
                                    <p><b>Date: </b>{{$date}}</p>
                                    @endif
                                    <p><b>Process Of Transfer: </b>{{$key}}</p>
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
                                @endforeach<!-- Added By Nitin -->
                                @else
                                <p class="font-weight-bold">No Records Available</p>
                                @endif
                            </div>
                        </div>
                        <div class="step-content" data-step="3" style="display: none;">
                            
                            <!-- Content for step 4 -->
                            <div class="container-fluid pb-3">
                                <h5 class="mb-4 pt-3 text-decoration-underline">PROPERTY STATUS DETAILS</h5>
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        @if($viewDetails->propertyLeaseDetail)
                                        <?php
                                        $namesConversion = [];
                                        foreach ($viewDetails->propertyTransferredLesseeDetails as $transferDetail) {
                                            $name = $transferDetail->process_of_transfer;
                                            if ($name == 'Conversion') {
                                                $namesConversion[] = $transferDetail->lessee_name;
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td><b>Free Hold (F/H): </b>{{($viewDetails->status == 952) ? 'Yes' : 'No'}}</td>
                                            <td><b>Date of Conveyance Deed:
                                                </b>{{$viewDetails->propertyLeaseDetail->date_of_conveyance_deed}}</td>
                                            <td>
                                                <b>In Favour of, Name: </b>{{ implode(", ", $namesConversion) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Vaccant: </b>{{($viewDetails->status == 1124) ? 'Yes' : 'No'}}</td>
                                            <td><b>In Possession Of:
                                                </b>{{$viewDetails->propertyLeaseDetail->in_possession_of_if_vacant}}</td>
                                            <td><b>Date Of Transfer: </b>{{$viewDetails->propertyLeaseDetail->date_of_transfer}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Others: </b>{{($viewDetails->status == 1342) ? 'Yes' : 'No'}}</td>
                                            <td><b>Remark: </b>{{$viewDetails->propertyLeaseDetail->remarks}}</td>
                                        </tr>
                                        @else
                                        <p class="font-weight-bold">No Records Available</p>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="step-content" data-step="4" style="display: none;">
                            
                            <!-- Content for step 5 -->
                            <div class="container-fluid pb-3">
                                <h5 class="mb-4 pt-3 text-decoration-underline">INSPECTION & DEMAND DETAILS</h5>
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        {{-- Show Inspection Report Date if available --}}
                                        @if($viewDetails->propertyInspectionDemandDetail && $viewDetails->propertyInspectionDemandDetail->last_inspection_ir_date)
                                            <tr>
                                                <td colspan=2><b>Date of Last Inspection Report:</b>
                                                    {{ $viewDetails->propertyInspectionDemandDetail->last_inspection_ir_date }}
                                                </td>
                                            </tr>
                                        @endif

                                        {{-- Show Demand Data from API fallback --}}
                                        @if($demandFallback)
                                            <tr>
                                                <td><b>Date of Last Demand Letter:</b> {{ $demandFallback->last_demand_letter_date }}</td>
                                                <td><b>Demand ID:</b> {{ $demandFallback->last_demand_id }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan=2><b>Amount of Last Demand Letter:</b> ₹ {{ $demandFallback->last_demand_amount }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Last Amount Received:</b> ₹ {{ $demandFallback->last_amount_received }}</td>
                                                <td><b>Date of Last Amount Received:</b> {{ $demandFallback->last_amount_received_date }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <p class="font-weight-bold">No Records Available</p>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="step-content" data-step="5" style="display: none;">
                           
                            <!-- Content for step 5 -->
                            <div class="container-fluid pb-3">
                                <h5 class="mb-4 pt-3 text-decoration-underline">MISCELLANEOUS DETAILS</h5>
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        @if($viewDetails->propertyMiscDetail)
                                        <tr>
                                            <td><b>GR Revised Ever:
                                                </B>{{($viewDetails->propertyMiscDetail->is_gr_revised_ever) ? 'Yes' : 'No'}}</td>
                                            <td><b>Date of GR Revised: </b>{{$viewDetails->propertyMiscDetail->gr_revised_date}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Supplementary Lease Deed Executed:
                                                </b>{{($viewDetails->propertyMiscDetail->is_supplimentry_lease_deed_executed) ? 'Yes' : 'No'}}
                                            </td>
                                            <td><b>Date of Supplementary Lease Deed Executed:
                                                </b>{{$viewDetails->propertyMiscDetail->supplimentry_lease_deed_executed_date}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Re-entered: </b>{{($viewDetails->propertyMiscDetail->is_re_rented) ? 'Yes' : 'No'}}
                                            </td>
                                            <td><b>Date of Re-entry: </b>{{$viewDetails->propertyMiscDetail->re_rented_date}}</td>
                                        </tr>
                                        @else
                                        <p class="font-weight-bold">No Records Available</p>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="step-content" data-step="6" style="display: none;">
                            
                            <!-- Content for step 5 -->
                            <div class="container-fluid">
                                <h5 class="mb-4 pt-3 text-decoration-underline">Latest Contact Details</h5>
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td><b>Address: </b>{{$viewDetails->propertyContactDetail->address}}</td>
                                            <td><b>Phone No.: </b>{{$viewDetails->propertyContactDetail->phone_no}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Email: </b>{{$viewDetails->propertyContactDetail->email}}</td>
                                            <td><b>As on Date: </b>
                                                @if(isset($viewDetails->propertyContactDetail->as_on_date))
                                                {{$viewDetails->propertyContactDetail->as_on_date}}
                                                @else
                                                {{$viewDetails->propertyLeaseDetail->date_of_conveyance_deed}}
                                                @endif
                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xl-8">
                                    <a href="{{ route('download.pdf', ['property' => $viewDetails->id]) }}" class="btn btn-success">
                                            Download <i class='bx bxs-download'></i>
                                        </a>                                    </div>
                                    <div class="col-xl-4">
                                        <div class="btn-group">
                                            <button class="btn btn-dark" type="button" data-action="prev" disabled>Previous</button>
                                            <button class="btn btn-primary" type="button" data-action="next">Next</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                     <!-- End Tabs and Tabs Container -->
                </div>
            </div>

        </div>
    </div>
</div>


@endsection


@section('footerScript')
{{-- <script src="{{ asset('assets/js/jquery.min.js') }}"></script> --}}
<script src="{{ asset('assets/js/viewAndNext.js') }}"></script>
@endsection

