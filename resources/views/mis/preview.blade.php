@extends('layouts.app')

@section('title', 'MIS Form Details')

@section('content')
    <style>
        .pagination .active a {
            color: #ffffff !important;

        }
    </style>
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
    <!--breadcrumb-->

    <hr>

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <!-- <div class="container"> -->
                <div class="part-title">
                    <h5>BASIC DETAILS</h5>
                </div>
                <div class="part-details">
                    <div class="container-fluid">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td><b>New Property Id: </b> {{ $viewDetails->unique_propert_id }}</td>
                                    <td><b>Old Property Id: </b> {{ $viewDetails->old_propert_id }}</td>
                                </tr>
                                <tr>
                                    <td><b>More than 1 Property IDs: </b> {{ $viewDetails->is_multiple_ids ? 'Yes' : 'No' }}
                                    </td>
                                    <td><b>File No.: </b> {{ $viewDetails->file_no }}</td>
                                </tr>
                                <tr>
                                    <td><b>Computer generated file no: </b> {{ $viewDetails->unique_file_no }} </td>
                                    <td><b>Colony Name(Old): </b> {{ $viewDetails->oldColony->name }} </td>
                                </tr>
                                <tr>
                                    <td><b>Colony Name(Present):</b> {{ $viewDetails->newColony->name }} </td>
                                    <td><b>Property Status: </b> {{ $item->itemNameById($viewDetails->status) }} </td>

                                </tr>
                                <tr>
                                    <td><b>Land Type:</b> {{ $item->itemNameById($viewDetails->land_type) }}</td>
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                    
                

                <!-- <h5 class="mb-4 pt-3 text-decoration-underline">LEASE DETAILS</h5> -->
                <div class="part-title">
                    <h5>LEASE DETAILS</h5>
                </div>

                <div class="part-details">
                    <div class="container-fluid">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td><b>Type of Lease: </b>
                                        {{ $item->itemNameById($viewDetails->propertyLeaseDetail->type_of_lease) }}</td>
                                    <td><b>Date of Execution: </b> {{ $viewDetails->propertyLeaseDetail->doe }}</td>
                                </tr>
                                <tr>
                                    <td><b>Lease/Allotment No.: </b> {{ $viewDetails->lease_no ?? 'NA' }}</td>
                                    <td><b>Date of Expiration: </b>{{ $viewDetails->propertyLeaseDetail->date_of_expiration }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Date of Allotment: </b>{{ $viewDetails->propertyLeaseDetail->doa }} </td>
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
                                            Sq
                                            Meter)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Premium (Re/ Rs): </b>₹
                                        {{ $viewDetails->propertyLeaseDetail->premium ?? '0' }}.{{ $viewDetails->propertyLeaseDetail->premium_in_paisa }}{{ $viewDetails->propertyLeaseDetail->premium_in_aana }}
                                    </td>
                                    <td><b>Ground Rent (Re/ Rs):
                                        </b>₹
                                        {{ $viewDetails->propertyLeaseDetail->gr_in_re_rs ?? '0' }}.{{ $viewDetails->propertyLeaseDetail->gr_in_paisa }}{{ $viewDetails->propertyLeaseDetail->gr_in_aana }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Start Date of Ground Rent:
                                        </b>{{ $viewDetails->propertyLeaseDetail->start_date_of_gr ?? 'NA' }} </td>
                                    <td><b>RGR Duration (Yrs): </b>
                                        {{ $viewDetails->propertyLeaseDetail->rgr_duration ?? 'NA' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>First Revision of GR due on:
                                        </b>{{ $viewDetails->propertyLeaseDetail->first_rgr_due_on ?? 'NA' }} </td>
                                    <td><b>Purpose for which leased/<br> allotted (As per lease):
                                        </b>{{ $item->itemNameById($viewDetails->propertyLeaseDetail->property_type_as_per_lease) ?? 'NA' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td><b>Sub-Type (Purpose , at present):
                                        </b>{{ $item->itemNameById($viewDetails->propertyLeaseDetail->property_sub_type_as_per_lease) ?? 'NA' }}
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan=2><b>Land Use Change:
                                        </b>{{ $viewDetails->propertyLeaseDetail->is_land_use_changed ? 'Yes' : 'No' }} </td>

                                </tr>
                                <tr>
                                    <td><b>If yes,<br>Purpose for which leased/<br> allotted (As per lease):
                                        </b>{{ $item->itemNameById($viewDetails->propertyLeaseDetail->property_type_at_present) ?? 'NA' }}
                                    </td>
                                    <td><b>Sub-Type (Purpose , at present):
                                        </b>{{ $item->itemNameById($viewDetails->propertyLeaseDetail->property_sub_type_at_present) ?? 'NA' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="part-title">
                    <h5>LAND TRANSFER DETAILS</h5>
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
                                                        <!-- <b>Date: </b> -->({{ $viewDetails->propertyLeaseDetail->date_of_conveyance_deed }})
                                                        
                                                    @else
                                                        <!-- <b>Date: </b> -->({{ $date }})
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
                                                    <td>{{ $details->lessee_name }}</td>
                                                    <td>{{ $details->lessee_age }}</td>
                                                    <td>{{ $details->property_share }}</td>
                                                    <td>{{ $details->lessee_pan_no }}</td>
                                                    <td>{{ $details->lessee_aadhar_no }}</td>
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

               
                    @if(isset($flatData['flatDetails']->flat_number))
                    <!-- <h5 class="mb-4 pt-3 text-decoration-underline">FLAT DETAILS</h5> -->
                    <div class="part-title">
                        <h5>FLAT DETAILS</h5>
                    </div>

                    <div class="part-details">
                        <div class="container-fluid">
                        
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><b>Flat Id : </b>{{ $flatData['flatDetails']->unique_flat_id }}</td>
                                        <td><b>Flat File No. : </b>{{ $flatData['flatDetails']->unique_file_no }}</td>
                                        <td><b>Flat No : </b>{{ $flatData['flatDetails']->flat_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Builder / Developer Name : </b>{{ $flatData['flatDetails']->builder_developer_name }}</td>
                                        <td><b>Original Buyer Name : </b>{{ $flatData['flatDetails']->original_buyer_name }}</td>
                                        <td><b>Purchase Date : </b>{{ \Carbon\Carbon::parse($flatData['flatDetails']->purchase_date)->format('m/d/Y') }}
                                        </td>                                            </td>
                                    </tr>
                                    <tr>
                                        <td><b>Present Occupent Name : </b>{{ $flatData['flatDetails']->present_occupant_name }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                            
                    @else
                        @if (!empty($flatData['flatDetails']['flat_number']))
                        <!-- <h5 class="mb-4 pt-3 text-decoration-underline">FLAT DETAILS</h5> -->
                        <div class="part-title">
                            <h5>FLAT DETAILS</h5>
                        </div>

                        <div class="part-details">
                            <div class="container-fluid">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><b>Flat Number : </b>{{ $flatData['flatDetails']['flat_number'] }}</td>
                                            <td><b>No Mis Found For This Flat Property </b></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                                
                        @else
                            <!-- <h5 class="mb-4 pt-3 text-decoration-underline">PROPERTY STATUS DETAILS</h5> -->
                            <div class="part-title">
                                <h5>PROPERTY STATUS DETAILS</h5>
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
                                                    <td><b>Free Hold (F/H): </b>{{ $viewDetails->status == 952 ? 'Yes' : 'No' }}</td>
                                                    <td><b>Date of Conveyance Deed:
                                                        </b>{{ $viewDetails->propertyLeaseDetail->date_of_conveyance_deed ?? 'NA' }}</td>
                                                    <td>
                                                        <b>In Favour of, Name: </b>{{ implode(', ', $namesConversion) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Vaccant: </b>{{ $viewDetails->status == 1124 ? 'Yes' : 'No' }}</td>
                                                    <td><b>In Possession Of:
                                                        </b>{{ $viewDetails->propertyLeaseDetail->in_possession_of_if_vacant ?? 'NA' }}
                                                    </td>
                                                    <td><b>Date Of Transfer:
                                                        </b>{{ $viewDetails->propertyLeaseDetail->date_of_transfer ?? 'NA' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Others: </b>{{ $viewDetails->status == 1342 ? 'Yes' : 'No' }}</td>
                                                    <td><b>Remark: </b>{{ $viewDetails->propertyLeaseDetail->remarks ?? 'NA' }}</td>
                                                </tr>
                                            @else
                                                <p class="font-weight-bold">No Records Available</p>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>   
                            </div>

                            <!-- <h5 class="mb-4 pt-3 text-decoration-underline">INSPECTION & DEMAND DETAILS</h5> -->
                            <div class="part-title">
                                <h5>INSPECTION & DEMAND DETAILS</h5>
                            </div>
                            <div class="part-details">
                                <div class="container-fluid">
                                    <table class="table table-bordered">
                                        <tbody>
                                            @if ($viewDetails->propertyInspectionDemandDetail)
                                                <tr>
                                                    <td colspan=2><b>Date of Last Inspection Report:
                                                        </b>{{ $viewDetails->propertyInspectionDemandDetail->last_inspection_ir_date ?? 'NA' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Date of Last Demand Letter:
                                                        </b>{{ $viewDetails->propertyInspectionDemandDetail->last_demand_letter_date ?? 'NA' }}
                                                    </td>
                                                    <td><b>Demand ID:
                                                        </b>{{ $viewDetails->propertyInspectionDemandDetail->last_demand_id ?? 'NA' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan=2><b>Amount of Last Demand Letter:
                                                        </b>₹ {{ $viewDetails->propertyInspectionDemandDetail->last_demand_amount ?? '0' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Last Amount Received:
                                                        </b>₹
                                                        {{ $viewDetails->propertyInspectionDemandDetail->last_amount_received ?? '0' }}
                                                    </td>
                                                    <td><b>Date of Last Amount Received:
                                                        </b>{{ $viewDetails->propertyInspectionDemandDetail->last_amount_received_date ?? 'NA' }}
                                                    </td>
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
                                <h5>MISCELLANEOUS DETAILS</h5>
                            </div>
                            <div class="part-details">
                                <div class="container-fluid">
                            
                                    <table class="table table-bordered">
                                        <tbody>
                                            @if ($viewDetails->propertyMiscDetail)
                                                <tr>
                                                    <td><b>GR Revised Ever:
                                                        </B>{{ $viewDetails->propertyMiscDetail->is_gr_revised_ever ? 'Yes' : 'No' }}
                                                    </td>
                                                    <td><b>Date of GR Revised:
                                                        </b>{{ $viewDetails->propertyMiscDetail->gr_revised_date ?? 'NA' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Supplementary Lease Deed Executed:
                                                        </b>{{ $viewDetails->propertyMiscDetail->is_supplimentry_lease_deed_executed ? 'Yes' : 'No' }}
                                                    </td>
                                                    <td><b>Date of Supplementary Lease Deed Executed:
                                                        </b>{{ $viewDetails->propertyMiscDetail->supplimentry_lease_deed_executed_date ?? 'NA' }}
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td><b>Supplementary Area: </b>
                                                        {{ $viewDetails->propertyMiscDetail->supplementary_area }}
                                                        {{ $item->itemNameById($viewDetails->propertyMiscDetail->supplementary_area_unit) }}
                                                        <span
                                                            class="text-secondary">({{ $viewDetails->propertyMiscDetail->supplementary_area_in_sqm }}
                                                            Sq
                                                            Meter)</span>
                                                    </td>
                                                    <td><b>Supplementary Total Premium (in Rs):
                                                        </b>₹ {{ $viewDetails->propertyMiscDetail->supplementary_total_premium ?? '0' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Supplementary Total GR (in Rs):
                                                        </b>₹ {{ $viewDetails->propertyMiscDetail->supplementary_total_gr ?? '0' }}
                                                    </td>
                                                    <td><b>Supplementary Remark:
                                                        </b>{{ $viewDetails->propertyMiscDetail->supplementary_remark ?? 'NA' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Re-entered:
                                                        </b>{{ $viewDetails->propertyMiscDetail->is_re_rented ? 'Yes' : 'No' }}
                                                    </td>
                                                    <td><b>Date of Re-entry:
                                                        </b>{{ $viewDetails->propertyMiscDetail->re_rented_date ?? 'NA' }}
                                                    </td>
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
                                <h5>LATEST CONTACT DETAILS</h5>
                            </div>
                            <div class="part-details">
                                <div class="container-fluid">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><b>Address: </b>{{ $viewDetails->propertyContactDetail->address ?? 'NA' }}</td>
                                                <td><b>Phone No.: </b>{{ $viewDetails->propertyContactDetail->phone_no ?? 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Email: </b>{{ $viewDetails->propertyContactDetail->email ?? 'NA' }}</td>
                                                <td><b>As on Date: </b>
                                                    @if (isset($viewDetails->propertyContactDetail->as_on_date))
                                                        {{ $viewDetails->propertyContactDetail->as_on_date }}
                                                    @else
                                                        {{ $viewDetails->propertyLeaseDetail->date_of_conveyance_deed }}
                                                    @endif

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                                
                            @endif
                    @endif
                
                @if ($roles === 'section-officer')            
                    @if ($isChecked == 1)
                        <div class="d-flex pb-5 gap-1 flex-row justify-content-end align-items-end ">
                            @if ($disableButtons)
                                {{-- @if (empty($applicationStatus->permission_to) && empty($applicationStatus->remarks)) --}}
                                @if ($hideRequestEditButtons)
                                    <div class="btn-group">
                                        <button type="button" id="requestMisEdit" class="btn btn-primary ml-2">Request
                                            Edit</button>
                                    </div>
                                @endif
                                {{-- @endif --}}
                            @else
                                @if ($disableApproveButtons)
                                    <div class="btn-group">
                                        <button type="button" id="MISChecked" class="btn btn-primary ml-2">Approve</button>
                                    </div>
                                @endif

                                @php
                                    $serviceType = !empty($additionalData[0]) ? $additionalData[0] : '';
                                    $modalId = !empty($additionalData[1]) ? $additionalData[1] : '';
                                    $applicantNo = !empty($additionalData[2]) ? $additionalData[2] : '';
                                    $masterId = !empty($additionalData[3]) ? $additionalData[3] : '';
                                    $uniquePropertyId = !empty($additionalData[4]) ? $additionalData[4] : '';
                                    $oldPropertyId = !empty($additionalData[5]) ? $additionalData[5] : '';
                                    $sectionCode = !empty($additionalData[6]) ? $additionalData[6] : '';
                                    //Flat Id added by Lalit on 06/Nov/2024
                                    $flatId = !empty($flatData['flatDetails']->flat_id) ? $flatData['flatDetails']->flat_id : '';
                                    $additionalData = [
                                        $serviceType,
                                        $modalId,
                                        $applicantNo,
                                        $masterId,
                                        $uniquePropertyId,
                                        $oldPropertyId,
                                        $sectionCode,
                                        $flatId,
                                    ]; //service type,modalId, applicant no
                                    $additionalDataJson = json_encode($additionalData);
                                @endphp
                                @if(isset($flatData['flatDetails']->id))
                                    <div class="btn-group">
                                        <a
                                            href="{{ route('editFlatDetails', ['id' => $flatData['flatDetails']->id]) }}?params={{ urlencode($additionalDataJson) }}">
                                            <button type="button" class="btn btn-secondary ml-2">Edit</button>
                                        </a>
                                    </div>
                                @else
                                        @if (empty($flatData['flatDetails']['is_property_flat']))
                                            <div class="btn-group">
                                                <a
                                                    href="{{ route('editDetails', ['property' => $viewDetails->id]) }}?params={{ urlencode($additionalDataJson) }}">
                                                    <button type="button" id="PropertyIDSearchBtn"
                                                        class="btn btn-secondary ml-2">Edit</button>
                                                </a>
                                            </div>
                                        @endif
                                @endif
                            @endif
                        </div>
                    @endif
                @endif
            <!-- </div> -->
        </div>
    </div>
    @include('include.loader')
    @include('include.alerts.ajax-alert')
    @include('include.alerts.section.mis-checked')
    @include('include.alerts.section.request-mis-edit-model-popup')


@endsection


@section('footerScript')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#MISChecked').on('click', function() {
                $('#MISChecked').prop('disabled', true).html('Approving...');
                $('#MISCheckedModal').modal('show');
            });

            $('#confirmApproveMisCheckedCloseBtn').on('click', function(){
                $('#MISChecked').prop('disabled', false).html('Approve');
            })
            
            $('.btn-close').on('click', function(){
                $('#MISChecked').prop('disabled', false).html('Approve');
                $('#requestMisEdit').prop('disabled', false).html('Request Edit');
            })



            // Optionally, you can handle the closing of the modal
            $('#MISCheckedModal').on('hidden.bs.modal', function() {
                // Do something after the modal is hidden, like unchecking the checkbox if needed
                $('#MISChecked').prop('checked', false);
            });


            // confirm and aproove MIS is checked by section - Sourav Chauhan (06/sep/2024)
            $('#confirmApproveMisChecked').on('click', function(e) {
                e.preventDefault();
                $('#confirmApproveMisChecked').prop('disabled', true).html('Submitting...');
                // Serialize form data
                let formData = $('#misCheckedForm').serialize();
                // $('#misCheckedForm').submit();
                // Send AJAX request
                $.ajax({
                    url: "{{ route('approveMis') }}", // Your form action URL
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if(response.status == 'success'){
                            // Handle success response
                            $('#MISCheckedModal').modal('hide');
                            $('.loader_container').addClass('d-none');
                            if ($('.results').hasClass('d-none'))
                                $('.results').removeClass('d-none');
                            showSuccess(response.message);
                            window.location.href = "{{ url()->previous() }}";
                            // Ensure checkbox is checked and disabled after success
                            // Slight delay to ensure modal is fully hidden
                        } else {
                            // Handle success response
                            $('#MISCheckedModal').modal('hide');
                            $('.loader_container').addClass('d-none');
                            if ($('.results').hasClass('d-none'))
                                $('.results').removeClass('d-none');
                            showError(response.message);
                            window.location.href = "{{ url()->previous() }}";
                            // Ensure checkbox is checked and disabled after success
                           // Slight delay to ensure modal is fully hidden
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        $('.loader_container').addClass('d-none');
                        if ($('.results').hasClass('d-none'))
                            $('.results').removeClass('d-none');
                        if (response.responseJSON && response.responseJSON.message) {
                            showError(response.responseJSON.message)
                        }
                    }
                });
            });

            $('#requestMisEdit').on('click', function() {
                $('#requestMisEdit').prop('disabled', true).html('Requesting...');
                $('#requestMisEditModal').modal('show');
            });

            $('#confirmrequestEditMisCheckedCloseBtn').on('click', function(){
                $('#requestMisEdit').prop('disabled', false).html('Request Edit');
            })

            // confirm and request edit mis is checked by section officer - Lalit Tiwari (09/sep/2024)
            /*$('#confirmrequestEditMisChecked').on('click', function(e) {
                e.preventDefault();
                let remarks = $('#remarks').val();
                if (remarks == '') {
                    $('#remarksError').show();
                    return false;
                }
                $('#confirmrequestEditMisChecked').prop('disabled', true);
                $('#confirmrequestEditMisChecked').html('Submitting...');
                $('#requestEditMisForm').submit();
            });*/

            $('#confirmrequestEditMisChecked').on('click', function(e) {
                e.preventDefault();
                $('#confirmrequestEditMisChecked').prop('disabled', true).html('Submitting...');
                // Serialize form data
                let formData = $('#requestEditMisForm').serialize();
                // Send AJAX request
                $.ajax({
                    url: "{{ route('requestEditMis') }}", // Your form action URL
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if(response.status == 'success'){
                            // Handle success response
                            $('#requestMisEditModal').modal('hide');
                            $('.loader_container').addClass('d-none');
                            if ($('.results').hasClass('d-none'))
                                $('.results').removeClass('d-none');
                            showSuccess(response.message);
                            // Ensure checkbox is checked and disabled after success
                            setTimeout(function() {
                                location.reload();
                            }, 3000); // Slight delay to ensure modal is fully hidden
                        } else {
                            // Handle success response
                            $('#requestMisEditModal').modal('hide');
                            $('.loader_container').addClass('d-none');
                            if ($('.results').hasClass('d-none'))
                                $('.results').removeClass('d-none');
                            showError(response.message);
                            // Ensure checkbox is checked and disabled after success
                            setTimeout(function() {
                                location.reload();
                            }, 100); // Slight delay to ensure modal is fully hidden
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        $('.loader_container').addClass('d-none');
                        if ($('.results').hasClass('d-none'))
                            $('.results').removeClass('d-none');
                        if (response.responseJSON && response.responseJSON.message) {
                            showError(response.responseJSON.message)
                        }
                    }
                });
            });


        });
    </script>
@endsection
