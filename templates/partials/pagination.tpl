{if $totalPages > 1}
    <nav class="pagination" aria-label="Страницы">
        {if $page > 1}
            <a href="/category/{$category.id}?sort={$sort}&amp;page={$page - 1}">←</a>
        {else}
            <span class="is-disabled">←</span>
        {/if}
        {for $i = 1 to $totalPages}
            {if $i === $page}
                <span class="is-current">{$i}</span>
            {else}
                <a href="/category/{$category.id}?sort={$sort}&amp;page={$i}">{$i}</a>
            {/if}
        {/for}
        {if $page < $totalPages}
            <a href="/category/{$category.id}?sort={$sort}&amp;page={$page + 1}">→</a>
        {else}
            <span class="is-disabled">→</span>
        {/if}
    </nav>
{/if}
