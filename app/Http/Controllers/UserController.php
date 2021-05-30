<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmTwoFactorAuthRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('settings', [
            'user' => $user,
            'qrcode' => $user->two_factor_secret ? $user->twoFactorQrCodeSvg() : null,
        ]);
    }

    public function confirmTwoFactorAuth(ConfirmTwoFactorAuthRequest $request): RedirectResponse
    {
        if ($request->user()->confirmTwoFactorAuth($request->code)) {
            return redirect()->back()
                ->with('success', __('Two Factor Authentication enabled.'));
        }

        return redirect()->back()
            ->with('error', __('Invalid code, Two factor authentication was not enabled'));
    }
}
