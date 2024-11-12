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
        'api/login', // Exclude the login route from CSRF protection
        'api/logout', // Exclude the logout route from CSRF protection
        'api/register', // If needed, also exclude register route
    ];
}
