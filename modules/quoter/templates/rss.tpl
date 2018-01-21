<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Говнокод.ру{if $action == 'userrss'} — лента пользователя {$user->getLogin()|h}{/if}{if $withCategory} — {$category->getTitle()|h}{/if}</title>
        <link>{if !$withCategory}{assign var="rss_url" value={url route="rss"}}{else}{assign var="rss_url" value={url route="rssFull" name=$category->getName()}}{/if}{$rss_url|h}</link>
        <description><![CDATA[Говнокод: по колено в коде]]></description>
        <language>ru</language>
        <managingEditor>support@govnokod.ru (govnokod.ru support)</managingEditor>
        <generator>{$smarty.const.MZZ_NAME} v.100500-{$smarty.const.MZZ_REVISION}</generator>
        <pubDate>{"D, d M Y H:i:s O"|date:$smarty.now}</pubDate>
        <lastBuildDate>{"D, d M Y H:i:s O"|date:$quotes->rewind()->getCreated()}</lastBuildDate>
        <image>
            <link>{$rss_url|h}</link>
            <url>http://govnokod.ru/images/brand.png</url>
            <title>Говнокод.ру</title>
        </image>
        <atom:link href="{$rss_url|h}" rel="self" type="application/rss+xml" />
{foreach from=$quotes item="quote"}
        <item>
            <title>{$quote->getCategory()->getTitle()|h} / Говнокод #{$quote->getId()}</title>
            <guid isPermaLink="true">{url route="quoteView" id=$quote->getId()}</guid>
            <link>{url route="quoteView" id=$quote->getId()}</link>
            <description>
                <![CDATA[
{if $quote->getDescription() != ''}
                    <p>{$quote->getDescription()|trim|h|bbcode|nl2br}</p>
{/if}
{if $quote->isSpecial()}
                    {$quote->getText()}
{else}
                    <pre><code class="{$quote->getCategory()->getJsAlias()|h}">{$quote->getText()|h}</code></pre>
{/if}
                ]]>
            </description>
            <pubDate>{"D, d M Y H:i:s O"|date:$quote->getCreated()}</pubDate>
            <category>{$quote->getCategory()->getTitle()|h}</category>
            <author>{$quote->getUser()->getLogin()|h}</author>
        </item>
{/foreach}
    </channel>
</rss>