<article class="card">
    <a href="/article/{$article.id}">
        {if isset($article.image)}
            <img class="card__img" src="/uploads/articles/{$article.image}" alt="" loading="lazy">
        {else}
            <img class="card__img" src="/assets/img/no-image.svg" alt="no-image" loading="lazy">
        {/if}
    </a>
    <div class="card__body">
        <h3 class="card__title">
            <a href="/article/{$article.id}">{$article.title}</a>
        </h3>
        <p class="card__text">{$article.description}</p>
        <div class="card__meta">
            <span>{$article.created_at|date_format:'%d.%m.%Y'}</span>
            <span>{$article.views} просмотров</span>
        </div>
    </div>
</article>
