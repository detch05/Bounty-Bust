<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    
    protected $primaryKey = 'id_content';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_content',
        'bounty_id',
        'answer_id',
        'parent_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function content()
    {
        return $this->belongsTo(Content::class, 'id_content', 'id');
    }

    public function bounty()
    {
        return $this->belongsTo(Bounty::class, 'bounty_id', 'id_content');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id', 'id_content');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'id_content');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id_content');
    }
}
