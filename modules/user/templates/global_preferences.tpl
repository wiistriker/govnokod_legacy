{title append="Глобальные настройки"}
{assign var="helpPageUrl" value={url route="pageActions" name="preferences"}}
<ol class="posts">
    <li class="hentry">
        <h2><a href="{url route="default2" module="user" action="login"}">Моя личная кабинка</a> → <a href="{url route="default2" module="user" action="preferences"}">Настройки</a> → Глобальные</h2>
        {form action=$form_action method="post"}
            {if !$validator->isValid()}
            <dl class="errors">
                <dt>Ошибка сохранения настроек:</dt>
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
                <dt>{form->caption name="lang" value="Интересующие языки (<a href='{$helpPageUrl}#langs'>подробнее</a>):" label=false}</dt>
                <dd>
                    <ul>
                    {foreach from=$categories item="category" key="id"}
                        <li>{form->checkbox name="lang[$id]" values="0|1" text=$category->getTitle() style="width: auto;" value=$user->isPreferredLang($id) nodefault=true}</li>
                    {/foreach}
                    </ul>
                </dd>

                <dt>{form->caption name="hdriver" value="Способ подсветки кода (<a href='{$helpPageUrl}#highlight'>что выбрать?</a>):"}</dt>
                <dd>
                    {form->select name="hdriver" options=$drivers value=$user->getHighlightDriver()}
                </dd>

                <dt>{form->caption name="timezone" value="Часовой пояс:"}</dt>
                <dd>{form->select name="timezone" options=$timezones emptyFirst=true value=$user->getTimezone()}</dd>
            </dl>
            <p>
                {form->submit class="send" name="submit" value="Сохранить"}
            </p>
        </form>
    </li>
</ol>