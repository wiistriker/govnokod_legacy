<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/forms/formTextareaField.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formTextareaField.php 2820 2008-11-25 03:20:51Z mz $
 */

/**
 * formTextareaField: текстарея
 *
 * @package system
 * @subpackage forms
 * @version 0.1.1
 */
class formTextareaField extends formElement
{
    public function __construct()
    {
        $this->setAttribute('rows', 5);
        $this->setAttribute('cols', 20);
        $this->setAttribute('content', '');
        $this->addOptions(array('content', 'value'));
    }

    public function render($attributes = array(), $value = null)
    {
        $attributes['content'] = $this->escapeOnce($value);
        return $this->renderTag('textarea', $attributes);
    }
}

?>