   			<div id="comment-{$comment->getId()}" class="entry-comment-wrapper{if $lastTimeRead|default:false && $comment->getCreated() > $lastTimeRead} new{/if}">
                <p class="entry-info">
                    <img class="avatar" src="{$comment->getUser()->getAvatarUrl(28)|h}" alt="ava" title="Аватар" />
                    <strong class="entry-author"><a href="{url route="withId" module="user" id=$comment->getUser()->getId() action=""}">{$comment->getUser()->getLogin()|h}</a></strong>
					<abbr class="published" title="{"c"|date:$comment->getCreated()}">{$comment->getCreated()|date_i18n:'relative_hour'}</abbr>
                    <a href="{$commentsFolder->getDefaultBackUrl()|h}#comment{$comment->getId()}" name="comment{$comment->getId()}" title="Ссылка на комментарий" class="comment-link">#</a> {$comment->getJip()}
                    <span class="comment-vote">
                        {include file="comments/rating.tpl" comment=$comment}
                    </span>
                </p>
                <div class="entry-comment{if $comment->getRating() <= -5} entry-comment-hidden{/if}">{if $comment->getRating() <= -5}<span class="hidden-text"><a href="#" class="ajax">показать все, что скрыто</a></span>{/if}<span class="comment-text">{$comment->getText()|h|nl2br|bbcode}</span></div>
                <a class="answer" href="{url route="withId" module="comments" action="post" id=$commentsFolder->getId()}?replyTo={$comment->getId()}" onclick="comments.moveForm({$comment->getId()}, {$commentsFolder->getId()}, this); return false;">Ответить</a>
                {if $comment->canRun('edit')}<a class="edit-comment-link" href="{url route="withId" module="comments" action="edit" id=$comment->getId()}">Редактировать</a>{/if}
            </div>
{*
			<div id="comment-{$comment->getId()}" class="entry-comment-wrapper{if $lastTimeRead|default:false && $comment->getCreated() > $lastTimeRead} new{/if}">
                <p class="entry-info">
                    <img class="avatar" src="{$toolkit->getMapper('user', 'user')->getGuest()->getAvatarUrl(28)|h}" alt="ava" title="Аватар" />
                    <strong class="entry-author"><a href="{url route="withId" module="user" id=$toolkit->getMapper('user', 'user')->getGuest()->getId() action=""}">{$toolkit->getMapper('user', 'user')->getGuest()->getLogin()|h}</a></strong>
                    <abbr class="published" title="{"c"|date:$comment->getCreated()}">{$comment->getCreated()|date_i18n:'relative_hour'}</abbr>
                    <a href="{$commentsFolder->getDefaultBackUrl()|h}#comment{$comment->getId()}" name="comment{$comment->getId()}" title="Ссылка на комментарий" class="comment-link">#</a> {$comment->getJip()}
                    <span class="comment-vote">
                        {include file="comments/rating.tpl" comment=$comment}
                    </span>
                </p>
                <div class="entry-comment{if $comment->getRating() <= -5} entry-comment-hidden{/if}">{if $comment->getRating() <= -5}<span class="hidden-text"><a href="#" class="ajax">показать все, что скрыто</a></span>{/if}<span class="comment-text">{$comment->getText()|h|nl2br|bbcode}</span></div>
                <a class="answer" href="{url route="withId" module="comments" action="post" id=$commentsFolder->getId()}?replyTo={$comment->getId()}" onclick="comments.moveForm({$comment->getId()}, {$commentsFolder->getId()}, this); return false;">Ответить</a>
                {if $comment->canRun('edit')}<a class="edit-comment-link" href="{url route="withId" module="comments" action="edit" id=$comment->getId()}">Редактировать</a>{/if}
            </div>
*}