<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/exceptions/mzzUnknownMailConfigException.php $
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
 * @version $Id: mzzUnknownMailConfigException.php 3604 2009-08-12 06:46:57Z striker $
*/

/**
 * mzzUnknownMailConfigException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1
*/

class mzzUnknownMailConfigException extends mzzException
{
    public function __construct($configName)
    {
        $message = "Mail backend config '" . $configName . "' not found";
        parent::__construct($message);
    }
}

?>