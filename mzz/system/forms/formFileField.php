<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/forms/formFileField.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formFileField.php 2806 2008-11-20 01:14:51Z mz $
 */

/**
 * formFileField: поле выбора файла
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 * @deprecated больше не нужен
 */
class formFileField extends formElement
{
    static public function toString($options = array())
    {
        $options['type'] = 'file';
        return self::createTag($options);
    }
}

?>