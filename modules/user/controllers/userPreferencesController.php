<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/user/controllers/userPreferencesController.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userPreferencesController.php 334 2010-04-20 06:10:16Z wiistriker $
 */

/**
 * userPreferencesController
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userPreferencesController extends simpleController
{
    protected function getView()
    {
        $user = $this->toolkit->getUser();

        $type = $this->request->getString('name');

        switch ($type) {
            case 'personal':
                $validator = new formValidator();

                $validator->rule('required', 'avatar', 'Укажите способ отображения юзерпика!');
                $validator->rule('in', 'avatar', 'Выберите способ отображения юзерпика из списка!', array(1, 2));

                if ($validator->validate()) {
                    $avatar = $this->request->getInteger('avatar', SC_POST);
                    $user->setAvatarType($avatar);

                    $is_mail_send_item = $this->request->getInteger('send_mail_on_item', SC_POST);
                    if ($is_mail_send_item) {
                        $user->setIsMailSendItem((bool)($is_mail_send_item - 1));
                    }
                    
                    $is_mail_send_reply = $this->request->getInteger('send_mail_on_reply', SC_POST);
                    if ($is_mail_send_reply) {
                        $user->setIsMailSendReply((bool)($is_mail_send_reply - 1));
                    }
                    
                    $userMapper = $this->toolkit->getMapper('user', 'user');
                    $userMapper->save($user);

                    $url = new url('default2');
                    $url->setModule('user');
                    $url->setAction('preferences');
                    $url->add('saved', 1, true);

                    $this->redirect($url->get());
                    return;
                }

                $url = new url('withAnyParam');
                $url->setModule('user');
                $url->setAction('preferences');
                $url->add('name', $type);

                $this->smarty->assign('form_action', $url->get());
                $this->smarty->assign('validator', $validator);

                $this->setTemplatePrefix('personal_');
                break;

            case 'global':
                $userMapper = $this->toolkit->getMapper('user', 'user');
                $categoryMapper = $this->toolkit->getMapper('quoter', 'quoteCategory');

                $drivers = $userMapper->getHighlighDrivers();
                $categories = $categoryMapper->searchAll();

                $validator = new formValidator();
                $validator->rule('required', 'hdriver', 'Укажите способ подсветки кода');
                $validator->rule('in', 'hdriver', 'Укажите способ подсветки кода из списка', array_keys($drivers));
                //$validator->rule('required', 'avatar', 'Укажите способ отображения юзерпика!');
                //$validator->rule('in', 'avatar', 'Выберите способ отображения юзерпика из списка!', array(1, 2));
                $validator->rule('required', 'lang', 'Должен быть выбран хотя бы один язык!');

                $timezones = $userMapper->getTimezones();
                $validator->rule('required', 'timezone', 'Укажите часовой пояс!');
                $validator->rule('in', 'timezone', 'Укажите часовой пояс из списка!', array_keys($timezones));

                if ($validator->validate()) {
                    $driver = $this->request->getString('hdriver', SC_POST);
                    $langs = $this->request->getArray('lang', SC_POST);
                    $timezone = $this->request->getNumeric('timezone', SC_POST);

                    if (sizeof($langs) == sizeof($categories)) {
                        $user->setPreferredLangs(false);
                    } else {
                        $preferredLangs = array();
                        foreach ($langs as $lang => $val) {
                            if (isset($categories[$lang])) {
                                $preferredLangs[] = $lang;
                            }
                        }

                        $user->setPreferredLangs($preferredLangs);
                    }

                    //$user->setAvatarType($avatar);
                    $user->setHighlightDriver($driver);
                    $user->setTimezone($timezone);
                    $userMapper->save($user);

                    $url = new url('default2');
                    $url->setModule('user');
                    $url->setAction('preferences');
                    $url->add('saved', 1, true);

                    $this->redirect($url->get());
                    return;
                }

                $url = new url('withAnyParam');
                $url->setModule('user');
                $url->setAction('preferences');
                $url->add('name', $type);

                $this->smarty->assign('form_action', $url->get());
                $this->smarty->assign('validator', $validator);

                $this->smarty->assign('drivers', $drivers);
                $this->smarty->assign('categories', $categories);
                $this->smarty->assign('timezones', $timezones);
                $this->setTemplatePrefix('global_');
                break;

            default:
                $is_saved = $this->request->getBoolean('saved', SC_GET);

                $this->smarty->assign('is_saved', $is_saved);

                $type = 'main';
                $this->setTemplatePrefix('main_');
                break;
        }

        $this->smarty->assign('user', $user);
        $this->smarty->assign('type', $type);
        return $this->fetch('user/preferences.tpl');
    }
}

?>