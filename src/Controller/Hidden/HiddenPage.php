<?php

namespace Controller\Hidden;

class HiddenPage
{
    use \Panada\Resource\Controller;
    
    public function index($name)
    {
        return 'Hi '.$name;
    }
}
