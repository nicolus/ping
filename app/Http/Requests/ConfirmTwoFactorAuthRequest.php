<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmTwoFactorAuthRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => 'required'
        ];
    }
}
