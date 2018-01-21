<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/resolver/classFileResolver.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: classFileResolver.php 3750 2009-09-25 04:36:43Z zerkms $
 */

/**
 * classFileResolver: резолвит основные классы
 * Примеры:
 * (запрос -> результат)
 * core         -> core/core.php
 * module/bla   -> module/bla.php
 *
 * @package system
 * @subpackage resolver
 * @version 0.1.1
 */
class classFileResolver extends partialFileResolver
{
    protected function partialResolve($request)
    {
        if (strpos($request, '/') === false) {
            $request .= '/' . $request;
        }

        if (strpos($request, '.ini') !== false) {
            return $request;
        }

        return $request . '.php';
    }
}

?>