<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/forms/validators/formRequiredRule.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formRequiredRule.php 3874 2009-10-22 01:38:22Z zerkms $
 */

/**
 * formRequiredRule: правило, определяющее, что значение поле обязательно должно быть заполнено
 *
 * @package system
 * @subpackage forms
 * @version 0.1.1
 */
class formRequiredRule extends formAbstractRule
{
    protected $message = 'Field is required';

    public function notExists()
    {
        $this->validation = false;
    }

    protected function _validate($value)
    {
        return $this->validation !== false && $value;
    }
}

?>