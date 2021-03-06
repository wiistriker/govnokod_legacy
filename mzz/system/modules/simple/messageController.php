<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/simple/messageController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: messageController.php 3750 2009-09-25 04:36:43Z zerkms $
 */

/**
 * messageController: контроллер вывода стандартных сообщений
 *
 * @package modules
 * @subpackage simple
 */
class messageController extends simpleController
{
    const INFO = 1;
    const WARNING = 2;

    private $message;
    private $type;
    private $templates;

    public function __construct(simpleAction $action, $message, $type = messageController::WARNING)
    {
        parent::__construct($action);

        $this->message = $message;
        $this->type = $type;
        $this->templates = array(
            self::INFO => 'info',
            self::WARNING => 'warning');

        if (!isset($this->templates[$this->type])) {
            $this->type = self::INFO;
        }
    }

    public function run()
    {
        return $this->getView();
    }

    protected function getView()
    {
        $this->smarty->assign('message', $this->message);
        return $this->smarty->fetch('simple/' . $this->templates[$this->type] . '.tpl');
    }
}

?>