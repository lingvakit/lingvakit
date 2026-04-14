<?php

return [
    'host' => env('KAFKA'),

    'topics' => [
        'notification.user' => [
            'acks' => 'all',
        ],
    ],
];