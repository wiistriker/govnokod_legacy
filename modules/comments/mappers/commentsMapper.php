<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/comments/mappers/commentsMapper.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: commentsMapper.php 332 2010-04-19 23:43:07Z wiistriker $
*/

fileLoader::load('comments/models/comments');
fileLoader::load('orm/plugins/tree_alPlugin');
fileLoader::load('modules/ratings/plugins/ratingsPlugin');
fileLoader::load('modules/jip/plugins/jipPlugin');
fileLoader::load('orm/plugins/identityMapPlugin');

/**
 * commentsMapper: маппер
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */
class commentsMapper extends mapper implements iACLMapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'comments';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'comments_comments';

    /**
     * Map
     *
     * @var array
     */
    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'orderBy' => 1,
            'options' => array('pk', 'once'),
        ),
        'folder_id' => array(
            'accessor' => 'getFolder',
            'mutator' => 'setFolder',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'comments/commentsFolder',
            'options' => array('once')
        ),
        'user_id' => array(
            'accessor' => 'getUser',
            'mutator' => 'setUser',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'user/user',
            'options' => array('once')
        ),
        'text' => array(
            'accessor' => 'getText',
            'mutator' => 'setText'
        ),
        'created' => array(
            'accessor' => 'getCreated',
            'mutator' => 'setCreated',
            'options' => array('once')
        ),
        'edit_times' => array(
            'accessor' => 'getEditTimes',
            'mutator' => 'setEditTimes'
        ),
        'edited' => array(
            'accessor' => 'getEdited',
            'mutator' => 'setEdited'
        ),
        'rating' => array(
            'accessor' => 'getRating',
            'mutator' => 'setRating'
        ),
        'votes_on' => array(
            'accessor' => 'getVotesOn',
            'mutator' => 'setVotesOn'
        ),
        'votes_against' => array(
            'accessor' => 'getVotesAgainst',
            'mutator' => 'setVotesAgainst'
        ),
        'author_ip' => array(
            'accessor' => 'getAuthorIp',
            'mutator' => 'setAuthorIp',
        )
    );

    public function __construct()
    {
        $this->attach(new ratingsPlugin(array('join_rate' => true)));
        parent::__construct();
        $this->attach(new tree_alPlugin(array('path_name' => 'id')), 'tree');
        $this->plugins('jip');
        $this->plugins('identityMap');
    }

    public function searchById($id)
    {
        return $this->searchByKey($id);
    }

    public function searchByFolderAndId(commentsFolder $folder, $id)
    {
        $criteria = new criteria;
        $criteria->where('folder_id', $folder->getId())->where('id', $id);
        return $this->searchOneByCriteria($criteria);
    }

    public function preInsert(array &$data)
    {
        $data['created'] = time();
    }

    public function postInsert(entity $object)
    {
        $folder = $object->getFolder();
        $objectMapper = $folder->getObjectMapper();
        $commentedObject = $folder->getObject();

        $data = array(
            'commentedObject' => $commentedObject,
            'commentObject' => $object,
            'commentFolderObject' => $folder
        );

        $commentsFolderMapper = systemToolkit::getInstance()->getMapper('comments', 'commentsFolder');
        $commentsFolderMapper->notify('commentAdded', $data);

        $objectMapper->notify('commentAdded', $data);
    }

    public function ratingGetVoteValue($vote, user $user, entity $object)
    {
        $rateValue = null;
        switch ($vote) {
            case 'on':
                $rateValue = ($user->isLoggedIn()) ? 1 : 0.2;
                break;

            case 'against':
                $rateValue = ($user->isLoggedIn()) ? -1 : -0.2;
                break;
        }

        return $rateValue;
    }

    public function ratingUserCanRate($vote, user $user, entity $object)
    {
        //у гостя будем проверять токены
        if (!$user->isLoggedIn()) {
            return false;
            $toolkit = systemToolkit::getInstance();
            $request = $toolkit->getRequest();
            $session = $toolkit->getSession();

            $allow = false;
            $token = $request->getString('secret', SC_GET);
            if ($token) {
                $value = $session->get($object->getTokenName(), false);
                $allow = ($value === $token);
            }
            $session->destroy($object->getTokenName());

            return $allow;
        }

        if (stripos($user->getEmail(), '@mailinator.com') !== false) {
            return false;
        }

        return true;
        /*
        if (!$user->isLoggedIn()) {
            return false;
        }

        return $object->getUser()->getId() != $user->getId();
        */
    }

    public function ratingSearchUserRate($vote, $rateValue, user $user, entity $ratedObject, $ratingsFolder, $ratingsMapper, $ip, $ua)
    {
        if ($user->isLoggedIn()) {
            $rate = $ratingsMapper->searchByUserAndFolder($user, $ratingsFolder);
        } else {
            $rate = $ratingsMapper->searchByGestUserAndFolder($ip, $ratingsFolder, 7200); //таймаут голосования 2 часа
        }

        return $rate;
    }

    public function ratingAdded(Array $data)
    {
        $object = $data['ratedObject'];
        $ratingsFolder = $data['ratingsFolder'];

        $object->setRating($ratingsFolder->getRating());
        $object->setVotesOn($ratingsFolder->getRatingsOn());
        $object->setVotesAgainst($ratingsFolder->getRatingsAgainst());

        $this->save($object);

        //опять хак.
        $object->merge(array(
            'rating' => $ratingsFolder->getRating(),
            'votes_on' => $ratingsFolder->getRatingsOn(),
            'votes_against' => $ratingsFolder->getRatingsAgainst()
        ));
    }

    public function convertArgsToObj(array $args)
    {
        if (isset($args['id'])) {
            $do = $this->searchByKey($args['id']);
            if ($do) {
                return $do;
            }
        }

        throw new mzzDONotFoundException();
    }
}

?>