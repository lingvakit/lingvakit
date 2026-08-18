<?php

namespace App\Http\Controllers;

use App\Mail\Feedback;
use App\Models\Article;
use App\Models\FeedbackMessage;
use App\Models\LMS\Course;
use App\Models\LMS\CourseReview;
use App\Models\LMS\Language;
use App\Models\LMS\Result;
use App\Models\Rubric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::where([
            ['is_published', 1],
            ['is_allowed', 1],
        ]);

        if ($request->has('language')) {
            $courses->where('language_id', $request->language);
        }

        $noRubric = Rubric::where("title", "Без рубрики")->first();
        return view('home-page', [
            'courses' => $courses->orderBy('publish_date')->get(),
            'languages' => Language::all(),
            'rubrics' => Rubric::all()->except($noRubric->id)->sortBy('title')
        ]);
    }

    public function documentList()
    {
        return view('documents-list');
    }

    public function reviewsPage()
    {
        return view('reviews');
    }

    public function about()
    {
        return view('about');
    }

    public function learning(Request $request)
    {
        $courses = Course::where([
            ['is_published', 1],
            ['is_allowed', 1],
        ]);

        if ($request->has('language')) {
            $courses->where('language_id', $request->language);
        }

        return view('welcome', [
            'courses' => $courses->orderBy('publish_date')->get(),
            'languages' => Language::all(),
        ]);
    }

    public function contacts()
    {
        return view('site.contacts');
    }

    public function aboutUs()
    {
        return view('site.about-us');
    }

    public function privacyPolicy()
    {
        return view('site.privacy-policy');
    }

    public function offerAgreement()
    {
        return view('site.offer-agreement');
    }

    public function myCourses()
    {
        return view('site.my-courses', [
            'courses' => Auth::user()->courses
        ]);
    }

    public function getCourse(Course $course)
    {
        if ($course->type === 'free') {
            $course->students()->attach(Auth::user()->id);
        }

        return back();
    }

    public function showCourse(Course $course)
    {
        $user = Auth::user();

        if ($user) {
            Result::where([
                ['user_id', $user->id],
                ['topic_id', $user->id],
            ])->first();
        }

        return view('site.course.show', [
            'course' => $course,
            'user' => $user,
            'reviews' => CourseReview::where([
                ['course_id', $course->id],
                ['is_active', 1],
            ])->get(),
        ]);
    }

    public function storeReview(Request $request, Course $course)
    {
        $request->validate([
            'grade' => 'required',
            'review' => 'nullable|min:5',
        ]);

        CourseReview::create([
            'course_id' => $course->id,
            'user_id' => auth()->user()->id,
            'review' => $request->review,
            'grade' => $request->grade,
        ]);

        return back();
    }

    public function feedback(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ]);

        $feedback = FeedbackMessage::add($request->all());

        if ($feedback) {
            $availableDomains = [
                'gmail.com',
                'ya.ru',
                'yandex.ru',
                'mail.ru',
                'list.ru',
            ];

            foreach ($availableDomains as $domain) {
                if (str_contains($request->get('email'), $domain)) {
                    Mail::to('pristya@bk.ru')->send(new Feedback($feedback));
                }
            }
        }

        return back()->with('success', 'Ваше сообщение отправлено!');
    }

    public function articlesByRubric($rubricSlug)
    {
        $rubric = Rubric::where('slug', $rubricSlug)->first();
        $noRubric = Rubric::where("title", "Без рубрики")->first();
        $articles = Article::where('rubric_id', $rubric->id)->get();

        return view('category', [
            'allRubrics' => Rubric::all()->except($noRubric->id)->sortBy("title"),
            'rubric' => $rubric,
            'articles' => $articles->sortBy("title")
        ]);
    }

    public function articlePage($rubricSlug, $articleSlug)
    {
        $noRubric = Rubric::where("title", "Без рубрики")->first();
        return view('article', [
            'allRubrics' => Rubric::all()->except($noRubric->id)->sortBy("title"),
            'article' => Article::where("slug", $articleSlug)->first(),
            'rubric' => Rubric::where("slug", $rubricSlug)->first(),
        ]);
    }
}
