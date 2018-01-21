<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/quoter/controllers/quoterListController.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: quoterListController.php 312 2010-01-17 00:36:34Z wiistriker $
 */

/**
 * quoterListController: контроллер для метода list модуля quoter
 *
 * @package modules
 * @subpackage quoter
 * @version 0.1
 */

class quoterListController extends simpleController
{
    protected function getView()
    {
        $action = $this->request->getAction();
        $listAll = ($action == 'listAll');

        $quoteMapper = $this->toolkit->getMapper('quoter', 'quote');

        $criteria = new criteria;
        $criteria->where('active', 1);

        if (!$listAll) {
            $name = $this->request->getString('name');

            $categoryMapper = $this->toolkit->getMapper('quoter', 'quoteCategory');
            $category = $categoryMapper->searchByName($name);

            if (!$category) {
                return $this->forward404($categoryMapper);
            }

            $criteria->where('category_id', $category->getId());
            $this->smarty->assign('category', $category);
        } else {
            $user = $this->toolkit->getUser();
            if ($user->getPreferredLangs()) {
                $criteria->where('category_id', $user->getPreferredLangs(), criteria::IN);
            }
        }

        $pager = $this->setPager($quoteMapper, 10, true, 4);
        $quotes = $quoteMapper->searchAllByCriteria($criteria);
        
        //если получаем список конкретной категории, то есть шанс пересчитать количество элементов в категории
        if (!$listAll) {
            if ($category->getQuoteCounts() != $pager->getItemsCount()) {
                $category->setQuoteCounts($pager->getItemsCount());
                $categoryMapper->save($category);
            }
        }

        $this->smarty->assign('quotes', $quotes);
        $this->smarty->assign('listAll', $listAll);
        return $this->smarty->fetch('quoter/list.tpl');
    }
}

?>