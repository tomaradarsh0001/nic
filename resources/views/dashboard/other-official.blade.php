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

    h6 {
        font-size: 11px !important;
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
        {{-- <div class="col-lg-6">
            <div class="colony-dropdown ms-auto">
                <div>
                    <select id="select-filter" class="form-select">
                        <option value=""> Filter by section</option>
                        @foreach($sections as $section)
                        <option value="{{$section->section_code}}">{{$section->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="container-fluid dashboardcards">
        <div class="row">

            <div class="col-lg-6 col-6">
                <div class="card offorangecard">
                    <div class="card-body">
                        <div class="dashboard-card-view">
                            <h4><a href="{{ route('admin.applicationsAssignedToUser', ['onlyCurrentApplicatinos' => 1]) }}"
                                    style="color: inherit">Applications for
                                    consideration
                                    <span id="totalAppCount">{{$assignedToUser}}</span></a></h4>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-6">
                <div class="card skybluecard">
                    <div class="card-body">
                        <div class="dashboard-card-view">
                            <h4><a href="{{ route('admin.applicationsAssignedToUser',['onlyCurrentApplicatinos'=> 2]) }}"
                                    style="color: inherit">Forwarded
                                    applications
                                    <span id="totalAppCount">{{$passed}}</span></a></h4>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('include.alerts.ajax-alert')
    @endsection

    @section('footerScript')

    @endsection