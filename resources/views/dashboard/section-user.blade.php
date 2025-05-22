@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<style>
    .subtypes {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
    }

    .typeName {
        text-align: center;
    }

    .custom-col {
        flex: 1;
        margin: 0 5px;
    }

    .custom-col:first-child {
        margin-left: 0;
    }

    .custom-col:last-child {
        margin-right: 0;
    }

    .status_name {
        color: #101010;
        font-size: 16px;
        font-weight: 500;
    }

    .status_name:after {
        content: ':';
        display: inline
    }

    .status_value {
        color: #101010;
        font-size: 16px;
        font-weight: 500;
    }

    .section-row {
        display: flex;
        width: 100%;
        background: #02020200;
        justify-content: space-between;
        padding: 5px 15px;
        box-shadow: 5px 2px 8px -2px #00000066;
    }
</style>
<div class="container-fluid">
    <div class="row justify-content-between mb-3">
        <div class="col-lg-6">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Dashboard</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="colony-dropdown ms-auto">
                <div>
                    <select id="select-filter" class="form-select">
                        <option value=""> Filter by section</option>
                        @foreach ($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid dashboardcards">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="col-lg-12 col-12" style="margin-bottom: 0px;">
                    <div class="card skybluecard totalrgn">
                        <div class="card-body">
                            <div class="dashboard-card-view" id="registrationData">
                                <h4><a href="{{ route('regiserUserListings') }}" style="color: inherit">Total
                                        Registrations:
                                        <span id="reg-totalCount">{{ $registrations['totalCount'] }}</span></a></h4>
                                <div class="container-fluid">
                                    <div class="row separate-col-border">
                                        <div class="custom-col-col col-4 col-lg-2">
                                            <a
                                                href="{{ route('regiserUserListings', ['status' => Crypt::encrypt('RS_NEW')]) }}"><span
                                                    class="dashboard-label">New:</span>
                                                <span id="reg-newCount"> {{ $registrations['newCount'] }}</span>
                                            </a>
                                        </div>
                                        <div class="custom-col-col col-4 col-lg-2">
                                            <a
                                                href="{{ route('regiserUserListings', ['status' => Crypt::encrypt('RS_PEN')]) }}"><span
                                                    class="dashboard-label">Pending:</span>
                                                <span id="reg-penCount"> {{ $registrations['penCount'] }} </span>
                                            </a>
                                        </div>
                                        <div class="custom-col-col col-4 col-lg-2">
                                            <a
                                                href="{{ route('regiserUserListings', ['status' => Crypt::encrypt('RS_UREW')]) }}"><span
                                                    class="dashboard-label">Under Review:</span>
                                                <span id="reg-urewCount"> {{ $registrations['urewCount'] }}
                                                </span>
                                            </a>
                                        </div>
                                        <div class="custom-col-col col-4 col-lg-2">
                                            <a
                                                href="{{ route('regiserUserListings', ['status' => Crypt::encrypt('RS_REW')]) }}"><span
                                                    class="dashboard-label">Reviewed:</span>
                                                <span id="reg-urewCount"> {{ $registrations['rewCount'] }}
                                                </span>
                                            </a>
                                        </div>
                                        <div class="custom-col-col col-4 col-lg-2">
                                            <a
                                                href="{{ route('regiserUserListings', ['status' => Crypt::encrypt('RS_APP')]) }}"><span
                                                    class="dashboard-label">Approved:</span><span id="reg-appCount">
                                                    {{ $registrations['appCount'] }}</span></a>
                                        </div>
                                        <div class="custom-col-col col-4 col-lg-2">
                                            <a
                                                href="{{ route('regiserUserListings', ['status' => Crypt::encrypt('RS_REJ')]) }}"><span
                                                    class="dashboard-label">Rejected:</span> <span id="reg-rejCount">{{
                                                    $registrations['rejCount'] }}</span></a>
                                        </div>


                                        {{-- <div class="custom-col-col col-4 col-lg-2">
                                            <a
                                                href="{{ route('regiserUserListings', ['status' => Crypt::encrypt('RS_REW')]) }}"><span
                                                    class="dashboard-label">Review:</span> {{ $registrations['rewCount']
                                                }}</a>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-12" style="margin-bottom: 0px;">
                    <div class="card offorangecard totalApp" style="margin-bottom: 0px;">
                        <div class="card-body">
                            <div class="dashboard-card-view">
                                <h4><a href="{{ route('admin.applications') }}" style="color: inherit">Total
                                        Applications:
                                        <span id="totalAppCount">{{ $totalAppCount }}</span></a></h4>
                                <div class="container-fluid">
                                    <div class="row separate-col-border">
                                        @foreach ($statusList as $i => $status)
                                        <div class="custom-col-col col-4 col-lg-2"><a href="{{ route('admin.applications', [
                                                            'status' => Crypt::encrypt(" $status->item_code"),
                                                ]) }}"><span class="dashboard-label">{{ $status->item_name }}:</span>
                                                <span id="total-{{ $status->item_code }}">{{
                                                    isset($statusWiseCounts[$status->item_code]) ?
                                                    $statusWiseCounts[$status->item_code] : 0 }}</span></a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row mt-4">
                                @foreach ($statusList as $status)
                                <div class="custom-col-col col-4 col-lg-2">
                                    <span class="status_name">{{$status->item_name}}</span> <span
                                        class="status_value">{{isset($statusWiseCounts[$status->item_code]) ?
                                        $statusWiseCounts[$status->item_code] : 0}}</span>
                                </div>
                                @endforeach
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-4 col-12">
                <div class="card redcard">
                    <div class="card-body">
                        <h4>Section</h4>
                        @foreach($sections as $section)
                        <div class="section-row">
                            <span>{{$section->name}}</span>
                            <a href="{{route('colonywiseSectionReport',[$section->id])}}"
                                target="_blank">{{$section->property_count}}</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> --}}

            <div class="col-lg-4 col-12">
                <div class="col-lg-12 col-12" style="margin-bottom: 0px; height:100%">
                    <div class="card purplecard public_service" style="margin-bottom: 0px;">
                        <h4 class="pubser-title">Section{{$sections->count()== 1 ?'':'s'}}</h4>
                        <div class="card-body">
                            <div class="dashboard-card-view">
                                @foreach ($sections as $section)
                                    <div class="grievance-card-item">
                                        <a href="{{route('colonywiseSectionReport',[$section->id])}}"
                                            target="_blank">
                                            <div class="public-services-content">
                                                <div class="services-label">
                                                    <h4>{{$section->name}}</h4>
                                                </div>
                                                <div class="services-count">
                                                    <h4 class="services_count_text"><span id="appointmentCount">{{$section->property_count}}</span></h4>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card greycard submutCard">
                    <div class="card-body">
                        <h4>Substitution / Mutation: <span id="mutation-total">{{ isset($mutataionData['total']) ?
                                $mutataionData['total'] : 0 }}</span> </h4>
                        <div class="styled-table">
                            @foreach ($statusList as $i => $status)
                            <div class="table-item">
                                <span>
                                    <a href="#">{{ $status->item_name }}:</a>
                                </span>
                                <div class="value"><span id="mutation-{{ $status->item_code }}">{{
                                        isset($mutataionData[$status->item_code]) ? $mutataionData[$status->item_code] :
                                        0 }}</span></div>

                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card darkbluecard landusechange">
                    <div class="card-body">
                        <h4>Land Use Change: <span id="luc-total">{{ isset($lucData['total']) ? $lucData['total'] : 0
                                }}</span></h4>
                        <div class="styled-table">
                            @foreach ($statusList as $i => $status)
                            <div class="table-item">
                                <span>
                                    <a href="#">{{ $status->item_name }}:</a>
                                </span>
                                <div class="value"><span id="luc-{{ $status->item_code }}">{{
                                        isset($lucData[$status->item_code]) ? $lucData[$status->item_code] : 0 }}</span>
                                </div>

                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card bluecard conversioncard">
                    <div class="card-body">
                        <h4>Conversion: <span id="conversion-total">{{ isset($conversionData['total']) ?
                                $conversionData['total'] : 0 }}</span></h4>
                        <div class="styled-table">
                            @foreach ($statusList as $i => $status)
                            <div class="table-item">
                                <span>
                                    <a href="#">{{ $status->item_name }}:</a>
                                </span>
                                <div class="value">
                                    <span id="conversion-{{ $status->item_code }}">{{
                                        isset($conversionData[$status->item_code]) ? $conversionData[$status->item_code]
                                        : 0 }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card redcard">
                    <div class="card-body">
                        <h4>NOC: 0</h4>
                        <div class="styled-table">
                            <div class="table-item">
                                <span>
                                    <a href="#">In Process:</a>
                                </span>
                                <div class="value">
                                    <span id="">0</span>
                                </div>
                            </div>
                            <div class="table-item">
                                <span>
                                    <a href="#">Disposed:</a>
                                </span>
                                <div class="value">
                                    <span id="">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card pinkcard addedproperties">
                    <div class="card-body">
                        <div class="dashboard-card-view temp_design">
                            <h4><a href="{{ route('applicantNewProperties') }}" style="color: inherit">Added Properties:
                                    <span id="new-prop-totalCount">{{ $newProperty['totalCount'] }}</span> </a> </h4>

                            <div class="added-properties-content">
                                <div class="item-cards-col">
                                    <div class="added-status">
                                        <span class="status-added-color newStatus"></span>
                                        <a
                                                href="{{ route('applicantNewProperties', ['status' => Crypt::encrypt('RS_NEW')]) }}">
                                                <p class="cards-title-p">New</p>
                                            </a>
                                    </div>
                                    <h3 class="item-cards-count" id="new-prop-newCount">{{
                                        $newProperty['newCount'] }}</h3>
                                </div>
                                <div class="item-cards-col">
                                    <div class="added-status">
                                        <span class="status-added-color pendingStatus"></span>
                                        <a
                                                href="{{ route('applicantNewProperties', ['status' => Crypt::encrypt('RS_PEN')]) }}">

                                                <p class="cards-title-p">Pending</p>
                                            </a>
                                    </div>
                                    <h3 class="item-cards-count" id="new-prop-penCount">{{
                                        $newProperty['penCount'] }}</h3>
                                </div>
                                <div class="item-cards-col">
                                    <div class="added-status">
                                        <span class="status-added-color underreviewStatus"></span>
                                        <a
                                                href="{{ route('applicantNewProperties', ['status' => Crypt::encrypt('RS_UREW')]) }}">
                                                <p class="cards-title-p">Under Review</p>
                                            </a>
                                    </div>
                                    <h3 class="item-cards-count" id="new-prop-urewCount">{{
                                        $newProperty['urewCount'] }}</h3>
                                </div>
                                <div class="item-cards-col">
                                    <div class="added-status">
                                        <span class="status-added-color approvedStatus"></span>
                                        <a
                                                href="{{ route('applicantNewProperties', ['status' => Crypt::encrypt('RS_APP')]) }}">
                                                <p class="cards-title-p">Approved</p>
                                            </a>
                                    </div>
                                    <h3 class="item-cards-count" id="new-prop-appCount">{{
                                        $newProperty['appCount'] }}</h3>
                                </div>
                                <div class="item-cards-col">
                                    <div class="added-status">
                                        <span class="status-added-color rejectedStatus"></span>
                                        <a
                                                href="{{ route('applicantNewProperties', ['status' => Crypt::encrypt('RS_REJ')]) }}">
                                                <p class="cards-title-p">Rejected</p>
                                            </a>
                                    </div>
                                    <h3 class="item-cards-count" id="new-prop-rejCount">{{
                                        $newProperty['rejCount'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="col-lg-12 col-12" style="margin-bottom: 0px; height:100%">
                    <div class="card purplecard public_service" style="margin-bottom: 0px;">
                        <h4 class="pubser-title"><a href="{{ route('applicantNewProperties') }}"
                                style="color: inherit">Public Services:
                                <span id="publicServiceCount">{{$grievencesCount + $appointmentCount}}</span></a>
                        </h4>
                        <div class="card-body">
                            <div class="dashboard-card-view">
                                <div class="grievance-card-item">
                                    <a href="{{ route('grievance.index') }}">
                                        <div class="public-services-content">
                                            <div class="services-label">
                                                <img src="{{ asset('assets/images/WhyGrievances.svg') }}"
                                                    alt="Grievances" class="grievance-icon">
                                                <h4>Grievances</h4>
                                            </div>
                                            <div class="services-count">
                                                <h4 class="services_count_text"><span
                                                        id="appointmentCount">{{$grievencesCount}}</span></h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="grievance-card-item">
                                    <a href="{{ route('appointments.index') }}">
                                        <div class="public-services-content">
                                            <div class="services-label">
                                                <img src="{{ asset('assets/images/Schedule.svg') }}" alt="Appointments">
                                                <h4>Appointments</h4>
                                            </div>
                                            <div class="services-count">
                                                <h4 class="services_count_text"><span
                                                        id="grievencesCount">{{$appointmentCount}}</span></h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('include.alerts.ajax-alert')
    @endsection

    @section('footerScript')
    <script>
        $('#select-filter').change(function() {
                let selectedOption = $(this).val();
                if (selectedOption != "") {
                    getFilterDataforSelectedOption(selectedOption);
                    $('#select-filter option:first').text('Remove Filter').val('');
                } else {
                    let allValues = $('#select-filter option').map(function() {
                        if ($(this).val() != "")
                            return $(this).val();
                    }).get();
                    getFilterDataforSelectedOption(allValues);
                    $('#select-filter option:first').text('Filter by section').val('');
                }
            })

            function getFilterDataforSelectedOption(values) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('dashbordSectionFilter') }}",
                    data: {
                        filter: values,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#totalAppCount').html(response.totalAppCount);
                            let totalKeys = Object.keys(response.statusWiseCounts);
                            totalKeys.forEach(tk => {
                                $('#total-' + tk).html(response.statusWiseCounts[tk]);
                            })
                            let mutationKeys = Object.keys(response.mutataionData);
                            mutationKeys.forEach(mk => {
                                $('#mutation-' + mk).html(response.mutataionData[mk]);
                            })
                            let lucKeys = Object.keys(response.lucData);
                            lucKeys.forEach(lk => {
                                $('#luc-' + lk).html(response.lucData[lk]);
                            });

                            let conversionKeys = Object.keys(response.conversionData);
                            conversionKeys.forEach(ck => {
                                $('#conversion-' + ck).html(response.conversionData[ck]);
                            })

                    //registration
                    let registrationKeys = Object.keys(response.registrationData);
                    registrationKeys.forEach(rk => {
                        $('#reg-' + rk).html(response.registrationData[rk]);
                    })
                    //new properties
                    let newPropKeys = Object.keys(response.newPropertyData);
                    newPropKeys.forEach(npk => {
                        $('#new-prop-' + npk).html(response.newPropertyData[npk]);
                    })

                    //public services
                    $('#grievencesCount').html(response.grievencesCount);
                    $('#appointmentCount').html(response.appointmentCount);
                    $('#publicServiceCount').html(response.grievencesCount + response.appointmentCount);


                        } else {
                            showError(response.details);
                        }
                    },
                    error: function(response) {
                        if (response.responseJSON && response.responseJSON.message) {
                            showError(response.responseJSON.message)
                        }
                    }
                })
            }
    </script>
    @endsection