@extends('layouts.app')
@section('title', 'User Registration Details')
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
    </style>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">APPLICANT DETAILS</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">Registration</li>
                    <li class="breadcrumb-item active" aria-current="page">Applicant Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="part-title">
                <h5>USER DETAILS</h5>
            </div>
            @if (!empty($data['details']->user_type) && $data['details']->user_type == 'individual')
                <div class="part-details">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <table class="table table-bordered property-table-info">
                                    <tbody>
                                        <tr>
                                            <th>Current Status:</th>
                                            <td colspan="3">
                                                @switch(getStatusDetailsById( $data['details']->status ?? '' )->item_code)
                                                    @case('RS_REJ')
                                                        <span
                                                            class="highlight_value statusRejected text-uppercase">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </span>
                                                    @break

                                                    @case('RS_NEW')
                                                        <span
                                                            class="highlight_value statusNew text-uppercase">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </span>
                                                    @break

                                                    @case('RS_UREW')
                                                        <span
                                                            class="highlight_value statusSecondary text-uppercase">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </span>
                                                    @break

                                                    @case('RS_REW')
                                                        <span
                                                            class="highlight_value statusWarning text-uppercase">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </span>
                                                    @break

                                                    @case('RS_PEN')
                                                        <span
                                                            class="ml-2 badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </span>
                                                    @break

                                                    @case('RS_APP')
                                                        <span
                                                            class="highlight_value landtypeFreeH text-uppercase">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </span>
                                                    @break

                                                    @default
                                                        <span
                                                            class="ml-2 badge rounded-pill text-secondary bg-light p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </span>
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Registration ID:</th>
                                            <td id="applicantNumber">{{ $data['details']->applicant_number ?? '' }}</td>
                                            <th>Registration Type:</th>
                                            <td>{{ $data['details']->user_type ?? '' }}</td>
                                            @if (!empty($data['details']->profile_photo))
                                                <td rowspan="6" class="text-center"><img style="width: 120px;"
                                                        src="{{ asset('storage/' . $data['details']->profile_photo ?? '') }}">
                                                </td>
                                            @endif
                                        </tr>

                                        <tr>
                                            <th>Full Name:</th>
                                            <td>{{ $data['details']->name ?? '' }}</td>
                                            <th>Gender:</th>
                                            <td>{{ $data['details']->gender ?? '' }}</td>

                                        </tr>

                                        <tr>
                                            <th>Mobile:</th>
                                            <td>({{ '+ ' . $data['details']->country_code ?? 'Not Available' }})
                                                {{ $data['details']->mobile ? substr($data['details']->mobile, 0, 3) . str_repeat('*', 4) . substr($data['details']->mobile, -3) : '' }}
                                            </td>
                                            <th>Email:</th>
                                            <td>
                                                @php
                                                    if ($data['details']->email) {
                                                        $useremail = $data['details']->email;
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
                                            <th>{{ $data['details']->prefix ?? '' }} :</th>
                                            <td>{{ $data['details']->second_name ?? '' }}</td>
                                            <th>PAN:</th>
                                            <td>{{ $data['details']->pan_number ? str_repeat('*', 5) . substr($data['details']->pan_number, -5) : '' }}
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>Aadhar:</th>
                                            <td> {{ $data['details']->aadhar_number
                                                ? substr($data['details']->aadhar_number, 0, 4) . str_repeat('*', 4) . substr($data['details']->aadhar_number, -4)
                                                : '' }}
                                            </td>
                                            <th>Address:</th>
                                            <td>{{ $data['details']->comm_address ?? '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="part-details">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <table class="table table-bordered property-table-info">
                                    <tbody>
                                        <tr>
                                            <th>Current Status:</th>
                                            <td colspan="3">
                                                @switch(getStatusDetailsById( $data['details']->status ?? '' )->item_code)
                                                    @case('RS_REJ')
                                                        <span
                                                            class="highlight_value statusRejected text-uppercase">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </span>
                                                    @break

                                                    @case('RS_NEW')
                                                        <span
                                                            class="highlight_value statusNew text-uppercase">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </span>
                                                    @break

                                                    @case('RS_UREW')
                                                        <span
                                                            class="highlight_value statusSecondary text-uppercase">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </span>
                                                    @break

                                                    @case('RS_REW')
                                                        <span
                                                            class="highlight_value statusWarning text-uppercase">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </span>
                                                    @break

                                                    @case('RS_PEN')
                                                        <span
                                                            class="ml-2 badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </span>
                                                    @break

                                                    @case('RS_APP')
                                                        <span
                                                            class="highlight_value landtypeFreeH text-uppercase">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </span>
                                                    @break

                                                    @default
                                                        <span
                                                            class="ml-2 badge rounded-pill text-secondary bg-light p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </span>
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Registration ID:</th>
                                            <td id="applicantNumber">{{ $data['details']->applicant_number ?? '' }}</td>
                                            <th>Registration Type:</th>
                                            <td>{{ $data['details']->user_type ?? '' }}</td>
                                            @if (!empty($data['details']->profile_photo))
                                                <td rowspan="4" class="text-center"><img style="width: 120px;"
                                                        src="{{ asset('storage/' . $data['details']->profile_photo ?? '') }}">
                                                </td>
                                            @endif
                                        </tr>

                                        <tr>
                                            <th>Full Name:</th>
                                            <td>{{ $data['details']->name ?? '' }}</td>
                                            <th>Mobile:</th>
                                            <td>({{ '+ ' . $data['details']->country_code ?? 'Not Available' }})
                                                {{ $data['details']->mobile ? substr($data['details']->mobile, 0, 3) . str_repeat('*', 4) . substr($data['details']->mobile, -3) : '' }}
                                            </td>

                                        </tr>

                                        <tr>
                                            
                                            <th>Email:</th>
                                            <td>
                                                @php
                                                    if ($data['details']->email) {
                                                        $useremail = $data['details']->email;
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
                                            <th>Aadhar:</th>
                                            <td> {{ $data['details']->aadhar_number
                                                ? substr($data['details']->aadhar_number, 0, 4) . str_repeat('*', 4) . substr($data['details']->aadhar_number, -4)
                                                : '' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (!empty($data['details']->organization_name))
                <div class="part-title mt-2">
                    <h5>ORGANIZATION DETAILS</h5>
                </div>
                <div class="part-details">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <ul class="basic-user-details">
                                    <li><strong>Organization Name: </strong>
                                        {{ $data['details']->organization_name ?? '' }}
                                    </li>
                                    <li><strong>Organization PAN: </strong>
                                        {{ $data['details']->organization_pan_card ?? '' }}</li>
                                    <li><strong>Organization Address: </strong>
                                        {{ $data['details']->organization_address ?? '' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (!empty($data['oldPropertyId']))
                <div class="part-title">
                    <h5>PROPERTY DETAILS</h5>
                </div>
                <div class="part-details">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <table class="table table-bordered property-table-info">
                                    <tbody>
                                        <tr>
                                            <th>Old Property ID:</th>
                                            <td>{{ $data['oldPropertyId'] ?? '' }}</td>
                                            <th>New Property ID:</th>
                                            <td>{{ $data['uniquePropertyId'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Property Status:</th>
                                            <td colspan="3">{{ $data['propertyCommonDetails']['status'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Lease Type:</th>
                                            <td>{{ $data['propertyCommonDetails']['leaseType'] ?? '' }}</td>
                                            <th>Lease Execution Date:</th>
                                            <td id="leaseExecutionDate"></td>
                                        </tr>
                                        <tr>
                                            <th>Property Type:</th>
                                            <td>{{ $data['propertyCommonDetails']['propertyType'] ?? '' }}</td>
                                            <th>Property Sub Type:</th>
                                            <td>{{ $data['propertyCommonDetails']['propertySubType'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Presently Known As:</th>
                                            <td>{{ $data['propertyCommonDetails']['presentlyKnownAs'] ?? '' }}</td>
                                            <th>Original Lessee:</th>
                                            <td>{{ $data['propertyCommonDetails']['inFavourOf'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Locality:</th>
                                            <td>{{ $data['details']['colonyName'] ?? '' }}</td>
                                            <th>Block:</th>
                                            <td>{{ $data['details']['block'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Plot:</th>
                                            <td rowspan="3">{{ $data['details']['plot'] ?? '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="part-title">
                    <h5>PROPERTY DETAILS</h5>
                </div>
                <div class="part-details">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <table class="table table-bordered property-table-info">
                                    <tbody>
                                        <tr>
                                            <th>Locality:</th>
                                            <td>{{ $data['details']['colonyName'] ?? '' }}</td>
                                            <th>Block:</th>
                                            <td>{{ $data['details']['block'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Plot:</th>
                                            <td>{{ $data['details']['plot'] ?? '' }}</td>
                                            <th>Known As:</th>
                                            <td>{{ $data['details']['block'] . '/' . $data['details']['plot'] . '/' . $data['details']['colonyName'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Property Type:</th>
                                            <td>{{ $data['details']['propertyType'] ?? '' }}</td>
                                            <th>Property Sub Type:</th>
                                            <td>{{ $data['details']['propertySubType'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Flat Number:</th>
                                            <td rowspan="3">{{ $data['details']['flat_no'] ?? '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (!empty($data['flatDetails']->id))
                <div class="part-title">
                    <h5>FLAT DETAILS</h5>
                </div>
                <div class="part-details">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <table class="table table-bordered property-table-info">
                                    <tbody>
                                        <tr>
                                            <th>Flat ID:</th>
                                            <td>{{ $data['flatDetails']->unique_flat_id ?? '' }}</td>
                                            <th>Flat Number :</th>
                                            <td>{{ $data['flatDetails']->flat_number ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Locality:</th>
                                            <td>{{ $data['flatDetails']->colonyName ?? '' }}</td>
                                            <th>Block:</th>
                                            <td>{{ $data['flatDetails']->block ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Plot:</th>
                                            <td>{{ $data['flatDetails']->plot ?? '' }}</td>
                                            <th>Known As:</th>
                                            <td>{{ $data['flatDetails']->block . '/' . $data['flatDetails']->plot . '/' . $data['flatDetails']->colonyName }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Flat Area In (Sq. Mt.):</th>
                                            <td>{{ $data['flatDetails']->area_in_sqm ?? '' }}</td>
                                            <th>Builder Name:</th>
                                            <td>{{ $data['flatDetails']->builder_developer_name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Buyer Name:</th>
                                            <td>{{ $data['flatDetails']->original_buyer_name ?? '' }}</td>
                                            <th>Purchase Date:</th>
                                            <td>{{ $data['flatDetails']->purchase_date ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Presently Occupant:</th>
                                            <td rowspan="3">{{ $data['flatDetails']->present_occupant_name ?? '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="part-title mt-2">
                <h5>PROPERTY DOCUMENT DETAILS</h5>
            </div>
            <div class="part-details">
                <div class="container-fluid">
                    <table class="table table-bordered property-table-info">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Document Name</th>
                                <th style="text-align:center;">View Docs</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 1;
                            @endphp
                            @if (!empty($data['details']->sale_deed_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Sale Deed</td>
                                    <td style="text-align:center;"><a
                                            href="{{ asset('storage/' . $data['details']->sale_deed_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="saleDeedDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="saleDeedDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->lease_deed_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Lease Deed</td>
                                    <td style="text-align:center;">
                                        <a href="{{ asset('storage/' . $data['details']->lease_deed_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a>
                                    </td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="leaseDeedDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="leaseDeedDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->builder_buyer_agreement_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Agreement</td>
                                    <td style="text-align:center;"><a
                                            href="{{ asset('storage/' . $data['details']->builder_buyer_agreement_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="agreementDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="agreementDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->substitution_mutation_letter_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Substitution/Mutation Letter</td>
                                    <td style="text-align:center;"><a
                                            href="{{ asset('storage/' . $data['details']->substitution_mutation_letter_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="subsMutDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="subsMutDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->owner_lessee_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Owner Lessee</td>
                                    <td style="text-align:center;"><a
                                            href="{{ asset('storage/' . $data['details']->owner_lessee_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="ownerLesseeDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="ownerLesseeDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->other_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Other Document</td>
                                    <td style="text-align:center;"><a
                                            href="{{ asset('storage/' . $data['details']->other_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="ownerLesseeDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="ownerLesseeDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->authorised_signatory_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Authorised Signatory</td>
                                    <td style="text-align: center"><a
                                            href="{{ asset('storage/' . $data['details']->authorised_signatory_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="authorisedSignatoryDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="authorisedSignatoryDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->chain_of_ownership_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Chain Of Ownership</td>
                                    <td><a href="{{ asset('storage/' . $data['details']->chain_of_ownership_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input property-document-approval-chk" type="checkbox"
                                                role="switch" id="subsMutDoc"
                                                @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                @if ($roles === 'deputy-lndo') disabled @endif>
                                            <label class="form-check-label" for="subsMutDoc">Checked</label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($roles === 'section-officer')
                <div class="part-title mt-2">
                    <h5>OFFICE ACTIVITY</h5>
                </div>
                <div class="part-details">
                    <form id="approvalForm" method="POST" action="{{ route('approve.user.registration') }}">
                        @csrf
                        <div class="container-fluid pb-3">
                            <div class="row">
                                <input type="hidden" name="emailId" id="emailId"
                                    value="{{ $data['details']->email ?? '' }}">
                                <input type="hidden" name="registrationId" id="registrationId"
                                    value="{{ $data['details']->id ?? '' }}">
                                <input type="hidden" name="oldPropertyId" id="oldPropertyId"
                                    value="{{ $data['oldPropertyId'] ?? '' }}">
                                <input type="hidden" name="flatId" id="flatId"
                                    value="{{ $data['flatDetails']->id ?? '' }}">
                                <div class="mis-view-group-btn">
                                    @if ($data['suggestedPropertyId'])
                                        <div class="w-25 mob-w-100">
                                            <div class="d-flex justify-space-between items-end">
                                                <label for="PropertyID" class="form-label">Suggested Property ID</label>
                                            </div>
                                            <input type="text" name="suggestedPropertyId" class="form-control"
                                                id="SuggestedPropertyID" placeholder="Suggested Property ID"
                                                value="{{ $data['suggestedPropertyId'] ?? '' }}" readonly>

                                        </div>
                                        <div class="btn-group">
                                            <a href="javascript:void(0);" id="PropertyIDSearchBtn"
                                                class="btn btn-grey pdf-btn" data-bs-toggle="modal"
                                                data-bs-target="#viewScannedFiles">View Scanned Files <i
                                                    class="fas fa-file-pdf"></i>
                                            </a>
                                        </div>
                                        @if ($data['details']->is_property_flat)
                                            <div class="w-15">
                                                <div class="d-flex justify-space-between items-end">
                                                    <label for="flatNumber" class="form-label">Flat Id</label>
                                                </div>
                                                <input type="text" name="uniqueFlatId" class="form-control"
                                                    id="uniqueFlatId" placeholder="Flat Id"
                                                    value="{{ $data['flatDetails']->unique_flat_id ?? '' }}" readonly
                                                    style="width: 169px;">

                                            </div>
                                            <div class="w-15">
                                                <div class="d-flex justify-space-between items-end">
                                                    <label for="flatNumber" class="form-label">Flat Number</label>
                                                </div>
                                                <input type="text" name="flatNo" class="form-control" id="flatNo"
                                                    placeholder="Flat No" value="{{ $data['details']->flat_no ?? '' }}"
                                                    readonly style="width: 169px;">

                                            </div>
                                        @endif
                                        @php
                                            $modalId = $data['details']->id ?? '';
                                            $applicant_no = $data['details']->applicant_number ?? '';
                                            $masterId = $data['propertyMasterId'] ?? '';
                                            $uniquePropertyId = $data['uniquePropertyId'] ?? '';
                                            $oldPropertyId = $data['oldPropertyId'] ?? '';
                                            $sectionCode = $data['sectionCode'] ?? '';
                                            // Add Flat Id - Lalit on 06/Nov/2024
                                            $flatId = $data['flatDetails']->id ?? '';
                                            $additionalData = [
                                                // 'RS_REG',
                                                'RS_NEW_REG',
                                                $modalId,
                                                $applicant_no,
                                                $masterId,
                                                $uniquePropertyId,
                                                $oldPropertyId,
                                                $sectionCode,
                                                $flatId,
                                            ]; //service type,modalId, applicant no
                                            $additionalDataJson = json_encode($additionalData);
                                        @endphp
                                        <div class="btn-group">
                                            <a href="{{ route('viewDetails', ['property' => $data['propertyMasterId']]) }}?params={{ urlencode($additionalDataJson) }}">
                                                <button type="button" id="PropertyIDSearchBtn"
                                                    class="btn btn-primary ml-2">Go to Property
                                                    Details</button>
                                            </a>
                                        </div>
                                    @else
                                        <div class="w-25 mob-w-100">
                                            <div class="d-flex justify-space-between items-end">
                                                <label for="PropertyID" class="form-label">Suggested Property ID</label>
                                            </div>
                                            <input type="text" name="suggestedPropertyId" class="form-control"
                                                id="SuggestedPropertyID" placeholder="Suggested Property ID"
                                                value="" readonly>

                                        </div>
                                        <div class="btn-group">
                                            <a href="javascript:void(0);" id="PropertyIDSearchBtn"
                                                class="btn btn-grey pdf-btn">View Scanned Files <i
                                                    class="fas fa-file-pdf"></i>
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <a href="#">
                                                <button type="button" id="PropertyIDSearchBtn"
                                                    class="btn btn-primary ml-2" disabled>Go to Property Details</button>
                                            </a>
                                        </div>
                                        <div class="w-15">
                                            <div class="d-flex justify-space-between items-end">
                                                <label for="flatNumber" class="form-label">Flat Id</label>
                                            </div>
                                            <input type="text" name="uniqueFlatId" class="form-control"
                                                id="uniqueFlatId" placeholder="Flat Id"
                                                value="{{ $data['flatDetails']->unique_flat_id ?? '' }}" readonly
                                                style="width: 169px;">

                                        </div>
                                        <div class="w-15">
                                            <div class="d-flex justify-space-between items-end">
                                                <label for="flatNumber" class="form-label">Flat Number</label>
                                            </div>
                                            <input type="text" name="flatNo" class="form-control" id="flatNo"
                                                placeholder="Flat No" value="{{ $data['details']->flat_no ?? '' }}"
                                                readonly style="width: 169px;">

                                        </div>
                                    @endif
                                    <div class="btn-group">
                                        @if (!$data['suggestedPropertyId'] || !$data['details']->is_property_flat)
                                            @if (empty($data['suggestedPropertyId']))
                                                <a href="{{ route('mis.index') }}" class="btn btn-warning ml-2"
                                                    id="PropertyIDSearchBtn" target="_blank">Go to MIS</a>
                                            @endif
                                        @else
                                            @if (empty($data['flatDetails']->unique_flat_id))
                                                <a href="{{ route('create.flat.form', ['applicationMovementId' => $data['applicationMovementId'] ?? null]) }}" class="btn btn-warning ml-2"
                                                    id="PropertyIDSearchBtn" target="_blank">Go to MIS</a>
                                            @endif
                                        @endif
                                    </div>


                                </div>
                                @if ($data['details']->status !== getStatusName('RS_REJ'))
                                    @if ($data['details']->status !== getStatusName('RS_APP'))
                                        <div class="row pt-3">
                                            <div class="col-lg-12 mt-4">
                                                <div class="checkbox-options">
                                                    <div class="form-check form-check-success">
                                                        <label class="form-check-label" for="isUnderReview">
                                                            Send To Deputy L&DO For Review
                                                        </label>
                                                        <input class="form-check-inputs" type="checkbox" value="review"
                                                            id="isUnderReview"
                                                            @if ($data['details']->status == getStatusName('RS_UREW')) checked disabled @endif>
                                                        <div class="text-danger required-error-message">This field is
                                                            required.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                @if (isset($data['details']->remarks))
                                    <div class="remark-container">
                                        <h4 class="remark-title">Remark</h4>
                                        <p class="remark-content">{{ $data['details']->remarks }}<span
                                                class="author-name"></p>
                                    </div>
                                @endif
                                <div class="row py-3">
                                    <div class="col-lg-12 mt-4">
                                        <div class="checkbox-options">
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label" for="isMISCorrect">
                                                    {{-- is MIS Checked --}}
                                                    MIS Checked
                                                </label>
                                                <input class="form-check-input required-for-approve"
                                                    @if ($checkList && $checkList->is_mis_checked == 1) checked disabled @endif
                                                    @if ($checkList) disabled @endif
                                                    name="is_mis_checked" type="checkbox" value="1"
                                                    id="isMISCorrect">
                                                <div class="text-danger required-error-message" id="misCheckedError">This
                                                    field is required.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="checkbox-options">
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label" for="isScanningCorrect">
                                                    {{-- is Property Scanned File Checked --}}
                                                    Scanned File Checked
                                                </label>
                                                <input class="form-check-input required-for-approve"
                                                    @if ($checkList && $checkList->is_scan_file_checked == 1) checked disabled @endif
                                                    name="is_scan_file_checked" type="checkbox" value="1"
                                                    id="isScanningCorrect">
                                                <div class="text-danger required-error-message"
                                                    id="isScanningCheckedError">This field is required.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="checkbox-options">
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label" for="isDocumentCorrect">
                                                    {{-- is Uploaded Documents Checked --}}
                                                    Uploaded Documents Checked
                                                </label>
                                                <input class="form-check-input required-for-approve"
                                                    @if ($checkList && $checkList->is_uploaded_doc_checked == 1) checked disabled @endif
                                                    name="is_uploaded_doc_checked" type="checkbox" value="1"
                                                    id="isDocumentCorrect">
                                                <div class="text-danger required-error-message"
                                                    id="isDocumentCorrectError">
                                                    This field is required.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (
                            $data['details']->status == getStatusName('RS_REW') ||
                                $data['details']->status == getStatusName('RS_NEW') ||
                                $data['details']->status == getStatusName('RS_PEN'))
                            <div class="row">
                                <div class="d-flex justify-content-end gap-4 col-lg-12">
                                    <button type="button" class="btn btn-primary" id="approveBtn">Approve</button>
                                    @if (Auth::user()->hasRole('section-officer') && Auth::user()->can('reject.register.user'))
                                        <button type="button" id="rejectButton" class="btn btn-danger">Reject</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            @endif
            @if ($roles === 'deputy-lndo')
                <div class="part-title mt-2">
                    <h5>OFFICE ACTIVITY</h5>
                </div>
                <div class="part-details">
                    <form id="approvalForm" method="POST" action="{{ route('approve.review.application') }}">
                        @csrf
                        <div class="container-fluid pb-3">
                            <div class="row">
                                <input type="hidden" name="applicationMovementId" id="applicationMovementId"
                                    value="{{ $data['applicationMovementId'] ?? '' }}">
                                <div class="d-flex gap-1 flex-row align-items-end ">
                                    @if ($data['suggestedPropertyId'])
                                        <div class="w-25 mob-w-100">
                                            <div class="d-flex justify-space-between items-end">
                                                <label for="PropertyID" class="form-label">Suggested Property ID</label>
                                                {{-- Comment given below code to make View Scanned File UI Simillar to Application By Lalit Tiwari (10/Jan/2025) --}}
                                                {{-- <a href="javascript:void(0);" id="PropertyIDSearchBtn"
                                                    class="pl-2 pr-4 fs-2 text-decoration-none d-flex flex-column align-items-center justify-content-end"
                                                    data-toggle="tooltip" title="View Scanned Files"
                                                    data-bs-toggle="modal" data-bs-target="#viewScannedFiles">
                                                    <i class='bx bxs-file-pdf text-danger'></i>
                                                </a> --}}
                                            </div>
                                            <input type="text" name="suggestedPropertyId" class="form-control"
                                                id="SuggestedPropertyID" placeholder="Suggested Property ID"
                                                value="{{ $data['suggestedPropertyId'] ?? '' }}" readonly>
                                        </div>
                                        <div class="btn-group">
                                            <a href="javascript:void(0);" id="PropertyIDSearchBtn"
                                                class="btn btn-grey pdf-btn" data-toggle="tooltip"
                                                title="View Scanned Files" data-bs-toggle="modal"
                                                data-bs-target="#viewScannedFiles">View Scanned Files <i
                                                    class="fas fa-file-pdf"></i>
                                            </a>
                                        </div>


                                        @if ($data['details']->is_property_flat)
                                            <div class="w-15">
                                                <div class="d-flex justify-space-between items-end">
                                                    <label for="flatNumber" class="form-label">Flat Id</label>
                                                </div>
                                                <input type="text" name="uniqueFlatId" class="form-control"
                                                    id="uniqueFlatId" placeholder="Flat Id"
                                                    value="{{ $data['flatDetails']->unique_flat_id ?? '' }}" readonly
                                                    style="width: 169px;">

                                            </div>
                                        @endif
                                        @if ($data['details']->is_property_flat)
                                            <div class="w-15">
                                                <div class="d-flex justify-space-between items-end">
                                                    <label for="flatNumber" class="form-label">Flat Number</label>
                                                </div>
                                                <input type="text" name="flatNo" class="form-control" id="flatNo"
                                                    placeholder="Flat No" value="{{ $data['details']->flat_no ?? '' }}"
                                                    readonly style="width: 169px;">

                                            </div>
                                        @endif
                                        @php
                                            $modalId = $data['details']->id ?? '';
                                            $applicant_no = $data['details']->applicant_number ?? '';
                                            $masterId = $data['propertyMasterId'] ?? '';
                                            $uniquePropertyId = $data['uniquePropertyId'] ?? '';
                                            $oldPropertyId = $data['oldPropertyId'] ?? '';
                                            $sectionCode = $data['sectionCode'] ?? '';
                                            $additionalData = [
                                                // 'RS_REG',
                                                'RS_NEW_REG',
                                                $modalId,
                                                $applicant_no,
                                                $masterId,
                                                $uniquePropertyId,
                                                $oldPropertyId,
                                                $sectionCode,
                                            ]; //service type,modalId, applicant no
                                            $additionalDataJson = json_encode($additionalData);
                                        @endphp
                                        <div class="btn-group">
                                            <a
                                                href="{{ route('viewDetails', ['property' => $data['propertyMasterId']]) }}?params={{ urlencode($additionalDataJson) }}">
                                                <button type="button" id="PropertyIDSearchBtn"
                                                    class="btn btn-primary ml-2">Go to Details</button>
                                            </a>
                                        </div>
                                    @endif
                                    {{-- @if ($data['details']->is_property_flat)
                                        <div class="btn-group">
                                            <a href="{{ route('create.flat.form') }}">
                                                <button type="button" id="PropertyIDSearchBtn"
                                                    class="btn btn-warning ml-2">Go
                                                    to MIS</button>
                                            </a>
                                        </div>
                                    @else
                                        <div class="btn-group">
                                            <a href="{{ route('mis.index') }}">
                                                <button type="button" id="PropertyIDSearchBtn"
                                                    class="btn btn-warning ml-2">Go
                                                    to MIS</button>
                                            </a>
                                        </div>
                                    @endif --}}
                                </div>
                                @if (isset($data['details']->remarks))
                                    <div class="remark-container">
                                        <h4 class="remark-title">Remark</h4>
                                        <p class="remark-content">{{ $data['details']->remarks }}<span
                                                class="author-name"></p>
                                    </div>
                                @endif
                                {{-- @if ($data['details']->status == getStatusName('RS_APP') || $data['details']->status == getStatusName('RS_REW'))
                                @else --}}
                                {{-- Date 25th September- Change this condition due to earliear only Deputy landdo officer can only see the list of review & under_review application but tester raise the issue like in dashboard we are showign all status listing so deputy landdo can see list of all so after discussion with mam we give all permisison to depute landdo --}}
                                @if ($data['details']->status == getStatusName('RS_UREW'))
                                    <div class="row">
                                        <div class="col-lg-12 mt-4">
                                            <label for="remarks" class="form-label">Enter Remark</label>
                                            <textarea id="remarks" name="remarks" placeholder="Enter Remarks" class="form-control" rows="6"></textarea>
                                            <div class="text-danger" id="errorMsgNew">Remark is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 mt-4" style="text-align: right;">
                                            <button type="button" class="btn btn-primary" id="reviewBtnNew"
                                                disabled>Reviewed</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
    </div>
    @endif
    <!-- View Scanned Files Modal -->
    <div class="modal fade" id="viewScannedFiles" data-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewScannedFilesLabel">View Scanned Files</h5>
                    @if ($roles === 'section-officer')
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            onclick="checkScannedFilesRegistration()"></button>
                    @else
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    @endif
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
                    @if ($roles === 'section-officer')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            onclick="checkScannedFilesRegistration()">Close</button>
                    @else
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @php
        $serviceType = 'RS_NEW_REG';
    @endphp
    <input type="hidden" id="serviceType" name="serviceType" value="{{ $serviceType }}">
    <input type="hidden" id="modalId" name="modalId" value="{{ $data['details']->id }}">
    <input type="hidden" id="applicantNo" name="applicantNo" value="{{ $data['details']->applicant_number }}">
    <!-- End Modal -->
    @include('include.loader')
    @include('include.alerts.ajax-alert')
    @include('include.alerts.reject-user-registration-confirmation')
    {{-- @include('include.alerts.section.scanned-files-checked') --}}
@endsection
@section('footerScript')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            //Reject the application
            $('#rejectButton').click(function() {
                let allCheckBoxChecked = true;
                $('.required-for-approve').each(function() {
                    const $checkbox = $(this);
                    // console.log($checkbox);
                    const $errorMsg = $checkbox.siblings('.required-error-message');
                    // console.log($errorMsg);
                    if (!$checkbox.is(':checked')) {
                        console.log('inside if');
                        $errorMsg.show();
                        allCheckBoxChecked = false;
                    } else {
                        console.log('inside else');
                        $errorMsg.hide();
                    }
                });
                if (allCheckBoxChecked) {
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
                }

            })
            $('#approveBtn').click(function() {
                console.log('clicked');
                let allChecked = true;
                $('.required-for-approve').each(function() {
                    const $checkbox = $(this);
                    // console.log($checkbox);
                    const $errorMsg = $checkbox.siblings('.required-error-message');
                    // console.log($errorMsg);
                    if (!$checkbox.is(':checked')) {
                        console.log('inside if');
                        $errorMsg.show();
                        allChecked = false;
                    } else {
                        console.log('inside else');
                        $errorMsg.hide();
                    }
                });
                if (allChecked) {
                    console.log("inside if");
                    //Check Property link with other applicant.
                    var button = $('#approveBtn');
                    var error = $('#isPropertyFree');
                    button.prop('disabled', true);
                    button.html('Approving...');
                    var propertyId = $('#SuggestedPropertyID').val();
                    // Introduce FlatId - Lalit on 04/Nov/2024
                    var flatId = $('#flatId').val();
                    $.ajax({
                        url: "{{ route('register.user.checkProperty') }}", // No need for dynamic parameters in the URL anymore
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            _token: '{{ csrf_token() }}', // CSRF token for Laravel security
                            id: propertyId, // Send propertyId in the request body
                            flatId: flatId // Send flatId in the request body
                        },
                        success: function(response) {
                            if (response.success === true) {
                                $('#approvePropertyModal').modal('show');
                            } else {
                                $('#checkProperty').modal('show');
                                error.html(response.details);
                                button.prop('disabled', false);
                                button.html('Approve');
                            }
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });

                }
            });
            $('#confirmApproveSubmit').on('click', function(e) {
                e.preventDefault();
                $('#approveBtn').prop('disabled', true);
                $('#approveBtn').html('Approving...');
                $('#confirmApproveSubmit').prop('disabled', true);
                $('#confirmApproveSubmit').html('Submitting...');
                $('#approvalForm').submit();
            });
            $('#approvePropertyModal').on('hidden.bs.modal', function(e) {
                $('#approveBtn').prop('disabled', false);
                $('#approveBtn').html('Approve');
            });
            // $('#closeApproveModelBtn').on('click', function(e) {
            //     e.preventDefault();
            //     e.preventDefault();
            //     $('#approveBtn').prop('disabled', false);
            //     $('#approveBtn').html('Approve');
            // });
            $('#rejectBtn').on('click', function(e) {
                e.preventDefault();
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

        function checkScannedFilesRegistration() {
            $('#isScanningCorrect').prop('checked', true);
            $('#isScanningCorrect').prop('disabled', true); //user can not uncheck once checked
            saveScannedFileCheckedRegistration(); // call the function to store value of scanned files
        }

        // confirm and aproove Scanned files checked by section - Lalit Tiwari (09/jan/2025)
        function saveScannedFileCheckedRegistration() {
            $('#confirmScannFileChecked').prop('disabled', true).html('Submitting...');
            let serviceType = $("#serviceType").val();
            let modalId = $("#modalId").val();
            let applicantNo = $("#applicantNo").val();
            // Send AJAX request
            $.ajax({
                url: "{{ route('scannedFilesChecked') }}", // Your form action URL
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'serviceType': serviceType,
                    'modalId': modalId,
                    'applicationNo': applicantNo,
                },
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

        //confirmation for scanned files checked - Lalit Tiwari - 9/Jan/2025
        $(document).ready(function() {
            $('#isScanningCorrect').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).prop('checked', false);
                    $('#isScanningCheckedError').text(
                        'Please check Scanned Files, Click on View Scanned Files button.').show();
                } else {
                    $('#isScanningCheckedError').hide();
                    $(this).prop('checked', false);
                }
            });
        });

        // Event delegation for dynamically added elements by lalit on 01/08-2024 for remarks validation
        $(document).on('click', '.confirm-reject-btn', function(event) {
            event.preventDefault();
            var confirmButton = $('#objectConfirmButton');
            confirmButton.prop('disabled', true);
            confirmButton.html('Submitting...');
            var form = $('#rejectUserStatusForm');
            var remarksInput = form.find('textarea[name="remarks"]');
            var remarksValue = remarksInput.val().trim();
            var errorLabel = form.find('.error-label');
            var url = "{{ route('update.registration.status', ['id' => $data['details']->id]) }}";
            if (!remarksValue) {
                $('.error-label').css('display', 'block');
                $('.error-label').html('Remark is requied');
                confirmButton.prop('disabled', false);
                confirmButton.html('Confirm');
            } else if (remarksValue.length >= 50) {
                $('.error-label').css('display', 'none');
                $('#objectConfirmation').modal('hide');
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
                            window.location.replace("{{ route('regiserUserListings') }}");
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
            } else {
                $('.error-label').css('display', 'block');
                $('.error-label').html('Atleast 50 characters are required.');
                confirmButton.prop('disabled', false);
                confirmButton.html('Confirm');
            }
            /*if (remarksValue === '') {
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
                            window.location.replace("{{ route('dashboard') }}");
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
            }*/
        });

        $(document).on('click', '.confirm-user-review-btn', function(event) {
            event.preventDefault();

            var form = $('#reviewUserRegistrationForm');
            var remarksInput = form.find('textarea[name="remarks"]');
            var remarksValue = remarksInput.val().trim();
            var errorLabel = form.find('.error-label');
            var url = "{{ route('review.user.registration', ['id' => $data['details']->id]) }}";

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
                $('input[name="is_uploaded_doc_checked"]').prop('checked', allChecked);
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
                            $('#isDocumentCorrect').prop('disabled', true)
                            $('.property-document-approval-chk').prop('disabled', true)
                            $('#isDocumentCorrectError').hide();
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
        if(document.getElementById("leaseExecutionDate")){
            document.getElementById("leaseExecutionDate").innerText = formatDateToDDMMYYYY("{{ $data['propertyCommonDetails']['leaseExectionDate'] ?? '' }}");
        }
    </script>
@endsection
