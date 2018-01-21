<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/modules/page/controllers/pageViewController.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: pageViewController.php 3620 2009-08-15 23:51:48Z striker $
 */

/**
 * pageViewController: контроллер для метода view модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.2.1
 */

class pageViewController extends simpleController
{
    protected function getView()
    {
        $name = $this->request->getString('name');
        if (!$name) {
            $name = $this->request->getString('id');
        }
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');

        $page = $pageFolderMapper->searchChild($name);

        if (empty($page)) {
            return $this->forward404($pageFolderMapper);
        }

        $this->smarty->assign('page', $page);
        return $this->smarty->fetch('page/view.tpl');
    }
}

?>