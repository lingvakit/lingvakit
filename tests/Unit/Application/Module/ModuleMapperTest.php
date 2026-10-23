<?php
declare(strict_types=1);

use App\Application\Module\Dto\ModuleDto;
use App\Application\Module\Mapper\ModuleMapper;
use App\Application\Topic\Dto\TopicDto;
use App\Application\Topic\Service\TopicContentResolver;
use App\Models\LMS\Stage;
use App\Models\LMS\Topic;
use Mockery as m;
use Mockery\MockInterface;

uses(Tests\TestCase::class);

afterEach(fn () => m::close());

const MODULE_MAPPER_UUID = '550e8400-e29b-41d4-a716-446655440000';

function moduleMapperResolver(): MockInterface
{
    $resolver = m::mock(TopicContentResolver::class);
    $resolver->shouldReceive('resolveContent')
        ->zeroOrMoreTimes()
        ->andReturnUsing(fn (Topic $topic) => moduleMapperTopicDto((int) $topic->id));

    return $resolver;
}

function moduleMapperTopicDto(int $id): TopicDto
{
    $dto = new ReflectionClass(TopicDto::class)->newInstanceWithoutConstructor();

    $reflection = new ReflectionClass($dto);
    if ($reflection->hasProperty('id')) {
        $property = $reflection->getProperty('id');
        $property->setValue($dto, $id);
    }

    return $dto;
}

function moduleMapperStage(array $topics, int|string $id = 1, string $name = 'Module'): Stage
{
    $stage = new Stage()->forceFill(['id' => $id, 'name' => $name]);
    $stage->setRelation('topics', collect(array_map(
        fn (array $attributes) => new Topic()->forceFill($attributes),
        $topics,
    )));

    return $stage;
}

function moduleMapperIds(ModuleDto $dto): array
{
    return array_map(function (object $topic): int {
        if (method_exists($topic, 'getId')) {
            return $topic->getId();
        }

        return new ReflectionProperty($topic, 'id')->getValue($topic);
    }, $dto->topics);
}

describe('fromStageSummary', function () {
    it('maps id and title', function () {
        $stage = new Stage()->forceFill(['id' => 5, 'name' => 'Intro']);

        $dto = new ModuleMapper(moduleMapperResolver())->fromStageSummary($stage);

        expect($dto)->toBeInstanceOf(ModuleDto::class)
            ->and($dto->id)->toBe(5)
            ->and($dto->title)->toBe('Intro');
    });

    it('casts a string id from the database to int under strict types', function () {
        $stage = new Stage()->forceFill(['id' => '12', 'name' => 'Intro']);

        expect(new ModuleMapper(moduleMapperResolver())->fromStageSummary($stage)->id)->toBe(12);
    });

    it('always returns an empty topics list and does not load the relation', function () {
        $stage = new Stage()->forceFill(['id' => 5, 'name' => 'New']);

        $dto = new ModuleMapper(moduleMapperResolver())->fromStageSummary($stage);

        expect($dto->topics)->toBe([])
            ->and($stage->relationLoaded('topics'))->toBeFalse();
    });

    it('ignores topics that are already loaded on the stage', function () {
        $stage = moduleMapperStage([['id' => 1, 'entity_id' => null]]);

        expect(new ModuleMapper(moduleMapperResolver())->fromStageSummary($stage)->topics)->toBe([]);
    });

    it('never calls the topic resolver', function () {
        $resolver = m::mock(TopicContentResolver::class);
        $resolver->shouldNotReceive('resolveContent');

        new ModuleMapper($resolver)->fromStageSummary(
            moduleMapperStage([['id' => 1, 'entity_id' => MODULE_MAPPER_UUID]])
        );
    });

    it('keeps a title with unicode characters intact', function () {
        $stage = new Stage()->forceFill(['id' => 1, 'name' => 'Модуль №1 — Введение']);

        expect(new ModuleMapper(moduleMapperResolver())->fromStageSummary($stage)->title)
            ->toBe('Модуль №1 — Введение');
    });
});

