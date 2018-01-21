<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/user/controllers/userOnlineController.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userOnlineController.php 3857 2009-10-19 04:12:06Z zerkms $
 */

/**
 * userOnlineController: контроллер для метода online модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class userOnlineController extends simpleController
{
    protected function getView()
    {
        $userOnlineMapper = $this->toolkit->getMapper('user', 'userOnline');
        $criteria = new criteria();
        $criteria->orderByDesc('last_activity');
        $users = $userOnlineMapper->searchAll($criteria);

        $guests = 0;
        $total = 0;
        foreach ($users as $key => $user) {
            if (!$user->getUser()->isLoggedIn()) {
                $guests++;
                unset($users[$key]);
                continue;
            }

            $total++;
        }

        $this->smarty->assign('total', $total);
        $this->smarty->assign('guests', $guests);
        $this->smarty->assign('users', $users);

        return $this->smarty->fetch('user/online.tpl');
    }
}

?>