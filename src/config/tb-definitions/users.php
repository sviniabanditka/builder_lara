<?php

return array(
    'db' => array(
        'table' => 'users',
        'order' => array(
            'created_at' => 'DESC',
        ),
        'pagination' => array(
            'per_page' => 20,
            'uri' => '/admin/users',
        ),
    ),
    'options' => array(
        'caption' => 'Пользователи',
        'ident' => 'users-container',
        'form_ident' => 'users-form',
        'form_width' => '700px',
        'table_ident' => 'users-table',
        'action_url' => '/admin/handle/users',
        'handler'    => 'Vis\Builder\Helpers\UsersHandler',
        'not_found'  => 'NOT FOUND',
        'model' => 'User',
    ),
    'position' => array(
        'tabs' => array(
            'Общая'     => array(
                'id',
                'email',
                'password',
                'last_name',
                'first_name',
                'activated',
                'created_at',
                'last_login',
            ),
            'Фото' => array(
                'image',
            ),
            'Группа' => array(
                'many2many_groups',
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
        ),
        'email' => array(
            'caption' => 'Email',
            'type' => 'text',
            'filter' => 'text',
            'is_sorting' => true,
            'placeholder' => "Email",
            'validation' => array(
                'server' => array(
                    'rules' => 'required|email',
                    'messages' => array(
                        'required' => 'Обязательно к заполнению',
                        "unique" => "Пользователь с таким емейлом уже существует"
                    ),
                    'ignore_this_id' => 'users'
                ),
                'client' => array(
                    'rules' => array(
                        'required' => true,
                        'email' => true,
                    ),
                    'messages' => array(
                        'required' => 'Обязательно к заполнению',
                        'email' => 'Неправильный e-mail'
                    )
                )
            ),
        ),
        'password' => array(
            'caption' => 'Пароль',
            'type' => 'text',
            'hide_list' => true,
            'placeholder' => "Введите пароль",
            'is_password' => true,
            'validation' => array(
                'server' => array(
                    'rules' => 'required|min:6'
                ),
                'client' => array(
                    'rules' => array(
                        'required' => true,
                        'minlength' => 6
                    ),
                    'messages' => array(
                        'required' => 'Обязательно к заполнению',
                        'minlength' => 'Пароль долже быть минимум 6-ь символов'
                    )
                )
            ),
        ),
        'last_name' => array(
            'caption' => 'Фамилия',
            'type'    => 'text',
            'filter' => 'text',
            'placeholder' => "Фамилия",
            'is_sorting' => true,
            'validation' => array(
                'server' => array(
                    'rules' => 'required'
                ),
                'client' => array(
                    'rules' => array(
                        'required' => true
                    ),
                    'messages' => array(
                        'required' => 'Обязательно к заполнению'
                    )
                )
            ),
        ),
        'first_name' => array(
            'caption'   => 'Имя',
            'type'      => 'text',
            'filter'    => 'text',
            'is_sorting' => true,
            'placeholder' => "Имя",
            'validation' => array(
                'server' => array(
                    'rules' => 'required'
                ),
                'client' => array(
                    'rules' => array(
                        'required' => true
                    ),
                    'messages' => array(
                        'required' => 'Обязательно к заполнению'
                    )
                )
            ),
        ),

        'image' => array(
            'caption' => 'Фото',
            'type' => 'image',
            'storage_type' => 'image', // image|tag|gallery
            'img_height' => '50px',
            'is_upload' => true,
            'is_null' => true,
            'is_remote' => false,
            'hide_list' => true,
        ),
        'last_login' => array(
            'caption' => 'Дата последнего входа',
            'type' => 'readonly',
            'is_sorting' => true,
            'months' => 2
        ),
        'activated' => array(
            'caption' => 'Активен',
            'type' => 'checkbox',
            'options' => array(
                1 => 'Активные',
                0 => 'He aктивные',
            ),
            'is_sorting' => false,
        ),
        'created_at' => array(
            'caption' => 'Дата регистрации',
            'type' => 'readonly',
            'is_sorting' => true,
            'months' => 2
        ),
        'updated_at' => array(
            'caption' => 'Дата обновления',
            'type' => 'readonly',
            'hide' => true,
            'is_sorting' => true,
            'months' => 2,
            'hide_list' => true,
        ),

        'many2many_groups' => array(
            'caption'                        => 'Группы',
            'type'                           => 'many_to_many',
            'show_type'                      => 'select2',
            'hide_list'                      => true,
            'mtm_table'                      => 'role_users',
            'mtm_key_field'                  => 'user_id',
            'mtm_external_foreign_key_field' => 'id',
            'mtm_external_key_field'         => 'role_id',
            'mtm_external_value_field'       => 'name',
            'mtm_external_table'             => 'roles',
        ),
    ),
    'export' => array(
        'caption'  => 'Экспорт',
        'filename' => 'exp',
        'width'    => '300',
        'date_range_field' => 'created_at',
        'buttons' => array(
            'xls' => array(
                'caption' => 'в XLS',
            ),
            'csv' => array(
                'caption' => 'в CSV',
                'delimiter' => ';'
            ),
        ),
        'check' => function() {
            return true;
        }
    ),

    'actions' => array(
        'search' => array(
            'caption' => 'Поиск',
        ),
        'insert' => array(
            'caption' => 'Добавить',
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
        ),
    ),
);
