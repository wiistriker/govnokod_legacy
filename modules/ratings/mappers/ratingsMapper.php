<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/ratings/mappers/ratingsMapper.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: ratingsMapper.php 300 2010-01-08 06:27:46Z wiistriker $
 */

fileLoader::load('ratings/models/ratings');

/**
 * ratingsMapper: маппер
 *
 * @package modules
 * @subpackage ratings
 * @version 0.1
 */
class ratingsMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'ratings';
    
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'ratings_ratings';

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
            'join_type' => 'inner',
            'options' => array('lazy')
        ),
        'created' => array(
            'accessor' => 'getCreated',
            'mutator' => 'setCreated'
        ),
        'ip_address' => array(
            'accessor' => 'getIpAddress',
            'mutator' => 'setIpAddress'
        ),
        'useragent' => array(
            'accessor' => 'getUserAgent',
            'mutator' => 'setUserAgent'
        ),
        'ratevalue' => array(
            'accessor' => 'getRateValue',
            'mutator' => 'setRateValue'
        ),
        'folder_id' => array(
            'accessor' => 'getFolder',
            'mutator' => 'setFolder',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'ratings/ratingsFolder',
            'options' => array('lazy')
        )
    );

    public function searchByUserAndFolder(user $user, ratingsFolder $folder)
    {
        $criteria = new criteria;
        $criteria->where('user_id', $user->getId())->where('folder_id', $folder->getId());
        return $this->searchOneByCriteria($criteria);
    }

    public function searchByGestUserAndFolder($ip, ratingsFolder $folder, $rateTimeout = 7200)
    {
        $criteria = new criteria;
        $criteria->where('ip_address', $ip)->where('folder_id', $folder->getId())->where('created', time() - $rateTimeout, criteria::GREATER);

        return $this->searchOneByCriteria($criteria);
    }

    public function preInsert(& $data)
    {
        if (is_array($data)) {
            $data['created'] = time();
        }
    }

    public function postInsert(entity $object)
    {
        $folder = $object->getFolder();

        $data = array(
            'ratings' => $object,
            'ratingsFolder' => $folder,
            'rateValue' => $object->getRateValue(),
        );

        $ratingsFolderMapper = systemToolkit::getInstance()->getMapper('ratings', 'ratingsFolder');
        $ratingsFolderMapper->notify('ratingAdded', $data);
    }
}

?>