<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmTwoFactorAuthRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('settings', [
            'user' => $user,
            'qrcode' => $user->two_factor_secret ? $user->twoFactorQrCodeSvg() : null,
        ]);
    }

    public function update(UpdateUserRequest $request): RedirectResponse
    {
        $request->user()->update($request->validated());

        return redirect()->back()
            ->with('success', __('Profile updated'));
    }
}
