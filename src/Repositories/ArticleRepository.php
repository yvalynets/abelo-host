<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

class ArticleRepository
{
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    public function latestByCategory(int $categoryId, int $limit): array
    {
        $sql = 'SELECT a.id, a.image, a.title, a.description, a.views, a.created_at
                FROM articles a
                    JOIN article_category ac ON ac.article_id = a.id
                WHERE ac.category_id = :cid
                ORDER BY a.created_at DESC, a.id DESC
                LIMIT :limit';

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':cid', $categoryId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
