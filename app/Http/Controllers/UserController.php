<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('settings', [
            'user' => $user,
            'qrcode' => $user->two_factor_secret ? $user->twoFactorQrCodeSvg() : null,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        if ($request->code) {
            $user->confirmTwoFactorAuth($request->code);
        }

        return view('settings', [
            'user' => $user,
            'qrcode' => $user->two_factor_secret ? $user->twoFactorQrCodeSvg() : null,
        ]);
    }
}
