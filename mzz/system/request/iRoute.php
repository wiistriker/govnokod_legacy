<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/request/iRoute.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage request
 * @version $Id: iRoute.php 3845 2009-10-16 10:45:53Z mz $
*/

/**
 * iRoute: интерфейс правила для маршрутизатора.
 * При совпадении PATH с шаблоном правила производит его декомпозицию.
 *
 * @package system
 * @subpackage request
 * @version 0.1
 */
interface iRoute
{
    /**
     * Проверка совпадения PATH с шаблоном.
     *
     * @param string $path полученный path из URL
     * @return array|false
     */
    public function match($path);

    /**
     * Установка имени роута. Устанавливается только один раз
     *
     * @param string $name
     */
    public function setName($name);

    public function prepend(iRoute $route);

    public function setPartial($partial);

    public function isPartial();
}

?>