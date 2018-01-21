<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/modules/menu/controllers/menuDeletemenuController.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: menuDeletemenuController.php 3388 2009-06-20 12:26:10Z striker $
 */

/**
 * menuDeletemenuController: контроллер для метода delete модуля menu
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuDeletemenuController extends simpleController
{
    protected function getView()
    {
        $menuMapper = $this->toolkit->getMapper('menu', 'menu');
        $id = $this->request->getInteger('id');

        $menu = $menuMapper->searchById($id);

        if ($menu) {
            $menuMapper->delete($menu);
        }

        return jipTools::redirect();
    }
}

?>