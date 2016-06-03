<?php

return array(
    'db' => array(
        'table' => 'revisions',
        'order' => array(
            'created_at' => 'desc',
        ),
        'pagination' => array(
            'per_page' => 20,
            'uri' => '/admin/revisions',
        ),
    ),
    'options' => array(
        'caption' => 'Контроль изменений',
        'ident' => 'revisions',
        'form_ident' => 'revisions-form',
        'form_width' => '920px',
        'table_ident' => 'revisions-table',
        'action_url' => '/admin/handle/revisions',
        'not_found' => 'пусто',
        'is_sortable' => false,
        'model' => 'Vis\Builder\Revision',
    ),
    'position' => array(
        'tabs' => array(
            'Общая'     => array(
                'id',
                'user_id',
                'revisionable_type',
                'revisionable_id',
                'key',
                'old_value',
                'new_value',
                'created_at',
            ),
        )
    ),
    'fields' => array(
        'id' => array(
            'caption' => '#',
            'type' => 'readonly',
            'class' => 'col-id',
            'width' => '1%',
            'hide' => true,
            'is_sorting' => true,
        ),
        'user_id' => array(
            'caption' => 'Имя',
            'type' => 'foreign',
            'is_sorting' => true,
            'foreign_table'       => 'users',
            'foreign_key_field'   => 'id',
            'foreign_value_field' => 'first_name',
            'result_show' => "<a href='/admin/tb/users/%user_id%' target='_blank'>%users_first_name%</a>",
        ),
        'revisionable_type' => array(
            'caption' => 'Модель',
            'type'    => 'text',
            'filter' => 'text',
            'is_sorting' => true,
        ),
        'revisionable_id' => array(
            'caption' => 'Id записи',
            'type'    => 'text',
            'filter' => 'text',
            'is_sorting' => true,
        ),
        'key' => array(
            'caption' => 'Поле',
            'type'    => 'text',
            'filter' => 'text',
            'is_sorting' => true,
        ),
        'old_value' => array(
            'caption' => 'Старое значение',
            'type'    => 'text',
            'filter' => 'text',
            'is_sorting' => true,
        ),
        'new_value' => array(
            'caption' => 'Новое значение',
            'type'    => 'text',
            'filter' => 'text',
            'is_sorting' => true,
        ),

        'created_at' => array(
            'caption' => 'Дата/Время',
            'type' => 'datetime',
            'is_sorting' => true,
            'months' => 2,
            'field' => 'timestamp',
        ),

    ),
    'filters' => array(
    ),
    'actions' => array(
    ),
);