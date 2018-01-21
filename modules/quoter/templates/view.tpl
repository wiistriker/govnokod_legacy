{strip}{add file="jquery.js"}{add file="jquery.scrollTo.js"}
{add file="govnokod.js"}
{assign var="number" value=$quote->getId()}
{title append="Говнокод #$number"}
{title append=$quote->getCategory()->getTitle()|h}
{meta description=$quote->getDescription() reset=true}

{assign var="highlight" value=$toolkit->getUser()->getHighlightDriver()}
{if $highlight == "geshi"}
{assign var="langName" value=$quote->getCategory()->getGeshiAlias()|h}
{if $langName}{add file="langs/$langName.css"}{/if}
{else}
{add file="jshighlight/govnokod.css"}{add file="jshighlight/highlight.pack.js"}
{assign var="langName" value=$quote->getCategory()->getJsAlias()|h}
{/if}

{/strip}
<ol class="posts hatom">
    <li class="hentry">
        <h2><a rel="chapter" href="{url route="categoryList" name=$quote->getCategory()->getName()|h}">{$quote->getCategory()->getTitle()|h}</a> / <a rel="bookmark" class="entry-title" href="{url route="quoteView" id=$quote->getId()}">Говнокод #{$quote->getId()}</a> {$quote->getJip()}</h2>
        <p class="vote">
            {include file="quoter/rating.tpl" quote=$quote}
        </p>
        <div class="entry-content">
            {if $quote->isSpecial()}
            {$quote->getText()}
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
            Запостил: <a href="{url route="withId" module="user" action="" id=$quote->getUser()->getId()}"><img src="{$quote->getUser()->getAvatarUrl(20)|h}" alt="" class="avatar" /></a> <a href="{url route="withId" module="user" action="" id=$quote->getUser()->getId()}">{$quote->getUser()->getLogin()|h}</a>,
            <abbr title="{"c"|date:$quote->getCreated()}">{$quote->getCreated()|date_i18n:"date2"}</abbr>
        </p>
        <div style="float:right">
            <a href="http://twitter.com/share" class="twitter-share-button" data-url="{url route="quoteView" id=$quote->getId()}" data-text="{$quote->getCategory()->getTitle()|h} / Говнокод #{$quote->getId()}" data-count="horizontal" data-via="govnokod">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
            <iframe src="http://www.facebook.com/plugins/like.php?app_id=262270407124304&amp;href={url route="quoteView" id=$quote->getId()}&amp;send=false&amp;layout=button_count&amp;width=130&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=20" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:20px;" allowTransparency="true"></iframe>
        </div>
        {load module="comments" action="list" object=$quote}
    </li>
</ol>