<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 2200 2007-12-06 06:52:05Z zerkms $
 */

/**
 * userSendregmailController
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class userSendregmailController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');
        $userMapper = $this->toolkit->getMapper('user', 'user');

        $user = $userMapper->searchByKey($id);
        if (!$user || $user->isConfirmed()) {
            return $this->forward404($userMapper);
        }

        $this->smarty->assign('user', $user);
        $body = $this->smarty->fetch('user/register/mailbody.tpl');
        $alt_body = $this->smarty->fetch('user/register/mailbody_text.tpl');

        fileLoader::load('service/mailer/mailer');
        $mailer = mailer::factory();

        $mailer->set($user->getEmail(), $user->getLogin(), 'noreply@govnokod.ru', 'Говнокод.ру', 'Подтверждение регистрации на сайте Говнокод.ру', $body, $alt_body);
        $result = $mailer->send();

        $this->smarty->assign('result', $result);
        return $this->smarty->fetch('user/sendregmail.tpl');
    }
}
?>