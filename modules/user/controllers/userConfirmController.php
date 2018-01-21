<?php
/**
 * $URL: http://dev.vladnet.ru/svn/wiweb/t2home/trunk/modules/user/controllers/userConfirmController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userConfirmController.php 8554 2010-01-06 02:17:42Z striker $
 */

/**
 * userConfirmController: контроллер для метода confirm модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userConfirmController extends simpleController
{
    protected function getView()
    {
        $userMapper = $this->toolkit->getMapper('user', 'user');

        $code = $this->request->getString('code', SC_GET);
        if (!is_null($code) && strlen($code) == 32) {
            $userForConfirm = $userMapper->searchByConfirmCode($code);

            if ($userForConfirm) {
                $userForConfirm->activate();
                
                $groupMapper = $this->toolkit->getMapper('user', 'group');
                $groups = $groupMapper->searchDefaultGroups();
        
                $userGroups = $userForConfirm->getGroups();
        
                foreach ($groups as $group) {
                    $userGroups->add($group);
                }
        
                $userMapper->save($userForConfirm);

                return $this->smarty->fetch('user/register/confirmed.tpl');
            } else {
                return $this->smarty->fetch('user/register/confirmNoNeed.tpl');
            }
        }

        $url = new url('default');
        $this->redirect($url->get());
        return;
    }
}

?>