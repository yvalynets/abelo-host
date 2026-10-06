<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

class CategoryRepository
{
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    public function findNonEmpty(): array
    {
        $sql = 'SELECT c.id, c.name, c.description
                FROM categories c
                WHERE EXISTS (
                    SELECT 1
                    FROM article_category ac
                    WHERE ac.category_id = c.id
                )
                ORDER BY c.name';

        return $this->pdo->query($sql)->fetchAll();
    }
}
