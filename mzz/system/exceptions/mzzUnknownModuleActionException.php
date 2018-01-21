<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/exceptions/mzzUnknownModuleActionException.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage exceptions
 * @version $Id: mzzUnknownModuleActionException.php 3750 2009-09-25 04:36:43Z zerkms $
*/

/**
 * mzzUnknownModuleActionException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1
*/

class mzzUnknownModuleActionException extends mzzException
{
    public function __construct($module, $action)
    {
        parent::__construct('Unknown action ' . $action . ' in module ' . $module);
    }
}

?>