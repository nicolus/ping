<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ApiUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return auth()->user()->urls()->with('latestCheck')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function refresh(): Response
    {
        auth()->user()->urls()->get()->each->makeCheck();
        return auth()->user()->urls()->with('latestCheck')->get();
    }
}
