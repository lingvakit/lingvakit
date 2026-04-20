<?php
declare(strict_types=1);

namespace Feature\UI\Controllers\Module;

use App\Application\Module\Handlers\UpdateModuleHandlerInterface;
use Mockery;
use Tests\TestCase;

class ModuleUpdateControllerTest extends TestCase
{
    private const string MODULE_UPDATE_ENDPOINT = '/react/api/modules/1';

    public function testCreateModuleSuccessfully(): void
    {
        $moduleId = 1;
        $moduleTitle = 'Updated Module 1';
        $handler = Mockery::mock(UpdateModuleHandlerInterface::class);

        $handler->shouldReceive('handle')
            ->once()
            ->with(
                $moduleId,
                Mockery::on(function ($dto) use ($moduleTitle) {
                    return $dto->title === $moduleTitle;
                })
            )
            ->andReturn(10);

        $this->app->instance(UpdateModuleHandlerInterface::class, $handler);

        $response = $this->putJson(
            uri: self::MODULE_UPDATE_ENDPOINT,
            data: ['title' => $moduleTitle]
        );

        $response->assertStatus(200)->assertJson([
            'data' => [
                "message" => "Module with id: 10 updated successfully"
            ]
        ]);
    }

    public function testCreateModuleFailedWhenDataIsInvalid(): void
    {
        $handler = Mockery::mock(UpdateModuleHandlerInterface::class);

        $this->app->instance(UpdateModuleHandlerInterface::class, $handler);

        $response = $this->putJson(
            uri: self::MODULE_UPDATE_ENDPOINT
        );

        $response->assertStatus(422);
    }
}
