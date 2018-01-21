{strip}
{title append="Поиск говнокода"}
{add file="jquery.js"}
{add file="jquery.scrollTo.js"}
{add file="govnokod.js"}
{assign var="highlight" value=$toolkit->getUser()->getHighlightDriver()}
{if $highlight == 'js'}{add file="jshighlight/govnokod.css"}{add file="jshighlight/highlight.pack.js"}{/if}
{/strip}
<ol class="posts hatom">
    <li class="hentry">
        <h2>Поиск говнокода</h2>
        <p>Этот поиск практически ничего не может найти! Но вы всё-таки попытайтесь, вдруг повезет.</p>
        {strip}{capture name="searchUrl"}{if $category|default:false}{url route="search" name=$category->getName()}{else}{url route="search"}{/if}{/capture}
        <form action="{$smarty.capture.searchUrl|h}" method="get">
            <dl>
                <dt>{form->caption name="search" value="Поисковая строка:"}</dt>
                <dd>{form->text name="search" maxlength=50}</dd>

                <dt>{form->caption name="language" value="В языке:"}</dt>
                <dd>{form->select name="language" options=$categorySelect emptyFirst="Во всех"}</dd>
            </dl>
            <p>
                <input type="submit" class="send" value="Покопаться!"/>
            </p>
        </form>
        {/strip}
        {if $word != '' && $pager->getItemsCount() > 0}
        <p>Найдено: {$pager->getItemsCount()}</p>
        {/if}
    </li>
    {if $word != ''}
{foreach from=$quotes item="quote"}
    {include file="quoter/listitem.tpl" quote=$quote highlight=$highlight}
{foreachelse}
    <li class="hentry">
        <h2>Ничего не найдено</h2>
        <p>Поиск не дал результатов!</p>
    </li>
{/foreach}
    {if $pager|default:false &&  $pager->getPagesTotal() > 1}
        {$pager->toString()}
    {/if}
    {/if}
</ol>