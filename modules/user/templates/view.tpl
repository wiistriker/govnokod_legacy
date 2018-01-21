{title append="Личная кабинка пользователя `$viewuser->getLogin()`"}
<ol class="posts">
    <li class="hentry">
        <h2>Личная кабинка пользователя <strong>{$viewuser->getLogin()|h}</strong></h2>
        <p><img src="{$viewuser->getAvatarUrl()|h}" alt="avatar" title="Аватар пользователя {$viewuser->getLogin()|h}" /></p>

        <dl>
            <dt>Предпочитаемые языки:</dt>
            <dd>
                {if $viewuser->getPreferredLangs() === false}
                <strong>Все</strong>
                {else}
                {foreach from=$viewuser->getPreferredLangsCategories() item="category" name="categoryIterator"}
                <a href="{url route="categoryList" name=$category->getName()}">{$category->getTitle()|h}</a>{if !$smarty.foreach.categoryIterator.last}, {/if}
                {/foreach}
                {/if}
            </dd>

            <dt>Подсветка кода:</dt>
            <dd>{$viewuser->getHighlightDriverTitle()|h}</dd>
        </dl>

        <ul>
            <li><a href="{url route="userCodes" id=$viewuser->getId()}">Его говнокоды ({$viewuser->getQuotesCount()})</a></li>
        </ul>
    </li>
</ol>