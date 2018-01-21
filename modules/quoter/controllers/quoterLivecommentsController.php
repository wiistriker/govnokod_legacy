<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 2200 2007-12-06 06:52:05Z zerkms $
 */

/**
 * quoterLivecommentsController
 *
 * @package modules
 * @subpackage quoter
 * @version 0.0.1
 */
class quoterLivecommentsController extends simpleController
{
    protected function getView()
    {
        $cache_key = 'live_comments';
        $cache = cache::factory('memcache');
        $result = $cache->get($cache_key, $html);

		if ($this->request->getBoolean('anticache', SC_GET)) {
			$result = false;
		}

        if (!$result) {
            $quoteMapper = $this->toolkit->getMapper('quoter', 'quote');
            $quotes = $quoteMapper->searchForLiveComments();
            
            $this->smarty->assign('quotes', $quotes);
            $html = $this->smarty->fetch('quoter/livecomments.tpl');
            $cache->set($cache_key, $html, array(), 3600 * 3);
        }
        
        $this->smarty->assign('html', $html);
        return $this->smarty->fetch('quoter/livecomments_holder.tpl');
    }
}
?>