<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'apply/*',
        'api/*',
        'admin/application/borrower/edit/*',
        'admin/application/patient/edit/*',
        '/admin/login',
        '/admin/application/*',
        '/user/*',
        'payment/*',
        '/eligibility/screenshot/*',
        '/user/process/emandate/*',
        'admin/manage-charges/*'
    ];
}
