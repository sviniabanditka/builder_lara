<?php

return array(

    'model' => 'Tree',
    'cache' => array(
        'tags' => array('tree'),
    ),
    'templates' => array(
        'Контакты' => array(
            'action' => 'ContactsController@showPage',
            'node_definition' => 'contacts',
            'check' => function() {
                return true;
            },
        ),

        'Главная' => array(
            'action' => 'HomeController@showPage',
            'node_definition' => 'node',
            'check' => function() {
                return true;
            },
        ),
    ),

    'default' => array(
        'type' => 'node',
        'action' => 'HomeController@showPage',
        'node_definition' => 'node',
    ),



);
