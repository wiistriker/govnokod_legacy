{strip}
    <ul class="pagination">
        <li>{if !is_null($pager->getPrev())}<a href="{$pager->getPrev()|h}">&larr; влево</a>{else}&larr; влево{/if}</li>
        <li>{if !is_null($pager->getNext())}<a href="{$pager->getNext()|h}">вправо &rarr;</a>{else}вправо &rarr;{/if}</li>
    </ul>

    <ul class="pagination numbered">
        {foreach from=$pages item=current}
            {if not empty($current.skip)}
            <li>…</li>
            {elseif not empty($current.current)}
            <li><span>{$current.page}</span></li>
            {else}
            <li><a href="{$current.url|h}">{$current.page}</a></li>
            {/if}
        {/foreach}
    </ul>
{/strip}