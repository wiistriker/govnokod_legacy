<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/exceptions/init.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage exceptions
 * @version $Id: init.php 3918 2009-11-02 05:58:39Z striker $
*/

fileLoader::load('exceptions/mzzException');
fileLoader::load('exceptions/phpErrorException');
fileLoader::load('exceptions/errorDispatcher');
fileLoader::load('exceptions/mzzRuntimeException');
fileLoader::load('exceptions/mzzSystemException');
fileLoader::load('exceptions/mzzIoException');
fileLoader::load('exceptions/mzzCallbackException');
fileLoader::load('exceptions/mzzInvalidParameterException');
fileLoader::load('exceptions/mzzDONotFoundException');
fileLoader::load('exceptions/mzzModuleNotFoundException');
fileLoader::load('exceptions/mzzUndefinedModuleClassException');
fileLoader::load('exceptions/mzzUnknownModuleActionException');
fileLoader::load('exceptions/mzzUnknownCacheBackendException');
fileLoader::load('exceptions/mzzUnknownCacheConfigException');
fileLoader::load('exceptions/mzzUnknownDBConfigException');
fileLoader::load('exceptions/mzzUnknownMailBackendException');
fileLoader::load('exceptions/mzzUnknownMailConfigException');
fileLoader::load('exceptions/mzzNoRouteException');
fileLoader::load('exceptions/mzzNoActionException');
fileLoader::load('exceptions/mzzLocaleNotFoundException');

?>