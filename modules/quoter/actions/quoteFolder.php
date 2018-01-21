<?php
//quoteFolder actions config

return array (
    'listAll' => 
    array (
        'controller' => 'list',
        'title' => 'Листинг всех',
    ),
    'add' => 
    array (
        'controller' => 'save',
        'title' => 'Добавление записи',
        'role' => 'user'
    ),
    'search' => 
    array (
        'controller' => 'search',
        'title' => 'Поиск',
    ),
    'best' => 
    array (
        'controller' => 'best',
        'title' => 'Список лучших',
    ),
    'listCategories' => 
    array (
        'controller' => 'listCategories',
        'title' => 'Список категорий',
        'main' => 'deny',
    ),
    'rss' => 
    array (
        'controller' => 'rss',
        'title' => 'RSS',
        'main' => 'active.blank.tpl',
    ),
    'userrss' => 
    array (
        'controller' => 'rss',
        'title' => 'RSS лента пользователя',
        'main' => 'active.blank.tpl',
    ),
    'userquotes' => 
    array (
        'controller' => 'userQuotes',
        'title' => 'Записи пользователя',
    ),
    'admin' => 
    array (
        'controller' => 'admin',
        'admin' => true,
        'role' => 
        array (
            0 => 'moderator',
        ),
    ),
    'adminCategories' => 
    array (
        'controller' => 'adminCategories',
        'title' => 'Список категорий',
        'admin' => true,
        'role' => 
        array (
            0 => 'admin',
        ),
    ),
    'addCategory' => 
    array (
        'controller' => 'saveCategory',
        'title' => 'Добавить категорию',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/page/add',
        'route_name' => 'default2',
        'role' => 
        array (
            0 => 'admin',
        ),
    ),
    'livecomments' => 
    array (
        'controller' => 'livecomments',
        'title' => 'Последние комментарии'
    ),
);
?>