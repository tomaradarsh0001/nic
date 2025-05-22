@extends('layouts.app')

@section('title', 'Application Payment')

@section('content')

<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Demand</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Payment</li>
                <li class="breadcrumb-item active" aria-current="page">Application</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>

<hr>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="form-inner">
                    <div class="form-inner-head">
                        <h3>Payment Form</h3>
                    </div>
                    <form action="{{route('applicationPaymentSubmit')}}" method="post">
                        @csrf
                        <input type="hidden" name="model_name" value="{{$model}}">
                        <input type="hidden" name="id" value="{{$id}}">
                        @php
                        $modelName = str_replace('Temp','',$model);
                        $applicaitonFor = preg_replace('/([a-z])([A-Z])/', '$1 $2', $modelName)
                        @endphp
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">Paying for </label>
                                <input type="text" value="{{$applicaitonFor}}" class="form-control" readonly>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Amount</label>
                                <input type="text" value="{{$applicationCharges}}" name="applicationCharges" class="form-control" readonly>
                            </div>
                        </div>
                        @include('include.parts.payer-details')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('footerScript')
<script src="{{asset('assets/js/addressDropdown.js')}}"></script>
@endsection