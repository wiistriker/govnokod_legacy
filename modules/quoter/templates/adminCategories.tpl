<div class="title">Список категорий {$folder->getJip()}</div>

<table class="admin">
    <thead class="tableListHead">
        <tr class="first center">
            <th class="first" style="width: 30px;">&nbsp;</th>
            <th class="left">Название</th>
            <th class="left">Идентификатор</th>
            <th class="left">Алиас geshi</th>
            <th class="left">Алиас HighlightJS</th>
            <th class="left">Количество элементов</th>
            <th class="last" style="width: 30px;">JIP</th>
        </tr>
    </thead>

    {foreach from=$categories item="category"}
        <tr>
            <td class="first center"><img src="{$SITE_PATH}/templates/images/page/page.gif" alt="" /></td>
            <td align="left">{$category->getTitle()|h}</td>
            <td align="left">{$category->getName()|h}</td>
            <td align="left">{$category->getGeshiAlias()|h}</td>
            <td align="left">{$category->getJsAlias()|h}</td>
            <td align="center">{$category->getQuoteCounts()}</td>
            <td class="last center">{$category->getJip()}</td>
        </tr>
    {/foreach}
    <tr class="last">
        <td class="first"></td>
        <td class="last center" colspan="6"></td>
    </tr>
</table>