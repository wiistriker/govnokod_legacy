<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/menu/controllers/menuViewController.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: menuViewController.php 4031 2009-12-10 03:34:19Z striker $
 */

/**
 * menuViewController: контроллер для метода view модуля menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuViewController extends simpleController
{
    protected function getView()
    {
        $menuMapper = $this->toolkit->getMapper('menu', 'menu');

        $name = $this->request->getString('name');

        /*
        $menu = $menuMapper->searchByName($name);
        if (empty($menu)) {
            return $this->forward404($menuMapper);
        }
        */

        $menuItemMapper = $this->toolkit->getMapper('menu', 'menuItem');
        $items = $menuItemMapper->searchAllByMenuName($name);

        $this->smarty->assign('items', $items);
        //$this->smarty->assign('menu', $menu);
        return $this->fetch('menu/view.tpl');
    }
}
?>