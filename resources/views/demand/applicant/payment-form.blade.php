@extends('layouts.app')

@section('title', 'Payment')

@section('content')

<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Payment</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <!-- <li class="breadcrumb-item" aria-current="page">Payment</li> -->
                <li class="breadcrumb-item active" aria-current="page">Payment</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>

<hr>
<div class="card">
    <div class="card-body">
        <div class="row mt-2">
            <h5 class="mb-1"> Demand Details</h5>
            <!-- <p class="mb-4">Enter Your Application Information</p> -->

        </div>


        @include('include.parts.demand-details')
    </div>
    <!-- <div class="card-footer">
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="btn btn-primary" id="submitButton1">Procced</button>
            </div>
        </div>
    </div> -->
</div>
@include('include.alerts.ajax-alert')
@endsection


@section('footerScript')
<script src="{{asset('assets/js/demandPayment.js')}}"></script>
<script src="{{asset('assets/js/addressDropdown.js')}}"></script>
@endsection