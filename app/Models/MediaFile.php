<?php

namespace App\Models;

use App\Domain\Media\Enum\FileType;
use App\Models\LMS\Conformity;
use App\Models\LMS\Course;
use App\Models\LMS\Lesson;
use App\Models\LMS\Question;
use App\Models\LMS\QuestionAudio;
use App\Models\LMS\Quiz;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\MediaFile
 *
 * @property int $id
 * @property string $filename
 * @property string $path
 * @property string $alt
 * @property FileType $type
 * @property float $size
 * @property float $duration
 * @property int $author_id
 * @property string|null $title
 */
class MediaFile extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'filename', 'path', 'alt', 'type', 'size', 'duration', 'author_id'];

    protected $casts = [
        'type' => FileType::class,
    ];

    /**
     * @throws Exception
     */
    public function uploadFile($file): void
    {
        $msUrl = $this->getMsMediaUrl();
        $extension = $file->guessExtension();
        $fileType = $this->getFileType($extension);

        $url = "{$msUrl}/api/{$fileType}/catalog_course/save";
        $response = Http::withoutVerifying()->attach(
            'file',
            file_get_contents($file),
            $file->getClientOriginalName()
        )->post($url);

        if (!$response->successful()) {
            throw new Exception('Uploading file error: ' . $response->body());
        }

        $filename = $this->getFilenameFromPath($response);
        $directoryPath = $this->getDirectoryPath($response);
        $currentUser = Auth::user();

        $this->title = $file->getClientOriginalName();
        $this->filename = $filename;
        $this->path = $directoryPath;
        $this->type = $fileType === "document" ? "file" : $fileType;
        $this->size = $file->getSize();
        $this->author_id = $currentUser->id;
        $this->save();
    }

    /**
     * @throws Exception
     */
    public function removeFile(): void
    {
        $msUrl = $this->getMsMediaUrl();
        $url = "$msUrl/api/file/{$this->type}/delete";

        $response = Http::withoutVerifying()->delete($url, [
            'path' => "{$this->path}/{$this->filename}"
        ]);

        if (!$response->successful()) {
            throw new Exception('Removing file error: ' . $response->body());
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

    public function getMsMediaUrl(): string
    {
        return config('app.url') . config('services.ms.media');
    }

    private function getMsFile(): string
    {
        $rootMsPath = config('app.url') . config('services.ms.media');
        $partsPath = explode('/', $this->path);
        $path = implode('_', $partsPath) . '/' . $this->filename;

        return "$rootMsPath/$path";
    }

    private function getFileType(string $extension): string
    {
        return match ($extension) {
            'jpg', 'png', 'gif' => 'image',
            'mp3', 'wav' => 'audio',
            'mp4' => 'video',
            'doc', 'docx', 'xls', 'xlsx', 'pdf' => 'document',
            default => 'unknown',
        };
    }

    private function getDirectoryPath(string $path): string
    {
        $pathArray = explode('/', $path);
        array_pop($pathArray);

        return implode('/', $pathArray);
    }

    private function getFilenameFromPath(string $path): string
    {
        $pathArray = explode('/', $path);

        return end($pathArray);
    }
}
