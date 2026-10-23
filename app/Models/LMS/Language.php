<?php
declare(strict_types=1);

namespace App\Models\LMS;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $table = 'lms_languages';

    protected $fillable = ['name', 'slug', 'label'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }


}
