<?php

return array(
    'edit' => array(
        'controller' => 'save',
        'jip' => '1',
        'icon' => 'sprite:mzz-icon/page-text/edit',
        'role' => array('moderator'),
        'main' => 'active.blank.tpl',
        'route_name' => 'pageActions',
        'route.name' => '->getFullPath'
    )
);

?>