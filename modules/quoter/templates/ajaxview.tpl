{assign var="highlight" value=$toolkit->getUser()->getHighlightDriver()}
<ol>{foreach from=$quote->generateLines() item="line"}<li>{$line}</li>{/foreach}</ol>
{if $highlight == "geshi"}
{assign var="langName" value=$quote->getCategory()->getGeshiAlias()|h}
{$quote->getText()|highlite:$langName:$quote->getCacheKey()}
{else}
{assign var="langName" value=$quote->getCategory()->getJsAlias()|h}
<pre><code class="{$langName|h}">{$quote->getText()|h}</code></pre>
{/if}