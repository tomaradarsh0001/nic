@extends('layouts.app')

@section('title', 'Revision of Ground Rent')

@section('content')

<link rel="stylesheet" href="{{asset('assets/css/rgr.css')}}">

<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">RGR</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">RGR</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>
<!--end breadcrumb-->
<hr>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                @if(session('newRGR'))
                <div class="toast-container position-fixed top-3 end-0 p-3">
                    <div class="toast align-items-center text-dark bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Update RGR</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            Ground rent added successfuly. Click here to view the list<a href="{{route('completeList',['id'=>session('newRGR')])}}" class="view-icons" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg> View</a>
                        </div>
                    </div>
                </div>
                @endif
                @if(!is_null($shouldEdit))
                <div class="toast-container position-fixed top-3 end-0 p-3">
                    @if($shouldEdit['land_status_change'] > 0)
                    <div class="toast align-items-center text-dark bg-info border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Update RGR</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            Status of {{$shouldEdit['land_status_change']. ' '. ($shouldEdit['land_status_change'] > 1 ? 'properties': 'property') }} changed to free hold<a href="{{route('statusChangeList')}}" class="view-icons"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg> View</a>
                        </div>
                    </div>
                    @endif
                    @if($shouldEdit['re_entered'] > 0)
                    <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Update RGR</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            Status of {{$shouldEdit['re_entered']. ' '. ($shouldEdit['re_entered'] > 1 ? 'properties': 'property')}} changed to re-entered<a href="{{route('reenteredList')}}" class="view-icons"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg> View</a>
                        </div>
                    </div>
                    @endif
                    @if($shouldEdit['area_changed'] > 0)
                    <div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Update RGR</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            Area of {{$shouldEdit['area_changed'].' '.  ($shouldEdit['area_changed'] > 1 ? 'properties': 'property')}} changed <a href="{{route('areaChangeList')}}" class="view-icons"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg> View</a>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
                <!-- @if(!is_null($shouldEdit))
            <div class="notifications">
                @if($shouldEdit['land_status_change'] > 0)
                <div class="notification">
                    <h5>
                        Status of {{$shouldEdit['land_status_change']}} properties changed &nbsp; &nbsp; <a class="hoverable" href="{{route('statusChangeList')}}">View</a> </h5>
                    </h5>
                </div>
                @endif
                @if($shouldEdit['re_entered'] > 0)
                <div class="notification">
                    <h5>
                        {{$shouldEdit['re_entered']}} Properties re-entered &nbsp; &nbsp; <a class="hoverable" href="{{route('reenteredList')}}">View</a>
                    </h5>
                    </h5>
                </div>
                @endif
                @if($shouldEdit['area_changed'] > 0)
                <div class="notification">
                    <h5>
                        Area of {{$shouldEdit['area_changed']}} Properties changed &nbsp; &nbsp; <a class="hoverable" href="{{route('areaChangeList')}}">View</a>
                    </h5>
                    </h5>
                </div>
                @endif
            </div>
            @endif -->
                <div class="col">
                    <table class="table table-bordered table-info table-top RGR_table_design">
                        <thead>
                            <tr>
                                <th>Total LH Properties</th>
                                <th>Total LH Area (Sqm)</th>
                                <th>Ground Rent Received as on Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{customNumFormat($totalLeaseHoldCount)}}</td>
                                <td>{{customNumFormat(round($totalLeaseHoldarea,2))}}</td>
                                <td>__</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered table-info table-top RGR_table_design">
                        <thead>
                            <tr>
                                <th>Total Number of properties for which RGR done</th>
                                <th>Total Area of properties for whiich RGR done (Sqm.)</th>
                                <th>Total Annual GR (Revised on L&DO rates w.e.f. {{date('01.01.Y')}})</th>
                                <th>Total Annual GR (Revised on circle rates w.e.f. {{date('01.01.Y')}})</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{customNumFormat($rgrCount)}}</td>
                                <td>{{customNumFormat(round($rgrDoneArea))}}</td>
                                <td>₹{{customNumFormat($rgrLDO)}}</td>
                                <td>₹{{customNumFormat($rgrCircle)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @include('rgr.alert')
            @include('modals.view-rgr-draft')
            {{--@include('modals.rgr-edit')--}}
            <div class="w-50 d-flex flex-row mt-5 justify-content-between">
                <div>
                    <input type="radio" name="input-form-type" value="property" id="radio-property">
                    &nbsp;&nbsp;
                    <label for="radio-property">Calculate Single Property RGR</label>
                </div>
                <div>
                    <input type="radio" name="input-form-type" value="colony" id="radio-colony">
                    &nbsp;&nbsp;
                    <label for="radio-colony">Calculate Colonywise RGR</label>
                </div>
            </div>
            <div class="form-container mt-5"></div>
        </div>
    </div>
    @endsection

    @section('footerScript')
    <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
    <script>
        $(document).on('change', 'input[name="input-form-type"]', function() {
            var slectedFormType = $(this).val();
            var route = "";
            if (slectedFormType == "property") {
                route = "{{route('singlePropertyRGRInput')}}";
            }
            if (slectedFormType == "colony") {
                route = "{{route('rgrColony')}}";
            }
            if (route != "") {
                $('.form-container').load(route);
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var toastElements = document.querySelectorAll('.toast');
            toastElements.forEach(function(toastEl) {
                var toast = new bootstrap.Toast(toastEl, {
                    autohide: false,
                    delay: 5000
                });
                toast.show();
            });
        });
    </script>

    @endsection