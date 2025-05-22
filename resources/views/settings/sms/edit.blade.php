@extends('layouts.app')

@section('title', 'Edit Sms Settings')

@section('content')
<style>
    .required-error-message {
        display: none;
        margin-top: 3px;
    }
</style>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Settings</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Sms</li>
                <li>
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Sms</li>
                    </ol>
                </li>
            </ol>

        </nav>
    </div>
</div>
<!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->

<hr>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between pb-5">
            <h6 class="mb-0 text-uppercase tabular-record_font">Create Sms Service</h6>
            <a href="{{route('settings.sms.index')}}"><button class="btn btn-primary"><i class="lni lni-arrow-left"></i>Sms Listing</button></a>
        </div>
        <form class="row g-3" id="smsCreateForm" method="post" action="{{route('settings.sms.update',$configuration->id)}}">
            @csrf
            @method('PUT')
            @csrf
            <div class="col-md-4">
                <label for="smsAction" class="form-label">Sms Action</label>
                <input type="text" class="form-control required-for-sms-setting-create" id="smsAction"
                    name="smsAction" placeholder="Sms Action" value="{{$configuration->action}}">
                <div class="text-danger required-error-message" id="smsActionError">This field is required.</div>
            </div>
            <div class="col-md-4">
                <label for="smsVendor" class="form-label">Sms Vendor</label>
                <input type="text" class="form-control required-for-sms-setting-create" id="smsVendor"
                    name="smsVendor" placeholder="Sms Vendor" value="{{$configuration->vendor}}">
                <div class="text-danger required-error-message" id="smsVendorError">This field is required.</div>
            </div>
            <div class="col-md-4">
                <label for="smsNumber" class="form-label">Sms From</label>
                <input type="text" class="form-control required-for-sms-setting-create" id="smsNumber"
                    name="smsNumber" placeholder="Sms From" value="{{$configuration->sms_number}}">
                <div class="text-danger required-error-message" id="smsNumberError">This field is required.</div>
            </div>
            <div class="col-md-6">
                <label for="secretId" class="form-label">Secret ID</label>
                <input type="text" class="form-control required-for-sms-setting-create" id="secretId" name="secretId"
                    placeholder="Enter Secret Id" value="{{$configuration->key}}">
                <div class="text-danger required-error-message" id="smsScretIdError">This field is required.</div>
            </div>
            <div class="col-md-6">
                <label for="secretToken" class="form-label">Secret Token</label>
                <input type="text" class="form-control required-for-sms-setting-create" id="secretToken" name="secretToken"
                    placeholder="Enter Secret Id" value="{{$configuration->auth_token}}">
                <div class="text-danger required-error-message" id="smsScretTokenError">This field is required.</div>
            </div>
            
            <div class="col-md-12">
                <label for="api" class="form-label">API Endpoint</label>
                <input type="text" class="form-control required-for-sms-setting-create" id="api"
                    name="api" placeholder="Mail Password" value="{{$configuration->api}}">
                <div class="text-danger required-error-message" id="apiError">This field is required.</div>
            </div>
            <div class="col-12 py-4">
                <button type="button" id="smsButton" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>


@endsection
@section('footerScript')
<script>
    $('#smsButton').click(function () {
        let allInputFilled = true;
        $('.required-for-sms-setting-create').each(function () {
            const $input = $(this);
            const $errorMsg = $input.siblings('.required-error-message');

            if ($input.val() == '') {
                $errorMsg.show();
                allInputFilled = false;
            } else {
                $errorMsg.hide();
            }
        });
        if (allInputFilled) {
            $('#smsButton').prop('disabled', true);
            $('#smsButton').html('Updating...');
            $('#smsCreateForm').submit();
        }
    });
</script>

@endsection