<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProbeResource;
use Illuminate\Http\JsonResponse;

class ApiProbeController extends Controller
{
    /**
     * Display a listing of the probes.
     */
    public function index(): JsonResponse
    {
        return ProbeResource::collection(
            auth()->user()->probes()->with('latestCheck')->get()
        )->response();
    }

    /**
     * Refresh the probes and return the updated list
     */
    public function refresh(): JsonResponse
    {
        auth()->user()->probes()->get()->each->makeCheck();
        return $this->index();
    }
}
