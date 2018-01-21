<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/session/iSessionStorage.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage session
 * @version $Id: iSessionStorage.php 2182 2007-11-30 04:41:35Z zerkms $
*/

/**
 * iSessionStorage: интрефейс хранилища сессии
 *
 * @package system
 * @subpackage session
 * @version 0.1
*/
interface iSessionStorage
{
    /**
     * Открытие хранилища сессий
     *
     * @return bool
     */
    function storageOpen();

    /**
     * Закрытие хранилища сессий
     *
     * @return bool
     */
    function storageClose();

    /**
     * Чтение сессии из хранилища
     *
     * @param string $sid Идентификатор сессии
     * @return string
     */
    function storageRead($sid);

    /**
     * Запись значения сессии в хранилище
     *
     * @param string $sid   Идентификатор сессии
     * @param string $value Значение сессии
     * @return string
     */
    function storageWrite($sid, $value);

    /**
     * Уничтожение сессии из хранилища
     *
     * @param string $sid Идентификатор сессии
     * @return string
     */
    function storageDestroy($sid);

    /**
     * Установка продолжительности жизни сессии
     *
     * @param string $maxLifeTime Время жизни сессии в секундах
     * @return string
     */
    function storageGc($maxLifeTime);
}


?>