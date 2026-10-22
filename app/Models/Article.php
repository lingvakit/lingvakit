<?php
declare(strict_types=1);

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['rubric_id', 'title', 'slug', 'content', 'image'];

    public function rubric()
    {
        return $this->belongsTo(Rubric::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function image()
    {
        return $this->hasOne(MediaFile::class, 'id', 'image');
    }

    public function getImage() : string
    {
        if($this->image) {
            return $this->image()->first()->getPath();
        }
        return '/assets/cms/img/no-image.jpg';
    }
}
