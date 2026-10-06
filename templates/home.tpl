{extends file="layout.tpl"}

{block name="title"}Блог{/block}

{block name="content"}
    {foreach $categories as $category}
        <section class="section">
            <div class="section__head">
                <div>
                    <h2 class="section__title">{$category.name}</h2>
                    <p class="section__desc">{$category.description}</p>
                </div>
                <a class="btn" href="/category/{$category.id}">Все статьи</a>
            </div>
            <div class="grid">
                {foreach $articlesByCategory[$category.id] as $article}
                    {include file="partials/article_card.tpl" article=$article}
                {/foreach}
            </div>
        </section>
    {/foreach}
{/block}
