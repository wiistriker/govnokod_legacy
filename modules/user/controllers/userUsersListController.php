<?php
/**
 * $URL: http://dev.vladnet.ru/svn/wiweb/t2home/trunk/modules/user/controllers/userUsersListController.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userUsersListController.php 8479 2009-12-21 07:01:31Z striker $
 */

/**
 * userUsersListController
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class userUsersListController extends simpleController
{
    protected function getView()
    {
        $userFolderMapper = $this->toolkit->getMapper('user', 'userFolder');
        $userMapper = $this->toolkit->getMapper('user', 'user');
        $pager = $this->setPager($userMapper, 20);

        switch ($this->getAction()->getName()) {
            case 'usersList':
                $template = 'usersList.tpl';
                $users = $userMapper->searchAll();
                break;

            case 'unconfirmedUsersList':
                $template = 'unconfirmedUsersList.tpl';
                $users = $userMapper->searchAllNotConfirmed();
                break;
        }

        $userFolder = $userFolderMapper->getFolder();

        $this->smarty->assign('users', $users);
        $this->smarty->assign('userFolder', $userFolder);
        return $this->smarty->fetch('user/' . $template);
    }
}
?>