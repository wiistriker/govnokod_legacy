<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/user/userModule.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userModule.php 3839 2009-10-16 04:36:39Z zerkms $
 */

/**
 * userModule
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class userModule extends simpleModule
{
    protected $classes = array(
        'user',
        'userFolder',
        'userGroup',
        'group',
        'groupFolder',
        'userAuth',
        'userOnline',
        'userRole',
        'userOpenID',
    );

    protected $roles = array(
        'moderator',
        'user'
    );
    
    public function getRoutes()
    {
        return array(
            array(
            ),
            array(
                'openIDLogin' => new requestRoute('user/openid/login', array('module' => 'user', 'action' => 'openIDLogin')),
                'user-confirm' => new requestRoute('user/confirm', array('module' => 'user', 'action' => 'confirm')),
                'user-recover-pass' => new requestRoute('user/recover', array('module' => 'user', 'action' => 'recover')),
            )
        );
    }
}
?>