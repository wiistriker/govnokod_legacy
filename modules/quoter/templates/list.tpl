{strip}
{add file="jquery.js"}
{add file="jquery.scrollTo.js"}
{add file="govnokod.js"}
{assign var="highlight" value=$toolkit->getUser()->getHighlightDriver()}
{if $highlight == 'js'}{add file="jshighlight/govnokod.css"}{add file="jshighlight/highlight.pack.js"}{/if}
{if !$listAll}
    {title append=$category->getTitle()}
{else}
    {title append="По колено в коде"}
{/if}
{/strip}
<ol class="posts hatom">
{foreach from=$quotes item="quote" name="quotes"}
    {*
    {if $listAll && $pager->getRealPage() == 1 && $smarty.foreach.quotes.iteration == 3}
    <li class="hentry">
        <h2>Реклама</h2>
        <div style="text-align:center">
            <a href="http://amperkot.ru/?utm_source=gk&utm_medium=banner&utm_campaign=gk-2" target="_blank">
                <p><img src="/images/banners/amperkot.png" width="200px" alt="Amperkot.ru"/></p>
                <p>Интернет-магазин электронных компонентов, радиодеталей и микрокомпьютеров Amperkot.ru</p>
            </a>
        </div>
    </li>
    {/if}
    *}
    {include file="quoter/listitem.tpl" quote=$quote highlight=$highlight}
{foreachelse}
    <li class="hentry">
        <h2>Пусто</h2>
    </li>
{/foreach}
</ol>

{if $pager->getPagesTotal() > 1}
    {$pager->toString()}
{/if}