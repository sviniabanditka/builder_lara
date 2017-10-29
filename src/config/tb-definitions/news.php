<?php

return array(
    'db' => array(
        'table' => 'news',
        'order' => array(
            'priority' => 'asc',
        ),
        'pagination' => array(
            'per_page' => 20,
            'uri' => '/admin/news',
        ),
    ),
    'cache' => array(
        'tags' => array('news'),
    ),
    'options' => array(
        'caption' => 'Новости',
        'is_sortable' => true,
        'model' => 'News',
    ),
    'position' => array(
        'tabs' => array(
            'Общая' => array(
                'id',
                'title',
                'picture',
                'short_description',
                'description',
                'created_at',
                'updated_at',
                'is_active',
            ),

            'SEO' => array(
                'seo_title',
                'seo_description',
                'seo_keywords',
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
            'is_sorting' => false
        ),

        'picture' => array(
            'caption' => 'Изображение',
            'type' => 'image',
            'storage_type' => 'image', // image|tag|gallery
            'img_height' => '50px',
            'is_upload' => true,
            'is_null' => true,
            'is_remote' => false,
            'hide_list' => true,
            'field' => 'string',
        ),
        'title' => array(
            'caption' => 'Название',
            'type' => 'text',
            'filter' => 'text',
            'is_sorting' => true,
            'field' => 'string',
        ),

        'short_description' => array(
            'caption' => 'Краткое описание',
            'type'    => 'wysiwyg',
            'wysiwyg' => 'redactor',
            'hide_list' => true,
            'field' => 'text',
        ),
        'description' => array(
            'caption' => 'Полное описание',
            'type'    => 'wysiwyg',
            'hide_list' => true,
            'field' => 'text',
        ),

        'created_at' => array(
            'caption' => 'Дата создания',
            'type' => 'datetime',
            'is_sorting' => true,
            'months' => 2,
            'field' => 'timestamp',
        ),
        'updated_at' => array(
            'caption' => 'Дата обновления',
            'type' => 'readonly',
            'hide_list' => true,
            'is_sorting' => true,
            'hide'        => true,
            'field' => 'timestamp',
        ),
        'is_active' => array(
            'caption' => 'Статья активна',
            'type' => 'checkbox',
            'options' => array(
                1 => 'Активные',
                0 => 'He aктивные',
            ),
            'field' => 'tinyInteger',
        ),

        'seo_title' => array(
            'caption' => 'Seo: title',
            'type' => 'text',
            'filter' => 'text',
            'hide_list' => true,
            'field' => 'string',

        ),
        'seo_description' => array(
            'caption' => 'Seo: description',
            'type' => 'text',
            'filter' => 'text',
            'hide_list' => true,
            'field' => 'text',

        ),
        'seo_keywords' => array(
            'caption' => 'Seo: keywords',
            'type' => 'text',
            'filter' => 'text',
            'hide_list' => true,
            'field' => 'string',
        ),
    ),
    'filters' => array(
    ),
    'actions' => array(
        /* 'search' => array(
             'caption' => 'Поиск',
         ),*/
        'insert' => array(
            'caption' => 'Добавить',
            'check' => function() {
                return true;
            }
        ),
        'preview' => array(
            'caption' => 'Предпросмотр',
            'check' => function() {
                return true;
            }
        ),
        'clone' => array(
            'caption' => 'Клонировать',
            'check' => function() {
                return true;
            }
        ),
        'update' => array(
            'caption' => 'Редактировать',
            'check' => function() {
                return true;
            }
        ),
        'revisions' => array(
            'caption' => 'Версии',
            'check' => function() {
                return true;
            }
        ),
        'delete' => array(
            'caption' => 'Удалить',
            'check' => function() {
                return true;
            }
        ),
    ),
);
