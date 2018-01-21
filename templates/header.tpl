<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{title separator=" — " end=" — "} Говнокод.ру</title>
    <meta name="keywords" content="{meta show="keywords" default="говнокод, смешной код, быдлокод, быдлокодеры, индусы, для программистов, про программистов, индусский код, записки программиста, говно, говнокод на php, mysql, perl"}" />
    <meta name="description" content="{meta show="description" default="Сборник говнокода на различных языках программирования"}" />
    <meta property="og:image" content="http://govnokod.ru/images/brand.gif" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="/animated_favicon.gif" type="image/gif" />
    <link rel="stylesheet" href="{$SITE_PATH}/css/style.css?v=4" media="all" type="text/css" />
    <!--[if lte IE 7]><link href="{$SITE_PATH}/css/ie.css" rel="stylesheet" type="text/css"><![endif]-->
{if $listAll|default:true}
    <link title="rss govnokod.ru" type="application/rss+xml" rel="alternate" href="{url route="rss"}"/>
{else}
    <link title="rss {$category->getTitle()|h} govnokod.ru" type="application/rss+xml" rel="alternate" href="{url route="rssFull" name=$category->getName()}"/>
{/if}
    {include file='include.external.bundle.css.tpl'}
    <script type="text/javascript">
    //<!--
    var SITE_PATH = '{$SITE_PATH}'; var SITE_LANG = '{$current_lang}';
    //-->
    </script>
    {include file='include.external.bundle.js.tpl'}
</head>
<body>
{$content}
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-6478594-1");
pageTracker._trackPageview();
</script>
{*
<script type="text/javascript" src="http://copiny.com/static/js/widget.js"></script>
{literal}<script type="text/javascript" charset="utf-8">
var copinyWidgetOptions = {
	position: 'left',
	color: 	  '#ff8400',
	title:	  'Оставить отзыв',
	community:47
};
initCopinyWidget(copinyWidgetOptions);
</script>{/literal}
*}
</body>
</html>