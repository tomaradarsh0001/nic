@extends('layouts.app')

@section('title', 'User Registration Details')

@section('content')
    <style>
        .pagination .active a {
            color: #ffffff !important;
        }

        .text-danger {
            display: none;
            margin-top: 3px;
        }
    </style>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">APPLICATION</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->

    <hr>

    <div class="card">
        <div class="card-body">

            <div class="container-fluid">
                <h5 class="mb-4 pt-3 text-decoration-underline">USER DETAILS</h5>
                <div class="container-fluid pb-3">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <ul class="basic-user-details">
                                <li><strong>Name: </strong> {{ $data['details']->name ?? '' }}</li>
                                <li><strong>Email: </strong> {{ $data['details']->email ?? '' }}</li>
                                <li><strong>Mobile: </strong> {{ $data['details']->mobile ?? '' }}</li>
                                <li><strong>Gender: </strong> {{ $data['details']->gender ?? '' }}</li>
                                <li><strong>S/o, D/0, Spouse: </strong>{{ $data['details']->second_name ?? '' }}</li>

                            </ul>
                        </div>
                        <div class="col-lg-6 col-12">
                            <ul class="basic-user-details">
                                <li><strong>Registration Type: </strong> {{ $data['details']->user_type ?? '' }}</li>
                                <li><strong>PAN: </strong> {{ $data['details']->pan_number ?? '' }}</li>
                                <li><strong>Aadhar: </strong>{{ $data['details']->aadhar_number ?? '' }}</li>
                                <li><strong>Address: </strong> {{ $data['details']->comm_address ?? '' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                @if (!empty($data['details']->organization_name))
                    <h5 class="mb-4 pt-3 text-decoration-underline">ORGANIZATION DETAILS</h5>
                    <div class="container-fluid pb-3">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <ul class="basic-user-details">
                                    <li><strong>Organization Name: </strong> {{ $data['details']->organization_name ?? '' }}
                                    </li>
                                    <li><strong>Organization PAN: </strong>
                                        {{ $data['details']->organization_pan_card ?? '' }}</li>
                                </ul>
                            </div>
                            <div class="col-lg-6 col-12">
                                <ul class="basic-user-details">
                                    <li><strong>Organization Address:
                                        </strong>{{ $data['details']->organization_address ?? '' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endif

                <h5 class="mb-4 pt-3 text-decoration-underline">PROPERTY DOCUMENT DETAILS</h5>
                <div class="container-fluid pb-3">
                    <table class="table table-bordered table-striped property-table-info">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Document Name</th>
                                <th>View Docs</th>
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
                                    <td><a href="{{ $data['details']->sale_deed_doc ?? '' }}" target="_blank"
                                            class="text-primary view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bx-show"></i></a></td>

                                </tr>
                            @endif
                            @if (!empty($data['details']->lease_deed_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Lease Deed</td>
                                    <td><a href="{{ $data['details']->lease_deed_doc ?? '' }}" target="_blank"
                                            class="text-primary view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bx-show"></i></a></td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->builder_buyer_agreement_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Agreement</td>
                                    <td><a href="{{ $data['details']->builder_buyer_agreement_doc ?? '' }}" target="_blank"
                                            class="text-primary view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bx-show"></i></a></td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->substitution_mutation_letter_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Substitution/Mutation Letter</td>
                                    <td><a href="{{ $data['details']->substitution_mutation_letter_doc ?? '' }}"
                                            target="_blank" class="text-primary view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bx-show"></i></a></td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->owner_lessee_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Owner Lessee</td>
                                    <td><a href="{{ $data['details']->owner_lessee_doc ?? '' }}" target="_blank"
                                            class="text-primary view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bx-show"></i></a></td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->authorised_signatory_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Authorised Signatory</td>
                                    <td><a href="{{ $data['details']->authorised_signatory_doc ?? '' }}" target="_blank"
                                            class="text-primary view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bx-show"></i></a></td>
                                </tr>
                            @endif
                            @if (!empty($data['details']->chain_of_ownership_doc))
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>Chain Of Ownership</td>
                                    <td><a href="{{ $data['details']->chain_of_ownership_doc ?? '' }}" target="_blank"
                                            class="text-primary view_docs" data-toggle="tooltip"
                                            title="View Uploaded Files"><i class="bx bx-show"></i></a></td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                <hr>
                <form id="approvalForm" method="POST" action="{{ route('approve.review.application') }}">
                    @csrf
                    <div class="container-fluid pb-3">
                        <div class="row">
                            {{-- <input type="hidden" name="emailId" id="emailId"
                                value="{{ $data['details']->email ?? '' }}">
                            <input type="hidden" name="registrationId" id="registrationId"
                                value="{{ $data['details']->id ?? '' }}">
                            <input type="hidden" name="oldPropertyId" id="oldPropertyId"
                                value="{{ $data['oldPropertyId'] ?? '' }}"> --}}
                            <input type="hidden" name="applicationMovementId" id="applicationMovementId"
                                value="{{ $data['applicationMovementId'] ?? '' }}">
                            <div class="row align-items-end">
                                @if ($data['suggestedPropertyId'])
                                    <div class="col-lg-4 col-12">
                                        <label for="PropertyID" class="form-label">Suggested Property ID</label>
                                        <input type="text" name="suggestedPropertyId" class="form-control"
                                            id="SuggestedPropertyID" placeholder="Suggested Property ID"
                                            value="{{ $data['suggestedPropertyId'] ?? '' }}" readonly>
                                    </div>
                                @endif

                                <div class="col-lg-4 col-12">
                                    <div class="btn-group">
                                        <a href="{{ route('mis.index') }}">
                                            <button type="button" id="PropertyIDSearchBtn" class="btn btn-primary ml-2">Go
                                                to MIS</button>
                                        </a>
                                    </div>
                                </div>
                                @if ($data['suggestedPropertyId'])
                                    <div class="col-lg-4 col-12">
                                        <div class="btn-group">
                                            <a
                                                href="{{ route('viewDetails', ['property' => $data['suggestedPropertyId']]) }}">
                                                <button type="button" id="PropertyIDSearchBtn"
                                                    class="btn btn-primary ml-2">Go to Details</button>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <label for="remarks" class="form-label">Enter Remark</label>
                                    <textarea id="remarks" name="remarks" placeholder="Enter Remarks" class="form-control" rows="6"></textarea>
                                    <div class="text-danger" id="errorMsg">Remark is required.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-4" style="text-align: right;">
                                    <button type="button" class="btn btn-primary" id="approveBtn"
                                        disabled>Approve</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footerScript')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var remarksTextarea = document.getElementById('remarks');
            var $approveBtn = $('#approveBtn');
            // Event listener for keypress event
            remarksTextarea.addEventListener('keypress', function(event) {
                // You can perform actions here based on the key pressed
                $approveBtn.prop('disabled', false); // Enable button
            });
        });

        $(document).ready(function() {
            var $errorMsg = $('#errorMsg');

            $('#approveBtn').click(function() {
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
                    $('#approveBtn').prop('disabled', true);
                    $('#approveBtn').html('Submitting...');
                    $('#approvalForm').submit();
                }
            });
        });
    </script>
@endsection
