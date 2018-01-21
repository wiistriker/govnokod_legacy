{add file="jquery.js"}
{add file="govnokod.js"}
<div class="entry-comments">
    <h3>Комментарии <span class="enrty-comments-count">({$commentsFolder->getCommentsCount()})</span> <span class="rss"><a href="{url route="withId" module="comments" action="rss" id=$commentsFolder->getId()}" rel="alternative">RSS</a></span></h3>
    <ul id="comments_{$commentsFolder->getId()}">
    {foreach from=$comments item="comment" name="commentsIteration"}
        {strip}{if !$smarty.foreach.commentsIteration.first}
            {if $comment->getTreeLevel() < $lastLevel}
                {math equation="x - y" x=$lastLevel y=$comment->getTreeLevel() assign="levelDown"}
                {"</li></ul>"|@str_repeat:$levelDown}</li>
            {elseif $lastLevel == $comment->getTreeLevel()}
                </li>
            {else}
                <ul>
            {/if}
        {/if}{/strip}
        <li class="hcomment">
            {include file="comments/listitem.tpl" commentsFolder=$commentsFolder comment=$comment}

            <ul><li id="answerForm_{$commentsFolder->getId()}_{$comment->getId()}"></li></ul>
        {strip}{assign var="lastLevel" value=$comment->getTreeLevel()}
        {if $smarty.foreach.commentsIteration.last}
            {math equation="x - y" x=$lastLevel y=1 assign="levelDown"}
            {"</li></ul>"|@str_repeat:$levelDown}</li>
        {/if}{/strip}
    {foreachelse}
        <li></li>
    {/foreach}
    </ul>
    {if $comments->isEmpty()}{assign var="hideForm" value=false}{else}{assign var="hideForm" value=true}{/if}
    {load module="comments" action="post" tplPrefix="list_" hideForm=$hideForm id=$commentsFolder onlyForm=true}
</div>
