<?php

use \Panada\Router\Routes;

// This is only served as examples to show how Routes being used
// in an application

Routes::get('/test1', ['controller' => 'Controller\Home', 'action' => 'test1']);
Routes::get('/test2', ['controller' => 'Controller\Home', 'action' => 'test2']);
Routes::get('/blog/:name', ['controller' => 'Controller\Hidden\HiddenPage', 'action' => 'index']);
Routes::get('/exampleModule', ['controller' => 'Module\ExampleModule\Controller\Home', 'action' => 'index']);
