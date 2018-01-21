<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/menu/helpers/simpleMenuItemHelper.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: simpleMenuItemHelper.php 3876 2009-10-22 02:40:05Z striker $
 */

fileLoader::load('menu/helpers/iMenuItemHelper');

/**
 * simpleMenuItemHelper: хелпер для simple меню
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */
class simpleMenuItemHelper implements iMenuItemHelper
{
    public function setArguments($item, array $args)
    {
        $item->setArguments(array());
        $item->setArgument('url', $args['url']);
        return $item;
    }

    public function injectItem($validator, $item = null, $smarty = null, array $args = null)
    {
        //$validator->rule('required', 'url', 'Укажите URL');
    }
}

?>