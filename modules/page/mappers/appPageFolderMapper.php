<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/page/mappers/appPageFolderMapper.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: appPageFolderMapper.php 308 2010-01-16 06:59:16Z wiistriker $
 */

/**
 * appPageFolderMapper: маппер
 *
 * @package modules
 * @subpackage page
 * @version 0.1.4
 */
class appPageFolderMapper extends pageFolderMapper 
{
    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk',
                'once',
            ),
        ),
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName',
        ),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle',
        ),
    );
}

?>