<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name=title}Блог{/block}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700&family=Source+Serif+4:wght@400;600&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css?v=1.0">
</head>
<body>
{include file="partials/header.tpl"}
<main class="main">
    <div class="container">
        {block name="content"}{/block}
    </div>
</main>
{include file="partials/footer.tpl"}
</body>
</html>
