<?php
/**
 * $URL: http://dev.vladnet.ru/svn/wiweb/t2home/trunk/modules/user/controllers/userActivateController.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userActivateController.php 8524 2009-12-24 06:46:00Z striker $
 */

/**
 * userActivateController
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class userActivateController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');
        $userMapper = $this->toolkit->getMapper('user', 'user');

        $user = $userMapper->searchByKey($id);
        if (!$user || $user->isConfirmed()) {
            return $this->forward404($userMapper);
        }

        $user->activate();

        $groupMapper = $this->toolkit->getMapper('user', 'group');
        $groups = $groupMapper->searchDefaultGroups();

        $userGroups = $user->getGroups();

        foreach ($groups as $group) {
            $userGroups->add($group);
        }

        $userMapper->save($user);

        return jipTools::redirect();
    }
}
?>