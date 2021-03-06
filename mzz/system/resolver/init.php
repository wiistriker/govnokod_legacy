<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/resolver/init.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage resolver
 * @version $Id: init.php 3750 2009-09-25 04:36:43Z zerkms $
*/

require_once systemConfig::$pathToSystem . '/resolver/iResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/partialFileResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/fileResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/compositeResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/classFileResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/moduleResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/commonFileResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/decoratingResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/cachingResolver.php';

?>