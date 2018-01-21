{if $isEdit}{title append="Редактировать говнокод"}{else}{title append="Наговнокодить"}{/if}
{add file="add.css"}
{add file="jquery.js"}
{add file="govnokod.save.js"}

<ol class="posts hatom">
    {if $isPreview}{strip}
{assign var="highlight" value=$user->getHighlightDriver()}
{if $highlight == "geshi"}
{assign var="langName" value=$quote->getCategory()->getGeshiAlias()|h}
{add file="langs/$langName.css"}
{else}
{assign var="langName" value=$quote->getCategory()->getJsAlias()|h}
{/if}{/strip}
    <li class="hentry">
        <h2><a rel="chapter" href="{url route="categoryList" name=$quote->getCategory()->getName()|h}">{$quote->getCategory()->getTitle()|h}</a> / Предпросмотр</h2>
        <div class="entry-content">
        {if $highlight == "geshi" && $quote->getLinesCount() > 30}
            <ol>{foreach from=$quote->generateLines(15) item="line"}<li>{$line}</li>{/foreach}<li>…</li><li>{$quote->getLinesCount()}</li></ol>
            {$quote->getText(15)|highlite:$langName:$quote->getCacheKey('15_')}
            <a class="trigger" href="{url route="quoteView" id=$quote->getId()}" title="показать весь код">показать весь код +</a>
        {else}
            <ol>{foreach from=$quote->generateLines() item="line"}<li>{$line}</li>{/foreach}</ol>
            {if $highlight == "geshi"}
            {$quote->getText()|highlite:$langName:$quote->getCacheKey()}
            {else}
            <pre><code class="{$langName|h}">{$quote->getText()|h}</code></pre>
            {/if}
        {/if}
        </div>
        <p class="description">
            {$quote->getDescription()|trim|h|bbcode|nl2br}
        </p>
        <p class="author">
            Запостил: <a href="{url route="withId" module="user" action="" id=$user->getId()}"><img src="{$user->getAvatarUrl(20)|h}" alt="" class="avatar" /></a> <a href="{url route="withId" module="user" action="" id=$user->getId()}">{$user->getLogin()|h}</a>,
            <abbr title="{"c"|date:$quote->getCreated()}">{$quote->getCreated()|date_i18n:"date2"}</abbr>
        </p>
    </li>
    {/if}

    <li class="hentry add">
        <h2>{if $isEdit}Редактирование <a href="{url route="quoteView" id=$quote->getId()}">говнокода #{$quote->getId()}</a>{else}Наговнокодить{/if}</h2>
        {form action=$formAction method="post"}
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
                {if $isEdit}{assign var="categoryValue" value=$quote->getCategory()->getId()}{else}{assign var="categoryValue" value=0}{/if}
                <dd>{form->select class="lang" name="category_id" options=$categoriesSelect emptyFirst=true value=$categoryValue}</dd>

                <dt>{form->caption name="text" value="Код (максимум 100 строк):"}</dt>
                <dd>
                    {if $quote->getText()}{assign var="text" value=$quote->getText()}{else}{assign var="text" value="\n\n\n\n\n\n\n\n\n\n"}{/if}
                    {form->textarea class="code" name="text" value=$text rows="10" cols="50"}
                </dd>

                <dt>{form->caption name="description" value="Описание:"}</dt>
                <dd>{form->textarea name="description" value=$quote->getDescription() rows="6" cols="50"}</dd>

                {if !$isEdit}<dt>{form->caption name="captcha" value="Проверочный код:"}</dt>
                <dd>{form->captcha name="captcha"}</dd>{/if}
            </dl>
            {*<p>
                {set name="licenseText"}Я обязуюсь не постить УГ{/set}
                {form->checkbox name="license" values="0|1" text=$licenseText nodefault=true}
            </p>*}
            <p>
                {form->submit class="send" name="submit" value="Накласть"}
                {form->submit name="preview" value="Предпросмотр" nodefault=true}
            </p>
        </form>
    </li>
</ol>