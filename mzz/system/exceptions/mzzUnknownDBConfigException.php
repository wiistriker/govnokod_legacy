<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/exceptions/mzzUnknownDBConfigException.php $
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
 * @version $Id: mzzUnknownDBConfigException.php 3637 2009-08-21 11:41:18Z striker $
*/

/**
 * mzzUnknownDBConfigException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1
*/

class mzzUnknownDBConfigException extends mzzException
{
    public function __construct($aliasName)
    {
        $message = "DB config with alias '" . $aliasName . "' not found";
        parent::__construct($message);
    }
}

?>