<?php
/**
 * quoterModule
 *
 * @package modules
 * @subpackage quoter
 * @version 0.1
 */
class quoterModule extends simpleModule
{
    protected $classes = array(
        'quote',
        'quoteCategory',
        'quoteFolder'
    );

    protected $roles = array(
        'admin',
        'moderator',
        'user'
    );
    
    protected $moduleTitle = 'Цитатник';
    
    public function getRoutes()
    {
        return array(
            array(
                'userCodes' => new requestRoute('user/:id/codes', array('module' => 'quoter', 'action' => 'userquotes')),
                'rssUser' => new requestRoute('user/:id/rss', array('module' => 'quoter', 'action' => 'userrss')),
            ),
            array(
                'rateForCode' => new requestRoute('ratings/code/:id/:vote', array('module' => 'ratings', 'action' => 'rate', 'module_name' => 'quoter', 'class_name' => 'quote'), array('id' => '\d+')),
                'categoryList' => new requestRoute(':name', array('module' => 'quoter', 'action' => 'list')),
                'search' => new requestRoute('search', array('module' => 'quoter', 'action' => 'search')),
                'best' => new requestRoute('best/:nomination/:name', array('module' => 'quoter', 'action' => 'best', 'nomination' => 'rating', 'name' => '')),
                'rss' => new requestRoute('rss', array('module' => 'quoter', 'action' => 'rss')),
                'rssFull' => new requestRoute(':name/rss', array('module' => 'quoter', 'action' => 'rss')),
                'livecomments' => new requestRoute('comments', array('module' => 'quoter', 'action' => 'livecomments')),
                
                'quoteAdd' => new requestRoute('add', array('module' => 'quoter', 'action' => 'add')),
                'quoteView' => new requestRoute(':id', array('module' => 'quoter', 'action' => 'view'), array('id' => '\d+')),
            )
        );
    }
}
?>