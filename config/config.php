<?php

declare(strict_types=1);

use App\Enums\ArticleSort;

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
            'sort_by' => ArticleSort::Date,
        ],
        'category' => [
            'per_page' => 6,
            'sort_by' => ArticleSort::Date,
        ],
        'article' => [
            'similar_count' => 3,
            'similar_sort_by' => ArticleSort::Views,
        ],
    ],
];
