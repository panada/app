<?php
// Sets the default timezone used by all date/time. Adjust to your location
date_default_timezone_set('Asia/Jakarta');

// Sets folder maps where the source code located
$dir = dirname(__DIR__);

// Application folder
$appDir = $dir.'/src/';

// Composer's vendor folder
$vendorDir = $dir.'/vendor/';

// Include the autoloader class handler
require $vendorDir.'panada/loader/Auto.php';

new Panada\Loader\Auto($vendorDir);

Panada\Resource\Gear::send(
    Panada\Http\Uri::getInstance(),
    $appDir
);