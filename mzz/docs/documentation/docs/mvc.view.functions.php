<p>Функция <code>{load}</code> предназначена для запуска модулей из шаблонов. Framy предоставляет возможность запускать в шаблонах любые действия модулей, также предоставляя средства для организации взаимодействия модулей.</p>
<p>Синтаксис:</p>
<<code smarty>>
{load module="" action="" <переменная>="значение" ...}
<</code>>

<p>Пример: запуск действия <code>list</code> модуля <code>news</code>:</p>
<<code smarty>>
{load module="news" action="list"}
<</code>>