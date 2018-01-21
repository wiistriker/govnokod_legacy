<ol class="posts hatom">
{foreach from=$quotes item="quote"}
{assign var="comment" value=$quote->getLastComment()}
{if $comment}
    <li class="hentry">
        <h2>Комментарий к <a rel="bookmark" class="entry-title" href="{url route="quoteView" id=$quote->getId()}">говнокоду #{$quote->getId()}</a></h2>
        <div class="entry-comments">
            <ul>
                <li class="hcomment">
                    {assign var="commentsFolder" value=$comment->getFolder()}
                    <div class="entry-comment-wrapper">
                        <p class="entry-info">
                            <img class="avatar" src="{$comment->getUser()->getAvatarUrl(28)|h}" alt="ava" title="Аватар" />
                            <strong class="entry-author"><a href="{url route="withId" module="user" id=$comment->getUser()->getId() action=""}">{$comment->getUser()->getLogin()|h}</a></strong>
                            <abbr class="published" title="{"c"|date:$comment->getCreated()}">{$comment->getCreated()|date_i18n:'relative_hour'}</abbr>
                            <a href="{$commentsFolder->getDefaultBackUrl()|h}#comment{$comment->getId()}" name="comment{$comment->getId()}" title="Ссылка на комментарий" class="comment-link">#</a>
                        </p>
                        <div class="entry-comment">{$comment->getText()|h|nl2br|bbcode}</div>
                        <a class="answer" href="{url route="withId" module="comments" action="post" id=$commentsFolder->getId()}?replyTo={$comment->getId()}">Ответить</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="show-code">
            <a href="{url route="quoteView" id=$quote->getId()}" class="show-code-trigger">Показать код ▼</a>
            <div class="code-holder">
                <h3><a rel="chapter" href="{url route="categoryList" name=$quote->getCategory()->getName()|h}">{$quote->getCategory()->getTitle()|h}</a> / <a rel="bookmark" class="entry-title" href="{url route="quoteView" id=$quote->getId()}">Говнокод #{$quote->getId()}</a></h3>
                <div class="entry-content">
                {if $quote->isSpecial()}
                    {$quote->getText()}
                {else}
                    <ol>{foreach from=$quote->generateLines() item="line"}<li>{$line}</li>{/foreach}</ol>
                    {$quote->getText()|highlite:$langName:$quote->getCacheKey()}
                {/if}
                </div>
                <p class="description">
                    {$quote->getDescription()|trim|h|bbcode|nl2br}
                </p>
                <p class="author">
                    Запостил: <a href="{url route="withId" module="user" action="" id=$quote->getUser()->getId()}"><img src="{$quote->getUser()->getAvatarUrl(20)|h}" alt="" class="avatar" /></a> <a href="{url route="withId" module="user" action="" id=$quote->getUser()->getId()}">{$quote->getUser()->getLogin()|h}</a>,
                    <abbr title="{"c"|date:$quote->getCreated()}">{$quote->getCreated()|date_i18n:"date2"}</abbr>
                </p>
                <div class="entry-comments">
                    <span class="comments-icon"></span><a href="{url route="quoteView" id=$quote->getId()}#comments">Все комментарии</a> <span class="entry-comments-count">({$quote->getCommentsCount()})</span>
                </div>
            </div>
        </div>
    </li>
{/if}
{/foreach}
</ol>