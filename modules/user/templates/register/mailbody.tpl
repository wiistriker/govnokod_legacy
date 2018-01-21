{include file="service/mail/header.tpl"}
Hello, <i>{$user->getLogin()|h}</i>!<br />
<br />
На Ваш e-mail была запрошена регистрация на сайте <a href="{url route="default"}">Говнокод.ру</a>!<br />
<br />
Для подтверждения своих намерений перейдите по этой ссылке:<br />
<br />
{assign var="confirmUrl" value={url route="user-confirm" _code=$user->getConfirmed()}}<a href="{$confirmUrl|h}">{$confirmUrl|h}</a><br />
<br/>
<br/>
Внимание! Ссылка будет доступна в течение 3-х суток. Если Вы не подтвердите регистрацию за это время, то пользователь будет удален и процесс регистрации придется начинать заново!<br />
{include file="service/mail/footer.tpl"}