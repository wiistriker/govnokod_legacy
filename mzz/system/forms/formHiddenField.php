<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/forms/formHiddenField.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formHiddenField.php 2806 2008-11-20 01:14:51Z mz $
 */

/**
 * formHiddenField: hidden
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formHiddenField extends formElement
{
    public function __construct()
    {
        $this->setAttribute('type', 'hidden');
        $this->setAttribute('value', '');
    }

    public function render($attributes = array(), $value = null)
    {
        return $this->renderTag('input', $attributes);
    }
}

?>