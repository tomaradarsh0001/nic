<!DOCTYPE html>
<html lang="en">

<head>
    <title>eDharti | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/frontend/assets/css/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/frontend/assets/fonts/font-awesome/css/font-awesome.min.css') }}">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/frontend/assets/fonts/flaticon/font/flaticon.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@flaticon/flaticon-uicons/css/all/all.css" rel="stylesheet">

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/logo-icon.png') }}" type="image/png" />

    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPoppins:400,500,700,800,900%7CRoboto:100,300,400,400i,500,700">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/frontend/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" id="style_sheet"
        href="{{ asset('assets/frontend/assets/css/skins/default.css') }}">
    <link rel="stylesheet" type="text/css" id="style_sheet" href="{{ asset('assets/frontend/assets/css/custom.css') }}">
    <!-- Toaster CSS Added by Diwakar Sinha at 20-09-2024 -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        /* Initially hide the form */
        #emailLoginForm {
            display: none;
        }

        #emailInput {
            display: block;
        }

        #dividerLogin {
            display: block;
        }

        #mobileOtp {
            display: none;
        }

        #LoginWithOTP {
            display: none;
        }

        #mobileInput {
            display: block;
        }

        .text-divider {
            margin: 2em 0;
            line-height: 0;
            text-align: center;
        }

        .text-divider span {
            background-color: #116d6e;
            padding: 7px;
            border-radius: 50%;
            color: #ffffff;
            font-size: 14px;
            position: relative;
        }

        .text-divider:before {
            content: " ";
            display: block;
            border-top: 1px solid #e3e3e3;
            border-bottom: 1px solid #f7f7f7;
            position: relative;
            z-index: -1;
        }

        .text-divider span::after {
            position: absolute;
            width: 50px;
            height: 5px;
            content: '';
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            z-index: -1;
        }

    </style>

</head>

