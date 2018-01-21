<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/quoter/controllers/quoterUserQuotesController.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: quoterUserQuotesController.php 300 2010-01-08 06:27:46Z wiistriker $
 */

/**
 * quoterUserQuotesController
 *
 * @package modules
 * @subpackage quoter
 * @version 0.1
 */
class quoterUserQuotesController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');

        $userMapper = $this->toolkit->getMapper('user', 'user');
        $user = $userMapper->searchByKey($id);

        if (!$user) {
            return $this->forward404($user);
        }

        $quoteMapper = $this->toolkit->getMapper('quoter', 'quote');

        $pager = $this->setPager($quoteMapper, 10, true, 4);
        $quotes = $quoteMapper->searchUserQuotes($user);
        
        //SELECT `qc`.`name`, COUNT(*) FROM `quoter_quote` `q` INNER JOIN `quoter_quoteCategory` `qc` ON `q`.`category_id` = `qc`.`id` WHERE `q`.`user_id` = 1 GROUP BY `q`.`category_id`

        if ($user->getQuotesCount() != $pager->getItemsCount()) {
            $user->setQuotesCount($pager->getItemsCount());
            $userMapper->save($user);
        }

        $this->smarty->assign('quotes', $quotes);
        $this->smarty->assign('user', $user);
        return $this->smarty->fetch('quoter/userquotes.tpl');
    }
}

?>