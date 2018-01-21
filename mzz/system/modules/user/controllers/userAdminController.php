<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/modules/user/controllers/userAdminController.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userAdminController.php 3082 2009-03-27 00:21:20Z mz $
 */

/**
 * userAdminController: контроллер для метода admin модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class userAdminController extends simpleController
{
    protected function getView()
    {
        $userFolderMapper = $this->toolkit->getMapper('user', 'userFolder');
        $groupFolderMapper = $this->toolkit->getMapper('user', 'groupFolder');

        $userFolder = $userFolderMapper->getFolder();
        $groupFolder = $groupFolderMapper->getFolder();

        $userMapper = $this->toolkit->getMapper('user', 'user');
        $this->setPager($userMapper);

        $this->smarty->assign('userFolder', $userFolder);
        $this->smarty->assign('groupFolder', $groupFolder);
        $this->smarty->assign('section_name', $this->request->getString('section_name'));
        $this->smarty->assign('users', $userMapper->searchAll());
        return $this->smarty->fetch('user/admin.tpl');
    }
}

?>