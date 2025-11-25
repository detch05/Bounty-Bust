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
}

