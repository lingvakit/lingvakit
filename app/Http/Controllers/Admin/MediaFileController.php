<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaFileController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();

        $audioFiles = MediaFile::where([
            ['author_id', $currentUser->id],
            ['type', 'audio'],
        ])->orderBy('created_at', 'desc')->paginate(24);

        $images = MediaFile::where([
            ['author_id', $currentUser->id],
            ['type', 'image'],
        ])->orderBy('created_at', 'desc')->paginate(24);

        $videoFiles = MediaFile::where([
            ['author_id', $currentUser->id],
            ['type', 'video'],
        ])->orderBy('created_at', 'desc')->paginate(24);

        $files = MediaFile::where([
            ['author_id', $currentUser->id],
            ['type', 'file'],
        ])->orderBy('created_at', 'desc')->paginate(24);

        return view('cms.media.index',[
            'audioFiles' => $audioFiles,
            'images' => $images,
            'videoFiles' => $videoFiles,
            'files' => $files,
        ]);
    }

    public function create()
    {
        return view('cms.media.create');
    }

    public function store(Request $request)
    {
        $inputs = $request->file('filename');

        if ($inputs) {
            foreach ($inputs as $input) {
                if ($input) {
                    $media = new MediaFile;
                    $media->uploadFile($input);
                }
            }
        }
        return back();
    }

    public function ajaxStore(Request $request)
    {
        $inputs = $request->file('filename');
        $files = array();

        foreach ($inputs as $input) {
            if ($input) {
                $media = new MediaFile;
                $media->uploadFile($input);
                $files[] = $media;
            }
        }
        return Response()->json([
            'success' => 'Images have been uploaded!',
            'files' => $files
        ]);
    }

    public function getAjaxData($id)
    {
        $file = MediaFile::find($id);
        $baseUrl = env('APP_URL');

        return Response()->json([
            'id' => $file->id,
            'title' => $file->title,
            'path' => $file->getMiddleImage(),
            'alt' => $file->alt,
            'type' => $file->type,
            'size' => $file->getFileSize(),
            'duration' => $file->duration,
            'link' => "$baseUrl/uploads/$file->path/$file->filename",
        ]);
    }

    public function update(Request $request, $id)
    {
        MediaFile::find($id)->update($request->all());
        return response()->json([
            'success' => 'Data Saved',
            'result' => $request->all()
        ]);
    }

    public function destroy($id)
    {
        MediaFile::find($id)->remove();
        return back();
    }

    public function getFilesByAjax($fileType)
    {
        $currentUser = Auth::user();

        $mediaFiles = MediaFile::where([
            ['author_id', $currentUser->id],
            ['type', $fileType],
        ])->orderBy('id', 'desc')->get();
        $files = array();

        foreach ($mediaFiles as $mediaFile) {
            $files[] = [
                'id' => $mediaFile->id,
                'title' => $mediaFile->title,
                'path' => $mediaFile->getMiddleImage(),
                'alt' => $mediaFile->alt,
                'type' => $mediaFile->type,
                'size' => $mediaFile->getFileSize(),
                'duration' => $mediaFile->duration,
                'link' => "{$mediaFile->getMsMediaUrl()}/uploads/{$mediaFile->path}/{$mediaFile->filename}",
            ];
        }

        return response()->json([
            'files' => $files
        ]);
    }

    public function downloadFile(MediaFile $file)
    {
        $path = public_path('/uploads/'.$file->path.'/') . $file->filename;
        return response()->download($path);
    }
}
