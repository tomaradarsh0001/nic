@extends('layouts.app')
@section('title', 'Application')
@section('content')
<style>
    .pagination .active a {
        color: #ffffff !important;
    }

    .required-error-message {
        display: none;
    }

    .required-error-message {
        margin-left: -1.5em;
        margin-top: 3px;
    }

    .form-check-inputs[type=checkbox] {
        border-radius: .25em;
    }

    .form-check .form-check-inputs {
        float: left;
        margin-left: -1.5em;
    }

    .form-check-inputs {
        width: 1.5em;
        height: 1.5em;
        margin-top: 0;
    }

    /** Added By Nitin */
    .duesDetails {
        display: flex;
    }

    .duesDetails span {
        flex: 1;
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

    /* for offic activity By Diwakar */
    div.dt-buttons {
        float: none !important;
        width: 19%;
    }

    div.dt-buttons.btn-group {
        margin-bottom: 20px;
    }

    div.dt-buttons.btn-group .btn {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .form-check .form-check-inputs {
        float: left;
        margin-left: -1.5em;
    }

    .form-check-inputs[type=checkbox] {
        border-radius: .25em;
    }

    .form-check-inputs {
        width: 1.5em;
        height: 1.5em;
        margin-top: 0;
    }

    /* Ensure responsiveness on smaller screens */
    @media (max-width: 768px) {
        div.dt-buttons.btn-group {
            flex-direction: column;
            align-items: flex-start;
        }

        div.dt-buttons.btn-group .btn {
            width: 100%;
            text-align: left;
        }
    }

    .text-muted {
        color: #6c757dad !important;
    }
</style>
<!-- dd($details, $details->documentFinal) -->
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">APPLICATION</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item">{{ $applicationType }}</li>
                <li class="breadcrumb-item active" aria-current="page">Application Details</li>
            </ol>
        </nav>
    </div>
</div>
<!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
<hr>
<div class="card">
    <div class="card-body">
        <div>
            <div class="parent_table_container pb-3">
                <table class="table report-item">
                    <tbody>

                        <tr>
                            <td>Application No: <span
                                    class="highlight_value">{{ $details->application_no ?? '' }}</span></td>
                            <td>Application Type: <span class="highlight_value">
                                    <div
                                        class="ml-2 badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
                                        {{ $applicationType }}
                                    </div>
                                </span></td>
                                <td>Application Current Satus: <span class="highlight_value">
                                    @switch(getStatusDetailsById( $details->status ?? '' )->item_code)
                                    @case('APP_REJ')
                                    <span
                                        class=" statusRejected">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </span>
                                    @break

                                    @case('APP_NEW')
                                    <span
                                        class=" statusNew">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </span>
                                    @break

                                    @case('APP_IP')
                                    <span
                                        class=" statusSecondary">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </span>
                                    @break

                                    @case('APP_OBJ')
                                    <span
                                        class=" statusObject">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </span>
                                    @break

                                    @case('APP_APR')
                                    <span
                                        class=" landtypeFreeH">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </span>
                                    @break
                                    @case('APP_HOLD')
                                    <span
                                        class="statusHold">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </span>
                                    @break

                                    @default
                                    <span
                                        class="">
                                        {{ getStatusDetailsById($details->status ?? '')->item_name }}
                                    </span>
                                    @endswitch
                                </span></td>
                            <td>Status of Applicant: <span
                                    class="highlight_value">{{ getServiceNameById($details->status_of_applicant ?? '') }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="part-title">
            <h5>Property Details</h5>
        </div>
        <div class="part-details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <table class="table table-bordered property-table-info">
                            <tbody>
                                <tr>
                                    <th>Old Property ID:</th>
                                    <td>{{ $details->old_property_id ?? '' }}</td>
                                    <th>New Property ID:</th>
                                    <td>{{ $details->new_property_id ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Property Status:</th>
                                    <td colspan="3">{{ $propertyCommonDetails['status'] ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Lease Type:</th>
                                    <td>{{ $propertyCommonDetails['leaseType'] ?? '' }}</td>
                                    <th>Lease Execution Date:</th>
                                    <td id="leaseExecutionDate"></td>
                                </tr>
                                <tr>
                                    <th>Property Type:</th>
                                    <td>{{ $propertyCommonDetails['propertyType'] ?? '' }}</td>
                                    <th>Property Sub Type:</th>
                                    <td>{{ $propertyCommonDetails['propertySubType'] ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Presently Known As:</th>
                                    <td>{{ $propertyCommonDetails['presentlyKnownAs'] ?? '' }}</td>
                                    <th>Original Lessee:</th>
                                    <td>{{ $propertyCommonDetails['inFavourOf'] ?? '' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="part-title">
            <h5>Name & Details of Registered Applicant</h5>
        </div>
        <div class="part-details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <table class="table table-bordered property-table-info">
                            <tbody>
                                <tr>
                                    <th>Applicant Number:</th>
                                    <td>{{ $user->applicantUserDetails->applicant_number ?? '' }}</td>
                                    <th>User Type:</th>
                                    <td class="text-uppercase">{{ $user->applicantUserDetails->user_sub_type ?? '' }}
                                    </td>
                                    <td rowspan="5" class="text-center"><img style="width: 120px;" src="{{ ($user->applicantUserDetails) ? asset('storage/' .$user->applicantUserDetails->profile_photo):'' }}"></td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td>
                                        {{ $user->name ?? '' }}
                                    </td>
                                    <th>Email:</th>
                                    <td>
                                        @php
                                        if ($user->email) {
                                        $useremail = $user->email;
                                        $position = strpos($useremail, '@');
                                        $email =
                                        substr($useremail, 0, 2) .
                                        str_repeat('*', $position - 2) .
                                        substr($useremail, $position);
                                        } else {
                                        $email = '';
                                        }
                                        @endphp
                                        {{ $email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Gender:</th>
                                    <td>{{ $user->applicantUserDetails->gender ?? '' }}</td>
                                    <th>{{ $user->applicantUserDetails->so_do_spouse }}:</th>
                                    <td> {{ $user->applicantUserDetails->second_name }}</td>
                                </tr>
                                <tr>
                                    <th>PAN:</th>
                                    <td>{{ $user->applicantUserDetails->pan_card
                                            ? str_repeat('*', 5) . substr($user->applicantUserDetails->pan_card, -5)
                                            : '' }}
                                    </td>
                                    <th>Aadhaar:</th>
                                    <td> {{ $user->applicantUserDetails->aadhar_card
                                            ? substr($user->applicantUserDetails->pan_card, 0, 4) .
                                                str_repeat('*', 4) .
                                                substr($user->applicantUserDetails->pan_card, -4)
                                            : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Mobile:</th>
                                    <td>{{ $user->mobile_no ? substr($user->mobile_no, 0, 3) . str_repeat('*', 4) . substr($user->mobile_no, -3) : '' }}
                                    </td>
                                    <th>Address:</th>
                                    <td class="w-50">{{ $user->applicantUserDetails->address ?? '' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($coapplicants) && count($coapplicants) > 0)
        <div class="part-title">
            <h5>Name & Details of Other Co-Applicants</h5>
        </div>
        <div class="part-details">
            <div class="container-fluid">
                <div class="row">
                    @foreach ($coapplicants as $key => $coapplicant)

                    <div class="col-lg-12 col-12 items" style="position: relative;">
                        <div
                            style="
                                position: absolute;
                                right: 10px;
                                padding: 2px 8px;
                                background: #126a6ba8;
                                border-radius: 50%;
                                color: #ffffff;
                            ">
                            {{ $key + 1 }}
                        </div>
                        <div class="parent_table_container">
                            <table class="table table-bordered property-table-info" style="margin: 5px 0px;">
                                <tbody>
                                    <tr>
                                        <td>Name: <span
                                                class="highlight_value">{{ $coapplicant->co_applicant_name }}</span>
                                        </td>
                                        <td>Gender/DOB: <span
                                                class="highlight_value">{{ $coapplicant->co_applicant_gender }}/
                                                {{ $coapplicant->co_applicant_age }}</span></td>
                                        <td>{{ $coapplicant->prefix }}: <span
                                                class="highlight_value lessee_address">{{ $coapplicant->co_applicant_father_name }}</span>
                                        </td>
                                        <td rowspan="2" class="text-center"><img style="width: 120px;height: 120px" src="{{ asset('storage/' .$coapplicant->image_path ?? '') }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Aadhaar: <span
                                                class="highlight_value">{{ $coapplicant->co_applicant_aadhar }} </span><span><a target="_blank" href="{{ asset('storage/' .$coapplicant->aadhaar_file_path ?? '') }}"> (View)</a></span>
                                        </td>
                                        <td>PAN: <span
                                                class="highlight_value">{{ $coapplicant->co_applicant_pan }}</span><span><a target="_blank" href="{{ asset('storage/' .$coapplicant->pan_file_path ?? '') }}"> (View)</a></span>
                                        </td>
                                        <td>Mobile Number: <span
                                                class="highlight_value">{{ $coapplicant->co_applicant_mobile }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Check if application type is not Deed Of Apartment then only show Details of Lease Deed - Lalit Tiwari (13/02/2025) -->
        @if (!empty($applicationType) && $applicationType != 'Deed Of Apartment')                               
            <!-- For mutation application -->
            @if (isset($details->name_as_per_lease_conv_deed))
            <div class="part-title">
                @if ($details->property_status == 952)
                <h5>Details of Conveyance Deed</h5>
                @else
                <h5>Details of Lease Deed</h5>
                @endif
            </div>
            <div class="part-details">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <table class="table table-bordered property-table-info">
                                <tbody>
                                    <tr>
                                        <th>Executed In Favour of:</th>
                                        <td>{{ $details->name_as_per_lease_conv_deed ?? '' }}</td>
                                        <th>Executed On:</th>
                                        <td id="executedOn">{{ $details->executed_on ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Regn. No.:</th>
                                        <td>{{ $details->reg_no_as_per_lease_conv_deed ?? '' }}</td>
                                        <th>Book No.:</th>
                                        <td>{{ $details->book_no_as_per_lease_conv_deed ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Volume No.:</th>
                                        <td>{{ $details->volume_no_as_per_lease_conv_deed ?? '' }}</td>
                                        <th>Page No.:</th>
                                        <td>{{ $details->page_no_as_per_lease_conv_deed ?? $details->page_no_as_per_deed }}</td>
                                    </tr>
                                    <tr>
                                        <th>Regn. Date:</th>
                                        <td id="regnDate">{{ $details->reg_date_as_per_lease_conv_deed ?? '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            
            <!-- For conversion application -->
            @if (isset($details->applicant_name))
            <div class="part-title">
                @if ($details->status == 952)
                <h5>Details of Conveyance Deed</h5>
                @else
                <h5>Details of Lease Deed</h5>
                @endif
            </div>
            <div class="part-details">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <table class="table table-bordered property-table-info">
                                <tbody>
                                    <tr>
                                        <th>Executed In Favour of:</th>
                                        <td>{{ $details->applicant_name ?? '' }}</td>
                                        <th>Executed On:</th>
                                        <td>{{ $details->executed_on ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Regn. No.:</th>
                                        <td>{{ $details->reg_no ?? '' }}</td>
                                        <th>Book No.:</th>
                                        <td>{{ $details->book_no ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Volume No.:</th>
                                        <td>{{ $details->volume_no ?? '' }}</td>
                                        <th>Page No.:</th>
                                        <td>{{ $details->page_no ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Regn. Date:</th>
                                        <td>{{ $details->reg_date ?? '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endif

        
        @if(isset($details->property_stands_mortgaged))
        @if ($details->property_stands_mortgaged == 1 || $details->is_basis_of_court_order == 1)
        <div class="part-details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <table class="table table-bordered property-table-info">
                            <tbody>
                                <tr>
                                    @if($details->property_stands_mortgaged == 1)
                                    <th>Mortgaged Remark:</th>
                                    <td>{{ $details->mortgaged_remark ?? '' }}</td>
                                    @endif
                                    @if($details->is_basis_of_court_order == 1)
                                    <th>Court Case No.:</th>
                                    <td>{{ $details->court_case_no ?? '' }}</td>
                                    <th>Court Case Details:</th>
                                    <td>{{ $details->court_case_details ?? '' }}</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endif


        <!-- for conversion application -->
        @if(isset($details->is_mortgaged))
            @if ($details->is_mortgaged == 1 || $details->is_Lease_deed_lost == 1)
                <div class="part-details">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <table class="table table-bordered property-table-info">
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <!-- for LUC application -->
        @if (isset($details->property_type_change_to))
        <div class="part-title">
            <h5>Application Details</h5>
        </div>
        <div class="part-details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <table class="table table-bordered property-table-info">
                            <tbody>
                                <tr>
                                    <td> Applicant wants to change to change use of property from <b>{{$propertyCommonDetails['propertyType']}} ({{$propertyCommonDetails['propertySubType']}})</b> to <b>{{ getServiceNameById($details->property_type_change_to) ?? '' }} ({{ getServiceNameById($details->property_subtype_change_to) ?? '' }})</b></td>
                                    {{-- <th>Property Type:</th>
                                            <td></td>
                                            <th>Property Sub Type:</th>
                                            <td>/td> --}}
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if ($applicationType == 'Deed Of Apartment')
        <!-- for DOA pplication -->

        <div class="part-title">
            <h5>Flat Details</h5>
        </div>
        <div class="part-details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-12">
                    <table class="table table-bordered property-table-info">
                                    <tbody>
                                        <tr>
                                            <th>Name:</th>
                                            <td>{{ $details->applicant_name ?? '' }}</td>
                                            <th>Communication Address:</th>
                                            <td>{{ $details->applicant_address ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Building Name:</th>
                                            <td>{{ $details->building_name ?? '' }}</td>
                                            <th>Locality:</th>
                                            <td>{{ $details->locality ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Block:</th>
                                            <td>{{ $details->block ?? '' }}</td>
                                            <th>Plot No.:</th>
                                            <td>{{ $details->plot ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Presently Known As:</th>
                                            <td>{{ $details->known_as ?? '' }}</td>
                                            <th>Flat No.:</th>
                                            <td>{{ $details->flat_number ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>is Flat not listed:</th>
                                            <td>{{ $details->flat_id ? 'True' : 'False' }}</td>
                                            <th>Name of Builder / Developer:</th>
                                            <td>{{ $details->builder_developer_name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Name Of Original Buyer:</th>
                                            <td>{{ $details->original_buyer_name ?? '' }}</td>
                                            <th>Name Of Present Occupant:</th>
                                            <td>{{ $details->present_occupant_name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Purchased From:</th>
                                            <td>{{ $details->purchased_from ?? '' }}</td>
                                            <th>Date of Purchase:</th>
                                            <td>{{ !empty($details->purchased_date) ? \Carbon\Carbon::parse($details->purchased_date)->format('d-m-Y') : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Flat Area In (Sq. Mtr.) :</th>
                                            <td>{{ $details->flat_area ?? '' }}</td>
                                            <th>Plot Area In (Sq. Mtr.) :</th>
                                            <td>{{ $details->plot_area ?? '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @php
        $currentDate = new \DateTime();
        $currentDateFormatted = $currentDate->format('Y-m-d');
        @endphp

        <!-- For Property Document Details Section- SOURAV CHAUHAN (12/Dec/2024)-->
        @include('application.admin.application_document.index')

        @php
        // $serviceType = $details->serviceType;
        $serviceType = $actionServiceType;
        @endphp

        @if($roles != 'applicant')
            <!-- For Office activity section- SOURAV CHAUHAN (12/Dec/2024) -->
            @include('application.admin.office_activity.index')
        @endif
    </div>
</div>

<!-- View Scanned Files Modal -->
<div class="modal fade" id="viewScannedFiles" data-backdrop="static" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewScannedFilesLabel">View Scanned Files</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @if ($roles == 'section-officer') onclick='checkScannedFiles()' @endif></button>
            </div>
            <div class="modal-body">
                @if ($scannedFiles)
                <ul class="files-link">
                    @foreach ($scannedFiles['files'] as $scannedFile)
                    <li><a href="{{ $scannedFiles['baseUrl'] }}{{ $scannedFile }}"
                            target="_blank">{{ $scannedFile }}</a></li>
                    @endforeach
                </ul>
                @else
                <p class="text-danger fs-4">No scanned files available.</p>
                @endif
            </div>
            <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @if ($roles == 'section-officer') onclick='checkScannedFiles()' @endif>Close</button>
            </div>
        </div>
    </div>
</div>

<!-- object action confirmation modal -->
<div class="modal fade" id="objectConfirmation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title">Are You Sure?</h5> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- <div class="modal-body">
                                                                                                                                Please give remark.
                                                                                                                            </div> -->
            <div class="modal-body input-class-reject">
                <label for="rejection">Remarks</label>
                <textarea id="objectRemarkTextarea" name="remarks" class="form-control" placeholder="Remarks" rows="5"></textarea>
                <div class="error-label text-danger mt-2" style="display:none; margin-left:0px;">Please enter
                    remark.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="objectConfirmButton" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="serviceType" name="serviceType" value="{{ getServiceCodeById($serviceType) }}">
<input type="hidden" id="modalId" name="modalId" value="{{ $details->id }}">
<input type="hidden" id="applicantNo" name="applicantNo" value="{{ $details->application_no }}">
<!-- End Modal -->
@include('include.loader')
@include('include.alerts.ajax-alert')
{{-- @include('include.alerts.section.scanned-files-checked') --}} {{-- confirmation  not required anymore - Nitin 09Dec2024 --}}

<div id="spinnerOverlay" style="display:none;">
    <!-- <div class="spinner"></div> -->
    <img src="{{ asset('assets/images/chatbot_icongif.gif') }}">
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Please enter remark</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('applications.checklist') }}" id="checklistRemarkForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="applicationNo" id="applicationNo"
                        value="{{ $details->application_no }}">
                    <input type="hidden" name="type" id="type" value="0">
                    <textarea name="checklistRemark" class="form-control" placeholder="Remarks" rows="3" required=""
                        spellcheck="false"></textarea>
                    <div class="error-label text-danger mt-2" style="display:none; margin-left:0px;">Please enter
                        remark.
                    </div>
                    <input type="hidden" name="documentId" id="documentId" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitchecklistRemarkForm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="remarkScrollableModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remark</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="remarkInModal"></p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footerScript')
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script>
    function handleApplicationAction(action, applicationNo, button, remark = null) {

        var needToconfirm = ((action == 'OBJECT' || action == 'HOLD' || action == 'REJECT_APP') && remark == null);
        if (!needToconfirm) {
            let allChecked = true;
            $('.required-for-approve').each(function() {
                const $checkbox = $(this);
                const $errorMsg = $checkbox.siblings('.required-error-message');
                if (!$checkbox.is(':checked')) {
                    $errorMsg.show();
                    allChecked = false;
                } else {
                    $errorMsg.hide();
                }
            });
        
            if (allChecked) {
                $('#actionConfirmationModal').modal('show');
                $('#actionConfirmationButton').off('click').on('click', function() {
                    $('#actionConfirmationModal').modal('hide');
                    storeApplicationAction(action, applicationNo, button, remark)
                })
            
            }
        } else {
            let allChecked = true;
            $('.required-for-approve').each(function() {
                const $checkbox = $(this);
                const $errorMsg = $checkbox.siblings('.required-error-message');
                if (!$checkbox.is(':checked')) {
                    $errorMsg.show();
                    allChecked = false;
                } else {
                    $errorMsg.hide();
                }
            });

            if (allChecked) {

                // for getting the latest object remark
                $.ajax({
                    url: "{{ route('applications.object.remark') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        _token: '{{ csrf_token() }}',
                        applicationNo: applicationNo,
                    },
                    success: function(response) {
                        if (response.status === true) {
                            $('#objectRemarkTextarea').val(response.data.remark)
                        }
                    },

                });
                $('#objectConfirmation').modal('show');
                $('#objectConfirmButton').off('click').on('click', function() {
                    var confirmButton = $('#objectConfirmButton');
                    confirmButton.prop('disabled', true);
                    confirmButton.html('Submitting...');
                    var remark = $('#objectRemarkTextarea').val();
                    if (!remark) {
                        $('.error-label').css('display', 'block');
                        $('.error-label').html('Remark is requied');
                        confirmButton.prop('disabled', false);
                        confirmButton.html('Confirm');
                    } else if (remark.length >= 50) {
                        $('.error-label').css('display', 'none');
                        $('#objectConfirmation').modal('hide');
                        storeApplicationAction(action, applicationNo, button, remark)
                    } else {
                        $('.error-label').css('display', 'block');
                        $('.error-label').html('Atleast 50 characters are required.');
                        confirmButton.prop('disabled', false);
                        confirmButton.html('Confirm');
                    }
                })
            }
        }
    }


    function storeApplicationAction(action, applicationNo, button, remark) {
        let allChecked = true;
        $('.required-for-approve').each(function() {
            const $checkbox = $(this);
            const $errorMsg = $checkbox.siblings('.required-error-message');
            if (!$checkbox.is(':checked')) {
                $errorMsg.show();
                allChecked = false;
            } else {
                $errorMsg.hide();
            }
        });

        if (allChecked) {
            /** code modified by Nitin as we need to disable everything once user click a button  - 13 Dec 2024*/
            const spinnerOverlay = document.getElementById('spinnerOverlay');
            const actionButtonContainer = document.getElementById('action-btn-container');
            spinnerOverlay.style.display = 'flex';
            actionButtonContainer.style.display = 'none';

            var buttonOriginalText = $(button).html(); //Added by NItin - In case of error, we need to restore original text of Button - 12 Dec 2024
            $(button).prop('disabled', true);
            $(button).html('Submitting...');
            //Check Property link with other applicant.
            $.ajax({
                url: "{{ route('applications.action') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    _token: '{{ csrf_token() }}',
                    action: action,
                    applicationNo: applicationNo,
                    modelName: '{{$application->model_name}}',
                    remark: remark
                },
                success: function(response) {
                    if (response.status === true) {
                        // spinnerOverlay.style.display = 'none';
                        showSuccess(response.message, window.location.href)
                    } else {
                        $('#checkProperty').modal('show');
                        spinnerOverlay.style.display = 'none';
                        actionButtonContainer.style.display = 'block';
                        $(button).prop('disabled', false);
                        $(button).html(buttonOriginalText);
                        showError(response.message)
                    }
                },

            });
        }
    }

    $(document).ready(function() {
        //Reject the application
        $('#rejectButton').click(function() {
            var isDocumentCorrect = $('#isDocumentCorrect');
            if (isDocumentCorrect.is(':checked')) {
                $('#isDocumentCorrectError').hide();
                var value1 = 0;
                var input1 = $('#isMISCorrect');
                if (input1.is(':checked')) {
                    value1 = 1;
                }
                var value2 = 0;
                var input2 = $('#isScanningCorrect');
                if (input2.is(':checked')) {
                    value2 = 1;
                }
                var value3 = 0;
                var input3 = $('#isDocumentCorrect');
                if (input3.is(':checked')) {
                    value3 = 1;
                }
                // Dynamically create input elements and append to the modal
                $('#modalInputs').html(`
                    <input type="hidden" id="input1" name="is_mis_checked" value="${value1}">
                    <input type="hidden" id="input2" name="is_scan_file_checked" value="${value2}">
                    <input type="hidden" id="input3" name="is_uploaded_doc_checked" value="${value3}">
                    <br>
                    `);
                $('#rejectUserStatus').modal('show');
            } else {
                $('#isDocumentCorrectError').show();
            }
        })
        // $('#approveBtn').click(function() {

        // let allChecked = true;
        // $('.required-for-approve').each(function() {
        //     const $checkbox = $(this);
        //     // console.log($checkbox);
        //     const $errorMsg = $checkbox.siblings('.required-error-message');
        //     // console.log($errorMsg);
        //     if (!$checkbox.is(':checked')) {
        //         console.log('inside if');
        //         $errorMsg.show();
        //         allChecked = false;
        //     } else {
        //         console.log('inside else');
        //         $errorMsg.hide();
        //     }
        // });
        //     if (allChecked) {
        //         console.log("inside if");
        //         //Check Property link with other applicant.
        //         var button = $('#approveBtn');
        //         var error = $('#isPropertyFree');
        //         button.prop('disabled', true);
        //         button.html('Submitting...');
        //         var propertyId = $('#SuggestedPropertyID').val();
        //         $.ajax({
        //             url: "{{ route('applications.action', ['id' => '__propertyId__']) }}"
        //                 .replace('__propertyId__', propertyId),
        //             type: "POST",
        //             dataType: "JSON",
        //             data: {
        //                 _token: '{{ csrf_token() }}',
        //             },
        //             success: function(response) {
        //                 //console.log(response);
        //                 if (response.success === true) {
        //                     $('#approvePropertyModal').modal('show');
        //                 } else {
        //                     $('#checkProperty').modal('show');
        //                     error.html(response.details)
        //                     button.prop('disabled', false);
        //                     button.html('Approve');
        //                 }
        //             },
        //             error: function(response) {
        //                 console.log(response);
        //             }
        //         });
        //     }
        // });
        $('#confirmApproveSubmit').on('click', function(e) {
            e.preventDefault();
            $('#approveBtn').prop('disabled', true);
            $('#approveBtn').html('Submitting...');
            $('#confirmApproveSubmit').prop('disabled', true);
            $('#confirmApproveSubmit').html('Submitting...');
            $('#approvalForm').submit();
        });
        $('#closeApproveModelButton').on('click', function(e) {
            e.preventDefault();
            e.preventDefault();
            $('#approveBtn').prop('disabled', false);
            $('#approveBtn').html('Approve');
        });
        $('#rejectBtn').on('click', function(e) {
            e.preventDefault();
            $('#rejectModal').modal('show');
            $('#rejectModal').modal('show');
        });
    });
    $(document).ready(function() {
        $('#isUnderReview').on('change', function() {
            if ($(this).is(':checked')) {
                $('#modelReview').modal('show');
            }
        });
        // Optionally, you can handle the closing of the modal
        $('#modelReview').on('hidden.bs.modal', function() {
            // Do something after the modal is hidden, like unchecking the checkbox if needed
            $('#isUnderReview').prop('checked', false);
        });
    });
    //confirmation for scanned files checked - Sourav Chauhan - 9/sep/2024
    $(document).ready(function() {
        $('#isScanningCorrect').on('change', function() {
            if ($(this).is(':checked')) {
                $(this).prop('checked', false);
                $('#isScanningCheckedError').text('Please check Scanned Files, Click on View Scanned Files button.').show();
            } else {
                $('#isScanningCheckedError').hide();
                $(this).prop('checked', false);
            }
        });
    });



    // Event delegation for dynamically added elements by lalit on 01/08-2024 for remarks validation
    $(document).on('click', '.confirm-reject-btn', function(event) {
        event.preventDefault();

        var form = $('#rejectUserStatusForm');
        var remarksInput = form.find('textarea[name="remarks"]');
        var remarksValue = remarksInput.val().trim();
        var errorLabel = form.find('.error-label');
        var url = "{{ route('update.registration.status', ['id' => $details->id]) }}";

        if (remarksValue === '') {
            // Show the error label if remarks are empty
            errorLabel.show();
        } else {
            // Hide the error label and submit the form via AJAX
            errorLabel.hide();

            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(), // Serialize the form data
                success: function(response) {
                    if (response.status == 'success') {
                        $('#rejectUserStatus').modal('hide');
                        $('.loader_container').addClass('d-none');
                        if ($('.results').hasClass('d-none'))
                            $('.results').removeClass('d-none');
                        showSuccess(response.message);
                    } else {
                        $('#rejectUserStatus').modal('hide');
                        $('.loader_container').addClass('d-none');
                        if ($('.results').hasClass('d-none'))
                            $('.results').removeClass('d-none');
                        showError(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error (show error message or take appropriate action)
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    });

    $(document).on('click', '.confirm-user-review-btn', function(event) {
        event.preventDefault();

        var form = $('#reviewUserRegistrationForm');
        var remarksInput = form.find('textarea[name="remarks"]');
        var remarksValue = remarksInput.val().trim();
        var errorLabel = form.find('.error-label');
        var url = "{{ route('review.user.registration', ['id' => $details->id]) }}";

        if (remarksValue === '') {
            // Show the error label if remarks are empty
            errorLabel.show();
        } else {
            // Hide the error label and submit the form via AJAX
            errorLabel.hide();

            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(), // Serialize the form data
                success: function(response) {
                    if (response.status == 'success') {
                        // Handle success response
                        $('#modelReview').modal('hide');
                        $('.loader_container').addClass('d-none');
                        if ($('.results').hasClass('d-none'))
                            $('.results').removeClass('d-none');
                        showSuccess(response.message);
                        // Ensure checkbox is checked and disabled after success
                        setTimeout(function() {
                            $('#isUnderReview').prop('checked', true).prop(
                                'disabled', true);
                        }, 500); // Slight delay to ensure modal is fully hidden
                    } else {
                        // Handle success response
                        $('#modelReview').modal('hide');
                        $('.loader_container').addClass('d-none');
                        if ($('.results').hasClass('d-none'))
                            $('.results').removeClass('d-none');
                        showError(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error (show error message or take appropriate action)
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var remarksTextarea = document.getElementById('remarks');
        if (remarksTextarea) {
            var $reviewBtnNew = $('#reviewBtnNew');
            // Event listener for keypress event
            remarksTextarea.addEventListener('keypress', function(event) {
                // You can perform actions here based on the key pressed
                $reviewBtnNew.prop('disabled', false); // Enable button
            });
        }
    });
    $(document).ready(function() {
        var $errorMsg = $('#errorMsgNew');
        $('#reviewBtnNew').click(function() {
            var allChecked = true;
            var remark = $('#remarks').val();
            if (remark.trim() === '') {
                $errorMsg.show();
                allChecked = false;
            } else {
                $errorMsg.hide();
                allChecked = true;
            }
            if (allChecked) {
                $('#reviewBtnNew').prop('disabled', true);
                $('#reviewBtnNew').html('Submitting...');
                $('#approvalForm').submit();
            }
        });
    });
    $(document).ready(function() {
        // When the checkbox with name "is_uploaded_doc_checked" is checked or unchecked
        $('input[name="is_uploaded_doc_checked"]').change(function() {
            // Check if any checkbox with class "property-document-approval-chk" is unchecked
            if ($(this).prop('checked') && $('.property-document-approval-chk:not(:checked)').length >
                0) {
                // Show error message
                $('#isDocumentCorrectError').text('Please check the uploaded documents.').show();
                $(this).prop('checked', false); // Uncheck the checkbox
            } else {
                // Hide error message
                $('#isDocumentCorrectError').hide();
            }
        });
        // When any checkbox with the class "property-document-approval-chk" is checked or unchecked
        $('.property-document-approval-chk').change(function() {
            // Check if all checkboxes with class "property-document-approval-chk" are checked
            var allChecked = $('.property-document-approval-chk').length === $(
                '.property-document-approval-chk:checked').length;
            // Check or uncheck the checkbox with name "is_uploaded_doc_checked"

            // Hide error message if all checkboxes are checked
            if (allChecked) {
                var serviceType = $('#serviceType').val();
                var modalId = $('#modalId').val();
                var applicantNo = $('#applicantNo').val();
                $.ajax({
                    url: "{{ route('uploadedDocsChecked') }}",
                    type: "POST",
                    data: {
                        serviceType: serviceType,
                        modalId: modalId,
                        applicantNo: applicantNo,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success) {
                            $('input[name="is_uploaded_doc_checked"]').prop('checked',
                                allChecked);
                            $('#isDocumentCorrect').prop('disabled', true)
                            $('.property-document-approval-chk').prop('disabled', true)
                            $('#isDocumentCorrectError').hide();
                        } else {
                            $('.property-document-approval-chk').prop('checked', false);
                            $('#isDocumentCorrectError').show();
                            $('#isDocumentCorrectError').html('Some issue in saving');

                        }
                    }
                });
            }
        });
    });
    $(document).ready(function() {
        $('#isMISCorrect').on('change', function() {
            if ($(this).is(':checked')) {
                $(this).prop('checked', false);
                $('#misCheckedError').text('Please check MIS, Click on Go to Details button.').show();
            } else {
                $('#misCheckedError').hide();
                $(this).prop('checked', false);
            }
        });
    });

    // Comment Given below code for checking validation for upload signed letter by Lalit - 20/02/2025
    // function handleLetterUpload() {
    //     const uploadButton = document.getElementById('uploadButton');
    //     uploadButton.innerHTML = 'Uploading...';
    //     const form = document.getElementById('signedLetterForm');
    //     form.submit();
    // }

    function handleLetterUpload() {
        const fileInput = document.getElementById('signedLetter');
        const errorMessage = document.getElementById('signedLetterError');
        const uploadButton = document.getElementById('uploadButton');
        if (!fileInput.files.length) {
            document.getElementById('signedLetterError').innerHTML = "Please upload a signed letter.";
            errorMessage.style.display = 'block'; // Show error message
            return;
        } else {
            errorMessage.style.display = 'none'; // Hide error if file is selected
        }
        uploadButton.innerHTML = 'Uploading...';
        const spinnerOverlay = document.getElementById('spinnerOverlay');
        spinnerOverlay.style.display = 'flex';
        const form = document.getElementById('signedLetterForm');
        form.submit();
    }

    $(document).ready(function() {
        $('#forwardToDepartment').on('change', function() {
            console.log('Called');

            if ($(this).is(':checked')) {
                $('#divForwardAppDept').show();
            } else {
                $('#divForwardAppDept').hide();
            }
        });

        $('#forwardAppForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission


            $('#forwardAppBtn').prop('disabled', true);
            $('#forwardAppBtn').html('Submitting...');

            // Clear previous error messages
            $('#forwardToError').hide();
            $('#forwardRemarkError').hide();

            // Validate form inputs
            const forwardTo = $('#forwardTo').val();
            const forwardRemark = $('#forwardRemark').val().trim();

            let isValid = true;

            if (!forwardTo) {
                $('#forwardToError').show();
                isValid = false;
                $('#forwardAppBtn').prop('disabled', false);
                $('#forwardAppBtn').html('Submit');
            }

            if (!forwardRemark) {
                $('#forwardRemarkError').show();
                isValid = false;
                $('#forwardAppBtn').prop('disabled', false);
                $('#forwardAppBtn').html('Submit');
            }

            // If validation fails, stop form submission
            if (!isValid) {
                return;
            }

            /** code modified by Nitin as we need to disable everything once user click a button  - 13 Dec 2024*/
            const spinnerOverlay = document.getElementById('spinnerOverlay');
            const actionButtonContainer = document.getElementById('action-btn-container');
            spinnerOverlay.style.display = 'flex';
            actionButtonContainer.style.display = 'none';
            // Collect form data and additional variables
            const formData = $(this).serialize() +
                `&serviceType=${encodeURIComponent($('#serviceType').val())}` +
                `&modalId=${encodeURIComponent($('#modalId').val())}` +
                `&applicantNo=${encodeURIComponent($('#applicantNo').val())}`;

            // Set up CSRF token for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Perform AJAX request
            $.ajax({
                url: "{{ route('forwardApplicationToDepartment') }}", // Your form action URL
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        $('#forwardAppForm')[0].reset(); // Reset the form
                        $('#divForwardAppDept').hide(); // Hide the div

                        showSuccess(response.message);

                        setTimeout(function() {
                            location
                                .reload(); // Reload the page after successful form submission
                        }, 500); // Slight delay to ensure modal is fully hidden
                    } else {
                        showError(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    spinnerOverlay.style.display = 'none';
                    actionButtonContainer.style.display = 'block';
                    // Handle error response
                    if (xhr.status === 422) { // Laravel validation error
                        const errors = xhr.responseJSON.errors;
                        if (errors.forwardTo) {
                            $('#forwardToError').text(errors.forwardTo[0]).show();
                        }
                        if (errors.forwardRemark) {
                            $('#forwardRemarkError').text(errors.forwardRemark[0]).show();
                        }
                    } else {
                        alert('An error occurred: ' + xhr.responseText);
                    }
                }
            });
        });

        $('#revertAppForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            $('#revertAppBtn').prop('disabled', true).text('Submitting...');
            $('#revertRemarkError').hide(); // Clear previous error messages

            const revertRemark = $('#revertRemark').val().trim();
            const serviceType = $('#serviceType').val();
            const modalId = $('#modalId').val();
            const applicantNo = $('#applicantNo').val();

            if (!revertRemark) {
                $('#revertRemarkError').show();
                $('#revertAppBtn').prop('disabled', false).text('Submit');
                return;
            }

            // Collect form data
            const revertFormData = {
                revertRemark: revertRemark,
                serviceType: serviceType,
                modalId: modalId,
                applicantNo: applicantNo,
                _token: $('meta[name="csrf-token"]').attr('content'), // CSRF Token
            };

            // Perform AJAX request
            $.ajax({
                url: "{{ route('revertApplicationToAssignee') }}",
                method: "POST",
                data: revertFormData,
                success: function(response) {
                    if (response.status === 'success') {
                        $('#revertAppForm')[0].reset(); // Reset form
                        $('#revertModal').modal('hide'); // Hide modal
                        showSuccess(response.message); // Display success notification
                        setTimeout(function() {
                            location.reload(); // Reload page
                        }, 500);
                    } else {
                        showError(response.message); // Display error notification
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) { // Laravel validation error
                        const errors = xhr.responseJSON.errors;
                        if (errors.revertRemark) {
                            $('#revertRemarkError').text(errors.revertRemark[0]).show();
                        }
                    } else {
                        alert('An error occurred: ' + xhr.responseText);
                    }
                },
                complete: function() {
                    $('#revertAppBtn').prop('disabled', false).text('Submit');
                },
            });
        });
    });

    //         document.querySelectorAll('.doc-check-no').forEach(function(radioButton) {
    //         radioButton.addEventListener('change', function() {
    //             if (this.checked) {
    //             // Get the value of the clicked radio button
    //             var radioValue = this.value;
    //             $('#documentId').val(radioValue);
    //             $('#exampleModal').modal('show');
    //         }
    //         });
    //     });

    //     $('#exampleModal').on('hidden.bs.modal', function () {
    //     // Uncheck the radio button
    //     document.querySelector('input[type="radio"][id="doc-check-no"]').checked = false;
    // });


    document.querySelectorAll('.doc-check-no').forEach(function(radioButton) {
        radioButton.addEventListener('change', function() {
            if (this.checked) {
                // Get the value of the clicked radio button
                var radioValue = this.value;

                // Set the value of the radio button into the modal
                $('#documentId').val(radioValue);

                // Store the reference of the clicked radio button
                var selectedRadioButton = this;

                // Show the modal
                $('#exampleModal').modal('show');

                // When the modal is closed, uncheck the selected radio button
                $('#exampleModal').on('hidden.bs.modal', function() {
                    selectedRadioButton.checked = false; // Uncheck the radio button
                });
            }
        });
    });


    document.querySelectorAll('.doc-check-yes').forEach(function(radioButton) {
        radioButton.addEventListener('change', function() {
            if (this.checked) {
                const spinnerOverlay = document.getElementById('spinnerOverlay');
                spinnerOverlay.style.display = 'flex';
                // Get the value of the clicked radio button
                var radioValue = this.value;
                var applicationNo = $('#applicationNo').val()
                var tableRow = document.getElementById(radioValue)
                // console.log(radioValue);


                // Call AJAX function to save data to the database
                $.ajax({
                    url: "{{ route('applications.checklist') }}", // Your Laravel route for saving the data
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        documentId: radioValue,
                        applicationNo: applicationNo,
                        type: '1'
                    },
                    success: function(response) {
                        let requiredDocDiv = tableRow.querySelector("td .notCorrectRemark");
                        if (requiredDocDiv) {
                            requiredDocDiv.style.display = "none"; // Hide the div
                        }
                        spinnerOverlay.style.display = 'none';
                        showSuccess('Data saved successfully');
                    },
                    error: function(xhr, status, error) {
                        spinnerOverlay.style.display = 'none';
                        showError('There was an error saving the data');
                        console.log(error);
                    }
                });
            }
        });
    });


    $(document).ready(function() {
        $("#submitchecklistRemarkForm").click(function() {
            var remark = $('textarea[name="checklistRemark"]').val()
            if (remark == '') {
                $('.error-label').show()
            } else {
                $('#submitchecklistRemarkForm').prop('disabled', false).text('Submiting...');
                $('.error-label').hide()
                $("#checklistRemarkForm").submit();
            }
        });
    });



    //     function checkAllYesSelected() {
    //     // Get all the "Yes" radio buttons
    //     var allYesSelected = true;

    //     document.querySelectorAll('.doc-check-yes').forEach(function(radioButton) {
    //         if (!radioButton.checked) {
    //             allYesSelected = false; // If any "Yes" radio button is not checked, disable the button
    //         }
    //     });

    //     // Enable or disable the button based on all "Yes" selections
    //     if (allYesSelected) {
    //         document.getElementById('sendProofReadingLink').disabled = false;
    //     } else {
    //         document.getElementById('sendProofReadingLink').disabled = true;
    //     }
    // }

    // // Event listeners to trigger the check when a radio button changes
    // document.querySelectorAll('.doc-check-yes, .doc-check-no').forEach(function(radioButton) {
    //     radioButton.addEventListener('change', function() {
    //         checkAllYesSelected(); // Check the radio buttons each time one is clicked
    //     });
    // });

    // // Call on page load to check the initial state of the radio buttons
    // window.onload = function() {
    //     checkAllYesSelected();
    // };


    function checkAllYesSelected() {
        var allYesSelected = true; // To track if all "Yes" radio buttons are selected
        var allRadioButtonsSelected = true; // To track if all radio button groups have a selection

        // Check if all "Yes" radio buttons are selected
        document.querySelectorAll('.doc-check-yes').forEach(function(radioButton) {
            // If any "Yes" radio button is not checked, disable the first button
            if (!radioButton.checked) {
                allYesSelected = false;
            }
        });

        // Check if every radio button group has a selection (either Yes or No)
        document.querySelectorAll('.doc-check-yes, .doc-check-no').forEach(function(radioButton) {
            // If any radio button in a group is not selected, disable the second button
            var name = radioButton.name;
            var groupSelected = document.querySelector(`input[name="${name}"]:checked`);
            if (!groupSelected) {
                allRadioButtonsSelected = false;
            }
        });

        // Enable or disable the 'sendProofReadingLink' button based on all "Yes" selections
        let sendProofReadingLink = document.getElementById('sendProofReadingLink')
        if (sendProofReadingLink) {
            sendProofReadingLink.disabled = !allYesSelected;
        }

        // Enable or disable the second button when all radio buttons (Yes or No) are selected
        let objectButton = document.getElementById('objectButton')
        if (objectButton) {
            objectButton.disabled = !allRadioButtonsSelected;
        }
    }

    // Event listeners to trigger the check when a radio button changes
    document.querySelectorAll('.doc-check-yes, .doc-check-no').forEach(function(radioButton) {
        radioButton.addEventListener('change', function() {
            checkAllYesSelected(); // Check the radio buttons each time one is clicked
        });
    });

    // Call on page load to check the initial state of the radio buttons
    window.onload = function() {
        checkAllYesSelected();
    };



    function getRemark(documentId) {
        var remark = $('#fullRemark_' + documentId).val()
        console.log(remark);

        $('.remarkInModal').html(remark)
        $('#remarkScrollableModal').modal('show');
    }



    $(document).ready(function() {
        const fileUploadBox = $('.file-upload-box');
        const fileList = $('.file-list');
        const fileInput = $('.file-upload-input');

        // Handle drag and drop events
        fileUploadBox
            .on('dragover dragenter', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('drag-over');
            })
            .on('dragleave dragend drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('drag-over');
            });

        // Handle file selection
        fileInput.on('change', function(e) {
            const files = e.target.files;

            var filesSize = files[0].size;
            
            var maxSize = 5 * 1024 * 1024;

            if (filesSize > maxSize) {
                fileList.empty()
                $('#signedLetter').val('');
                $('#signedLetterError').html('File size exceeds 5 MB. Please select a smaller file.')
            } else {
                $('#signedLetterError').html('')
                handleFiles(files);
            }
        });

        // Handle dropped files
        fileUploadBox.on('drop', function(e) {
            const files = e.originalEvent.dataTransfer.files;
            handleFiles(files);
        });

        function handleFiles(files) {
            fileList.empty()
            Array.from(files).forEach(file => {
                // Create progress bar element
                const progressBar = $('<div class="upload-progress"></div>');

                const fileItem = $(`
                        <div class="file-item">
                            <i class="fas fa-file file-icon"></i>
                            <span class="file-name" title="${file.name}">${file.name}</span>
                            <i class="fas fa-times remove-file"></i>
                            ${progressBar.prop('outerHTML')}
                        </div>
                    `);

                fileList.append(fileItem);

                // Remove progress bar after animation
                setTimeout(() => {
                    fileItem.find('.upload-progress').remove();
                }, 1000);

                // Handle file removal
                fileItem.find('.remove-file').on('click', function(e) {
                    e.stopPropagation();
                    $('#signedLetter').val('');
                    
                    fileItem.fadeOut(300, function() {
                        $(this).remove();
                    });
                });

                // Get appropriate FontAwesome icon based on file type
                const fileIcon = fileItem.find('.file-icon');
                const fileExtension = file.name.split('.').pop().toLowerCase();

                const iconMap = {
                    'pdf': 'fa-file-pdf',
                    'jpg': 'fa-file-image',
                    'jpeg': 'fa-file-image',
                    'png': 'fa-file-image',
                };

                if (iconMap[fileExtension]) {
                    fileIcon.removeClass('fa-file').addClass(iconMap[fileExtension]);
                }
            });
        }
        // Forward To Department

        // $('#forwardToDepartment').on('change', function() {
        //     if ($(this).is(':checked')) {
        //         $('#divForwardAppDept').show();
        //     } else {
        //         $('#divForwardAppDept').hide();
        //     }
        // });
        // End
    });

    /** funciton added by Nitin to automatically check scanned files */

    function checkScannedFiles() {
        $('#isScanningCorrect').prop('checked', true);
        $('#isScanningCorrect').prop('disabled', true); //user can not uncheck once checked
        saveScannedFileChecked(); // call the function to store value of scanned files
    }

    /** onclick function modified by nitin */

    // confirm and aproove Scanned files checked by section - Sourav Chauhan (09/sep/2024)
    function saveScannedFileChecked() {
        $('#confirmScannFileChecked').prop('disabled', true).html('Submitting...');
        // Serialize form data
        //let formData = $('#scannFileCheckedForm').serialize();
        // Send AJAX request
        $.ajax({
            url: "{{ route('scannedFilesChecked') }}", // Your form action URL
            type: 'POST',
            data: {
                "_token": "{{csrf_token()}}",
                'serviceType': "{{ getServiceCodeById($serviceType) }}",
                'modalId': "{{ $details->id }}",
                'applicationNo': "{{ $details->application_no }}",
            }, //formData,
            success: function(response) {
                if (response.status == 'success') {
                    // Handle success response
                    $('#ModelScannFile').modal('hide');
                    $('.loader_container').addClass('d-none');
                    if ($('.results').hasClass('d-none'))
                        $('.results').removeClass('d-none');
                    showSuccess(response.message);
                    // Ensure checkbox is checked and disabled after success
                    setTimeout(function() {
                        $('#isScanningCorrect').prop('checked', true).prop(
                            'disabled', true);
                        $('#isScanningCheckedError').text('').hide();
                    }, 500); // Slight delay to ensure modal is fully hidden
                } else {
                    // Handle success response
                    $('#ModelScannFile').modal('hide');
                    $('.loader_container').addClass('d-none');
                    if ($('.results').hasClass('d-none'))
                        $('.results').removeClass('d-none');
                    showError(response.message);
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
    };
</script>


<script>
    //for uploading files by CDV - SOURAV CHAUHAN (12/Dec/2024)
    function handleFIleUploadForCdv(file, id) {
        const spinnerOverlay = document.getElementById('spinnerOverlay');
        spinnerOverlay.style.display = 'flex';
        const baseUrl = "{{ asset('storage') }}";

        const formData = new FormData();
        formData.append('file', file); // Append the file to the FormData object
        formData.append('id', id); // Append the document id
        formData.append('_token', '{{ csrf_token() }}'); // Append the CSRF token

        $.ajax({
            url: "{{ route('uploadFileforCdv') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    var anchorTag = $('a[data-document-type="' + name + '"]');
                    if (anchorTag.length > 0) {
                        const newPath = baseUrl + '/' + response.path;
                        anchorTag.attr('href', newPath);
                    }
                    spinnerOverlay.style.display = 'none';
                    showSuccess('File Uploaded Successfully')
                }
            },
            error: function(response) {
                spinnerOverlay.style.display = 'none'
                showError('File Not Uploaded')
            }
        });
    }

    if(document.getElementById("leaseExecutionDate")){
        document.getElementById("leaseExecutionDate").innerText = formatDateToDDMMYYYY("{{ $propertyCommonDetails['leaseExectionDate'] ?? '' }}");
    }
    if(document.getElementById("executedOn")){
        document.getElementById("executedOn").innerText = formatDateToDDMMYYYY("{{ $details->executed_on ?? '' }}");
    }
    if(document.getElementById("regnDate")){
        document.getElementById("regnDate").innerText = formatDateToDDMMYYYY("{{ $details->reg_date_as_per_lease_conv_deed ?? '' }}");
    }
    if(document.getElementById("warningMailSentDate")){
        document.getElementById("warningMailSentDate").innerText = formatDateToDDMMYYYY("{{ $application->warning_sent_on ?? '' }}");
    }
    if(document.getElementById("scheduleDate")){
        document.getElementById("scheduleDate").innerText = formatDateToDDMMYYYY("{{ $applicationAppointmentLink['schedule_date'] ?? '' }}");
    }
    if(document.getElementById("validDate")){
        document.getElementById("validDate").innerText = formatDateToDDMMYYYY("{{ $applicationAppointmentLink['valid_till'] ?? '' }}");
    }

</script>
@endsection