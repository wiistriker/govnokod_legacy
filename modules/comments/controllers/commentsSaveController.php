<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/comments/controllers/commentsSaveController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: commentsSaveController.php 320 2010-01-20 13:04:18Z wiistriker $
*/

/**
 * commentsSaveController: контроллер для метода save модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.2
 */
class commentsSaveController extends simpleController
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

        $validator->rule('required', 'text', 'Введите хоть что-нибудь!');
        $validator->rule('length', 'text', 'Слишком длинный комментарий! Максимум 2000 символов!', array(0, 2000));

        if (!$user->isLoggedIn()) {
            $validator->filter('trim', 'captcha');

            $validator->rule('required', 'captcha', 'Введите проверочный код!');
            $validator->rule('captcha', 'captcha', 'Неверно введен проверочный код!');
        }

        $isAjax = $this->request->getBoolean('ajax', SC_POST);
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

            if ($user->isLoggedIn()) {
                $commentsLastSeenMapper = $this->toolkit->getMapper('comments', 'commentsLastSeen');
                $commentsLastSeenMapper->saveSeen($user, $commentsFolder, $commentsFolder->getCommentsCount());
            }

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

        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('user', $user);
        $this->smarty->assign('validator', $validator);
        $this->smarty->assign('comment', $comment);
        $this->smarty->assign('commentReply', $commentReply);
        $this->smarty->assign('commentsFolder', $commentsFolder);
        $this->smarty->assign('hideForm', $this->request->getBoolean('hideForm'));
        $this->smarty->assign('onlyForm', $onlyForm);

        $this->smarty->assign('isAjax', $isAjax);
        if ($isAjax) {
            $this->smarty->disableMain();
            $this->setTemplatePrefix('ajax_');
        }

        if (!$backUrl) {
            $backUrl = $commentsFolder->getDefaultBackUrl();

            if (!$backUrl) {
                $backUrl = $this->request->getServer('REQUEST_URI');
            }
        }

        $formTitles = array(
            'Я, <b>' . htmlspecialchars($user->getLogin()) . '</b>, находясь в здравом уме и твердой памяти, торжественно заявляю:',
            'Помни, <b>' . htmlspecialchars($user->getLogin()) . '</b>, за тобой могут следить!',
            'Семь раз отмерь — один отрежь, <b>' . htmlspecialchars($user->getLogin()) . '</b>!',
        );

        $session = $this->toolkit->getSession();
        if ($onlyForm) {
            $currentTitleIndex = mt_rand(0, sizeof($formTitles) - 1);
            $session->set('comments_form_title_index', $currentTitleIndex);
        } else {
            $currentTitleIndex = $session->get('comments_form_title_index', -1);
            if (!isset($formTitles[$currentTitleIndex])) {
                $currentTitleIndex = mt_rand(0, sizeof($formTitles) - 1);
                $session->set('comments_form_title_index', $currentTitleIndex);
            }
        }

        $this->smarty->assign('formTitle', $formTitles[$currentTitleIndex]);
        $this->smarty->assign('backUrl', $backUrl);
        return $this->fetch('comments/post.tpl');
    }
}
?>