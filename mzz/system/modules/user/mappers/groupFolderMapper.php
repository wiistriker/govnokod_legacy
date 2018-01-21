<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/user/mappers/groupFolderMapper.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: groupFolderMapper.php 4039 2009-12-17 10:30:13Z striker $
 */

fileLoader::load('user/models/groupFolder');
fileLoader::load('modules/jip/plugins/jipPlugin');

/**
 * groupFolderMapper: mapper for fake object
 *
 * @package modules
 * @subpackage user
 * @version 0.2
 */
class groupFolderMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'groupFolder';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'user_groupFolder';

    /**
     * Map
     *
     * @var array
     */
    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk',
                'once')),
    );

    public function __construct()
    {
        parent::__construct();
        $this->plugins('jip');
    }

    public function getFolder()
    {
        return $this->create();
    }
}

?>