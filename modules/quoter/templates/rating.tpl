{strip}
{if $toolkit->getUser()->isLoggedIn()}
    {if $toolkit->getUser()->getId() == $quote->getUser()->getId()}
        <span class="vote-on" title="Я не могу голосовать за собственный код">&darr;</span>
        <strong{if $quote->getRating() < 0} class="bad"{/if} title="{$quote->getRatingsOn()|h} за и {$quote->getRatingsAgainst()|h} против">{if $quote->getRating() > 0}+{elseif $quote->getRating() < 0}&minus;{/if}{$quote->getRating()|@abs}</strong>
        <span class="vote-against" title="Я не могу голосовать за собственный код">&uarr;</span>
    {else}
        {if $quote->getCurrentUserRate()}
            {if $quote->getCurrentUserRate() == -1}<span class="vote-on my-vote" title="Мой голос">{else}<span class="vote-on">{/if}&darr;</span>
            <strong{if $quote->getRating() < 0} class="bad"{/if} title="{$quote->getRatingsOn()|h} за и {$quote->getRatingsAgainst()|h} против">{if $quote->getRating() > 0}+{elseif $quote->getRating() < 0}&minus;{/if}{$quote->getRating()|@abs}</strong>
            {if $quote->getCurrentUserRate() == 1}<span class="vote-against my-vote" title="Мой голос">{else}<span class="vote-against">{/if}&uarr;</span>
        {else}
            <a class="vote-against" rel="nofollow" href="{url route="rateForCode" id=$quote->getId() vote="against"}" title="Минусну!">&darr;</a>
            <strong{if $quote->getRating() < 0} class="bad"{/if} title="{$quote->getRatingsOn()|h} за и {$quote->getRatingsAgainst()|h} против">{if $quote->getRating() > 0}+{elseif $quote->getRating() < 0}&minus;{/if}{$quote->getRating()|@abs}</strong>
            <a class="vote-on" rel="nofollow" href="{url route="rateForCode" id=$quote->getId() vote="on"}" title="Плюсану!">&uarr;</a>
        {/if}
    {/if}
{else}
    <strong class="just-rating{if $quote->getRating() < 0} bad{/if}" title="{$quote->getRatingsOn()|h} за и {$quote->getRatingsAgainst()|h} против">{if $quote->getRating() > 0}+{elseif $quote->getRating() < 0}&minus;{/if}{$quote->getRating()|@abs}</strong>
    {*
    {if $justRate|default:false}
    <strong class="just-rating{if $quote->getRating() < 0} bad{/if}" title="{$quote->getRatingsOn()|h} за и {$quote->getRatingsAgainst()|h} против">{if $quote->getRating() > 0}+{elseif $quote->getRating() < 0}&minus;{/if}{$quote->getRating()|@abs}</strong>
    {else}
    <a class="vote-against" rel="nofollow" href="{url route="rateForCode" id=$quote->getId() vote="against" _secret=$quote->getVoteToken()}" title="Минусну!">&darr;</a>
    <strong{if $quote->getRating() < 0} class="bad"{/if} title="{$quote->getRatingsOn()|h} за и {$quote->getRatingsAgainst()|h} против">{if $quote->getRating() > 0}+{elseif $quote->getRating() < 0}&minus;{/if}{$quote->getRating()|@abs}</strong>
    <a class="vote-on" rel="nofollow" href="{url route="rateForCode" id=$quote->getId() vote="on" _secret=$quote->getVoteToken()}" title="Плюсану!">&uarr;</a>
    {/if}
    *}
{/if}
{/strip}