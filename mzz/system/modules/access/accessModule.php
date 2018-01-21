<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/access/accessModule.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: accessModule.php 4033 2009-12-10 09:21:00Z striker $
 */

/**
 * accessModule
 *
 * @package modules
 * @subpackage access
 * @version 0.0.1
 */
class accessModule extends simpleModule
{
    protected $classes = array('access');

    protected $roles = array('admin');
}
?>