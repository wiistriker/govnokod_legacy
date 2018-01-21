<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/comments/controllers/commentsPostController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: commentsPostController.php 325 2010-01-25 10:24:12Z wiistriker $
*/

fileLoader::load('forms/validators/formValidator');

/**
 * commentsPostController: контроллер для метода post модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.2
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

        $validator->rule('required', 'text', 'Введите хоть что-нибудь!');
        $validator->rule('length', 'text', 'Слишком длинный комментарий! Максимум 2000 символов!', array(0, 2000));

        if (stripos($user->getEmail(), '@mailinator.com') !== false) {
            $validator->setError('text', 'System health check error');
        }

        $user_created = $user->getCreated();
        if (!$user_created) {
            //$user_created = strtotime();
        }
        
        if (time() - $user_created < strtotime('+1 week', 0)) {
            //$validator->setError('text', 'Пожалуйста, подождите неделю, прежде чем Вам будет доступно комментирование');
        }
        
		$use_captcha = false;

		$cache = cache::factory('memcache');
		$prevent_flood_cache_key = 'user_comment_' . $user->getId();

		if (!$user->isLoggedIn()) {
			$use_captcha = true;
            
            if (!in_array((int)date('w'), array(2, 5, 6))) {
                $validator->setError('text', 'Гости могут высказаться только во вторник, пятницу или субботу');
            } else {
                $validator->setError('text', 'Гости могут высказаться только в понедельник, среду, четверг или воскресение');
            }
		} else {
			$result = $cache->get($prevent_flood_cache_key);
			if ($result) {
				$use_captcha = true;
			}
		}

        if ($use_captcha) {
            $validator->filter('trim', 'captcha');

            $validator->rule('required', 'captcha', 'Введите проверочный код!');
            $validator->rule('captcha', 'captcha', 'Неверно введен проверочный код!');

            /*
            $guest_comments_disabled_until = strtotime('2099-01-01');
            if (!$user->isLoggedIn() && time() < $guest_comments_disabled_until) {
                $validator->setError('text', 'На сайте проводится профилактика, поэтому гостям нельзя писать комментарии до 1 января 2099. Говнокод.ру благодарит Вас за понимание!');
            }
            */
        }

        $isAjax = $this->request->getBoolean('ajax', SC_POST);

        if (!$onlyForm && $validator->validate()) {
            $text = $this->request->getString('text', SC_POST);

            $comment->setFolder($commentsFolder);
            $comment->setUser($user);

            if ($commentReply) {
                $comment->setTreeParent($commentReply);
            }

            $ip = $this->request->getServer('REMOTE_ADDR');
            $comment->setAuthorIp($ip);

            $comment->setText(mzz_trim($text));
            $commentsMapper->save($comment);

            if ($user->isLoggedIn()) {
				$cache->set($prevent_flood_cache_key, 1, array(), 30);

                $commentsLastSeenMapper = $this->toolkit->getMapper('comments', 'commentsLastSeen');
                $commentsLastSeenMapper->saveSeen($user, $commentsFolder, $commentsFolder->getCommentsCount());
            }

            if ($isAjax) {
                $this->smarty->disableMain();
                $this->smarty->assign('comment', $comment);
                $this->smarty->assign('commentsFolder', $commentsFolder);
                return $this->smarty->fetch('comments/post_added_ajax.tpl');
            } else {
                $back_url = $commentsFolder->getDefaultBackUrl();

                if (!$back_url) {
                    $url = new url('default');
                    $back_url = $url->get();
                }

                $this->redirect($back_url . '#comment' . $comment->getId());
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
		$this->smarty->assign('use_captcha', $use_captcha);
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

        $formTitles = array(
            'Я, <b>' . htmlspecialchars($user->getLogin()) . '</b>, находясь в здравом уме и твердой памяти, торжественно заявляю:',
            'Помни, <b>' . htmlspecialchars($user->getLogin()) . '</b>, за тобой могут следить!',
            'Семь раз отмерь — один отрежь, <b>' . htmlspecialchars($user->getLogin()) . '</b>!',
            'Где здесь C++, <b>' . htmlspecialchars($user->getLogin()) . '</b>?!',
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
        return $this->fetch('comments/post.tpl');
    }
}
?>