Hello, <em>{$quoteUser->getLogin()|h}</em>!<br />
<br />
Между прочим, у Вашего <a href="{url route="quoteView" id=$quote->getId()}" title="Перейти к просмотру говнокода">говнокода #{$quote->getId()}</a>
появился <a href="{url route="quoteView" id=$quote->getId()}#comment{$comment->getId()}" title="Перейти к чтению комментария">новый комментарий</a>!<br />
<br />
Вот его содержание:<br />
<em>{$comment->getText()|trim|h|nl2br|bbcode}</em><br />
<br />
<br />
{url route="quoteView" id=$quote->getId()}/#comment{$comment->getId()}
<br />
<br />
С уважением, Ваш <a href="{url route="default"}">Говнокод</a>.