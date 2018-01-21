<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/comments/plugins/commentsPlugin.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: commentsPlugin.php 300 2010-01-08 06:27:46Z wiistriker $
*/

/**
 * @package orm
 * @subpackage plugins
 * @version 0.0.2
 */
class commentsPlugin extends observer
{
    protected $options = array(
        'byField' => 'id',
        'join_last_seen' => false
    );

    /*
    public function commentPostInsert(Array $data)
    {
    }
    */

    protected function updateMap(& $map)
    {
        if ($this->isWithLastSeen()) {
            $map['seen_comments_count'] = array(
                'accessor' => 'getSeenCommentsCount',
                'options' => array('fake', 'ro')
            );
        }
    }

    public function preSqlSelect(criteria $criteria)
    {
        if ($this->isWithLastSeen()) {
            $toolkit = systemToolkit::getInstance();
            $user = $toolkit->getUser();

            if ($user->isLoggedIn()) {
                $commentsLastSeenMapper = $toolkit->getMapper('comments', 'commentsLastSeen');
                $commentsFolderMapper = $toolkit->getMapper('comments', 'commentsFolder');

                $commentsFolderTableAlias = $commentsFolderMapper->table(false);

                $criterion = new criterion($commentsFolderTableAlias . '.parent_id', $this->mapper->table(false) . '.id', criteria::EQUAL, true);
                $criterion->addAnd(new criterion($commentsFolderTableAlias . '.module', $this->mapper->getModule()));
                $criterion->addAnd(new criterion($commentsFolderTableAlias . '.type', $this->mapper->getClass()));
                $criteria->join($commentsFolderMapper->table(), $criterion, $commentsFolderTableAlias);

                $criterion = new criterion($commentsLastSeenMapper->table(false) . '.folder_id', $commentsFolderTableAlias . '.id', criteria::EQUAL, true);
                $criterion->addAnd(new criterion($commentsLastSeenMapper->table(false) . '.user_id', $user->getId()));
                $criteria->join($commentsLastSeenMapper->table(), $criterion, $commentsLastSeenMapper->table(false));

                $criteria->select($commentsLastSeenMapper->table(false) . '.cnt', $this->mapper->table(false) . mapper::TABLE_KEY_DELIMITER  . 'seen_comments_count');
            }
        }
    }

    public function preDelete(entity $object)
    {
        $toolkit = systemToolkit::getInstance();
        $commentsFolderMapper = $toolkit->getMapper('comments', 'commentsFolder');

        $objectClass = get_class($object);

        $map = $this->mapper->map();

        $objectId = $object->$map[$this->getByField()]['accessor']();

        $commentsFolder = $commentsFolderMapper->searchFolder($objectClass, $objectId);
        if ($commentsFolder) {
            $commentsFolderMapper->delete($commentsFolder);
        }
    }

    public function getByField()
    {
        return $this->options['byField'];
    }

    public function isWithLastSeen()
    {
        return $this->options['join_last_seen'];
    }
}
?>