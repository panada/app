<?php

namespace Controller;

use Respect\Validation\Validator as v;

class Home extends \Panada\Resource\Controller
{
    public function index()
    {
        $this->response->setHeaders('Content-Type', 'text/html; charset=utf-8');
        
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
    
    public function testDB()
    {
        $database = \Panada\Medoo\Medoo::getInstance();
        
        //$name = time();
        //
        //$last_user_id = $database->insert("users", [
        //    "name" => $name,
        //    "email" => $name."@bar.com",
        //]);
        //
        //var_dump($last_user_id);exit;
        
        $users = $database->select("users", [
            "name",
            "email"
        ])->fetchAll(\PDO::FETCH_ASSOC);
        
        return print_r($users, true);
    }
    
    public function testnotorm()
    {
        $db = \Panada\Notorm\NotORM::getInstance();
        
        foreach ($db->users() as $user) { // get all applications
            echo $user['name'].'<br>';
        }
    }
    
    public function testRespect()
    {
        //new Panada\Resource\Kandar;
        //exit;
        $number = 123;
        var_dump(v::numeric()->validate($number));
    }
    
    public function testImagine()
    {
        $imagine = new \Imagine\Gd\Imagine();
    }
    
    public function testMailer()
    {
        $mail = new \PHPMailer;
    }
}
