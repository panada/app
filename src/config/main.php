<?php

return [

    'defaultController' => 'Home',
    
    'defaultAction' => 'index',
    
    'aliasAction' => 'alias',
    
    'requestHandlerRule' => [
        'controllerHandler',
        'moduleHandler',
        'routingHandler'
    ]
];