describe('fromModel', function () {
    it('maps stage id and title and casts the id to int', function () {
        $dto = new ModuleMapper(moduleMapperResolver())->fromModel(
            moduleMapperStage([], id: '7', name: 'Grammar'),
            lessons: [], quizzes: [], msQuizzes: [],
        );

        expect($dto->id)->toBe(7)->and($dto->title)->toBe('Grammar');
    });

    it('returns an empty topics list for a stage without topics', function () {
        $dto = new ModuleMapper(moduleMapperResolver())->fromModel(
            moduleMapperStage([]), lessons: [], quizzes: [], msQuizzes: [],
        );

        expect($dto->topics)->toBe([]);
    });

    it('keeps a topic backed by a lesson', function () {
        $dto = new ModuleMapper(moduleMapperResolver())->fromModel(
            moduleMapperStage([['id' => 1, 'entity_id' => null]]),
            lessons: [1 => new stdClass()], quizzes: [], msQuizzes: [],
        );

        expect(moduleMapperIds($dto))->toBe([1]);
    });

    it('keeps a topic backed by a legacy quiz', function () {
        $dto = new ModuleMapper(moduleMapperResolver())->fromModel(
            moduleMapperStage([['id' => 1, 'entity_id' => null]]),
            lessons: [], quizzes: [1 => new stdClass()], msQuizzes: [],
        );

        expect(moduleMapperIds($dto))->toBe([1]);
    });

    it('keeps a topic backed by a microservice quiz', function () {
        $dto = new ModuleMapper(moduleMapperResolver())->fromModel(
            moduleMapperStage([['id' => 1, 'entity_id' => MODULE_MAPPER_UUID]]),
            lessons: [], quizzes: [], msQuizzes: [MODULE_MAPPER_UUID => new stdClass()],
        );

        expect(moduleMapperIds($dto))->toBe([1]);
    });

    it('drops topics that have no content at all', function () {
        $dto = new ModuleMapper(moduleMapperResolver())->fromModel(
            moduleMapperStage([['id' => 1, 'entity_id' => null], ['id' => 2, 'entity_id' => null]]),
            lessons: [], quizzes: [], msQuizzes: [],
        );

        expect($dto->topics)->toBe([]);
    });

    it('keeps only topics with content and preserves their original order', function () {
        $stage = moduleMapperStage([
            ['id' => 30, 'entity_id' => null],               // lesson
            ['id' => 20, 'entity_id' => null],               // пустой
            ['id' => 10, 'entity_id' => null],               // legacy quiz
            ['id' => 40, 'entity_id' => MODULE_MAPPER_UUID], // quiz в микросервисе
        ]);

        $dto = new ModuleMapper(moduleMapperResolver())->fromModel(
            $stage,
            lessons: [30 => new stdClass()],
            quizzes: [10 => new stdClass()],
            msQuizzes: [MODULE_MAPPER_UUID => new stdClass()],
        );

        expect(moduleMapperIds($dto))->toBe([30, 10, 40]);
    });

    it('returns a list with sequential keys when a middle topic is filtered out', function () {
        $stage = moduleMapperStage([
            ['id' => 1, 'entity_id' => null],
            ['id' => 2, 'entity_id' => null],
            ['id' => 3, 'entity_id' => null],
        ]);

        $dto = new ModuleMapper(moduleMapperResolver())->fromModel(
            $stage,
            lessons: [1 => new stdClass(), 3 => new stdClass()], quizzes: [], msQuizzes: [],
        );

        // До исправления ключи были [0, 2], и json_encode отдавал объект вместо массива.
        expect(array_is_list($dto->topics))->toBeTrue()
            ->and(json_encode($dto->topics))->toStartWith('[');
    });

    it('resolves a topic that matches several sources only once', function () {
        $stage = moduleMapperStage([['id' => 1, 'entity_id' => MODULE_MAPPER_UUID]]);

        $resolver = m::mock(TopicContentResolver::class);
        $resolver->shouldReceive('resolveContent')->once()->andReturn(moduleMapperTopicDto(1));

        $dto = new ModuleMapper($resolver)->fromModel(
            $stage,
            lessons: [1 => new stdClass()],
            quizzes: [1 => new stdClass()],
            msQuizzes: [MODULE_MAPPER_UUID => new stdClass()],
        );

        expect($dto->topics)->toHaveCount(1);
    });

    it('calls the resolver once per valid topic and never for filtered ones', function () {
        $stage = moduleMapperStage([
            ['id' => 1, 'entity_id' => null],
            ['id' => 2, 'entity_id' => null],
            ['id' => 3, 'entity_id' => null],
        ]);

        $resolver = m::mock(TopicContentResolver::class);
        $resolver->shouldReceive('resolveContent')->twice()
            ->andReturnUsing(fn (Topic $topic) => moduleMapperTopicDto((int) $topic->id));

        new ModuleMapper($resolver)->fromModel(
            $stage,
            lessons: [1 => new stdClass(), 3 => new stdClass()], quizzes: [], msQuizzes: [],
        );
    });

    it('passes the topic and all three lookups to the resolver unchanged', function () {
        $stage = moduleMapperStage([['id' => 1, 'entity_id' => null]]);
        $lessons = [1 => new stdClass()];
        $quizzes = [9 => new stdClass()];
        $msQuizzes = [MODULE_MAPPER_UUID => new stdClass()];

        $resolver = m::mock(TopicContentResolver::class);
        $resolver->shouldReceive('resolveContent')->once()
            ->withArgs(fn (Topic $topic, array $l, array $q, array $ms) => $topic->id === 1
                && $l === $lessons
                && $q === $quizzes
                && $ms === $msQuizzes)
            ->andReturn(moduleMapperTopicDto(1));

        new ModuleMapper($resolver)->fromModel($stage, $lessons, $quizzes, $msQuizzes);
    });

    it('matches microservice quizzes regardless of entity_id letter case', function () {
        $dto = new ModuleMapper(moduleMapperResolver())->fromModel(
            moduleMapperStage([['id' => 9, 'entity_id' => strtoupper(MODULE_MAPPER_UUID)]]),
            lessons: [], quizzes: [], msQuizzes: [MODULE_MAPPER_UUID => new stdClass()],
        );

        expect(moduleMapperIds($dto))->toBe([9]);
    });

    it('does not crash and drops the topic when entity_id is empty or invalid', function (?string $entityId) {
        $dto = new ModuleMapper(moduleMapperResolver())->fromModel(
            moduleMapperStage([['id' => 1, 'entity_id' => $entityId]]),
            lessons: [], quizzes: [], msQuizzes: [MODULE_MAPPER_UUID => new stdClass()],
        );

        expect($dto->topics)->toBe([]);
    })->with([
        'null' => [null],
        'empty string' => [''],
        'garbage' => ['not-a-uuid'],
        'number' => ['12345'],
        'truncated uuid' => ['550e8400-e29b-41d4-a716'],
    ]);

    it('keeps a lesson topic even when its entity_id is invalid', function () {
        $dto = new ModuleMapper(moduleMapperResolver())->fromModel(
            moduleMapperStage([['id' => 1, 'entity_id' => 'garbage']]),
            lessons: [1 => new stdClass()], quizzes: [], msQuizzes: [],
        );

        expect(moduleMapperIds($dto))->toBe([1]);
    });

    it('drops a topic whose microservice quiz was not returned by the service', function () {
        $dto = new ModuleMapper(moduleMapperResolver())->fromModel(
            moduleMapperStage([['id' => 1, 'entity_id' => MODULE_MAPPER_UUID]]),
            lessons: [], quizzes: [], msQuizzes: [],
        );

        expect($dto->topics)->toBe([]);
    });

    it('does not match a topic against a different quiz uuid', function () {
        $dto = new ModuleMapper(moduleMapperResolver())->fromModel(
            moduleMapperStage([['id' => 1, 'entity_id' => MODULE_MAPPER_UUID]]),
            lessons: [], quizzes: [],
            msQuizzes: ['00000000-0000-4000-8000-000000000000' => new stdClass()],
        );

        expect($dto->topics)->toBe([]);
    });

    it('treats a null lookup value as missing content', function () {
        $dto = new ModuleMapper(moduleMapperResolver())->fromModel(
            moduleMapperStage([['id' => 1, 'entity_id' => null]]),
            lessons: [1 => null], quizzes: [], msQuizzes: [],
        );

        expect($dto->topics)->toBe([]);
    });

    it('propagates resolver failures instead of swallowing them', function () {
        $resolver = m::mock(TopicContentResolver::class);
        $resolver->shouldReceive('resolveContent')->andThrow(new RuntimeException('resolver failed'));

        new ModuleMapper($resolver)->fromModel(
            moduleMapperStage([['id' => 1, 'entity_id' => null]]),
            lessons: [1 => new stdClass()], quizzes: [], msQuizzes: [],
        );
    })->throws(RuntimeException::class, 'resolver failed');
});

describe('ModuleDto', function () {
    it('defaults topics to an empty list', function () {
        expect(new ModuleDto(id: 1, title: 'A')->topics)->toBe([]);
    });
});