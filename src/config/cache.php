<?php

return [

    'default' => [
        'driver' => 'dummy',
    ],

    'apc' => [
        'driver' => 'apc',
    ],

    'memcached' => [
        'driver' => 'memcached',
        'server' => [
            [
                'host' => 'localhost',
                'port' => 11211,
                'persistent' => false,
                'compressThreshold' => [20000, 0.2]
            ],
        ]
    ],

    'memcache' => [
        'driver' => 'memcache',
        'server' => [
            [
                'host' => 'localhost',
                'port' => 11211,
                'persistent' => false,
                'compressThreshold' => [20000, 0.2]
            ],
        ]
    ],

    'redis' => [
        'driver' => 'redis',
        'host' => 'localhost',
        'port' => 6379,
        'persistent' => false,
        'timeout' => 2.5
    ],
];
