{strip}
{if $toolkit->getUser()->isLoggedIn()}
    {if $toolkit->getUser()->getId() == $comment->getUser()->getId()}
            <strong{if $comment->getRating() < 0} class="bad"{elseif $comment->getRating() > 0} class="good"{/if} title="{$comment->getVotesOn()|h} за и {$comment->getVotesAgainst()|h} против">{if $comment->getRating() > 0}+{elseif $comment->getRating() < 0}&minus;{/if}{$comment->getRating()|@abs}</strong>
            <span class="comment-vote-against" title="Это мой комментарий, я не могу за него голосовать"> </span>
            <span class="comment-vote-on" title="Это мой комментарий, я не могу за него голосовать"> </span>
    {else}
        {if $comment->getCurrentUserRate()}
            <strong{if $comment->getRating() < 0} class="bad"{elseif $comment->getRating() > 0} class="good"{/if} title="{$comment->getVotesOn()|h} за и {$comment->getVotesAgainst()|h} против">{if $comment->getRating() > 0}+{elseif $comment->getRating() < 0}&minus;{/if}{$comment->getRating()|@abs}</strong>
            {if $comment->getCurrentUserRate() == -1}<span class="comment-vote-against my-vote" title="Мой голос!"> </span>{else}<span class="comment-vote-against"> </span>{/if}
            {if $comment->getCurrentUserRate() == 1}<span class="comment-vote-on my-vote" title="Мой голос!"> </span>{else}<span class="comment-vote-on"> </span>{/if}
        {else}
            <strong{if $comment->getRating() < 0} class="bad"{elseif $comment->getRating() > 0} class="good"{/if} title="{$comment->getVotesOn()|h} за и {$comment->getVotesAgainst()|h} против">{if $comment->getRating() > 0}+{elseif $comment->getRating() < 0}&minus;{/if}{$comment->getRating()|@abs}</strong>
            <a rel="nofollow" class="comment-vote-against" href="{url route="rateForComment" id=$comment->getId() vote="against"}" title="-1"> </a>
            <a rel="nofollow" class="comment-vote-on" href="{url route="rateForComment" id=$comment->getId() vote="on"}" title="+1"> </a>
        {/if}
    {/if}
{else}
    <strong class="just-rating{if $comment->getRating() < 0} bad{elseif $comment->getRating() > 0} good{/if}" title="{$comment->getVotesOn()|h} за и {$comment->getVotesAgainst()|h} против">{if $comment->getRating() > 0}+{elseif $comment->getRating() < 0}&minus;{/if}{$comment->getRating()|@abs}</strong>
    {*
    {if $justRate|default:false}
    <strong class="just-rating{if $comment->getRating() < 0} bad{elseif $comment->getRating() > 0} good{/if}" title="{$comment->getVotesOn()|h} за и {$comment->getVotesAgainst()|h} против">{if $comment->getRating() > 0}+{elseif $comment->getRating() < 0}&minus;{/if}{$comment->getRating()|@abs}</strong>
    {else}
    <strong{if $comment->getRating() < 0} class="bad"{elseif $comment->getRating() > 0} class="good"{/if} title="{$comment->getVotesOn()|h} за и {$comment->getVotesAgainst()|h} против">{if $comment->getRating() > 0}+{elseif $comment->getRating() < 0}&minus;{/if}{$comment->getRating()|@abs}</strong>
    <a rel="nofollow" class="comment-vote-against" href="{url route="rateForComment" id=$comment->getId() vote="against" _secret=$comment->getVoteToken()}" title="-1"> </a>
    <a rel="nofollow" class="comment-vote-on" href="{url route="rateForComment" id=$comment->getId() vote="on" _secret=$comment->getVoteToken()}" title="+1"> </a>
    {/if}
    *}
{/if}
{/strip}