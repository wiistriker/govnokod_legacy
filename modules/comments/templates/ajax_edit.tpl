{form class="edit-comment-form" action=$form_action method="post"}
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