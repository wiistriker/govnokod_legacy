{if $isEdit}
    <div class="jipTitle">Редактирование &quot;{$category->getTitle()|h}&quot;</div>
{else}
    <div class="jipTitle">Создание новой категории</div>
{/if}

{form action=$form_action method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style="width: 20%;">{form->caption name="name" value="Идентификатор:"}</td>
            <td style="width: 80%;">
                {form->text name="name" value=$category->getName() size="60"}
                {if $validator->isFieldError('name')}<div class="error">{$validator->getFieldError('name')}</div>{/if}
            </td>
        </tr>
        <tr>
            <td>{form->caption name="title" value="Заголовок:"}</td>
            <td>
                {form->text name="title" value=$category->getTitle() size="60"}
                {if $validator->isFieldError('title')}<div class="error">{$validator->getFieldError('title')}</div>{/if}
            </td>
        </tr>
        <tr>
            <td>{form->caption name="geshi_alias" value="Geshi alias:"}</td>
            <td>
                {form->text name="geshi_alias" value=$category->getGeshiAlias() size="60"}
                {if $validator->isFieldError('geshi_alias')}<div class="error">{$validator->getFieldError('geshi_alias')}</div>{/if}
            </td>
        </tr>
        <tr>
            <td>{form->caption name="js_alias" value="HighlighJS alias:"}</td>
            <td>
                {form->text name="js_alias" value=$category->getJsAlias() size="60"}
                {if $validator->isFieldError('js_alias')}<div class="error">{$validator->getFieldError('js_alias')}</div>{/if}
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>