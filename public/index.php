<?php
if (!defined('DC')) {
    define('DC', DIRECTORY_SEPARATOR);
}
require_once __DIR__.'/../vendor/autoload.php';

require_once  '..' .DC.'config'.DC.'config.php';

use app\Router;

$router= new Router();
    
$router->renderRoute();
$router->resolve();
