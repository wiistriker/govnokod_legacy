<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/modules/admin/controllers/adminDashboardController.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: adminDashboardController.php 3322 2009-06-05 00:42:36Z mz $
 */

/**
 * adminDashboardController
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminDashboardController extends simpleController
{
    protected function getView()
    {
        return $this->smarty->fetch('admin/dashboard.tpl');
    }
}

?>