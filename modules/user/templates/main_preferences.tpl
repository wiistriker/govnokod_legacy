{title append="Настройки"}
<ol class="posts">
    <li class="hentry">
        <h2><a href="{url route="default2" module="user" action="login"}">Моя личная кабинка</a> → Настройки</h2>
        {if $is_saved}<p style="font-size: 20px;">Данные успешно сохранены!</p>{/if}
        <ul>
            <li><a href="{url route="withAnyParam" module="user" action="preferences" name="global"}">Глобальные настройки</a></li>
            <li><a href="{url route="withAnyParam" module="user" action="preferences" name="personal"}">Персональные настройки</a></li>
        </ul>
    </li>
</ol>