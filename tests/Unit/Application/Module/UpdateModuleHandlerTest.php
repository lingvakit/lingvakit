<?php
declare(strict_types=1);

use App\Application\Module\Dto\RequestUpdateModuleDto;
use App\Application\Module\Handlers\UpdateModuleHandler;
use App\Application\Module\Mapper\ModuleMapper;
use App\Application\Topic\Service\TopicContentResolver;
use App\Exceptions\ModuleNotExistsException;
use App\Infrastructure\Persistence\Repository\ModuleRepositoryInterface;
use App\Models\LMS\Stage;
use Mockery as m;

afterEach(fn () => m::close());

function updateHandlerStage(int $id, string $name): Stage
{
    return new Stage()->forceFill([
        'id' => $id,
        'name' => $name,
        'course_id' => 1
    ]);
}

function makeUpdateHandler(ModuleRepositoryInterface $repository): UpdateModuleHandler
{
    $resolver = m::mock(TopicContentResolver::class);
    $resolver->shouldNotReceive('resolveContent');

    return new UpdateModuleHandler(
        $repository,
        new ModuleMapper($resolver)
    );
}

it('renames a module and returns a summary DTO (regression: too few arguments)', function () {
    $stage = updateHandlerStage(4, 'Old');

    $repository = m::mock(ModuleRepositoryInterface::class);
    $repository->shouldReceive('findById')->once()->with(4)->andReturn($stage);
    $repository->shouldReceive('update')->once()
        ->with($stage, ['name' => 'New'])
        ->andReturn(updateHandlerStage(4, 'New'));

    $dto = makeUpdateHandler($repository)->handle(4, new RequestUpdateModuleDto(title: 'New'));

    expect($dto->id)->toBe(4)
        ->and($dto->title)->toBe('New')
        ->and($dto->topics)->toBe([]);
});

it('maps the model returned by the repository, not the stale one', function () {
    $stale = updateHandlerStage(4, 'Old');

    $repository = m::mock(ModuleRepositoryInterface::class);
    $repository->shouldReceive('findById')->andReturn($stale);
    $repository->shouldReceive('update')->andReturn(updateHandlerStage(4, 'Fresh'));

    expect(makeUpdateHandler($repository)->handle(4, new RequestUpdateModuleDto('x'))->title)
        ->toBe('Fresh');
});

it('throws ModuleNotExistsException and does not update when the module is missing', function () {
    $repository = m::mock(ModuleRepositoryInterface::class);
    $repository->shouldReceive('findById')->once()->with(404)->andReturn(null);
    $repository->shouldNotReceive('update');

    makeUpdateHandler($repository)->handle(404, new RequestUpdateModuleDto('x'));
})->throws(ModuleNotExistsException::class, 'Stage with id 404 not found');

it('propagates repository failures on update', function () {
    $repository = m::mock(ModuleRepositoryInterface::class);
    $repository->shouldReceive('findById')->andReturn(updateHandlerStage(1, 'A'));
    $repository->shouldReceive('update')->andThrow(new RuntimeException('db down'));

    makeUpdateHandler($repository)->handle(1, new RequestUpdateModuleDto('B'));
})->throws(RuntimeException::class, 'db down');

it('serialises the update DTO into the name column only', function () {
    expect(new RequestUpdateModuleDto('Intro')->toArray())->toBe(['name' => 'Intro']);
});