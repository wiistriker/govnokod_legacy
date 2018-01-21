<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/user/controllers/userRegisterController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userRegisterController.php 324 2010-01-25 10:12:15Z wiistriker $
 */

/**
 * userRegisterController: контроллер для метода register модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userRegisterController extends simpleController
{
    protected function getView()
    {
        $userMapper = $this->toolkit->getMapper('user', 'user');
        
        if (DEBUG_MODE) {
            $user = $this->toolkit->getUser();
            $this->smarty->assign('user', $user);
            $body = $this->smarty->fetch('user/register/mailbody.tpl');
            $alt_body = $this->smarty->fetch('user/register/mailbody_text.tpl');

            fileLoader::load('service/mailer/mailer');
            $mailer = mailer::factory();

            $mailer->set('striker@bk.ru', 'test', 'noreply@govnokod.ru', 'Говнокод.ру', 'Подтверждение регистрации на сайте Говнокод.ру', $body, $alt_body);
            var_dump($mailer->send());
        }

        $validator = new formValidator();

        $validator->filter('trim', 'login');
        $validator->filter('trim', 'email');
        $validator->filter('trim', 'password');
        $validator->filter('trim', 'repassword');

        $validator->rule('required', 'login', 'Вы забыли указать логин');
        $validator->rule('regex', 'login', 'Логин может содержать только латинские буквы, цифры, дефис и знак подчеркивания', '/^[-_a-z0-9]+$/i');
        $validator->rule('length', 'login', 'Укажите логин, длиннее 2-х символов', array(3, null));
        $validator->rule('length', 'login', 'Укажите логин, короче 20-ти символов', array(null, 20));
        $validator->rule('callback', 'login', 'Пользователь с таким логином уже существует. Выберите другой', array(array($this, 'checkUniqueUserLogin'), $userMapper));
        $validator->rule('required', 'email', 'Без E-mail в наше время никуда, укажите его');
        $validator->rule('email', 'email', 'Укажите правильный адрес E-mail');
        $validator->rule('callback', 'email', 'Это прозвучит странно, но пользователь с таким E-mail уже существует. Укажите другой', array(array($this, 'checkUniqueUserEmail'), $userMapper));

        $validator->rule('required', 'password', 'Укажите пароль');
        $validator->rule('required', 'repassword', 'Подтвердите пароль');
        $validator->rule('callback', 'repassword', 'Повтор пароля не совпадает', array(array($this, 'checkRepass'), $this->request->getString('password', SC_POST)));

        $validator->rule('required', 'captcha', 'Укажите проверочный код');
        $validator->rule('captcha', 'captcha', 'Неправильно указан проверочный код. Попробуйте еще раз');

        if ($validator->validate()) {
            $login = $this->request->getString('login', SC_POST);
            $password = $this->request->getString('password', SC_POST);
            $email = $this->request->getString('email', SC_POST);

            $user = $userMapper->create();
            $user->setLogin($login);
            $user->setEmail($email);
            $user->setPassword($password);

            $confirm = md5($email . $login . microtime(true) . mt_rand(0, 1000));
            $user->setConfirmed($confirm);
            $userMapper->save($user);

            $this->smarty->assign('user', $user);
            $body = $this->smarty->fetch('user/register/mailbody.tpl');
            $alt_body = $this->smarty->fetch('user/register/mailbody_text.tpl');

            fileLoader::load('service/mailer/mailer');
            $mailer = mailer::factory();

            $mailer->set($user->getEmail(), $user->getLogin(), 'noreply@govnokod.ru', 'Говнокод.ру', 'Подтверждение регистрации на сайте Говнокод.ру', $body, $alt_body);
            $mailer->send();
            
            return $this->smarty->fetch('user/register/success.tpl');
        }

        $url = new url('default2');
        $url->setModule('user');
        $url->setAction('register');

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('validator', $validator);
        return $this->smarty->fetch('user/register/form.tpl');
    }

    function checkUniqueUserLogin($login, $userMapper)
    {
        $user = $userMapper->searchByLogin($login);
        return is_null($user);
    }

    function checkUniqueUserEmail($email, $userMapper)
    {
        $user = $userMapper->searchByEmail($email);
        return is_null($user);
    }

    function checkRepass($repassword, $password)
    {
        return $password === $repassword;
    }
}

?>