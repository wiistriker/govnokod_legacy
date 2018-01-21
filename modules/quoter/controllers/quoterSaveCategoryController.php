<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/quoter/controllers/quoterSaveCategoryController.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: quoterSaveCategoryController.php 309 2010-01-16 08:39:19Z wiistriker $
 */

/**
 * quoterSaveCategoryController: контроллер для метода addCategory модуля quoter
 *
 * @package modules
 * @subpackage quoter
 * @version 0.1
 */
class quoterSaveCategoryController extends simpleController
{
    protected function getView()
    {
        $action = $this->request->getAction();
        $isEdit = ($action == 'editCategory');

        $quoteCategoryMapper = $this->toolkit->getMapper('quoter', 'quoteCategory');

        if ($isEdit) {
            $name = $this->request->getString('name');
            $category = $quoteCategoryMapper->searchByName($name);
            if (!$category) {
                return $this->forward404($quoteCategoryMapper);
            }
        } else {
            $category = $quoteCategoryMapper->create();
        }

        $validator = new formValidator();
        
        $validator->filter('trim', 'title');
        $validator->filter('trim', 'name');
        $validator->filter('trim', 'geshi_alias');
        $validator->filter('trim', 'js_alias');
        
        $validator->rule('required', 'title', 'Укажите заголовок');
        $validator->rule('required', 'geshi_alias', 'Укажите алиас для Geshi');
        $validator->rule('required', 'js_alias', 'Укажите алиас для HighglightJS');
        $validator->rule('required', 'name', 'Укажите идентификатор');
        $validator->rule('callback', 'name', 'Идентификатор должен быть уникален', array('checkCategoryName', $category, $quoteCategoryMapper));

        if ($validator->validate()) {
            $title = $this->request->getString('title', SC_POST);
            $name = $this->request->getString('name', SC_POST);
            $geshi_alias = $this->request->getString('geshi_alias', SC_POST);
            $js_alias = $this->request->getString('js_alias', SC_POST);

            $category->setName($name);
            $category->setTitle($title);
            $category->setGeshiAlias($geshi_alias);
            $category->setJsAlias($js_alias);

            $quoteCategoryMapper->save($category);
            return jipTools::redirect();
        }

        $url = new url(($isEdit) ? 'withAnyParam' : 'default2');
        $url->setModule('quoter');
        if ($isEdit) {
            $url->add('name', $name);
        }
        $url->setAction($action);

        $this->smarty->assign('category', $category);
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('validator', $validator);
        $this->smarty->assign('form_action', $url->get());

        return $this->smarty->fetch('quoter/saveCategory.tpl');
    }
}

function checkCategoryName($name, $category, $categoryMapper)
{
    if ($name == $category->getName()) {
        return true;
    }

    $criteria = new criteria();
    $criteria->where('name', $name);
    return is_null($categoryMapper->searchOneByCriteria($criteria));
}
?>