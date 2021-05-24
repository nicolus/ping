<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'url' => 'url'
        ]);

        auth()->user()->urls()->create([
            'url'  => $request->input('url'),
            'name' => $request->input('name')
        ])->makeCheck();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Url $url
     * @return Response
     */
    public function show(Url $url)
    {
        //
    }

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
