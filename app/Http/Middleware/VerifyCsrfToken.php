<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/send-notification',  // Your API route for sending notifications
        '/payment-response', //Added to avoid CSRF token verification as it is redirecting from NTRP -- Amita [20-01-2025]
        'api/public-grievances', //for posting public grievances response added by Swati Mishra [31-01-2025]
        'api/club-memberships/*', //for posting club membership response added by Swati Mishra [31-01-2025]
        'api/upload-document/*', //for club membership upload docs
        'api/membership/*', //for club membership record for a particular id
        'api/membership/filter'
    ];
}