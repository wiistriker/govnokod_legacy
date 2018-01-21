<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/page/models/page.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: page.php 3836 2009-10-16 03:12:59Z zerkms $
 */

/**
 * page: page
 *
 * @package modules
 * @subpackage page
 * @version 0.1.4
 */
class page extends entity implements iACL
{
    public function getFullPath()
    {
        $path = $this->getFolder()->getTreePath() . '/' . $this->getName();
        return substr($path, strpos($path, '/') + 1);
    }

    public function getAcl($action)
    {
    }
}

?>