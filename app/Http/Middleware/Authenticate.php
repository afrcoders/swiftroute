<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Deliveries subdomain uses its own admin login route
        if ($request->getHost() === config('app.deliveries_domain')) {
            return route('admin.login');
        }

        return url('/admin/login');
    }
}
