<div class="jipTitle">Редактирование говнокода #{$quote->getId()}</div>
{form action=$formAction method="post" jip=true}
    {if !$validator->isValid()}
    <dl class="errors">
        <dt>Ошибка компиляции кода:</dt>
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
        <dt>{form->caption name="category_id" value="Язык:"}</dt>
        <dd>{form->select name="category_id" options=$categoriesSelect emptyFirst=true value=$quote->getCategory()->getId()}</dd>

        <dt>{form->caption name="text" value="Код:"} (Максимум 100 строк)</dt>
        <dd>
            {form->textarea class="code" name="text" value=$text rows="10" cols="50" style="width: 90%;" value=$quote->getText()}
        </dd>

        <dt>{form->caption name="description" value="Описание:"}</dt>
        <dd>{form->textarea name="description" value=$quote->getDescription() rows="4" cols="50"}</dd>
    </dl>
    <p>
        {form->submit class="send" name="submit" value="Накласть"}
    </p>
</form>