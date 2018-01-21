<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/quoter/controllers/quoterAdminController.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: quoterAdminController.php 296 2010-01-08 02:57:55Z wiistriker $
 */

/**
 * quoterAdminController: контроллер для метода admin модуля quoter
 *
 * @package modules
 * @subpackage quoter
 * @version 0.1
 */

class quoterAdminController extends simpleController
{
    protected function getView()
    {
        $quoteMapper = $this->toolkit->getMapper('quoter', 'quote');

        $this->setPager($quoteMapper);

        $quotes = $quoteMapper->searchAll();

        $this->smarty->assign('quotes', $quotes);
        return $this->smarty->fetch('quoter/admin.tpl');
    }
}

?>