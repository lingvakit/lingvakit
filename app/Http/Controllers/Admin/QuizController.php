<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Application\Quiz\Actions\CreateAction;
use App\Application\Quiz\Actions\DeleteAction;
use App\Application\Quiz\Actions\UpdateAction;
use App\Application\Quiz\Services\QuizViewService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizRequest;
use App\Models\LMS\Course;
use App\Models\LMS\Quiz;
use App\Models\LMS\Stage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function __construct(
        private readonly CreateAction $createAction,
        private readonly UpdateAction $updateAction,
        private readonly DeleteAction $deleteAction,
        private readonly QuizViewService $quizViewService,
    ) {
    }

    public function create(Course $course, Stage $stage): View
    {
        return view(
            view: 'cms.courses.quizzes.create',
            data: $this->quizViewService->prepareDataForCreateView($course, $stage)
        );
    }

    /**
     * @throws \Exception
     */
    public function store(StoreQuizRequest $request, Course $course, Stage $stage): RedirectResponse
    {
        $quiz = DB::transaction(function () use ($request, $course, $stage) {
            return $this->createAction->execute(
                data: $request->validated(),
                course: $course,
                stage: $stage
            );
        });

        return redirect()->route('quizzes.show', [$course, $stage, $quiz]);
    }

    public function show(Course $course, Stage $stage, Quiz $quiz): View
    {
        return view(
            view: 'cms.courses.quizzes.show',
            data: $this->quizViewService->prepareDataForShowView($course, $stage, $quiz)
        );
    }

    public function edit(Course $course, Stage $stage, Quiz $quiz): View
    {
        return view(
            view: 'cms.courses.quizzes.edit',
            data: $this->quizViewService->prepareDataForEditView($course, $stage, $quiz)
        );
    }

    public function update(StoreQuizRequest $request, Course $course, Stage $stage, Quiz $quiz): RedirectResponse
    {
        $quiz = DB::transaction(function () use ($request, $quiz, $course) {
            return $this->updateAction->execute(
                data: $request->validated(),
                quiz: $quiz,
                course: $course
            );
        });

        return redirect()->route('quizzes.show', [$course, $stage, $quiz]);
    }

    public function destroy(Course $course, Stage $stage, Quiz $quiz): RedirectResponse
    {
        DB::transaction(function () use ($quiz, $course) {
            $this->deleteAction->execute($course, $quiz);
        });

        return redirect()->route('courses.show', $course);
    }

    public function removeImage(Course $course, Stage $stage, Quiz $quiz)
    {
        $quiz->update(['image' => null]);
    }

    public function removeAudio(Course $course, Stage $stage, Quiz $quiz)
    {
        $quiz->update(['audio' => null]);
    }

    public function removeVideo(Course $course, Stage $stage, Quiz $quiz)
    {
        $quiz->update(['video' => null]);
    }
}
