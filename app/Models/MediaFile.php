<?php

namespace App\Models;

use App\Models\LMS\Conformity;
use App\Models\LMS\Course;
use App\Models\LMS\Lesson;
use App\Models\LMS\Question;
use App\Models\LMS\QuestionAudio;
use App\Models\LMS\Quiz;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class MediaFile extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'filename', 'path', 'alt', 'type', 'size', 'duration', 'author_id'];

    public function uploadFile($file)
    {
        $currentUser = Auth::user();
        $extImages = ['jpg', 'png', 'gif'];
        $extAudio = ['wav', 'mp3'];
        $extVideo = ['mp4'];

        if ($file == null) {
            return;
        }

        $extension = strtolower($file->extension());
        if ($extension == 'jpeg') {
            $extension = 'jpg';
        }

        $type = 'file';

        if (in_array($extension, $extImages)) {
            $type = 'image';
            $filename = 'image-' . Str::random(3) . time() . '.' . $extension;
            $path = 'teachers/id_' . $currentUser->id . '/' . 'img/' . date("Y") . '/' . date("m");
            $file->storeAs($path . '/', $filename, 'uploads');

            // Make thumbs
            $thumb = Image::make($file);

            // Make large image
            if (getimagesize($file)[0] > 1200 || getimagesize($file)[1] > 1200) {
                $thumbPath = 'uploads/' . $path . '/' . strstr($filename, '.', true) . '_large.' . $extension;
                $thumb->resize(1200, 1200, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath, 100);
            }

            // Make middle image
            if (getimagesize($file)[0] > 600 || getimagesize($file)[1] > 600) {
                $thumbPath = 'uploads/' . $path . '/' . strstr($filename, '.', true) . '_middle.' . $extension;
                $thumb->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath, 100);
            }

            // Make small image
            if (getimagesize($file)[0] > 300 || getimagesize($file)[1] > 300) {
                $thumbPath = 'uploads/' . $path . '/' . strstr($filename, '.', true) . '_small.' . $extension;
                $thumb->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath, 100);
            }
        } elseif (in_array($extension, $extAudio)) {
            $type = 'audio';
            $filename = 'audio-' . Str::random(3) . time() . '.' . $extension;
            $path = 'teachers/id_' . $currentUser->id . '/' . 'audio/' . date("Y") . '/' . date("m");
            $file->storeAs($path . '/', $filename, 'uploads');
        } elseif (in_array($extension, $extVideo)) {
            $type = 'video';
            $filename = 'video-' . Str::random(3) . time() . '.' . $extension;
            $path = 'teachers/id_' . $currentUser->id . '/' . 'video/' . date("Y") . '/' . date("m");
            $file->storeAs($path . '/', $filename, 'uploads');
        } else {
            $filename = 'file-' . Str::random(3) . time() . '.' . $extension;
            $path = 'teachers/id_' . $currentUser->id . '/' . 'files/' . date("Y") . '/' . date("m");
            $file->storeAs($path . '/', $filename, 'uploads');
        }

        $this->title = $file->getClientOriginalName();
        $this->filename = $filename;
        $this->path = $path;
        $this->type = $type;
        $this->size = $file->getSize();
        $this->author_id = $currentUser->id;
        $this->save();
    }

    public function removeFile()
    {
        if ($this->filename != null) {
            $ext = strstr($this->filename, '.');
            $filename = str_replace($ext, '', $this->filename);

            Storage::disk('uploads')->delete([
                $this->path . '/' . $this->filename,
                $this->path . '/' . $filename . '_large' . $ext,
                $this->path . '/' . $filename . '_middle' . $ext,
                $this->path . '/' . $filename . '_small' . $ext
            ]);
        }
    }

    public function getPath(): string
    {
        if ($this->filename == null && $this->type === 'image') {
            return asset('/assets/cms/img/no-image.jpg');
        }

        return $this->getMsFile();
    }

    public function getLargeImage(): string
    {
        if ($this->type === 'image') {
            $ext = strstr($this->filename, '.');
            $filename = str_replace($ext, '', $this->filename);
            $fileExists = Storage::disk('uploads')->exists($this->path . '/' . $filename . '_large' . $ext);
            if ($fileExists) {
                return asset('uploads/' . $this->path . '/' . $filename . '_large' . $ext);
            }
        }
        return $this->getPath();
    }

    public function getMiddleImage(): string
    {
        if ($this->type === 'image') {
            $ext = strstr($this->filename, '.');
            $filename = str_replace($ext, '', $this->filename);
            $fileExists = Storage::disk('uploads')->exists($this->path . '/' . $filename . '_middle' . $ext);
            if ($fileExists) {
                return asset('uploads/' . $this->path . '/' . $filename . '_middle' . $ext);
            }
        }

        return $this->getPath();
    }

    public function getSmallImage(): string
    {
        if ($this->type === 'image') {
            $ext = strstr($this->filename, '.');
            $filename = str_replace($ext, '', $this->filename);
            $fileExists = Storage::disk('uploads')->exists($this->path . '/' . $filename . '_small' . $ext);
            if ($fileExists) {
                return asset('uploads/' . $this->path . '/' . $filename . '_small' . $ext);
            }
        }

        return $this->getPath();
    }

    public function unpinFile()
    {
        if ($this->type === 'image') {
            Course::where('image', $this->id)->update(['image' => null]);
            Lesson::where('image', $this->id)->update(['image' => null]);
            Quiz::where('image', $this->id)->update(['image' => null]);
            Question::where('image', $this->id)->update(['image' => null]);
            Conformity::where('image', $this->id)->update(['image' => null]);
        }
        if ($this->type === 'audio') {
            Lesson::where('audio', $this->id)->update(['audio' => null]);
            Quiz::where('audio', $this->id)->update(['audio' => null]);
            QuestionAudio::where('audio', $this->id)->update(['audio' => null]);
            Conformity::where('audio', $this->id)->update(['audio' => null]);
        }
    }

    public function remove()
    {
        $this->unpinfile();
        $this->removeFile();
        $this->delete();
    }

    public function getFileSize(): string
    {
        $size = round($this->size);

        if ($size > 1048576) {
            return round($size / 1024 / 1024) . ' Mb';
        }
        if ($size > 1024) {
            return round($size / 1024) . ' Kb';
        }
        return $size . ' b';
    }

    private function getMsFile(): string
    {
        // TODO: Remove this code after fix migrating video files
        if ($this->type === 'video') {
            $parts = explode('_', $this->path);

            if (count($parts) >= 6) {
                $newPath =
                    $parts[0] . '/' .
                    $parts[1] . '_' . $parts[2] . '/' .
                    $parts[3] . '/' .
                    $parts[4] . '/' .
                    $parts[5];

                return asset('/uploads/' . $newPath . '/' . $this->filename);
            }

            // fallback — если структура не совпадает
            return asset('/uploads/' . $this->path . '/' . $this->filename);
        }


        $rootMsPath = config('app.url') . config('services.ms.media');
        $partsPath = explode('/', $this->path);
        $path = implode('_', $partsPath) . '/' . $this->filename;

        return "$rootMsPath/$path";
    }
}
