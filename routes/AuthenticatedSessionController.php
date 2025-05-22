<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\UserActionLogHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use DB;

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

        return redirect('/login');
    }
}
