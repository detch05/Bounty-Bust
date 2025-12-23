<?php

namespace App\Models;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
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

    public function handleBountyIMG(UploadedFile $uploadedFile)
    {
        $image_suffix = $this->id_content . '.jpg';
        $normal_img_path = 'bounties/normal/' . $image_suffix;
        $preview_img_path = 'bounties/preview/' . $image_suffix;

        Storage::disk('public')->delete(['normal_img_path','preview_img_path']);
       
        $manager = new ImageManager(new Driver());
        $img = $manager->read($uploadedFile->getRealPath());


        $normal_img = clone $img;
        $img_data= $normal_img->cover(140, 140, 'center')->encode(new JpegEncoder(90));
        Storage::disk('public')->put($normal_img_path,$img_data);

        $preview_img = clone $img;
        $preview_data = $preview_img->cover(640, 480, 'center')->encode(new JpegEncoder(90));
        Storage::disk('public')->put($preview_img_path,$preview_data);
        

       
    }

    public function getImagePath(bool $isPreview)
    {
        $suffix = $this->id_content . '.jpg';
        $main = $isPreview ? 'bounties/preview/' : 'bounties/normal/';
        return $main . $suffix;
    }


    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Content::class,
            'id',
            'id',
            'id_content',
            'user_id'
        );
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'bounty_id', 'id_content');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'bounty_id', 'id_content');
    }


}
