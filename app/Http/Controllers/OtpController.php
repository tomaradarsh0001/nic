<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommunicationService;
use App\Services\SettingsService;
use App\Models\Otp;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\CommonService;


class OtpController extends Controller
{
    protected $settingsService;
    protected $commonService;

    public function __construct(SettingsService $settingsService, CommonService $commonService)
    {
        $this->settingsService = $settingsService;
        $this->commonService = $commonService;
    }


    public function saveAptOtp(Request $request, CommunicationService $communicationService)
    {
        try {
            $action = 'APT_OTP'; // Define or modify action based on module requirements

            if ($request->has('mobile')) {
                $mobile = $request->mobile;
                $countryCode = $request->countryCode;

                if ($request->has('emailToVerify')) {
                    $latestEmailRecord = Otp::where('email', $request->emailToVerify)
                        ->orderBy('created_at', 'desc')
                        ->first();

                    if (!empty($latestEmailRecord) && 
                        ($latestEmailRecord->is_email_verified == '1' && $latestEmailRecord->is_mobile_verified == '1')) {
                        return $this->commonService->createOtp('mobile', $mobile, 'APT_NEW', $action, $countryCode, $communicationService);
                    } elseif (!empty($latestEmailRecord)) {
                        return $this->commonService->updateOtp($latestEmailRecord, 'mobile', $mobile, $action, $countryCode, $communicationService);
                    }
                }

                $latestMobileRecord = Otp::where('mobile', $mobile)
                    ->where('country_code', $countryCode)
                    ->orderBy('created_at', 'desc')
                    ->first();

                if (empty($latestMobileRecord)) {
                    return $this->commonService->createOtp('mobile', $mobile, 'APT_NEW', $action, $countryCode, $communicationService);
                } elseif (!empty($latestMobileRecord) && 
                    ($latestMobileRecord->is_mobile_verified == '1' && $latestMobileRecord->is_email_verified == '1')) {
                    return $this->commonService->createOtp('mobile', $mobile, 'APT_NEW', $action, $countryCode, $communicationService);
                } else {
                    return $this->commonService->updateOtp($latestMobileRecord, 'mobile', $mobile, $action, $countryCode, $communicationService);
                }
            } elseif ($request->has('email')) {
                $email = $request->email;

                if ($request->has('mobileToVerify')) {
                    $countryCode = $request->countryCode;
                    $mobileToVerify = $request->mobileToVerify;

                    $latestMobileRecord = Otp::where('mobile', $mobileToVerify)
                        ->where('country_code', $countryCode)
                        ->orderBy('created_at', 'desc')
                        ->first();

                    if (!empty($latestMobileRecord) && 
                        ($latestMobileRecord->is_email_verified == '1' && $latestMobileRecord->is_mobile_verified == '1')) {
                        return $this->commonService->createOtp('email', $email, 'APT_NEW', $action, $countryCode, $communicationService);
                    } elseif (!empty($latestMobileRecord)) {
                        return $this->commonService->updateOtp($latestMobileRecord, 'email', $email, $action, $countryCode, $communicationService);
                    }
                }

                $latestEmailRecord = Otp::where('email', $email)->orderBy('created_at', 'desc')->first();

                if (empty($latestEmailRecord)) {
                    return $this->commonService->createOtp('email', $email, 'APT_NEW', $action, null, $communicationService);
                } elseif (!empty($latestEmailRecord) && 
                    ($latestEmailRecord->is_email_verified == '1' && $latestEmailRecord->is_mobile_verified == '1')) {
                    return $this->commonService->createOtp('email', $email, 'APT_NEW', $action, null, $communicationService);
                } else {
                    return $this->commonService->updateOtp($latestEmailRecord, 'email', $email, $action, null, $communicationService);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'No mobile or email provided']);
            }
        } catch (\Exception $e) {
            Log::error('Error in saveOtp: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        }
    }



    public function verifyAptOtp(Request $request)
    {
        try {
            // Verify Mobile OTP
            if ($request->has('mobileOtp') && $request->has('countryCode')) {
                $countryCode = $request->countryCode;
                Log::info('Verifying mobile OTP for: ' . $request->mobile);

                // Fetch the latest OTP record with additional filters
                $databaseOtp = Otp::where('mobile', $request->mobile)
                    ->where('country_code', $countryCode)
                    ->where(function ($query) {
                        $query->where('is_mobile_verified', '!=', '1')
                            ->orWhere('is_email_verified', '!=', '1');
                    })
                    ->where('service_type', '1401') // Ensure service type matches
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($databaseOtp) {
                    // Check OTP expiry
                    $mobileOtpSentAt = $databaseOtp->mobile_otp_sent_at;
                    $generatedOtpDateTime = Carbon::parse($mobileOtpSentAt);
                    $now = Carbon::now();
                    $minutesDifference = $generatedOtpDateTime->diffInMinutes($now);

                    if ($minutesDifference < config('constants.OTP_EXPIRY_TIME')) {
                        if (trim($databaseOtp->mobile_otp) === trim($request->mobileOtp)) {
                            $databaseOtp->is_mobile_verified = '1';
                            $databaseOtp->mobile_verified_at = now();
                            $databaseOtp->mobile_otp = null;

                            if ($databaseOtp->save()) {
                                return response()->json(['success' => true, 'message' => 'Mobile number verified successfully']);
                            } else {
                                return response()->json(['success' => false, 'message' => 'Mobile number not verified']);
                            }
                        } else {
                            return response()->json(['success' => false, 'message' => 'OTP not matched. Please enter the correct OTP.']);
                        }
                    } else {
                        return response()->json(['success' => false, 'message' => 'OTP has expired. Please request a new OTP.']);
                    }
                } else {
                    return response()->json(['success' => false, 'message' => 'No OTP found for the provided mobile number.']);
                }
            }

            // Verify Email OTP
            elseif ($request->has('emailOtp')) {
                Log::info('Verifying email OTP for: ' . $request->email);

                // Fetch the latest OTP record with additional filters
                $databaseOtp = Otp::where('email', $request->email)
                    ->where(function ($query) {
                        $query->where('is_email_verified', '!=', '1')
                            ->orWhere('is_mobile_verified', '!=', '1');
                    })
                    ->where('service_type', '1401') // Ensure service type matches
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($databaseOtp) {
                    // Check OTP expiry
                    $emailOtpSentAt = $databaseOtp->email_otp_sent_at;
                    $generatedOtpDateTime = Carbon::parse($emailOtpSentAt);
                    $now = Carbon::now();
                    $minutesDifference = $generatedOtpDateTime->diffInMinutes($now);

                    if ($minutesDifference < config('constants.OTP_EXPIRY_TIME')) {
                        if (trim($databaseOtp->email_otp) === trim($request->emailOtp)) {
                            $databaseOtp->is_email_verified = '1';
                            $databaseOtp->email_verified_at = now();
                            $databaseOtp->email_otp = null;

                            if ($databaseOtp->save()) {
                                return response()->json(['success' => true, 'message' => 'Email verified successfully']);
                            } else {
                                return response()->json(['success' => false, 'message' => 'Email not verified']);
                            }
                        } else {
                            return response()->json(['success' => false, 'message' => 'OTP not matched. Please enter the correct OTP.']);
                        }
                    } else {
                        return response()->json(['success' => false, 'message' => 'OTP has expired. Please request a new OTP.']);
                    }
                } else {
                    return response()->json(['success' => false, 'message' => 'No OTP found for the provided email.']);
                }
            }

            // No OTP provided in the request
            else {
                return response()->json(['success' => false, 'message' => 'No OTP provided']);
            }
        } catch (\Exception $e) {
            Log::error('Error in verifyOtp: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again later.']);
        }
    }

