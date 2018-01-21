<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/template/plugins/modifier.i18n.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage template
 * @version $Id: modifier.i18n.php 2454 2008-04-02 09:56:32Z zerkms $
*/

/**
 * smarty_modifier_i18n: модификатор для вызова i18n

 * @param string $params строка для перевода
 * @param string $module имя модуля
 * @return string переведённая строка
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_modifier_i18n($name, $module = 'simple')
{
    return i18n::getMessage($name, $module);
}

?>