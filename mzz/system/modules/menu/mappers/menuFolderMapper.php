<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/menu/mappers/menuFolderMapper.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: menuFolderMapper.php 4039 2009-12-17 10:30:13Z striker $
 */

fileLoader::load('menu/models/menuFolder');
fileLoader::load('modules/jip/plugins/jipPlugin');

/**
 * menuFolderMapper: маппер
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuFolderMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'menuFolder';

    protected $table = 'menu_menuFolder';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk',
                'once',
            ),
        ),
    );

    public function __construct()
    {
        parent::__construct();
        $this->plugins('jip');
    }

    public function getFolder()
    {
        $folder = $this->create();
        //$folder->import(array('obj_id' => $this->getObjId()));
        return $folder;
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToObj($args)
    {
        return $this->getFolder();
    }
}

?>