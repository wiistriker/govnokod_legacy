{include file="service/mail/header.tpl"}
Hello, <i>{$user->getLogin()|h}</i>!<br />
<br />
Это письмо было выслано вам по запросу на восстановление пароля на сайте <a href="{$toolkit->getRequest()->getUrl()|h}">Говнокод.ру</a><br />
(если вы не запрашивали восстановление пароля, просто удалите это письмо)<br />
<br />
Для смены пароля пройдите по этой ссылке:<br />
{assign var="userRecoverUrl" value={url route="user-recover-pass" _code=$user->getRecoverCode()}}<a href="{$userRecoverUrl|h}">{$userRecoverUrl|h}</a><br />
(ссылка будет работать в течение суток)<br />
{include file="service/mail/footer.tpl"}