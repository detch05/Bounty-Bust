<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentVote extends Model
{
    protected $table = 'content_vote';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'content_id',
        'vote'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id', 'id');
    }

}