    public function resendAptOtp(Request $request)
    {
        try {
            if ($request->has('mobile') && $request->has('countryCode')) {
                $mobile = $request->mobile;
                $countryCode = $request->countryCode;

                $latestMobileRecord = Otp::where('mobile', $mobile)
                    ->where('country_code', $countryCode)
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($latestMobileRecord) {
                    return $this->saveAptOtp(new Request([
                        'mobile' => $mobile,
                        'countryCode' => $countryCode,
                        'emailToVerify' => $latestMobileRecord->email,
                    ]), app(CommunicationService::class));
                }

                return response()->json(['success' => false, 'message' => 'No OTP record found for the provided mobile and country code.']);
            } elseif ($request->has('email')) {
                $email = $request->email;

                $latestEmailRecord = Otp::where('email', $email)
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($latestEmailRecord) {
                    return $this->saveAptOtp(new Request([
                        'email' => $email,
                        'mobileToVerify' => $latestEmailRecord->mobile,
                        'countryCodeToVerify' => $latestEmailRecord->country_code,
                    ]), app(CommunicationService::class));
                }

                return response()->json(['success' => false, 'message' => 'No OTP record found for the provided email.']);
            } else {
                return response()->json(['success' => false, 'message' => 'No mobile or email provided.']);
            }
        } catch (\Exception $e) {
            Log::error('Error in resendOtp: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while resending OTP. Please try again later.']);
        }
    }


}