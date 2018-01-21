<?php
return array(
    'list' => array(
        'controller' => 'list',
        'title' => 'Список записей'
    ),
    'editCategory' => array(
        'controller' => 'saveCategory',
        'title' => 'Редактировать',
        'jip' => 1,
        'icon' => 'sprite:mzz-icon/page-text/edit',
        'route_name' => 'withAnyParam',
        'route.name' => '->getName'
    )
);
?>