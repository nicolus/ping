<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can edit settings', function () {
    $user = User::find(1);
    $this->actingAs($user)
        ->get('/settings')
        ->assertSee("$user->email");
});

test('can update settings', function () {
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

    expect($user->phone_number)->toEqual('+33111111111');
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
    $this->seed(\Database\Seeders\DatabaseSeeder::class);

    $this->actingAs(User::find(1));

    $this->get('/probes')
        ->assertSee('gooddomain.com');
});
