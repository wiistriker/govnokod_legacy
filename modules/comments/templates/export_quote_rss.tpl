<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Говнокод.ру — Комментарии говнокода #{$commentsFolder->getParentId()}</title>
        <link>{assign var="rss_url" value={url route="rssComments" id=$commentsFolder->getParentId()}}{$rss_url|h}</link>
        <description><![CDATA[Говнокод: по колено в коде]]></description>
        <language>ru</language>
        <managingEditor>support@govnokod.ru (govnokod.ru support)</managingEditor>
        <generator>{$smarty.const.MZZ_NAME} v.100500-{$smarty.const.MZZ_REVISION}</generator>
        <pubDate>{"D, d M Y H:i:s O"|date:$smarty.now}</pubDate>
        <lastBuildDate>{"D, d M Y H:i:s O"|date:$comments->rewind()->getCreated()}</lastBuildDate>
        <image>
            <link>{$rss_url|h}</link>
            <url>http://govnokod.ru/images/brand.png</url>
            <title>Говнокод.ру — Комментарии говнокода #{$commentsFolder->getParentId()}</title>
        </image>
        <atom:link href="{$rss_url|h}" rel="self" type="application/rss+xml" />
{foreach from=$comments item="comment" name="commentsIterator"}
        <item>
            <title>Комментарий #{$smarty.foreach.commentsIterator.iteration}</title>
            <guid isPermaLink="true">{assign var="item_url" value={url route="quoteView" id=$commentsFolder->getParentId()}}{$item_url|h}#comment{$comment->getId()}</guid>
            <link>{$item_url|h}#comment{$comment->getId()}</link>
            <description>
                <![CDATA[
                {$comment->getText()|trim|h|nl2br|bbcode}
                ]]>
            </description>
            <pubDate>{"D, d M Y H:i:s O"|date:$comment->getCreated()}</pubDate>
            <author>{$comment->getUser()->getLogin()|h}</author>
        </item>
{/foreach}
    </channel>
</rss>