<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Enums\ArticleSort;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use Exception;
use PDO;
use Smarty\Smarty;

class CategoryController
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
        $category = $this->categories->findById($id);

        if ($category === null) {
            http_response_code(404);
            return;
        }

        $sort = ArticleSort::tryFrom($_GET['sort'] ?? '') ?? $this->config['app']['category']['sort_by'];
        $perPage = $this->config['app']['category']['per_page'];

        $total = $this->articles->countByCategory($id);
        $totalPages = max(1, (int)ceil($total / $perPage));

        $page = min($totalPages, max(1, (int)($_GET['page'] ?? 1)));
        $offset = ($page - 1) * $perPage;

        $articles = $this->articles->getByCategory($id, $sort, $perPage, $offset);

        try {
            $this->smarty->assign('category', $category);
            $this->smarty->assign('articles', $articles);
            $this->smarty->assign('sortOptions', array_map(fn(ArticleSort $sort) => [
                'value' => $sort->value,
                'label' => $sort->label()
            ], ArticleSort::cases()));
            $this->smarty->assign('sort', $sort->value);
            $this->smarty->assign('page', $page);
            $this->smarty->assign('totalPages', $totalPages);
            $this->smarty->display('category.tpl');
        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo 'Ошибка при отображении страницы';
        }
    }
}
