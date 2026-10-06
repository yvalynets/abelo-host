<?php

declare(strict_types=1);

return [
    'db' => [
        'host' => getenv('DB_HOST') ?: 'db',
        'port' => (int)(getenv('DB_PORT') ?: 3306),
        'name' => getenv('DB_NAME') ?: 'app',
        'user' => getenv('DB_USER') ?: 'app',
        'pass' => getenv('DB_PASS') ?: 'app',
        'charset' => 'utf8mb4',
    ],

    'app' => [
        'home' => [
            'per_category' => 3,
            'sort_by' => 'date',
        ],
        'category' => [
            'per_page' => 6,
            'sort_by' => 'date',
        ],
        'article' => [
            'similar_count' => 3,
            'sort_by' => 'views',
        ],
    ],
];
