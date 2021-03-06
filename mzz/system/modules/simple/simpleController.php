<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/simple/simpleController.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: simpleController.php 3790 2009-10-12 03:01:31Z striker $
 */

/**
 * simpleController: реализация общих методов у контроллеров
 *
 * @package modules
 * @subpackage simple
 * @version 0.2.10
 */

abstract class simpleController
{
    /**
     * Объект Toolkit
     *
     * @var stdToolkit
     */
    protected $toolkit;

    /**
     * Объект Request
     *
     * @var iRequest
     */
    protected $request;

    /**
     * Объект Request
     *
     * @var httpResponse
     */
    protected $response;

    /**
     * Объект шаблонного движка
     *
     * @var mzzSmarty
     */
    protected $smarty;

    /**
     * Action object
     *
     * @var simpleAction
     */
    protected $action;

    /**
     * Сообщение для подтверждения выполнения действия.
     * Если null, сообщение берется из конфигурации действий
     *
     * @var string
     */
    protected $confirm = null;

    /**
     * Свойство для хранения языка (берётся из SC_GET)
     *
     * @var integer
     */
    protected $lang_id = null;

    /**
     * A prefix for the templates
     *
     * @var string
     */
    protected $tpl_prefix = null;

    /**
     * Конструктор
     *
     */
    public function __construct(simpleAction $action = null)
    {
        $this->toolkit = systemToolkit::getInstance();
        $this->request = $this->toolkit->getRequest();
        $this->smarty = $this->toolkit->getSmarty();
        $this->response = $this->toolkit->getResponse();
        $this->action = $action;

        $this->lang_id = $this->request->getInteger('lang_id', SC_GET);

        $this->setTemplatePrefix($this->request->getString('tplPrefix'));
    }

    /**
     * Применение к мапперу текущего языка
     *
     * @param simpleMapper $mapper
     */
    final public function acceptLang(mapper $mapper)
    {
        $mapper->plugin('i18n')->setLangId($this->lang_id);
    }

    /**
     * Перенаправление пользователя на другую страницу
     *
     * @param string $url
     * @param integer $code 300...307
     */
    public function redirect($url, $code = 302)
    {
        $this->smarty->disableMain();
        $this->response->redirect($url, $code);
    }

    /**
     * Передача управления другому контроллеру
     *
     * @param string $moduleName имя модуля
     * @param string $actionName имя экшна
     * @return mixed результат работы контроллера
     */
    protected function forward($moduleName, $actionName)
    {
        $module = $this->toolkit->getModule($moduleName);
        $action = $module->getAction($actionName);
        return $action->run();
    }

    protected function forward404($mapper = null)
    {
        if ($mapper instanceof mapper) {
            $class = $mapper->getClass() . '404Controller';
            $module = $mapper->getModule();
        } else {
            $module = $class = '';
        }

        try {
            fileLoader::load($module . '/controllers/' . $class);
        } catch (mzzIoException $e) {
            $class = 'simple404Controller';
            if (!class_exists($class)) {
                fileLoader::load('simple/' . $class);
            }
        }

        $controller = new $class($this->getAction());
        return $controller->run();
    }

    public function forward403($mapper = null)
    {
        if ($mapper instanceof mapper) {
            $class = $mapper->getClass() . '403Controller';
            $module = $mapper->getModule();
        } else {
            $module = $class = '';
        }

        try {
            fileLoader::load($module . '/controllers/' . $class);
        } catch (mzzIoException $e) {
            $class = 'simple403Controller';
            if (!class_exists($class)) {
                fileLoader::load('simple/' . $class);
            }
        }

        $controller = new $class($this->getAction());
        return $controller->run();
    }

    /**
     * Возвращает результат отображения
     *
     */
    abstract protected function getView();

