{title append="Вход в говнокод тут"}
<ol class="posts">
    <li class="hentry">
        <h2>Вход в говнокод тут</h2>

        <p>Если Вы видите этот экран, то это значит, что указанный OpenID идентификатор впервые используется для входа на Говнокод.ру. Для того, чтобы навсегда убрать его, заполните форму ниже:</p>

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
                <dt>Авторизуемся под:</dt>
                <dd><strong>{$openIDUrl|h}</strong></dd>

                {if isset($regData.nickname)}{assign var="login" value=$regData.nickname}{else}{assign var="login" value=''}{/if}
                <dt>{form->caption name="login" value="Логин:"}</dt>
                <dd>{form->text name="login" value=$login}</dd>

                {if isset($regData.email)}{assign var="email" value=$regData.email}{else}{assign var="email" value=''}{/if}
                <dt>{form->caption name="email" value="E-mail:"}</dt>
                <dd>{form->text name="email" value=$email}</dd>
            </dl>
            <p>
                {form->submit class="send" name="openid_reg_cancel" value="Отменить" nodefault=true}
                {form->submit class="send" name="openid_reg_submit" value="Подтверждаю >>"}
            </p>
        </form>
    </li>
</ol>