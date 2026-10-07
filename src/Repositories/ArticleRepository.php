<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\ArticleSort;
use PDO;

class ArticleRepository
{
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    public function findById(int $id): ?array
    {
        $statement = $this->pdo->prepare(
            'SELECT id, title, description, text, image, views, created_at
             FROM articles
             WHERE id = :id'
        );
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch() ?: null;
    }

    public function getByCategory(int $categoryId, ArticleSort $sort, int $limit, int $offset = 0): array
    {
        $orderBy = match ($sort) {
            ArticleSort::Date => 'a.created_at DESC, a.id',
            ArticleSort::Views => 'a.views DESC, a.id',
        };

        $statement = $this->pdo->prepare(
            "SELECT a.id, a.image, a.title, a.description, a.views, a.created_at
            FROM articles a
                JOIN article_category ac ON ac.article_id = a.id
            WHERE ac.category_id = :cid
            ORDER BY $orderBy
            LIMIT :limit
            OFFSET :offset"
        );
        $statement->bindValue(':cid', $categoryId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function countByCategory(int $categoryId): int
    {
        $statement = $this->pdo->prepare(
            'SELECT COUNT(*)
            FROM article_category
            WHERE category_id = :cid'
        );
        $statement->bindValue(':cid', $categoryId, PDO::PARAM_INT);
        $statement->execute();

        return (int)$statement->fetchColumn();
    }

    public function incrementViews(int $id): void
    {
        $statement = $this->pdo->prepare(
            'UPDATE articles
            SET views = views + 1
            WHERE id = :id'
        );
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function getSimilar(int $id, ArticleSort $sort, int $limit): array
    {
        $orderBy = match ($sort) {
            ArticleSort::Date => 'a.created_at DESC, a.id',
            ArticleSort::Views => 'a.views DESC, a.id',
        };

        $statement = $this->pdo->prepare(
            "SELECT a.id, a.title, a.description, a.image, a.views, a.created_at
            FROM articles a
            WHERE a.id <> :aid
            AND EXISTS (
                SELECT 1
                FROM article_category ac1 
                    JOIN article_category ac2 ON ac2.category_id = ac1.category_id
                WHERE ac1.article_id = :aid2
                AND ac2.article_id = a.id
            )
            ORDER BY $orderBy
            LIMIT :limit"
        );
        $statement->bindValue(':aid', $id, PDO::PARAM_INT);
        $statement->bindValue(':aid2', $id, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
