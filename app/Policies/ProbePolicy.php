<?php

namespace App\Policies;

use App\Models\Probe;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProbePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function view(User $user, Probe $probe): bool
    {
        return $probe->user_id === $user->id;
    }

    public function edit(User $user, Probe $probe): bool
    {
        return $probe->user_id === $user->id;
    }

    public function update(User $user, Probe $probe): bool
    {
        return $probe->user_id === $user->id;
    }

    public function delete(User $user, Probe $probe): bool
    {
        return $probe->user_id === $user->id;
    }
}
