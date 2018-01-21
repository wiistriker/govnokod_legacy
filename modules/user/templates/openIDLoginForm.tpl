{title append="Вход в говнокод тут"}
<ol class="posts">
    <li class="hentry">
        <h2>Вход в говнокод тут</h2>
        {form action=$form_action method="post"}
            {if !$validator->isValid()}
            <dl class="errors">
                <dt>Ошибка авторизации:</dt>
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
                {form->submit class="send" name="openid_submit" value="Вхожу!"}
            </p>
        </form>
        <p>&nbsp;</p>
        <p><a href="{url route="pageActions" name="whatisopenid"}">Что это?</a> | <a href="{url route="default2" module="user" action="login"}">Обычная форма входа</a></p>
    </li>
</ol>