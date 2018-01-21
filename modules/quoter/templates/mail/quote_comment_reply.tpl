Hello, <em>{$you->getLogin()|h}</em>!<br />
<br />
Пользователь <a href="{url route="withId" module="user" action="" id=$him->getId()}">{$him->getLogin()|h}</a> ответил на Ваш комментарий к <a href="{url route="quoteView" id=$quote->getId()}">говнокоду #{$quote->getId()}</a>!<br />
<br />
Напомним, Вы <a href="{$commentsFolder->getDefaultBackUrl()|h}#comment{$yourComment->getId()}">написали</a>:<br />
<em>{$yourComment->getText()|trim|h|nl2br|bbcode}</em><br />
<br />
На что получили <a href="{$commentsFolder->getDefaultBackUrl()|h}#comment{$answerComment->getId()}">ответ</a>:<br />
<em>{$answerComment->getText()|trim|h|nl2br|bbcode}</em>
<br /><br /><br />
С уважением, Ваш <a href="{url route="default"}">Говнокод</a>.