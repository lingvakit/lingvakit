<?php
declare(strict_types=1);

namespace App\Models\LMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $table = 'lms_categories';

    protected $fillable = ['name', 'label', 'description', 'image'];

    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'category_id');
    }

    public function uploadImage($image)
    {
        if ($image == null) { return; }
        $this->removeImage();

        $extension = $image->extension();
        if ($extension == 'jpeg') {
            $extension = 'jpg';
        }

        $filename = strtolower($this->slug) . '.' . $extension;
        $image->storeAs('img/categories', $filename, 'uploads');

        $this->image = $filename;
        $this->save();
    }

    public function removeImage()
    {
        if ($this->image != null) {
            Storage::disk('uploads')->delete('img/categories/' . $this->image);
        }
    }

    public function getImage()
    {
        if ($this->image == null) {
            return '/assets/cms/img/no-image.jpg';
        }

        return '/uploads/img/categories/' . $this->image;
    }

    public function remove()
    {
        $uncategorized = Category::where('name', 'Uncategorized')->first();

        foreach ($this->courses as $course) {
            $course->category_id = $uncategorized->id;
            $course->save();
        }
        foreach ($this->quizzes as $quiz) {
            $quiz->category_id = $uncategorized->id;
            $quiz->save();
        }
        $this->removeImage();
        $this->delete();
    }
}
