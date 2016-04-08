<?php

return array(
    'db' => array(
        'table' => 'roles',
        'order' => array(
            'id' => 'ASC',
        ),
        'pagination' => array(
            'per_page' => 20,
            'uri' => '/admin/handle/groups',
        ),
    ),
    'options' => array(
        'caption' => "Группы пользователей",
        'ident' => 'groups-container',
        'form_ident' => 'groups-form',
        'table_ident' => 'groups-table',
        'action_url' => '/admin/handle/groups',
        'not_found'  => 'NOT FOUND',
        'model' => 'Group',
    ),

    'fields' => array(
        'id' => array(
            'caption' => '#',
            'type' => 'readonly',
            'class' => 'col-id',
            'width' => '1%',
            'hide' => true,
            'is_sorting' => false,
        ),
        'slug' => array(
            'caption' => "Имя",
            'type' => 'text',
            'filter' => 'text',
            'is_sorting' => true,
        ),
        'name' => array(
            'caption' => "Название",
            'type' => 'text',
            'filter' => 'text',
            'is_sorting' => false,
        ),
    ),

    'actions' => array(
        'search' => array(
            'caption' => "Поиск",
        ),
        'insert' => array(
            'caption' => "Добавить",
        ),
        'update' => array(
            'caption' => 'Редактировать',
            'check' => function() {
                return true;
            }
        ),
        'delete' => array(
            'caption' => "Удалить",
        ),
    ),
);