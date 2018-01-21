<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/trunk/system/db/simpleMssqlSelect.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: simpleMssqlSelect.php 2182 2007-11-30 04:41:35Z zerkms $
 */

/**
 * Класс для генерации простых SELECT SQL-запросов для MSSQL
 *
 * @package system
 * @subpackage db
 * @version 0.1
 */

class simpleMssqlSelect extends simpleSelect
{
    /**
     * Экранирование алиасов
     *
     * @param string $alias
     * @return string
     */
    public function quoteAlias($alias)
    {
        return '[' . $alias . ']';
    }

    /**
     * Экранирование имён полей
     *
     * @param string $field
     * @return string
     */
    public function quoteField($field)
    {
        return '[' . str_replace('.', '].[', $field) . ']';
    }

    /**
     * Экранирование имён таблиц
     *
     * @param string $table
     * @return string
     */
    public function quoteTable($table)
    {
        return '[' . $table . ']';
    }
}

?>