{include file="service/mail/header_text.tpl"}
Hello, {$user->getLogin()|h}!

Это письмо было выслано вам по запросу на восстановление пароля на сайте Говнокод.ру ({$toolkit->getRequest()->getUrl()}/)
(если вы не запрашивали восстановление пароля, просто удалите это письмо)

Для смены пароля пройдите по этой ссылке:
{url route="user-recover-pass" _code=$user->getRecoverCode()}
(ссылка будет работать в течение суток)
{include file="service/mail/footer_text.tpl"}