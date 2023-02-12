<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUrlRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'url' => ['url', 'required'],
            'name' => ['string', 'required'],
        ];
    }
}
