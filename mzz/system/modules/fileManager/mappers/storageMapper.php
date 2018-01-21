<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/fileManager/mappers/storageMapper.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: storageMapper.php 4039 2009-12-17 10:30:13Z striker $
 */

fileLoader::load('fileManager/models/storage');

/**
 * storageMapper: маппер
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.2
 */

class storageMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'storage';
    protected $table = 'fileManager_storage';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array('pk', 'once'),
        ),
        'path' => array(
            'accessor' => 'getPath',
            'mutator' => 'setPath',
        ),
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName',
        ),
        'web_path' => array(
            'accessor' => 'getWebPath',
            'mutator' => 'setWebPath',
        )
    );

    protected $obj_id_field = null;

    /**
     * Возвращает доменный объект по аргументам
     *
     * @return simple
     */
    public function convertArgsToObj($args)
    {
        throw new mzzDONotFoundException();
    }

    public function getStorage()
    {
        return $this->searchOneByField('id', 1);
    }
}

?>