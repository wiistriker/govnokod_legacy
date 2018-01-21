<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/forms/validators/formFileextRule.php $
 *
 * MZZ Content Management System (c) 2005-2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formFileextRule.php 4005 2009-11-25 00:31:42Z striker $
 */

/**
 * formFileextRule: валидатор размера загружаемых файлов
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formFileextRule extends formAbstractRule
{
    protected function _validate($value, $name = null)
    {
        if (!isset($_FILES[$name])) {
            return true;
        }

        if (!isset($this->params) || !is_array($this->params)) {
            throw new mzzRuntimeException('Argument with array of valid extensions expected');
        }

        $validExts = array_map('strtolower', $this->params);

        $ext = strtolower(substr(strrchr($_FILES[$name]['name'], '.'), 1));

        return empty($this->params) ? true : in_array($ext, $this->params);
    }
}

?>