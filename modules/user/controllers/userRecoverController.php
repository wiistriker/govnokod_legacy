<?php
/**
 * $URL: http://dev.vladnet.ru/svn/wiweb/t2home/trunk/modules/user/controllers/userRecoverController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userRecoverController.php 8561 2010-01-11 04:10:59Z striker $
 */

/**
 * userRecoverController: контроллер восстановления пароля юзера
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userRecoverController extends simpleController
{
    protected function getView()
    {
        $currentUser = $this->toolkit->getUser();

        if ($currentUser->isLoggedIn()) {
            $url = new url('default');
            $this->redirect($url->get());
            return;
        }

        $code = $this->request->getString('code', SC_GET);
        if (!is_null($code) && strlen($code) == 32) {
            $userMapper = $this->toolkit->getMapper('user', 'user');
            $user = $userMapper->searchByRecoverCode($code);
            if (!$user) {
                $url = new url('default');
                $this->redirect($url->get());
                return;
            }

            $validator = new formValidator();
            $validator->submit('change_pass');

            $validator->filter('trim', 'newpassword');
            $validator->filter('trim', 'repassword');

            $validator->rule('required', 'newpassword', 'Укажите новый пароль');
            $validator->rule('required', 'repassword', 'Подтвердите новый пароль');
            $validator->rule('callback', 'repassword', 'Повтор пароля не совпадает', array(array($this, 'checkRepass'), $this->request->getString('newpassword', SC_POST)));

            if ($validator->validate()) {
                $password = $this->request->getString('newpassword', SC_POST);
                $user->setPassword($password);
                $user->setRecoverCode('');
                $user->setRecoverTime(0);
                $userMapper->save($user);

                return $this->smarty->fetch('user/recover/success.tpl');
            }

            $url = new url('user-recover-pass');
            $url->add('code', $code, true);

            $this->smarty->assign('user', $user);
            $this->smarty->assign('form_action', $url->get());
            $this->smarty->assign('validator', $validator);
            return $this->smarty->fetch('user/recover/changePassword.tpl');
        }

        $validator = new formValidator();
        $validator->submit('recover');

        $validator->filter('trim', 'loginemail');

        $validator->rule('required', 'loginemail', 'Укажите логин или E-mail вашей учетной записи');
        $validator->rule('required', 'captcha', 'Укажите цифры, которые вы видите на изображении');
        $validator->rule('captcha', 'captcha', 'Неправильно указаны цифры. Попробуйте еще раз.');

        if ($validator->validate()) {
            $login_email = $this->request->getString('loginemail', SC_POST);

            $userMapper = $this->toolkit->getMapper('user', 'user');

            $user = $userMapper->searchByLoginOrEmail($login_email);
            if ($user && $user->isConfirmed() && $user->isLoggedIn()) {
                $recover_code = md5($user->getLogin() . $user->getEmail() . mt_rand(0, 1000) . microtime(true));
                $user->setRecoverCode($recover_code);
                $user->setRecoverTime(time());
                $userMapper->save($user);

                $this->smarty->assign('user', $user);
                $body = $this->smarty->fetch('user/recover/mailbody.tpl');
                $alt_body = $this->smarty->fetch('user/recover/mailbody_text.tpl');

                fileLoader::load('service/mailer/mailer');
                $mailer = mailer::factory();

                $mailer->set($user->getEmail(), $user->getLogin(), 'noreply@govnokod.ru', 'Говнокод.ру', 'Восстановление забытого пароля на сайте Говнокод.ру', $body, $alt_body);
                $mailer->send();
            }

            return $this->smarty->fetch('user/recover/sended.tpl');
        }

        $url = new url('user-recover-pass');

        $this->smarty->assign('validator', $validator);
        $this->smarty->assign('form_action', $url->get());
        return $this->smarty->fetch('user/recover/form.tpl');
    }

    function checkRepass($repassword, $password)
    {
        return $password === $repassword;
    }
}

?>