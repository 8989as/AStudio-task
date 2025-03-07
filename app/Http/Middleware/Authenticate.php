<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseFormatter;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return null;
    }

    protected function unauthenticated($request, array $guards)
    {
        abort(ResponseFormatter::format(
            401,
            'Unauthenticated',
            []
        ));
    }
}
