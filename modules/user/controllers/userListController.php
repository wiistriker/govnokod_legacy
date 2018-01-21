<?php
/**
 * $URL: http://dev.vladnet.ru/svn/wiweb/t2home/trunk/modules/user/controllers/userListController.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userListController.php 8490 2009-12-22 05:11:28Z striker $
 */

/**
 * userListController
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class userListController extends simpleController
{
    protected function getView()
    {
        return;
        $userMapper = $this->toolkit->getMapper('user', 'user');

        //количество записей на страницу
        $onpage = 10;

        $pager = $this->setPager($userMapper, $onpage);
        $users = $userMapper->searchAllActiveUsers();

        $this->smarty->assign('users', $users);
        $this->smarty->assign('onpage', $onpage);
        return $this->smarty->fetch('user/list.tpl');
    }
}
?>