<p>Работа с пакетом начинается с процесса его конфигурирования. В конфигурационном файле приложения вы можете определить новые конфигурации для <code>cache</code>, которые будут определять тип хранилища, время жизни данных и специфические для хранилищ свойства (путь хранения, префикс, итд).</p>
<p>Существует набор конфигураций по умолчанию:</p>

<table class="beauty">
    <tr>
        <th>Название</th>
        <th>Хранилище</th>
        <th>Опции</th>
        <th>Описание</th>
    </tr>
    
        <tr>
            <td>fast</td>
            <td>file</td>
            <td>
<<code php>>
'params' => array(
    'path' => systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . 'cache',
    'prefix' => 'fast_',
    'expire' => 180)
<</code>>
            </td>
            <td>
                Предназначен для хранения часто изменяющихся данных, которые по истечении очень короткого срока времени (180 секунд по умолчанию) должны будут устареть и заменены на свежие данные. Данные хранятся в поддиректории <code>cache</code>, временной директории проекта.
            </td>
        </tr>

        <tr>
            <td>session</td>
            <td>session</td>
            <td>
<<code php>>
'params' => array('expire' => 1800)
<</code>>
            </td>
            <td>
                Предназначен для хранения данных, имеющих свою актуальность только в пределах пользовательской сессии. Стоит помнить, что данные, в этом случае, будут независимы для каждой из сессий и из одной сессии нельзя будет получить данные другой.
            </td>
        </tr>

        <tr>
            <td>long</td>
            <td>file</td>
            <td>
<<code php>>
'params' => array(
    'path' => systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . 'cache',
    'prefix' => 'long_',
    'expire' => 86400)
<</code>>
            </td>
            <td>
                Конфигурация аналогичная конфигурации <code>fast</code>, но предназначены наоборот - для хранения редко изменяющихся данных. Время хранения по умолчанию - сутки.
            </td>
        </tr>

        <tr>
            <td>memory</td>
            <td>memory</td>
            <td></td>
            <td>
                Предназначен для хранения данных, имеющих свою актуальность только в пределах вызова скрипта. Данные хранятся в оперативной памяти и уничтожаются после завершения выполнения скрипта.
            </td>
        </tr>

        <tr>
            <td>default</td>
            <td></td>
            <td></td>
            <td>
                Конфигурация, которая будет использована в случае, если при получении объекта кэша не была указана любая из существующих конфигураций. По умолчанию является синонимом на конфигурацию <code>fast</code>.
            </td>
        </tr>
    
</table>

<p>В дополнение к этим конфигурациям вы можете добавить в своём приложении свои. Для этого в массив <code>systemConfig::$cache</code> просто необходимо добавить описание новой конфигурации. Ключ массива с конфигурацией - будет служить её именем.</p>
<p>Например, для добавления конфигурации кэша с именем <code>myMemcacheConfig</code>, которая бы хранила данные в memcache-хранилище нужно добавить следующие строки:</p>

<<code php>>
systemConfig::$cache['myMemcacheConfig'] = array(
    'backend' => 'memcache'
);
<</code>>

<p>Если вам нужно изменить параметры стандартных конфигураций, то просто переопределите соответствующие ключи массива systemConfig::$cache.</p>

<p>Например, чтобы кэш <code>fast</code> начал работать с memcache вместо файлов, в конфигурационном файле нужно прописать:</p>

<<code php>>
systemConfig::$cache['fast'] = array(
    'backend' => 'memcache'
);
<</code>>