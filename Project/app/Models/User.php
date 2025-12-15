<?php

namespace App\Models;


use Carbon\Carbon;
use App\Models\Content;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Modifiers\CropModifier;
use Intervention\Image\Modifiers\ResizeModifier;



class User extends Authenticatable
{
    use Notifiable;
    // Disable default created_at and updated_at timestamps for this model.
    public $timestamps = false;
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
        'created_at',
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
            'created_at' => 'datetime',
            'user_role' => 'integer',
        ];

    public function getDate(): string
    {
        return "Joined on " . Carbon::parse($this->created_at)->format('F j, Y');
    }
    public function content()
    {
        return $this->hasMany(Content::class, 'user_id', 'id');
    }

    public function handlePFP(UploadedFile $uploadedFile)
    {
        $imageName = $this->id . '.jpg';
        $imgPath = public_path('img/users');

        if (file_exists($imgPath . '/' . $imageName)) {
            unlink($imgPath . '/' . $imageName);
        }

        $manager = new ImageManager(new Driver());
        $img = $manager->read($uploadedFile->getRealPath());

        $shortSide = min($img->width(), $img->height());
        $img = $img->modify(new CropModifier($shortSide, $shortSide, position: 'center'));
        $img = $img->modify(new ResizeModifier(400, 400));
        $img = $img->encode(new JpegEncoder(quality: 90));
        $img->save($imgPath . '/' . $imageName);

        return $imageName;
    }

      protected function makeName(string $firstName, string $lastName): string
    {
        // No whitespaces should be presented in each of the fields
        $str1 = trim($firstName);
        $str2 = trim($lastName);
        return preg_replace('/\s+/', ' ', "$str1 $str2");
    }


    public function answers()
    {
        return $this->hasManyThrough(
            Answer::class,
            Content::class,
            'user_id',
            'id_content',
            'id',
            'id'
        );

    }
    public function bounties()
    {
        return $this->hasManyThrough(
            Bounty::class,
            Content::class,
            'user_id',
            'id_content',
            'id',
            'id'
        );
    }


    public function role()
    {
        return $this->belongsTo(Role::class, 'user_role', 'role_id');
    }

    public function hasRole($role)
    {
        return $this->role && $this->role->name === $role;
    }

}
