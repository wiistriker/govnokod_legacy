{if !$isValidated}
{add file="jquery.js"}
{add file="govnokod.js"}
<div id="userpane">
    <ul class="menu">
        <li><a id="expand-trigger" href="{url route="openIDLogin"}">Войти в говнокод</a></li>
    </ul>

    {form action=$form_action method="post" class="pane-content"}
        <ul>
            <li>{form->text id="openid_identifier_small" name="openid_identifier" value=""}</li>
            <li class="submit-holder">{form->hidden name="url" value={url appendGet=true}}{form->submit id="openid_submit_small" name="openid_submit" value="Вхожу!" nodefault=true}</li>
        </ul>

        <p><a href="{url route="pageActions" name="whatisopenid"}">Что это?</a> | <a href="{url route="default2" module="user" action="login"}">Обычная форма входа</a></p>
    </form>
</div>
{else}
<div id="userpane">
    <ul class="menu">
        <li><a href="{url route="openIDLogin"}">{if $current_module == 'user' && $current_action == 'openIDLogin'}Войти в говнокод{else}Заполни данные, %username%!{/if}</a></li>
    </ul>
</div>
{/if}