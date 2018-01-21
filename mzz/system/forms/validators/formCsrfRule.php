<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/forms/validators/formCsrfRule.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formCsrfRule.php 3890 2009-10-28 04:25:40Z zerkms $
 */

/**
 * formCsrfRule: правило проверки уникального идентификатора формы для защиты от CSRF аттак
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formCsrfRule extends formAbstractRule
{
    protected $message = 'csrf verification error';

    protected function _validate($value)
    {
        $session = systemToolkit::getInstance()->getSession();
        return $session->get('CSRFToken') === $value;
    }
}

?>