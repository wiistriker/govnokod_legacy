<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/forms/validators/formLengthRule.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formLengthRule.php 3867 2009-10-21 05:08:04Z zerkms $
 */

/**
 * formLengthRule: правило, проверяющее длину строки
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formLengthRule extends formAbstractRule
{
    protected function _validate($value)
    {
        $length = mzz_strlen($value);

        if (is_integer($this->params)) {
            return $length == $this->params;
        }

        if (is_array($this->params) && array_key_exists(0, $this->params) && array_key_exists(1, $this->params)) {
            if (is_null($this->params[0])) {
                return $length <= $this->params[1];
            }

            if (is_null($this->params[1])) {
                return $length >= $this->params[0];
            }

            return $length >= $this->params[0] && $length <= $this->params[1];
        }

        throw new mzzRuntimeException('Отствуют необходимые аргументы');
    }
}

?>