<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = auth()->user();

        if ($user->hasRole('employee')) {
            return redirect()->route('portal.index');
        }

        return redirect()->route('dashboard');
    }
}