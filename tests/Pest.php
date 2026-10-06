<?php
declare(strict_types=1);

use App\Kafka\Producer\BaseProducer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->beforeEach(function (): void {
        $this->withoutVite();
        Http::preventStrayRequests();
        $this->mock(BaseProducer::class)->shouldIgnoreMissing();
    })
    ->in('Feature');
