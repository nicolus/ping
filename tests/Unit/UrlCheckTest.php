<?php

use App\Models\Probe;
use Illuminate\Support\Facades\Http;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    Http::fake([
       'gooddomain.com' => Http::response(),
       'baddomain.com' => Http::response(null, 500),
   ]);
});

test('check good uri', function () {
    $url = Probe::where('url', 'https://gooddomain.com')->first();
    $url->makeCheck();

    $this->assertDatabaseHas('checks', ['probe_id' => $url->id, 'status' => 200]);
});

test('check bad uri', function () {
    $url = Probe::where('url', 'https://baddomain.com')->first();
    $url->makeCheck();

    $this->assertDatabaseHas('checks', ['probe_id' => $url->id, 'status' => 500]);
});
