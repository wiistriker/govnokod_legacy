<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/modules/user/controllers/userMembersListController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userMembersListController.php 3088 2009-03-30 10:08:26Z zerkms $
 */

/**
 * userMembersListController: контроллер для метода membersList модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userMembersListController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id', SC_PATH | SC_POST);

        $groupMapper = $this->toolkit->getMapper('user', 'group');

        $group = $groupMapper->searchByKey($id);

        // проверяем что найдена нужная группа
        if (is_null($group)) {
            return $groupMapper->get404()->run();
        }

        $validator = new formValidator();

        if ($validator->validate()) {
            $users = $this->request->getArray('users', SC_POST);

            if (is_null($users)) {
                $users = array();
            }

            $users_exists = $group->getUsers();

            // формируем массив с выбранными пользователями
            foreach (array_keys($users) as $user_id) {
                $users_exists->delete($user_id);
            }

            $groupMapper->save($group);

            return jipTools::closeWindow(0, true);
        }

        $users = $group->getUsers();

        $this->smarty->assign('users', $users);
        $this->smarty->assign('group', $group);
        return $this->smarty->fetch('user/membersList.tpl');
    }
}

?>