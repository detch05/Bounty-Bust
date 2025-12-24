<?php

namespace App\Policies;

use App\Models\Bounty;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BountyPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Bounty $bounty): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return isset($user->id);
    }

    public function update(User $user, Bounty $bounty): bool
    {
        $ownerId = $bounty->content?->user_id ?? null;
        return $user->id === $ownerId || $user->hasRole('admin');
    }

    public function delete(User $user, Bounty $bounty): bool
    {
        $ownerId = $bounty->content?->user_id ?? null;
        return $user->id === $ownerId || $user->hasRole('admin');
    }
}
