<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/fileManager/controllers/fileManagerMoveController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: fileManagerMoveController.php 3879 2009-10-22 03:37:30Z striker $
 */

/**
 * fileManagerMoveController: контроллер для метода move модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManagerMoveController extends simpleController
{
    protected function getView()
    {
        $name = $this->request->getString('name');
        $dest = $this->request->getInteger('dest', SC_POST);

        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $file = $fileMapper->searchByPath($name);

        if (!$file) {
            return $this->forward404($fileMapper);
        }

        $folders = $folderMapper->searchAll();

        $validator = new formValidator();
        $validator->rule('required', 'dest', 'Обязательное для заполнения поле');
        $validator->rule('callback', 'dest', 'В каталоге назначения уже есть файл с таким же именем', array(array($this, 'checkFilename'), $file));
        $validator->rule('in', 'dest', 'Каталог назначения не существует', $folders->keys());

        if ($validator->validate()) {
            $destFolder = $folderMapper->searchById($dest);

            $file->setFolder($destFolder);
            $fileMapper->save($file);
            return jipTools::redirect();
        }


        $url = new url('withAnyParam');
        $url->setAction('move');
        $url->add('name', $file->getFullPath());

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('validator', $validator);

        $dests = array();
        $styles = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getTitle();
            $styles[$val->getId()] = 'padding-left: ' . ($val->getTreeLevel() * 15) . 'px;';
        }

        $this->smarty->assign('dests', $dests);
        $this->smarty->assign('styles', $styles);

        $this->smarty->assign('file', $file);
        $this->smarty->assign('folders', $folders);
        return $this->smarty->fetch('fileManager/move.tpl');
    }

    public function checkFilename($dest, $file)
    {
        $folderMapper = systemToolkit::getInstance()->getMapper('fileManager', 'folder');
        $fileMapper = systemToolkit::getInstance()->getMapper('fileManager', 'file');

        $destFolder = $folderMapper->searchById($dest);

        if (!$destFolder) {
            return false;
        }

        $criteria = new criteria();
        $criteria->where('folder_id', $destFolder->getId())->where('name', $file->getName());

        return is_null($fileMapper->searchOneByCriteria($criteria));
    }
}

?>