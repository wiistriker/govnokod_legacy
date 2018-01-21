<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/resolver/compositeResolver.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: compositeResolver.php 2182 2007-11-30 04:41:35Z zerkms $
 */

/**
 * compositeResolver: реализация паттерна composite для резолверов
 * содержит группу резолверов, которые по запросу начинает поочерёдно опрашивать
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */
class compositeResolver implements iResolver
{
    /**
     * массив для хранения резолверов
     *
     * @var array
     */
    private $resolvers = array();

    /**
     * метод для добавления резолверов
     *
     * @param object $resolver
     */
    public function addResolver(iResolver $resolver)
    {
        $this->resolvers[] = $resolver;
    }

    /**
     * подача запроса, запуск поочерёдно резолверов
     * продолжается до тех пор, пока один из резолверов не вернёт строку с результатом
     *
     * @param string $request запрос
     * @return string|null путь к файлу, если запрос обработан одним из резолверов, либо null
     */
    public function resolve($request)
    {
        foreach ($this->resolvers as $resolver) {
            if (null !== ($filename = $resolver->resolve($request))) {
                return $filename;
            }
        }
        return null;
    }
}

?>