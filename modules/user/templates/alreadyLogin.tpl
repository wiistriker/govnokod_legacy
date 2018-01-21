{title append="Моя личная кабинка"}
<ol class="posts">
    <li class="hentry">
        <h2>Моя личная кабинка</h2>
        <p><img src="{$user->getAvatarUrl()|h}" alt="avatar" title="Аватар пользователя {$user->getLogin()|h}" /></p>

        <dl>
            <dt>Предпочитаемые языки:</dt>
            <dd>
                {if $user->getPreferredLangs() === false}
                <strong>Все</strong>
                {else}
                {foreach from=$user->getPreferredLangsCategories() item="category" name="categoryIterator"}
                <a href="{url route="categoryList" name=$category->getName()}">{$category->getTitle()|h}</a>{if !$smarty.foreach.categoryIterator.last},{/if}
                {/foreach}
                {/if}
            </dd>

            <dt>Подсветка кода:</dt>
            <dd>{$user->getHighlightDriverTitle()|h}</dd>
        </dl>

        <ul>
            <li><a href="{url route="userCodes" id=$user->getId()}">Мои говнокоды ({$user->getQuotesCount()})</a></li>
            <li><a href="{url route="rssUser" id=$user->getId()}" title="Лента RSS, собранная на основе предпочитаемых языков">Моя RSS лента</a></li>
            <li><a href="{url route="default2" module="user" action="preferences"}">Настройки</a></li>
            <li>{assign var="url" value={url appendGet=true}}<a href="{url route="default2" module="user" action="exit"}/?url={$url|rawurlencode}">Выйти</a></li>
        </ul>
    </li>
</ol>