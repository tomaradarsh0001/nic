@extends('layouts.app')

@section('title', 'Edit Mail Settings')

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
                <li class="breadcrumb-item active" aria-current="page">Mails</li>
                <li>
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Mail</li>
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
            <h6 class="mb-0 text-uppercase tabular-record_font">Create Mail</h6>
            <a href="{{route('settings.mail.index')}}"><button class="btn btn-primary"><i class="lni lni-arrow-left"></i>Mail Listing</button></a>
        </div>
        <form class="row g-3" id="mailCreateForm" method="post" action="{{route('settings.mail.update',$configuration->id)}}">
            @csrf
            @method('PUT')
            <div class="col-md-3">
                <label for="mailAction" class="form-label">Mail Action</label>
                <input type="text" class="form-control required-for-mail-setting-create" id="mailAction"
                    name="mailAction" placeholder="Mail Action" value="{{$configuration->action}}">
                <div class="text-danger required-error-message" id="mailActionError">This field is required.</div>
            </div>
            <div class="col-md-3">
                <label for="malFrom" class="form-label">Mail From</label>
                <input type="email" class="form-control required-for-mail-setting-create" id="malFrom" name="malFrom"
                    placeholder="Enter email" value="{{$configuration->email}}">
                <div class="text-danger required-error-message" id="mailActionError">This field is required.</div>
            </div>
            <div class="col-md-3">
                <label for="mailUsername" class="form-label">Mail Username</label>
                <input type="text" class="form-control required-for-mail-setting-create" id="mailUsername"
                    name="mailUsername" placeholder="Mail Username" value="{{$configuration->key}}">
                <div class="text-danger required-error-message" id="mailActionError">This field is required.</div>
            </div>
            <div class="col-md-3">
                <label for="mailPassword" class="form-label">Mail Password</label>
                <input type="text" class="form-control required-for-mail-setting-create" id="malPassword"
                    name="mailPassword" placeholder="Mail Password" value="{{$configuration->auth_token}}">
                <div class="text-danger required-error-message" id="mailActionError">This field is required.</div>
            </div>
            <div class="col-md-3">
                <label for="mailHost" class="form-label">Mail Host</label>
                <input type="text" class="form-control required-for-mail-setting-create" id="mailHost" name="mailHost"
                    placeholder="Mail Host" value="{{$configuration->host}}">
                <div class="text-danger required-error-message" id="mailActionError">This field is required.</div>
            </div>
            <div class="col-md-3">
                <label for="mailPort" class="form-label">Mail Port</label>
                <input type="string" class="form-control required-for-mail-setting-create" id="mailPort" name="mailPort"
                    placeholder="Mail Port" value="{{$configuration->port}}">
                <div class="text-danger required-error-message" id="mailActionError">This field is required.</div>
            </div>
            <div class="col-md-3">
                <label for="mailEncryption" class="form-label">Mail Encryption</label>
                <input type="text" class="form-control required-for-mail-setting-create" id="mailEncryption"
                    name="mailEncryption" placeholder="Mail Encryption" value="{{$configuration->encryption}}">
                <div class="text-danger required-error-message" id="mailActionError">This field is required.</div>
            </div>
            <div class="col-12 py-4">
                <button type="button" id="emailButton" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>


@endsection
@section('footerScript')
<script>
    $('#emailButton').click(function () {
        let allInputFilled = true;
        $('.required-for-mail-setting-create').each(function () {
            const $input = $(this);
            const $errorMsg = $input.siblings('.required-error-message');

            if ($input.val() == '') {
                $errorMsg.show();
                allInputFilled = false;
            } else {
                $errorMsg.hide();
            }
        });
        console.log(allInputFilled);
        if (allInputFilled) {
            $('#emailButton').prop('disabled', true);
            $('#emailButton').html('Updating...');
            $('#mailCreateForm').submit();
        }
    });
</script>

@endsection