<?php

require 'core' . DIRECTORY_SEPARATOR . 'AutoLoad.php';
use core\Router;

//автозагрузка
$autoLoad = new AutoLoad();
spl_autoload_register([$autoLoad, 'Load']);

//маршрутизатор
define('ROOT', dirname(__FILE__));

//require_once(ROOT.'\vendor\Router.php');
$router = new Router();
$router->Start();






