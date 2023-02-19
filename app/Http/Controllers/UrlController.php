<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUrlRequest;
use App\Models\Url;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $urls = auth()->user()->urls()->with('latestCheck')->get();

        return response()->view('urls.index', ['urls' => $urls]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUrlRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUrlRequest $request): RedirectResponse
    {
        auth()->user()->urls()
            ->create($request->validated())
            ->makeCheck();

        return redirect()->back()->with('success', __('Url successfully added'));
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param Url $url
//     */
//    public function show(Url $url)
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Url $url
     * @return RedirectResponse
     */
    public function destroy(Url $url): RedirectResponse
    {
        $url->delete();
        return redirect()->back();
    }
}
