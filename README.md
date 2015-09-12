# About Panada

Panada is a high performance PHP 5.4 base development framework, yet simple.
Not only in contexts about how to use it, but also how the core system run it.

At this time, Panada 2.0 is on its very heavy in development phrases, so it will be a lot changes in the features.

## Requirements

Panada is only supported on PHP 5.4 and up.

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

```
<?php

namespace Controller;

class Hello
{
    public function index()
    {
        return 'Hello world!';
    }
}
```

In version 2.0 we changed the way a controller getting the controller's helper method. To use this helper you can use the Controller trait.

```
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

```
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

```
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

```
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

```
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

```
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

Routing is a way to lets you define certain URLs that you map to different areas of your application. Panada route config are located in src/config/routes.php here's the examples

```
<?php

use \Panada\Router\Routes;

// route route www.site.com/test1 to Controller\Home::test1()
Routes::get('/test1', ['controller' => 'Controller\Home', 'action' => 'test1']);

// route route www.site.com/test2 to Controller\Home::tes2()
Routes::get('/test2', ['controller' => 'Controller\Home', 'action' => 'test2']);

// rote a request to some sub controller
Routes::get('/blog/:name', ['controller' => 'Controller\Hidden\HiddenPage', 'action' => 'index']);

// rote a request to a module
Routes::get('/exampleModule', ['controller' => 'Module\ExampleModule\Controller\Home', 'action' => 'index']);
```

### Database

### Webserver

#### Nginx

### Upgrading from Version 1.1

There are lot lot differences between versions 1.1 and 2.0 since Panada was completely rewritten for 2.0. As a result, upgrading from version 1.1 is not as trivial as upgrading between minor versions.

#### Front Controller (index.php)

All the content of index.php file are totally changed. In version 2.0 we don't use any global contants any more. So if you use any of these constants: APP, INDEX_FILE or GEAR please updated it.

#### Folders Name

All folders name are changed:

* app to src
* app/Controllers to src/Controller
* app/views to src/view
* app/Modules to src/Module

Panada folder now moved to vendor/panada.

#### Views

In version 1.1 to display the output diveloper simply just echo the variable just like this:

```
public function index($id = 0)
{
    echo 'This is the news with ID' . $id;
}
```
Or, use $this->output() metod to display from view file:

```
public function index()
{        
    $this->output('helloworldViewFile');
}
```

But in version 2.0 all you have to is return the object, just like:

```
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

```
<?php
namespace Controller;
```

Controller's parent class changed from:

```
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

```
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
