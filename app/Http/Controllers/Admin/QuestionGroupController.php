<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Application\Quiz\Actions\QuestionGroup\StoreAction;
use App\Application\Quiz\Actions\QuestionGroup\UpdateAction;
use App\Application\Quiz\Enum\QuestionType;
use App\Application\Quiz\Services\QuestionGroupViewService;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionGroup\StoreRequest;
use App\Http\Requests\UpdateQuestionGroupRequest;
use App\Models\LMS\Course;
use App\Models\LMS\Quiz;
use App\Models\LMS\Stage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class QuestionGroupController extends Controller
{
    public function __construct(
        private readonly QuestionGroupViewService $service,
        private readonly StoreAction              $createAction,
        private readonly UpdateAction             $updateAction,
    ) {
    }

    public function show(
        Course $course,
        Stage $stage,
        Quiz $quiz,
        string $uuid,
    ): View {
        return view(
            view: 'cms.courses.quizzes.question-groups.single-choice.show',
            data: $this->service->prepareDataForShowView($course, $stage, $quiz, $uuid)
        );
    }

    public function create(
        Course $course,
        Stage $stage,
        Quiz $quiz,
        QuestionType $questionType
    ): View {
        return view(
            view: 'cms.courses.quizzes.question-groups.single-choice.create',
            data: $this->service->prepareDataForCreateView($course, $stage, $quiz, $questionType)
        );
    }

    /**
     * @throws \Throwable
     */
    public function store(
        StoreRequest $request,
        Course $course,
        Stage $stage,
        Quiz $quiz,
        QuestionType $questionType
    ): RedirectResponse {
        $uuid = DB::transaction(function () use ($request, $course, $stage, $quiz, $questionType) {
            return $this->createAction->execute(
                data: $request->toMsPayload(
                    uuid: $quiz->uuid,
                    questionType: $questionType->value
                )
            );
        });

        return redirect()->route(
            route: 'questionGroup.show',
            parameters: [$course, $stage, $quiz, $uuid]
        );
    }



    public function edit(
        Course $course,
        Stage $stage,
        Quiz $quiz,
        string $uuid,
    ): View {
        return view(
            view: 'cms.courses.quizzes.question-groups.single-choice.edit',
            data: $this->service->prepareDataForShowView($course, $stage, $quiz, $uuid)
        );
    }

    public function update(
        UpdateQuestionGroupRequest $request,
        Course $course,
        Stage $stage,
        Quiz $quiz,
        string $uuid,
    ): RedirectResponse {
        $this->updateAction->execute(
            uuid: $uuid,
            data: $request->toMsPayload()
        );

        return redirect()->route(
            route: 'questionGroup.show',
            parameters: [$course, $stage, $quiz, $uuid]
        );
    }
}
