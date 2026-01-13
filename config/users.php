<?php

declare(strict_types=1);

return [
    'http' => [
        'connect_timeout' => env('USERS_HTTP_CONNECT_TIMEOUT', 3),
        'timeout' => env('USERS_HTTP_TIMEOUT', 5),
        'retry_attempts' => env('USERS_HTTP_RETRY_ATTEMPTS', 3),
        'retry_sleep_ms' => env('USERS_HTTP_RETRY_SLEEP_MS', 200),
    ],

    'cache' => [
        'key' => env('USERS_CACHE_KEY', 'users.provider.cache'),
        'ttl' => env('USERS_CACHE_TTL', 300), // seconds
    ],
];
