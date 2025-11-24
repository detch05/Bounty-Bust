<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



class User extends Authenticatable
{
    use Notifiable;
    // Disable default created_at and updated_at timestamps for this model.
    public $timestamps  = false;
    public $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * Only these fields may be filled using methods like create() or update().
     * This protects against mass-assignment vulnerabilities.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'location',
        'bio',
        'points',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden when serializing the model
     * (e.g., to arrays or JSON).
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts =
    [
        'id' => 'integer',
        'email' => 'string',
        'name' => 'string',
        'username' => 'string',
        'location' => 'string',
        'bio' => 'string',
        'points' => 'integer',
        'profile_picture' => 'string',
    ];


    public function showProfile($id){
        $profile= User::findorFail($id);
        return view('pages.profile',compact('profile'));
    }
 
}
