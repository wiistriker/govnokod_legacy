{form->hidden name="captcha_id" value=$captcha_id}
<img class="captcha" src="{url route="captcha" _rand=$captcha_id}" onclick="javascript: this.src = '{url route="captcha" _rand=$captcha_id}&amp;r=' + Math.random();" alt="Проверочный код" />
{form->text name="captcha" class="captcha" value="" useDefault=true}