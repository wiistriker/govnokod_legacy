{if $media.js}
{strip}
{assign var="external" value=""}
{foreach from=$media.js item="jsitem" key="file" name="jsFiles"}
{if $jsitem.join}
{assign var="external" value="$external$file,"}
{else}
{include file=$jsitem.tpl filename=$file}
{/if}
{/foreach}
{if $external}
<script type="text/javascript" src="{$SITE_PATH}/media/{$external|substr:0:-1|@md5}.js?files={$external|substr:0:-1}&amp;v=4"></script>
{/if}
{/strip}
{/if}