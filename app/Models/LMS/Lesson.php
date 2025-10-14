<?php

namespace App\Models\LMS;

use App\Models\MediaFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lms_lessons';

    protected $fillable = ['title', 'description', 'image', 'audio', 'video', 'duration', 'topic_id'];

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'id', 'lms_topics');
    }

    public function audio()
    {
        return $this->hasOne(MediaFile::class, 'id', 'audio');
    }

    public function audios()
    {
        return $this->hasMany(LessonAudio::class, 'lesson_id');
    }

    public function image()
    {
        return $this->hasOne(MediaFile::class, 'id', 'image');
    }

    public function video()
    {
        return $this->hasOne(MediaFile::class, 'id', 'video');
    }

    public function additionalVideos()
    {
        return $this->hasMany(LessonVideo::class, 'lesson_id');
    }

    public function presentation()
    {
        return $this->hasOne(LessonPresentation::class);
    }

    public function homeWork()
    {
        return $this->hasOne(LessonHomeWork::class);
    }

    public static function add($fields, $topic)
    {
        $lesson = new static();
        $lesson->fill($fields);
        $lesson->topic_id = $topic->id;
        $lesson->save();

        return $lesson;
    }

    public function getAudio() : string
    {
        if ($this->audio == null) {
            return false;
        }
        return $this->audio()->first()->getPath();
    }

    public function getImage() : string
    {
        if($this->image) {
            return $this->image()->first()->getPath();
        }
        return '/assets/cms/img/no-image.jpg';
    }


    public function getImageAlt()
    {
        if ($this->image) {
            return $this->image()->first()->alt;
        }
        return false;
    }

    public function getVideo() : string
    {
        $video = $this->video;
        if($video && is_numeric($video)) {
            return $this->video()->first()->getPath();
        }
        return false;
    }

    public function isExternalVideo() : bool
    {
        $video = $this->video;
        if ($video && !is_numeric($video)) {
            return true;
        }
        return false;
    }

    public function remove()
    {
        $files = LessonFile::where('lesson_id', $this->id)->get();
        foreach ($files as $file) {
            $file->remove();
        }
        foreach ($this->audios as $audio) {
            $audio->remove();
        }
        Topic::find($this->topic_id)->delete();
        $this->topic()->delete();
        $this->delete();
    }

    public function getVideoId() : string
    {
        $videoArr = explode('/', $this->video);
        return end($videoArr);
    }

    public function getDuration() : string
    {
        return formatDuration($this);
    }
}
