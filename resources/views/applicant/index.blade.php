@extends('layouts.app')

@section('title', 'Applicant Profile')

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
        <div class="breadcrumb-title pe-3">ACCOUNT DETAILS</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
    <hr>
    <div class="container-fluid">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                @if ($user->applicantDetails->profile_photo)
                                    <img src="{{ asset('storage/' . $user->applicantDetails->profile_photo) }}"
                                        alt="Admin" class="rounded-circle p-1 bg-primary" width="155">
                                @else
                                    <img src="{{ asset('assets/images/avatars/avatar-1.png') }}" alt="Admin"
                                        class="rounded-circle p-1 bg-primary" width="155">
                                @endif
                                <div class="mt-3">
                                    <h4>{{ $user->name ?? '' }}</h4>
                                    <p class="text-secondary mb-1">{{ $user->email ?? '' }}</p>
                                    <p class="text-muted font-size-sm">{{ $user->mobile_no ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">S/o, D/0, Spouse:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control"
                                        value="{{ $user->applicantDetails->second_name ?? '' }}" readonly />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Gender:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control"
                                        value="{{ $user->applicantDetails->gender ?? '' }}" readonly />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Pan Card:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control"
                                        value="{{ $user->applicantDetails->pan_card ?? '' }}" readonly />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Aadhaar Card:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control"
                                        value="{{ $user->applicantDetails->aadhar_card ?? '' }}" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Address:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control"
                                        value="{{ $user->applicantDetails->address ?? '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-12">

                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-custom-title">Organisation Details</h5>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Organisation Name:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control"
                                        value="{{ $user->applicantDetails->organization_name ?? '' }}" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Organisation Pan Card:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control"
                                        value="{{ $user->applicantDetails->organization_pan_card ?? '' }}" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Organisation Aadhaar Card:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control"
                                        value="{{ $user->applicantDetails->organization_address ?? '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('footerScript')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
@endsection
