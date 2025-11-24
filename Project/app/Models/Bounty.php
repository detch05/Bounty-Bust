<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bounty extends Model
{
    protected $table = 'bounty'; 

    // CORREÇÃO 1: Define a chave primária correta
    protected $primaryKey = 'id_content'; 

    use HasFactory;

    public function content()
    {
        return $this->hasOne(Content::class, 'id', 'id_content');
    }
}
