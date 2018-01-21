<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/ratings/models/ratingsFolder.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: ratingsFolder.php 303 2010-01-08 07:43:46Z wiistriker $
 */

/**
 * ratingsFolder: класс для работы c данными
 *
 * @package modules
 * @subpackage ratings
 * @version 0.1
 */
class ratingsFolder extends entity
{
    protected $object = null;
    protected $objectMapper = null;

    public function getObjectMapper()
    {
        if (is_null($this->objectMapper)) {
            $toolkit = systemToolkit::getInstance();
            $this->objectMapper = $toolkit->getMapper($this->getModule(), $this->getClass());
        }

        return $this->objectMapper;
    }

    public function getObject()
    {
        if (is_null($this->object)) {
            $objectMapper = $this->getObjectMapper();
            $ratingsPlugin = $objectMapper->plugin('ratings');

            $this->object = $objectMapper->searchByKey($this->getParentId());
        }

        return $this->object;
    }

    public function setObjectMapper(mapper $objectMapper)
    {
        if (!$objectMapper->isAttached('ratings')) {
            throw new mzzRuntimeException('Attach ratingsPlugin mapper to ' . get_class($objectMapper));
        }

        $this->objectMapper = $objectMapper;
    }

    public function setObject(entity $object)
    {
        $this->object = $object;
    }
}
?>