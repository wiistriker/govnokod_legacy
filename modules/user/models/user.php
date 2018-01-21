<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/user/models/user.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: user.php 318 2010-01-17 15:25:24Z wiistriker $
 */

fileLoader::load('service/skin');

/**
 * user: user
 *
 * @package modules
 * @subpackage user
 * @version 0.2
 */
class user extends entity implements iACL
{
    const LOCAL_AVATARS_URL = '/files/avatars/';

    protected $avatarUrls = array();
    protected $preferredLangs = null;
    protected $preferredLangsCategories = null;

    /**
     * Проверяет является ли пользователь авторизированным
     * Пользователь считается таковым, если у него установлен
     * id больше 0 и он не равен значению константы MZZ_USER_GUEST_ID
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        return $this->getId() > 0 && $this->getId() !=  MZZ_USER_GUEST_ID;
    }

    public function isConfirmed()
    {
        return !(bool)($this->getConfirmed());
    }

    public function isActive()
    {
        return !is_null($this->getOnline());
    }
    
    public function activate()
    {
        $this->setConfirmed('');
    }
    
    public function isRoot()
    {
        return $this->getId() == 2;
        //return in_array(MZZ_ROOT_GID, $this->getGroups()->keys());
    }

    public function getSkin()
    {
        $id = parent::__call('getSkin', array());
        return new skin($id);
    }

    public function getAvatarUrl($size = 100)
    {
        $size = (int)$size;

        if (!isset($this->avatarUrls[$size])) {
            if ($this->isLoggedIn()) {
                $avatarValue = $this->getAvatarType();

                switch ($avatarValue) {
                    case 2:
                        $email = $this->getEmail();
                        $avatarUrl = 'http://www.gravatar.com/avatar/' . md5(strtolower($email)) . '?default=' . urlencode($this->getNoAvatarUrl($size)). '&r=pg&size=' . $size;
                        break;

                    default:
                        $avatarUrl = $this->getNoAvatarUrl($size);
                        break;
                }
            } else {
                $avatarUrl = $this->getGuestAvatarUrl($size);
            }

            $this->avatarUrls[$size] = $avatarUrl;
        }

        return $this->avatarUrls[$size];
    }

    protected function getNoAvatarUrl($size)
    {
        $request = systemToolkit::getInstance()->getRequest();
        return $request->getUrl() . self::LOCAL_AVATARS_URL . 'noavatar_' . $size . '.png';
    }

    protected function getGuestAvatarUrl($size)
    {
        $request = systemToolkit::getInstance()->getRequest();
        return $request->getUrl() . self::LOCAL_AVATARS_URL . 'guest_' . $size . '.png';
    }

    public function setPreferredLangs($langs = false)
    {
        if (is_array($langs)) {
            $langs = serialize($langs);
        } else {
            $langs = '';
        }

        parent::__call('setPreferredLangs', array($langs));
    }

    public function getPreferredLangsCategories()
    {
        if (is_null($this->preferredLangsCategories)) {
            $categories = array();
            if ($this->getPreferredLangs()) {
                $quoteCategoryMapper = systemToolkit::getInstance()->getMapper('quoter', 'quoteCategory');

                $criteria = new criteria;
                $criteria->where('id', $this->getPreferredLangs(), criteria::IN);
                $categories = $quoteCategoryMapper->searchAllByCriteria($criteria);
            }

            $this->preferredLangsCategories = $categories;
        }

        return $this->preferredLangsCategories;
    }

    public function getPreferredLangs()
    {
        if (is_null($this->preferredLangs)) {
            $langs = parent::__call('getPreferredLangs', array());
            if ($langs === '') {
                $langs = false;
            } else {
                try {
                    $langs = unserialize($langs);
                } catch (mzzException $ex) {
                    $langs = false;
                }
            }

            $this->preferredLangs = $langs;
        }

        return $this->preferredLangs;
    }

    public function isPreferredLang($langId)
    {
        $langs = $this->getPreferredLangs();

        if ($langs === false) {
            return true;
        }

        return in_array($langId, $langs);
    }

    public function getHighlightDriverTitle()
    {
        $userMapper = systemToolkit::getInstance()->getMapper('user', 'user');
        $drivers = $userMapper->getHighlighDrivers();

        if (isset($drivers[$this->getHighlightDriver()])) {
            return $drivers[$this->getHighlightDriver()];
        }

        return null;
    }

    public function getOnline()
    {
        return null;
    }

    /*
    public function getGroups()
    {
        $cache = cache::factory('memcache');

        $cacheKey = 'user_' . $this->getId() . '_groups';
        $result = $cache->get($cacheKey, $groups);
        if (!$result || !is_a($groups, 'collection')) {
            $groups = parent::__call('getGroups', array());
            $cache->set($cacheKey, $groups, array(), 3600*24);
        }

        return $groups;
    }
    */
    
    public function getAcl($action)
    {
        switch ($action) {
            case 'preferences':
                if (!$this->isConfirmed()) {
                    return false;
                }

                $user = systemToolkit::getInstance()->getUser();
                if ($this->getId() === $user->getId()) {
                    return true;
                }
                break;

            case 'activate':
                if ($this->isConfirmed()) {
                    return false;
                }
                break;
        }
    }
}
?>