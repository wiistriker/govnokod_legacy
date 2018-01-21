<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/fileManager/fileManagerModule.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: fileManagerModule.php 3839 2009-10-16 04:36:39Z zerkms $
 */

/**
 * fileManagerModule
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.0.1
 */
class fileManagerModule extends simpleModule
{
    protected $classes = array(
        'file',
        'folder',
        'storage');

    protected $roles = array(
        'moderator',
        'user');

    public function getRoutes()
    {
        return array(
            array(),
            array(
                'fmFolder' => new requestRoute('fileManager/:name/:action', array(
                    'module' => 'fileManager',
                    'name' => 'root',
                    'action' => 'get'), array(
                    'name' => '.+?',
                    'action' => '(?:list|upload|edit|delete|get|editFolder|createFolder|deleteFolder|move|moveFolder)')),
                'fmFolderRoot' => new requestRoute('fileManager/:action', array(
                    'module' => 'fileManager',
                    'name' => 'root',
                    'action' => 'list'), array(
                    'name' => '.+?',
                    'action' => '(?:list|upload)'))));
    }

}
?>