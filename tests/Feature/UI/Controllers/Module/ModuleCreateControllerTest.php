<?php
declare(strict_types=1);

namespace Feature\UI\Controllers\Module;

use App\Application\Module\Commands\CreateModuleHandlerInterface;
use Mockery;
use Tests\TestCase;

class ModuleCreateControllerTest extends TestCase
{
    private const string MODULE_CREATE_ENDPOINT = '/react/api/courses/1/modules';

    public function testCreateModuleSuccessfully(): void
    {
        $moduleTitle = 'Module 1';
        $handler = Mockery::mock(CreateModuleHandlerInterface::class);

        $handler->shouldReceive('handle')
            ->once()
            ->with(Mockery::on(function ($dto) use ($moduleTitle) {
                return $dto->title === $moduleTitle;
            }))
            ->andReturn(10);

        $this->app->instance(CreateModuleHandlerInterface::class, $handler);

        $response = $this->postJson(
            uri: self::MODULE_CREATE_ENDPOINT,
            data: ['title' => $moduleTitle]
        );

        $response->assertStatus(201)->assertJson([
            'data' => [
                'id' => 10
            ]
        ]);
    }

    public function testCreateModuleFailedWhenDataIsInvalid(): void
    {
        $handler = Mockery::mock(CreateModuleHandlerInterface::class);

        $this->app->instance(CreateModuleHandlerInterface::class, $handler);

        $response = $this->postJson(
            uri: self::MODULE_CREATE_ENDPOINT
        );

        $response->assertStatus(422);
    }
}
