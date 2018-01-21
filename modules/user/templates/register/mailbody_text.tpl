{include file="service/mail/header_text.tpl"}
Hello, {$user->getLogin()|h}!

На Ваш e-mail была запрошена регистрация на сайте Говнокод.ру ({$toolkit->getRequest()->getUrl()}/)!

Для подтверждения своих намерений перейдите по этой ссылке:

{url route="user-confirm" _code=$user->getConfirmed()}


Внимание! Ссылка будет доступна в течение 3-х суток. Если Вы не подтвердите регистрацию за это время, то пользователь будет удален и процесс регистрации придется начинать заново!

{include file="service/mail/footer_text.tpl"}