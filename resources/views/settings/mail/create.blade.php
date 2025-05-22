@extends('layouts.app')

@section('title', 'Add Mail')

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
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item">Application Configuration</li>
                <li class="breadcrumb-item">Mail</li>
                <li class="breadcrumb-item active" aria-current="page">Add Mail</li>
                
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
        <form class="row g-3" id="mailCreateForm" method="post" action="{{route('settings.mail.store')}}">
            @csrf
            <div class="col-md-3">
                <div class="d-flex justify-content-between">
                    <label for="mailAction" class="form-label">Mail Action</label>
                    <a href="{{route('settings.action.index')}}" title="Add/ Edit Action"><i class="lni lni-circle-plus"></i></a>
                </div>
                <select class="form-select required-for-mail-setting-create" name="mailAction" id="mailAction">
                    <option value="">Select Action</option>
                    @foreach($actions as $action)
                        <option value="{{$action->item_code}}">{{$action->item_name}}</option>
                    @endforeach
                </select>
                
                <div class="text-danger required-error-message" id="mailActionError">This field is required.</div>
            </div>
            <div class="col-md-3">
                <label for="malFrom" class="form-label">Mail From</label>
                <input type="email" class="form-control required-for-mail-setting-create" id="malFrom" name="malFrom"
                    placeholder="Enter email">
                <div class="text-danger required-error-message" id="mailActionError">This field is required.</div>
            </div>
            <div class="col-md-3">
                <label for="mailUsername" class="form-label">Mail Username</label>
                <input type="text" class="form-control required-for-mail-setting-create" id="mailUsername"
                    name="mailUsername" placeholder="Mail Username">
                <div class="text-danger required-error-message" id="mailActionError">This field is required.</div>
            </div>
            <div class="col-md-3">
                <label for="mailPassword" class="form-label">Mail Password</label>
                <input type="text" class="form-control required-for-mail-setting-create" id="malPassword"
                    name="mailPassword" placeholder="Mail Password">
                <div class="text-danger required-error-message" id="mailActionError">This field is required.</div>
            </div>
            <div class="col-md-3">
                <label for="mailHost" class="form-label">Mail Host</label>
                <input type="text" class="form-control required-for-mail-setting-create" id="mailHost" name="mailHost"
                    placeholder="Mail Host">
                <div class="text-danger required-error-message" id="mailActionError">This field is required.</div>
            </div>
            <div class="col-md-3">
                <label for="mailPort" class="form-label">Mail Port</label>
                <input type="string" class="form-control required-for-mail-setting-create" id="mailPort" name="mailPort"
                    placeholder="Mail Port">
                <div class="text-danger required-error-message" id="mailActionError">This field is required.</div>
            </div>
            <div class="col-md-3">
                <label for="mailEncryption" class="form-label">Mail Encryption</label>
                <input type="text" class="form-control required-for-mail-setting-create" id="mailEncryption"
                    name="mailEncryption" placeholder="Mail Encryption">
                <div class="text-danger required-error-message" id="mailActionError">This field is required.</div>
            </div>
            <div class="col-12 py-4">
                <button type="button" id="emailButton" class="btn btn-primary">Submit</button>
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
            $('#emailButton').html('Submitting...');
            $('#mailCreateForm').submit();
        }
    });
</script>

@endsection