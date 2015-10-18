<?php

return [
    'pattern' => [
        'year' => '/^[0-9]{4}$/i',
        'month' => '/^[0-9]{2}$/i',
        'id' => '/^[1-9][0-9]+$/i',
        'name' => '/^[a-z][a-z0-9_]+$/i'
    ],
    'defaults' => [
        'method' => 'GET|POST',
        'protocol' => 'http',
        'subdomain' => '',
        'domain' => 'localhost',
        'port' => 8081,
    ],
    'route' => [
        'archive' => [
            'url'=>'/news/:year/:month',
            'controller'=>'news',
            'action'=>'archive'
        ],
        'article' => [
            'url'=>'/post',
            'controller'=>'posts',
            'action'=>'view'
        ],
        'test1' => [
            'url'=>'/test1',
            'controller'=>'Controller\Home',
            'action'=>'test1'
        ],
        'blog' => [
            'url'=>'/blog/:name',
            'controller'=>'Controller\Hidden\HiddenPage',
            'action'=>'index'
        ]
    ]
];
