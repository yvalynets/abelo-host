{extends file="layout.tpl"}

{block name="title"}{$category.name}{/block}

{block name="content"}
    <nav class="crumbs">
        <a href="/">Главная</a>
        <span>/</span>
        {$category.name}
    </nav>
    <div class="page-head">
        <h1 class="page-head__title">{$category.name}</h1>
        <p class="page-head__desc">{$category.description}</p>
    </div>
    <div class="toolbar">
        <span>Сортировка:</span>
        {foreach $sortOptions as $option}
            <a class="sort {if $option.value === $sort}is-active{/if}"
               href="/category/{$category.id}?sort={$option.value}">{$option.label}</a>
        {/foreach}
    </div>
    <div class="grid">
        {foreach $articles as $article}
            {include file="partials/article_card.tpl" article=$article}
        {/foreach}
    </div>
    {include file="partials/pagination.tpl"}
{/block}
