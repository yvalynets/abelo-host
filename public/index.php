<?php

use App\Controllers\ArticleController;
use App\Controllers\CategoryController;
use App\Controllers\HomeController;
use Smarty\Smarty;

require __DIR__ . '/../bootstrap.php';

/**
 * @var PDO $pdo
 * @var Smarty $smarty
 * @var array $config
 */

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = $path === '/' ? '/' : rtrim($path, '/');

if ($path === '/') {
    (new HomeController($pdo, $smarty, $config))->index();
} elseif (preg_match('#^/category/(\d+)$#', $path, $matches)) {
    (new CategoryController($pdo, $smarty, $config))->show((int)$matches[1]);
} elseif (preg_match('#^/article/(\d+)$#', $path, $matches)) {
    (new ArticleController($pdo, $smarty, $config))->show((int)$matches[1]);
} else {
    http_response_code(404);
}
