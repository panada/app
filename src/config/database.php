<?php

return [
    'default' => [
        'dsn' => 'sqlite::memory:',
		'username' => null,
		'password' => null,
		'options' => [
            PDO::ATTR_PERSISTENT => true
        ]
    ],
    'mysql' => [
        'dsn' => 'mysql:host=127.0.0.1;dbname=panada;port=3306',
		'username' => 'root',
		'password' => '',
		'options' => [
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_PERSISTENT => true
		]
    ]
];
