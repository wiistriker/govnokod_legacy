<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/filters/sessionFilter.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage filters
 * @version $Id: sessionFilter.php 2182 2007-11-30 04:41:35Z zerkms $
*/

fileLoader::load('session');

/**
 * sessionFilter: фильтр для старта сессии
 *
 * @package system
 * @subpackage filters
 * @version 0.2.1
 */
class sessionFilter implements iFilter
{
    /**
     * запуск фильтра на исполнение
     *
     * @param filterChain $filter_chain объект, содержащий цепочку фильтров
     * @param httpResponse $response объект, содержащий информацию, выводимую клиенту в браузер
     * @param iRequest $request
     */
    public function run(filterChain $filter_chain, $response, iRequest $request)
    {
        $session = systemToolkit::getInstance()->getSession();
        $session->start();

        $filter_chain->next();

        $session->stop();
    }
}

?>