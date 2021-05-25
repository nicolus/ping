<?php

namespace Tests\Unit;

use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UrlCheckTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function setUp(): void
    {
        parent::setUp();

        Http::fake([
           'gooddomain.com' => Http::response(),
           'baddomain.com' => Http::response(null, 500),
       ]);
    }

    public function testCheckGoodUri()
    {
        $url = Url::where('url', 'https://gooddomain.com')->first();
        $url->makeCheck();

        $this->assertDatabaseHas('checks', ['url_id' => $url->id, 'status' => 200]);
    }

    public function testCheckBadUri()
    {
        $url = Url::where('url', 'https://baddomain.com')->first();
        $url->makeCheck();

        $this->assertDatabaseHas('checks', ['url_id' => $url->id, 'status' => 500]);
    }
}
