<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\MobileLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticateMobileApp extends Controller
{

    /**
     * Return an authentication token for the mobile app
     *
     * @param MobileLoginRequest $request
     * @return string a newly created token
     */
    public function __invoke(MobileLoginRequest $request): string
    {
        $user = User::where('email', $request->input('email'))->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->input('device_name'))->plainTextToken;
    }
}
