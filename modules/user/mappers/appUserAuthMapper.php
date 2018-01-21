<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/user/mappers/appUserAuthMapper.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: appUserAuthMapper.php 305 2010-01-10 00:53:43Z wiistriker $
 */

/**
 * appUserAuthMapper: маппер
 *
 * @package modules
 * @subpackage user
 * @version 0.2
 */
class appUserAuthMapper extends userAuthMapper 
{
    public function getAuth($hash, $ip)
    {
        if (!$hash) {
            return null;
        }

        $criteria = new criteria();
        $criteria->where('hash', $hash);

        $auth = $this->searchOneByCriteria($criteria);

        if ($auth) {
            $this->save($auth);
        }

        return $auth;
    }

    public function saveAuth($user, $hash, $ip)
    {
        $userAuth = $this->getAuth($hash, $ip);

        if (!is_null($userAuth) && $user_id != $userAuth->getUserId()) {
            $userAuth = null;
        }

        if (is_null($userAuth)) {
            $userAuth = $this->create();
            $userAuth->setIp($ip);
            $userAuth->setUser($user);
            $this->save($userAuth);
        }

        return $userAuth;
    }
    
    public function clearExpired($timestamp)
    {
        $criteria = new criteria($this->table());
        $criteria->where('time', $timestamp, criteria::LESS);

        $simpleDelete = new simpleDelete($criteria);
        $this->db()->query($simpleDelete->toString());
        
        /*
        $auths = $this->searchAllByCriteria($criteria);

        foreach ($auths as $auth) {
            $this->delete($auth);
        }
        */
    }
}

?>