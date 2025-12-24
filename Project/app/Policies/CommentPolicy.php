<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Comment $comment): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return isset($user->id);
    }

    public function update(User $user, Comment $comment): bool
    {
        $ownerId = $comment->user?->id ?? null;
        return $user->id === $ownerId || $user->hasRole('admin');
    }

    public function delete(User $user, Comment $comment): bool
    {
        $ownerId = $comment->user?->id ?? null
        return $user->id === $ownerId || $user->hasRole('admin');
    }
}
