<?php
namespace App\Services;
use App\Helpers\GeneralFunctions;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommonMail;
use App\Services\CommunicationService;
use App\Services\SettingsService;
use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\CircleResidentialLandRate;
use App\Models\LndoResidentialLandRate;
use App\Models\CircleCommercialLandRate;
use App\Models\LndoCommercialLandRate;
use App\Models\CircleInstitutionalLandRate;
use App\Models\LndoInstitutionalLandRate;
use App\Models\CircleIndustrialLandRate;
use App\Models\LndoIndustrialLandRate;

class CommonService
{
    public function getUniqueID($model, $prefix, $column)
    {
        $maxId = $model::max($column);

        if ($maxId) {
            // Extract numeric part after the prefix
            $numericPart = (int) substr($maxId, strlen($prefix));
            
            $nextNumericPart = $numericPart + 1;
            
            $paddedNumericPart = str_pad($nextNumericPart, 7, '0', STR_PAD_LEFT);

            $nextId = $prefix . $paddedNumericPart;
        } else {
            $nextId = $prefix . '0000001';
        }

        return $nextId;
    }

        // Create OTP
        public function createOtp(
            $type,
            $value,
            $serviceType,
            $action,
            $countryCode = null,
            CommunicationService $communicationService = null
        ) {
            $generateOtp = app(GeneralFunctions::class)->generateUniqueRandomNumber(4);
    
            $otpData = [
                'service_type' => getServiceType($serviceType),
                "{$type}" => $value,
                "{$type}_otp" => $generateOtp,
                "{$type}_otp_sent_at" => now(),
            ];
    
            if ($type === 'mobile') {
                $otpData['country_code'] = $countryCode;
            }
    
            $otp = Otp::create($otpData);
    
            Log::info("OTP generated: " . $generateOtp);
    
            $data = ['otp' => $generateOtp];
            $communicationService = $communicationService ?? app(CommunicationService::class);
    
            if ($type === 'mobile') {
                $communicationService->sendSmsMessage($data, $value, $action);
                $communicationService->sendWhatsAppMessage($data, $value, $action);
            } elseif ($type === 'email') {
                app(SettingsService::class)->applyMailSettings($action);
                Mail::to($value)->send(new CommonMail($data, $action));
            }
    
            return response()->json(['success' => true, 'message' => "OTP sent to {$type} {$value} successfully"]);
        }
    
        // Update OTP
        public function updateOtp(
            $otpRecord,
            $type,
            $value,
            $action,
            $countryCode = null,
            CommunicationService $communicationService = null
        ) {
            $generateOtp = app(GeneralFunctions::class)->generateUniqueRandomNumber(4);
    
            if ($type === 'mobile') {
                $otpRecord->country_code = $countryCode;
                $otpRecord->mobile = $value;
                $otpRecord->mobile_otp = $generateOtp;
                $otpRecord->mobile_otp_sent_at = now();
            } else {
                $otpRecord->email = $value;
                $otpRecord->email_otp = $generateOtp;
                $otpRecord->email_otp_sent_at = now();
            }
    
            $otpRecord->save();
    
            Log::info("OTP updated: " . $generateOtp);
    
            $data = ['otp' => $generateOtp];
            $communicationService = $communicationService ?? app(CommunicationService::class);
    
            if ($type === 'mobile') {
                $communicationService->sendSmsMessage($data, $value, $action);
                $communicationService->sendWhatsAppMessage($data, $value, $action);
            } elseif ($type === 'email') {
                app(SettingsService::class)->applyMailSettings($action);
                Mail::to($value)->send(new CommonMail($data, $action));
            }
    
            return response()->json(['success' => true, 'message' => "OTP sent to {$type} {$value} successfully"]);
        }

    //For calculating land value - SOURAV CHAUHAN (19/Dec/2024)
    public static function calculatePlotValue($request,$plotAreaInSqm)
    {
        $plot_value = 0;
        $plot_value_cr = 0;
        $lndoRateInv = null;
        $circleRateInv = null;
        $colonyId = $request->present_colony_name;
        if($request->property_status == 1476){//If property status is unalloted
            $propertyType = '47';
        } else {
            $propertyType = $request->land_use_changed
                ? $request->purpose_lease_type_alloted_present
                : $request->purpose_property_type;
        }
        switch ($propertyType) {
            case '47'://Residential
                $circleRateInv = Self::fetchLatestLandRate(CircleResidentialLandRate::class, $colonyId);
                $lndoRateInv = Self::fetchLatestLandRate(LndoResidentialLandRate::class, $colonyId);
                break;
            case '48'://Commercial
            case '72'://Mixed
                $circleRateInv = Self::fetchLatestLandRate(CircleCommercialLandRate::class, $colonyId);
                $lndoRateInv = Self::fetchLatestLandRate(LndoCommercialLandRate::class, $colonyId);
                break;
            case '49'://Institutional
                $circleRateInv = Self::fetchLatestLandRate(CircleInstitutionalLandRate::class, $colonyId);
                $lndoRateInv = Self::fetchLatestLandRate(LndoInstitutionalLandRate::class, $colonyId);
                break;
            case '469'://industrial
                $circleRateInv = Self::fetchLatestLandRate(CircleIndustrialLandRate::class, $colonyId);
                $lndoRateInv = Self::fetchLatestLandRate(LndoIndustrialLandRate::class, $colonyId);
                break;
        }
        $plotAreaRounded = round($plotAreaInSqm, 2);
        if ($lndoRateInv !== null) {
            $plot_value = round($lndoRateInv * $plotAreaRounded, 2);
        }
        if ($circleRateInv !== null) {
            $plot_value_cr = round($circleRateInv * $plotAreaRounded, 2);
        }
        
        $data = [
            "plot_value" => $plot_value,
            "plot_value_cr" => $plot_value_cr
        ];
        return $data;
    }

    //To fetch land rates from different models - SOURAV CHAUHAN (19/Dec/2024)
    public static function fetchLatestLandRate($modelClass, $colonyId) 
    {
        $data = $modelClass::where("colony_id", $colonyId)
                          ->orderBy('date_from', 'desc')
                          ->first();
                          
        return $data ? $data->land_rate : 0;
    }
}
