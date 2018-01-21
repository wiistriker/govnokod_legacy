<?php
//user actions config

return array (
    'view' =>
    array (
        'controller' => 'view',
        'title' => 'Кабинка пользователя',
    ),
    'activate' =>
    array (
        'controller' => 'activate',
        'title' => 'Активировать',
        'confirm' => 'Вы уверены, что хотите активировать этого пользователя?',
        'main' => 'active.blank.tpl',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/accept',
        'role' => 'moderator',
    ),
    'sendregmail' =>
    array (
        'controller' => 'sendregmail',
        'title' => 'Отправить письмо',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/mail/add',
        'role' => 'moderator',
    ),
);
?>