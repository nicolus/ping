<?php

namespace Tests\Feature;

use App\Models\Probe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UrlManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_user_cant_add_invalid_url()
    {
        Http::fake();

        $this->actingAs(User::find(1));

        $response = $this->post('/probes', [
            'name' => 'myName',
            'url' => 'not-an-url'
        ]);

        $this->assertDatabaseMissing('probes', ['url' => 'not-an-url']);
        $response->assertSessionHasErrors();
    }

    public function test_user_can_add_url()
    {
        Http::fake();

        $this->actingAs(User::find(1));

        $response = $this->post('/probes', [
            'name' => 'myName',
            'url' => 'https://my-url.com'
        ]);

        $this->assertEquals('myName', Probe::latest('id')->first()->name);
        $response->assertRedirect();
    }

    public function test_user_can_delete_url()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $urlCount = $user->probes()->count();

        $response = $this->delete('/probes/1', [
            'name' => 'myName',
            'url' => 'https://my-url.com'
        ]);

        $this->assertEquals($urlCount - 1, $user->probes()->count());
        $response->assertRedirect();
    }

    public function test_index_shows_url_list()
    {
        Http::fake();
        $this->actingAs(User::find(1));

        $this->get('/probes')
            ->assertSee('gooddomain.com');
    }

    public function test_can_edit_url()
    {
        Http::fake();
        $this->actingAs(User::find(1));

        $this->get('/probes/1/edit')
            ->assertSee('gooddomain.com');
    }

    public function test_can_update_url()
    {
        Http::fake();
        $this->actingAs(User::find(1));

        $this->put('/probes/1', [
            'name' => 'UpdatedName',
            'url' => 'https://gooddomain.com',
        ])->assertRedirect();

        $this->assertDatabaseHas('probes', ['name' => 'UpdatedName']);
    }

    public function test_cannot_update_url_from_other_user()
    {
        Http::fake();
        $this->actingAs(User::find(1));

        $otherUser = User::factory(1)->has(Probe::factory(1))->create()->first();
        $otherUrl = $otherUser->probes()->first();

        $this->get('/probes/1/edit')
            ->assertStatus(403);

        $this->put('/probes/' . $otherUrl->id , [
            'name' => 'UpdatedName',
            'url' => 'https://gooddomain.com',
        ])->assertStatus(403);
    }
}