    /**
     * Запуск контроллера. Если в конфигурации действий указано свойство confirm, требует
     * подтверждения от пользователя выполнения данного сообщения. Текст сообщения может находиться
     * в значении свойства confirm или в свойстве объекта контроллера $confirm
     *
     * @return mixed
     */
    public function run()
    {
        $confirm = $this->getAction()->getConfirm();
        $confirmCode = $this->request->getString('_confirm', SC_GET);
        $session = $this->toolkit->getSession();

        if (!empty($confirm) && (empty($confirmCode) || $confirmCode != $session->get('confirm_code'))) {
            $view = $this->getConfirmView($confirm);
        }

        if (empty($view)) {
            $view = $this->getView();
        }

        if ($this->getAction()->isJip() && $this->request->isJip()) {
            $this->smarty->setActiveTemplate('main.xml.tpl');
            $this->response->setHeader('Content-Type', 'text/xml');
        }

        return $view;
    }

    /**
     * Метод установки пейджера для получаемой коллекции объектов
     *
     * @param mapper $item маппер, который возвращает требуемую коллекцию объектов
     * @param integer $per_page число объектов на странице
     * @param boolean $reverse флаг, изменяющий порядок страниц на противоположный (от больших к меньшим)
     * @param integer $round_items число выводимых номеров страниц рядом с текущим (Например: ... 4 5 6 _7_ 8 9 10 ... -> $roundItems = 3)
     * @return pager
     */
    public function setPager(mapper $mapper, $per_page = 20, $reverse = false, $round_items = 2)
    {
        fileLoader::load('modules/pager/plugins/pagerPlugin');
        $pager = new pager($this->request->getRequestUrl(), $this->request->getInteger('page', SC_REQUEST), $per_page, $round_items, $reverse);
        $mapper->attach(new pagerPlugin($pager));

        $this->smarty->assign('pager', $pager);

        return $pager;
    }

    /**
     * Sets a template path
     *
     * @param string $tpl_path the path to a template
     */
    public function setTemplatePrefix($prefix)
    {
        $this->tpl_prefix = $prefix;
    }

    /**
     * Adds a prefix to the templates
     *
     * @param string $path
     * @return string
     */
    public function addTemplatePrefix($path)
    {
        if (empty($this->tpl_prefix)) {
            return $path;
        }

        return substr_replace($path, '/' . $this->tpl_prefix, strpos($path, '/'), 1);
    }

    /**
     * Executes and returns the template results
     *
     * @param string $path the path to a template
     * @return string
     */
    public function fetch($path)
    {
        return $this->smarty->fetch($this->addTemplatePrefix($path));
    }

    /**
     * Возвращает HTML-форму для подтверждения выполнения действия
     *
     * @param string $confirm
     * @return string
     */
    protected function getConfirmView($confirm)
    {
        $session = $this->toolkit->getSession();
        $session->set('confirm_code', $code = md5(microtime()));

        $url = $this->request->getRequestUrl();
        $url = $url . (strpos($url, '?') ? '&' : '?') . '_confirm=' . $code;
        $this->smarty->assign('url', $url);

        $confirm = empty($this->confirm) ? $confirm : $this->confirm;

        if (i18n::isName($confirm)) {
            $confirm = i18n::getMessage($confirm);
        }

        $this->smarty->assign('message', $confirm);
        $this->smarty->assign('method', $this->request->getMethod());
        // если подтверждается POST-действие, помещаем данные в форму
        if ($this->request->isMethod('POST')) {
            $postData = $this->getPostData();
            $this->smarty->assign('postData', $postData);
        }
        return $this->smarty->fetch('simple/confirm.tpl');
    }

    public function getAction()
    {
        return $this->action;
    }

    /**
     * Возвращает массив переданных POST-переменных с правильными
     * именами для значений-массивов
     *
     * @return array
     */
    protected function getPostData()
    {
        // переменные могут содержать не только строковое значение, но и массив,
        // поэтому используем http_build_query для составления правильных имен переменных
        $values = http_build_query($this->request->exportPost());
        $values = explode('&', $values);
        $postData = array();
        foreach ($values as $key => $value) {
            $postData[$key] = array_map('urldecode', explode('=', $value));
        }

        return $postData;
    }
}

?>