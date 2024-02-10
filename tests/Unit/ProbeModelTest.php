<?php

use App\Models\Check;
use App\Models\User;
use App\Models\Probe;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $user = User::factory()->create();
    $this->probe = Probe::factory()->for($user)->create();
});

it('returns false when latest check is null', function () {
    expect($this->probe->isOnline())->toBeFalse();
});

it('returns false when latest check is offline', function () {
    Check::factory()->for($this->probe)->state(['online' => false])->create();
    expect($this->probe->isOnline())->toBeFalse();
});

it('returns true when latest check is online', function () {
    Check::factory()->for($this->probe)->state(['online' => true])->create();
    expect($this->probe->isOnline())->toBeTrue();
});