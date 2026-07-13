<?php
declare(strict_types=1);

namespace App\Application\Course\Handlers;

use App\Application\Course\Dto\CourseDto;
use App\Application\Course\Mapper\CourseMapper;
use App\Domain\Lesson\Repository\LessonRepositoryInterface;
use App\Domain\Quiz\Repository\QuizRepositoryInterface;
use App\Exceptions\CourseNotExistsException;
use App\Infrastructure\Persistence\Repository\CourseRepositoryInterface;
use Illuminate\Database\DatabaseManager;

final readonly class ShowCourseHandler implements ShowCourseHandlerInterface
{
    public function __construct(
        private DatabaseManager $db,
        private CourseRepositoryInterface $repository,
        private LessonRepositoryInterface $lessonRepository,
        private QuizRepositoryInterface $quizRepository,
        private CourseMapper $mapper
    ) {}

    public function handle(int $courseId): CourseDto
    {
        return $this->db->transaction(function () use ($courseId) {
            $course = $this->repository->findById($courseId);

            if ($course === null) {
                throw new CourseNotExistsException(
                    message: "Course with id {$courseId} not found"
                );
            }

            $topicIds = [];
            foreach ($course->stages as $stage) {
                foreach ($stage->topics as $topic) {
                    $topicIds[] = (int)$topic->id;
                }
            }

            $lessonsLookUp = $this->lessonRepository->findByTopicIds($topicIds);
            $quizzesLookUp = $this->quizRepository->findByTopicIds($topicIds);

            return $this->mapper->fromModel($course, $lessonsLookUp, $quizzesLookUp);
        });
    }
}
