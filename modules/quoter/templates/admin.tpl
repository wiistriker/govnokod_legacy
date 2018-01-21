<div class="title">Список цитат</div>

<table class="admin">
    <thead class="tableListHead">
        <tr class="first center">
            <th class="first" style="width: 30px;">&nbsp;</th>
            <th class="left">Название</th>
            <th class="left">Категория</th>
            <th class="left">Текущий рейтинг</th>         <th class="left">Количество комментариев</th>
            <th class="left">Активен</th>
            <th class="last" style="width: 30px;">JIP</th>
        </tr>
    </thead>

    {foreach from=$quotes item="quote"}
        <tr>
            <td class="first center"><img src="{$SITE_PATH}/templates/images/page/page.gif" alt="" /></td>
            <td align="left"><a href="{url route="quoteView" id=$quote->getId()}">Говнокод #{$quote->getId()}</a></td>
            <td align="left">{$quote->getCategory()->getTitle()|h}</td>
            <td align="center">{$quote->getRating()}</td>
            <td align="center">{$quote->getCommentsCount()}</td>
            <td align="center">{if $quote->getIsActive()}Да{else}Нет{/if}</td>
            <td class="last center">{$quote->getJip()}</td>
        </tr>
    {/foreach}
    <tr class="last">
        <td class="first"></td>
        <td>{$pager->toString('admin/main/adminPager.tpl')}</td>
        <td class="last center" colspan="5" style="text-align: right; color: #7A7A7A;">Всего: {$pager->getItemsCount()}</td>
    </tr>
</table>