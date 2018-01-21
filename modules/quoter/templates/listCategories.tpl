<ol id="language">
{foreach from=$categories item="categoryl"}
    <li><a href="{url route="categoryList" name=$categoryl->getName()|h}">{$categoryl->getTitle()|h}</a> <span>({$categoryl->getQuoteCounts()})</span></li>
{/foreach}
</ol>