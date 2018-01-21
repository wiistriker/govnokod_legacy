<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/comments/mappers/commentsLastSeenMapper.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: commentsLastSeenMapper.php 300 2010-01-08 06:27:46Z wiistriker $
 */

fileLoader::load('comments/models/commentsLastSeen');

/**
 * commentsLastSeenMapper
 *
 * @package modules
 * @subpackage comments
 * @version 0.2
 */
class commentsLastSeenMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'commentsLastSeen';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'comments_comments_lseen';

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
        'folder_id' => array (
            'accessor' => 'getFolderId',
            'mutator' => 'setFolderId'
        ),
        'user_id' => array (
            'accessor' => 'getUserId',
            'mutator' => 'setUserId'
        ),
        'cnt' => array (
            'accessor' => 'getSeenCommentsCount',
            'mutator' => 'setSeenCommentsCount'
        ),
        'time_read' => array (
            'accessor' => 'getTimeRead',
            'mutator' => 'setTimeRead'
        )
    );

    public function searchByUserAndFolder(user $user, commentsFolder $folder)
    {
        $criteria = new criteria;
        $criteria->where('user_id', $user->getId())->where('folder_id', $folder->getId());
        return $this->searchOneByCriteria($criteria);
    }

    public function saveSeen(user $user, commentsFolder $folder, $commentsCount)
    {
        $data = array(
            'user_id' => $user->getId(),
            'folder_id' => $folder->getId(),
            'cnt' => $commentsCount,
            'time_read' => time()
        );

        $criteria = new criteria($this->table());
        $insert = new simpleInsert($criteria);

        $insertQuery = $insert->toString($data);
        $replaceQuery = preg_replace('!^INSERT!', 'REPLACE', $insertQuery);

        $this->db()->query($replaceQuery);
    }
}

?>