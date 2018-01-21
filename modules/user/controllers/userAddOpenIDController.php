<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/user/controllers/userAddOpenIDController.php $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userAddOpenIDController.php 335 2010-04-20 06:51:49Z wiistriker $
 */

require_once 'Zend/OpenId/Consumer.php';
require_once 'Zend/OpenId/Extension/Sreg.php';
if (!defined('SID')) {
    define('SID', true);
}

/**
 * userAddOpenIDController
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class userAddOpenIDController extends simpleController
{
    protected function getView()
    {
        $user = $this->toolkit->getUser();

        if (!$user->isLoggedIn()) {
            $this->redirect('/');
            return;
        }

        $open_id_mode = $this->request->getString('openid_mode', SC_GET);

        switch ($open_id_mode) {
            case 'id_res':
                $consumer = $this->getConsumer();

                if ($consumer->verify($_GET, $id)) {
                    $userOpenIDMapper = $this->toolkit->getMapper('user', 'userOpenID');

                    $userOpenID = $userOpenIDMapper->searchByUrl($id);
                    if (!$userOpenID) {
                        $userOpenID = $userOpenIDMapper->create();
                        $userOpenID->setUser($user);
                        $userOpenID->setUrl($id);
                        $userOpenIDMapper->save($userOpenID);
                    }

                    $url = new url('withAnyParam');
                    $url->setModule('user');
                    $url->setAction('preferences');
                    $url->add('name', 'personal');

                    $this->redirect($url->get());
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

        if ($validator->validate()) {
            $openIDUrl = $this->request->getString('openid_identifier', SC_POST);

            $consumer = $this->getConsumer();

            if (!$consumer->login($openIDUrl, null, $this->request->getUrl())) {
                $validator->setError('username', $consumer->getError());
            }
        }

        $url = new url('default2');
        $url->setModule('user');
        $url->setAction('addOpenID');

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('validator', $validator);
        return $this->smarty->fetch('user/addOpenID.tpl');
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
}
?>