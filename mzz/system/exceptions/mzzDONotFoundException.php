<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/exceptions/mzzDONotFoundException.php $
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
 * @version $Id: mzzDONotFoundException.php 2182 2007-11-30 04:41:35Z zerkms $
*/

/**
 * mzzDONotFoundException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1
*/

class mzzDONotFoundException extends mzzException
{
    public function __construct($message = 'Искомый ДО не найден')
    {
        parent::__construct($message);
    }
}

?>