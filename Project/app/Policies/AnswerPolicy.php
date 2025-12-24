<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Answer $answer): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return isset($user->id);
    }

    public function update(User $user, Answer $answer): bool
    {
        return $user->id === ($answer->content?->user_id ?? null) || $user->hasRole('admin') ;
    }

    public function delete(User $user, Answer $answer): bool
    {
        return $user->id === ($answer->content?->user_id ?? null) || $user->hasRole('admin');
    }
}
