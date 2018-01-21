<?php
//userFolder actions config

return array(
    'openIDLogin' => array(
        'controller' => 'openIDLogin'
    ),
    'preferences' => array(
        'controller' => 'preferences',
        'title' => 'Настройки пользователя',
        'role' => 'user'
    ),
    'addOpenID' => array (
        'controller' => 'addOpenID',
        'title' => 'Прилепить OpenID',
        'role' => 'user'
    ),
    'list' => array(
        'controller' => 'list',
        'title' => 'Список пользователей',
        'role' => 'root'
    ),
    'confirm' => array(
        'controller' => 'confirm',
        'title' => 'Подтверждение регистрации'
    ),
    'recover' => array(
        'controller' => 'recover',
        'title' => 'Восстановление пароля'
    ),
    'usersList' => array(
        'controller' => 'usersList',
        'title' => 'Все',
        'admin' => true,
        'role' => array('moderator')
    ),
    'unconfirmedUsersList' => array(
        'controller' => 'usersList',
        'title' => 'Неактивированные',
        'admin' => true,
        'role' => array('moderator')
    )
);
?>