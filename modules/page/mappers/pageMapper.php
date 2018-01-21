<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/page/mappers/pageMapper.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: pageMapper.php 4039 2009-12-17 10:30:13Z striker $
 */

fileLoader::load('page/models/page');
fileLoader::load('modules/jip/plugins/jipPlugin');

/**
 * pageMapper: маппер для страниц
 *
 * @package modules
 * @subpackage page
 * @version 0.2.1
 */
class pageMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'page';
    protected $table = 'page_page';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk',
                'once')),
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName'),
        'content' => array(
            'accessor' => 'getContent',
            'mutator' => 'setContent',
            'options' => array()
        ),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle',
            'options' => array()),
        'compiled' => array(
            'accessor' => 'getCompiled',
            'mutator' => 'setCompiled'
        ),
        'folder_id' => array(
            'accessor' => 'getFolder',
            'mutator' => 'setFolder',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'page/pageFolder',
            'join_type' => 'inner'
        )
    );
    
    public function __construct()
    {
        parent::__construct();
        $this->plugins('jip');
    }

    /**
     * Выполняет поиск объекта по идентификатору
     *
     * @param integer $id идентификатор
     * @return object|null
     */
    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    /**
     * Выполняет поиск объектов по идентификатору папки
     *
     * @param integer $id идентификатор папки
     * @return array
     */
    public function searchByFolder($folder_id)
    {
        return $this->searchAllByField('folder_id', $folder_id);
    }

    /**
     * Выполняет поиск объекта по имени
     *
     * @param string $name имя
     * @return object|null
     */
    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    public function searchByNameInFolder($name, $folder_id)
    {
        $criteria = new criteria();
        $criteria->where('name', $name)->where('folder_id', $folder_id);
        return $this->searchOneByCriteria($criteria);
    }
}

?>