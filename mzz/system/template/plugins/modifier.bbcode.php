<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/template/plugins/modifier.bbcode.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: modifier.bbcode.php 2422 2008-03-12 11:27:16Z striker $
 */

fileLoader::load('service/bbcode');

/**
 * smarty_modifier_bbcode: смарти плагин для преобразования bbcode
 *
 * Примеры использования:<br />
 * <code>
 * {$text|bbcode}
 * </code>
 *
 * @param string $string исходная строка
 * @return string
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_modifier_bbcode($string)
{
    $bbcode_parser = new bbcode($string);
    return $bbcode_parser->parse();
}
?>