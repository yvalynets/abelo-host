{extends file="layout.tpl"}

{block name="title"}{$article.title}{/block}

{block name="content"}
    <article class="article">
        <nav class="crumbs">
            <a href="/">Главная</a>
            <span>/</span>
            <a href="/category/{$categories[0].id}">{$categories[0].name}</a>
            <span>/</span>
            {$article.title}
        </nav>
        <div class="tags">
            {foreach $categories as $category}
                <a class="tag" href="/category/{$category.id}">{$category.name}</a>
            {/foreach}
        </div>
        <h1 class="article__title">{$article.title}</h1>
        {if isset($article.description)}
            <p class="article__lead">{$article.description}</p>
        {/if}
        <div class="article__meta">
            <span>{$article.created_at|date_format:'%d.%m.%Y'}</span>
            <span>{$article.views} просмотров</span>
        </div>
        {if isset($article.image)}
            <img class="article__cover" src="/uploads/articles/{$article.image}" alt="">
        {/if}
        <div class="article__content">
            {$article.text nofilter}
        </div>
    </article>
    {if $similar}
        <section class="related">
            <h2 class="related__title">Похожие статьи</h2>
            <div class="grid">
                {foreach $similar as $article}
                    {include file="partials/article_card.tpl" article=$article}
                {/foreach}
            </div>
        </section>
    {/if}
{/block}
