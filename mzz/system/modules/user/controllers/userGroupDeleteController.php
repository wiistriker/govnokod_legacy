<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/modules/user/controllers/userGroupDeleteController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userGroupDeleteController.php 2481 2008-04-26 13:25:46Z striker $
 */

/**
 * userGroupDeleteController: контроллер для метода groupDelete модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userGroupDeleteController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');

        $groupMapper = $this->toolkit->getMapper('user', 'group');
        $group = $groupMapper->searchByKey($id);

        if (!$group) {
            return $groupMapper->get404()->run();
        }

        // удаляем группу
        $groupMapper->delete($group);
        return jipTools::redirect();
    }
}

?>