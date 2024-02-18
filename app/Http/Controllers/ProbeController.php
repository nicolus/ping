<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProbeRequest;
use App\Models\Probe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ProbeController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Probe::class, 'probe');
    }

    public function index(): Response
    {
        return response()->view('probes.index');
    }

    public function store(StoreProbeRequest $request): RedirectResponse
    {
        auth()->user()->probes()
            ->create($request->validated())
            ->makeCheck();

        return redirect()->back()->with('success', __('Url successfully added'));
    }

    public function update(Probe $probe, StoreProbeRequest $request): RedirectResponse
    {
        $probe->update($request->validated());

        return redirect()->back()
            ->with('success', __('Url successfully updated'));
    }

    public function edit(Probe $probe): Response
    {
        return response()->view('probes.edit', [
            'url' => $probe,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Probe $probe
     * @return RedirectResponse
     */
    public function destroy(Probe $probe): RedirectResponse
    {
        $probe->delete();
        return redirect()->route('probes.index')
            ->with('success', __('Url successfully deleted'));
    }
}
