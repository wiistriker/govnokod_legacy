<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/user/controllers/userOpenIDLoginController.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userOpenIDLoginController.php 315 2010-01-17 04:15:10Z wiistriker $
 */

//fileLoader::load('libs/simpleOpenID/class.openid');
fileLoader::load('user/controllers/userLoginController');

require_once 'Zend/OpenId/Consumer.php';
require_once 'Zend/OpenId/Extension/Sreg.php';
define('SID', true);

/**
 * userOpenIDLoginController
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userOpenIDLoginController extends userLoginController
{
    protected function getView()
    {
        $user = $this->toolkit->getUser();
        
        if ($user->isLoggedIn()) {
            $this->smarty->assign('user', $user);
            return $this->fetch('user/alreadyLogin.tpl');
        }

        $session = $this->toolkit->getSession();
        $isValidated = $session->get('openID_validated', false);
        $this->smarty->assign('isValidated', $isValidated);
        if (!$this->request->getBoolean('onlyForm') && $isValidated === true) {
            $userMapper = $this->toolkit->getMapper('user', 'user');
            //$timezones = $userMapper->getTimezones();

            $openIDUrl = $session->get('openID_url', false);

            $cancelValidator = new formValidator();
            $cancelValidator->submit('openid_reg_cancel');

            $validator = new formValidator();
            $validator->submit('openid_reg_submit');

            $validator->filter('trim', 'login');
            $validator->filter('trim', 'email');

            $validator->rule('required', 'login', 'Пожалуйста, укажите логин');
            $validator->rule('regex', 'login', 'Логин может содержать только латинские буквы, цифры, дефис и знак подчеркивания', '/^[-_a-z0-9]+$/i');
            $validator->rule('callback', 'login', 'Пользователь с таким логином уже существует. Пожалуйста, выберите другой', array(array($this, 'checkUniqueUserLogin'), $userMapper));
            $validator->rule('required', 'email', 'Пожалуйста, укажите E-mail');
            $validator->rule('email', 'email', 'Пожалуйста, укажите правильный адрес E-mail');
            $validator->rule('callback', 'email', 'Пользователь с таким email уже существует. Пожалуйста, укажите другой', array(array($this, 'checkUniqueUserEmail'), $userMapper));

            if ($cancelValidator->validate()) {
                $session->destroy('openID_url');
                $session->destroy('openID_validated');
                $session->destroy('openID_RegData');
                $session->destroy('openid_backurl');

                $url = new url('openIDLogin');

                $this->redirect($url->get());
                return;
            } else if ($validator->validate()) {
                $login = $this->request->getString('login', SC_POST);
                $email = $this->request->getString('email', SC_POST);

                $user = $userMapper->create();
                $user->setLogin($login);
                $user->setEmail($email);

                $generatedPassword = $userMapper->generatePassword(mt_rand(6, 10));
                $user->setPassword($generatedPassword);
                $userMapper->save($user);
                
                $groupMapper = $this->toolkit->getMapper('user', 'group');
                $groups = $groupMapper->searchDefaultGroups();
        
                $userGroups = $user->getGroups();
        
                foreach ($groups as $group) {
                    $userGroups->add($group);
                }
                
                $userMapper->save($user);

                $userOpenIDMapper = $this->toolkit->getMapper('user', 'userOpenID');
                $userOpenID = $userOpenIDMapper->create();
                $userOpenID->setUser($user);
                $userOpenID->setUrl($openIDUrl);
                $userOpenIDMapper->save($userOpenID);

                $this->toolkit->setUser($user);
                $this->rememberUser($user);

                $session->destroy('openID_url');
                $session->destroy('openID_validated');
                $session->destroy('openID_RegData');

                $back_url = $session->get('openid_backurl');
                if (!$back_url) {
                    $url = new url('default');
                    $back_url = $url->get();
                }
                $session->destroy('openid_backurl');
                $this->redirect($back_url);
                return;
            }

            $regData = $session->get('openID_RegData');
            $this->smarty->assign('regData', $regData);

            $url = new url('openIDLogin');

            $this->smarty->assign('openIDUrl', $openIDUrl);
            //$this->smarty->assign('timezones', $timezones);
            $this->smarty->assign('form_action', $url->get());
            $this->smarty->assign('validator', $validator);
            return $this->smarty->fetch('user/openIDRegForm.tpl');
        }

        $open_id_mode = $this->request->getString('openid_mode', SC_GET);

        switch ($open_id_mode) {
            case 'id_res':
                $consumer = $this->getConsumer();
                $sreg = $this->getConsumerSreg();

                if ($consumer->verify($_GET, $id, $sreg)) {
                    $userOpenIDMapper = $this->toolkit->getMapper('user', 'userOpenID');

                    $userOpenID = $userOpenIDMapper->searchByUrl($id);
                    if (!$userOpenID) {
                        $data = $sreg->getProperties();

                        $session->set('openID_validated', true);
                        $session->set('openID_url', $id);
                        $session->set('openID_RegData', $data);

                        $url = new url('openIDLogin');
                        $this->redirect($url->get());
                        return;
                    }

                    $user = $userOpenID->getUser();
                    $this->toolkit->setUser($user);
                    $this->rememberUser($user);

                    $session->destroy('openID_url');
                    $session->destroy('openID_validated');
                    $session->destroy('openID_RegData');

                    $back_url = $session->get('openid_backurl');
                    if (!$back_url) {
                        $url = new url('default');
                        $back_url = $url->get();
                    }
                    $session->destroy('openid_backurl');
                    $this->redirect($back_url);
                    return;
                } else {
                    $errors = array(
                        'username' => $consumer->getError()
                    );
                }
                break;

            case 'cancel':
                $errors = array('username' => 'Авторизация отменена');
                break;
        }

        $validator = new formValidator();
        $validator->submit('openid_submit');

        $validator->rule('required', 'openid_identifier', 'Введите OpenID идентификатор!');
        $validator->rule('url', 'openid_identifier', 'Введите корректный OpenID идентификатор!');
        
        if (isset($errors)) {
            foreach ($errors as $field => $error) {
                $validator->setError($field, $error);
            }
        }

        if (!$this->request->getBoolean('onlyForm') && $validator->validate()) {
            $openIDUrl = $this->request->getString('openid_identifier', SC_POST);

            $back_url = $this->request->getString('url', SC_POST);
            if (!$back_url) {
                $url = new url('default');
                $back_url = $url->get();
            }
            $session->set('openid_backurl', $back_url);

            $consumer = $this->getConsumer();
            $sreg = $this->getConsumerSreg();

            if (!$consumer->login($openIDUrl, null, $this->request->getUrl(), $sreg)) {
                $validator->setError('username', $consumer->getError());
            }
        }

        $url = new url('openIDLogin');

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('validator', $validator);
        return $this->fetch('user/openIDLoginForm.tpl');
    }

    protected function getSuccessUrl()
    {
        $url = new url('userLogin');
        return $url->get();
    }

    public function checkUniqueUserLogin($login, $userMapper)
    {
        $user = $userMapper->searchByLogin($login);
        return is_null($user);
    }

    public function checkUniqueUserEmail($email, $userMapper)
    {
        $user = $userMapper->searchByEmail($email);
        return is_null($user);
    }

    protected function getConsumer()
    {
        require_once "Zend/OpenId/Consumer/Storage/File.php";
        $storage = new Zend_OpenId_Consumer_Storage_File(systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . 'openid');

        $consumer = new Zend_OpenId_Consumer($storage, true);

        $client = new Zend_Http_Client(
            null,
            array(
                'maxredirects' => 4,
                'timeout'      => 15,
                'useragent'    => 'Zend_OpenId',
                'adapter'    => 'Zend_Http_Client_Adapter_Curl',
                'curloptions' => array(
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false
                )
            )
        );

        $consumer->setHttpClient($client);

        return $consumer;
    }

    protected function getConsumerSreg()
    {
        return new Zend_OpenId_Extension_Sreg(
            array(
                'email' => false,
                'nickname' => false
            ), null, 1.1);
    }

}
?>