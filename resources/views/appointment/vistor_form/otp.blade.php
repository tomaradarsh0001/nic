<!-- Appointment Mobile OTP Modal -->
<div class="modal fade" id="appOtpMobile" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
            <div class="otp-title">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Mobile Phone Verification</h1>
                <p class="otp-description">Enter the 4-digit verification code that was sent to your phone number.</p>
            </div>
            <div class="text-danger text-center" id="appMobileOptVerifyError"></div>
            <div class="text-success text-center" id="appMobileOptVerifySuccess"></div>
            <form action="#" id="app-otp-form">
                <div class="otp-receive-container">
                    <div class="otp_input_groups">
                            <input type="text" class="otp_input app_mobile_otp_input" autofocus pattern="\d*" maxlength="1" />
                            <input type="text" class="otp_input app_mobile_otp_input" maxlength="1" />
                            <input type="text" class="otp_input app_mobile_otp_input" maxlength="1" />
                            <input type="text" class="otp_input app_mobile_otp_input" maxlength="1" />
                      </div>
                      <button type="button" id="appVerifyMobileOtpBtn" class="btn otp_verify_btn">Verify Mobile Number</button>
                      <!-- <p class="resent_otp">
                          Didn't receive code? 
                          <a href="javascript:void(0);" id="reSentAptOtpMobileBtn">Resend</a>
                      </p>
                      <div class="text-danger text-center" id="mobileResendAptOptError"></div>
                      <div class="text-success text-center" id="mobileResendAptOptSuccess"></div>
                      <div id="otpTimerContainerMobile" style="display: none;">
                          Resend available in <span id="otpTimerMobile">60</span> seconds.
                      </div> -->
                        <div id="otpTimerContainerAptMobile" style="display:none;">
                                <p>OTP expire in <span id="otpTimerAptMobile"></span> seconds</p>
                        </div>
                        <div class="text-danger text-center" id="mobileResendAptOptError"></div>
                        <div class="text-success text-center" id="mobileResendAptOptSuccess"></div>
                        <p class="resent_otp">Didn't receive code? <a href="javascript:void(0);" id="reSentAptOtpMobileBtn">Resend</a></p>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
 <!-- End -->

  <!-- Appointment Email OTP Modal -->
  <div class="modal fade" id="appOtpEmail" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
            <div class="otp-title">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Email Verification</h1>
                <p class="otp-description">Enter the 4-digit verification code that was sent to your email.</p>
            </div>
            <div class="text-danger text-center" id="appEmailOptVerifyError"></div>
            <div class="text-success text-center" id="appEmailOptVerifySuccess"></div>
            <form action="#" id="app-otp-form-email">
                <div class="otp-receive-container">
                    <div class="otp_input_groups">
                            <input type="text" class="app_otp_input_email otp_input" autofocus pattern="\d*" maxlength="1" />
                            <input type="text" class="app_otp_input_email otp_input" maxlength="1" />
                            <input type="text" class="app_otp_input_email otp_input" maxlength="1" />
                            <input type="text" class="app_otp_input_email otp_input" maxlength="1" />
                      </div>
                      <button type="button" id="appVerifyEmailOtpBtn" class="btn otp_verify_btn">Verify Email</button>
                      <!-- <p class="resent_otp">
                          Didn't receive code? 
                          <a href="javascript:void(0);" id="reSentAptOtpEmailBtn">Resend</a>
                      </p>
                      <div class="text-danger text-center" id="emailResendAptOptError"></div>
                      <div class="text-success text-center" id="emailResendAptOptSuccess"></div>
                      <div id="otpTimerContainerEmail" style="display: none;">
                          Resend available in <span id="otpTimerEmail">60</span> seconds.
                      </div> -->
                        <div id="otpTimerContainerAptEmail" style="display:none;">
                                <p>OTP expire in <span id="otpTimerAptEmail"></span> seconds</p>
                        </div>
                        <div class="text-danger text-center" id="emailResendAptOptError"></div>
                        <div class="text-success text-center" id="emailResendAptOptSuccess"></div>
                        <p class="resent_otp">Didn't receive code? <a href="javascript:void(0);" id="reSentAptOtpEmailBtn">Resend</a></p>
                           
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
 <!-- End -->