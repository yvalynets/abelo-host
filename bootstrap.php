<?php

declare(strict_types=1);

use App\Database;
use Smarty\Smarty;

require __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config/config.php';

$pdo = Database::connect($config['db']);

$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . '/templates');
$smarty->setCompileDir(__DIR__ . '/templates_c');
$smarty->escape_html = true;