<body id="top">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TAGCODE" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="page_loader"></div>

    <!-- Login 8 start -->
    <nav class="navbar fixed-top sticky-shadow full-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-7">
                    <a class="navbar-brand" href="{{ route('login') }}">
                        <img src="{{ asset('assets/frontend/assets/img/LDOLogo-white.png') }}"
                            alt="Land and Development Office" height="60">
                    </a>
                </div>
                <div class="col-lg-6 col-5 text-end">
                    <div class="d-flex justify-content-end"><img
                            src="{{ asset('assets/frontend/assets/img/eDharti-Logo-white.png') }}" alt="logo"
                            class="edharti-logo"><span class="text-white">2.0</span></div>
                </div>
            </div>
        </div>
    </nav>

    <div class="alert alert-success border-0 bg-success alert-dismissible">
        <div class="text-white">{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    
    <div class="page-wrapper public-wrap">
        <div class="page-content">
            @yield('content')
        </div>
    </div>


    <footer>
        <span>Copyright &copy; 2024. All Rights Reserved.</span>
    </footer>
    <!-- Login 8 end -->
    <!-- Begin OTP -->
    <!-- Button trigger modal -->


    <!-- Mobile OTP Modal -->
    <div class="modal fade" id="otpMobile" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="otp-title">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Mobile Phone Verification</h1>
                        <p class="otp-description">Enter the 4-digit verification code that was sent to your phone
                            number.</p>
                    </div>
                    <div class="text-danger text-center" id="mobileOptVerifyError"></div>
                    <div class="text-success text-center" id="mobileOptVerifySuccess"></div>
                    <form action="#" id="otp-form">
                        <div class="otp-receive-container">
                            <div class="otp_input_groups">
                                <input type="text" class="otp_input" autofocus pattern="\d*" maxlength="1" />
                                <input type="text" class="otp_input" maxlength="1" />
                                <input type="text" class="otp_input" maxlength="1" />
                                <input type="text" class="otp_input" maxlength="1" />
                            </div>
                            <button type="button" id="verifyMobileOtpBtn" class="otp_verify_btn">Verify Mobile
                                Number</button>
                            
                            <div id="otpTimerContainerMobile" style="display:none;">
                                <p>OTP expire in <span id="otpTimerMobile"></span> seconds</p>
                            </div>
                            <div class="text-success text-center" id="mobileResendOptSuccess"></div>
                            <p class="resent_otp">Didn't receive code? <a href="#" id="reSentOtpMobileBtn">Resend</a></p>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->

    <!-- Email OTP Modal -->
    <div class="modal fade" id="otpEmail" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="otp-title">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Email Verification</h1>
                        <p class="otp-description">Enter the 4-digit verification code that was sent to your email.</p>
                    </div>
                    <div class="text-danger text-center" id="emailOptVerifyError"></div>
                    <div class="text-success text-center" id="emailOptVerifySuccess"></div>
                    <form action="#" id="otp-form-email">
                        <div class="otp-receive-container">
                            <div class="otp_input_groups">
                                <input type="text" class="otp_input_email otp_input" autofocus pattern="\d*"
                                    maxlength="1" />
                                <input type="text" class="otp_input_email otp_input" maxlength="1" />
                                <input type="text" class="otp_input_email otp_input" maxlength="1" />
                                <input type="text" class="otp_input_email otp_input" maxlength="1" />
                            </div>
                            <button type="button" id="verifyEmailOtpBtn" class="otp_verify_btn">Verify Email</button>
                            
                            <div id="otpTimerContainerEmail" style="display:none;">
                                <p>OTP expire in <span id="otpTimerEmail"></span> seconds</p>
                            </div>
                            <div class="text-success text-center" id="emailResendOptSuccess"></div>
                            <p class="resent_otp">Didn't receive code? <a href="#" id="reSentOtpEmailBtn">Resend</a></p>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->


    <!-- Organization Mobile OTP Modal -->
    <div class="modal fade" id="orgOtpMobile" tabindex="-1" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="otp-title">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Mobile Phone Verification</h1>
                        <p class="otp-description">Enter the 4-digit verification code that was sent to your phone
                            number.</p>
                    </div>
                    <div class="text-danger text-center" id="orgMobileOptVerifyError"></div>
                    <div class="text-success text-center" id="orgMobileOptVerifySuccess"></div>
                    <form action="#" id="org-otp-form">
                        <div class="otp-receive-container">
                            <div class="otp_input_groups">
                                <input type="text" class="otp_input org_mobile_otp_nput" autofocus pattern="\d*"
                                    maxlength="1" />
                                <input type="text" class="otp_input org_mobile_otp_nput" maxlength="1" />
                                <input type="text" class="otp_input org_mobile_otp_nput" maxlength="1" />
                                <input type="text" class="otp_input org_mobile_otp_nput" maxlength="1" />
                            </div>
                            <button type="button" id="orgVerifyMobileOtpBtn" class="otp_verify_btn">Verify Mobile
                                Number</button>
                            
                            <div id="otpTimerContainerOrgMobile" style="display:none;">
                                <p>OTP expire in <span id="otpTimerOrgMobile"></span> seconds</p>
                            </div>
                            <div class="text-success text-center" id="orgMobileResendOptSuccess"></div>
                            <p class="resent_otp">Didn't receive code? <a href="#" id="reSentOtpOrgMobileBtn">Resend</a></p>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->

    <!-- Organization Email OTP Modal -->
    <div class="modal fade" id="orgOtpEmail" tabindex="-1" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="otp-title">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Email Verification</h1>
                        <p class="otp-description">Enter the 4-digit verification code that was sent to your email.</p>
                    </div>
                    <div class="text-danger text-center" id="orgEmailOptVerifyError"></div>
                    <div class="text-success text-center" id="orgEmailOptVerifySuccess"></div>
                    <form action="#" id="org-otp-form-email">
                        <div class="otp-receive-container">
                            <div class="otp_input_groups">
                                <input type="text" class="org_otp_input_email otp_input" autofocus pattern="\d*"
                                    maxlength="1" />
                                <input type="text" class="org_otp_input_email otp_input" maxlength="1" />
                                <input type="text" class="org_otp_input_email otp_input" maxlength="1" />
                                <input type="text" class="org_otp_input_email otp_input" maxlength="1" />
                            </div>
                            <button type="button" id="orgVerifyEmailOtpBtn" class="otp_verify_btn">Verify
                                Email</button>
                            
                            <div id="otpTimerContainerOrgEmail" style="display:none;">
                                <p>OTP expire in <span id="otpTimerOrgEmail"></span> seconds</p>
                            </div>
                            <div class="text-success text-center" id="orgEmailResendOptSuccess"></div>
                            
                            <p class="resent_otp">Didn't receive code? <a href="#" id="reSentOtpOrgEmailBtn">Resend</a></p>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->



    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- External JS libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('assets/frontend/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom JS Script -->
    <script src="{{ asset('assets/frontend/assets/js/custom.js') }}"></script>

    @yield('footerScript')

    
    <!-- Toast JS Added by Diwakar Sinha at 20-09-2024 -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Chat JS added by Diwakar & Adarsh -->
    <!-- Developed by Adarsh -->
    <script>
        function isValidMobile(mobile) {
            var mobilePattern = /^[0-9]{10}$/;
            return mobilePattern.test(mobile);
        }

        function isValidEmail(email) {
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
        }
        var botmanWidget = {
            aboutText: 'Start the conversation with Hi',
            introMessage: "Hello User My name is Bhoomi your digital assistant. Welcome to eDharti 2.0 Portal Type <b>'Hi'</b> to start conversation! <br> <br> नमस्ते उपयोगकर्ता, मेरा नाम भूमि है, आपकी डिजिटल सहायक। eDharti 2.0 पोर्टल में आपका स्वागत है बातचीत शुरू करने के लिए <b>'Hi'</b> टाइप करें!",
            placeholderText: 'Type your message here...',
            desktopHeight: 450,
            desktopWidth: 370,
            mobileHeight: '100%',
            mobileWidth: '100%',
            mainColor: '#116d6e',
            headerTextColor: '#fff',
            bubbleBackground: '#116d6e',
            aboutText: '',
            bubbleAvatarUrl: '{{ asset('assets/images/chatbot_icongif.gif') }}',
            backgroundImage: '{{ asset('assets/images/chatbot_bg.png') }}',
            backgroundColor: '#f8f8f8',
            className: 'bhoomiChatBot'
        };

        window.onload = function() {
            setTimeout(function() {
                var tooltip = document.getElementById('tooltip');
                tooltip.style.display = 'block';
                tooltip.classList.add('tooltip-show');

                setTimeout(function() {
                    tooltip.style.display = 'none';
                }, 5000);
            }, 500);
        };
        
        //function added by Nitin on 20/nov/24 and copeied from app.js by nitin on 22-01-2025
        // Minified by Diwakar Sinha at 30-12-2024
        function customNumFormat(t) {
            if (t < 1e3) return t.toString();
            {
                const r = t.toString(),
                    [o, n] = r.split(".");
                let e = parseInt(o, 10),
                    a = [],
                    i = 1e3;
                for (a.push(String(e % i).padStart(3, "0")), e = Math.floor(e / i), i = 100; e > 99;) a.push(String(e % i).padStart(2, "0")), e = Math.floor(e / i);
                const s = e + "," + a.reverse().join(",");
                return n ? s + "." + n : s
            }
        }
    </script>
    <div id="tooltip" class="tooltip-message">
        Hello, I am Bhoomi How can I assist you?
    </div>
    {{-- <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script> --}}

    <script id="botmanWidget" src="{{ asset('/assets/js/widget.js') }}"></script>
</body>

</html>
