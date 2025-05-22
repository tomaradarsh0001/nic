<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\UserActionLogHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use DB;
use App\Helpers\GeneralFunctions;
use App\Models\Otp;
use App\Services\CommunicationService;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // $user = User::where('email', $request->email)->first();
        // //Code added by Lalit on 08/01/2024 Like if user does not exist then redirect to login page with error
        // if(empty($user)){
        //     return redirect()->back()->with('failure','Your account does not exists.');
        // }
        // if ($user->status == 1) {
        //     $request->authenticate();
        //     $request->session()->regenerate();
        //     // Retrieve authenticated user
        //     $user = Auth::user();
        //     $roleName = $user->roles->pluck('name')->first();
        //     if (!empty($roleName) && $roleName != 'super-admin') {
        //         //  Helper function to Manage User Activity / Action Logs
        //         UserActionLogHelper::UserActionLog('login', url("/login"), 'login', "User " . Auth::user()->name . " login.");
        //     }
        //     return redirect()->intended(RouteServiceProvider::HOME);
        // } else {
        //     return redirect()->back()->with('failure', 'Your account is not activated yet.');
        // }
        if($request->mobile){
            $user = User::where('mobile_no',$request->mobile)->first();
            if(empty($user)){
                return response()->json(['success' => false, 'message' => 'Your account does not exists.']);
            }
            if($user->status == 1){
                $request->authenticate();
                $request->session()->regenerate();
                $user = Auth::user();
                $roleName = $user->roles->pluck('name')->first();
                if (!empty($roleName) && $roleName != 'super-admin') {
                    UserActionLogHelper::UserActionLog('login', url("/login"), 'login', "User " . Auth::user()->name . " login.");
                }
                return response()->json(['success' => true, 'message' => 'Login Successfully.']);
            } else{
                return response()->json(['success' => false, 'message' => 'Your account is not activated yet.']);
            }
        } else if($request->email) {
            $user = User::where('email',$request->email)->first();
            //Code added by Lalit on 08/01/2024 Like if user does not exist then redirect to login page with error
            if(empty($user)){
                return redirect()->back()->with('failure','Your account does not exists.');
            }
            if($user->status == 1){
                // dd('Inside if');
                $request->authenticate();
                $request->session()->regenerate();
                // Retrieve authenticated user
                $user = Auth::user();
                $roleName = $user->roles->pluck('name')->first();
                if (!empty($roleName) && $roleName != 'super-admin') {
                    //  Helper function to Manage User Activity / Action Logs
                    UserActionLogHelper::UserActionLog('login', url("/login"), 'login', "User " . Auth::user()->name . " login.");
                }
                return redirect()->intended(RouteServiceProvider::HOME);
                    

            } else{
                // dd('Inside else');
                return redirect()->back()->with('failure','Your account is not activated yet.');
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Your account does not exists.']);
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Retrieve authenticated user
        $user = Auth::user();
        $roleName = $user->roles->pluck('name')->first();
        if (!empty($roleName) && $roleName != 'super-admin') {
            //  Helper function to Manage User Activity / Action Logs
            UserActionLogHelper::UserActionLog('logout', url("/logout"), 'logout', "User " . Auth::user()->name . " logout.");
        }
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

         return redirect()->route('login');

    }

     //To send and store the Login otp - Sourav Chauhan (13/Aug/2024)
     public function sendLoginOtp(Request $request,CommunicationService $communicationService)
     {
         try {
             if (isset($request->mobile)) {
                 $isUserExist = User::where('mobile_no',$request->mobile)->first();
                 if($isUserExist){
                     $generateOtp = GeneralFunctions::generateUniqueRandomNumber(6);
 
                     // Create or update OTP record for the mobile
                     $otp = Otp::updateOrCreate(
                         ['mobile' => $request->mobile],
                         ['mobile_otp' => $generateOtp, 'service_type' => getServiceType('OTP_LOGIN')]
                     );
 
                     if ($otp) {
                         $action = 'LOGIN_OTP';
                         $data = [
                             'otp' => $generateOtp
                         ];
 
                         $communicationService->sendSmsMessage($data,$request->mobile,$action);
                         $communicationService->sendWhatsAppMessage($data,$request->mobile,$action);
 
 
                         return response()->json(['success' => true, 'message' => 'OTP sent to mobile number ' . $request->mobile . ' successfully']);
                     } else {
                         return response()->json(['success' => false, 'message' => 'Failed to send OTP']);
                     }
                 } else {
                     return response()->json(['success' => false, 'message' => 'Mobile number not registered with us']);
                 }
                 
             } else {
                 return response()->json(['success' => false, 'message' => 'Failed to send OTP']);
             }
         } catch (\Exception $e) {
             Log::info($e);
             return response()->json(['success' => false, 'message' => $e->getMessage()]);
         }
     }
 
 
     //To verify otp and make the user login - Sourav Chauhan (14/Aug/2024)
     public function verifyLoginOtp(Request $request)
     {
         try {
             if (isset($request->mobile) && isset($request->otp)) {
                 $user = User::where('mobile_no', $request->mobile)->first();
                 if($user){
                     if($user->status == 1){
                         $otpValid = Otp::where('mobile', $request->mobile)
                             ->where('mobile_otp', $request->otp)
                             ->exists();
                         if($otpValid){
                             Auth::login($user);
                             $request->session()->regenerate();
                             $roleName = $user->roles->pluck('name')->first();
                             if (!empty($roleName) && $roleName != 'super-admin') {
                                 UserActionLogHelper::UserActionLog('login', url("/login"), 'login', "User " . $user->name . " logged in.");
                             }
                             return response()->json(['success' => true, 'message' => 'Login Successfully.']);
                         } else {
                             return response()->json(['success' => false, 'message' => 'OTP not correct']);
                         }
                     } else {
                         return response()->json(['success' => false, 'message' => 'Your account is not activated yet.']);
                     }
                 } else {
                     return response()->json(['success' => false, 'message' => 'Mobile number not registered with us']);
                 }
                 
             } else {
                 return response()->json(['success' => false, 'message' => 'Mobile / Otp are required']);
             }
         } catch (\Exception $e) {
             Log::info($e);
             return response()->json(['success' => false, 'message' => $e->getMessage()]);
         }
     }
}
