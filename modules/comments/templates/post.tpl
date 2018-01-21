{add file="jquery.js"}
{add file="govnokod.js"}
<ol class="posts hatom">
    <li class="hentry">
        {if !$commentReply}{title append="Добавление комментария"}
        <h2>Добавление комментария для <a href="{url route="quoteView" id=$commentsFolder->getParentId()}">Говнокода #{$commentsFolder->getParentId()}</a></h2>
        {else}{title append="Ответ на комментарий"}
        <h2>Ответ на <a href="{url route="quoteView" id=$commentsFolder->getParentId()}#comment{$commentReply->getId()}">комментарий</a> для <a href="{url route="quoteView" id=$commentsFolder->getParentId()}">Говнокода #{$commentsFolder->getParentId()}</a></h2>
        {/if}
        <div class="entry-comments">
            {form action=$action method="post" onkeypress="comments.handleCtrEnter(event, this);"}
                {include file="comments/postForm.tpl"}
            </form>
        </div>
    </li>
</ol>