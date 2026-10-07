<?php

declare(strict_types=1);

use Faker\Factory;

require __DIR__ . '/../bootstrap.php';

/**
 * @var PDO $pdo
 * @var array $config
 */

// php bin/seed.php --fresh --articles=50 --categories=10
$opts = getopt('', ['fresh', 'articles:', 'categories:']);
$articlesCount = (int)($opts['articles'] ?? 50);
$categoriesCount = (int)($opts['categories'] ?? 10);

$faker = Factory::create('ru_RU');

if (isset($opts['fresh'])) {
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
    foreach (['article_category', 'articles', 'categories'] as $table) {
        $pdo->exec("TRUNCATE TABLE $table");
    }
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
}

$imagesDir = __DIR__ . '/../public/uploads/articles';

for ($id = 1; $id <= 10; $id++) {
    $path = "$imagesDir/$id.jpg";

    if (is_file($path)) {
        continue;
    }

    $data = file_get_contents("https://picsum.photos/id/$id/760/428");

    if ($data === false) {
        echo 'Не удалось скачать id=' . $id . PHP_EOL;
        continue;
    }

    file_put_contents($path, $data);
}

$pdo->beginTransaction();

try {
    $insCategory = $pdo->prepare(
        'INSERT INTO categories (name, description)
         VALUES (:name, :description)'
    );

    $categoryIds = [];

    for ($i = 1; $i <= $categoriesCount; $i++) {
        $insCategory->execute([
            'name' => rtrim($faker->sentence(2), '.!?,… '),
            'description' => rand(1, 10) > 3 ? $faker->paragraph() : null, // 20% без описания
        ]);
        if (rand(1, 10) > 1) { // 10% категорий пустые
            $categoryIds[] = (int)$pdo->lastInsertId();
        }
    }

    $insArticle = $pdo->prepare(
        'INSERT INTO articles (title, description, text, image, views, created_at)
         VALUES (:title, :description, :text, :image, :views, :created_at)'
    );

    $articleIds = [];

    for ($i = 1; $i <= $articlesCount; $i++) {
        $insArticle->execute([
            'title' => rtrim($faker->sentence(4), '.!?'),
            'description' => rand(1, 10) > 3 ? $faker->paragraph() : null, // 30% без описания
            'text' => $faker->realText(1000),
            'image' => rand(1, 10) > 1 ? rand(1, 10) . '.jpg' : null, // 10% без картинки
            'views' => rand(1, 10) > 2 ? rand(1, 1000) : 0, // 20% без просмотров
            'created_at' => $faker->dateTimeBetween('-1 year')->format('Y-m-d H:i:s'),
        ]);
        $articleIds[] = (int)$pdo->lastInsertId();
    }

    $articleCategoryIns = $pdo->prepare(
        'INSERT INTO article_category (article_id, category_id)
         VALUES (:article_id, :category_id)'
    );

    foreach ($articleIds as $articleId) {
        shuffle($categoryIds);
        foreach (array_slice($categoryIds, 0, rand(1, 3)) as $categoryId) {
            $articleCategoryIns->execute([
                'article_id' => $articleId,
                'category_id' => $categoryId,
            ]);
        }
    }

    $pdo->commit();
    echo "Готово: $categoriesCount категорий, $articlesCount статей." . PHP_EOL;
} catch (Throwable $e) {
    $pdo->rollBack();
    echo('Ошибка: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}
