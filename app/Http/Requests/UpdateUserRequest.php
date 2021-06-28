<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone_number' => ['nullable', 'string'],
            'fcm_token' => ['nullable', 'string']
        ];
    }
}
