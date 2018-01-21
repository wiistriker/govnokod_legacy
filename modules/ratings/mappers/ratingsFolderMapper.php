<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/ratings/mappers/ratingsFolderMapper.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: ratingsFolderMapper.php 300 2010-01-08 06:27:46Z wiistriker $
 */

fileLoader::load('ratings/models/ratingsFolder');
fileLoader::load('orm/plugins/identityMapPlugin');

/**
 * ratingsFolderMapper: маппер
 *
 * @package modules
 * @subpackage ratings
 * @version 0.3
 */
class ratingsFolderMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'ratingsFolder';
    
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'ratings_ratingsFolder';

    /**
     * Map
     *
     * @var array
     */
    protected $map = array (
        'id' => array (
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array ('pk', 'once')
        ),
        'parent_id' => array (
            'accessor' => 'getParentId',
            'mutator' => 'setParentId',
        ),
        'rating' => array (
            'accessor' => 'getRating',
            'mutator' => 'setRating',
        ),
        'ratings_on' => array (
            'accessor' => 'getRatingsOn',
            'mutator' => 'setRatingsOn',
        ),
        'ratings_against' => array (
            'accessor' => 'getRatingsAgainst',
            'mutator' => 'setRatingsAgainst',
        ),
        'module' => array (
            'type' => 'char',
            'maxlength' => 20,
            'accessor' => 'getModule',
            'mutator' => 'setModule',
        ),
        'class' => array (
            'type' => 'char',
            'maxlength' => 20,
            'accessor' => 'getClass',
            'mutator' => 'setClass',
        )
    );

    public function __construct()
    {
        parent::__construct();
        $this->plugins('identityMap');
    }

    public function searchById($id)
    {
        return $this->searchByKey($id);
    }

    public function searchByModuleClassAndParent($module, $class, $id)
    {
        $criteria = new criteria;
        $criteria->where('module', $module)->where('class', $class)->where('parent_id', $id);

        $folder = $this->searchOneByCriteria($criteria);

        if (!$folder) {
            try {
                $ratedObjectMapper = systemToolkit::getInstance()->getMapper($module, $class);

                if ($ratedObjectMapper->isAttached('ratings')) {
                    $object = $ratedObjectMapper->searchByKey($id);
                    if ($object) {
                        $folder = $this->create();
                        $folder->setModule($module);
                        $folder->setClass($class);

                        $pkAccessor = $ratedObjectMapper->pk();
                        $map = $ratedObjectMapper->map();
                        $objectId = $object->$map[$pkAccessor]['accessor']();
                        $folder->setParentId($objectId);

                        $this->save($folder);

                        $folder->setObjectMapper($ratedObjectMapper);
                        $folder->setObject($object);
                    }
                }
            } catch (mzzException $ex) {
                $folder = null;
            }
        }

        return $folder;
    }

    public function preInsert(&$data)
    {
        if (is_array($data)) {
            $data['rating'] = 0;
            $data['ratings_on'] = 0;
            $data['ratings_against'] = 0;
        }
    }

    public function ratingAdded(Array $data)
    {
        $ratingsFolder = $data['ratingsFolder'];
        $ratedObjectMapper = $ratingsFolder->getObjectMapper();

        $ratings = $data['ratings'];

        $value = $ratings->getRateValue();

        $ratingsOn = $ratingsFolder->getRatingsOn();
        $ratingsAgainst = $ratingsFolder->getRatingsAgainst();

        if ($value > 0) {
            $ratingsOn++;
            $ratingsFolder->setRatingsOn($ratingsOn);
        } elseif ($value < 0) {
            $ratingsAgainst++;
            $ratingsFolder->setRatingsAgainst($ratingsAgainst);
        }

        $currentRating = $ratingsFolder->getRating();
        $newRating = $currentRating + $value;

        $ratingsFolder->setRating($newRating);
        $this->save($ratingsFolder);

        $data['ratingsFolder'] = $ratingsFolder;
        $data['ratedObject'] = $ratingsFolder->getObject();

        $ratedObjectMapper->notify('ratingAdded', $data);
    }
}

?>