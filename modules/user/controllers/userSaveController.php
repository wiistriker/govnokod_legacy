<?php
/**
 * $URL: http://dev.vladnet.ru/svn/wiweb/t2home/trunk/modules/user/controllers/userSaveController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userSaveController.php 8524 2009-12-24 06:46:00Z striker $
 */

/**
 * userEditController: контроллер для метода edit модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.2
 */
class userSaveController extends simpleController
{
    protected function getView()
    {
        $userMapper = $this->toolkit->getMapper('user', 'user');
        $id = $this->request->getInteger('id');

        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');

        if ($isEdit) {
            $editedUser = $userMapper->searchByKey($id);

            if (!$editedUser) {
                return $this->forward404($userMapper);
            }
        } else {
            $editedUser = $userMapper->create();
        }

        $validator = new formValidator();

        $validator->filter('trim', 'login');
        $validator->filter('trim', 'email');
        $validator->filter('trim', 'password');

        $validator->rule('required', 'user[login]', 'Укажите логин');
        $validator->rule('required', 'user[email]', 'Укажите email');
        $validator->rule('email', 'user[email]', 'Укажите правильный email');
        if (!$isEdit) {
            $validator->rule('required', 'user[password]', 'Укажите пароль');
        }

        $validator->rule('callback', 'user[login]', 'Пользователь с таким логином уже существует', array(
            array(
                $this,
                'checkUniqueUserLogin'),
            $editedUser,
            $userMapper));

        $validator->rule('callback', 'user[email]', 'Пользователь с таким email уже существует', array(
            array(
                $this,
                'checkUniqueUserEmail'),
            $editedUser,
            $userMapper));

        if ($validator->validate()) {
            $info = $this->request->getArray('user', SC_POST);

            $editedUser->setLogin((string)$info['login']);
            $editedUser->setEmail((string)$info['email']);
            if (!empty($info['password'])) {
                $editedUser->setPassword((string)$info['password']);
            }
            $userMapper->save($editedUser);

            if (!$isEdit) {
                // добавим созданного пользователя в группы с флагом 'is_default'
                $groupMapper = $this->toolkit->getMapper('user', 'group');
                $groups = $groupMapper->searchDefaultGroups();

                $userGroups = $editedUser->getGroups();

                foreach ($groups as $group) {
                    $userGroups->add($group);
                }

                $userMapper->save($editedUser);
            }

            return jipTools::redirect();
        }

        if ($isEdit) {
            $url = new url('withId');
            $url->add('id', $editedUser->getId());
        } else {
            $url = new url('default2');
        }
        $url->setAction($action);

        $editedUser = ($isEdit) ? $editedUser : $userMapper->create();
        $this->smarty->assign('user', $editedUser);
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('validator', $validator);
        return $this->smarty->fetch('user/save.tpl');
    }

    function checkUniqueUserLogin($login, $user, $userMapper)
    {
        if ($login === $user->getLogin()) {
            return true;

        }
        $user = $userMapper->searchByLogin($login);
        return is_null($user);
    }

    function checkUniqueUserEmail($email, $user, $userMapper)
    {
        if ($email === $user->getEmail()) {
            return true;

        }
        $user = $userMapper->searchByEmail($email);
        return is_null($user);
    }
}

?>