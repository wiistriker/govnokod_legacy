{add file="jquery.js"}
{add file="govnokod.js"}
{title append="Редактировать комментарий"}
<ol class="posts hatom">
    <li class="hentry">
        <h2>Редактирование комментария</h2>
        <div class="entry-comments">
            {form action=$form_action method="post" onkeypress="comments.handleCtrEnter(event, this);"}
            {if !$validator->isValid()}
                <dl class="errors">
                    <dt>Ошибка редактирования комментария:</dt>
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
                    <dt>{$formTitle}</dt>
                    <dd>{form->textarea name="text" value=$comment->getText() rows="5" cols="5"}</dd>
                </dl>
                <p>{form->submit class="send" name="commentSubmit" value="Отредактировать комментарий"}</p>
            </form>
        </div>
    </li>
</ol>