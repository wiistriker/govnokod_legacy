<?php
/**
 * $URL: https://govnokod.googlecode.com/svn/trunk/govnoquoter/app/modules/comments/controllers/commentsRawEditController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: commentsRawEditController.php 320 2010-01-20 13:04:18Z wiistriker $
*/

/**
 * commentsRawEditController: контроллер для метода edit модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1.2
 */
class commentsRawEditController extends simpleController
{
    protected function getView()
    {
        $commentsMapper = $this->toolkit->getMapper('comments', 'comments');
        $id = $this->request->getInteger('id');

        $comment = $commentsMapper->searchByKey($id);
        if (!$comment) {
            return $this->forward404($commentsMapper);
        }

        $validator = new formValidator();

        $validator->filter('trim', 'text');

        $validator->rule('required', 'text', 'Введите комментарий');
        //$validator->rule('required', 'rating', 'Укажите рейтинг');
        //$validator->rule('numeric', 'rating', 'Укажите рейтинг');

        if ($validator->validate()) {
            $text = $this->request->getString('text', SC_POST);

            $comment->setText($text);
            
            $rating = $this->request->getInteger('rating', SC_POST);
            if (!is_null($rating)) {
                $rate_value = $rating - $comment->getRating();
                
                if ($rate_value != 0) {
                    $ratingsFolderMapper = $this->toolkit->getMapper('ratings', 'ratingsFolder');
                    $ratingsFolder = $ratingsFolderMapper->searchByModuleClassAndParent('comments', 'comments', $comment->getId());
                    if ($ratingsFolder) {
                        $ratingsMapper = $this->toolkit->getMapper('ratings', 'ratings');
                        
                        $ip = $this->request->getServer('REMOTE_ADDR');
                        $ua = $this->request->getServer('HTTP_USER_AGENT') . ', user_id: ' . $this->toolkit->getUser()->getId();
                        
                        $rate = $ratingsMapper->create();
                        $rate->setUser(MZZ_USER_GUEST_ID);
                        $rate->setIpAddress($ip);
                        $rate->setUserAgent($ua);
                        $rate->setRateValue($rate_value);
                        $rate->setFolder($ratingsFolder);

                        $ratingsMapper->save($rate);
                    }
                    
                    $comment->setRating($rating);
                }
            }
            
            $commentsMapper->save($comment);

            return jipTools::redirect();
        }

        $url = new url('withId');
        $url->setAction('rawedit');
        $url->add('id', $comment->getId());

        $this->smarty->assign('comment', $comment);
        $this->smarty->assign('validator', $validator);
        $this->smarty->assign('form_action', $url->get());

        return $this->smarty->fetch('comments/rawedit.tpl');
    }
}
?>