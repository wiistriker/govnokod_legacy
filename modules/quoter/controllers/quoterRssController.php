<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/quoter/controllers/quoterRssController.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: quoterRssController.php 304 2010-01-08 07:46:43Z wiistriker $
 */

/**
 * quoterRssController
 *
 * @package modules
 * @subpackage quoter
 * @version 0.1
 */
class quoterRssController extends simpleController
{
    protected function getView()
    {
        $criteria = new criteria;
        $criteria->where('active', 1)->limit(50);

        $action = $this->request->getAction();
        if ($action == 'userrss') {
            $id = $this->request->getInteger('id');

            $userMapper = $this->toolkit->getMapper('user', 'user');
            $user = $userMapper->searchByKey($id);

            if (!$user || !$user->isLoggedIn()) {
                $url = new url('rss');
                $this->redirect($url->get());
                return;
            }

            if ($user->getPreferredLangs()) {
                $criteria->where('category_id', $user->getPreferredLangs(), criteria::IN);
            }

            $this->smarty->assign('user', $user);
        } else {
            $name = $this->request->getString('name');
            if ($name) {
                $categoryMapper = $this->toolkit->getMapper('quoter', 'quoteCategory');
                $category = $categoryMapper->searchByName($name);
                if ($category) {
                    $criteria->where('category_id', $category->getId());
                    $this->smarty->assign('category', $category);
                }
            } else if (!$this->request->getBoolean('pass', SC_GET)) {
                $this->redirect('http://feeds.feedburner.com/Govnokodru');
                return;
            }
        }

        $quoteMapper = $this->toolkit->getMapper('quoter', 'quote');
        $quotes = $quoteMapper->searchAllByCriteria($criteria);
        
        $this->smarty->assign('quotes', $quotes);
        $this->smarty->assign('withCategory', (isset($category)));
        $this->smarty->assign('action', $action);
        
        $this->response->setHeader('Content-type', 'application/rss+xml; charset=utf-8;');
        return $this->smarty->fetch('quoter/rss.tpl');
    }
}

?>