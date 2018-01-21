<?php

/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/template/plugins/modifier.crud_property.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage request
 * @version $Id: modifier.crud_property.php 3266 2009-05-31 09:47:44Z zerkms $
*/

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
function smarty_modifier_crud_property($name, $property)
{
    $modifier = '';
    if ($property['type'] == 'char') {
        $modifier = 'h';
    }

    return '{$' . $name . '->' . $property['accessor'] . '()' . ($modifier ? '|' . $modifier : '') . '}';
}

?>