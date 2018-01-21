{title append="Регистрация нового пользователя"}
<ol class="posts">
    <li class="hentry">
        <h2>Регистрация нового пользователя</h2>

        {form action=$form_action method="post"}
            {if !$validator->isValid()}
            <dl class="errors">
                <dt>Ошибка регистрации:</dt>
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
                <dt>{form->caption name="login" value="Логин:"}</dt>
                <dd>{form->text name="login"}</dd>

                <dt>{form->caption name="email" value="E-mail:"}</dt>
                <dd>{form->text name="email"}</dd>

                <dt>{form->caption name="password" value="Пароль:"}</dt>
                <dd>{form->password name="password"}</dd>

                <dt>{form->caption name="repassword" value="Повтор пароля:"}</dt>
                <dd>{form->password name="repassword"}</dd>
                
                <dt>{form->caption name="captcha" value="Проверочный код:"}</dt>
                <dd>{form->captcha name="captcha"}</dd>
            </dl>
            <p>
                {form->submit class="send" name="submit" value="Зарегистрироваться!"}
            </p>
        </form>
    </li>
</ol>