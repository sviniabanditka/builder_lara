<?php

return array(
    'db' => array(
        'table' => 'articles',
        'order' => array(
            'priority' => 'asc',
        ),
        'pagination' => array(
            'per_page' => 20,
            'uri' => '/admin/articles',
        ),
    ),
    'options' => array(
        'caption' => 'Статьи',
        'ident' => 'articles',
        'form_ident' => 'articles-form',
        'form_width' => '920px',
        'table_ident' => 'articles-table',
        'action_url' => '/admin/handle/articles',
        'not_found' => 'пусто',
        'is_sortable' => true,
        'model' => 'Articles',
    ),
    'position' => array(
        'tabs' => array(
            'Общая'     => array(
                'id',
                'title',

                'picture',
                'created_at',
                'updated_at',
                'is_active',
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
            'is_sorting' => true
        ),
        'group_sider' => array(
            'caption' => 'файлы',
            'field' => 'text',
            'type' => 'group',
            'filds' => array(
                'title333' => array(
                    'caption' => 'Название группы',
                    'type' => 'text',
                    'hide' => true,
                    'hide_list' => true,
                ),
                'file222' => array(
                    'caption' => 'Файл',
                    'comment' => "каок",
                    'type' => 'file',
                    'field' => 'string',
                    'is_multiple' => true, //если нужно много файлов
                    'accept' => "image/*"
                )
            ),
            "hide_add" => true
        ),


        'file' => array(
            'caption' => 'Файл',
            'type' => 'file',
            'field' => 'string',
            //'is_multiple' => true,
        ),

        'type_template' => array(
            'caption' => 'Тип шаблона',
            'hide_list' => true,
            'field' => 'string',
            'type' => 'select',
            'options' => array(
                'type1' => 'Тип1',
                'type2'  => 'Тип2',
            ),
            'action' => true,
            "readonly_for_edit" => true,
        ),

        'title' => array(
            'caption' => 'Название',
            'type' => 'text',
            'filter' => 'text',
            'is_sorting' => true,
            'field' => 'string',
            "readonly_for_edit" => true,
        ),

        'description' => array(
            'caption' => 'Описание',
            'type'    => 'wysiwyg',
            'wysiwyg' => 'redactor',
            'editor-options' => array(
                'lang' => 'ru-RU',
            ),
            'inlineStyles' => array(
                "test1" => "font-size: 20px; color: red;",
                "text2" => "font-size:30px;"
            ),
            'hide_list' => true,
            'field' => 'text',
            'class_name' => "type1"
            /*'tabs' => array(

                array(
                    'caption' => 'ru',
                    'postfix' => '',
                    'placeholder' => 'Текст на русском'
                ),
                array(
                    'caption' => 'ua',
                    'postfix' => '_ua',
                    'placeholder' => 'Текст на украинском'
                ),
                array(
                    'caption' => 'en',
                    'postfix' => '_en',
                    'placeholder' => 'Текст на английском'
                ),
            )*/
        ),
        'short_description' => array(
            'caption' => 'Короткий текст',
            'type'    => 'textarea',
            'wysiwyg' => 'redactor',
            'editor-options' => array(
                'lang' => 'ru-RU',
            ),
            'hide_list' => true,
            'field' => 'text',
            'class_name' => "type2"
        ),
        'picture' => array(
            'caption' => 'Изображение',
            'type' => 'image',
            'storage_type' => 'image', // image|tag|gallery
            'img_height' => '50px',
            'is_upload' => true,
            'is_null' => true,
            'is_remote' => false,

            'field' => 'string',
            'class_name' => "type2"
        ),
        'additional_pictures' => array(
            'caption' => 'Дополнительные изображение',
            'type' => 'image',
            'storage_type' => 'image', // image|tag|gallery
            'img_height' => '150px',
            'is_upload' => true,
            'is_null' => true,
            'is_remote' => false,
            'hide_list' => true,
            'is_multiple' => true,
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
        /* 'id' => array(
             'sign'  => '=',
             'value' => '1'
         ),
        */
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
        'revisions' => array(
            'caption' => 'Версии',
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
        'delete' => array(
            'caption' => 'Удалить',
            'check' => function() {
                return true;
            }
        ),

    ),
);