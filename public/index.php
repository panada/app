<?php
// Sets the default timezone used by all date/time. Adjust to your location
date_default_timezone_set('Asia/Jakarta');

// Sets folder maps where the source code located
$dir = dirname(__DIR__);
$app = $dir.'/src/';
$vendor = $dir.'/vendor/';

// Include the autoloader class handler
require $vendor.'panada/resource/Loader.php';

// Instantiate autoloader class
new Panada\Resource\Loader([
    'Controller' => $app,
    'Panada' => $vendor.'panada/',
    'Model' => $app,
    'Library' => $app,
    'Module' => $app,
    'vendor' => $vendor
]);

// Exception handler
$exception = new Panada\Resource\Exception;
        
set_exception_handler([$exception, 'main']);
set_error_handler([$exception, 'errorHandler'], E_ALL);

// Instantiate Panada bootstrap class
$uri = Panada\Request\Uri::getInstance();
$response = Panada\Resource\Response::getInstance();

new Panada\Resource\Gear($uri, $response);

echo $response->output();
