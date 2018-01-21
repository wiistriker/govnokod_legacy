<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/application.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage core
 * @version $Id: application.php 296 2010-01-08 02:57:55Z wiistriker $
*/

/**
 * application: демо-приложение
 *
 * @package system
 * @subpackage application
 * @version 0.1
 */

class application extends core
{

    /**
     * Регистрация необходимых фильтров
     *
     * @param object $filter_chain
     * @return object
     */
    protected function composeFilters($filter_chain)
    {
        $filter_chain->registerFilter(new timingFilter());
        $filter_chain->registerFilter(new sessionFilter());
        $filter_chain->registerFilter(new routingFilter());
        $filter_chain->registerFilter(new userFilter());
        //$filter_chain->registerFilter(new userPreferencesFilter());
        //$filter_chain->registerFilter(new userOnlineFilter());
        $filter_chain->registerFilter(new contentFilter());
        return $filter_chain;
    }
}

?>