# About Panada

Panada is a high performance PHP 5.5 base development framework, yet simple.
Not only in contexts about how to use it, but also how the core system run it.

At this time, Panada 2.0 is on its very heavy development phase, so it will be a lot changes in the features.

## Requirements

Panada is only supported on PHP 5.5 and up.

## Installation
```
composer create-project panada/app --prefer-dist --stability=dev myweb;
php -S localhost:8181 -t myweb/public;
```

Then open your browser http://localhost:8181

## Quick Start Guide

### Controller

Since version 1, Panada use [HMVC](https://en.wikipedia.org/wiki/Hierarchical_model%E2%80%93view%E2%80%93controller) design patern. As part of the HMVC architecture, controllers are responsible for processing requests and generating responses, both in main application controller's and module controller's. Now lets create one in main application.

Create a new file named Hello.php in src/Controller folder. Then write some class:

```php
<?php

namespace Controller;

class Hello
{
    public function index()
    {
        return 'Hello world!';
    }
    
    public function me($firstName = null, $lastName = null)
    {
        return 'My name is:'.$name.' '.$lastName;
    }
}
```
#### Accesing Controller

URL form for accessing a controller take the following format:

```
ControllerName/ActionName
```

Now open your browser http://localhost:8181/hello or http://localhost:8181/me/john/doe

In version 2.0 we changed the way a controller getting the controller's helper method. To use this helper you can use the Controller trait.

```php
<?php

namespace Controller;

class Hello
{
    use \Panada\Resource\Controller;
    
    public function index()
    {
        return 'Hello world!';
    }
}
```

Or if you use a constructor method in your controller you can use:

```php
<?php
namespace Controller;

use Panada;
use Panada\Resource\Controller;

class Cookies
{
    use Controller
    {
        Controller::__construct as private _construct;
    }
    
    public function __construct()
    {
        $this->_construct();
        
        $this->session = Panada\Session\Session::getInstance();
    }
    
    public function index()
    {
        $this->response->setHeaders('Content-Type', 'text/html');
     
        if( $this->session->getValue('isLogin') )
            return $this->response->redirect('cookies/protectedPage');
        
        return '<a href="'.$this->uri->location('cookies/set').'">Set session</a>';
    }
    
    public function api()
    {
        $this->response->setHeaders('Content-Type', 'application/json');
        
        return json_encode(['foo' => 'bar']);
    }
}
```
### View

You can manage separated html template files in views folder. Now lets create a view file within src/view folder then named it as helloWorld.php

```html
<html>
    <head>
        <title>Hellow world!</title>
    </head>
    <body>
        Hello world!
    </body>
</html>
```

To display your view file, use ```$this->output()``` method in your controller's method:

```php
<?php

namespace Controller;

class Hello
{
    use \Panada\Resource\Controller;
    
    public function index()
    {
        return $this->output('helloWorld');
    }
}
```

To passed a value from controller to view, just add an array in the second argument of ```$this->output()``` method:

```php
<?php

namespace Controller;

class Hello
{
    use \Panada\Resource\Controller;
    
    public function index()
    {
        return $this->output('helloWorld', ['name' => 'Panada']);
    }
}
```

Then use $name variable within your view file.

```html
<html>
    <head>
        <title><?=$name?></title>
    </head>
    <body>
        <?=$name?>
    </body>
</html>
```

### Models

Models are part of the MVC architecture. They are objects representing business data, rules and logic. Model is a class whose duties are directly related to the handling of data, be it from a database, or other storage systems.

#### Creating Model

To create a class of models, add new files and put in the folder **src/Model/**, for example **Users.php**.

Create class users in this file with a given namespace **"Model"**, for example:

```
<?php
namespace Model;

class Users
{    
    public function __construct()
    {
        
    }
}

```

#### Load Library inside Model

If you are going to load a library or another class in this model, there are two ways you can do. First, if the resource of the class or the library will be used by all the methods that exist in the model class, then the retrieval and initialization can be done in the __construct method. However, if the resource just want to be used on one specific method only, then the initialization and retrieval can be done in the method in question.

One of the most common thing to do in a class model is to load a database resource. Here is a simple example to load a database resource in a class of models:

```php
<?php
namespace Model;
use Panada\Database;

class Users
{
    public function __construct()
    {
        $this->db = Database\SQL::getInstance();
    }
}
```

Furthermore, the property **"$this->db"** can be used in all the methods that exist in that class. Here is an example to get 5 records from the database:

```php
<?php
namespace Model;
use Panada\Database;

class Users
{
    public function __construct()
    {
        $this->db = Database\SQL::getInstance();
    }
    
    public function users()
    {
        return $this->db->results("SELECT * FROM table_name ORDER BY id LIMIT 5");
    }
}
```

### Modules

Modules are sub-applications that consist of models, views, controllers, and other supporting components. Modules differ from applications in that modules cannot be deployed alone and must reside within an applications. Every module in Panada reside in ```Module``` folder.

Every class within a module should add the module name in his namespace. For example:

```php
<?php

namespace Module\Foo\Controller;

class Bar
{
    use \Panada\Resource\Controller;
    
    public function index()
    {
        return __METHOD__;
    }
    
    public function blog()
    {
        return __METHOD__;
    }
}
```

#### Accessing Modules

URL form for accessing a controller within a module take the following format:

```
ModuleName/ControllerName/ActionName
```

So if we have a module called Foo and this module have a controller called Bar with method called blog the URL would be:

http://www.mysite.com/foo/bar/blog

Or if you don't defined controller name and action name, it will goes to controller Home with index method.

### Routing

Routing is a way to lets you define certain URLs that you map to different areas of your application. Unlike main controller or module, routing give you flexibility to define your URL format.

#### Router

There are 3 entities that must be defined in Router config file.

##### 1. Patterns

A pattern defines how dynamic parts of a URL must look like. in fact, the patterns are essential to define dynamic routes. for example, the post_id and published_date in a url will be detected by three different patterns.

##### 2. defaults

A default value will be used for part of a URL when we don't want to mention every time we are defining a route or creating a link.

#### 3. Routes

A map from url to controllers.

Panada route config are located in src/config/routes.php here's the examples

```php
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
```

### Request Handler Priority Rule

There are times when we have a controller with the same name as the name of a module, or even match with one of routing rules. In this situation, by default Panada will check main controller first, then module, then route. If your prefer other rule priority you can change ini ```app/src/config/main.php``` file.

```php
'requestHandlerRule' => [
    'controllerHandler',
    'moduleHandler',
    'routingHandler'
]
```

### Database

Version 2.0 adopting [NotORM](https://github.com/panada/notorm), a library for simple working with data in the database.

Your db config located in ```src/config/database.php```

```php
<?php

return [
    'default' => [
        'dsn' => 'mysql:host=127.0.0.1;dbname=panada;port=3306',
		'username' => 'root',
		'password' => '',
		'options' => [
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_PERSISTENT => true
		]
    ]
];

```

Here's example how to use NotORM:

```php
<?php

namespace Controller;

class Testnotorm
{
    public function __construct()
    {
        $this->db = \Panada\Notorm\NotORM::getInstance();
        
        // pass config name in getInstance method if you have another config
        // $this->db = \Panada\Notorm\NotORM::getInstance('mysql');
    }
    
    public function index()
    {
        $r = null;
        foreach ($this->db->users() as $user) {
            $r .= $user['email'].'<br>';
        }
        
        return $r;
    }
    
    public function singleRow()
    {
        $r = print_r($this->db->users[1]['id'], true);
        $r .= '<br>';
        $r .= print_r($this->db->users('id = ?', 1)->fetch()['id'], true);
    }
    
    public function insert()
    {
        $name = time();
        
        $row = $this->db->users()->insert([
            "name" => $name,
            "email" => $name."@bar.com",
        ]);
        
        return print_r($row['id'], true);
    }
    
    public function update()
    {
        $name = time();
        
        $affected = $this->db->users('id = ?', 1)->fetch()->update(['name' => 'update']);
        
        return print_r($affected, true);
    }
    
    public function delete()
    {
        return var_export($this->db->users[1]->delete(), true);
    }
}

```

To see more example how to use NotORM apis, please check this repo https://github.com/panada/notorm

### Session

Here's an example how to use session:

```php
<?php
namespace Controller;

use Panada;
use Panada\Resource\Controller;

class Admin
{
    use Controller
    {
        Controller::__construct as private _construct;
    }
    
    public function __construct()
    {
        $this->_construct();
        
        $this->session = Panada\Session\Session::getInstance();
        
        // pass config name in getInstance method if you have another session config
        // $this->session = Panada\Session\Session::getInstance('config2');
    }
    
    public function index()
    {
        if( $this->session->getValue('isLogin') )
            return $this->response->redirect('admin/protectedPage');
        
        return '<a href="'.$this->uri->location('admin/set').'">Set session</a>';
    }
    
    public function protectedPage(){
        
        $echo = $this->session->getValue('name').'<br />';
        $echo .= '<a href="'.$this->uri->location('admin/remove').'">Remove session</a>';
        
        return $echo;
    }
    
    public function remove(){
        
        $this->session->destroy();
        
        return $this->response->redirect('admin');
    }
}
```

### Cache

Here's an example how to use cache:

```php
<?php
namespace Controller;

use Panada;
use Panada\Resource\Controller;

class Blog
{
    use Controller
    {
        Controller::__construct as private _construct;
    }
    
    public function __construct()
    {
        $this->_construct();
        
        $this->cache = Panada\Cache\Cache::getInstance();
        
        // pass config name in getInstance method if you have another cache config
        // $this->cache = Panada\Cache\Cache::getInstance();'config2');
    }
    
    public function index()
    {
        $key = 'foo';
        $val = 'bar';
        $val2 = 'bar2';
        
        $info;
        
        // insert new value by a key
        $status = $this->cache->setValue($key, $val);
        
        $info .= 'Insert status:<br>'.var_export($status, true);
        
        // get a value
        $status = $this->cache->getValue($key);
        
        $info .= 'Get status:<br>'.var_export($status, true);
        
        // update a value
        $status = $this->cache->updateValue($key, $val2);
        
        $info .= 'Update status:<br>'.var_export($status, true);
        
        // get updated value
        $status = $this->cache->getValue($key);
        
        $info .= 'Get updated value status:<br>'.var_export($status, true);
        
        // delete a value by it key
        $status = $this->cache->deleteValue($key);
        
        $info .= 'Delete status:<br>'.var_export($status, true);
        
        // get deleted value
        $status = $this->cache->getValue($key);
        
        $info .= 'Deleted value status:<br>'.var_export($status, true);
        
        return $info;
    }
}
```

To know more about the use if cache package, go to https://github.com/panada/cache

### Additional Libraries

Panada 2.0 fully embraces [Composer](https://getcomposer.org/). Installation of additional Panada package or external libraries are handled through Composer.

### Webserver

#### Nginx

[Nginx](http://wiki.nginx.org/Main) is a free, open-source, high-performance and extremely fast HTTP server. To get it works with your Panada project, you can use the following sample server config:

```
server {
    listen 80 default_server;
    listen [::]:80 default_server ipv6only=on;

    access_log /var/log/nginx/access.log;
    error_log /var/log/nginx/error.log;

    # this is the root of your project
    root /var/www/public;
    index index.php;

    location / {
            try_files $uri /index.php$request_uri;
    }

    location ~ \.php(/|$) {
        index index.php;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # deny access to .htaccess files, if Apache's document root
    # concurs with nginx's one
    #
    location ~ /\.ht {
        deny all;
    }
}
```

#### Apache

Create a .htaccess file in you public folder then fill with:

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [QSA,L]
```

### Upgrading from Version 1.1

There are lot lot differences between versions 1.1 and 2.0 since Panada was completely rewritten for 2.0. As a result, upgrading from version 1.1 is not as trivial as upgrading between minor versions.

#### Front Controller (index.php)

All the content of index.php file are totally changed. In version 2.0 we don't use any global constants any more. So if you use any of these constants: APP, INDEX_FILE or GEAR please updated it.

#### Folders Name

All folders name are changed:

* app to src
* app/Controllers to src/Controller
* app/views to src/view
* app/Modules to src/Module

Panada folder now moved to vendor/panada.

#### Views

In version 1.1 to display the output diveloper simply just echo the variable just like this:

```php
public function index($id = 0)
{
    echo 'This is the news with ID' . $id;
}
```
Or, use $this->output() metod to display from view file:

```php
public function index()
{        
    $this->output('helloworldViewFile');
}
```

But in version 2.0 all you have to do is return the object, just like:

```php
public function index($id = 0)
{
    return 'This is the news with ID' . $id;
}
public function page()
{        
    return $this->output('helloworldViewFile');
}
```

#### Controllers

Controller's namespace now become:

```php
<?php
namespace Controller;
```

Controller's parent class changed from:

```php
class Home extends \Libraries\Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        
    }
}
```

to

```php
class Home
{
    use Controller {
        Controller::__construct as private _construct;
    }
    
    public function __construct()
    {
        $this->_construct();
    }
    
    public function index()
    {
        
    }
}
```

We embraces the feature of [trait](http://php.net/manual/en/language.oop5.traits.php).

#### Alias

Controller features are removed and only method alias are supported. To accommodate your alias like features, you can use Route.

If you need to use other name for alias method, you can changed it at ```app/scr/config/main.php```.

#### Database

Since version 2.0, Panada use PDO as the default db driver. We also remove [Active Recored](http://panadaframework.com/documentation/id/classes/database/activerecord.html) feature and replaced with [NotORM](http://www.notorm.com/). consequently, there are now way to use your current query in version 2.0. You must update all your db query.

However, we still maintain [Query Builder](http://panadaframework.com/documentation/id/classes/database/query_builder.html). But you need to update your file db configuration located at ```app/src/config/database.php```.

Panada version 1 db config looks like:

```
<?php

return array(

    'default' => array(
        'driver' => 'mysqli',
        'host' => 'localhost',
        'port' => 3306,
        'user' => 'root',
        'password' => '',
        'database' => 'panada',
        'tablePrefix' => '',
        'charset' => 'utf8',
        'collate' => 'utf8_general_ci',
        'persistent' => false,
    );
);
```

In version 2 should be:

```
return [
    'default' => [
        'dsn' => 'mysql:host=127.0.0.1;dbname=mydb1;port=3306',
		'username' => 'root',
		'password' => '',
		'options' => [
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_PERSISTENT => true
		]
    ],
];
```

See more for Query Builder https://github.com/panada/database

## Full Documentation

We don't have complete documentation yet for Panada version 2.X. If you thinks you
can help us to write some, it would be nice. Just fork the documentation branch at https://github.com/panada/documentation/tree/with-pure.0.5.0

### Contribution

Panada 2.0 consist number of sub packages. To report any bug or make some contribution, please go to each package repo.

Package | First install | Repo
--- | --- | ---
resource | yes | https://github.com/panada/resource
loader | yes | https://github.com/panada/loader
request | yes | https://github.com/panada/request
utility | yes | https://github.com/panada/utility
router | yes | https://github.com/panada/router
NotORM | yes | https://github.com/panada/notorm
database | yes | https://github.com/panada/database
cache | no | https://github.com/panada/cache
session | no | https://github.com/panada/session
