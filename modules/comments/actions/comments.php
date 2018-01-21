<?php
return array(
    'edit' => array(
        'controller' => 'edit',
        'icon' => 'sprite:mzz-icon/comment/edit',
        'title' => 'Редактировать',
        'role' => array('user')
    ),
    'rawedit' => array(
        'controller' => 'rawEdit',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/comment/edit',
        'title' => 'Редактировать',
        'main' => 'active.blank.tpl',
        'role' => array('moderator')
    ),
    'delete' => array(
        'controller' => 'delete',
        'title' => 'Удалить',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/comment/del',
        'confirm' => 'Вы хотите удалить этот комментарий?',
        'role' => array('root')
    )
);
?>