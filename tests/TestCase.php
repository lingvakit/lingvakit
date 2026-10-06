<?php
declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $database = (string) config('database.connections.' . config('database.default') . '.database');
        if (! str_ends_with($database, '_test')) {
            $this->fail("Тесты запущены на не-тестовой БД «{$database}». Проверьте phpunit.xml.");
        }
    }
}
