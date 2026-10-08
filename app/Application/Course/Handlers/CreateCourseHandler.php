<?php
declare(strict_types=1);

namespace App\Application\Course\Handlers;

use App\Application\Course\Dto\CourseCreateRequestDto;
use App\Application\Course\Dto\CourseDto;
use App\Application\Course\Mapper\CourseMapper;
use App\Exceptions\LanguageNotExistsException;
use App\Infrastructure\Persistence\Repository\CourseRepositoryInterface;
use App\Models\LMS\Language;
use Illuminate\Support\Facades\DB;

final readonly class CreateCourseHandler implements CreateCourseHandlerInterface
{
    private const string LANGUAGE_CHINA_CODE = 'cn';

    public function __construct(
        private CourseRepositoryInterface $repository,
        private CourseMapper $courseMapper,
    ) {
    }

    public function handle(
        CourseCreateRequestDto $dto,
        int $authorId,
        bool $autoApprove
    ): CourseDto {
        return DB::transaction(function () use ($dto, $authorId, $autoApprove) {
            $language = Language::query()->where('label', self::LANGUAGE_CHINA_CODE)->first()
                ?? throw new LanguageNotExistsException(
                    message: 'Language with label ' . self::LANGUAGE_CHINA_CODE . ' not found'
                );

            $course = $this->repository->save([
                ...$dto->toArray(),
                'language_id' => $language->id,
                'author_id' => $authorId,
                'is_allowed' => $autoApprove,
            ]);

            return $this->courseMapper->fromModel($course->refresh());
        });
    }
}
