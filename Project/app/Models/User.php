<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Import Eloquent relationship classes.
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    
}
