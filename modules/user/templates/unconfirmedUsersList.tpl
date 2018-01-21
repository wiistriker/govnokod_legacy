<div class="title">Неактивированные пользователи</div>
<table class="admin">
    <thead>
        <tr class="first center">
            <th class="first" style="width: 30px;">ID:</th>
            <th class="left">Логин:</th>
            <th class="left">Email:</th>
            <th class="left">Создан:</th>
            <th class="last" style="width: 30px;">JIP</th>
        </tr>
    </thead>
    <tbody>
{foreach from=$users item="user"}
        <tr class="center">
            <td class="first">{$user->getId()}</td>
            <td class="left">{$user->getLogin()|h}</td>
            <td class="left">{$user->getEmail()|h}</td>
            <td class="left">{$user->getCreated()|date_i18n:"short_date_short_time"}</td>
            <td class="last">{$user->getJip()}</td>
        </tr>
{/foreach}
        <tr class="last">
            <td class="first"></td>
            <td colspan="2">{$pager->toString('admin/main/adminPager.tpl')}</td>
            <td class="last" colspan="2" style="text-align: right; color: #7A7A7A;">Всего: {$pager->getItemsCount()}</td>
        </tr>
    </tbody>
</table>