<?php

namespace App\Models;

use App\Models\Bounty;
use App\Models\Content;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    protected $table = 'answer';

    public $timestamps = false;

    protected $primaryKey = 'id_content';

    use HasFactory;

    protected $fillable = [
        'title', 
        'id_content',
        'bounty_id',
    ];

    public function content()
    {
        return $this->hasOne(Content::class, 'id', 'id_content');
    }

    public function bounty()
    {
        return $this->belongsTo(Bounty::class, 'bounty_id', 'id_content');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'answer_id', 'id_content');
    }

}
