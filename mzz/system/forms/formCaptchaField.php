<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/forms/formCaptchaField.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formCaptchaField.php 4047 2010-01-05 06:55:10Z striker $
 */

/**
 * formCaptchaField: captcha
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formCaptchaField extends formElement
{
    public function render($attributes = array(), $value = null)
    {
        $captcha_id = md5(microtime(true));

        $tplPrefix = isset($attributes['tplPrefix']) ? $attributes['tplPrefix'] : '';

        $smarty = systemToolkit::getInstance()->getSmarty();
        $smarty->assign('captcha_id', $captcha_id);
        $smarty->assign('attributes', $attributes);

        return $smarty->fetch('captcha/' . $tplPrefix . 'captcha.tpl');
    }
}

?>