<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/i18n/charset/singleByteCharset.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage request
 * @version $Id: singleByteCharset.php 3002 2009-02-04 23:03:20Z mz $
*/

class singleByteCharset
{
    public function __call($method, $args)
    {
        return call_user_func_array($method, $args);
    }
}

?>