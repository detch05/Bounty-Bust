<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bounty extends Model
{
    protected $table = 'bounty'; 

    public $timestamps = false;

    protected $fillable = [
        'id_content', 
        'title', 
        'media', 
        'reward'
    ];

    // CORREÇÃO 1: Define a chave primária correta
    protected $primaryKey = 'id_content'; 

    use HasFactory;

    public function content()
    {
        return $this->hasOne(Content::class, 'id', 'id_content');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'bounty_tag', 'bounty_id', 'tag_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'bounty_id', 'id_content');
    }
}
