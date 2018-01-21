<?php
/**
 * $URL: http://192.200.0.2/svn/calendars/www/bundle.php $
 *
 * MZZ Content Management System (c) 2005-2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: bundle.php 112 2009-12-04 10:14:30Z striker $
 */

/**
 * Код для сборки js и css файлов в один большой и расположение его на ФС для последующей отдачи средствами веб-сервера
 *
 * @package system
 * @subpackage template
 * @version 0.2
 */

require_once dirname(__FILE__) . '/../config.php';
require_once systemConfig::$pathToSystem . '/index.php';

class externalBundleApplication extends core
{
    protected function handle()
    {
        $request = new httpRequest();

        $hash = $request->getString('hash', SC_GET);
        $filesString = $request->getString('files', SC_GET);

        $mimes = array('js' => 'application/x-javascript', 'css' => 'text/css');
        $ext = substr(strrchr($filesString, '.'), 1);

        $strippedHash = str_ireplace('.' . $ext, '', $hash);

        if ($filesString !== null && $hash !== null && isset($mimes[$ext]) && $strippedHash === md5($filesString)) {
            $source = $this->generateSource(explode(',', $filesString));

            if ($ext == 'js') {
                fileLoader::load('libs/jsmin/jsmin-1.1.1');
                $source = JSMin::minify($source);
            }

            file_put_contents(systemConfig::$pathToWebRoot . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . $hash, $source);
            header('Location: ' . SITE_PATH . '/media/' . $hash . '?files=' . $filesString);
            exit;
        }
    }

    protected function composeResolvers()
    {
        require_once systemConfig::$pathToSystem . '/resolver/init.php';
        require_once systemConfig::$pathToSystem . '/resolver/templateMediaResolver.php';
        require_once systemConfig::$pathToSystem . '/resolver/moduleMediaResolver.php';
        require_once systemConfig::$pathToSystem . '/resolver/extensionBasedModuleMediaResolver.php';
        require_once systemConfig::$pathToSystem . '/core/fileLoader.php';

        $baseresolver = new compositeResolver();
        $baseresolver->addResolver(new fileResolver(systemConfig::$pathToApplication . '/*'));
        $baseresolver->addResolver(new fileResolver(systemConfig::$pathToWebRoot . '/*'));
        $baseresolver->addResolver(new fileResolver(systemConfig::$pathToSystem . '/*'));

        $resolver = new compositeResolver();
        $resolver->addResolver(new templateMediaResolver($baseresolver));
        $resolver->addResolver(new moduleMediaResolver($baseresolver));
        $resolver->addResolver(new extensionBasedModuleMediaResolver($baseresolver));
        $resolver->addResolver(new classFileResolver($baseresolver));

        if (function_exists('external_callback')) {
            external_callback($resolver, $baseresolver);
        }

        return new cachingResolver($resolver, 'resolver_media_cache');
    }

    protected function loadCommonFiles()
    {
        fileLoader::load('exceptions/init');
        errorDispatcher::setDispatcher(new errorDispatcher());

        fileLoader::load('service/arrayDataspace');

        fileLoader::load('request/init');
        fileLoader::load('toolkit/init');
    }

    private function generateSource(Array $files)
    {
        $fileNameReplacePatterns = array(
            '..' => '');
        $source = null;
        $filemtime = null;

        foreach ($files as $file) {
            $file = preg_replace('![^a-z\d_\-/.]!i', '', $file);

            $file = str_replace(array_keys($fileNameReplacePatterns), $fileNameReplacePatterns, $file);

            $filePath = null;

            try {
                $filePath = fileLoader::resolve($file);
            } catch (mzzIoException $e) {
                // если в обычных директориях не найден - ищем в simple
                try {
                    $filePath = fileLoader::resolve('simple/' . $file);
                } catch (mzzIoException $e) {
                    continue;
                }
            }

            if (is_readable($filePath)) {
                $currentFileTime = filemtime($filePath);
                if ($currentFileTime > $filemtime) {
                    $filemtime = $currentFileTime;
                }
                $source .= file_get_contents($filePath) . "\r\n\r\n";
            }
        }

        if (is_null($filemtime)) {
            header("HTTP/1.1 404 Not Found");
            header('Content-Type: text/html');
            exit();
        }

        return $source;
    }
}

$application = new externalBundleApplication();
$application->run();

?>