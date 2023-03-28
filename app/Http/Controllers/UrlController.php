<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUrlRequest;
use App\Http\Requests\updateUrlRequest;
use App\Models\Url;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class UrlController extends Controller
{

    public function index(): Response
    {
        $urls = auth()->user()->urls()->with('latestCheck')->get();

        return response()->view('urls.index', ['urls' => $urls]);
    }


    public function store(StoreUrlRequest $request): RedirectResponse
    {
        auth()->user()->urls()
            ->create($request->validated())
            ->makeCheck();

        return redirect()->back()->with('success', __('Url successfully added'));
    }

    public function update(Url $url, StoreUrlRequest $request): RedirectResponse
    {
        $url->update($request->validated());

        return redirect()->back()
            ->with('success', __('Url successfully updated'));
    }

    public function edit(Url $url)
    {
        return view('urls.edit', [
            'url' => $url,
        ]);
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
        return redirect()->route('urls.index')
            ->with('success', __('Url successfully deleted'));
    }
}
