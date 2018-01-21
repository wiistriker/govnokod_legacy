{assign var="commentsFolderId" value=$commentsFolder->getId()}
{add file="jquery.js"}{add file="govnokod.js"}
<h3><a href="{url route="withId" module="comments" action="post" id=$commentsFolderId}"{if !$hideForm}class="selected" {/if} onclick="comments.moveForm(0, {$commentsFolderId}, this); return false;">Добавить комментарий</a></h3>
<div id="answerForm_{$commentsFolderId}_0">
{if $hideForm}{assign var="formStyle" value="display: none;"}{else}{assign var="formStyle" value=""}{/if}
{form id="commentForm_$commentsFolderId" action=$action method="post" style=$formStyle onsubmit="comments.postForm(this); return false;" onkeypress="comments.handleCtrEnter(event, this);"}
    {include file="comments/postForm.tpl"}
</form>
</div>