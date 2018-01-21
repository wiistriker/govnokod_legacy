<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/forms/validators/formCallbackRule.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formCallbackRule.php 3864 2009-10-21 04:50:04Z zerkms $
 */

/**
 * formCallbackRule: правило проверки по callback-функции
 *
 * @package system
 * @subpackage forms
 * @version 0.1.1
 */
class formCallbackRule extends formAbstractRule
{
    protected function _validate($value)
    {
        $funcName = array_shift($this->params);
        if (!is_callable($funcName)) {
            throw new Exception('Указанная функция ' . (is_array($funcName) ? get_class($funcName[0]) . '::' . $funcName[1] : $funcName) . ' не является валидным callback\'ом');
        }
        return call_user_func_array($funcName, array_merge(array($value), $this->params));
    }
}

?>