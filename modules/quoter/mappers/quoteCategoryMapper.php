<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/quoter/mappers/quoteCategoryMapper.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: quoteCategoryMapper.php 303 2010-01-08 07:43:46Z wiistriker $
 */

fileLoader::load('quoter/models/quoteCategory');
fileLoader::load('orm/plugins/identityMapPlugin');
fileLoader::load('modules/jip/plugins/jipPlugin');

/**
 * quoteCategoryMapper: маппер
 *
 * @package modules
 * @subpackage quoter
 * @version 0.3
 */
class quoteCategoryMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'quoteCategory';
    
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'quoter_quoteCategory';

    /**
     * Map
     *
     * @var array
     */
    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array('pk', 'once')
        ),
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName'
        ),
        'geshi_alias' => array(
            'accessor' => 'getGeshiAlias',
            'mutator' => 'setGeshiAlias'
        ),
        'js_alias' => array(
            'accessor' => 'getJsAlias',
            'mutator' => 'setJsAlias'
        ),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle'
        ),
        'quote_counts' => array(
            'accessor' => 'getQuoteCounts',
            'mutator' => 'setQuoteCounts'
        )
    );

    public function __construct()
    {
        parent::__construct();
        $this->plugins('jip');
        $this->plugins('identityMap');
    }

    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    public function searchAllWithQuotes()
    {
        $criteria = new criteria;
        $criteria->where('quote_counts', 0, criteria::GREATER)->orderByDesc('quote_counts');

        return $this->searchAllByCriteria($criteria);
    }

    public function postInsert(entity $object)
    {
        $this->cleanCategoriesListCache();
    }

    public function postUpdate(entity $object)
    {
        $this->cleanCategoriesListCache();
    }

    public function cleanCategoriesListCache()
    {
        $cache = cache::factory('memcache');
        $cache->delete('main_categoriesList');
    }
}

?>