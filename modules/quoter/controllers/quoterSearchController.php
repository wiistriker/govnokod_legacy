<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/quoter/controllers/quoterSearchController.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: quoterSearchController.php 328 2010-02-25 04:48:02Z wiistriker $
 */

/**
 * quoterSearchController: контроллер для метода searchAll модуля quoter
 *
 * @package modules
 * @subpackage quoter
 * @version 0.1
 */

class quoterSearchController extends simpleController
{
    protected function getView()
    {
        $action = $this->request->getAction();

        $quoteMapper = $this->toolkit->getMapper('quoter', 'quote');
        $criteria = new criteria;
        $criteria->where('active', 1);

        $categoryMapper = $this->toolkit->getMapper('quoter', 'quoteCategory');
        $categories = $categoryMapper->searchAll();
        $this->smarty->assign('categories', $categories);

        $name = $this->request->getString('language', SC_GET);

        $category = null;
        $categorySelect = array();
        foreach ($categories as $cat) {
            $categorySelect[$cat->getName()] = $cat->getTitle();
            if ($cat->getName() == $name) {
                $category = $cat;
            }
        }

        if ($category) {
            $criteria->where('category_id', $category->getId());
        }

        $this->smarty->assign('category', $category);

        $quotes = array();

        $mode = $this->request->getString('mode');
        switch ($mode) {
            default:
                $this->setPager($quoteMapper, 10, true, 4);
                $mode = 'word';

                $word = trim($this->request->getString('search', SC_GET));
                $word = mb_substr($word, 0, 50);
                if ($word) {
                    //$criteria->add('active', 1)->setOrderByFieldDesc('created');

                    $criterion = new criterion('text', '%' . $word . '%', criteria::LIKE);
                    $criterion->addOr(new criterion('description', '%' . $word . '%', criteria::LIKE));

                    $criteria->where($criterion);

                    $quotes = $quoteMapper->searchAllByCriteria($criteria);
                }

                $this->smarty->assign('word', $word);
                break;
        }

        $this->smarty->assign('quotes', $quotes);
        $this->smarty->assign('categorySelect', $categorySelect);
        $this->smarty->assign('mode', $mode);
        return $this->smarty->fetch('quoter/search.tpl');
    }
}

?>