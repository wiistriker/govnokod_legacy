    {if !$validator->isValid()}
    <dl class="errors">
        <dt>Ошибка компиляции комментария:</dt>
        <dd>
            <ol>
            {foreach from=$validator->getErrors() item="error"}
                <li>{$error}</li>
            {/foreach}
            </ol>
        </dd>
    </dl>
    {/if}
    <dl>
        <dt><img class="avatar" src="{$user->getAvatarUrl(28)|h}" alt="ava" title="Аватар" /> {$formTitle}</dt>
        <dd>
            {form->textarea name="text" value=$comment->getText() rows="5" cols="5" useDefault=$onlyForm}
            <div class="field-info">
                А не использовать ли нам <a href="{url route="pageActions" name="bbcode"}" onclick="comments.toggleBBCodeBlock(this); return false;">bbcode</a>?
                <div class="bbcodes">
                    <ul style="margin-left: 0;">
                        <li>[b]жирный[/b] — <b>жирный</b></li>
                        <li>[i]курсив[/i] — <i>курсив</i></li>
                        <li>[u]подчеркнутый[/u] — <span style="text-decoration:underline;">подчеркнутый</span></li>
                        <li>[s]перечеркнутый[/s] — <span style="text-decoration:line-through;">перечеркнутый</span></li>
                        <li>[blink]мигающий[/blink] — <span style="text-decoration:blink;">мигающий</span></li>
                        <li>[color=red]цвет[/color] — <span style="color:red;">цвет</span> (<a href="{url route="pageActions" name="bbcode"}#color">подробнее</a>)</li>
                        <li>[size=20]размер[/size] — <span style="font-size:20px">размер</span> (<a href="{url route="pageActions" name="bbcode"}#size">подробнее</a>)</li>
                        <li>[code=&lt;language&gt;]some code[/code] (<a href="{url route="pageActions" name="bbcode"}#code">подробнее</a>)</li>
                    </ul>
                </div>
            </div>
        </dd>
    {if $use_captcha}
        <dt>{form->caption name="captcha" value="Проверочный код:" onError=""}</dt>
        <dd>{form->captcha name="captcha"}</dd>
    {/if}
    </dl>

    <p>
        {form->submit class="send" name="commentSubmit" value="Отправить комментарий [Ctrl+Enter]"}
    </p>