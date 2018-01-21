<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/quoter/controllers/quoterSaveController.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: quoterSaveController.php 314 2010-01-17 03:36:52Z wiistriker $
 */

/**
 * quoterSaveController: контроллер для метода add модуля quoter
 *
 * @package modules
 * @subpackage quoter
 * @version 0.1
 */
class quoterSaveController extends simpleController
{
    protected function getView()
    {
        $user = $this->toolkit->getUser();

        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');

        $quoteMapper = $this->toolkit->getMapper('quoter', 'quote');
        $categoryMapper = $this->toolkit->getMapper('quoter', 'quoteCategory');
        if ($isEdit) {
            $id = $this->request->getInteger('id');
            $quote = $quoteMapper->searchById($id);

            if (!$quote) {
                return $this->forward404($quoteMapper);
            }
        } else {
            $quote = $quoteMapper->create();
        }

        $categories = $categoryMapper->searchAll();
        $categoriesSelect = array();
        foreach ($categories as $category) {
            $categoriesSelect[$category->getId()] = $category->getTitle();
        }

        $previewValidator = new formValidator();
        $previewValidator->submit('preview');
        $isPreview = $previewValidator->validate();

        $validator = new formValidator();
        
        $validator->filter('trim', 'text');
        
        $user_created = $user->getCreated();
        if (!$user_created) {
            //$user_created = strtotime();
        }
        
        /*
        if (time() - $user_created < strtotime('+5 days', 0)) {
            $validator->setError('category_id', 'Вы еще слишком молоды. Пожалуйста, подождите немного, прежде чем Вам будет разрешено оставлять свои записи. Если Вы не согласны с текущим раскладом, то обратитесь к нам и, возможно, мы сможем чем-то помочь');
        }
        */
        
        $validator->rule('required', 'category_id', 'Укажите язык');
        $validator->rule('in', 'category_id', 'Укажите правильный язык', array_keys($categoriesSelect));
        $validator->rule('required', 'text', 'Укажите код');
        $validator->rule('callback', 'text', 'Такой длинный код врядли может быть смешным. Пожалуйста, ограничьтесь сотней строк и 6000 символами.', array('checkCodeLength'));
        $validator->rule('callback', 'description', 'Описание может быть не более ' . quote::MAX_DESC_CHARS . ' символов', array('checkDescLength'));

        if (!$isEdit) {
            //$validator->add('required', 'license', 'Примите лицензию!');
            if (!$isPreview) {
                $validator->rule('required', 'captcha', 'Произвол не пройдёт! Укажите проверочный код!');
                $validator->rule('captcha', 'captcha', 'Неверно введен проверочный код!');
            }
        }

        if ($validator->validate()) {
            $categoryId = $this->request->getInteger('category_id', SC_POST);
            $description = mzz_trim($this->request->getString('description', SC_POST));
            $text = mzz_trim($this->request->getString('text', SC_POST));

            if (!$isPreview) {
                $quote->setCategory($categoryId);
                $quote->setDescription($description);
                $quote->setText($text);

                if ($isEdit) {
                    $cache = cache::factory('memcache');
                    $cache->delete($quote->getCacheKey());
                } else {
                    $quote->setUser($user);
                }

                $quoteMapper->save($quote);

                if ($this->request->isJip()) {
                    return jipTools::redirect();
                } else {
                    $url = new url('quoteView');
                    $url->add('id', $quote->getId());

                    $this->redirect($url->get());
                    return;
                }
            } else {
                $quote->merge(array(
                    'category_id' => $categories[$categoryId],
                    'description' => $description,
                    'text' => $text,
                    'user_id' => $user,
                ));
            }
        } else {
            $isPreview = false;
        }

        if ($isEdit) {
            $url = new url('withId');
            $url->setAction("edit");
            $url->add('id', $id);
        } else {
            $url = new url('quoteAdd');
        }

        $this->smarty->assign('categoriesSelect', $categoriesSelect);
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('quote', $quote);
        $this->smarty->assign('user', $user);
        $this->smarty->assign('isPreview', $isPreview);
        $this->smarty->assign('formAction', $url->get());
        $this->smarty->assign('validator', $validator);

        if ($isEdit && $this->request->isJip()) {
            $this->setTemplatePrefix('ajax_');
        }

        return $this->fetch('quoter/save.tpl');
    }
}

function checkCodeLength($text) {
    if (mzz_strlen($text) > 6000) {
        return false;
    }

    $linesCount = mzz_substr_count($text, "\n");
    return ($linesCount < 100);
}

function checkDescLength($desc) {
    return (mzz_strlen($desc) < quote::MAX_DESC_CHARS);
}

?>