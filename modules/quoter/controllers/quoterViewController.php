<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/quoter/controllers/quoterViewController.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: quoterViewController.php 300 2010-01-08 06:27:46Z wiistriker $
 */

/**
 * quoterViewController: контроллер для метода view модуля quoter
 *
 * @package modules
 * @subpackage quoter
 * @version 0.1
 */

class quoterViewController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');

        $quoteMapper = $this->toolkit->getMapper('quoter', 'quote');
        $quote = $quoteMapper->searchByKey($id);
        
        if (!$quote) {
            return $this->forward404($quoteMapper);
        }

        $this->smarty->assign('quote', $quote);

        $format = $this->request->getString('format', SC_GET);
        if ($format == 'ajax') {
            $this->smarty->disableMain();
            return $this->smarty->fetch('quoter/ajaxview.tpl');
        }

        $onlyComments = $this->request->getBoolean('onlyComments', SC_GET);
        if ($onlyComments) {
            $this->smarty->disableMain();
            return $this->smarty->fetch('quoter/onlyComments.tpl');
        }

        return $this->smarty->fetch('quoter/view.tpl');
    }
}

?>