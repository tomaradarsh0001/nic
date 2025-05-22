@extends('layouts.app')

@section('title', 'Applicant Other Property Details')

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

        .property-table-infos {
            font-size: 16px;
        }

        h4.suggestedpropertytitle {
            font-size: 18px;
        }

        .grid-icons {
            font-size: 110px;
        }

        .doc-item {
            width: 140px;
            height: 145px;
            margin: 0px auto 15px;
            text-align: center;
        }

        .doc-item label {
            position: relative;
            width: 100%;
            height: 100%;
            border: 1px solid #e7e7e7;
            border-radius: 5px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        i.download_view {
            width: 25px;
            height: 25px;
            background-color: #116d6e;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            font-size: 18px;
        }

        input.property-document-approval-chk {
            width: 25px;
            height: 25px;
        }

        .grid-icon-group {
            position: absolute;
            top: 5px;
            right: 0px;
            display: flex;
            align-items: center;
            z-index: 9;
        }

        .grid-section {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 15px;
        }

        .view_docs {
            font-size: 28px;
            margin-right: 2px;
        }

        h5.icon-label {
            position: absolute;
            bottom: 0px;
            margin: 0px;
            width: 100%;
            background: #c1c1c1d9;
            padding: 5px;
            font-size: 16px;
        }
    </style>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">APPLICANT</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    {{-- <li class="breadcrumb-item">Other</li> --}}
                    <li class="breadcrumb-item active" aria-current="page">Property Details</li>
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
            <div class="part-details">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <table class="table table-bordered property-table-info">
                                <tbody>
                                    <tr>
                                        <th>Registration ID:</th>
                                        <td id="applicantNumber">{{ $data['details']->applicant_number ?? '' }}</td>
                                        <th>Registration Type:</th>
                                        <td>{{ $data['details']->user->user_type ?? '' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Full Name:</th>
                                        <td>{{ $data['details']->user->name ?? '' }}</td>
                                        <th>Mobile:</th>
                                        <td>(+ {{ $data['details']->user->country_code ?? '' }})
                                            {{ $data['details']->user->mobile_no ?? '' }}
                                        </td>

                                    </tr>

                                    <tr>

                                        <th>Email:</th>
                                        <td>
                                            {{ $data['details']->user->email ?? '' }}
                                        </td>
                                        <th>Aadhar:</th>
                                        <td> {{ $data['details']->applicantDetails->aadhar_card ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>

                                        <th>PAN:</th>
                                        <td colspan="3">
                                            {{ $data['details']->applicantDetails->pan_card ?? '' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

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
                                    @if (!empty($data['details']['flat_no']))
                                        <tr>
                                            <th>Flat Number:</th>
                                            <td rowspan="3">{{ $data['details']['flat_no'] ?? '' }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if (!empty($data['details']->applicantDetails->organization_name))
                <div class="part-title mt-2">
                    <h5>ORGANIZATION DETAILS</h5>
                </div>
                <div class="part-details">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <ul class="basic-user-details">
                                    <li><strong>Organization Name: </strong>
                                        {{ $data['details']->applicantDetails->organization_name ?? '' }}
                                    </li>
                                    <li><strong>Organization PAN: </strong>
                                        {{ $data['details']->applicantDetails->organization_pan_card ?? '' }}</li>
                                    <li><strong>Organization Address: </strong>
                                        {{ $data['details']->applicantDetails->organization_address ?? '' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="card-body">
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
                            @if (!empty($data['details']->authorised_signatory_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Authorised Signatory</td>
                                    <td><a href="{{ asset('storage/' . $data['details']->authorised_signatory_doc ?? '') }}"
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
                    <div class="float-end">
                        <a href="{{ route('mis.index', ['uId' => $data['details']->id]) }}" class="btn btn-primary ml-2" target="_blank">
                            Create Property
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


   

@endsection
@section('footerScript')


@endsection
