<?php

namespace Controller;

use Panada\Resource\Controller;

class Home
{
    use Controller
    {
        Controller::__construct as private _construct;
    }

    public function __construct()
    {
        $this->_construct();
    }
    
    public function index()
    {
        return $this->output('index', ['name' => 'Panada']);
    }
    
    public function name($name = 'mandriva')
    {
        return $name;
    }
    
    public function test1()
    {
        return __METHOD__;
    }
    
    public function test2()
    {
        return __METHOD__;
    }
}
