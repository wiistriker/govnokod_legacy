{if $media.css}
{strip}
{assign var="external" value=""}
{foreach from=$media.css item="cssitem" key="file" name="cssFiles"}
{if $cssitem.join}
{assign var="external" value="$external$file,"}
{else}
{include file=$cssitem.tpl filename=$file}
{/if}
{/foreach}
{if $external}
<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/media/{$external|substr:0:-1|@md5}.css?files={$external|substr:0:-1}" />
{/if}
{/strip}
{/if}