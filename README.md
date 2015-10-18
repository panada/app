# About Panada

Panada is a high performance PHP 5.5 base development framework, yet simple.
Not only in contexts about how to use it, but also how the core system run it.

At this time, Panada 2.0 is on its very heavy development phrases, so it will be a lot changes in the features.

## Requirements

Panada is only supported on PHP 5.5 and up.

## Installation
```
composer create-project panada/app --prefer-dist --stability=dev myweb
cd myweb/public
php -S localhost:8181
```

Then open your browser http://localhost:8181

## How Tos

### Controller

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

Now open your browser http://localhost:8181/hello or http://localhost:8181/me/jhon/doe

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

To display your view file, use $this->output() method in your controller's method:

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

To passed a value from controller to view, just add an array in the second argument of $this->output() method:

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

### Routing

Routing is a way to lets you define certain URLs that you map to different areas of your application.

There are 3 entities that must be defined in Router config file.

#### 1. Patterns

A pattern defines how dynamic parts of a URL must look like. in fact, the patterns are essential to define dynamic routes. for example, the post_id and published_date in a url will be detected by three different patterns.

#### 2. defaults

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

### Database

Version 2.0 adopting [Medoo](http://medoo.in/), an extremely simple database framework. But instead of embrace all the APIs, we make some changes to get more flexibility. See [here](https://github.com/panada/medoo) to get more datail.

Your db config located in src/config/database.php

```php
<?php

return [
    'default' => [
        'databaseType' => 'mysql',
        'databaseName' => 'panada',
        'server' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8'
    ],
];

```
Heres an example to insert then fatch some db data:

```php
public function testDB()
{
    $database = \Panada\Medoo\Medoo::getInstance();
    
    $name = time();
    
    $lastUserId = $database->insert("users", [
        "name" => $name,
        "email" => $name."@bar.com",
    ]);
    
    var_dump($$lastUserId);
    
    $user = $database->select("users", [
        "name",
        "email"
    ])->fetch(\PDO::FETCH_ASSOC);
    
    var_dump($user);
        
    $database->update('users',
        ['name' => $name],
        ['email' => 'joe@gmail.com']
    );
    
    $user = $database->select('users', 'name', [
        'email' => 'joe@gmail.com'
    ])->fetch(\PDO::FETCH_ASSOC);
    
    var_dump($user);
}
```

To see more example how to use the db apis, please check this one https://github.com/panada/medoo/blob/master/Tests/SelectTest.php

If you hanve more then one db connection, here's the example:

```php
<?php

return [
    'default' => [
        'databaseType' => 'mysql',
        'databaseName' => 'mydb1',
        'server' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8'
    ],
    'db2' => [
        'databaseType' => 'mysql',
        'databaseName' => 'mydb2',
        'server' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8'
    ],
    'db3' => [
        'databaseType' => 'mysql',
        'databaseName' => 'mydb3',
        'server' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8'
    ]
];
```

Call the db helper:

```php
public function testDB()
{
    $db1 = \Panada\Medoo\Medoo::getInstance();
    $db2 = \Panada\Medoo\Medoo::getInstance('db2');
    $db3 = \Panada\Medoo\Medoo::getInstance('db3');
}
```
### Session

coming soon.

### Cache

coming soon.

### Modules

coming soon.

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

All alias features are removed. To accommodate your alias like features, you can use Route.

#### Database

Since version 2.0 use [Medoo](https://github.com/panada/medoo) as the default db query builder, there are now way to use your current query in version 2.0. You must update all your db query.

## Full Documentation

We don't have complete documentation yet for Panada version 2.X. If you thinks you
can help us to write some, it would be nice. Just fork the documentation branch at https://github.com/panada/documentation/tree/with-pure.0.5.0

### Contribution

Panada 2.0 consist of sub package.