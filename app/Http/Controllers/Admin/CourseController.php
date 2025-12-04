<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LMS\Category;
use App\Models\LMS\Course;
use App\Models\LMS\Language;
use App\Models\MediaFile;
use App\Models\MetaCourse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function reactPage(): View
    {
        return view('layouts.cms-react');
    }

    public function index()
    {
        $currentUser = Auth::user();
        $courses = Course::where('author_id', $currentUser->id)->get();

        return view('cms.courses.index', [
            'currentUser' => $currentUser,
            'courses' => $courses,
        ]);
    }

    public function allCourses()
    {
        return view('cms.courses.index', [
            'currentUser' => Auth::user(),
            'courses' => Course::all()
        ]);
    }

    public function create()
    {
        $uncategorized = Category::where('name', 'Uncategorized')->first();

        return view('cms.courses.create', [
            'categories' => Category::all()->except($uncategorized->id),
            'languages' => Language::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'language_id' => 'required',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if ($request->has('category_id')) {
            $category = Category::find($request->input('category_id'));
            if ($request->input('category_id') == 0) {
                $category = Category::create(['name' => $request->input('category')]);
            }
        } else {
            $category = Category::find(1);
        }

        $course = Course::add($request->all(), Auth::user());
        $course->addCategory($category);
        $course->switchIsNew($request->input('is_new'));
        $course->switchIsPublished($request->input('is_published'));

        MetaCourse::add($request, $course);
        $course->students()->attach(Auth::user()->id);

        return redirect()->route('courses.show', $course->id);
    }

    public function show(Course $course)
    {
        return view('cms.courses.show', [
            'currentUser' => Auth::user(),
            'course' => $course
        ]);
    }

    public function edit(Course $course)
    {
        $uncategorized = Category::where('name', 'Uncategorized')->first();
        $audio = MediaFile::where('type', 'audio')->orderBy('id', 'desc')->get();
        $images = MediaFile::where('type', 'image')->orderBy('id', 'desc')->get();
        $videoFiles = MediaFile::where('type', 'video')->orderBy('id', 'desc')->get();

        return view('cms.courses.edit', [
            'course' => $course,
            'categories' => Category::all()->except($uncategorized->id),
            'languages' => Language::all(),
            'audioFiles' => $audio,
            'images' => $images,
            'videoFiles' => $videoFiles
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'language_id' => 'required',
        ]);

        if ($request->has('category_id')) {
            $category = Category::find($request->input('category_id'));
            if ($request->input('category_id') == 0) {
                $category = Category::create(['name' => $request->input('category')]);
            }
        } else {
            $category = Category::find(1);
        }

        $course->update($request->all());
        if ($request->input('type') === 'free') {
            $course->update([
                'price' => 0,
                'sale_price' => 0,
            ]);
        }
        $course->addCategory($category);
        $course->switchIsNew($request->input('is_new'));
        $course->switchIsPublished($request->input('is_published'));

        $course->meta()->update([
            'title' => $request->meta_title,
            'description' => $request->meta_description,
            'keywords' => $request->meta_keywords,
        ]);

        return redirect()->route('courses.show', $course->id);
    }

    public function destroy(Course $course)
    {
        $course->remove();
        return redirect()->route('courses.index');
    }

    public function removeImage(Course $course)
    {
        $course->update(['image' => null]);
    }
    public function removeVideo(Course $course)
    {
        $course->update(['video' => null]);
    }
}
