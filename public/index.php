<?php

use App\Controllers\HomeController;
use Smarty\Smarty;

require __DIR__ . '/../bootstrap.php';

/**
 * @var PDO $pdo
 * @var Smarty $smarty
 * @var array $config
 */

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === '/') {
    (new HomeController($pdo, $smarty, $config))->index();
} else {
    http_response_code(404);
}
