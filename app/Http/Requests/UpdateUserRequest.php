<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone_number' => ['nullable', 'phone'],
            'fcm_token' => ['nullable', 'string']
        ];
    }
}
