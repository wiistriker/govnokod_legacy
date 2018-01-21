<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/simple/simple404Controller.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: simple404Controller.php 4046 2010-01-04 05:29:02Z striker $
 */

/**
 * simple404Controller: контроллер страницы с ошибкой 404
 *
 * @package modules
 * @subpackage simple
 * @version 0.3
 */
class simple404Controller extends simpleController
{
    protected function getView()
    {
        $this->response->setStatus(404);

        $template = 'simple/404.tpl';
        $response = (!is_null($this->action)) ? $this->smarty->fetchPassive($template) : $this->smarty->fetch($template);

        return $response;
    }

    public function run()
    {
        return $this->getView();
    }
}

?>