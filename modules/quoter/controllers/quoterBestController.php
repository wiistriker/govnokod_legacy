<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/quoter/controllers/quoterBestController.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: quoterBestController.php 303 2010-01-08 07:43:46Z wiistriker $
 */

/**
 * quoterBestController: контроллер для метода best модуля quoter
 *
 * @package modules
 * @subpackage quoter
 * @version 0.1
 */

class quoterBestController extends simpleController
{
    protected function getView()
    {
        $quoteMapper = $this->toolkit->getMapper('quoter', 'quote');
        $criteria = new criteria;
        $criteria->where('active', 1);

        $category = null;
        $name = $this->request->getString('name');
        if ($name) {
            $categoryMapper = $this->toolkit->getMapper('quoter', 'quoteCategory');
            $category = $categoryMapper->searchByName($name);

            if (!$category) {
                return $this->forward404($categoryMapper);
            }

            $criteria->where('category_id', $category->getId());
        }

        $user = $this->toolkit->getUser();

        $this->smarty->assign('category', $category);

        $time = $this->request->getString('time', SC_GET);
        switch ($time) {
            case 'month':
                $startTime = mktime(0, 0, 0, date('m'), 1) + $user->getTimezone() * 3600 - date('Z') + date('I') * 3600;
                $criteria->where('created', $startTime, criteria::GREATER);
                break;

            case 'week':
                $startOfWeek = (date('w') == 0) ? date('d') - 6 : date('d') - date('w') - 1;

                $startTime = mktime(0, 0, 0, date('m'), $startOfWeek) + $user->getTimezone() * 3600 - date('Z') + date('I') * 3600;
                $criteria->where('created', $startTime, criteria::GREATER);
                break;

            case 'ever':
                break;

            case 'day':
            default:
                $time = 'day';

                $startTime = mktime(0, 0, 0) + $user->getTimezone() * 3600 - date('Z') + date('I') * 3600;
                $criteria->where('created', $startTime, criteria::GREATER);
                break;
        }

        $this->smarty->assign('time', $time);

        $nomination = $this->request->getString('nomination');
        switch ($nomination) {
            case 'comments':
                $criteria->where('comments_count', 0, criteria::GREATER)->orderByDesc('comments_count');
                break;

            case 'rating':
            default:
                $nomination = 'rating';
                $criteria->where('rating', 0, criteria::GREATER)->orderByDesc('rating');
                break;
        }

        $this->smarty->assign('nomination', $nomination);

        $this->setPager($quoteMapper, 10, true, 4);
        $quotes = $quoteMapper->searchAllByCriteria($criteria);

        $this->smarty->assign('quotes', $quotes);
        return $this->smarty->fetch('quoter/best.tpl');
    }
}

?>