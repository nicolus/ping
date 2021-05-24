<?php

namespace Tests\Feature;

use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UrlManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_user_can_add_url()
    {
        Http::fake();

        $this->actingAs(User::find(1));

        $response = $this->post('/urls', [
            'name' => 'myName',
            'url' => 'https://my-url.com'
        ]);

        $this->assertEquals('myName', Url::latest('id')->first()->name);
        $response->assertRedirect();
    }

    public function test_user_can_delete_url()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $urlCount = $user->urls()->count();

        $response = $this->delete('/urls/1', [
            'name' => 'myName',
            'url' => 'https://my-url.com'
        ]);

        $this->assertEquals($urlCount - 1, $user->urls()->count());
        $response->assertRedirect();
    }
}
