{strip}
{add file="jquery.js"}
{add file="jquery.scrollTo.js"}
{add file="govnokod.js"}
{assign var="highlight" value=$toolkit->getUser()->getHighlightDriver()}
{if $highlight == 'js'}{add file="jshighlight/govnokod.css"}{add file="jshighlight/highlight.pack.js"}{/if}
{title append="Список говнокодов пользователя `$user->getLogin()`"}
{/strip}
<ol class="posts hatom">
    <li class="hentry">
        <h2>Список говнокодов пользователя <a href="{url route="withId" module="user" action="" id=$user->getId()}">{$user->getLogin()|h}</a></h2>
        <p>Всего: {$pager->getItemsCount()|h}</p>
    </li>
{foreach from=$quotes item="quote"}
    {include file="quoter/listitem.tpl" quote=$quote highlight=$highlight}
{foreachelse}
    <li class="hentry">
        <h2>Пусто</h2>
        <p>Пользователь еще не успел наговнокодить</p>
    </li>
{/foreach}
</ol>

{if $pager->getPagesTotal() > 1}
    {$pager->toString()}
{/if}