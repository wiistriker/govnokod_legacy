<?php
return array(
    'view' => array(
        'controller' => 'view',
        'title' => 'Просмотр записи'
    ),
    'edit' => array(
        'controller' => 'save',
        'title' => 'Редактировать',
        'jip' => 1,
        'icon' => 'sprite:mzz-icon/page-text/edit',
        'role' => array('admin')
    ),
    'active' => array(
        'controller' => 'delete',
        'title' => 'Изменить активность',
        'jip' => 1,
        'icon' => 'sprite:mzz-icon/info',
        'confirm' => 'Вы уверены, что хотите изменить активность данного элемента?',
        'role' => array('moderator')
    ),
    'delete' => array(
        'controller' => 'delete',
        'title' => 'Удалить',
        'jip' => 1,
        'icon' => 'sprite:mzz-icon/page-text/del',
        'confirm' => 'Вы уверены, что хотите удалить данный элемент?',
        'role' => array('admin')
    )
);
?>