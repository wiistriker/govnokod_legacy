{title append="Восстановление забытого пароля"}
<ol class="posts">
    <li class="hentry">
        <h2>Восстановление забытого пароля</h2>

        {form action=$form_action method="post"}
            {if !$validator->isValid()}
            <dl class="errors">
                <dt>Ошибка восстановления пароля:</dt>
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
                <dt>{form->caption name="loginemail" value="Логин или E-mail:"}</dt>
                <dd>{form->text name="loginemail"}</dd>
                
                <dt>{form->caption name="captcha" value="Проверочный код:"}</dt>
                <dd>{form->captcha name="captcha"}</dd>
            </dl>
            <p>
                {form->submit class="send" name="recover" value="Зарегистрироваться!"}
            </p>
        </form>
    </li>
</ol>