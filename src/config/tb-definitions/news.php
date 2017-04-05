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
        'ident' => 'news',
        'form_ident' => 'news-form',
        'form_width' => '920px',
        'table_ident' => 'news-table',
        'action_url' => '/admin/handle/news',
        'not_found' => 'пусто',
        'is_sortable' => true,
        'model' => 'News',
    ),
    'position' => array(
        'tabs' => array(
            'Общая' => array(
                'id',
                'title',
                'many2many_tree',
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

        'many2many_tree' => array(
            'caption'   => 'Подарок',
            'type'      => 'many_to_many',
            'show_type' => 'select2',
            'mtm_table'                      => 'news2tb_tree',
            'mtm_key_field'                  => 'id_news',
            'mtm_external_foreign_key_field' => 'id',
            'mtm_external_key_field'         => 'id_tb_tree',
            'mtm_external_value_field'       => 'title',
            'mtm_external_table'             => 'tb_tree',
            'hide_list' => true,
            'additional_where' => array(
                'products.is_active' => array(
                    'sign'  => '=',
                    'value' => '1'
                ),
                'products.is_gift' => array(
                    'sign'  => '=',
                    'value' => '1'
                ),
                /*'products.id_city' => array(
                    'sign'  => '=',
                    'value' => function() {
                        return  Product::find(Input::get('id'))->id_city;
                    }
                ),*/
            ),
            'select2_search' => array(
                'placeholder'    => 'Поиск товаров',
                'minimum_length' => 3,
                'quiet_millis'   => 500,
                'per_page'       => 20,
            ),

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