<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/modules/page/controllers/pageDeleteFolderController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: pageDeleteFolderController.php 3116 2009-04-06 21:33:32Z mz $
*/

/**
 * pageDeleteFolderController: контроллер для метода deleteFolder модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

class pageDeleteFolderController extends simpleController
{
    protected function getView()
    {
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');

        $name = $this->request->getString('name');

        $folder = $pageFolderMapper->searchByPath($name);

        if (!$folder) {
            return $this->forward404($pageFolderMapper);
        }

        $pageFolderMapper->delete($folder);

        return jipTools::redirect();
    }
}

?>