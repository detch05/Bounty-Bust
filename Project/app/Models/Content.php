<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Content extends Model
{
    protected $table = 'content'; 

    public $timestamps = true;

    protected $fillable = [
        'description',
        'user_id', 
        'version',
        'rating',
    ];

    // A chave primária é 'id' (o padrão do Laravel, mas explicitamos)
    protected $primaryKey = 'id';
    
    // Se não tiveres colunas 'created_at' e 'updated_at', deves usar:
    // public $timestamps = false; 

    use HasFactory;

    // Se necessário, podes definir aqui a relação inversa para o Model Bounty
    public function bounty()
    {
        return $this->belongsTo(Bounty::class, 'id_content', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}