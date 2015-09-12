<?php

namespace Controller\Hidden;

class HiddenPage extends \Panada\Resource\Controller
{
    public function index($name)
    {
        return 'Hi '.$name;
    }
}
