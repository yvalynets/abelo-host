<?php

declare(strict_types=1);

namespace App\Enums;

enum ArticleSort: string
{
    case Date = 'date';
    case Views = 'views';

    public function label(): string
    {
        return match ($this) {
            self::Date => 'По дате',
            self::Views => 'По просмотрам',
        };
    }
}
