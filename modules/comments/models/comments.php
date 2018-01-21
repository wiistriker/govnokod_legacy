<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/comments/models/comments.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: comments.php 320 2010-01-20 13:04:18Z wiistriker $
*/

/**
 * comments: класс для работы с данными
 *
 * @package modules
 * @subpackage comments
 * @version 0.2
 */
class comments extends entity implements iACL
{
    const SESSION_VOTE_TOKEN_PREFIX = 'commentvotetoken_';

    protected $vote_token = null;

    public function getVoteToken()
    {
        if (is_null($this->vote_token)) {
            $session = systemToolkit::getInstance()->getSession();
            $token = md5(microtime(true) . $this->getId());
            $session->set($this->getTokenName(), $token);
            $this->vote_token = $token;
        }

        return $this->vote_token;
    }

    public function getTokenName()
    {
        return self::SESSION_VOTE_TOKEN_PREFIX . $this->getId();
    }

	public function getUser()
	{
		$user = parent::__call('getUser', array());
		if (!$user) {
			$user = systemToolkit::getInstance()->getMapper('user', 'user')->getGuest();
		}

		return $user;
	}

    public function getAcl($action)
    {
        if ($action == 'edit') {
            $user = systemToolkit::getInstance()->getUser();

            if ($user->isLoggedIn() && $user->getId() == $this->getUser()->getId()) {
                return (($this->getCreated() + 60 * 5) > time());
            }

            return false;
        }
    }
}
?>