<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class VerifySessionIntegrity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Bind session to IP address
            if (!session()->has('ip_address')) {
                session(['ip_address' => $request->ip()]);
            } elseif ($request->ip() !== session('ip_address')) {
                Auth::logout();
                session()->invalidate();
                return redirect('edharti/login')->withErrors([
                    'message' => 'Session mismatch detected (IP changed).',
                ]);
            }

            // Bind session to User-Agent (browser)
            if (!session()->has('user_agent')) {
                session(['user_agent' => $request->userAgent()]);
            } elseif ($request->userAgent() !== session('user_agent')) {
                Auth::logout();
                session()->invalidate();
                return redirect('edharti/login')->withErrors([
                    'message' => 'Session mismatch detected (device changed).',
                ]);
            }
        }

        return $next($request);
    }
}
