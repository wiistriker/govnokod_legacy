<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/app/modules/comments/controllers/commentsExportController.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: commentsExportController.php 349 2010-11-28 22:34:16Z wiistriker $
 */

/**
 * commentsExportController
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */
class commentsExportController extends simpleController
{
    protected function getView()
    {
        $exportType = $this->getExportType();
        if ($exportType == 'rss') {
            $commentsFolderMapper = $this->toolkit->getMapper('comments', 'commentsFolder');
            $id = $this->request->getInteger('id');
            $commentsFolder = $commentsFolderMapper->searchById($id);

            if (!$commentsFolder) {
                return $this->forward404($commentsFolderMapper);
            }

            if ($commentsFolder->getModule() == 'quoter' && $commentsFolder->getType() == 'quote') {
                $this->response->setHeader('Content-type', 'application/rss+xml; charset=utf-8;');

                $comments = $commentsFolder->getComments();

                $this->smarty->assign('commentsFolder', $commentsFolder);
                $this->smarty->assign('comments', $comments);
                return $this->smarty->fetch('comments/export_quote_rss.tpl', 'native');
            }
        }

        return;
    }

    protected function getExportType()
    {
        //$action = $this->request->getAction();
        return 'rss';
    }
}
?>