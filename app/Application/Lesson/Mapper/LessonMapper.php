<?php
declare(strict_types=1);

namespace App\Application\Lesson\Mapper;

use App\Application\Lesson\Dto\LessonDto;
use App\Models\LMS\Lesson;

class LessonMapper
{
    public function fromModel(Lesson $lesson): LessonDto
    {
        return new LessonDto(
            id: $lesson->id,
            title: $lesson->title,
            duration: (int)$lesson->duration,
            description: $lesson->description,
            imageUrl: $lesson->getImage(),
            audioUrl: $lesson->getAudio(),
            videoUrl: $lesson->getVideo(),
            orderIndex: $lesson->topic->index_number,
        );
    }
}
