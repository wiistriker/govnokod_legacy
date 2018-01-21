<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/admin/controllers/adminListActionsController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: adminListActionsController.php 3757 2009-09-25 06:11:53Z striker $
 */

/**
 * adminListActionsController
 *
 * @package modules
 * @subpackage admin
 * @version 0.2
 */
class adminListActionsController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $module_name = $this->request->getString('module_name');
        $class_name = $this->request->getString('class_name');
        try {
            $module = $this->toolkit->getModule($module_name);
        } catch (mzzModuleNotFoundException $e) {
            return $this->forward404($adminMapper);
        }

        $classes = $module->getClasses();
        if (!in_array($class_name, $classes)) {
            return $this->forward404($adminMapper);
        }

        $dests = $adminGeneratorMapper->getDests(true, $module->getName());

        if (!sizeof($dests)) {
            $controller = new messageController(i18n::getMessage('error.write_denied', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $actions = $module->getClassActions($class_name);
        $this->smarty->assign('module', $module);
        $this->smarty->assign('class_name', $class_name);
        $this->smarty->assign('actions', $actions);
        return $this->smarty->fetch('admin/listActions.tpl');
    }
}

?>