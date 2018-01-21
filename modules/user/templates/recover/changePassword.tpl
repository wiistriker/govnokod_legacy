{title append="Смена пароля"}
<ol class="posts">
    <li class="hentry">
        <h2>Смена пароля</h2>
        {form action=$form_action method="post"}
            {if !$validator->isValid()}
            <dl class="errors">
                <dt>Ошибка смены пароля:</dt>
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
                <dt>{form->caption name="newpassword" value="Новый пароль:" class="iText"}</dt>
                <dd>{form->password name="newpassword" size="40" class="iText" maxlength="255"}</dd>

                <dt>{form->caption name="repassword" value="Повтор пароля:" class="iText"}</dt>
                <dd>{form->password name="repassword" size="40" class="iText" maxlength="255"}</dd>
            </dl>
            <p>
                {form->submit class="send" name="change_pass" value="Сменить пароль"}
            </p>
        </form>
    </li>
</ol>