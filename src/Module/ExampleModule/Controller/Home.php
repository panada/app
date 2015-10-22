<?php

namespace Module\ExampleModule\Controller;

class Home
{
    use \Panada\Resource\Controller;
    
    public function index()
    {
        return $this->output('index', ['name' => 'model']);
    }
}