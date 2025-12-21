<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';

    public function bounty()
    {
        return $this->belongsToMany(Bounty::class, 'bounty_tag', 'tag_id', 'bounty_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'tag_follow', 'tag_id', 'user_id');
    }
}

