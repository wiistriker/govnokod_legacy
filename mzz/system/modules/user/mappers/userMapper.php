<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/user/mappers/userMapper.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userMapper.php 4039 2009-12-17 10:30:13Z striker $
 */

fileLoader::load('user/models/user');
fileLoader::load('modules/jip/plugins/jipPlugin');

/**
 * userMapper: mapper for users
 *
 * @package modules
 * @subpackage user
 * @version 0.3
 */
class userMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'user';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'user_user';

    /**
     * Map
     *
     * @var array
     */
    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk')),
        'login' => array(
            'accessor' => 'getLogin',
            'mutator' => 'setLogin'),
        'password' => array(
            'accessor' => 'getPassword',
            'mutator' => 'setPassword'),
        'created' => array(
            'accessor' => 'getCreated',
            'mutator' => 'setCreated'),
        'confirmed' => array(
            'accessor' => 'getConfirmed',
            'mutator' => 'setConfirmed'),
        'last_login' => array(
            'accessor' => 'getLastLogin',
            'mutator' => 'setLastLogin'),
        'email' => array(
            'accessor' => 'getEmail',
            'mutator' => 'setEmail'),
        'language_id' => array(
            'accessor' => 'getLanguageId',
            'mutator' => 'setLanguageId'),
        'timezone' => array(
            'accessor' => 'getTimezone',
            'mutator' => 'setTimezone'),
        'skin' => array(
            'accessor' => 'getSkin',
            'mutator' => 'setSkin'),
        'groups' => array(
            'accessor' => 'getGroups',
            'mutator' => 'setGroups',
            'relation' => 'many-to-many',
            'mapper' => 'user/group',
            'reference' => 'user_userGroup_rel',
            'local_key' => 'id',
            'foreign_key' => 'id',
            'ref_local_key' => 'user_id',
            'ref_foreign_key' => 'group_id'),
        'online' => array(
            'accessor' => 'getOnline',
            'relation' => 'one',
            'mapper' => 'user/userOnline',
            'local_key' => 'id',
            'foreign_key' => 'user_id',
            'options' => array(
                'ro')));

    public function __construct()
    {
        parent::__construct();
        $this->plugins('jip');
    }

    /**
     * Search user by id
     *
     * @param int $id
     * @return object user
     */
    public function searchById($id)
    {
        return $this->searchByKey($id);
    }

    /**
     * Search user by login
     *
     * @param string $login
     * @return object user
     */
    public function searchByLogin($login)
    {
        return $this->searchOneByField('login', $login);
    }

    /**
     * Search user by email
     *
     * @param string $email
     * @return object user
     */
    public function searchByEmail($email)
    {
        return $this->searchOneByField('email', $email);
    }

    /**
     * Search user by its login and password
     *
     * @param string $login
     * @param string $password
     * @return user
     */
    public function searchByLoginAndPassword($login, $password)
    {
        $criteria = new criteria;
        $criteria->where('login', $login)->where('password', $this->cryptPassword($password));

        return $this->searchOneByCriteria($criteria);
    }

    /**
     * Возвращает объект для гостя (id = MZZ_USER_GUEST_ID)
     *
     * @return object
     */
    public function getGuest()
    {
        return $this->searchById(MZZ_USER_GUEST_ID);
    }

    protected function preInsert(& $data)
    {
        if (is_array($data)) {
            $data['created'] = time();
            if (isset($data['password'])) {
                $data['password'] = $this->cryptPassword($data['password']);
            }
        }
    }

    protected function preUpdate(& $data)
    {
        if (is_array($data)) {
            if (isset($data['password'])) {
                $data['password'] = $this->cryptPassword($data['password']);
            }
        }
    }

    public function updateLastLoginTime(user $user)
    {
        $user->setLastLogin(new sqlFunction('unix_timestamp'));
        $this->save($user);
    }

    protected function cryptPassword($password)
    {
        return md5($password);
    }
}

?>