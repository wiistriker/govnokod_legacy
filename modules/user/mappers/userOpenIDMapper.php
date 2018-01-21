<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/user/mappers/userOpenIDMapper.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userOpenIDMapper.php 314 2010-01-17 03:36:52Z wiistriker $
 */

fileLoader::load('user/models/userOpenID');

/**
 * userOpenIDMapper
 *
 * @package modules
 * @subpackage user
 * @version 0.2
 */
class userOpenIDMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'userOpenID';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'user_userOpenID';

    /**
     * Map
     *
     * @var array
     */
    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array('pk', 'once')
        ),
        'user_id' => array(
            'accessor' => 'getUser',
            'mutator' => 'setUser',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'user/user',
            'join_type' => 'inner'
        ),
        'openid_url' => array(
            'accessor' => 'getUrl',
            'mutator' => 'setUrl',
        )
    );

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function searchAllByUserId($user_id)
    {
        return $this->searchAllByField('user_id', $user_id);
    }

    public function searchByUrl($url)
    {
        return $this->searchOneByField('openid_url', $url);
    }
}
?>