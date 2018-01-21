        <li class="hcomment new">
            {include file="comments/listitem.tpl" commentsFolder=$commentsFolder comment=$comment lastTimeRead=1}
            <ul>
                <li id="answerForm_{$commentsFolder->getId()}_{$comment->getId()}">
                    {load module="comments" action="post" tplPrefix="ajax_" hideForm=true id=$commentsFolder onlyForm=true}
                </li>
            </ul>
        </li>