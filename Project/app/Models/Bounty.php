<?php

namespace App\Models;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

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

    public function handleBountyIMG(UploadedFile $uploadedFile){
        $image_suffix =$this->id_content . '.jpg';
        $normal_img_path = public_path('img/bounties/normal/') . $image_suffix;
        $preview_img_path = public_path('img/bounties/preview/') . $image_suffix;

        if (file_exists($normal_img_path)) {
            unlink($normal_img_path);
        }

        if (file_exists($preview_img_path)) {
            unlink($preview_img_path);
        }

        $manager = new ImageManager(new Driver());
        $img = $manager->read($uploadedFile->getRealPath());


        $normal_img = clone $img;
        $normal_img->cover(140,140,'center');
        $normal_img->encode(new JpegEncoder(90))->save($normal_img_path);
       
        $preview_img = clone $img;
        $preview_img->cover(800, 600, 'center'); 
        $preview_img->encode(new JpegEncoder(90))->save($preview_img_path);
    }

    public function user(){
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

   
}
