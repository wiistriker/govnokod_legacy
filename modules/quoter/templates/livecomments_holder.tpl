{title append="Сток"}
{add file="jquery.js"}
{add file="govnokod.js"}
{add file="livecomments.js"}
{add file="livecomments.css"}
{assign var="highlight" value=$toolkit->getUser()->getHighlightDriver()}
{if $highlight == 'js'}{add file="jshighlight/govnokod.css"}{add file="jshighlight/highlight.pack.js"}{/if}
{$html}