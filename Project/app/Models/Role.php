<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['name'];
    
    public static $IS_USER = 1;
    public static $IS_MODERATOR = 2;
    public static $IS_ADMIN = 3;


    public function users(){
        return $this->hasMany(User::class,'user_role','role_id');
    }
}
