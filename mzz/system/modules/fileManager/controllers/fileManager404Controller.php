<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/modules/fileManager/controllers/fileManager404Controller.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: fileManager404Controller.php 3302 2009-06-03 05:11:29Z zerkms $
 */

/**
 * fileManager404Controller: контроллер для метода 404 модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManager404Controller extends simpleController
{
    private $type;
    public function __construct($type = 'file')
    {
        $this->type = $type;
        parent::__construct();
    }

    public function getView()
    {
        $this->smarty->assign('type', $this->type);
        return $this->smarty->fetch('fileManager/notfound.tpl');
    }
}

?>