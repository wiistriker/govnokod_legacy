{title append="Добавление OpenID идентификатора"}
<ol class="posts">
    <li class="hentry">
        <h2><a href="{url route="default2" module="user" action="login"}">Моя личная кабинка</a> → <a href="{url route="default2" module="user" action="preferences"}">Настройки</a> → <a href="{url route="withAnyParam" module="user" action="preferences" name="personal"}">Персональные</a> → Добавить OpenID</h2>
        {form action=$form_action method="post"}
            {if !$validator->isValid()}
            <dl class="errors">
                <dt>Ошибка добавления:</dt>
                <dd>
                    <ol>
                    {foreach from=$validator->getErrors() item="error"}
                        <li>{$error}</li>
                    {/foreach}
                    </ol>
                </dd>
            </dl>
            {/if}
            <dl>
                <dt>{form->caption name="openid_identifier" value="OpenID:"}</dt>
                <dd>{form->text name="openid_identifier" value=$openIDUrl}</dd>
            </dl>
            <p>
                {form->submit class="send" name="openid_submit" value="Добавить"}
            </p>
        </form>
        <p>&nbsp;</p>
        <p><a href="{url route="pageActions" name="whatisopenid"}">Что такое OpenID?</a></p>
    </li>
</ol>