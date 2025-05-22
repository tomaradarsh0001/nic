<!DOCTYPE html>
<br>
<head>
    <title>Property Details PDF</title>
    <style>
       .emblem-div {
            width: 100%;
            text-align: center;
        }

        .emblem {
            display: inline-block;
            margin: auto;
        }
        
        .title-main {
            color: navy;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin: 0;
        }
        .title-sub {
            color: navy;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin: 0;
        }
        .part-title {
            background-color: #1fa1a2;
            color: white;
            font-size: 16px;
            padding: 5px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 20px;
            text-align: center;
            vertical-align: middle;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f4f4f4;
        }

        @font-face {
            font-family: 'DejaVu Sans';
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
    </style>
</head>
<body>

    @if ($viewDetails->is_joint_property == NULL && $viewDetails->status != 1476)

        <!-- Emblem Image -->
        <div class="emblem-div">
            <img src="assets/images/emblem.png" width="60" alt="Emblem" class="emblem">
        </div>
        <!-- Main Title -->
        <h1 class="title-main">Land And Development Office</h1>
        <h2 class="title-sub">Ministry of Housing and Urban Affairs</h2>
        <h2 class="title-sub">Government of India</h2>
        <div class="part-title">
            BASIC DETAILS
        </div>
        <div class="part-details">
            <div class="container-fluid">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>
                                <b>Property ID:</b> 
                                {{ $viewDetails->unique_propert_id }} ({{ $viewDetails->old_propert_id }})
                            </td>
                            <td><b>Is it subdivided?: </b> {{ $viewDetails->is_multiple_ids ? 'Yes' : 'No' }}
                            </td>
                        </tr>
                        <tr>                        
                            <td><b>File No.: </b> {{ $viewDetails->file_no }}</td>
                            <td><b>Computer generated file no: </b> {{ $viewDetails->unique_file_no }} </td>
                        </tr>
                        <tr>                       
                            <td><b>Colony Name(Old): </b> {{ $viewDetails->oldColony->name }} </td>
                            <td><b>Colony Name(Present):</b> {{ $viewDetails->newColony->name }} </td>
                        </tr>
                        <tr>                       
                            <td><b>Property Status: </b> {{ $item->itemNameById($viewDetails->status) }} </td>
                            <td><b>Land Type:</b> {{ $item->itemNameById($viewDetails->land_type) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
            
        

        <!-- <h5 class="mb-4 pt-3 text-decoration-underline">LEASE DETAILS</h5> -->
        <div class="part-title">
            LEASE DETAILS
        </div>

        <div class="part-details">
            <div class="container-fluid">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><b>Type of Lease: </b>
                                {{ $item->itemNameById($viewDetails->propertyLeaseDetail->type_of_lease) }}</td>
                            <td><b>Date of Execution: </b> {{ \Carbon\Carbon::parse($viewDetails->propertyLeaseDetail->doe)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td><b>Lease/Allotment No.: </b> {{ $viewDetails->lease_no ??'NA' }}</td>
                            <td><b>Date of Expiration: </b>{{ \Carbon\Carbon::parse($viewDetails->propertyLeaseDetail->date_of_expiration)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Date of Allotment: </b> {{ \Carbon\Carbon::parse($viewDetails->propertyLeaseDetail->doa)->format('d-m-Y') }}</td>
                            <td><b>Block No.: </b> {{ $viewDetails->block_no }}</td>
                        </tr>
                        <tr>
                            <td><b>Plot No.: </b> {{ $viewDetails->plot_or_property_no }} </td>
                            <?php
                            $names = [];
                            foreach ($viewDetails->propertyTransferredLesseeDetails as $transferDetail) {
                                $name = $transferDetail->process_of_transfer;
                                if ($name == 'Original') {
                                    $names[] = $transferDetail->lessee_name;
                                }
                            }
                            ?>
                            <td><b>In Favour Of: </b>{{ implode(', ', $names) }} </td>
                        </tr>
                        <tr>
                            <td><b>Presently Known As: </b>{{ $viewDetails->propertyLeaseDetail->presently_known_as }}
                            </td>
                            <td><b>Area: </b> {{ $viewDetails->propertyLeaseDetail->plot_area }}
                                {{ $item->itemNameById($viewDetails->propertyLeaseDetail->unit) }} <span
                                    class="text-secondary">({{ $viewDetails->propertyLeaseDetail->plot_area_in_sqm }}
                                    Sq.
                                    Meter)</span>
                            </td>
                        </tr>
                        <tr>
                        <td><b>Premium (Re/ Rs):</b>
                            @if ($viewDetails->propertyLeaseDetail->premium)
                                ₹ {{ $viewDetails->propertyLeaseDetail->premium }}.{{ $viewDetails->propertyLeaseDetail->premium_in_paisa ?? '00' }}{{ $viewDetails->propertyLeaseDetail->premium_in_aana ?? '' }}
                            @else
                                ₹ 0
                            @endif
                        </td>

                        <td><b>Ground Rent (Re/ Rs):</b>
                            @if ($viewDetails->propertyLeaseDetail->gr_in_re_rs)
                                ₹ {{ $viewDetails->propertyLeaseDetail->gr_in_re_rs }}.{{ $viewDetails->propertyLeaseDetail->gr_in_paisa ?? '00' }}{{ $viewDetails->propertyLeaseDetail->gr_in_aana ?? '' }}
                            @else
                                ₹ 0
                            @endif
                        </td>
                        </tr>
                        <tr>
                            <td><b>Start Date of Ground Rent:
                                </b>{{\Carbon\Carbon::parse($viewDetails->propertyLeaseDetail->start_date_of_gr ?? 'NA')->format('d-m-Y') }}</td>
                            <td><b>RGR Duration (Yrs): </b>
                                {{ $viewDetails->propertyLeaseDetail->rgr_duration ?? 'NA' }}
                            </td>
                        </tr>
                        <tr>
                        <td colspan="2"><b>First Revision of GR due on:</b>
                            @if (!empty($viewDetails->propertyLeaseDetail->first_rgr_due_on))
                                {{ \Carbon\Carbon::parse($viewDetails->propertyLeaseDetail->first_rgr_due_on)->format('d-m-Y') }}
                            @else
                                NA
                            @endif
                        </td>

                        </tr>

                        <tr>
                            <td><b>Purpose for which leased/<br> allotted (As per lease):
                                </b>{{ $item->itemNameById($viewDetails->propertyLeaseDetail->property_type_as_per_lease) ?? 'NA' }}
                            </td>
                            <td><b>Sub-Type (Purpose , at present):
                                </b>{{ $item->itemNameById($viewDetails->propertyLeaseDetail->property_sub_type_as_per_lease) ?? 'NA' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan=2><b>Land Use Change:</b>
                                {{ $viewDetails->propertyLeaseDetail->is_land_use_changed ? 'Yes' : 'No' }}
                            </td>
                        </tr>

                        @if ($viewDetails->propertyLeaseDetail->is_land_use_changed)
                        <tr>
                            <td><b>If yes,<br>Property Type (Purpose, at present):</b>
                                {{ $item->itemNameById($viewDetails->propertyLeaseDetail->property_type_at_present) ?? 'NA' }}
                            </td>
                            <td><b>Sub-Type (Purpose, at present):</b>
                                {{ $item->itemNameById($viewDetails->propertyLeaseDetail->property_sub_type_at_present) ?? 'NA' }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        
        <br><br><br>

        <div class="part-title">
            LAND TRANSFER DETAILS
        </div>

        <div class="part-details">
            <div class="container-fluid">
                @if ($separatedData)
                    @foreach ($separatedData as $date => $dayTransferDetail)
                        <!-- Added by Nitin to group land transfer by date ---->
                        @foreach ($dayTransferDetail as $key => $transferDetail)
                            <!-- Modified By Nitin--->
                            <!-- <div class="border border-primary p-3 mt-3"> -->
                                <!-- <p><b>Process Of Transfer: </b>{{ $key }}</p>
                                @if ($key == 'Conversion')
                                    <p><b>Date: </b>{{ $viewDetails->propertyLeaseDetail->date_of_conveyance_deed }}
                                    </p>
                                @else
                                    <p><b>Date: </b>{{ $date }}</p>
                                @endif -->
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="5" class="address_data"><b>Process Of Transfer: </b>{{ $key }}<!-- </td> -->
                                        <!--  <td colspan="2" class="address_data"> -->
                                            &nbsp;
                                            @if ($key == 'Conversion')
                                                <!-- <b>Date: </b> -->({{\Carbon\Carbon::parse($viewDetails->propertyLeaseDetail->date_of_conveyance_deed)->format('d-m-Y') }})
                                                
                                            @else
                                                <!-- <b>Date: </b> -->({{ \Carbon\Carbon::parse($date)->format('d-m-Y') }})
                                            @endif
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <th>Lessee Name</th>
                                        <th>Lessee Age (in Years)</th>
                                        <th>Lessee Share</th>
                                        <th>Lessee PAN Number</th>
                                        <th>Lessee Aadhar Number</th>
                                    </tr>
                                    @foreach ($transferDetail as $details)
                                        <tr>
                                        <td>{{ $details->lessee_name ?? '-' }}</td>
                                        <td>{{ $details->lessee_age ?? '-' }}</td>
                                        <td>{{ $details->property_share ?? '-' }}</td>
                                        <td>{{ $details->lessee_pan_no ?? '-' }}</td>
                                        <td>{{ $details->lessee_aadhar_no ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            <!-- </div> -->
                        @endforeach
                    @endforeach
                @else
                    <p class="font-weight-bold">No Records Available</p>
                @endif
            </div>
        </div>

        <div class="part-title">
            PROPERTY STATUS DETAILS
        </div>
            <div class="part-details">
                <div class="container-fluid">
                    <table class="table table-bordered">
                        <tbody>
                            @if ($viewDetails->propertyLeaseDetail)
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
                                    <td >
                                        <b>Free Hold (F/H): </b>{{ $viewDetails->status == 952 ? 'Yes' : 'No' }}
                                    </td>

                                    @if ($viewDetails->status == 952)
                                        <td>
                                            <b>Date of Conveyance Deed:</b>
                                            @if ($viewDetails->propertyLeaseDetail->date_of_conveyance_deed)
                                                {{ \Carbon\Carbon::parse($viewDetails->propertyLeaseDetail->date_of_conveyance_deed)->format('d-m-Y') }}
                                            @else
                                                NA
                                            @endif
                                        </td>
                                        <td>
                                            <b>In Favour of, Name: </b>{{ implode(', ', $namesConversion) }}
                                        </td>
                                    @endif
                                </tr>
                            @else
                                <p class="font-weight-bold">No Records Available</p>
                            @endif
                        </tbody>
                    </table>
                </div>   
            </div>

            <div class="part-title">
                INSPECTION & DEMAND DETAILS
            </div>
            <div class="part-details">
                <div class="container-fluid">
                    <table class="table table-bordered">
                        <tbody>
                            {{-- Only inspection report from local --}}
                            @if($viewDetails->propertyInspectionDemandDetail && $viewDetails->propertyInspectionDemandDetail->last_inspection_ir_date)
                                <tr>
                                    <td colspan="2"><b>Date of Last Inspection Report:</b>
                                        {{ \Carbon\Carbon::parse($viewDetails->propertyInspectionDemandDetail->last_inspection_ir_date)->format('d-m-Y') }}
                                    </td>
                                </tr>
                            @endif
    
                            {{-- API-based demand display --}}
                            @if($demandFallback)
                                <tr>
                                    <td><b>Date of Last Demand Letter:</b>
                                        {{ \Carbon\Carbon::parse($demandFallback->last_demand_letter_date)->format('d-m-Y') }}
                                    </td>
                                    <td><b>Demand ID:</b> {{ $demandFallback->last_demand_id }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Amount of Last Demand Letter:</b> ₹ {{ $demandFallback->last_demand_amount }}</td>
                                </tr>
                                <tr>
                                    <td><b>Last Amount Received:</b> ₹ {{ $demandFallback->last_amount_received }}</td>
                                    <td><b>Date of Last Amount Received:</b> {{ $demandFallback->last_amount_received_date }}</td>
                                </tr>
                            @else
                                <p class="font-weight-bold">No Records Available</p>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        <!-- <h5 class="mb-4 pt-3 text-decoration-underline">MISCELLANEOUS DETAILS</h5> -->
        <div class="part-title">
            MISCELLANEOUS DETAILS
        </div>
        <div class="part-details">
            <div class="container-fluid">
        
                <table class="table table-bordered">
                    <tbody>
                        @if ($viewDetails->propertyMiscDetail)
                            
                            <tr>
                                <td><b>GR Revised Ever:</b>
                                    {{ $viewDetails->propertyMiscDetail->is_gr_revised_ever ? 'Yes' : 'No' }}
                                </td>

                                <td>
                                    @if ($viewDetails->propertyMiscDetail->is_gr_revised_ever)
                                        <b>Date of GR Revised:</b>
                                        @if ($viewDetails->propertyMiscDetail->gr_revised_date)
                                            {{ \Carbon\Carbon::parse($viewDetails->propertyMiscDetail->gr_revised_date)->format('d-m-Y') }}
                                        @else
                                            NA
                                        @endif
                                    @else
                                        <b>Date of GR Revised:</b> NA
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>Revised GR Amount:</b>₹ 0
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" @if (!$viewDetails->propertyMiscDetail->is_supplimentry_lease_deed_executed) colspan="2" @endif>
                                    <b>Supplementary Lease Deed Executed:</b>
                                    {{ $viewDetails->propertyMiscDetail->is_supplimentry_lease_deed_executed ? 'Yes' : 'No' }}
                                </td>

                                @if ($viewDetails->propertyMiscDetail->is_supplimentry_lease_deed_executed)
                                    <td width="50%"><b>Date of Supplementary Lease Deed Executed:</b>
                                        @if ($viewDetails->propertyMiscDetail->supplimentry_lease_deed_executed_date)
                                            {{ \Carbon\Carbon::parse($viewDetails->propertyMiscDetail->supplimentry_lease_deed_executed_date)->format('d-m-Y') }}
                                        @else
                                            NA
                                        @endif
                                    </td>
                                @endif
                            </tr>


                            <tr>
                                <td width="50%" @if (!$viewDetails->propertyMiscDetail->is_re_rented) colspan="2" @endif>
                                    <b>Re-entered:</b>
                                    {{ $viewDetails->propertyMiscDetail->is_re_rented ? 'Yes' : 'No' }}
                                </td>

                                @if ($viewDetails->propertyMiscDetail->is_re_rented)
                                    <td width="50%"><b>Date of Re-entry:</b>
                                        @if ($viewDetails->propertyMiscDetail->re_rented_date)
                                            {{ \Carbon\Carbon::parse($viewDetails->propertyMiscDetail->re_rented_date)->format('d-m-Y') }}
                                        @else
                                            NA
                                        @endif
                                    </td>
                                @endif
                            </tr>


                        @else
                            <p class="font-weight-bold">No Records Available</p>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- <h5 class="mb-4 pt-3 text-decoration-underline">Latest Contact Details</h5> -->
        <div class="part-title">
            LATEST CONTACT DETAILS
        </div>
        <div class="part-details">
            <div class="container-fluid">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td width="50%"><b>Address: </b>{{ $viewDetails->propertyContactDetail->address ?? 'NA' }}</td>
                            <td width="50%"><b>Phone No.: </b>{{ $viewDetails->propertyContactDetail->phone_no ?? 'NA' }}</td>
                        </tr>
                        <tr>
                            <td width="50%"><b>Email: </b>{{ $viewDetails->propertyContactDetail->email ?? 'NA' }}</td>
                            <td width="50%"><b>As on Date: </b>
                                @if (isset($viewDetails->propertyContactDetail->as_on_date))
                                    {{\Carbon\Carbon::parse($viewDetails->propertyContactDetail->as_on_date)->format('d-m-Y')}}
                                @else
                                    {{\Carbon\Carbon::parse($viewDetails->propertyLeaseDetail->date_of_conveyance_deed)->format('d-m-Y')}}
                                @endif

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Message for unallotted property -->
        <div style="text-align: center; margin: 50px; font-family: Arial, sans-serif;">
            <p style="font-size: 18px; color: #333;">This is an unallotted property. Its details cannot be downloaded currently.</p>
        </div>
    @endif
</body>
</html>
