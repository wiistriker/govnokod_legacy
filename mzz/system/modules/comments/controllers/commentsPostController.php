<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/comments/controllers/commentsPostController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: commentsPostController.php 4042 2009-12-22 06:00:38Z striker $
*/

fileLoader::load('forms/validators/formValidator');

/**
 * commentsPostController: контроллер для метода post модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1.2
 */
class commentsPostController extends simpleController
{
    protected function getView()
    {
        $user = $this->toolkit->getUser();

        $commentsFolderMapper = $this->toolkit->getMapper('comments', 'commentsFolder');
        $commentsMapper = $this->toolkit->getMapper('comments', 'comments');
        $id = $this->request->getRaw('id');

        if ($id instanceof commentsFolder) {
            $commentsFolder = $id;
            $id = $commentsFolder->getId();
        }

        $onlyForm = $this->request->getBoolean('onlyForm');
        if (!isset($commentsFolder)) {
            $commentsFolder = $commentsFolderMapper->searchById($id);
            if (!$commentsFolder) {
                return $this->forward404($commentsFolderMapper);
            }
        }

        $comment = $commentsMapper->create();

        $commentReply = null;
        $replyToId = $this->request->getInteger('replyTo', SC_PATH | SC_GET);
        if ($replyToId > 0) {
            $commentReply = $commentsMapper->searchByFolderAndId($commentsFolder, $replyToId);
            if (!$commentReply) {
                return $this->forward404($commentsMapper);
            }
        }

        $validator = new formValidator();
        $validator->submit('commentSubmit');
        $validator->filter('trim', 'text');
        $validator->rule('required', 'text', 'Введите комментарий');
        $validator->rule('length', 'text', 'Слишком длинный комментарий! Максимум 2000 символов!', array(0, 2000));

        $isAjax = $this->isAjaxRequest();
        $backUrl = $this->request->getString('backUrl', SC_POST);

        if (!$onlyForm && $validator->validate()) {
            $text = $this->request->getString('text', SC_POST);

            $comment->setFolder($commentsFolder);
            $comment->setUser($user);

            if ($commentReply) {
                $comment->setTreeParent($commentReply);
            }

            $comment->setText(mzz_trim($text));
            $commentsMapper->save($comment);

            if ($isAjax) {
                $this->smarty->disableMain();
                $this->smarty->assign('comment', $comment);
                $this->smarty->assign('commentsFolder', $commentsFolder);
                return $this->smarty->fetch('comments/post_added_ajax.tpl');
            } else {
                $this->redirect($backUrl . '#comment' . $comment->getId());
                return;
            }
        }

        $url = new url('withId');
        $url->setAction($this->request->getAction());
        $url->add('id', $commentsFolder->getId());

        if ($commentReply) {
            $url->add('replyTo', $commentReply->getId(), true);
        }

        $this->smarty->assign('validator', $validator);
        $this->smarty->assign('comment', $comment);
        $this->smarty->assign('commentReply', $commentReply);
        $this->smarty->assign('commentsFolder', $commentsFolder);
        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('hideForm', $this->request->getBoolean('hideForm'));
        $this->smarty->assign('onlyForm', $onlyForm);
        $this->smarty->assign('user', $user);

        if (!$backUrl) {
            $backUrl = $this->request->getServer('REQUEST_URI');
        }

        if ($isAjax) {
            $this->smarty->disableMain();
            $this->setTemplatePrefix('ajax_');
        }

        $this->smarty->assign('backUrl', $backUrl);
        return $this->fetch('comments/post.tpl');
    }

    protected function isAjaxRequest()
    {
        return $this->request->getServer('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest';
    }
}
?>