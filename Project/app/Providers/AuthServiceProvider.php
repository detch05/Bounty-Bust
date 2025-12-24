<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Content;
use App\Models\Comment;
use App\Models\Answer;
use App\Models\Bounty;
use App\Models\ContentVote;
use App\Models\User;
use App\Policies\ContentPolicy;
use App\Policies\CommentPolicy;
use App\Policies\AnswerPolicy;
use App\Policies\BountyPolicy;
use App\Policies\ContentVotePolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Comment::class => CommentPolicy::class,
        Answer::class => AnswerPolicy::class,
        Bounty::class => BountyPolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
