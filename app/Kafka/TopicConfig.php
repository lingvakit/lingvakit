<?php

declare(strict_types=1);

namespace App\Kafka;

use RdKafka\TopicConf;

class TopicConfig extends TopicConf
{
    public function __construct(array $config)
    {
        parent::__construct();

        foreach ($config as $key => $value) {
            $this->set(str_replace('_', '.', $key), $value);
        }
    }
}