<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_can_edit_settings()
    {
        $user = User::find(1);
        $this->actingAs($user)
            ->get('/settings')
            ->assertSee("$user->email");
    }

    public function test_can_update_settings()
    {
        $user = User::find(1);

        $this->actingAs($user)
            ->post('/settings', [
                'phone_number' => '+3312'
            ])->assertSessionHasErrors()
            ->assertRedirect();

        $this->actingAs($user)
            ->post('/settings', [
            'phone_number' => '+33111111111'
        ])->assertSessionDoesntHaveErrors()
            ->assertRedirect();

        $user->refresh();

        $this->assertEquals('+33111111111', $user->phone_number);
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
        $this->actingAs(User::find(1));

        $this->get('/probes')
            ->assertSee('gooddomain.com');
    }
}
