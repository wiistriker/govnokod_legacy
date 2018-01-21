<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/admin/adminModule.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: adminModule.php 3839 2009-10-16 04:36:39Z zerkms $
 */

/**
 * adminModule
 *
 * @package modules
 * @subpackage admin
 * @version 0.0.1
 */
class adminModule extends simpleModule
{
    protected $classes = array(
        'admin',
        'adminGenerator');

    protected $roles = array(
        'moderator',
        'user');
}

?>