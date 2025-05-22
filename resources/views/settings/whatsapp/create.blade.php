@extends('layouts.app')

@section('title', 'Create Whatsapp Settings')

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
                <li class="breadcrumb-item active" aria-current="page">Whatsapp</li>
                <li>
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create Whatsapp</li>
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
            <h6 class="mb-0 text-uppercase tabular-record_font">Create Whatsapp Service</h6>
            <a href="{{route('settings.whatsapp.index')}}"><button class="btn btn-primary"><i class="lni lni-arrow-left"></i>Whatsapp Listing</button></a>
        </div>
        <form class="row g-3" id="whatsappCreateForm" method="post" action="{{route('settings.whatsapp.store')}}">
            @csrf
            <div class="col-md-4">
                <label for="smsAction" class="form-label">Sms Action</label>
                <input type="text" class="form-control required-for-sms-setting-create" id="smsAction"
                    name="smsAction" placeholder="Sms Action">
                <div class="text-danger required-error-message" id="smsActionError">This field is required.</div>
            </div>
            <div class="col-md-4">
                <label for="whatsappVendor" class="form-label">Whatsapp Vendor</label>
                <input type="text" class="form-control required-for-sms-setting-create" id="whatsappVendor"
                    name="whatsappVendor" placeholder="Sms Vendor">
                <div class="text-danger required-error-message" id="whatsappVendorError">This field is required.</div>
            </div>
            <div class="col-md-4">
                <label for="whatsappNumber" class="form-label">Whatsapp From</label>
                <input type="text" class="form-control required-for-sms-setting-create" id="whatsappNumber"
                    name="whatsappNumber" placeholder="Whatsapp From">
                <div class="text-danger required-error-message" id="whatsappNumberError">This field is required.</div>
            </div>
            <div class="col-md-6">
                <label for="secretId" class="form-label">Secret ID</label>
                <input type="text" class="form-control required-for-sms-setting-create" id="secretId" name="secretId"
                    placeholder="Enter Secret Id">
                <div class="text-danger required-error-message" id="smsScretIdError">This field is required.</div>
            </div>
            <div class="col-md-6">
                <label for="secretToken" class="form-label">Secret Token</label>
                <input type="text" class="form-control required-for-sms-setting-create" id="secretToken" name="secretToken"
                    placeholder="Enter Secret Id">
                <div class="text-danger required-error-message" id="smsScretTokenError">This field is required.</div>
            </div>
            
            <div class="col-md-12">
                <label for="api" class="form-label">API Endpoint</label>
                <input type="text" class="form-control required-for-sms-setting-create" id="api"
                    name="api" placeholder="Mail Password">
                <div class="text-danger required-error-message" id="apiError">This field is required.</div>
            </div>
            <div class="col-12 py-4">
                <button type="button" id="whatsappButton" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>


@endsection
@section('footerScript')
<script>
    $('#whatsappButton').click(function () {
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
            $('#whatsappButton').prop('disabled', true);
            $('#whatsappButton').html('Submitting...');
            $('#whatsappCreateForm').submit();
        }
    });
</script>

@endsection