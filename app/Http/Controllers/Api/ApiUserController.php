<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;

class ApiUserController extends Controller
{
    public function update(UpdateUserRequest $request)
    {
        $request->user()->update($request->validated());

        return response()->json(['success' => true]);
    }

}
