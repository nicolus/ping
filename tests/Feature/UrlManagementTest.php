<?php

use App\Models\Probe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

test('user cant add invalid url', function () {
    Http::fake();

    $this->actingAs(User::find(1));

    $response = $this->post('/probes', [
        'name' => 'myName',
        'url' => 'not-an-url'
    ]);

    $this->assertDatabaseMissing('probes', ['url' => 'not-an-url']);
    $response->assertSessionHasErrors();
});

test('user can add url', function () {
    Http::fake();

    $this->actingAs(User::find(1));

    $response = $this->post('/probes', [
        'name' => 'myName',
        'url' => 'https://my-url.com'
    ]);

    expect(Probe::latest('id')->first()->name)->toEqual('myName');
    $response->assertRedirect();
});

test('user can delete url', function () {
    $user = User::find(1);
    $this->actingAs($user);

    $urlCount = $user->probes()->count();

    $response = $this->delete('/probes/1', [
        'name' => 'myName',
        'url' => 'https://my-url.com'
    ]);

    expect($user->probes()->count())->toEqual($urlCount - 1);
    $response->assertRedirect();
});

test('index shows url list', function () {
    Http::fake();
    $this->actingAs(User::find(1));

    $this->get('/probes')
        ->assertStatus(200)
        ->assertSee('gooddomain.com');
});

test('can edit url', function () {
    Http::fake();
    $this->actingAs(User::find(1));

    $this->get('/probes/1/edit')
        ->assertStatus(200)
        ->assertSee('gooddomain.com');
});

test('can update url', function () {
    Http::fake();
    $this->actingAs(User::find(1));

    $this->put('/probes/1', [
        'name' => 'UpdatedName',
        'url' => 'https://gooddomain.com',
    ])->assertRedirect();

    $this->assertDatabaseHas('probes', ['name' => 'UpdatedName']);
});

test('cannot update url from other user', function () {
    Http::fake();
    $this->actingAs(User::find(1));

    $otherUser = User::factory(1)->has(Probe::factory(1))->create()->first();
    $otherProbe = $otherUser->probes()->first();

    $this->get('/probes/' . $otherProbe->id . '/edit')
        ->assertStatus(403);

    $this->put('/probes/' . $otherProbe->id , [
        'name' => 'UpdatedName',
        'url' => 'https://gooddomain.com',
    ])->assertStatus(403);
});
