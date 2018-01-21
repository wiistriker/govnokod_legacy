<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/ratings/models/ratings.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: ratings.php 300 2010-01-08 06:27:46Z wiistriker $
 */

/**
 * ratings: класс для работы c данными
 *
 * @package modules
 * @subpackage ratings
 * @version 0.2
 */
class ratings extends entity
{
    protected $ratedObject;

    public function setRatedObject(entity $object)
    {
        $this->ratedObject = $object;
    }

    public function getRatedObject()
    {
        return $this->ratedObject;
    }
}
?>