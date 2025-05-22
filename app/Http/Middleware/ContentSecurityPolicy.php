<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);



        $csp = implode(' ', [
            "default-src 'self';",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://maps.googleapis.com  https://stackpath.bootstrapcdn.com https://code.jquery.com https://scanex.github.io https://cdnjs.cloudflare.com https://ptma.github.io https://cdnjs.cloudflare.com https://unpkg.com https://cdn.jsdelivr.net https://ajax.googleapis.com https://cdn.jsdelivr.net/npm/toastify-js http://127.0.0.1:8000 https://ish.lol https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js https://cdn.jsdelivr.net/npm/flatpickr https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js https://cdn.jsdelivr.net/npm/toastify-js https://cdn.jsdelivr.net/npm/toastify-js;",
            "style-src 'self' 'unsafe-inline' https://code.jquery.com https://cdnjs.cloudflare.com https://scanex.github.io/Leaflet-IconLayers/src/iconLayers.css https://cdn.jsdelivr.net https://unpkg.com https://fonts.googleapis.com https://ptma.github.io https://cdn.jsdelivr.net https://fonts.googleapis.com https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css https://unpkg.com/leaflet@1.9.4/dist/leaflet.css http://127.0.0.1:8000/  https://cdn.lineicons.com/4.0/lineicons.css  https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css https://cdn.jsdelivr.net/npm/@flaticon/flaticon-uicons/css/all/all.css  https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css  https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css;",
            "font-src 'self' https://fonts.gstatic.com https://fonts.googleapis.com http://127.0.0.1:8000 https://cdn.lineicons.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net;",
            "img-src 'self' data: https://scanex.github.io https://maps.gstatic.com https://unpkg.com https://streetviewpixels-pa.googleapis.com https://maps.googleapis.com  http://edharti.eu-north-1.elasticbeanstalk.com http://127.0.0.1:8000 https://mt1.google.com https://*.google.com https://*.googleusercontent.com;",
            "connect-src 'self' https://maps.googleapis.com http://127.0.0.1:8000;",
            "frame-ancestors 'none';",
            "worker-src 'self' blob:",
        ]);

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
