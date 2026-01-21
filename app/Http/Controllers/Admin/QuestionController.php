<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Application\Quiz\Actions\Question\CreateAction as QuestionCreateAction;
use App\Application\Quiz\Actions\QuestionGroup\StoreAction as QuestionGroupCreateAction;
use App\Application\Quiz\Enum\QuestionType;
use App\Application\Quiz\Services\QuestionViewService;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionGroup\StoreRequest;
use App\Http\Requests\StoreQuestionRequest;
use App\Models\LMS\Conformity;
use App\Models\LMS\ConformityOption;
use App\Models\LMS\Course;
use App\Models\LMS\Question;
use App\Models\LMS\QuestionAudio;
use App\Models\LMS\Quiz;
use App\Models\LMS\Stage;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function __construct(
        private readonly QuestionGroupCreateAction $questionGroupCreateAction,
        private readonly QuestionCreateAction $questionCreateAction,
        private readonly QuestionViewService $questionViewService,
    ) {
    }

    public function create(Course $course, Stage $stage, Quiz $quiz, QuestionType $questionType): View
    {
        return view(
            view: $questionType->getCreateViewName(),
            data: $this->questionViewService->prepareDataForCreateView($course, $stage, $quiz, $questionType),
        );
    }

    public function storeWithGroup(
        StoreRequest $request,
        Course       $course,
        Stage        $stage,
        Quiz         $quiz,
        QuestionType $questionType
    ) {
        DB::transaction(function () use ($request, $course, $stage, $quiz, $questionType) {
            $this->questionGroupCreateAction->execute(
                data: $request->toMsPayload(
                    uuid: $quiz->uuid,
                    questionType: $questionType->value
                )
            );
        });

        return redirect()->route('quizzes.show', [$course, $stage, $quiz]);
    }

    /**
     * @throws \Exception
     */
    public function store(StoreQuestionRequest $request, Course $course, Stage $stage, Quiz $quiz, $questionType)
    {
        if (!$quiz->uuid) {
            throw new \Exception('Quiz uuid is not valid');
        }

        $questionUuid = $this->questionCreateAction->execute(
            data: $request->validated()
        );

        return redirect()->route('questions.show', [$course, $stage, $quiz, $questionUuid]);



        /* Validate by question type */
//        $request->validate(
//            validateInputs($request, $questionType)
//        );

        /* Create new question */
//        $question = Question::add($request->all(), $quiz, $questionType);
//        $question->attachImage($request->input('question_image'));

        /* Add multiple audio files to question */
//        if ($request->has('question_audios')) {
//            foreach ($request->input('question_audios') as $audio) {
//
//                QuestionAudio::create([
//                    'question_id' => $question->id,
//                    'audio' => $audio
//                ]);
//            }
//        }

        /* Create new conformity */
//        if ($questionType === 'make_text') {
//            $text = '';
//
//            $sentences = $request->input('matching_title');
//            foreach ($sentences as $sentence) {
//                if ($sentence) {
//                    $text = $text . $sentence . ' ';
//                }
//            }
//
//            $conformity = Conformity::create([
//                'question_id' => $question->id,
//                'title' => $text,
//                'points' => $request->input('points'),
//                'audio' => $request->input('matching_audio'),
//                'image' => $request->input('matching_image'),
//            ]);
//
//            foreach ($sentences as $sentence) {
//                if ($sentence) {
//                    ConformityOption::add($sentence, $conformity, 1);
//                }
//            }
//
//        } else {
//
//            $conformity = Conformity::add($request->all(), $question);
//            $conformity->attachAudio($request->input('matching_audio'));
//            $conformity->attachImage($request->input('matching_image'));
//            $conformity->addOptionByCondition($questionType, $request);
//        }
//
//        return redirect()->route('questions.show', [
//            'course' => $course,
//            'stage' => $stage,
//            'quiz' => $quiz,
//            'question' => $question,
//        ]);
    }

    public function show(Course $course, Stage $stage, Quiz $quiz, string $questionUuid): View
    {
        return view(
            view: 'cms.courses.quizzes.questions.show',
            data: $this->questionViewService->prepareDataForShowView($course, $stage, $quiz, $questionUuid)
        );
    }

    public function edit(Course $course, Stage $stage, Quiz $quiz, Question $question)
    {
        $audio = MediaFile::where('type', 'audio')->orderBy('id', 'desc')->get();
        $images = MediaFile::where('type', 'image')->orderBy('id', 'desc')->get();

        return view('cms.courses.quizzes.questions.edit', [
            'course' => $course,
            'stage' => $stage,
            'quiz' => $quiz,
            'question' => $question,
            'audioFiles' => $audio,
            'images' => $images
        ]);
    }

    public function update(Request $request, Course $course, Stage $stage, Quiz $quiz, Question $question)
    {
        $request->validate([
            'title' => 'required|string',
        ]);

        $question->update($request->all());

        foreach ($question->audios as $currentAudio) {
            $currentAudio->remove();
        }

        if ($request->has('question_audios')) {
            foreach ($request->input('question_audios') as $audio) {
                QuestionAudio::create(['question_id' => $question->id,'audio' => $audio]);
            }
        }

        if ($question->type === 'make_text') {
            if ($request->has('matching_title')) {

                foreach ($question->conformities as $currentConformity) {
                    $currentConformity->remove();
                }

                $text = '';

                $sentences = $request->input('matching_title');
                foreach ($sentences as $key => $sentence) {
                    if ($sentence) {
                        $text = $text . $sentence . ' ';
                    }
                }

                $conformity = Conformity::create([
                    'question_id' => $question->id,
                    'title' => $text,
                    'points' => $request->input('points')
                ]);

                foreach ($sentences as $sentence) {
                    ConformityOption::add($sentence, $conformity, 1);
                }
            }
        }

        return redirect()->route('questions.show', [$course->id, $stage->id, $quiz->id, $question->id]);
    }

    public function destroy(Course $course, Stage $stage, Quiz $quiz, Question $question)
    {
        $question->remove();
        return redirect()->route('quizzes.show', [$course->id, $stage->id, $quiz->id]);
    }

    public function removeImage(Course $course, Stage $stage, Quiz $quiz, Question $question)
    {
        $question->update(['image' => null]);
    }

    public function removeAudio(Course $course, Stage $stage, Quiz $quiz, Question $question, QuestionAudio $audio)
    {
        $audio->remove();
    }
}
