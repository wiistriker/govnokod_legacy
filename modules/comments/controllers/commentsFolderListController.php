<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/modules/comments/controllers/commentsFolderListController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: commentsFolderListController.php 309 2010-01-16 08:39:19Z wiistriker $
*/

/**
 * commentsFolderListController: контроллер для метода list модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1.1
 */
class commentsFolderListController extends simpleController
{
    protected function getView()
    {
        $commentsFolderMapper = $this->toolkit->getMapper('comments', 'commentsFolder');

        $object = $this->request->getRaw('object');
        if (!$object instanceof entity) {
            throw new mzzInvalidParameterException('Invalid object for comments');
        }

        $objectModule = $object->module();
        $objectType = get_class($object);

        $objectMapper = $this->toolkit->getMapper($objectModule, $objectType);

        if ($objectMapper->isAttached('comments')) {
            //Если у комментируемого маппера приаттачен плагин comments, то берем поле из плагина
            $byField = $objectMapper->plugin('comments')->getByField();
        } else {
            //иначе пробуем связаться по первичному ключу
            $byField = $objectMapper->pk();
        }

        $map = $objectMapper->map();
        if (!isset($map[$byField])) {
            throw new mzzInvalidParameterException('Invalid byField value for comments');
        }

        $objectId = $object->$map[$byField]['accessor']();

        if (!is_numeric($objectId)) {
            throw new mzzInvalidParameterException('Invalid objectId for comments');
        }

        $commentsFolder = $commentsFolderMapper->searchFolder($objectType, $objectId);

        if (!$commentsFolder) {
            $commentsFolder = $commentsFolderMapper->create();
            $commentsFolder->setModule($objectModule);
            $commentsFolder->setType($objectType);
            $commentsFolder->setByField($byField);
            $commentsFolder->setParentId($objectId);
            $commentsFolderMapper->save($commentsFolder);
        }

        $comments = $commentsFolder->getComments();

        $commentsLastSeen = null;
        $user = $this->toolkit->getUser();
        if ($user->isLoggedIn() && $objectMapper->isAttached('comments') && $objectMapper->plugin('comments')->isWithLastSeen()) {
            $commentsLastSeenMapper = $this->toolkit->getMapper('comments', 'commentsLastSeen');
            $commentsLastSeen = $commentsLastSeenMapper->searchByUserAndFolder($user, $commentsFolder);

            $lastTimeRead = ($commentsLastSeen) ? $commentsLastSeen->getTimeRead() : 1;
            $this->smarty->assign('lastTimeRead', $lastTimeRead);

            $commentsCount = $comments->count();
            if (!$commentsLastSeen || $commentsLastSeen->getSeenCommentsCount() != $commentsCount) {
                $commentsLastSeenMapper->saveSeen($user, $commentsFolder, $commentsCount);
            }
        }

        $this->smarty->assign('commentsFolder', $commentsFolder);
        $this->smarty->assign('comments', $comments);
        $this->smarty->assign('commentsLastSeen', $commentsLastSeen);
        return $this->fetch('comments/list.tpl');
    }
}

?>