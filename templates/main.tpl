{* main="header.tpl" placeholder="content" *}
<div id="page">
    <div id="header">
        <h1><a rel="homepage" href="/">Говнокод: по колено в коде.</a></h1>

        {load module="user" action="openIDLogin" onlyForm=true tplPrefix="main_"}

        <ul id="navigation">
            <li><a href="{$SITE_PATH}/">Все</a></li>
            <li><a href="{url route="best"}">Лучший</a></li>
            <li{* style="background: url({$SITE_PATH}/images/new.png) no-repeat scroll 0% 50%; padding-left: 10px;"*}><a href="{url route="livecomments"}">Сток</a></li>
            <li><a href="{url route="search"}">Глупый поиск</a></li>
            {*<li><a href="#">Газета</a></li>*}
            <li class="add"><a href="{url route="quoteAdd"}">Наговнокодить!</a></li>
            {*
			<li><a href="http://govnokod.copiny.com/" onclick="CopinyWidget.show(); return false;" style="font-size: 11px;">Отзывы и предложения</a></li>
			
            <li><script type="text/javascript" src="http://reformal.ru/tab.js?title=%C3%EE%E2%ED%EE%EA%EE%E4.%F0%F3%3A+%EF%EE+%EA%EE%EB%E5%ED%EE+%E2+%EA%EE%E4%E5&amp;domain=govnokod&amp;color=adadad&amp;align=left&amp;charset=utf-8&amp;ltitle=%CE%F2%E7%FB%E2%FB&amp;lfont=Verdana, Geneva, sans-serif&amp;lsize=11px&amp;waction=0&amp;regime=1"></script></li>
            *}
            <li>
                <a href="http://govnokod.reformal.ru" onclick="Reformal.widgetOpen();return false;" onmouseover="Reformal.widgetPreload();">Oтзывы</a>

                <script type="text/javascript">
                    var reformalOptions = {
                        project_id: 9409,
                        show_tab: false,
                        project_host: "govnokod.reformal.ru"
                    };
                    
                    (function() {
                        var script = document.createElement('script');
                        script.type = 'text/javascript'; script.async = true;
                        script.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'media.reformal.ru/widgets/v3/reformal.js';
                        document.getElementsByTagName('head')[0].appendChild(script);
                    })();
                </script>
            </li>
        </ul>

        <p id="entrance">
            Нашли или выдавили из себя код, который нельзя назвать нормальным,
            на который без улыбки не взглянешь?
            Не торопитесь его удалять или рефакторить, &mdash; запостите его на
            говнокод.ру, посмеёмся вместе!
        </p>

        {load module="quoter" action="listCategories"}
    </div>

    <div id="content">
        {$content}
    </div>

    <div id="footer">
        <address>
            <span>&copy; 2008-{"Y"|date} &laquo;Говнокод.ру&raquo;{if $smarty.const.DEBUG_MODE} {$timer->toString()}{/if}</span>
            <span><a href="{url route="pageActions" name="feedback"}">Обратная связь</a> | <a href="{url route="pageActions" name="license"}">Лицензионное соглашение</a> | <a href="http://twitter.com/govnokod/"><img src="/images/footer_twitter.png" border="0" alt="" /> Follow us!</a>{*Работает на <a href="http://mzz.ru">mzz</a>*}</span>
        </address>
    </div>
</div>
