<?php
function smarty_modifier_highlite($source, $language = 'text', $cacheKey = null)
{
    if ($cacheKey) {
        fileLoader::load('cache');
        $cache = cache::factory('memcache');
        $result = $cache->get($cacheKey, $code);
        if ($result) {
            return $code;
        }
    }

    if (empty($language)) {
        $language = 'text';
    }

    fileLoader::load('libs/geshi/geshi');
    $geshi = new GeSHi($source, $language);

    //если такой язык подсветки не найден, то принуждаем использовать простой текст
    if ($geshi->error() !== false) {
        $geshi->set_language('text');
    } else {
        $css = systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'langs' . DIRECTORY_SEPARATOR . $language . '.css';
        if (!file_exists($css)) {
            @file_put_contents($css, $geshi->get_stylesheet(false));
        }
    }

    $geshi->set_comments_style(1, 'color: #666666;');
    $geshi->set_comments_style(2, 'color: #666666;');
    $geshi->set_comments_style(3, 'color: #0000cc;');
    $geshi->set_comments_style(4, 'color: #009933;');
    $geshi->set_comments_style('MULTI', 'color: #666666;');

    /*
    if ($highlight) {
        $geshi->highlight_lines_extra($highlight);
    }
    */

    //$geshi->set_header_type(GESHI_HEADER_NONE);
    //$geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
    $geshi->enable_classes();
    $code = $geshi->parse_code();

    if ($cacheKey) {
        $cache->set($cacheKey, $code, array(), 3600 * 24);
    }

    return $code;
}
?>