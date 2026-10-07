<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use Exception;
use PDO;
use Smarty\Smarty;

class ArticleController
{
    private ArticleRepository $articles;
    private CategoryRepository $categories;

    public function __construct(
        PDO $pdo,
        private readonly Smarty $smarty,
        private readonly array $config
    ) {
        $this->articles = new ArticleRepository($pdo);
        $this->categories = new CategoryRepository($pdo);
    }

    public function show(int $id): void
    {
        $article = $this->articles->findById($id);

        if ($article === null) {
            http_response_code(404);
            return;
        }

        if ($this->registerView($id)) {
            $article['views']++;
        }

        $similar = $this->articles->getSimilar(
            $id,
            $this->config['app']['article']['similar_sort_by'],
            $this->config['app']['article']['similar_count']
        );

        try {
            $this->smarty->assign('title', $article['title']);
            $this->smarty->assign('article', $article);
            $this->smarty->assign('categories', $this->categories->findByArticle($id));
            $this->smarty->assign('similar', $similar);
            $this->smarty->display('article.tpl');
        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo 'Ошибка при отображении страницы';
        }
    }

    private function registerView(int $id): bool
    {
        $cookieName = 'viewed_article_' . $id;

        if (isset($_COOKIE[$cookieName])) {
            return false;
        }

        $this->articles->incrementViews($id);

        setcookie($cookieName, '1', [
            'expires' => time() + 24 * 60 * 60,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        return true;
    }
}
