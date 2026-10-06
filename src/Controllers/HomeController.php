<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use PDO;
use Smarty\Exception;
use Smarty\Smarty;

class HomeController
{
    private CategoryRepository $categories;
    private ArticleRepository $articles;

    public function __construct(
        PDO $pdo,
        private readonly Smarty $smarty,
        private readonly array $config
    ) {
        $this->categories = new CategoryRepository($pdo);
        $this->articles = new ArticleRepository($pdo);
    }

    public function index(): void
    {
        $limit = $this->config['app']['home']['per_category'];

        $categories = $this->categories->findNonEmpty();

        $articlesByCategory = [];
        foreach ($categories as $category) {
            $articlesByCategory[$category['id']] = $this->articles->latestByCategory($category['id'], $limit);
        }

        try {
            $this->smarty->assign('title', 'Блог');
            $this->smarty->assign('categories', $categories);
            $this->smarty->assign('articlesByCategory', $articlesByCategory);
            $this->smarty->display('home.tpl');
        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo 'Ошибка при отображении страницы';
        }
    }
}
