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
                                                        <div
                                                            class="ml-2 badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </div>
                                                    @break

                                                    @case('RS_NEW')
                                                        <div
                                                            class="ml-2 badge rounded-pill text-primary bg-light-primary p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </div>
                                                    @break

                                                    @case('RS_UREW')
                                                        <div
                                                            class="ml-2 badge rounded-pill text-white bg-secondary p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </div>
                                                    @break

                                                    @case('RS_REW')
                                                        <div
                                                            class="ml-2 badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </div>
                                                    @break

                                                    @case('RS_PEN')
                                                        <div
                                                            class="ml-2 badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </div>
                                                    @break

                                                    @case('RS_APP')
                                                        <div
                                                            class="ml-2 badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </div>
                                                    @break

                                                    @default
                                                        <div
                                                            class="ml-2 badge rounded-pill text-secondary bg-light p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </div>
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
                                                        <div
                                                            class="ml-2 badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </div>
                                                    @break

                                                    @case('RS_NEW')
                                                        <div
                                                            class="ml-2 badge rounded-pill text-primary bg-light-primary p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </div>
                                                    @break

                                                    @case('RS_UREW')
                                                        <div
                                                            class="ml-2 badge rounded-pill text-white bg-secondary p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </div>
                                                    @break

                                                    @case('RS_REW')
                                                        <div
                                                            class="ml-2 badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </div>
                                                    @break

                                                    @case('RS_PEN')
                                                        <div
                                                            class="ml-2 badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </div>
                                                    @break

                                                    @case('RS_APP')
                                                        <div
                                                            class="ml-2 badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </div>
                                                    @break

                                                    @default
                                                        <div
                                                            class="ml-2 badge rounded-pill text-secondary bg-light p-2 text-uppercase px-3">
                                                            {{ getStatusDetailsById($data['details']->status ?? '')->item_name }}
                                                        </div>
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
                                    @empty(!$data['details']['flat_no'])
                                        <tr>
                                            <th>Flat Number:</th>
                                            <td rowspan="3">{{ $data['details']['flat_no'] ?? '' }}</td>
                                        </tr>
                                    @endempty

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


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

                                </tr>
                            @endif
                            @if (!empty($data['details']->chain_of_ownership_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Chain Of Ownership</td>
                                    <td><a href="{{ asset('storage/' . $data['details']->chain_of_ownership_doc ?? '') }}"
                                            target="_blank" class="text-danger view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bxs-file-pdf"></i></a></td>

                                </tr>
                            @endif
                        </tbody>
                    </table>
                    @if (getStatusDetailsById($data['details']->status ?? '')->item_code != 'RS_REJ')
                    <div class="float-end">
                        <a href="{{ route('mis.index', ['rId' => $data['details']->id]) }}"
                            class="btn btn-primary ml-2" target="_blank">
                            Create Property
                        </a>
                    </div>
                @endif
                </div>
            </div>
            
        </div>
    </div>
    </div>
@endsection
@section('footerScript')

@endsection
