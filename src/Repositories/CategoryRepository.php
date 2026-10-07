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

    public function findById(int $id): ?array
    {
        $statement = $this->pdo->prepare(
            'SELECT id, name, description
             FROM categories
             WHERE id = :id'
        );
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch() ?: null;
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

    public function findByArticle(int $articleId): array
    {
        $statement = $this->pdo->prepare(
            'SELECT c.id, c.name
             FROM categories c
                JOIN article_category ac ON ac.category_id = c.id
             WHERE ac.article_id = :aid
             ORDER BY c.name'
        );
        $statement->bindValue(':aid', $articleId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
