<?php
declare(strict_types=1);

use App\Application\Module\Dto\ModuleDto;
use App\Application\Module\Dto\RequestCreateModuleDto;
use App\Application\Module\Handlers\CreateModuleHandler;
use App\Application\Module\Mapper\ModuleMapper;
use App\Application\Topic\Service\TopicContentResolver;
use App\Infrastructure\Persistence\Repository\ModuleRepositoryInterface;
use App\Models\LMS\Stage;
use Mockery as m;

afterEach(fn () => m::close());

function makeStage(int $id, string $name, int $courseId): Stage
{
    return new Stage()->forceFill([
        'id' => $id,
        'name' => $name,
        'course_id' => $courseId
    ]);
}

it('creates a module and returns a DTO without topics (regression: too few arguments)', function () {
    $repository = m::mock(ModuleRepositoryInterface::class);
    $repository->shouldReceive('save')
        ->once()
        ->with([
            'course_id' => 3,
            'name' => 'Module 1'
        ])
        ->andReturn(
            makeStage(
                id: 15,
                name: 'Module 1',
                courseId: 3
            )
        );

    $resolver = m::mock(TopicContentResolver::class);
    $resolver->shouldNotReceive('resolveContent');

    $handler = new CreateModuleHandler($repository, new ModuleMapper($resolver));

    $dto = $handler->handle(new RequestCreateModuleDto(courseId: 3, title: 'Module 1'));

    expect($dto)->toBeInstanceOf(ModuleDto::class)
        ->and($dto->id)->toBe(15)
        ->and($dto->title)->toBe('Module 1')
        ->and($dto->topics)->toBe([]);
});

it('propagates repository failures', function () {
    $repository = m::mock(ModuleRepositoryInterface::class);
    $repository->shouldReceive('save')->once()->andThrow(
        new RuntimeException('FK violation')
    );

    $handler = new CreateModuleHandler(
        $repository,
        new ModuleMapper(
            m::mock(TopicContentResolver::class)
        )
    );

    $handler->handle(new RequestCreateModuleDto(
        courseId: 999,
        title: 'X')
    );
})->throws(RuntimeException::class, 'FK violation');

it('serialises the request DTO into fillable columns', function () {
    expect(new RequestCreateModuleDto(
        courseId: 7,
        title: 'Intro'
    )->toArray())->toBe([
        'course_id' => 7,
        'name' => 'Intro'
    ]);
});