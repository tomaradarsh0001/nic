@extends('layouts.public.app')
@section('title', 'Registration')

@section('content')

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/css/chat.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>
.login-8 {
    min-height: calc(100vh - 83px);
    background: url(assets/frontend/assets/img/cannaught-place-bg.jpg) no-repeat;
    background-size: cover;
    position: relative;
    text-align: center;
}
.login-8::before {
    position: absolute;
    content: '';
    background: #ffffff61;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}
.login-8 .container {
    position: relative;
    z-index: 9;
}
/* Begin Success */
.custom-success-card {
    width: 100%;
    background: radial-gradient(#19a3a4, #006c6d);
    padding: 50px 25px 10px;
    border-radius: 20px;
}
/* End Success */
/* Begin Danger */
.custom-danger-card {
    width: 100%;
    background: radial-gradient(#f14758, #a11926);
    padding: 50px 25px 10px;
    border-radius: 20px;
}
/* End */
p.help-note {
    margin: 10px 0px 0px;
    color: #dedede;
}
p.help-note a {
    color: #dedede;
}
.status-card h2 {
    font-size: 30px;
    font-family: 'jost';
    display: inline-block;
    border-bottom: 3px solid #fff;
    padding-bottom: 20px;
    margin-bottom: 20px;
}
.status-card p.subtitle {
    font-size: 40px;
    line-height: 40px;
    margin-bottom: 0px;
    font-family: 'jost';
}
.status-card p.subtitle span {
    color: #fff1ac;
}
.back-login {
    margin-top: 70px;
}
.back-login a.login {
    color: white;
    text-decoration: none;
    font-size: 22px;
}
.status-icon {
    width: 25px;
}


@media (max-width: 1600px) {
    .status-card h2 {
    font-size: 45px;
    }
    .custom-danger-card .status-icon {
    width: 45px;
}
.status-card p.subtitle {
    font-size: 30px;
}
.back-login a.login {
    font-size: 20px;
}
p.help-note {
    font-size: 14px;
}
}
@media (max-width: 1199px) {
    .status-card h2 {
    font-size: 35px;
    }
    .custom-danger-card .status-icon {
    width: 35px;
}
.status-card p.subtitle {
    font-size: 24px;
}
.back-login a.login {
    font-size: 18px;
}
p.help-note {
    font-size: 12px;
}
.back-login {
    margin-top: 42px;
}
}
@media (max-width: 767px) {
    .status-card h2 {
    font-size: 28px;
    padding-bottom: 10px;
    margin-bottom: 10px;
    }
    .custom-danger-card .status-icon {
    width: 28px;
}
.status-card p.subtitle {
    font-size: 18px;
}
.back-login a.login {
    font-size: 16px;
}
p.help-note {
    font-size: 10px;
}
.custom-success-card {
    width: 100%;
    background: radial-gradient(#19a3a4, #006c6d);
    padding: 20px 10px 10px;
    border-radius: 10px;
}
.custom-danger-card {
    width: 100%;
    background: radial-gradient(#f14758, #a11926);
    padding: 20px 10px 10px;
    border-radius: 10px;
}
.back-login {
    margin-top: 38px;
}
}
@media (max-width: 600px) {
    .status-card h2 {
    font-size: 25px;
    padding-bottom: 10px;
    margin-bottom: 10px;
    }
    .custom-danger-card .status-icon {
    width: 24px;
}
.status-card p.subtitle {
    font-size: 14px;
}
.back-login a.login {
    font-size: 16px;
}
p.help-note {
    font-size: 10px;
}
.custom-success-card {
    width: 100%;
    background: radial-gradient(#19a3a4, #006c6d);
    padding: 20px 10px 10px;
    border-radius: 10px;
}
.custom-danger-card {
    width: 100%;
    background: radial-gradient(#f14758, #a11926);
    padding: 20px 10px 10px;
    border-radius: 10px;
}
.back-login {
    margin-top: 38px;
}
}
    </style>

<div class="login-8">
        <div class="container">
           <div class="row">
            <div class="col-lg-8 col-md-8 col-11 mx-auto">
                <!-- Success Message -->
                <div class="status-card custom-success-card">
                    <h2 class="text-white"><img src="{{ asset('assets/frontend/assets/img/success-check.png') }}" alt="Check" class="status-icon"> You have Registered Successfully! Your Registration No. : <span style="font-weight: 600;">{{ $registrationNumber }}</span></h2>
                    <p class="subtitle text-white">Thank You!</p>
                    <div class="back-login">
                        <a href="{{ route('login') }}" class="login">Back to Login <i class="fas fa-sign-in-alt"></i></a>
                        <p class="help-note">If you have any questions, feel free to reach out to our support team at <a href="mailto:support@ldo.gov.in">support@ldo.gov.in</a>.</p>
                    </div>
                </div>
                <!-- End -->
            </div>
           </div>
        </div>
        <div class="ocean">
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
    </div>

@endsection
