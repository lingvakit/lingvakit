<?php
declare (strict_types = 1);

namespace App\Providers;

use App\Kafka\Producer\BaseProducer;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use RdKafka\Conf;
use RdKafka\Producer;

class KafkaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BaseProducer::class, function ($app) {
            $topicsConfig = config('kafka.topics');

            $conf = new Conf();
            $conf->set('metadata.broker.list', config('kafka.host'));

            $producer = new Producer($conf);

            $logger = $app->make(LoggerInterface::class);

            return new BaseProducer($producer, $topicsConfig, $logger);
        });
    }
}