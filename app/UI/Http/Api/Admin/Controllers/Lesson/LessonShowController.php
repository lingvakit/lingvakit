<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Lesson;

use App\Application\Course\Dto\Lesson\LessonDetailsDto;
use App\Application\Lesson\Commands\ShowLessonHandler;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Resources\Lesson\LessonDetailsResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LessonShowController extends Controller
{
    public function __construct(
        private readonly ShowLessonHandler $handler
    ) {}

    public function __invoke(int $lessonId): JsonResponse
    {
        $lesson = $this->handler->handle($lessonId);

        return response()->json(
            data: [
                'data' => new LessonDetailsResource(
                    new LessonDetailsDto(
                        id: $lesson->id,
                        title: $lesson->title,
                        description: $lesson->description,
                        imageUrl: $lesson->getImage() ?: null,
                        audioUrl: $lesson->getAudio() ?: null,
                        videoUrl: $lesson->getVideo() ?: null,
                        duration: (int)$lesson->duration,
                        orderIndex: $lesson->topic->index_number,
                    )
                )
            ],
            status: Response::HTTP_OK
        );
    }
}
