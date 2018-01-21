<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/captcha/captchaModule.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: captchaModule.php 3794 2009-10-13 01:44:43Z zerkms $
 */

/**
 * appCaptchaModule
 *
 * @package modules
 * @subpackage captcha
 * @version 0.0.1
 */
class appCaptchaModule extends captchaModule 
{
    public function getRoutes()
    {
        return array(
            array(),
            array(
                'captcha' => new requestRoute('captcha/image', array(
                    'module' => 'captcha',
                    'action' => 'view'))));
    }
}
?>