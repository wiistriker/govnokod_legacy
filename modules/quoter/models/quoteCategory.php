<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/quoter/models/quoteCategory.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: quoteCategory.php 303 2010-01-08 07:43:46Z wiistriker $
 */

/**
 * quoteCategory: класс для работы c данными
 *
 * @package modules
 * @subpackage quoter
 * @version 0.2
 */
class quoteCategory extends entity
{
    protected $page = false;

    public function getPage()
    {
        if ($this->page === false) {
            $this->page = $this->mapper->getPage($this);
        }

        return $this->page;
    }
}

?>