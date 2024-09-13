<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/place-bid', // Add your route here to disable CSRF temporarily
    ];

    /**
     * Determine if the session and input CSRF token match.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        // If running unit tests, don't enforce CSRF token match
        if (app()->runningUnitTests()) {
            return true;
        }

        return parent::tokensMatch($request);
    }
}
