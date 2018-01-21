{assign var="commentsFolderId" value=$commentsFolder->getId()}
{if $hideForm}{assign var="formStyle" value="display: none;"}{else}{assign var="formStyle" value=""}{/if}
{form id="commentForm_$commentsFolderId" action=$action method="post" style=$formStyle onsubmit="comments.postForm(this); return false;" onkeypress="comments.handleCtrEnter(event, this);"}
    {include file="comments/postForm.tpl"}
</form>