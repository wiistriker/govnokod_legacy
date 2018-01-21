<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/exceptions/mzzModuleNotFoundException.php $
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
 * @version $Id: mzzModuleNotFoundException.php 3750 2009-09-25 04:36:43Z zerkms $
*/

/**
 * mzzModuleNotFoundException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1
*/
class mzzModuleNotFoundException extends mzzException
{
    public function __construct($moduleName)
    {
        parent::__construct('Module ' . $moduleName . ' not found');
    }
}

?>