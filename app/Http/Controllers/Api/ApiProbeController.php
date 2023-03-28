<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiProbeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(
            auth()->user()->probes()->with('latestCheck')->get()
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function refresh(): JsonResponse
    {
        auth()->user()->probes()->get()->each->makeCheck();
        return response()->json(
            auth()->user()->probes()->with('latestCheck')->get()
        );
    }
}
