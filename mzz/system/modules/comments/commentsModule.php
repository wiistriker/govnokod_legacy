<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/comments/commentsModule.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: commentsModule.php 4033 2009-12-10 09:21:00Z striker $
 */

/**
 * commentsModule
 *
 * @package modules
 * @subpackage comments
 * @version 0.0.1
 */
class commentsModule extends simpleModule
{
    protected $classes = array(
        'comments',
        'commentsFolder',
    );

    protected $roles = array(
        'moderator',
        'user'
    );
}
?>