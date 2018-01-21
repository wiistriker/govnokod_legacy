<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/ratings/plugins/ratingsPlugin.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: ratingsPlugin.php 300 2010-01-08 06:27:46Z wiistriker $
*/

/**
 * ratingsPlugin: плагин для рейтингуемых модулей.
 *
 * @package orm
 * @subpackage plugins
 * @version 0.0.1
 */
class ratingsPlugin extends observer
{

    protected $options = array(
        'driver' => 'simple',
        'join_rate' => false,
        'join_guest_rate' => false,
    );

    protected function updateMap(& $map)
    {
        if ($this->isJoinUserRate()) {
            $map['current_user_rate'] = array(
                'accessor' => 'getCurrentUserRate',
                'options' => array('fake', 'ro')
            );
        }
    }

    public function preSqlSelect(criteria $criteria)
    {
        if ($this->isJoinUserRate()) {
            $toolkit = systemToolkit::getInstance();
            $user = $toolkit->getUser();

            if (!$user->isLoggedIn() && !$this->isJoinUserGuestRate()) {
                return;
            }

            $ratingsMapper = $toolkit->getMapper('ratings', 'ratings');
            $ratingsFolderMapper = $toolkit->getMapper('ratings', 'ratingsFolder');

            $ratingsFolderTableAlias = $ratingsFolderMapper->table(false);

            $criterion = new criterion($ratingsFolderTableAlias . '.parent_id', $this->mapper->table(false) . '.id', criteria::EQUAL, true);
            $criterion->addAnd(new criterion($ratingsFolderTableAlias . '.module', $this->mapper->getModule()));
            $criterion->addAnd(new criterion($ratingsFolderTableAlias . '.class', $this->mapper->getClass()));
            $criteria->join($ratingsFolderMapper->table(), $criterion, $ratingsFolderTableAlias);

            $criterion = new criterion($ratingsMapper->table(false) . '.folder_id', $ratingsFolderTableAlias . '.id', criteria::EQUAL, true);
            $criterion->addAnd(new criterion($ratingsMapper->table(false) . '.user_id', $user->getId()));
            $criteria->join($ratingsMapper->table(), $criterion, $ratingsMapper->table(false));

            $criteria->select($ratingsMapper->table(false) . '.ratevalue', $this->mapper->table(false) . mapper::TABLE_KEY_DELIMITER  . 'current_user_rate');
        }
    }

    public function getDriver()
    {
        return $this->options['driver'];
    }

    public function isJoinUserRate()
    {
        return (bool)$this->options['join_rate'];
    }

    public function isJoinUserGuestRate()
    {
        return (bool)$this->options['join_guest_rate'];
    }

    public function getRateByVote($vote, user $user, entity $object)
    {
        $rateValue = null;
        if (method_exists($this->mapper, 'ratingGetVoteValue')) {
            $rateValue = $this->mapper->ratingGetVoteValue($vote, $user, $object);
        } else {
            switch ($vote) {
                case 'on':
                    $rateValue = 1;
                    break;

                case 'against':
                    $rateValue = -1;
                    break;
            }
        }

        return $rateValue;
    }

    public function canRate($vote, user $user, entity $object)
    {
        $can = true;

        if (method_exists($this->mapper, 'ratingUserCanRate')) {
            $can = $this->mapper->ratingUserCanRate($vote, $user, $object);
        }

        return $can;
    }

    public function searchUserRate($vote, $rateValue, user $user, entity $ratedObject, $ratingsFolder, $ratingsMapper, $ip, $ua)
    {
        if (method_exists($this->mapper, 'ratingSearchUserRate')) {
            $rate = $this->mapper->ratingSearchUserRate($vote, $rateValue, $user, $ratedObject, $ratingsFolder, $ratingsMapper, $ip, $ua);
        } else {
            $rate = $ratingsMapper->searchByUserAndFolder($user, $ratingsFolder);
        }

        return $rate;
    }
}
?>