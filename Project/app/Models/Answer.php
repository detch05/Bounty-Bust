<?php

namespace App\Models;

use App\Models\Bounty;
use App\Models\Content;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;


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

    public function hasImage(){
        $image_suffix = $this->id_content . '.jpg';
        $img_path = 'answers/normal/' . $image_suffix;
        return Storage::disk('public')->exists($img_path);
    }

    public function getImagePath(){
        $suffix = $this->id_content . '.jpg';
        $img= 'answers/normal/' . $suffix;
        return $img;
    }

    public function isCorrect()
    {
        return $this->is_correct;
    }

        public function handleAnswerIMG(UploadedFile $uploadedFile)
    {
        $image_suffix = $this->id_content . '.jpg';
        $normal_img_path = 'answers/normal/' . $image_suffix;
        Storage::disk('public')->delete(['normal_img_path']);

        $manager = new ImageManager(new Driver());
        $img = $manager->read($uploadedFile->getRealPath());

        $normal_img = clone $img;
        $img_data= $normal_img->cover(400, 300, 'center')->encode(new JpegEncoder(90));
        Storage::disk('public')->put($normal_img_path,$img_data);
    }


}
